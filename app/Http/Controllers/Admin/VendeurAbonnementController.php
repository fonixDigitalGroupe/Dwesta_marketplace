<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendeur;
use Illuminate\Http\Request;

class VendeurAbonnementController extends Controller
{
    /**
     * Liste de tous les vendeurs avec l'état de leurs abonnements.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $statut = $request->get('statut'); // actif | expire | aucun

        $query = Vendeur::with(['user', 'abonnements.abonnement'])
            ->whereHas('user', fn ($q) => $q->whereDoesntHave('roles', fn ($r) => $r->where('name', 'admin')));

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('prenom', 'like', "%{$search}%")
                  ->orWhere('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $vendeurs = $query->latest()->paginate(20)->withQueryString();

        // Statistiques
        $totalVendeurs = Vendeur::count();
        $avecAbonnementActif = Vendeur::whereHas('abonnements', fn ($q) => $q->where('actif', true)->where('date_fin', '>=', now()))->count();
        $sansAbonnement = $totalVendeurs - $avecAbonnementActif;

        return view('admin.vendeurs.abonnements', compact(
            'vendeurs', 'search', 'statut',
            'totalVendeurs', 'avecAbonnementActif', 'sansAbonnement'
        ));
    }
}
