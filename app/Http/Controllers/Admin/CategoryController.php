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
        // Charger toutes les catégories avec leurs enfants récursivement
        $categories = Category::racines()
            ->with(['enfants' => function ($query) {
                $query->orderBy('ordre')->with(['enfants' => function ($q) {
                    $q->orderBy('ordre');
                }]);
            }])
            ->orderBy('ordre')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create()
    {
        // Récupérer toutes les catégories actives (pas seulement les racines)
        // pour permettre de créer des sous-catégories à n'importe quel niveau
        $categories = Category::actives()->parOrdre()->get();
        
        return view('admin.categories.create', compact('categories'));
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
            'icone' => ['nullable', 'string', 'max:100'],
            'ordre' => ['nullable', 'integer', 'min:0'],
            'actif' => ['nullable', 'boolean'],
        ]);

        $slug = Category::generateSlug($request->nom);

        Category::create([
            'parent_id' => $request->parent_id,
            'nom' => $request->nom,
            'slug' => $slug,
            'description' => $request->description,
            'icone' => $request->icone,
            'ordre' => $request->ordre ?? 0,
            'actif' => $request->boolean('actif', true),
        ]);

        return redirect()->route('admin.categories.index')
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
        // Récupérer toutes les catégories actives (pas seulement les racines)
        // pour permettre de changer le parent à n'importe quel niveau
        // Exclure la catégorie elle-même et ses descendants pour éviter les boucles
        $excludedIds = $this->getDescendantIds($category);
        $excludedIds[] = $category->id;

        $categories = Category::actives()
            ->parOrdre()
            ->whereNotIn('id', $excludedIds)
            ->get();

        return view('admin.categories.edit', compact('category', 'categories'));
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
            'parent_id' => ['nullable', 'exists:categories,id', function ($attribute, $value, $fail) use ($category) {
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
            }],
            'description' => ['nullable', 'string', 'max:1000'],
            'icone' => ['nullable', 'string', 'max:100'],
            'ordre' => ['nullable', 'integer', 'min:0'],
            'actif' => ['nullable', 'boolean'],
        ]);

        $slug = $category->slug;
        if ($request->nom !== $category->nom) {
            $slug = Category::generateSlug($request->nom, $category->id);
        }

        $category->update([
            'parent_id' => $request->parent_id,
            'nom' => $request->nom,
            'slug' => $slug,
            'description' => $request->description,
            'icone' => $request->icone,
            'ordre' => $request->ordre ?? $category->ordre,
            'actif' => $request->boolean('actif', $category->actif),
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Supprime une catégorie (récursivement avec ses enfants)
     */
    public function destroy(Category $category)
    {
        // TODO: Vérifier si la catégorie est utilisée par des annonces (Phase 4)
        // Si oui, on pourrait soit empêcher la suppression, soit déplacer les annonces

        // Supprimer récursivement tous les enfants
        $this->deleteRecursively($category);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie et ses sous-catégories supprimées avec succès.');
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
