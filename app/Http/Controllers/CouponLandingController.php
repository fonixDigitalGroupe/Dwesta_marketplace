<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Campaign;
use Illuminate\Http\Request;

class CouponLandingController extends Controller
{
    /**
     * Affiche la page de destination dédiée d'un coupon
     */
    public function show(string $code)
    {
        $coupon = Coupon::where('code', $code)
            ->where('is_active', true)
            ->firstOrFail();

        // Récupérer la campagne active associée à ce coupon
        $campaign = Campaign::where('coupon_id', $coupon->id)
            ->where(function($q) {
                $q->whereNull('ends_at')
                  ->orWhere('ends_at', '>=', now());
            })
            ->latest()
            ->first();

        $categoryIds = collect();
        $category = null;
        
        // 1. Détermination de la catégorie cible du coupon
        $targetId = $coupon->category_id ?? $coupon->category_id_n2 ?? $coupon->category_id_n1;

        if ($targetId) {
            $category = Category::find($targetId);
            if ($category) {
                $categoryIds = $category->getAllDescendantIds();
            }
        }

        $categoryIds = $categoryIds->unique()->toArray();

        $query = Annonce::publiees();
        
        if (!empty($categoryIds)) {
            $query->whereIn('categorie_id', $categoryIds);
        }

        $query->with(['photos', 'category.parent', 'vendeur.user', 'options', 'produit', 'vehicule']);

        // Tri par défaut
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

        // Sections bonus (Rakuten Style)
        $topConsultes = collect();
        if (!empty($categoryIds)) {
            $topConsultes = Annonce::publiees()
                ->whereIn('categorie_id', $categoryIds)
                ->orderBy('vues', 'desc')
                ->limit(12)
                ->get();
        }

        $produitsNeufs = collect();
        $produitsOccasion = collect();
        $prefCategories = collect();

        if ($category) {
            // Catégories préférées (enfants directs ou catégorie elle-même)
            $prefCategories = Category::where('parent_id', $category->id)
                ->where('actif', true)
                ->get();

            if ($prefCategories->isEmpty()) {
                $prefCategories = collect([$category]);
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
                ->latest()
                ->limit(20)
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
                ->latest()
                ->limit(20)
                ->get();
        }

        return view('coupons.landing', compact(
            'coupon', 
            'campaign',
            'category', 
            'annonces',
            'topConsultes',
            'produitsNeufs',
            'produitsOccasion',
            'prefCategories'
        ));
    }
}
