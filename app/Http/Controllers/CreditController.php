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
        private \App\Services\PayDunyaService $payDunyaService
    ) {}

    /**
     * Afficher la page Mon Porte-Monnaie / Crédits
     */
    public function index()
    {
        $user = Auth::user();
        $balance = $this->creditService->solde($user);
        $packs = CreditPack::actif()->get();
        $transactions = CreditTransaction::where('user_id', $user->id)->latest()->paginate(20);

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
            $session = $this->payDunyaService->createCheckoutSession(
                $pack->prix,
                "Achat de Pack Crédits " . $pack->nom . " sur Dwesta",
                route('paydunya.success'), 
                route('account.credits.index'),
                [
                    'user_id' => $user->id,
                    'pack_id' => $pack->id,
                    'type' => 'credit_pack_purchase'
                ]
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
