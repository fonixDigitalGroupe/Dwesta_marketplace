<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\VendeurAbonnement;
use App\Models\Abonnement;
use App\Models\Vendeur;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Exécute (fulfillment) une session Stripe payée, de façon IDEMPOTENTE.
 *
 * Utilisé par deux chemins :
 *  - le webhook `checkout.session.completed` (source principale) ;
 *  - un filet de sécurité sur les pages de succès (au cas où le webhook
 *    serait en panne ou en retard).
 *
 * Aucune commande / crédit / carte cadeau / abonnement n'est accordé tant
 * que Stripe n'a pas confirmé le paiement.
 */
class StripeFulfillmentService
{
    public function __construct(
        protected LogisticsService $logisticsService,
        protected StripeService $stripeService
    ) {
    }

    /**
     * Filet de sécurité : récupère la session Stripe, vérifie qu'elle est
     * bien PAYÉE, puis exécute le fulfillment. Retourne true si payée.
     */
    public function fulfillById(?string $sessionId): bool
    {
        if (!$sessionId) {
            return false;
        }

        try {
            $session = $this->stripeService->getSession($sessionId);
        } catch (\Throwable $e) {
            Log::error('Stripe fulfillById: session introuvable', ['session' => $sessionId, 'error' => $e->getMessage()]);
            return false;
        }

        if (($session->payment_status ?? null) !== 'paid') {
            return false;
        }

        $this->fulfill($session);
        return true;
    }

    /**
     * Exécute le fulfillment d'une session Stripe (objet Session).
     * Idempotent : peut être appelé plusieurs fois sans double effet.
     */
    public function fulfill($session): void
    {
        $metadata = $session->metadata;
        $type = $metadata->type ?? null;

        if ($type === 'marketplace_order') {
            $this->fulfillMarketplaceOrder($session, $metadata);
        } elseif ($type === 'seller_subscription') {
            $this->fulfillSellerSubscription($session, $metadata);
        } elseif ($type === 'credit_pack_purchase') {
            $this->fulfillCreditPack($session, $metadata);
        } elseif ($type === 'gift_card_purchase') {
            $this->fulfillGiftCardPurchase($session, $metadata);
        }
    }

    protected function fulfillMarketplaceOrder($session, $metadata): void
    {
        $orders = Order::where('stripe_session_id', $session->id)->get();

        foreach ($orders as $order) {
            if ($order->statut === 'en_attente') {
                $order->update([
                    'statut' => 'paye',
                    'stripe_payment_intent_id' => $session->payment_intent,
                ]);

                $this->logisticsService->generateLogisticsTokens($order);

                Transaction::create([
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'reference_externe' => $session->payment_intent,
                    'montant' => $order->total_final,
                    'moyen_paiement' => 'cb',
                    'statut' => 'succes',
                    'wallet_status' => 'none',
                    'metadata' => ['stripe_session_id' => $session->id],
                ]);

                if ($order->seller && $order->seller->user_id) {
                    $revenuVendeur = $order->total_produits - ($order->commission_plateforme ?? 0);
                    Transaction::create([
                        'order_id' => $order->id,
                        'user_id' => $order->seller->user_id,
                        'reference_externe' => 'REV-' . $order->reference,
                        'montant' => $revenuVendeur,
                        'moyen_paiement' => 'wallet',
                        'statut' => 'succes',
                        'wallet_status' => 'pending',
                        'release_at' => now()->addDays(30),
                        'metadata' => ['type' => 'seller_revenue', 'order_ref' => $order->reference],
                    ]);
                }
            }
        }

        // Déduction éventuelle d'une carte cadeau appliquée au checkout.
        $giftCardId = $metadata->gift_card_id ?? null;
        $giftCardAmount = (int) ($metadata->gift_card_amount ?? 0);
        if ($giftCardId && $giftCardAmount > 0) {
            $giftCard = \App\Models\GiftCard::find($giftCardId);
            // Idempotence : on ne déduit qu'une fois par session.
            $alreadyDeducted = Transaction::where('metadata->gift_card_session', $session->id)->exists();
            if ($giftCard && $giftCard->status === 'active' && !$alreadyDeducted) {
                $giftCard->decrement('balance', $giftCardAmount);
                if ($giftCard->balance <= 0) {
                    $giftCard->update(['status' => 'used', 'redeemed_at' => now()]);
                }
                Transaction::create([
                    'user_id' => $orders->first()?->user_id,
                    'reference_externe' => 'GC-' . $session->id,
                    'montant' => -$giftCardAmount,
                    'moyen_paiement' => 'gift_card',
                    'statut' => 'succes',
                    'wallet_status' => 'none',
                    'metadata' => ['gift_card_session' => $session->id, 'gift_card_id' => $giftCardId],
                ]);
            }
        }

        // Vider le panier de l'utilisateur (base de données) si disponible.
        if ($orders->count() > 0) {
            $user = $orders[0]->user;
            if ($user && $user->cart) {
                $user->cart->items()->delete();
            }
        }
    }

