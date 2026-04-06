<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manifeste;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiManifesteController extends Controller
{
    // ── Public ────────────────────────────────────────────────────────────────

    public function index(): JsonResponse
    {
        $manifestes = Manifeste::active()->ordered()->get()
            ->map(fn (Manifeste $m) => $this->summary($m));

        return response()->json(['data' => $manifestes]);
    }

    // ── Authenticated (admin) ─────────────────────────────────────────────────

    public function all(Request $request): JsonResponse
    {
        $query = Manifeste::ordered();

        if ($request->query('active') !== null) {
            if ((bool) $request->query('active')) {
                $query->active();
            }
        }

        $manifestes = $query->get()->map(fn (Manifeste $m) => $this->summary($m));

        return response()->json(['data' => $manifestes]);
    }

    public function show(Manifeste $manifeste): JsonResponse
    {
        return response()->json(['data' => $this->summary($manifeste)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'quote'      => 'required|string|max:500',
            'body'       => 'nullable|string|max:2000',
            'is_pinned'  => 'boolean',
            'sort_order' => 'integer|min:0|max:9999',
            'starts_at'  => 'nullable|date',
            'ends_at'    => 'nullable|date|after_or_equal:starts_at',
        ]);

        $data['is_pinned']  = $request->boolean('is_pinned');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        $manifeste = Manifeste::create($data);

        return response()->json([
            'data'    => $this->summary($manifeste),
            'message' => 'Manifeste créé.',
        ], 201);
    }

    public function update(Request $request, Manifeste $manifeste): JsonResponse
    {
        $data = $request->validate([
            'quote'      => 'sometimes|required|string|max:500',
            'body'       => 'nullable|string|max:2000',
            'is_pinned'  => 'boolean',
            'sort_order' => 'integer|min:0|max:9999',
            'starts_at'  => 'nullable|date',
            'ends_at'    => 'nullable|date|after_or_equal:starts_at',
        ]);

        if (array_key_exists('is_pinned', $data)) {
            $data['is_pinned'] = $request->boolean('is_pinned');
        }

        $manifeste->update($data);

        return response()->json([
            'data'    => $this->summary($manifeste->fresh()),
            'message' => 'Manifeste mis à jour.',
        ]);
    }

    public function destroy(Manifeste $manifeste): JsonResponse
    {
        $manifeste->delete();

        return response()->json(['message' => 'Manifeste supprimé.']);
    }

    public function pin(Manifeste $manifeste): JsonResponse
    {
        $manifeste->update(['is_pinned' => true]);

        return response()->json(['data' => $this->summary($manifeste->fresh()), 'message' => 'Manifeste épinglé.']);
    }

    public function unpin(Manifeste $manifeste): JsonResponse
    {
        $manifeste->update(['is_pinned' => false]);

        return response()->json(['data' => $this->summary($manifeste->fresh()), 'message' => 'Manifeste désépinglé.']);
    }

    // ── Helper ────────────────────────────────────────────────────────────────

    private function summary(Manifeste $m): array
    {
        return [
            'id'         => $m->id,
            'quote'      => $m->quote,
            'body'       => $m->body,
            'is_pinned'  => $m->is_pinned,
            'sort_order' => $m->sort_order,
            'starts_at'  => $m->starts_at?->toIso8601String(),
            'ends_at'    => $m->ends_at?->toIso8601String(),
            'created_at' => $m->created_at->toIso8601String(),
            'updated_at' => $m->updated_at->toIso8601String(),
        ];
    }
}

