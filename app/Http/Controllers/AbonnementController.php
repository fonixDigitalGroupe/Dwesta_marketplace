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
        
        if (!$user->estVendeurVerifie()) {
            return redirect()->route('vendeur.show')
                ->with('error', 'Votre compte doit être vérifié par l\'administration pour accéder aux abonnements.');
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
        $user = Auth::user();
        if (!$user->estVendeurVerifie()) {
            return redirect()->route('vendeur.show')
                ->with('error', 'Votre compte doit être vérifié pour accéder au paiement.');
        }

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

        if (!$user->estVendeurVerifie()) {
            return redirect()->route('vendeur.show')
                ->with('error', 'Votre compte doit être vérifié pour souscrire à un abonnement.');
        }

        $vendeur = $user->vendeur;
        $abonnement = Abonnement::findOrFail($request->abonnement_id);

        if (!$abonnement->stripe_price_id && $abonnement->prix_mensuel > 0) {
            return back()->with('error', 'Cet abonnement n\'est pas encore configuré pour le paiement réel (stripe_price_id manquant).');
        }

        if ($abonnement->prix_mensuel == 0) {
            // Logique pour abonnement gratuit (immédiat)
            try {
                DB::beginTransaction();
                VendeurAbonnement::where('vendeur_id', $vendeur->id)->update(['actif' => false]);
                VendeurAbonnement::create([
                    'vendeur_id' => $vendeur->id,
                    'abonnement_id' => $abonnement->id,
                    'date_debut' => Carbon::today(),
                    'date_fin' => Carbon::today()->addMonth(),
                    'actif' => true,
                    'renouvellement_automatique' => false,
                    'nombre_annonces_utilisees' => 0,
                ]);
                DB::commit();
                return redirect()->route('abonnements.index')->with('success', "Vous avez activé le forfait gratuit !");
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', $e->getMessage());
            }
        }

        // Flux Stripe pour abonnement payant
        try {
            $stripeService = new \App\Services\StripeService();
            $session = $stripeService->createSubscriptionSession($vendeur, $abonnement, 
                route('abonnements.success'), 
                route('abonnements.index')
            );

            return redirect($session->url);

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur Stripe : ' . $e->getMessage());
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

    /**
     * Page de succès après paiement Stripe
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if (!$sessionId) {
            return redirect()->route('abonnements.index');
        }

        try {
            $stripeService = new \App\Services\StripeService();
            $session = $stripeService->getSession($sessionId);
            
            if ($session->payment_status === 'paid' || $session->status === 'complete') {
                
                // On peut aussi activer ici "au cas où" le webhook tarde, mais l'idéal est de laisser le webhook gérer la source de vérité.
                // Pour une meilleure UX, on active ici si ce n'est pas déjà fait.
                
                $vendeurId = $session->metadata->vendeur_id ?? null;
                $planId = $session->metadata->plan_id ?? null;
                $type = $session->metadata->type ?? null;

                if ($type === 'seller_subscription' && $vendeurId && $planId) {
                    $vendeur = \App\Models\Vendeur::find($vendeurId);
                    $abonnement = Abonnement::find($planId);

                    // Vérifier si l'abonnement est déjà actif (par le webhook)
                    $exists = VendeurAbonnement::where('vendeur_id', $vendeurId)
                        ->where('abonnement_id', $planId)
                        ->where('created_at', '>=', Carbon::now()->subMinutes(5)) // Créé tout récemment
                        ->exists();

                    if (!$exists) {
                         // Activation immédiate (fallback webhook)
                         VendeurAbonnement::where('vendeur_id', $vendeur->id)->update(['actif' => false]);
                         
                         VendeurAbonnement::create([
                            'vendeur_id' => $vendeur->id,
                            'abonnement_id' => $abonnement->id,
                            'date_debut' => Carbon::today(),
                            'date_fin' => Carbon::today()->addMonth(),
                            'actif' => true,
                            'renouvellement_automatique' => true,
                            'nombre_annonces_utilisees' => 0,
                        ]);
                    }
                }

                return redirect()->route('abonnements.index')
                    ->with('success', 'Votre abonnement a été activé avec succès ! Bienvenue dans votre nouvelle offre.');
            }
        
        } catch (\Exception $e) {
            return redirect()->route('abonnements.index')->with('error', 'Erreur lors de la vérification du paiement.');
        }

        return redirect()->route('abonnements.index')
            ->with('info', 'Le paiement est en cours de traitement. Votre abonnement sera actif sous peu.');
    }
}
