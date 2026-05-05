<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Affiche les annonces d'une catégorie
     */
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('actif', true)
            ->with(['parent', 'enfantsActifs.enfantsActifs'])
            ->firstOrFail();

        // Si ce n'est pas une catégorie racine et qu'on n'est pas en mode liste,
        // on redirige vers la racine avec les paramètres de filtrage
        if ($category->parent_id !== null && request('view') !== 'list') {
            $ancetres = $category->ancetres; // Liste ordonnée de la racine jusqu'au parent
            $racine = $ancetres[0];
            
            $params = [];
            if (count($ancetres) === 1) {
                // On est au niveau N2
                $params['active'] = $category->id;
            } else {
                // On est au niveau N3
                $params['active'] = $ancetres[1]->id;
                $params['n3'] = $category->id;
            }
            
            return redirect()->route('categories.show', array_merge(['slug' => $racine->slug], $params));
        }

        // Charger les annonces de cette catégorie et de ses enfants
        $targetCategory = $category;
        if ($category->parent_id === null) {
            if (request()->filled('n3')) {
                $targetCategory = Category::find(request('n3')) ?? $category;
            } elseif (request()->filled('active')) {
                $targetCategory = Category::find(request('active')) ?? $category;
            }
        }
        
        $categoryIds = $targetCategory->getAllDescendantIds();
        
        $query = Annonce::publiees()
            ->whereIn('categorie_id', $categoryIds)
            ->with(['photos', 'category.parent', 'vendeur.user', 'options', 'produit', 'vehicule']);

        // Tri
        $sort = request('sort', 'relevance');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('prix', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('prix', 'desc');
                break;
            default:
                // Priorité : 1) Sponsorisé | 2) Vendeurs pro | 3) Date
                $query
                    ->leftJoin('vendeurs', 'vendeurs.id', '=', 'annonces.vendeur_id')
                    ->orderByRaw("CASE WHEN EXISTS (SELECT 1 FROM annonce_options WHERE annonce_id = annonces.id AND a_la_une = 1) THEN 0 ELSE 1 END")
                    ->orderByRaw("CASE WHEN vendeurs.type = 'professionnel' THEN 0 ELSE 1 END")
                    ->latest('annonces.publiee_le')
                    ->select('annonces.*');
                break;
        }

        $annonces = $query->paginate(24)->withQueryString();

        $dealsMarchands = collect();
        if ($category->parent_id === null) {
            $dealsMarchands = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->whereHas('vendeur', function ($q) {
                    $q->where('type', 'professionnel');
                })
                ->whereHas('options', function ($q) {
                    $q->where('a_la_une', 1);
                })
                ->whereHas('category', function ($q) {
                    $q->where('famille', Category::FAMILLE_ECOMMERCE);
                })
                ->with(['photos', 'category.parent', 'vendeur.professionnel', 'options'])
                ->latest('publiee_le')
                ->limit(60)
                ->get();
        }

        $selectionAnnonces = collect();
        $offresReductions = collect();
        $topConsultes = collect();
        
        if ($category->parent_id === null) {
            $selectionAnnonces = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->with(['photos', 'category.parent', 'vendeur.professionnel', 'options'])
                ->latest('publiee_le')
                ->limit(60)
                ->get();

            // Offres avec réduction (prix < prix_moyen_marche)
            $offresReductions = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->whereHas('produit', function ($q) {
                    $q->whereNotNull('prix_moyen_marche')
                      ->whereRaw('annonce_produits.prix_moyen_marche > annonces.prix');
                })
                ->with(['photos', 'category.parent', 'vendeur.professionnel', 'options', 'produit'])
                ->latest('publiee_le')
                ->limit(15)
                ->get();
                
            // Top des produits les plus consultés
            $topConsultes = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->with(['photos', 'category.parent', 'vendeur.professionnel', 'options', 'produit'])
                ->orderBy('vues', 'desc')
                ->limit(15)
                ->get();
        }

        // Fetch banners for this category or its family
        $banner = \App\Models\Banner::active()
            ->where(function ($q) use ($category) {
                $q->where('category_id', $category->id)
                  ->orWhere('famille', $category->famille);
            })
            ->orderByRaw("CASE WHEN category_id = {$category->id} THEN 0 ELSE 1 END")
            ->orderBy('order')
            ->first();

        return view('categories.show', compact('category', 'annonces', 'dealsMarchands', 'selectionAnnonces', 'offresReductions', 'banner', 'topConsultes'));
    }

    public function getFilters(Category $category)
    {
        return response()->json($category->filters()->orderBy('ordre')->get());
    }
}
