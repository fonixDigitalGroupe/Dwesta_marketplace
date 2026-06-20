<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Banner;
use App\Models\Category;
use Illuminate\Http\Request;

class BannerLandingController extends Controller
{
    /**
     * Affiche la page de destination dédiée d'une bannière
     */
    public function show(string $slug)
    {
        $banner = Banner::where('slug', $slug)
            ->where('active', true)
            ->firstOrFail();

        $categoryIds = collect();
        $category = null;
        
        // 1. Catégorie principale directe
        if ($banner->category_id) {
            $category = Category::find($banner->category_id);
            if ($category) {
                $categoryIds = $categoryIds->merge($category->getAllDescendantIds());
            }
        }

        // 2. Catégories via la relation pivot
        $pivotCategories = $banner->categories;
        foreach ($pivotCategories as $pivotCat) {
            $categoryIds = $categoryIds->merge($pivotCat->getAllDescendantIds());
            // Si pas de catégorie principale, on prend la première du pivot pour le fil d'ariane
            if (!$category) $category = $pivotCat;
        }

        $categoryIds = $categoryIds->unique()->toArray();

        $query = Annonce::publiees();
        
        if (!empty($categoryIds)) {
            $query->whereIn('categorie_id', $categoryIds);
        }

        $query->with(['photos', 'category.parent', 'vendeur.user', 'options', 'produit', 'vehicule']);

        // Tri par défaut : Pertinence (Boosted, Pro, Latest)
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

        // Sections bonus pour une page "Landing" riche
        $topConsultes = collect();
        if (!empty($categoryIds)) {
            $topConsultes = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->orderBy('vues', 'desc')
                ->limit(12)
                ->get();
        }

        // Sections par état (Rakuten Style)
        $produitsNeufs = collect();
        $produitsOccasion = collect();
        $prefCategories = collect();

        if (!empty($categoryIds)) {
            // On récupère les catégories enfants directes pour les sous-onglets "Vos catégories préférées"
            $allBannerCatIds = collect([$banner->category_id])->merge($banner->categories->pluck('id'))->unique()->filter();
            $prefCategories = Category::whereIn('parent_id', $allBannerCatIds)
                ->where('actif', true)
                ->get();

            // Si pas d'enfants, on prend les catégories elles-mêmes
            if ($prefCategories->isEmpty()) {
                $prefCategories = Category::whereIn('id', $allBannerCatIds)->get();
            }

            // Requête pour les NEUFS
            $produitsNeufs = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->where(function($query) {
                    $query->whereHas('produit', function($q) {
                        $q->whereIn('etat', ['Neuf', 'neuf']);
                    })->orWhereHas('vehicule', function($q) {
                        $q->whereIn('etat', ['Neuf', 'neuf']);
                    });
                })
                ->with(['photos', 'produit', 'vehicule'])
                ->latest()
                ->limit(20) // Plus de produits pour filtrer par catégorie en JS ou PHP
                ->get();

            // Requête pour les OCCASIONS
            $produitsOccasion = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->where(function($query) {
                    $query->whereHas('produit', function($q) {
                        $q->whereIn('etat', ['Occasion', 'occasion', 'Bon état', 'bon_etat'])->orWhereNull('etat');
                    })->orWhereHas('vehicule', function($q) {
                        $q->whereIn('etat', ['Occasion', 'occasion'])->orWhereNull('etat');
                    });
                })
                ->with(['photos', 'produit', 'vehicule'])
                ->latest()
                ->limit(20)
                ->get();
        }

        return view('banners.landing', compact(
            'banner', 
            'category', 
            'annonces',
            'topConsultes',
            'produitsNeufs',
            'produitsOccasion',
            'prefCategories'
        ));
    }
}
