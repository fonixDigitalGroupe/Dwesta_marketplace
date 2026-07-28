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
    protected $stripeService;

    public function __construct(\App\Services\StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
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
     * Page "Mon abonnement" (tableau de bord abonnement du vendeur)
     */
    public function monAbonnement()
    {
        $user = Auth::user();

        if (!$user->estVendeurVerifie()) {
            return redirect()->route('vendeur.show')
                ->with('error_banner', 'Votre compte doit être vérifié pour accéder à vos abonnements.');
        }

        $vendeur = $user->vendeur;
        $abonnements = Abonnement::where('actif', true)->orderBy('ordre')->get();

        $abonnementActif = VendeurAbonnement::where('vendeur_id', $vendeur->id)
            ->where('actif', true)
            ->with('abonnement')
            ->latest()
            ->first();

        return view('abonnements.mon-abonnement', compact('abonnements', 'abonnementActif'));
    }

    /**
     * Détail d'un forfait (page show)
     */
    public function show(Abonnement $abonnement)
    {
        $abonnementActuel = null;

        if (Auth::check() && Auth::user()->estVendeur() && Auth::user()->vendeur) {
            $abonnementActuel = VendeurAbonnement::where('vendeur_id', Auth::user()->vendeur->id)
                ->where('actif', true)
                ->where('date_fin', '>=', Carbon::today())
                ->first();
        }

        return view('abonnements.show', compact('abonnement', 'abonnementActuel'));
    }

    /**
     * Afficher la page de confirmation (Checkout) - kept for legacy
     */
    public function checkout(Request $request)
    {
        $user = Auth::user();
        if (!$user->estVendeurVerifie()) {
            return redirect()->route('vendeur.show')
                ->with('error_banner', 'Votre compte doit être vérifié pour accéder au paiement.');
        }

        $abonnement = Abonnement::findOrFail($request->get('abonnement_id'));

        if ($user->vendeur->estParticulier() && $abonnement->prix_mensuel > 0) {
            return redirect()->route('abonnements.index')
                ->with('error_banner', 'En tant que vendeur particulier, vous ne pouvez souscrire qu\'au forfait gratuit.');
        }

        return view('abonnements.checkout', compact('abonnement'));
    }

    /**
     * Initier le paiement directement — crée une session Stripe Checkout
     * et redirige l'utilisateur vers la page de paiement Stripe (mode test).
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'abonnement_id' => 'required|exists:abonnements,id',
        ]);

        $user = Auth::user();

        if (!$user->estVendeurVerifie()) {
            return redirect()->route('vendeur.show')
                ->with('error_banner', 'Votre compte doit être vérifié pour souscrire à un abonnement.');
        }

        $vendeur = $user->vendeur;
        $abonnement = Abonnement::findOrFail($request->abonnement_id);

        if ($vendeur->estParticulier() && $abonnement->prix_mensuel > 0) {
            return back()->with('error', 'Les vendeurs particuliers ne peuvent pas souscrire à des forfaits payants.');
        }

        if ($vendeur->estProfessionnel() && $abonnement->prix_mensuel == 0) {
            return back()->with('error', 'Les vendeurs professionnels doivent souscrire à un forfait Basic ou Expert.');
        }

        // Forfait gratuit : activation directe
        if ($abonnement->prix_mensuel == 0) {
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
                Mail::to($user->email)->send(new SubscriptionConfirmed($sub));
                return redirect()->route('vendeur.show')->with('success', 'Vous avez activé le forfait gratuit !');
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', $e->getMessage());
            }
        }

        // Forfait payant : paiement par carte via Stripe (mode test).
        try {
            $session = $this->stripeService->createSubscriptionSession(
                $vendeur,
                $abonnement,
                route('abonnements.index'),
                route('abonnements.index')
            );

            return redirect($session->url);

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur Stripe : ' . $e->getMessage());
        }
    }

    /**
     * Souscrire à un abonnement
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'abonnement_id' => 'required|exists:abonnements,id',
            'payment_method' => 'required|in:om,momo,cb,wave,free'
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

        // Paiement de l'abonnement par carte via Stripe (mode test).
        try {
            $session = $this->stripeService->createSubscriptionSession(
                $vendeur,
                $abonnement,
                route('abonnements.index'),
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
     * Page de succès (Legacy Stripe - redirected)
     */
    public function success(Request $request)
    {
        return redirect()->route('vendeur.show')->with('success', 'Votre abonnement est en cours de traitement.');
    }
}
