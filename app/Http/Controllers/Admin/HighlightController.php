<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Highlight;
use App\Models\HighlightTab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HighlightController extends Controller
{
    public function index()
    {
        $highlights = Highlight::with('highlightTab')
            ->join('highlight_tabs', 'highlights.highlight_tab_id', '=', 'highlight_tabs.id')
            ->orderBy('highlight_tabs.position')
            ->orderBy('highlights.position')
            ->select('highlights.*')
            ->get();
        
        $tabs = HighlightTab::orderBy('position')->pluck('name', 'id')->toArray();

        return view('admin.highlights.index', compact('highlights', 'tabs'));
    }

    public function create()
    {
        $tabs = HighlightTab::where('active', true)->orderBy('position')->get();

        $positions = [
            1 => 'Position 1 (Grand - Haut Gauche)',
            2 => 'Position 2 (Petit - Haut Droite)',
            3 => 'Position 3 (Petit - Milieu Droite)',
            4 => 'Position 4 (Large - Bas Droite)',
        ];

        return view('admin.highlights.create', compact('tabs', 'positions'));
    }

    public function store(Request $request)
    {
        // Check if a record already exists for this tab + position (upsert case)
        $existing = Highlight::where('highlight_tab_id', $request->highlight_tab_id)
            ->where('position', $request->position)
            ->first();

        $request->validate([
            'highlight_tab_id' => 'required|exists:highlight_tabs,id',
            'position'         => 'required|integer|min:1|max:4',
            'title'            => 'required|string|max:255',
            'subtitle'         => 'nullable|string|max:255',
            'image'            => ($existing ? 'nullable' : 'required') . '|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_url'         => 'nullable|url',
        ]);

        $data = $request->only(['highlight_tab_id', 'position', 'title', 'subtitle', 'link_url']);

        if ($request->hasFile('image')) {
            // Delete old image if replacing
            if ($existing && $existing->image_path && Storage::disk('public')->exists($existing->image_path)) {
                Storage::disk('public')->delete($existing->image_path);
            }
            $data['image_path'] = $request->file('image')->store('highlights', 'public');
        }

        if ($existing) {
            $existing->update($data);
        } else {
            Highlight::create($data);
        }

        return redirect()->route('admin.highlights.index')->with('success', 'Actualité enregistrée avec succès.');
    }

    public function edit(Highlight $highlight)
    {
        $tabs = HighlightTab::where('active', true)->orderBy('position')->get();

        $positions = [
            1 => 'Position 1 (Grand - Haut Gauche)',
            2 => 'Position 2 (Petit - Haut Droite)',
            3 => 'Position 3 (Petit - Milieu Droite)',
            4 => 'Position 4 (Large - Bas Droite)',
        ];

        return view('admin.highlights.edit', compact('highlight', 'tabs', 'positions'));
    }

    public function update(Request $request, Highlight $highlight)
    {
        $request->validate([
            'highlight_tab_id' => 'required|exists:highlight_tabs,id',
            'position' => 'required|integer|min:1|max:4',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_url' => 'nullable|url',
        ]);

        $data = $request->only(['highlight_tab_id', 'position', 'title', 'subtitle', 'link_url']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($highlight->image_path && Storage::disk('public')->exists($highlight->image_path)) {
                Storage::disk('public')->delete($highlight->image_path);
            }
            $data['image_path'] = $request->file('image')->store('highlights', 'public');
        }

        $highlight->update($data);

        return redirect()->route('admin.highlights.index')->with('success', 'Actualité mise à jour.');
    }

    public function destroy(Highlight $highlight)
    {
        if ($highlight->image_path && Storage::disk('public')->exists($highlight->image_path)) {
            Storage::disk('public')->delete($highlight->image_path);
        }
        $highlight->delete();

        return redirect()->route('admin.highlights.index')->with('success', 'Actualité supprimée.');
    }

    public function toggleStatus(Highlight $highlight)
    {
        $highlight->update(['active' => !$highlight->active]);
        return response()->json(['success' => true, 'active' => $highlight->active]);
    }
}
