<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil avec les différentes sections d'annonces.
     */
    public function index()
    {
        // 0. Bannières publicitaires (Bannières classiques + Coupons avec image)
        $banners = Banner::active()->orderBy('order', 'asc')->get();

        $couponBanners = \App\Models\Coupon::where('is_active', true)
            ->whereNotNull('banner_image')
            ->get()
            ->map(function($coupon) {
                // Déterminer le lien : Nouvelle route dédiée pour les coupons
                $link = route('coupons.landing', $coupon->code);

                return (object) [
                    'id'          => 'coupon-' . $coupon->id,
                    'image_url'   => \Storage::url($coupon->banner_image),
                    'link_url'    => $link,
                    'slug'        => null,
                    'title'       => $coupon->code,
                    'is_coupon'   => true
                ];
            });

        $banners = $banners->concat($couponBanners);

        // 1. Sections Dynamiques (Nouveau système)
        $homeSections = \App\Models\HomeSection::active()->ordered()->get()->map(function ($section) {
            $section->products = $section->getProducts();
            return $section;
        });

        // 2. Top des produits les plus consultés (Mélange aléatoire des plus vus, max 20)
        $topConsultes = Annonce::publiees()
            ->orderBy('vues', 'desc')
            ->take(50) // Prend les 50 produits les plus consultés (toutes catégories)
            ->get()
            ->shuffle() // Mélange aléatoirement
            ->take(20); // Extrait 20 produits max

        // 3. Actualités (Highlights) Bento Grid
        $highlightTabs = \App\Models\HighlightTab::where('active', true)
            ->with(['highlights' => function($query) {
                $query->where('active', true)->orderBy('position');
            }])
            ->orderBy('position')
            ->get();

        // 4. Nos top produits du moment : Filtrés par état
        $topNeufs = Annonce::publiees()
            ->whereHas('produit', function($q) { $q->where('etat', 'neuf'); })
            ->latest()
            ->take(10)
            ->get();

        $topOccasions = Annonce::publiees()
            ->whereHas('produit', function($q) { $q->where('etat', 'occasion'); })
            ->latest()
            ->take(10)
            ->get();

        $topReconditionnes = Annonce::publiees()
            ->whereHas('produit', function($q) { $q->where('etat', 'reconditionne'); })
            ->latest()
            ->take(10)
            ->get();

        // 5. Le meilleur de nos catégories
        $famillesList = \App\Models\Category::getFamilles();
        $bestCategories = [];
        foreach ($famillesList as $familleName) {
            $familleParent = \App\Models\Category::whereNull('parent_id')
                ->where('nom', 'like', '%' . $familleName . '%')
                ->first();
            
            if ($familleParent) {
                $firstLevel2 = \App\Models\Category::where('parent_id', $familleParent->id)
                    ->actives()
                    ->parOrdre()
                    ->first();
                
                if ($firstLevel2) {
                    $allSubCats = $firstLevel2->enfantsActifs()->get();
                    $countTotal = $allSubCats->count();
                    $topNumber = max(1, floor($countTotal / 2));
                    
                    $bestCategories[] = [
                        'famille' => $familleName,
                        'title' => $familleName,
                        'root_parent' => $familleParent,
                        'parent' => $firstLevel2,
                        'items' => $allSubCats->take($topNumber),
                        'topNumber' => $topNumber,
                        'totalSub' => $countTotal
                    ];
                }
            }
        }

        // 6. Boutique Pro Sellers
        $proSellers = \App\Models\Vendeur::where('type', 'professionnel')
            ->where('statut_verification', 'verifie')
            ->has('professionnel')
            ->has('pagePro')
            ->with(['professionnel', 'pagePro', 'annonces' => function($q) {
                $q->publiees();
            }])
            ->inRandomOrder()
            ->take(6)
            ->get()
            ->map(function($seller) {
                $maxDiscount = $seller->annonces->map(function($a) {
                    return $a->discount_percentage;
                })->max();
                
                if ($maxDiscount > 0) {
                    $seller->promo_val = "JUSQU'À -{$maxDiscount}%";
                    $seller->promo_sub = "";
                } else {
                    $seller->promo_val = "DÉCOUVREZ";
                    $seller->promo_sub = "la boutique";
                }
                return $seller;
            });

        return view('home', compact(
            'banners',
            'homeSections',
            'topConsultes',
            'highlightTabs',
            'topNeufs',
            'topOccasions',
            'topReconditionnes',
            'bestCategories',
            'proSellers'
        ));
    }
}
