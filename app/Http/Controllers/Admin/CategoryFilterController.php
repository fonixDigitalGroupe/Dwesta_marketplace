<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryFilterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 8);

        $query = CategoryFilter::with('category.parent.parent');

        // Recherche par nom
        if (!empty($search)) {
            $query->where('nom', 'like', "%{$search}%");
        }

        // Filtrage par niveaux de catégories
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        } elseif ($request->filled('l2')) {
            $l2Id = $request->l2;
            $query->whereHas('category', function ($q) use ($l2Id) {
                $q->where('parent_id', $l2Id) // L3 is child of L2
                    ->orWhere('id', $l2Id);    // Cases where filter is directly on L2
            });
        } elseif ($request->filled('l1')) {
            $l1Id = $request->l1;
            $query->whereHas('category', function ($q) use ($l1Id) {
                $q->whereHas('parent', function ($pq) use ($l1Id) {
                    $pq->where('parent_id', $l1Id); // L3 -> L2 -> L1
                })->orWhereHas('parent', function ($pq) use ($l1Id) {
                    $pq->where('id', $l1Id);        // L2 -> L1
                })->orWhere('id', $l1Id);           // L1
            });
        }

        $filters = $query->latest()->paginate($perPage)->withQueryString();
        $parents = Category::whereNull('parent_id')->get();

        return view('admin.filters.index', compact('filters', 'parents', 'search', 'perPage'));
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();
        return view('admin.filters.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nom' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('category_filters')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id);
                })
            ],
            'options' => 'nullable|array',
            'is_filterable' => 'nullable|boolean',
        ], [
            'nom.unique' => 'Ce nom de critère est déjà utilisé pour cette catégorie.',
        ]);

        $validated['type'] = 'select';
        $validated['is_filterable'] = $request->has('is_filterable');
        $validated['is_required'] = false;
        $validated['ordre'] = 0;

        if ($request->has('options') && is_array($request->options)) {
            $validated['options'] = array_filter(array_map('trim', $request->options));
        } else {
            $validated['options'] = null;
        }

        $validated['slug'] = Str::slug($validated['nom']);

        // Ensure slug is unique per category
        $slug = $validated['slug'];
        $count = 1;
        while (CategoryFilter::where('category_id', $validated['category_id'])->where('slug', $slug)->exists()) {
            $slug = $validated['slug'] . '-' . $count++;
        }
        $validated['slug'] = $slug;

        CategoryFilter::create($validated);

        return redirect()->route('admin.filters.index')->with('success', 'Filtre créé avec succès.');
    }

    public function show(CategoryFilter $filter)
    {
        return view('admin.filters.show', compact('filter'));
    }

    public function edit(CategoryFilter $filter)
    {
        $parents = Category::whereNull('parent_id')->get();

        $item = $filter->category;
        $l3Id = $item->id;
        $l2Id = $item->parent_id;
        $l1Id = $item->parent ? $item->parent->parent_id : null;

        // If it's only 2 levels deep, adjust
        if (!$l1Id && $l2Id) {
            $l1Id = $l2Id;
            $l2Id = $l3Id;
            $l3Id = null;
        }

        return view('admin.filters.edit', compact('filter', 'parents', 'l1Id', 'l2Id', 'l3Id'));
    }

    public function update(Request $request, CategoryFilter $filter)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'nom' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('category_filters')->where(function ($query) use ($request) {
                    return $query->where('category_id', $request->category_id);
                })->ignore($filter->id)
            ],
            'options' => 'nullable|array',
            'is_filterable' => 'nullable|boolean',
        ], [
            'nom.unique' => 'Ce nom de critère est déjà utilisé pour cette catégorie.',
        ]);

        $validated['type'] = 'select';
        $validated['is_filterable'] = $request->has('is_filterable');
        $validated['is_required'] = false;
        $validated['ordre'] = $filter->ordre ?? 0;

        if ($request->has('options') && is_array($request->options)) {
            $validated['options'] = array_filter(array_map('trim', $request->options));
        } else {
            $validated['options'] = null;
        }

        if ($filter->nom !== $validated['nom'] || $filter->category_id != $validated['category_id']) {
            $validated['slug'] = Str::slug($validated['nom']);
            $slug = $validated['slug'];
            $count = 1;
            while (CategoryFilter::where('category_id', $validated['category_id'])->where('id', '!=', $filter->id)->where('slug', $slug)->exists()) {
                $slug = $validated['slug'] . '-' . $count++;
            }
            $validated['slug'] = $slug;
        }

        $filter->update($validated);

        return redirect()->route('admin.filters.index')->with('success', 'Filtre mis à jour avec succès.');
    }

    public function getChildren(Category $category)
    {
        return response()->json($category->enfants);
    }

    public function toggleStatus(CategoryFilter $filter)
    {
        $filter->update(['is_filterable' => !$filter->is_filterable]);
        $status = $filter->is_filterable ? 'activé' : 'suspendu';
        return redirect()->back()->with('success', "Filtre {$status} avec succès.");
    }

    public function destroy(CategoryFilter $filter)
    {
        $filter->delete();
        return redirect()->route('admin.filters.index')->with('success', 'Filtre supprimé avec succès.');
    }
}
