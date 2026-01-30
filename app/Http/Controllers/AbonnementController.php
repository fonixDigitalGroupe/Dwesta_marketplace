<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\VendeurAbonnement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbonnementController extends Controller
{
    // Constructor removed

    /**
     * Afficher les offres d'abonnement
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->estVendeur()) {
            return redirect()->route('vendeur.create')
                ->with('error', 'Vous devez créer un compte vendeur pour accéder aux abonnements.');
        }

        $vendeur = $user->vendeur;
        $abonnements = Abonnement::where('actif', true)->orderBy('ordre')->get();
        
        // Récupérer l'abonnement actif du vendeur
        $abonnementActif = VendeurAbonnement::where('vendeur_id', $vendeur->id)
            ->where('actif', true)
            ->where('date_fin', '>=', Carbon::today())
            ->with('abonnement')
            ->first();

        return view('abonnements.index', compact('abonnements', 'abonnementActif'));
    }

    /**
     * Afficher la page de confirmation (Checkout)
     */
    public function checkout(Request $request)
    {
        $abonnement = Abonnement::findOrFail($request->abonnement_id);
        
        // Si c'est un forfait gratuit, on souscrit directement via la méthode subscribe
        if ($abonnement->prix_mensuel == 0) {
            // On redirige vers subscribe mais comme c'est une méthode POST, il faut un formulaire caché ou adapter la logique.
            // Pour faire simple ici, on affiche quand même la confirmation pour "Activer", ou on adapte plus tard.
            // Le user a dit "abonnement basic" (payant), donc on se concentre sur le flux payant.
        }

        return view('abonnements.checkout', compact('abonnement'));
    }

    /**
     * Souscrire à un abonnement
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'abonnement_id' => 'required|exists:abonnements,id',
            'payment_method' => 'required|in:om,momo,cb'
        ]);

        $user = Auth::user();
        $vendeur = $user->vendeur;
        $abonnement = Abonnement::findOrFail($request->abonnement_id);

        // Vérifier si le vendeur a déjà un abonnement actif
        $abonnementActif = VendeurAbonnement::where('vendeur_id', $vendeur->id)
            ->where('actif', true)
            ->where('date_fin', '>=', Carbon::today())
            ->first();

        try {
            DB::beginTransaction();

            // Désactiver l'ancien abonnement si existant
            if ($abonnementActif) {
                $abonnementActif->update(['actif' => false]);
            }

            // Créer le nouvel abonnement
            VendeurAbonnement::create([
                'vendeur_id' => $vendeur->id,
                'abonnement_id' => $abonnement->id,
                'date_debut' => Carbon::today(),
                'date_fin' => Carbon::today()->addMonth(),
                'actif' => true,
                'renouvellement_automatique' => $request->has('auto_renew'),
                'nombre_annonces_utilisees' => 0,
            ]);

            DB::commit();

            return redirect()->route('abonnements.index')
                ->with('success', "Vous êtes maintenant abonné au forfait {$abonnement->nom} !");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }

    /**
     * Annuler un abonnement
     */
    public function cancel(Request $request)
    {
        $user = Auth::user();
        $vendeur = $user->vendeur;

        $abonnementActif = VendeurAbonnement::where('vendeur_id', $vendeur->id)
            ->where('actif', true)
            ->first();

        if ($abonnementActif) {
            $abonnementActif->update([
                'renouvellement_automatique' => false
            ]);

            return back()->with('success', 'Le renouvellement automatique a été désactivé.');
        }

        return back()->with('error', 'Aucun abonnement actif trouvé.');
    }
}
