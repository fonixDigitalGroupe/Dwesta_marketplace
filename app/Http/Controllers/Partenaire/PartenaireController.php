<?php

namespace App\Http\Controllers\Partenaire;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PartenaireController extends Controller
{
    /**
     * Écran d'accueil (Splash) de la PWA partenaire.
     *
     * Détermine la destination suivante selon l'état de l'utilisateur :
     *  - invité                         -> connexion
     *  - connecté sans profil logistique -> choix du métier
     *  - livreur / transporteur          -> tableau de bord (accueil chauffeur)
     */
    public function entry()
    {
        $user = Auth::user();

        if (! $user) {
            $next = route('partenaire.login');
        } elseif ($user->estLivreur() || $user->estTransporteur()) {
            $next = route('partenaire.home');
        } else {
            $next = route('partenaire.login');
        }

        return view('partenaire.splash', [
            'next' => $next,
        ]);
    }

    /**
     * Tableau de bord chauffeur (placeholder — construit en Phase 3).
     */
    public function home()
    {
        return view('partenaire.placeholder', [
            'titre' => 'Accueil chauffeur',
            'message' => 'Le tableau de bord (carte + missions) arrive en Phase 3.',
        ]);
    }
}