    protected function fulfillSellerSubscription($session, $metadata): void
    {
        $vendeur = Vendeur::find($metadata->vendeur_id ?? null);
        $abonnement = Abonnement::find($metadata->plan_id ?? null);

        if (!$vendeur || !$abonnement) {
            return;
        }

        // Idempotence : ne pas recréer l'abonnement pour la même session Stripe.
        $already = VendeurAbonnement::where('metadata->stripe_session_id', $session->id)->exists();
        if ($already) {
            return;
        }

        VendeurAbonnement::where('vendeur_id', $vendeur->id)->update(['actif' => false]);

        VendeurAbonnement::create([
            'vendeur_id' => $vendeur->id,
            'abonnement_id' => $abonnement->id,
            'date_debut' => Carbon::today(),
            'date_fin' => Carbon::today()->addMonth(),
            'actif' => true,
            'renouvellement_automatique' => true,
            'nombre_annonces_utilisees' => 0,
            'metadata' => [
                'stripe_session_id' => $session->id,
                'stripe_subscription_id' => $session->subscription ?? null,
            ],
        ]);
    }

    protected function fulfillCreditPack($session, $metadata): void
    {
        $user = \App\Models\User::find($metadata->user_id ?? null);
        $pack = \App\Models\CreditPack::find($metadata->pack_id ?? null);

        if (!$user || !$pack) {
            return;
        }

        $exists = \App\Models\CreditTransaction::where('user_id', $user->id)
            ->where('type', 'achat')
            ->where('reference', $session->id)
            ->exists();

        if (!$exists) {
            app(CreditService::class)->acheter($user, $pack, $session->id);
        }
    }

    protected function fulfillGiftCardPurchase($session, $metadata): void
    {
        $user = \App\Models\User::find($metadata->user_id ?? null);
        $amount = (int) ($metadata->amount ?? 0);

        if (!$user || $amount <= 0) {
            return;
        }

        // Idempotence : ne pas recréer une carte pour la même session Stripe.
        $already = \App\Models\GiftCard::where('metadata->stripe_session_id', $session->id)->exists();
        if ($already) {
            return;
        }

        $giftCard = \App\Models\GiftCard::create([
            'code' => \App\Models\GiftCard::generateCode(),
            'amount' => $amount,
            'balance' => $amount,
            'status' => 'active',
            'buyer_id' => $user->id,
            'expiry_date' => now()->addYear(),
            'metadata' => ['stripe_session_id' => $session->id],
        ]);

        \App\Models\CreditTransaction::create([
            'user_id' => $user->id,
            'type' => 'gift_card_purchase',
            'montant' => 0,
            'description' => "Achat de carte cadeau : " . number_format($amount, 0, ',', ' ') . " FCFA",
            'reference' => $session->id,
            'related_type' => \App\Models\GiftCard::class,
            'related_id' => $giftCard->id,
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)
                ->send(new \App\Mail\GiftCardPurchased($user, $giftCard));
        } catch (\Exception $mailException) {
            Log::error('Gift card email failed: ' . $mailException->getMessage());
        }
    }
}
