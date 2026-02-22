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
        $banners = Banner::where('active', true)
            ->orderBy('order', 'asc')
            ->get();

        // 1. Nos offres imbattables : Les produits les moins chers (top 4)
        $offresImbattables = Annonce::publiees()
            ->orderBy('prix', 'asc')
            ->take(8)
            ->get();

        // 2. Top des produits les plus consultés : Top 4 par vues
        $topConsultes = Annonce::publiees()
            ->orderBy('vues', 'desc')
            ->take(4)
            ->get();

        // 3. Nos top produits du moment : Annonces à la une (aléatoire ou top 4)
        $topProduits = Annonce::publiees()
            ->aLaUne()
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Si pas assez d'annonces à la une, on complète avec des annonces récentes
        if ($topProduits->count() < 4) {
            $extra = Annonce::publiees()
                ->whereNotIn('id', $topProduits->pluck('id'))
                ->latest()
                ->take(4 - $topProduits->count())
                ->get();
            $topProduits = $topProduits->concat($extra);
        }

        // 4. Dernières opportunités : Les plus récentes
        $dernieresOpportunites = Annonce::publiees()
            ->latest()
            ->take(4)
            ->get();

        // 5. Actualités (Highlights) Bento Grid
        $highlightTabs = \App\Models\HighlightTab::where('active', true)
            ->with(['highlights' => function($query) {
                $query->where('active', true)->orderBy('position');
            }])
            ->orderBy('position')
            ->get();

        return view('home', compact(
            'banners',
            'offresImbattables',
            'topConsultes',
            'topProduits',
            'dernieresOpportunites',
            'highlightTabs'
        ));
    }
}
