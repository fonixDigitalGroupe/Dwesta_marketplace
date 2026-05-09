<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HighlightTab;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HighlightTabController extends Controller
{
    public function index(Request $request)
    {
        $query = HighlightTab::query()->orderBy('position');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $tabs = $query->paginate($request->get('per_page', 10));
        
        return view('admin.highlight_tabs.index', compact('tabs'));
    }

    public function create()
    {
        return view('admin.highlight_tabs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|integer',
            'active' => 'boolean',
        ]);

        HighlightTab::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'position' => $validated['position'] ?? 0,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.highlight-tabs.index')->with('success', 'Onglet créé avec succès.');
    }

    public function edit(HighlightTab $highlightTab)
    {
        return view('admin.highlight_tabs.edit', compact('highlightTab'));
    }

    public function update(Request $request, HighlightTab $highlightTab)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|integer',
            'active' => 'boolean',
        ]);

        $highlightTab->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'position' => $validated['position'] ?? 0,
            'active' => $request->has('active'),
        ]);

        return redirect()->route('admin.highlight-tabs.index')->with('success', 'Onglet mis à jour.');
    }

    public function destroy(HighlightTab $highlightTab)
    {
        if ($highlightTab->highlights()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un onglet contenant des actualités.');
        }

        $highlightTab->delete();
        return redirect()->route('admin.highlight-tabs.index')->with('success', 'Onglet supprimé.');
    }

    public function toggleStatus(HighlightTab $highlightTab)
    {
        $highlightTab->update(['active' => !$highlightTab->active]);
        return response()->json(['success' => true, 'active' => $highlightTab->active]);
    }
}
