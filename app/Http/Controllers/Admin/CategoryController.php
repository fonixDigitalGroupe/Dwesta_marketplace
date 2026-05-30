<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Liste des catégories avec arborescence
     */
    public function index()
    {
        return redirect()->route('admin.categories.l1');
    }

    public function indexL1(Request $request)
    {
        $query = Category::racines()->parOrdre();
        $parents = Category::racines()->get();
        
        if ($request->filled('search')) {
            $query->where('nom', 'LIKE', '%' . $request->search . '%');
        }

        $categories = $query->paginate($request->get('per_page', 8))->appends($request->query());
        return view('admin.categories.index', compact('categories', 'parents'))->with('level', 1);
    }

    public function indexL2(Request $request)
    {
        $parents = Category::racines()->get();
        
        $query = Category::whereIn('parent_id', $parents->pluck('id'))
            ->with('parent')
            ->parOrdre();

        if ($request->filled('l1')) {
            $query->where('parent_id', $request->l1);
        }

        if ($request->filled('search')) {
            $query->where('nom', 'LIKE', '%' . $request->search . '%');
        }

        $categories = $query->paginate($request->get('per_page', 8))->appends($request->query());
        return view('admin.categories.index', compact('categories', 'parents'))->with('level', 2);
    }

    public function indexL3(Request $request)
    {
        $parents = Category::racines()->get();
        
        $parentIds = Category::whereIn('parent_id', $parents->pluck('id'))
            ->when($request->filled('l1'), function($q) use ($request) {
                return $q->where('parent_id', $request->l1);
            })
            ->pluck('id');

        $query = Category::whereIn('parent_id', $parentIds)
            ->with('parent.parent')
            ->parOrdre();

        if ($request->filled('l2')) {
            $query->where('parent_id', $request->l2);
        }

        if ($request->filled('search')) {
            $query->where('nom', 'LIKE', '%' . $request->search . '%');
        }

        $categories = $query->paginate($request->get('per_page', 8))->appends($request->query());
        return view('admin.categories.index', compact('categories', 'parents'))->with('level', 3);
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        // Récupérer l'arborescence complète pour le menu de sélection du parent
        $categoriesTree = Category::getArborescence();

        // Calculer le prochain ordre disponible pour chaque parent (y compris racine)
        $nextOrders = Category::select('parent_id')
            ->selectRaw('MAX(ordre) as max_ordre')
            ->groupBy('parent_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [($item->parent_id ?: 'root') => $item->max_ordre + 1];
            })
            ->toArray();

        // Valeur par défaut si aucune catégorie n'existe encore
        if (!isset($nextOrders['root'])) {
            $nextOrders['root'] = 1;
        }

        return view('admin.categories.create', compact('categoriesTree', 'nextOrders'));
    }

    /**
     * Enregistre une nouvelle catégorie
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->where(function ($query) use ($request) {
                    return $query->where('parent_id', $request->parent_id);
                }),
            ],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icone' => ['nullable', 'string'],
            'ordre' => ['nullable', 'integer', 'min:0'],
            'actif' => ['nullable', 'boolean'],
            'famille' => ['nullable', 'string', 'in:' . implode(',', Category::getFamilles())],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.unique' => 'Une catégorie avec ce nom existe déjà à ce niveau (même parent).',
            'parent_id.exists' => 'Le parent sélectionné est invalide.',
        ]);

        // Validation conditionnelle : Famille requise si racine
        if (is_null($request->parent_id) && empty($request->famille)) {
            return back()->withErrors(['famille' => 'La famille est obligatoire pour une catégorie principale.'])->withInput();
        }

        $slug = Category::generateSlug($request->nom);

        $ordre = $request->ordre ?? 1;

        // Décalage automatique des ordres existants
        Category::shiftOrder($ordre, $request->parent_id);

        $imageData = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $imageData = Storage::url($path);
        }

        Category::create([
            'parent_id' => $request->parent_id,
            'nom' => $request->nom,
            'slug' => $slug,
            'description' => $request->description,
            'icone' => $request->icone,
            'image' => $imageData,
            'ordre' => $ordre,
            'actif' => $request->has('actif') ? $request->boolean('actif') : true,
            'famille' => $request->parent_id ? null : $request->famille, // Seulement pour les racines
        ]);

        if ($request->parent_id) {
            return redirect()->route('admin.categories.show', $request->parent_id)
                ->with('success', 'Catégorie créée avec succès.');
        }

        return redirect()->route('admin.categories.l1')
            ->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Affiche les détails d'une catégorie
     */
    public function show(Request $request, Category $category)
    {
        $category->load('parent');

        $perPage = $request->input('per_page', 8);
        $search = $request->input('search');

        $enfants = $category->enfants()
            ->when($search, function ($query, $search) {
                return $query->where('nom', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderBy('ordre')
            ->paginate($perPage)
            ->appends(['per_page' => $perPage, 'search' => $search]);

        return view('admin.categories.show', compact('category', 'enfants'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Category $category)
    {
        // Récupérer l'arborescence pour le menu de sélection du parent
        $categoriesTree = Category::getArborescence();

        return view('admin.categories.edit', compact('category', 'categoriesTree'));
    }

    /**
     * Récupère récursivement tous les IDs des descendants d'une catégorie
     */
    private function getDescendantIds(Category $category): array
    {
        $ids = [];

        foreach ($category->enfants as $enfant) {
            $ids[] = $enfant->id;
            $ids = array_merge($ids, $this->getDescendantIds($enfant));
        }

        return $ids;
    }

    /**
     * Met à jour une catégorie
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id)->where(function ($query) use ($request) {
                    return $query->where('parent_id', $request->parent_id);
                }),
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($category) {
                    if ($value == $category->id) {
                        $fail('Une catégorie ne peut pas être son propre parent.');
                    }
                    // Vérifier qu'on ne crée pas de boucle
                    if ($value) {
                        $parent = Category::find($value);
                        $ancetres = $parent->ancetres;
                        foreach ($ancetres as $ancetre) {
                            if ($ancetre->id == $category->id) {
                                $fail('Cette catégorie créerait une boucle dans l\'arborescence.');
                            }
                        }
                    }
                }
            ],
            'description' => ['nullable', 'string', 'max:1000'],
            'icone' => ['nullable', 'string'],
            'ordre' => ['nullable', 'integer', 'min:0'],
            'actif' => ['nullable', 'boolean'],
            'famille' => ['nullable', 'string', 'in:' . implode(',', Category::getFamilles())],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.unique' => 'Une catégorie avec ce nom existe déjà à ce niveau (même parent).',
            'parent_id.exists' => 'Le parent sélectionné est invalide.',
        ]);

        // Validation conditionnelle : Famille requise si racine
        if (is_null($request->parent_id) && empty($request->famille)) {
            return back()->withErrors(['famille' => 'La famille est obligatoire pour une catégorie principale.'])->withInput();
        }

        $slug = $category->slug;
        if ($request->nom !== $category->nom) {
            $slug = Category::generateSlug($request->nom, $category->id);
        }

        $ordre = $request->ordre ?? $category->ordre;

        // Décalage automatique si l'ordre a changé
        if ($ordre != $category->ordre) {
            Category::shiftOrder($ordre, $request->parent_id, $category->id);
        }

        $data = [
            'parent_id' => $request->parent_id,
            'nom' => $request->nom,
            'slug' => $slug,
            'description' => $request->description,
            'icone' => $request->icone,
            'ordre' => $ordre,
            'actif' => $request->has('actif') ? $request->boolean('actif') : $category->actif,
            'famille' => $request->parent_id ? null : $request->famille,
        ];

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($category->image) {
                $oldPath = str_replace('/storage/', '', $category->image);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('categories', 'public');
            $data['image'] = Storage::url($path);
        } elseif ($request->boolean('remove_image')) {
            // Suppression explicite de l'image
            if ($category->image) {
                $oldPath = str_replace('/storage/', '', $category->image);
                Storage::disk('public')->delete($oldPath);
            }
            $data['image'] = null;
        }

        $category->update($data);

        if ($category->parent_id) {
            return redirect()->route('admin.categories.show', $category->parent_id)
                ->with('success', 'Catégorie mise à jour avec succès.');
        }

        return redirect()->route('admin.categories.l1')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Supprime une catégorie (récursivement avec ses enfants)
     */
    /**
     * Supprime une catégorie (récursivement avec ses enfants)
     */
    public function destroy(Category $category)
    {
        // 1. Vérifier si la catégorie a des sous-catégories (enfants)
        if ($category->enfants()->count() > 0) {
            return redirect()->back()->withErrors([
                'error' => "Impossible de supprimer cette catégorie car elle contient des sous-catégories. Veuillez d'abord supprimer les sous-catégories."
            ]);
        }

        // 2. Vérifier si des annonces sont liées à cette catégorie spécifique
        $count = $category->annonces()->count();

        if ($count > 0) {
            return redirect()->back()->withErrors([
                'error' => "Impossible de supprimer cette catégorie car elle contient $count annonce(s). Veuillez d'abord supprimer ou déplacer ces annonces."
            ]);
        }

        // 3. Supprimer la catégorie
        $category->delete();

        return redirect()->back()
            ->with('success', 'Catégorie supprimée avec succès.');
    }

    /**
     * Supprime récursivement une catégorie et tous ses enfants
     */
    private function deleteRecursively(Category $category): void
    {
        // Supprimer d'abord tous les enfants
        foreach ($category->enfants as $enfant) {
            $this->deleteRecursively($enfant);
        }

    // Puis supprimer la catégorie elle-même
        $category->delete();
    }

    /**
     * Active/Désactive une catégorie
     */
    public function toggleStatus(Category $category)
    {
        $category->update(['actif' => !$category->actif]);

        $status = $category->actif ? 'activée' : 'suspendue';
        return redirect()->back()->with('success', "La catégorie a été $status avec succès.");
    }
}
