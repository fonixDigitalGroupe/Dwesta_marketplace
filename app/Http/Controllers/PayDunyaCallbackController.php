<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use App\Services\PayDunyaService;
use App\Services\LogisticsService;
use App\Mail\GiftCardPurchased;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PayDunyaCallbackController extends Controller
{
    protected $payDunyaService;
    protected $logisticsService;

    public function __construct(PayDunyaService $payDunyaService, LogisticsService $logisticsService)
    {
        $this->payDunyaService = $payDunyaService;
        $this->logisticsService = $logisticsService;
    }

    /**
     * Retour succès (Redirection Client)
     */
    public function success(Request $request)
    {
        $token = $request->get('token');
        if (!$token) {
            return redirect()->route('home')->with('error', 'Token manquant.');
        }

        $paymentData = $this->payDunyaService->verifyPayment($token);

        if ($paymentData && $paymentData['status'] === 'completed') {
            // Traiter le paiement s'il ne l'est pas encore (cas du local ou IPN lent)
            try {
                $this->handlePaymentSuccess($token, $paymentData);
            } catch (\Exception $e) {
                Log::error('PayDunya Success Redirect Processing Failed: ' . $e->getMessage());
            }

            $customData = $paymentData['custom_data'] ?? [];
            $type = $customData['type'] ?? 'marketplace_order';

            if ($type === 'marketplace_order') {
                $orderId = $customData['order_id'] ?? null;
                $orderIds = $customData['order_ids'] ?? [];
                
                $orders = Order::where('paydunya_token', $token)->get();
                if ($orders->isEmpty()) {
                    if (!empty($orderIds)) {
                        $orders = Order::whereIn('id', $orderIds)->get();
                    } elseif ($orderId) {
                        $orders = collect([Order::find($orderId)]);
                    }
                }

                // On vide le panier ici car c'est une session utilisateur
                app(\App\Services\CartService::class)->clear();

                return view('checkout.success', [
                    'orders' => $orders->load(['seller', 'items.annonce', 'items.variante']),
                    'gestionPaiement' => 'commande'
                ]);
            } elseif ($type === 'seller_subscription') {
                return redirect()->route('vendeur.show')
                    ->with('success', 'Votre abonnement a été activé avec succès ! Bienvenue dans votre nouvelle offre.');
            } elseif ($type === 'credit_pack_purchase') {
                return redirect()->route('account.credits.index')
                    ->with('success', 'Votre compte a bien été crédité.');
            } elseif ($type === 'gift_card_purchase') {
                return redirect()->route('gift-cards.index')
                    ->with('success', "Paiement réussi ! Votre carte cadeau a été générée.");
            }
        }

        return redirect()->route('home')->with('error', 'Paiement non confirmé.');
    }

    /**
     * Retour annulation
     */
    public function cancel()
    {
        return redirect()->route('checkout.step2')->with('error', 'Paiement annulé.');
    }

    /**
     * Callback IPN (Push Notification de PayDunya)
     */
    public function callback(Request $request)
    {
        $data = $request->all();
        Log::info('PayDunya IPN Received', $data);

        $token = $data['token'] ?? null;
        if (!$token)
            return response('No token', 400);

        $paymentData = $this->payDunyaService->verifyPayment($token);

        if ($paymentData && $paymentData['status'] === 'completed') {
            try {
                $this->handlePaymentSuccess($token, $paymentData);
                return response('OK', 200);
            } catch (\Exception $e) {
                Log::error('PayDunya Callback Processing Failed: ' . $e->getMessage());
                return response('Error', 500);
            }
        }

        return response('Invalid status', 400);
    }

    /**
     * Traitement unifié et idempotent de la réussite d'un paiement
     */
    private function handlePaymentSuccess(string $token, array $paymentData)
    {
        $customData = $paymentData['custom_data'] ?? [];
        $type = $customData['type'] ?? null;

        DB::beginTransaction();
        try {
            if ($type === 'marketplace_order') {
                // Idempotence : vérifier si une transaction existe déjà
                if (Transaction::where('reference_externe', $token)->exists()) {
                    DB::rollBack();
                    return;
                }

                $orderId = $customData['order_id'] ?? null;
                $orderIds = $customData['order_ids'] ?? [];
                
                $orders = Order::where('paydunya_token', $token)->get();
                if ($orders->isEmpty()) {
                    if (!empty($orderIds)) {
                        $orders = Order::whereIn('id', $orderIds)->get();
                    } elseif ($orderId) {
                        $orders = collect([Order::find($orderId)]);
                    }
                }
                
                if ($orders->isEmpty()) {
                    DB::rollBack();
                    return;
                }

                foreach ($orders as $order) {
                    if ($order && $order->statut === 'en_attente') {
                        $order->update([
                            'statut' => 'paye',
                            'paydunya_receipt_url' => $paymentData['response_text'] ?? null
                        ]);
                        $this->logisticsService->generateLogisticsTokens($order);
                        Transaction::create([
                            'order_id' => $order->id,
                            'user_id' => $order->user_id, // L'acheteur pour ses achats
                            'reference_externe' => $token,
                            'montant' => $order->total_final, 
                            'moyen_paiement' => 'paydunya',
                            'statut' => 'succes',
                            'wallet_status' => 'none', // Pas de wallet pour l'acheteur, juste historique
                            'metadata' => ['paydunya_token' => $token]
                        ]);

                        // Création de la transaction en attente pour le Vendeur (Revenus)
                        if ($order->seller && $order->seller->user_id) {
                            $revenuVendeur = $order->total_produits - ($order->commission_plateforme ?? 0);
                            Transaction::create([
                                'order_id' => $order->id,
                                'user_id' => $order->seller->user_id, // Le vendeur reçoit l'argent
                                'reference_externe' => 'REV-' . $order->reference,
                                'montant' => $revenuVendeur,
                                'moyen_paiement' => 'wallet',
                                'statut' => 'succes',
                                'wallet_status' => 'pending', // En séquestre jusqu'à livraison
                                'release_at' => now()->addDays(30), // Sécurité par défaut
                                'metadata' => [
                                    'type' => 'seller_revenue',
                                    'order_ref' => $order->reference
                                ]
                            ]);
                        }
                    }
                }

                // Gérer la déduction de la carte cadeau si présente
                if (isset($customData['gift_card_id']) && isset($customData['gift_card_amount'])) {
                    $giftCard = \App\Models\GiftCard::find($customData['gift_card_id']);
                    if ($giftCard && $giftCard->status === 'active') {
                        $giftCard->decrement('balance', $customData['gift_card_amount']);
                        if ($giftCard->balance <= 0) {
                            $giftCard->update(['status' => 'used', 'redeemed_at' => now()]);
                        }
                    }
                }
            } elseif ($type === 'seller_subscription') {
                // Idempotence : vérifier si l'abonnement a déjà été créé/mis à jour
                // Les abonnements ont le token dans les métadonnées
                if (\App\Models\VendeurAbonnement::where('metadata->paydunya_token', $token)->exists()) {
                    DB::rollBack();
                    return;
                }

                $vendeurId = $customData['vendeur_id'];
                $planId = $customData['plan_id'];
                $vendeur = \App\Models\Vendeur::find($vendeurId);
                $abonnement = \App\Models\Abonnement::find($planId);

                if ($vendeur && $abonnement) {
                    \App\Models\VendeurAbonnement::where('vendeur_id', $vendeur->id)->update(['actif' => false]);
                    \App\Models\VendeurAbonnement::create([
                        'vendeur_id' => $vendeur->id,
                        'abonnement_id' => $abonnement->id,
                        'date_debut' => \Carbon\Carbon::today(),
                        'date_fin' => \Carbon\Carbon::today()->addMonth(),
                        'actif' => true,
                        'renouvellement_automatique' => true,
                        'nombre_annonces_utilisees' => 0,
                        'metadata' => ['paydunya_token' => $token]
                    ]);
                }
            } elseif ($type === 'credit_pack_purchase') {
                // Idempotence : CreditTransaction utilise le token comme reference
                if (\App\Models\CreditTransaction::where('reference', $token)->exists()) {
                    DB::rollBack();
                    return;
                }

                $userId = $customData['user_id'];
                $packId = $customData['pack_id'];
                $user = \App\Models\User::find($userId);
                $pack = \App\Models\CreditPack::find($packId);

                if ($user && $pack) {
                    $creditService = app(\App\Services\CreditService::class);
                    $creditService->acheter($user, $pack, $token);
                }
            } elseif ($type === 'gift_card_purchase') {
                // Idempotence
                if (\App\Models\GiftCard::where('metadata->paydunya_token', $token)->exists()) {
                    DB::rollBack();
                    return;
                }

                $userId = $customData['user_id'];
                $amount = $customData['amount'];
                $user = \App\Models\User::find($userId);

                if ($user) {
                    $giftCard = \App\Models\GiftCard::create([
                        'code' => \App\Models\GiftCard::generateCode(),
                        'amount' => $amount,
                        'balance' => $amount,
                        'status' => 'active',
                        'buyer_id' => $user->id,
                        'expiry_date' => now()->addYear(),
                        'metadata' => ['paydunya_token' => $token]
                    ]);

                    // Créer une transaction de crédit pour l'historique (montant 0 crédits car c'est un achat externe)
                    \App\Models\CreditTransaction::create([
                        'user_id' => $user->id,
                        'type' => 'gift_card_purchase',
                        'montant' => 0,
                        'description' => "Achat de carte cadeau : " . number_format($amount, 0, ',', ' ') . " FCFA",
                        'reference' => $token,
                        'related_type' => \App\Models\GiftCard::class,
                        'related_id' => $giftCard->id,
                    ]);

                    // Envoyer l'email de confirmation avec le code de la carte
                    try {
                        Mail::to($user->email)->send(new GiftCardPurchased($user, $giftCard));
                    } catch (\Exception $mailException) {
                        Log::error('Gift card email failed: ' . $mailException->getMessage());
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
