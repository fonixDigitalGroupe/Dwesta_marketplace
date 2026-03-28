<?php

namespace App\Services;

use Stripe\StripeClient;
use App\Models\Order;
use App\Models\Vendeur;
use App\Models\Abonnement;

class StripeService
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    /**
     * Crée une session Checkout pour un achat unique (Panier)
     */
    public function createCheckoutSession(Order $order, $successUrl, $cancelUrl)
    {
        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => "Commande " . $order->reference,
                        'description' => "Paiement de votre commande sur Dwesta",
                    ],
                    'unit_amount' => (int)($order->total_final * 100), // Stripe utilise les centimes
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $cancelUrl,
            'client_reference_id' => $order->id,
            'metadata' => [
                'order_id' => $order->id,
                'type' => 'marketplace_order'
            ],
            'customer_email' => $order->buyer->email,
        ]);
    }

    /**
     * Crée une session Checkout pour un abonnement
     */
    /**
     * Crée une session Checkout pour un abonnement
     */
    public function createSubscriptionSession(Vendeur $vendeur, Abonnement $plan, $successUrl, $cancelUrl)
    {
        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price' => $plan->stripe_price_id,
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $cancelUrl,
            'client_reference_id' => $vendeur->id,
            'metadata' => [
                'vendeur_id' => $vendeur->id,
                'plan_id' => $plan->id,
                'type' => 'seller_subscription'
            ],
            'customer_email' => $vendeur->user->email,
        ]);
    }

    /**
     * Crée une session Checkout pour l'achat d'une carte cadeau
     */
    public function createGiftCardSession($user, $amount, $successUrl, $cancelUrl)
    {
        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => "Carte Cadeau Dwesta",
                        'description' => "Achat d'une carte cadeau de " . number_format($amount, 0) . " FCFA",
                    ],
                    'unit_amount' => (int)($amount / 655 * 100), // Conversion approximative FCFA -> EUR pour le test (ou garder en FCFA si configuré)
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}&amount=' . $amount,
            'cancel_url' => $cancelUrl,
            'metadata' => [
                'user_id' => $user->id,
                'amount' => $amount,
                'type' => 'gift_card_purchase'
            ],
            'customer_email' => $user->email,
        ]);
    }

    /**
     * Crée une session Checkout pour l'achat d'un pack de crédits
     */
    public function createCreditPackSession($user, \App\Models\CreditPack $pack, $successUrl, $cancelUrl)
    {
        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => "Pack {$pack->nom}",
                        'description' => "{$pack->credits} crédits" . ($pack->bonus_credits ? " + {$pack->bonus_credits} bonus" : ""),
                    ],
                    'unit_amount' => (int)($pack->prix / 655 * 100), // Conversion approximative FCFA -> EUR
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $cancelUrl,
            'metadata' => [
                'user_id' => $user->id,
                'pack_id' => $pack->id,
                'type' => 'credit_pack_purchase'
            ],
            'customer_email' => $user->email,
        ]);
    }

    /**
     * Récupère une session Stripe
     */
    public function getSession($sessionId)
    {
        return $this->stripe->checkout->sessions->retrieve($sessionId);
    }
}
