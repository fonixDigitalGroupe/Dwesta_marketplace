<?php

namespace App\Http\Controllers;

use App\Models\GiftCard;
use App\Models\GiftCardOption;
use App\Models\CreditTransaction;
use App\Services\CreditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GiftCardController extends Controller
{
    protected $creditService;

    protected $stripeService;

    public function __construct(CreditService $creditService, \App\Services\StripeService $stripeService)
    {
        $this->creditService = $creditService;
        $this->stripeService = $stripeService;
    }

    /**
     * Voir mes cartes cadeaux
     */
    public function index()
    {
        $user = Auth::user();
        
        // Options de cartes cadeaux dynamiques
        $giftCardOptions = GiftCardOption::where('is_active', true)->orderBy('amount')->get();

        // Cartes achetées par l'utilisateur
        $boughtCards = GiftCard::where('buyer_id', $user->id)->latest()->get();
        
        // Cartes utilisées par l'utilisateur
        $redeemedCards = GiftCard::where('user_id', $user->id)->latest()->get();

        return view('gift_cards.index', compact('giftCardOptions', 'boughtCards', 'redeemedCards'));
    }

    /**
     * Utiliser une carte cadeau
     */
    public function redeem(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = Auth::user();
        $code = strtoupper(trim($request->code));
        
        $giftCard = GiftCard::where('code', $code)->first();

        if (!$giftCard) {
            return back()->with('error', 'Code de carte cadeau invalide.');
        }

        if ($giftCard->status !== 'active' || $giftCard->balance <= 0) {
            return back()->with('error', 'Cette carte cadeau a déjà été utilisée ou est expirée.');
        }

        if ($giftCard->expiry_date && $giftCard->expiry_date->isPast()) {
            $giftCard->update(['status' => 'expired']);
            return back()->with('error', 'Cette carte cadeau est expirée.');
        }

        try {
            DB::beginTransaction();

            $amountToRedeem = $giftCard->balance;
            
            // Ajouter les crédits à l'utilisateur
            $this->creditService->addCredits(
                $user,
                (int)$amountToRedeem,
                "Utilisation de la carte cadeau : {$giftCard->code}",
                'gift_card_redeem',
                $giftCard
            );

            // Mettre à jour la carte cadeau
            $giftCard->update([
                'user_id' => $user->id,
                'balance' => 0,
                'status' => 'used',
                'redeemed_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', "Félicitations ! Vous avez crédité votre compte de " . number_format($amountToRedeem, 0) . " crédits.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de l\'utilisation de la carte : ' . $e->getMessage());
        }
    }

    /**
     * Initier l'achat d'une carte cadeau (Étape unique : directement vers la page de paiement)
     */
    public function buy(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
        ]);

        $amount = $request->amount;
        $user = Auth::user();

        try {
            $session = $this->stripeService->createGiftCardSession(
                $user,
                $amount,
                route('gift-cards.index'),
                route('gift-cards.index')
            );

            session(['gift_card_amount' => $amount]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur Stripe : ' . $e->getMessage());
        }
    }

    /**
     * Page de checkout de carte cadeau (Étape 2 : Choix du wallet)
     * Similaire à l'étape 1 du checkout marketplace
     */
    public function checkout()
    {
        $amount = session('gift_card_amount');
        if (!$amount) {
            return redirect()->route('gift-cards.index')->with('error', 'Veuillez choisir un montant d\'abord.');
        }

        return view('gift_cards.checkout', compact('amount'));
    }

    /**
     * Confirmer l'achat et initier le paiement Stripe (mode test).
     */
    public function confirm(Request $request)
    {
        $request->validate([
            'moyen_paiement' => 'required|string|in:om,wave,free,cb',
        ]);

        $amount = session('gift_card_amount');
        if (!$amount) {
            return redirect()->route('gift-cards.index')->with('error', 'Session expirée.');
        }

        $user = Auth::user();

        try {
            // Tous les moyens de paiement passent désormais par Stripe (carte, mode test).
            $session = $this->stripeService->createGiftCardSession(
                $user,
                $amount,
                route('gift-cards.index'),
                route('gift-cards.index')
            );

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur Stripe : ' . $e->getMessage());
        }
    }

    /**
     * Retour succès (Legacy Stripe - redirected)
     */
    public function success(Request $request)
    {
        return redirect()->route('gift-cards.index')->with('success', 'Votre paiement est en cours de traitement.');
    }

    /**
     * Supprimer une carte cadeau
     */
    public function destroy(GiftCard $giftCard)
    {
        // Vérifier que c'est bien l'acheteur qui supprime
        if ($giftCard->buyer_id !== Auth::id()) {
            abort(403);
        }

        $giftCard->delete();

        return back()->with('success', 'Votre carte cadeau a été supprimée avec succès.');
    }

    /**
     * Vérifier le solde d'une carte cadeau (AJAX)
     */
    public function checkBalance(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $code = strtoupper(trim($request->code));
        $giftCard = GiftCard::where('code', $code)->first();

        if (!$giftCard) {
            return response()->json(['success' => false, 'message' => 'Code introuvable.']);
        }

        if ($giftCard->expiry_date && $giftCard->expiry_date->isPast()) {
            $giftCard->update(['status' => 'expired']);
        }

        return response()->json([
            'success' => true,
            'code' => $giftCard->code,
            'amount' => (int)$giftCard->amount,
            'balance' => (int)$giftCard->balance,
            'status' => $giftCard->status,
            'expiry' => $giftCard->expiry_date ? $giftCard->expiry_date->format('d/m/Y') : null,
        ]);
    }

    /**
     * Appliquer une carte cadeau lors du checkout (AJAX)
     */
    public function applyToCheckout(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'total' => 'required|numeric'
        ]);

        $code = strtoupper(trim($request->code));
        $giftCard = GiftCard::where('code', $code)->first();

        if (!$giftCard) {
            return response()->json(['success' => false, 'message' => 'Code de carte cadeau invalide.'], 404);
        }

        if ($giftCard->status !== 'active' || $giftCard->balance <= 0) {
            return response()->json(['success' => false, 'message' => 'Cette carte a déjà été utilisée ou est expirée.'], 400);
        }

        if ($giftCard->expiry_date && $giftCard->expiry_date->isPast()) {
            $giftCard->update(['status' => 'expired']);
            return response()->json(['success' => false, 'message' => 'Cette carte cadeau est expirée.'], 400);
        }

        $deduction = min($giftCard->balance, $request->total);
        $newTotal = $request->total - $deduction;

        // On stocke temporairement en session l'intention d'utiliser cette carte
        session(['applied_gift_card' => [
            'id' => $giftCard->id,
            'code' => $giftCard->code,
            'amount' => $deduction
        ]]);

        return response()->json([
            'success' => true,
            'message' => 'Carte appliquée avec succès.',
            'deduction' => (int)$deduction,
            'newTotal' => (int)$newTotal,
            'balance_remaining' => (int)($giftCard->balance - $deduction)
        ]);
    }
}
