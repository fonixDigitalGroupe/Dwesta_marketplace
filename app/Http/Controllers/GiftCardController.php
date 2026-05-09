<?php

namespace App\Http\Controllers;

use App\Models\GiftCard;
use App\Models\GiftCardOption;
use App\Services\CreditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GiftCardController extends Controller
{
    protected $creditService;

    public function __construct(CreditService $creditService)
    {
        $this->creditService = $creditService;
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
                "Utilisation de la carte cadeau : {$giftCard->code}"
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
     * Acheter une carte cadeau via Stripe
     */
    public function buy(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);

        $user = Auth::user();
        
        try {
            $stripeService = new \App\Services\StripeService();
            $session = $stripeService->createGiftCardSession(
                $user, 
                $request->amount,
                route('gift-cards.success'),
                route('gift-cards.index')
            );

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur Stripe : ' . $e->getMessage());
        }
    }

    /**
     * Succès du paiement de la carte cadeau
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');
        $amount = $request->get('amount');
        $user = Auth::user();

        if (!$sessionId || !$amount) {
            return redirect()->route('gift-cards.index');
        }

        try {
            $stripeService = new \App\Services\StripeService();
            $session = $stripeService->getSession($sessionId);

            if ($session->payment_status === 'paid') {
                // Créer la carte cadeau effectivement
                $giftCard = GiftCard::create([
                    'code' => GiftCard::generateCode(),
                    'amount' => $amount,
                    'balance' => $amount,
                    'status' => 'active',
                    'buyer_id' => $user->id,
                    'expiry_date' => now()->addYear(),
                ]);

                return redirect()->route('gift-cards.index')->with('success', "Paiement réussi ! Votre carte cadeau a été générée. Code : " . $giftCard->code);
            }
        } catch (\Exception $e) {
            return redirect()->route('gift-cards.index')->with('error', 'Erreur lors de la vérification du paiement.');
        }

        return redirect()->route('gift-cards.index');
    }
}
