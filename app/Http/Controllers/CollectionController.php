<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Affiche une collection basée sur une bannière
     */
    public function show(string $slug)
    {
        $banner = Banner::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        $categoryIds = [];
        $category = null;

        if ($banner->category_id) {
            $category = Category::where('id', $banner->category_id)
                ->where('actif', true)
                ->with(['parent', 'enfantsActifs.enfantsActifs'])
                ->first();
            
            if ($category) {
                $categoryIds = $category->getAllDescendantIds()->toArray();
            }
        }

        $query = Annonce::publiees();
        
        if (!empty($categoryIds)) {
            $query->whereIn('categorie_id', $categoryIds);
        }

        $query->with(['photos', 'category.parent', 'vendeur.user', 'options', 'produit', 'vehicule']);

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
                $query
                    ->leftJoin('vendeurs', 'vendeurs.id', '=', 'annonces.vendeur_id')
                    ->orderByRaw("CASE WHEN EXISTS (SELECT 1 FROM annonce_options WHERE annonce_id = annonces.id AND a_la_une = 1) THEN 0 ELSE 1 END")
                    ->orderByRaw("CASE WHEN vendeurs.type = 'professionnel' THEN 0 ELSE 1 END")
                    ->latest('annonces.publiee_le')
                    ->select('annonces.*');
                break;
        }

        $annonces = $query->paginate(24)->withQueryString();

        // Données supplémentaires pour le look "Page de catégorie"
        $dealsMarchands = collect();
        $selectionAnnonces = collect();
        $offresReductions = collect();
        $topConsultes = collect();

        if (!empty($categoryIds)) {
            $dealsMarchands = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->whereHas('vendeur', function ($q) {
                    $q->where('type', 'professionnel');
                })
                ->whereHas('options', function ($q) {
                    $q->where('a_la_une', 1);
                })
                ->latest('publiee_le')
                ->limit(20)
                ->get();

            $offresReductions = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->whereHas('produit', function ($q) {
                    $q->whereNotNull('prix_moyen_marche')
                      ->whereRaw('annonce_produits.prix_moyen_marche > annonces.prix');
                })
                ->latest('publiee_le')
                ->limit(15)
                ->get();
                
            $topConsultes = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->orderBy('vues', 'desc')
                ->limit(15)
                ->get();
        }

        return view('collections.show', compact(
            'banner', 
            'category', 
            'annonces', 
            'dealsMarchands', 
            'offresReductions', 
            'topConsultes'
        ));
    }
}
