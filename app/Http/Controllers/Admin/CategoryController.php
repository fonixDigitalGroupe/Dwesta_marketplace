<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Liste des catégories avec arborescence
     */
    public function index()
    {
        return redirect()->route('admin.categories.l1');
    }

    public function indexL1()
    {
        $categories = Category::racines()->parOrdre()->paginate(10);
        return view('admin.categories.index', compact('categories'))->with('level', 1);
    }

    public function indexL2()
    {
        $categories = Category::whereIn('parent_id', Category::racines()->pluck('id'))
            ->with('parent')
            ->parOrdre()
            ->paginate(10);
        return view('admin.categories.index', compact('categories'))->with('level', 2);
    }

    public function indexL3()
    {
        $parentIds = Category::whereIn('parent_id', Category::racines()->pluck('id'))->pluck('id');
        $categories = Category::whereIn('parent_id', $parentIds)
            ->with('parent.parent')
            ->parOrdre()
            ->paginate(10);
        return view('admin.categories.index', compact('categories'))->with('level', 3);
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        // Récupérer l'arborescence complète pour le menu de sélection du parent
        $categoriesTree = Category::getArborescence();

        return view('admin.categories.create', compact('categoriesTree'));
    }

    /**
     * Enregistre une nouvelle catégorie
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'icone' => ['nullable', 'string'],
            'ordre' => ['nullable', 'integer', 'min:0'],
            'actif' => ['nullable', 'boolean'],
            'famille' => ['nullable', 'string', 'in:' . implode(',', Category::getFamilles())],
        ]);

        // Validation conditionnelle : Famille requise si racine
        if (is_null($request->parent_id) && empty($request->famille)) {
            return back()->withErrors(['famille' => 'La famille est obligatoire pour une catégorie principale.'])->withInput();
        }

        $slug = Category::generateSlug($request->nom);

        $ordre = $request->ordre ?? 1;

        // Décalage automatique des ordres existants
        Category::shiftOrder($ordre, $request->parent_id);

        Category::create([
            'parent_id' => $request->parent_id,
            'nom' => $request->nom,
            'slug' => $slug,
            'description' => $request->description,
            'icone' => $request->icone,
            'ordre' => $ordre,
            'actif' => $request->boolean('actif'),
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
    public function show(Category $category)
    {
        $category->load(['parent', 'enfants']);

        return view('admin.categories.show', compact('category'));
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
            'nom' => ['required', 'string', 'max:255'],
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

        $category->update([
            'parent_id' => $request->parent_id,
            'nom' => $request->nom,
            'slug' => $slug,
            'description' => $request->description,
            'icone' => $request->icone,
            'ordre' => $ordre,
            'actif' => $request->boolean('actif'),
            'famille' => $request->parent_id ? null : $request->famille,
        ]);

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
        // 1. Récupérer tous les IDs concernés (la catégorie et tous ses descendants)
        $allCategoryIds = $this->getDescendantIds($category);
        $allCategoryIds[] = $category->id;

        // 2. Vérifier si des annonces sont liées à l'une de ces catégories
        $count = \App\Models\Annonce::whereIn('categorie_id', $allCategoryIds)->count();

        if ($count > 0) {
            return redirect()->back()->withErrors([
                'error' => "Impossible de supprimer cette catégorie car elle (ou ses sous-catégories) contient $count annonce(s). Veuillez d'abord supprimer ou déplacer ces annonces."
            ]);
        }

        // 3. Supprimer récursivement tous les enfants
        $this->deleteRecursively($category);

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
}
