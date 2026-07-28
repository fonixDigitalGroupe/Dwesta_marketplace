<?php

namespace App\Http\Controllers;

use App\Models\CreditPack;
use App\Models\CreditTransaction;
use App\Services\CreditService;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    public function __construct(
        private CreditService $creditService,
        private StripeService $stripeService
    ) {}

    /**
     * Afficher la page Mon Porte-Monnaie / Crédits
     */
    public function index(Request $request)
    {
        // Filet de sécurité : finaliser l'achat de crédits si le webhook a tardé.
        app(\App\Services\StripeFulfillmentService::class)->fulfillById($request->query('session_id'));

        $user = Auth::user();
        $balance = $this->creditService->solde($user);
        $packs = CreditPack::actif()->get();
        // On n'affiche que les achats de crédit dans l'historique.
        $transactions = CreditTransaction::where('user_id', $user->id)
            ->where('type', 'achat')
            ->latest()
            ->paginate(20);

        return view('account.credits.index', compact('balance', 'packs', 'transactions'));
    }

    /**
     * Lancer le paiement pour un pack donné
     */
    public function buyPack(Request $request)
    {
        $request->validate([
            'pack_id' => 'required|exists:credit_packs,id',
        ]);

        $pack = CreditPack::findOrFail($request->pack_id);
        $user = Auth::user();

        try {
            $session = $this->stripeService->createCreditPackSession(
                $user,
                $pack,
                route('account.credits.index'),
                route('account.credits.index')
            );

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la redirection vers le paiement : ' . $e->getMessage());
        }
    }

    /**
     * Retour succès (Legacy Stripe - redirected)
     */
    public function success(Request $request)
    {
        return redirect()->route('account.credits.index')->with('success', 'Votre compte est en cours de crédit.');
    }

    /**
     * Supprimer une transaction de l'historique
     */
    public function destroyTransaction($id)
    {
        $transaction = \App\Models\CreditTransaction::where('user_id', \Illuminate\Support\Facades\Auth::id())->findOrFail($id);
        $transaction->delete();

        return back()->with('success', 'Transaction supprimée de l\'historique.');
    }
}
