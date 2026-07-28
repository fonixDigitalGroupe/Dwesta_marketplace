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
     * Crée une session Checkout carte pour une commande marketplace (multi-vendeurs).
     * Le montant est en FCFA et converti en EUR (Stripe ne supporte pas le XOF/XAF).
     * Le webhook retrouve les commandes via stripe_session_id.
     */
    public function createMarketplaceSession(float $amountFcfa, string $successUrl, string $cancelUrl, ?string $email = null, array $extraMetadata = [], ?string $name = null)
    {
        // 1 EUR = 655.957 FCFA (parité fixe CFA). Minimum Stripe ~0,50 €.
        $eurCents = max((int) round($amountFcfa / 655.957 * 100), 50);

        // On fusionne les métadonnées additionnelles (order_ids, carte cadeau…)
        // en ignorant les valeurs nulles (Stripe n'accepte que des scalaires).
        $metadata = array_filter(
            array_merge(['type' => 'marketplace_order'], $extraMetadata),
            fn ($v) => $v !== null && $v !== ''
        );

        $params = [
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Commande Dwesta',
                        'description' => 'Paiement par carte de votre commande sur Karnou',
                    ],
                    'unit_amount' => $eurCents,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $successUrl . (str_contains($successUrl, '?') ? '&' : '?') . 'session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => $cancelUrl,
            'metadata' => $metadata,
        ];

        // Pour pré-remplir le NOM (et l'email) du titulaire sur la page Stripe,
        // on crée un Customer avec ces informations et on l'attache à la session.
        if ($name && $email) {
            $customer = $this->stripe->customers->create([
                'name' => $name,
                'email' => $email,
            ]);
            $params['customer'] = $customer->id;
        } else {
            // Sinon on pré-remplit au moins l'email.
            $params['customer_email'] = $email;
        }

        return $this->stripe->checkout->sessions->create($params);
    }

    /**
     * Crée une session Checkout pour un abonnement (Style Pay-as-you-go / One-off)
     */
    public function createSubscriptionSession(Vendeur $vendeur, Abonnement $plan, $successUrl, $cancelUrl)
    {
        return $this->stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => "Abonnement {$plan->nom}",
                        'description' => "Accès forfait {$plan->nom} pour 1 mois",
                    ],
                    'unit_amount' => (int)($plan->prix_mensuel / 655 * 100), // Meme conversion que pour les crédits
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
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
                    'unit_amount' => (int)($amount / 655 * 100), // Conversion approximative FCFA -> EUR
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $successUrl . '?session_id={CHECKOUT_SESSION_ID}',
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
