<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\VendeurAbonnement;
use App\Models\Abonnement;
use App\Models\Vendeur;
use App\Services\LogisticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\StripeClient;
use Stripe\Webhook;
use Carbon\Carbon;

class StripeWebhookController extends Controller
{
    protected $logisticsService;

    public function __construct(LogisticsService $logisticsService)
    {
        $this->logisticsService = $logisticsService;
    }

    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleCheckoutCompleted($session);
                break;
            
            case 'invoice.paid':
                $invoice = $event->data->object;
                $this->handleInvoicePaid($invoice);
                break;

            default:
                Log::info('Unhandled Stripe event: ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleCheckoutCompleted($session)
    {
        $metadata = $session->metadata;
        $type = $metadata->type ?? null;

        if ($type === 'marketplace_order') {
            // Valider tous les ordres liés à cette session
            $orders = Order::where('stripe_session_id', $session->id)->get();

            foreach ($orders as $order) {
                if ($order->statut === 'en_attente') {
                    $order->update([
                        'statut' => 'paye',
                        'stripe_payment_intent_id' => $session->payment_intent,
                    ]);

                    // Génération des tokens logistiques
                    $this->logisticsService->generateLogisticsTokens($order);

                    // Transaction d'historique pour l'acheteur (pas de wallet).
                    Transaction::create([
                        'order_id' => $order->id,
                        'user_id' => $order->user_id,
                        'reference_externe' => $session->payment_intent,
                        'montant' => $order->total_final,
                        'moyen_paiement' => 'cb',
                        'statut' => 'succes',
                        'wallet_status' => 'none',
                        'metadata' => ['stripe_session_id' => $session->id]
                    ]);

                    // Transaction de revenu pour le vendeur, en séquestre jusqu'à livraison.
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
                            'metadata' => ['type' => 'seller_revenue', 'order_ref' => $order->reference]
                        ]);
                    }
                }
            }

            // Déduction éventuelle d'une carte cadeau appliquée au checkout.
            $giftCardId = $metadata->gift_card_id ?? null;
            $giftCardAmount = (int) ($metadata->gift_card_amount ?? 0);
            if ($giftCardId && $giftCardAmount > 0) {
                $giftCard = \App\Models\GiftCard::find($giftCardId);
                if ($giftCard && $giftCard->status === 'active') {
                    $giftCard->decrement('balance', $giftCardAmount);
                    if ($giftCard->balance <= 0) {
                        $giftCard->update(['status' => 'used', 'redeemed_at' => now()]);
                    }
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
        
        elseif ($type === 'seller_subscription') {
            $vendeurId = $metadata->vendeur_id;
            $planId = $metadata->plan_id;
            
            $vendeur = Vendeur::find($vendeurId);
            $abonnement = Abonnement::find($planId);

            if ($vendeur && $abonnement) {
                // Désactiver les anciens abonnements
                VendeurAbonnement::where('vendeur_id', $vendeur->id)->update(['actif' => false]);

                // Créer le nouvel abonnement
                VendeurAbonnement::create([
                    'vendeur_id' => $vendeur->id,
                    'abonnement_id' => $abonnement->id,
                    'date_debut' => Carbon::today(),
                    'date_fin' => Carbon::today()->addMonth(),
                    'actif' => true,
                    'renouvellement_automatique' => true,
                    'nombre_annonces_utilisees' => 0,
                    'metadata' => ['stripe_subscription_id' => $session->subscription]
                ]);
            }
        }
        
        elseif ($type === 'credit_pack_purchase') {
            $userId = $metadata->user_id;
            $packId = $metadata->pack_id;
            
            $user = \App\Models\User::find($userId);
            $pack = \App\Models\CreditPack::find($packId);
            
            if ($user && $pack) {
                $exists = \App\Models\CreditTransaction::where('user_id', $userId)
                    ->where('type', 'achat')
                    ->where('reference', $session->id)
                    ->exists();
                    
                if (!$exists) {
                    $creditService = app(\App\Services\CreditService::class);
                    $creditService->acheter($user, $pack, $session->id);
                }
            }
        }

        elseif ($type === 'gift_card_purchase') {
            $userId = $metadata->user_id;
            $amount = (int) ($metadata->amount ?? 0);
            $user = \App\Models\User::find($userId);

            // Idempotence : ne pas recréer une carte pour la même session Stripe.
            $already = \App\Models\GiftCard::where('metadata->stripe_session_id', $session->id)->exists();

            if ($user && $amount > 0 && !$already) {
                $giftCard = \App\Models\GiftCard::create([
                    'code' => \App\Models\GiftCard::generateCode(),
                    'amount' => $amount,
                    'balance' => $amount,
                    'status' => 'active',
                    'buyer_id' => $user->id,
                    'expiry_date' => now()->addYear(),
                    'metadata' => ['stripe_session_id' => $session->id]
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
    }

    protected function handleInvoicePaid($invoice)
    {
        // Utile pour les renouvellements automatiques
        // Logique similaire à handleCheckoutCompleted pour prolonger l'abonnement
    }
}
