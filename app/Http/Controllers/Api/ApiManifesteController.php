<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manifeste;
use Illuminate\Http\JsonResponse;

class ApiManifesteController extends Controller
{
    public function index(): JsonResponse
    {
        $manifestes = Manifeste::active()->ordered()->get()
            ->map(fn (Manifeste $m) => [
                'id'         => $m->id,
                'quote'      => $m->quote,
                'body'       => $m->body,
                'is_pinned'  => $m->is_pinned,
                'sort_order' => $m->sort_order,
                'starts_at'  => $m->starts_at?->toIso8601String(),
                'ends_at'    => $m->ends_at?->toIso8601String(),
            ]);

        return response()->json(['data' => $manifestes]);
    }
}
