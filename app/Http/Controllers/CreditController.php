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
            $session = $this->stripeService->createCreditPackSession(
                $user,
                $pack,
                route('account.credits.success'),
                route('account.credits.index')
            );

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la redirection vers le paiement : ' . $e->getMessage());
        }
    }

    /**
     * Retour suite au paiement Stripe
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if (!$sessionId) {
            return redirect()->route('account.credits.index');
        }

        try {
            $session = $this->stripeService->getSession($sessionId);
            
            if ($session->payment_status === 'paid' || $session->status === 'complete') {
                $userId = $session->metadata->user_id ?? null;
                $packId = $session->metadata->pack_id ?? null;
                $type = $session->metadata->type ?? null;

                if ($type === 'credit_pack_purchase' && $userId && $packId) {
                    $user = \App\Models\User::find($userId);
                    $pack = CreditPack::find($packId);

                    // Vérifier si la transaction existe déjà (traitée par webhook)
                    $exists = CreditTransaction::where('user_id', $userId)
                        ->where('type', 'achat')
                        ->where('reference', $sessionId)
                        ->exists();

                    if (!$exists && $user && $pack) {
                        // Activation immédiate
                        $this->creditService->acheter($user, $pack, $sessionId);
                        return redirect()->route('account.credits.index')->with('success', "Paiement réussi ! Vous avez reçu {$pack->total_credits} crédits.");
                    }
                    
                    if ($exists) {
                        return redirect()->route('account.credits.index')->with('success', 'Votre compte a bien été crédité.');
                    }
                }
            }
        
        } catch (\Exception $e) {
            \Log::error('Erreur vérification paiement Stripe: ' . $e->getMessage());
            return redirect()->route('account.credits.index')->with('error', 'Erreur lors de la vérification du paiement : ' . $e->getMessage());
        }

        return redirect()->route('account.credits.index')
            ->with('info', 'Le paiement est en cours de traitement. Vos crédits seront ajoutés sous peu.');
    }
}
