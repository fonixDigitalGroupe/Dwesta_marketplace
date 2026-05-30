<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    /**
     * Liste des annonces avec filtres
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');
        $perPage = $request->get('per_page', 8);

        $query = Annonce::with(['vendeur.user', 'categorie'])->latest();

        // Filtre par statut
        if (!empty($status)) {
            $query->where('statut', $status);
        }

        // Recherche par titre ou vendeur
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhereHas('vendeur.user', function($u) use ($search) {
                      $u->where('prenom', 'like', "%{$search}%")
                        ->orWhere('nom', 'like', "%{$search}%");
                  });
            });
        }

        $annonces = $query->paginate($perPage)->withQueryString();

        return view('admin.annonces.index', compact('annonces', 'status', 'search', 'perPage'));
    }

    /**
     * Approuve une annonce (Modération)
     */
    public function approve(Annonce $annonce)
    {
        $annonce->update([
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
            'expire_le' => now()->addMonths(6), // Durée par défaut si non spécifiée
        ]);
        
        return back()->with('success', 'L\'annonce a été publiée avec succès.');
    }

    /**
     * Rejette une annonce (Modération)
     */
    public function reject(Request $request, Annonce $annonce)
    {
        $request->validate([
            'raison_rejet' => 'nullable|string|max:1000'
        ]);

        $annonce->update([
            'statut' => Annonce::STATUT_REJETEE,
            'raison_rejet' => $request->raison_rejet
        ]);

        // Envoyer l'email de notification au vendeur
        try {
            \Illuminate\Support\Facades\Mail::to($annonce->vendeur->user->email)->send(new \App\Mail\AnnonceRejected($annonce));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Erreur lors de l'envoi de l'email de rejet d'annonce : " . $e->getMessage());
        }

        return back()->with('info', 'L\'annonce a été rejetée et le vendeur a été notifié.');
    }
}
