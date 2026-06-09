<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Highlight;
use App\Models\HighlightTab;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HighlightController extends Controller
{
    public function index(Request $request)
    {
        $tabs = HighlightTab::orderBy('position')->pluck('name', 'id')->toArray();

        // Par défaut : rediriger vers le premier onglet
        if (!$request->filled('tab') && !empty($tabs)) {
            $firstTabId = array_key_first($tabs);
            return redirect()->route('admin.highlights.index', array_merge(
                $request->except('tab'),
                ['tab' => $firstTabId]
            ));
        }

        $query = Highlight::with(['highlightTab'])
            ->join('highlight_tabs', 'highlights.highlight_tab_id', '=', 'highlight_tabs.id');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('highlights.title', 'like', '%' . $request->search . '%')
                  ->orWhere('highlights.subtitle', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tab')) {
            $query->where('highlights.highlight_tab_id', $request->tab);
        }

        $highlights = $query->orderBy('highlights.position')
            ->select('highlights.*')
            ->paginate($request->get('per_page', 10))
            ->withQueryString();

        return view('admin.highlights.index', compact('highlights', 'tabs'));
    }

    public function create()
    {
        $tabs = HighlightTab::where('active', true)->orderBy('position')->get();
        
        // Optimized category loading
        $categories = $this->getOptimizedCategories();

        $positions = [
            1 => 'Position 1 (Grand - Haut Gauche)',
            2 => 'Position 2 (Petit - Haut Droite)',
            3 => 'Position 3 (Petit - Milieu Droite)',
            4 => 'Position 4 (Large - Bas Droite)',
        ];

        return view('admin.highlights.create', compact('tabs', 'positions', 'categories'));
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
            'link_url'         => 'nullable|string',
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
        
        // Optimized category loading
        $categories = $this->getOptimizedCategories();

        $positions = [
            1 => 'Position 1 (Grand - Haut Gauche)',
            2 => 'Position 2 (Petit - Haut Droite)',
            3 => 'Position 3 (Petit - Milieu Droite)',
            4 => 'Position 4 (Large - Bas Droite)',
        ];

        return view('admin.highlights.edit', compact('highlight', 'tabs', 'positions', 'categories'));
    }

    public function update(Request $request, Highlight $highlight)
    {
        $request->validate([
            'highlight_tab_id' => 'required|exists:highlight_tabs,id',
            'position' => 'required|integer|min:1|max:4',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link_url' => 'nullable|string',
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

    /**
     * Get all active categories with pre-calculated paths and redirection URLs.
     * This avoids N+1 query issues and intensive recursive calculations in the view.
     */
    private function getOptimizedCategories()
    {
        try {
            // 1. Fetch all active categories with minimal columns
            $allCategories = Category::where('actif', true)
                ->select('id', 'parent_id', 'nom', 'slug')
                ->get();

            // 2. Index by ID for fast lookup
            $indexedCategories = $allCategories->keyBy('id');

            // 3. Pre-calculate paths and URLs in memory
            $processed = $allCategories->map(function ($category) use ($indexedCategories) {
                // Build the path (chemin)
                $path = [$category->nom];
                $ancestors = [];
                $current = $category;
                $visited = [$category->id];
                
                while ($current->parent_id && isset($indexedCategories[$current->parent_id])) {
                    $parentId = $current->parent_id;
                    if (in_array($parentId, $visited)) break; // Prevent infinite loop
                    
                    $current = $indexedCategories[$parentId];
                    $visited[] = $parentId;
                    
                    array_unshift($path, $current->nom);
                    array_unshift($ancestors, $current);
                }
                $chemin = implode(' > ', $path);

                // Build the URL (logic from the original view)
                // We use a simple concatenation if possible to avoid route() overhead in a large loop
                $catUrl = "";
                if (count($ancestors) > 0) {
                    $racine = $ancestors[0];
                    $slug = $racine->slug ?? 'unknown';
                    
                    if (count($ancestors) === 1) {
                        $catUrl = "/categories/{$slug}?active=" . $category->id;
                    } else {
                        $activeId = $ancestors[1]->id;
                        $catUrl = "/categories/{$slug}?active={$activeId}&n3=" . $category->id;
                    }
                } else {
                    $slug = $category->slug ?? 'unknown';
                    $catUrl = "/categories/{$slug}";
                }

                return (object) [
                    'id' => $category->id,
                    'chemin' => $chemin,
                    'url' => $catUrl
                ];
            });

            // 4. Sort by the calculated path
            return $processed->sortBy('chemin');
        } catch (\Exception $e) {
            \Log::error("Error in getOptimizedCategories: " . $e->getMessage());
            return collect(); // Return empty collection on error to avoid blank page
        }
    }
}
