<?php

namespace App\Http\Controllers;

use App\Models\Abonnement;
use App\Models\VendeurAbonnement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionConfirmed;

class AbonnementController extends Controller
{
    protected $payDunyaService;

    public function __construct(\App\Services\PayDunyaService $payDunyaService)
    {
        $this->payDunyaService = $payDunyaService;
    }

    /**
     * Afficher les offres d'abonnement
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->estVendeurVerifie()) {
            return redirect()->route('vendeur.show')
                ->with('error_banner', 'Votre compte doit être vérifié par l\'administration pour accéder aux abonnements.');
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
                ->with('error_banner', 'Votre compte doit être vérifié pour accéder au paiement.');
        }

        $abonnement = Abonnement::findOrFail($request->abonnement_id);

        // Sécurité vendeur particulier
        if ($user->vendeur->estParticulier() && $abonnement->prix_mensuel > 0) {
            return redirect()->route('abonnements.index')
                ->with('error_banner', 'En tant que vendeur particulier, vous ne pouvez souscrire qu\'au forfait gratuit.');
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
                ->with('error_banner', 'Votre compte doit être vérifié pour souscrire à un abonnement.');
        }

        $vendeur = $user->vendeur;
        $abonnement = Abonnement::findOrFail($request->abonnement_id);

        if ($vendeur->estParticulier() && $abonnement->prix_mensuel > 0) {
            return back()->with('error', 'Restriction : Les vendeurs particuliers ne peuvent pas souscrire à des forfaits payants.');
        }

        if ($vendeur->estProfessionnel() && $abonnement->prix_mensuel == 0) {
            return back()->with('error', 'Restriction : Les vendeurs professionnels doivent souscrire à un forfait Basic ou Expert.');
        }

        if ($abonnement->prix_mensuel == 0) {
            // Logique pour abonnement gratuit (immédiat)
            try {
                DB::beginTransaction();
                VendeurAbonnement::where('vendeur_id', $vendeur->id)->update(['actif' => false]);
                $sub = VendeurAbonnement::create([
                    'vendeur_id' => $vendeur->id,
                    'abonnement_id' => $abonnement->id,
                    'date_debut' => Carbon::today(),
                    'date_fin' => Carbon::today()->addMonth(),
                    'actif' => true,
                    'renouvellement_automatique' => false,
                    'nombre_annonces_utilisees' => 0,
                ]);
                DB::commit();

                // Envoi de l'email de confirmation
                Mail::to($user->email)->send(new SubscriptionConfirmed($sub));
                return redirect()->route('vendeur.show')->with('success', "Vous avez activé le forfait gratuit !");
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', $e->getMessage());
            }
        }

        // Flux PayDunya pour abonnement payant
        try {
            $session = $this->payDunyaService->createCheckoutSession(
                $abonnement->prix_mensuel,
                "Abonnement " . $abonnement->nom . " sur Dwesta",
                route('paydunya.success'), 
                route('abonnements.index'), // On peut aussi utiliser paydunya.cancel
                [
                    'vendeur_id' => $vendeur->id,
                    'plan_id' => $abonnement->id,
                    'type' => 'seller_subscription'
                ]
            );

            return redirect($session->url);

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur PayDunya : ' . $e->getMessage());
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
     * Page de succès (Legacy Stripe - redirected)
     */
    public function success(Request $request)
    {
        return redirect()->route('vendeur.show')->with('success', 'Votre abonnement est en cours de traitement.');
    }
}
