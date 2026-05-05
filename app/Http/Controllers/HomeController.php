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
        // 0. Bannières publicitaires
        $banners = Banner::active()->orderBy('order', 'asc')->get();

        // 1. Sections Dynamiques (Nouveau système)
        $homeSections = \App\Models\HomeSection::active()->ordered()->get()->map(function ($section) {
            $section->products = $section->getProducts();
            return $section;
        });

        // 2. Top des produits les plus consultés (Conservé pour le moment car format particulier)
        $topConsultes = Annonce::publiees()
            ->orderBy('vues', 'desc')
            ->take(15)
            ->get();

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
                    $bestCategories[] = [
                        'famille' => $familleName,
                        'title' => $familleName,
                        'parent' => $firstLevel2,
                        'items' => $firstLevel2->enfantsActifs()->take(10)->get()
                    ];
                }
            }
        }

        return view('home', compact(
            'banners',
            'homeSections',
            'topConsultes',
            'highlightTabs',
            'topNeufs',
            'topOccasions',
            'topReconditionnes',
            'bestCategories'
        ));
    }
}
