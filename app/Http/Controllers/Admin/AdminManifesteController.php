<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manifeste;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminManifesteController extends Controller
{
    public function index(): View
    {
        $manifestes = Manifeste::orderByDesc('is_pinned')->orderBy('sort_order')->orderByDesc('id')->get();

        return view('admin.manifeste.index', compact('manifestes'));
    }

    public function create(): View
    {
        $manifeste = null;

        return view('admin.manifeste.create', compact('manifeste'));
    }

    public function store(Request $request): RedirectResponse
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

        Manifeste::create($data);

        return redirect()->route('admin.manifeste.index')->with('success', 'Manifeste créé.');
    }

    public function edit(Manifeste $manifeste): View
    {
        return view('admin.manifeste.edit', compact('manifeste'));
    }

    public function update(Request $request, Manifeste $manifeste): RedirectResponse
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

        $manifeste->update($data);

        return redirect()->route('admin.manifeste.index')->with('success', 'Manifeste mis à jour.');
    }

    public function destroy(Manifeste $manifeste): RedirectResponse
    {
        $manifeste->delete();

        return redirect()->route('admin.manifeste.index')->with('success', 'Manifeste supprimé.');
    }

    public function pin(Manifeste $manifeste): RedirectResponse
    {
        $manifeste->update(['is_pinned' => true]);

        return back()->with('success', 'Manifeste épinglé.');
    }

    public function unpin(Manifeste $manifeste): RedirectResponse
    {
        $manifeste->update(['is_pinned' => false]);

        return back()->with('success', 'Manifeste désépinglé.');
    }
}
