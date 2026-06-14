<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Services\CartService;
use App\Services\LogisticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $logisticsService;
    protected $payDunyaService;

    public function __construct(CartService $cartService, LogisticsService $logisticsService, \App\Services\PayDunyaService $payDunyaService)
    {
        $this->cartService = $cartService;
        $this->logisticsService = $logisticsService;
        $this->payDunyaService = $payDunyaService;
    }

    /**
     * Étape 1 : Adresse de livraison & Récapitulatif
     */
    public function step1()
    {
        $cartGrouped = $this->cartService->getContentGroupedBySeller();
        if ($cartGrouped->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $subtotal = $this->cartService->getSubtotal();
        $user = Auth::user();

        // Check if any items require point relais
        $requiresPointRelais = false;
        foreach ($cartGrouped as $vendeurId => $items) {
            foreach ($items as $item) {
                if (($item->annonce->type_livraison ?? '') === 'retrait_point_relais') {
                    $requiresPointRelais = true;
                    break 2;
                }
            }
        }

        $pointRelais = $requiresPointRelais ? \App\Models\PointRelais::where('is_active', true)->get() : \App\Models\PointRelais::where('is_active', true)->get();
        $shippingRules = \App\Models\ShippingRule::active()->get();

        // Préparer les origines des vendeurs pour le calcul JS
        $sellerOrigins = [];
        foreach ($cartGrouped as $vendeurId => $items) {
            $vendeur = \App\Models\Vendeur::find($vendeurId);
            $sellerOrigins[$vendeurId] = $this->resolveCountryId($vendeur->user->pays ?? 'Sénégal');
        }
        $userCountryId = $this->resolveCountryId($user->pays ?? 'Sénégal');

        return view('checkout.step1', compact('cartGrouped', 'subtotal', 'user', 'requiresPointRelais', 'pointRelais', 'shippingRules', 'sellerOrigins', 'userCountryId'));
    }

    private function resolveCountryId(?string $countryName)
    {
        if (empty($countryName))
            return null;
        $c = \App\Models\Country::where('name', 'like', $countryName)
            ->orWhere('code', 'like', $countryName)
            ->first();
        return $c ? $c->id : null;
    }

    /**
     * Valider l'étape 1 et passer au paiement
     */
    public function postStep1(Request $request)
    {
        $request->validate([
            'adresse_livraison' => 'required_unless:mode_livraison,retrait_point_relais|string|max:500|nullable',
            'mode_livraison' => 'required|string',
            'point_relais_id' => 'required_if:mode_livraison,retrait_point_relais'
        ]);

        $adresse = $request->adresse_livraison;
        $shippingFee = 0;
        $destCountryName = Auth::user()->pays ?? 'Sénégal';
        $region = null;

        if ($request->mode_livraison === 'retrait_point_relais' && $request->filled('point_relais_id')) {
            $pr = \App\Models\PointRelais::find($request->point_relais_id);
            if ($pr) {
                $destCountryName = $pr->pays ?? 'Sénégal';
                $region = $pr->region;
                $ville = $pr->region ?? 'Dakar';
                $adresse = "Point Relais : " . $pr->nom . " - " . $pr->adresse . " (" . $ville . ")";
            }
        } else {
            $region = Auth::user()->ville;
        }

        $destCountryId = $this->resolveCountryId($destCountryName);

        // On calcule la somme des frais pour chaque vendeur du panier
        $cartGrouped = $this->cartService->getContentGroupedBySeller();
        $shippingFee = 0;

        foreach ($cartGrouped as $vendeurId => $items) {
            $vendeur = \App\Models\Vendeur::find($vendeurId);
            $sourceCountryId = $this->resolveCountryId($vendeur->user->pays ?? 'Sénégal');

            $rule = \App\Models\ShippingRule::active()
                ->where('delivery_type', $request->mode_livraison)
                ->where('source_country_id', $sourceCountryId)
                ->where('destination_country_id', $destCountryId)
                ->where(function ($q) use ($region) {
                    $q->where('zone_name', $region)
                        ->orWhereNull('zone_name')
                        ->orWhere('zone_name', '');
                })
                ->orderByRaw("CASE WHEN zone_name = ? THEN 0 ELSE 1 END", [$region])
                ->first();

            $shippingFee += $rule ? $rule->price : 0;
        }

        session([
            'checkout_adresse' => $adresse ?? 'Sur place / Non spécifié',
            'checkout_mode' => $request->mode_livraison,
            'checkout_point_relais_id' => ($request->mode_livraison === 'retrait_point_relais') ? $request->point_relais_id : null,
            'checkout_shipping_fee' => $shippingFee,
            'checkout_dest_country_id' => $destCountryId
        ]);

        return redirect()->route('checkout.step2');
    }

    /**
     * Étape 2 : Choix du mode de paiement
     */
    public function step2()
    {
        if (!session('checkout_adresse')) {
            return redirect()->route('checkout.step1');
        }

        $subtotal = $this->cartService->getSubtotal();
        $cartGrouped = $this->cartService->getContentGroupedBySeller();

        return view('checkout.step2', compact('subtotal', 'cartGrouped'));
    }

    /**
     * Endpoint pour le PSR Popup PayDunya
     * Crée une invoice et retourne le token + infos client en JSON
     */
    public function paydunyaToken(Request $request)
    {
        try {
            $cartGrouped = $this->cartService->getContentGroupedBySeller();
            if ($cartGrouped->isEmpty()) {
                return response()->json(['success' => false, 'error' => 'Panier vide'], 400);
            }

            $subtotal = $this->cartService->getSubtotal();
            $shippingFee = session('checkout_shipping_fee', 0);
            $total = $subtotal + $shippingFee;

            $moyenPaiement = $request->get('payment_method', 'card');
            $method = in_array($moyenPaiement, ['om', 'wave', 'free']) ? $moyenPaiement : null;

            $user = Auth::user();
            $phone = str_replace('+', '', $user->telephone ?? '');

            $session = $this->payDunyaService->createCheckoutSession(
                $total,
                'Commande Karnou',
                route('paydunya.success'),
                route('paydunya.cancel'),
                ['type' => 'marketplace_order'],
                $method,
                [
                    'name' => $user->name,
                    'first_name' => $user->prenom,
                    'last_name' => $user->nom,
                    'email' => $user->email,
                    'phone' => $phone,
                    'address' => $user->adresse,
                    'city' => $user->ville,
                    'state' => $user->region,
                    'zip_code' => $user->code_postal,
                ]
            );

            // Stocker le token en session pour onTerminate callback
            session(['paydunya_pending_token' => $session->token]);

            return response()->json([
                'success' => true,
                'token' => $session->token,
                'mode' => config('services.paydunya.mode') // 'live' or 'test'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Étape 3 : Traitement du paiement et création des commandes
     */
    public function process(Request $request)
    {
        // On accepte les données de livraison SI elles sont présentes (single page checkout)
        // Sinon on les prend de la session (anciennes étapes)
        if ($request->has('mode_livraison')) {
            $request->validate([
                'adresse_livraison' => 'required_unless:mode_livraison,retrait_point_relais|string|max:500|nullable',
                'mode_livraison' => 'required|string',
                'point_relais_id' => 'required_if:mode_livraison,retrait_point_relais'
            ]);

            $adresse = $request->adresse_livraison;
            $mode = $request->mode_livraison;
            $pointRelaisId = $request->point_relais_id;

            if ($mode === 'retrait_point_relais' && $pointRelaisId) {
                $pr = \App\Models\PointRelais::find($pointRelaisId);
                if ($pr) {
                    $ville = $pr->region ?? 'Dakar';
                    $adresse = "Point Relais : " . $pr->nom . " - " . $pr->adresse . " (" . $ville . ")";
                }
            }
        } else {
            $adresse = session('checkout_adresse');
            $mode = session('checkout_mode');
            $pointRelaisId = session('checkout_point_relais_id');
        }

        $request->validate([
            'gestion_paiement' => 'required|in:commande,livraison_buyer,livraison_receiver',
            'moyen_paiement' => 'nullable|in:om,momo,cb,card,paypal,wave,free,wallet,gift_card,cod',
            'phone_number' => 'required_if:moyen_paiement,om,wave,free|nullable|string'
        ]);

        $cartGrouped = $this->cartService->getContentGroupedBySeller();
        if ($cartGrouped->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $gestionPaiement = $request->gestion_paiement;
        $moyenPaiement = $request->moyen_paiement;
        if ($moyenPaiement === 'card') {
            $moyenPaiement = 'cb';
        }
        $giftCardCode = strtoupper(trim($request->applied_gift_card_code ?? ''));

        // Resolve applied gift card directly from POST data (more reliable than session)
        $resolvedGiftCard = null;
        if ($giftCardCode) {
            $resolvedGiftCard = \App\Models\GiftCard::where('code', $giftCardCode)
                ->where('status', 'active')
                ->where('balance', '>', 0)
                ->first();
        }

        // If gift card is present and no mobile payment selected, treat as gift_card payment
        if ($gestionPaiement === 'commande' && empty($moyenPaiement)) {
            $moyenPaiement = $resolvedGiftCard ? 'gift_card' : 'cb';
        }

        try {
            DB::beginTransaction();

            $orders = [];
            foreach ($cartGrouped as $vendeurId => $items) {
                // Calcul du total pour CE vendeur
                $totalProduits = $items->sum(function ($item) {
                    return ($item->annonce->prix + ($item->variante ? $item->variante->prix_supplementaire : 0)) * $item->quantite;
                });

                $vendeurModel = \App\Models\Vendeur::find($vendeurId);
                $sourceCountryId = $this->resolveCountryId($vendeurModel->user->pays ?? 'Sénégal');

                // Destination country
                if ($mode === 'retrait_point_relais' && isset($pr)) {
                    $destCountryName = $pr->pays ?? 'Sénégal';
                } else {
                    $destCountryName = Auth::user()->pays ?? 'Sénégal';
                }
                $destCountryId = $this->resolveCountryId($destCountryName);

                // On cherche la règle spécifique pour ce couple pays source / pays destination
                $rule = \App\Models\ShippingRule::active()
                    ->where('delivery_type', $mode)
                    ->where('source_country_id', $sourceCountryId)
                    ->where('destination_country_id', $destCountryId)
                    ->first();

                $fraisPort = $rule ? $rule->price : 0;
                $totalFinal = $totalProduits + $fraisPort;

                $tauxCommission = $vendeurModel && $vendeurModel->abonnementActuel ? $vendeurModel->abonnementActuel->commission : 15;
                $commission = $totalProduits * ($tauxCommission / 100);

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'vendeur_id' => $vendeurId,
                    'reference' => (string) random_int(100000000, 999999999),
                    'total_produits' => $totalProduits,
                    'frais_port' => $fraisPort,
                    'commission_plateforme' => $commission,
                    'total_final' => $totalFinal,
                    'statut' => 'en_attente',
                    'adresse_livraison' => $adresse,
                    'mode_livraison' => $mode,
                    'gestion_paiement' => $gestionPaiement,
                    'moyen_paiement' => $moyenPaiement,
                    'destination_point_relais_id' => $pointRelaisId,
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'annonce_id' => $item->annonce_id,
                        'annonce_variante_id' => $item->annonce_variante_id,
                        'quantite' => $item->quantite,
                        'prix_unitaire' => $item->annonce->prix + ($item->variante ? $item->variante->prix_supplementaire : 0),
                    ]);
                }

                $orders[] = $order;
            }

            // Store order refs and payment type in session for success page
            session([
                'last_order_refs' => collect($orders)->pluck('reference')->toArray(),
                'last_gestion_paiement' => $gestionPaiement,
            ]);

            if ($gestionPaiement === 'commande' && in_array($moyenPaiement, ['cb', 'om', 'wave', 'free', 'wallet', 'gift_card'])) {
                $totalCombined = collect($orders)->sum('total_final');
                
                // Calculate deduction from the resolved gift card (from POST data)
                $deduction = 0;
                if ($resolvedGiftCard) {
                    $deduction = min($totalCombined, $resolvedGiftCard->balance);
                }

                $remainingTotal = $totalCombined - $deduction;

                \Illuminate\Support\Facades\Log::info('Checkout Gift Card Debug', [
                    'gift_card_code' => $giftCardCode,
                    'resolved_gift_card_id' => $resolvedGiftCard?->id,
                    'total_combined' => $totalCombined,
                    'deduction' => $deduction,
                    'remaining_total' => $remainingTotal,
                    'moyen_paiement' => $moyenPaiement,
                ]);

                if ($remainingTotal > 0 && $moyenPaiement !== 'gift_card') {
                    // Normalize payment method for PayDunya (card -> cb)
                    $paymentMethod = in_array($moyenPaiement, ['gift_card', 'cb', 'card']) ? 'cb' : $moyenPaiement;
                    // If it's cb (hosted card), we pass null to allow all methods on hosted page, 
                    // unless we specifically want to restrict to card.
                    $payDunyaMethod = ($paymentMethod === 'cb') ? null : $paymentMethod;
                    
                    $phone = $request->phone_number;

                    $session = $this->payDunyaService->createCheckoutSession(
                        $remainingTotal,
                        $deduction > 0 ? "Commande Dwesta (Carte Cadeau: -{$deduction} FCFA)" : "Commande Dwesta",
                        route('paydunya.success'),
                        route('paydunya.cancel'),
                        [
                            'order_ids' => collect($orders)->pluck('id')->toArray(), 
                            'type' => 'marketplace_order',
                            'gift_card_id' => $resolvedGiftCard?->id,
                            'gift_card_amount' => $deduction
                        ],
                        $payDunyaMethod,
                        [
                            'name' => trim(Auth::user()->name ?: (Auth::user()->prenom . ' ' . Auth::user()->nom)),
                            'first_name' => Auth::user()->prenom,
                            'last_name' => Auth::user()->nom,
                            'email' => Auth::user()->email,
                            'phone' => preg_match('/^\+?221/', Auth::user()->telephone) 
                                ? (str_starts_with(Auth::user()->telephone, '+') ? Auth::user()->telephone : '+' . Auth::user()->telephone) 
                                : '+221' . ltrim(Auth::user()->telephone, '0'),
                            'address' => Auth::user()->adresse,
                            'city' => Auth::user()->ville,
                            'state' => Auth::user()->region,
                            'zip_code' => Auth::user()->code_postal,
                        ]
                    );

                    foreach ($orders as $o) {
                        $o->update(['paydunya_token' => $session->token]);
                    }

                    // On redirige vers la page de paiement personnalisée
                    DB::commit();

                    $redirectUrl = $session->url;
                    
                    // Si c'est du Mobile Money, on redirige vers notre page de paiement personnalisée
                    if ($phone && in_array($moyenPaiement, ['om', 'wave', 'free'])) {
                        $redirectUrl = route('checkout.pay', ['token' => $session->token]);
                    }

                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => true,
                            'redirect_url' => $redirectUrl,
                        ]);
                    }

                    return redirect($redirectUrl);
                } else {
                    // Fully paid by Gift Card!
                    foreach ($orders as $o) {
                        $o->update(['statut' => 'paye', 'moyen_paiement' => 'gift_card']);
                        $this->logisticsService->generateLogisticsTokens($o);
                    }

                    // Deduct from gift card balance
                    if ($resolvedGiftCard && $deduction > 0) {
                        $newBalance = $resolvedGiftCard->balance - $deduction;
                        $resolvedGiftCard->update([
                            'balance' => $newBalance,
                            'user_id' => Auth::id(),
                            'redeemed_at' => now(),
                            'status' => $newBalance <= 0 ? 'used' : 'active',
                        ]);
                    }

                    DB::commit();
                    session()->forget('applied_gift_card');
                    return redirect()->route('checkout.success');
                }
            }

            // Pour les paiements à la livraison, on confirme la commande avec statut "en attente de paiement"
            if (in_array($gestionPaiement, ['livraison_buyer', 'livraison_receiver'])) {
                foreach ($orders as $o) {
                    $o->update(['statut' => Order::STATUT_EN_ATTENTE]);
                }
            }

            DB::commit();
            return redirect()->route('checkout.success');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de la validation de la commande : ' . $e->getMessage());
        }
    }

    /**
     * Page de paiement personnalisée (Style Jumia/Amazon)
     */
    public function showPaymentPage($token)
    {
        $orders = Order::where('paydunya_token', $token)->get();
        
        if ($orders->isNotEmpty()) {
            $order = $orders->first();
            $total = $orders->sum('total_final');
            $moyenPaiement = $order->moyen_paiement;
            $description = "Commande Karnou #" . $order->reference;
        } else {
            // Tentative de récupération via PayDunya (ex: Carte cadeau)
            $paymentData = $this->payDunyaService->verifyPayment($token);
            if (!$paymentData) {
                return redirect()->route('home')->with('error', 'Session de paiement invalide.');
            }
            
            $total = $paymentData['invoice']['total_amount'];
            $customData = $paymentData['custom_data'] ?? [];
            $type = $customData['type'] ?? 'marketplace_order';
            
            // On essaie de retrouver le moyen de paiement via la session PayDunya
            // Note: En mode session standard, on ne le connaît pas forcément encore 
            // précisément sauf si on l'a forcé via channels
            $moyenPaiement = 'unknown';
            if (isset($paymentData['invoice']['channels'])) {
                $channels = $paymentData['invoice']['channels'];
                if (in_array('wave-senegal', $channels)) $moyenPaiement = 'wave';
                elseif (in_array('orange-money-senegal', $channels)) $moyenPaiement = 'om';
                elseif (in_array('free-money-senegal', $channels)) $moyenPaiement = 'free';
            }
            
            $description = $paymentData['invoice']['description'] ?? "Achat Karnou";
        }

        return view('checkout.pay', compact('total', 'moyenPaiement', 'token', 'description'));
    }

    /**
     * Traitement final du paiement SoftPay
     */
    public function processSoftPay(Request $request, $token)
    {
        $orders = Order::where('paydunya_token', $token)->get();
        
        if ($orders->isNotEmpty()) {
            $order = $orders->first();
            $moyenPaiement = $order->moyen_paiement;
            $buyer = $order->buyer;
        } else {
            $paymentData = $this->payDunyaService->verifyPayment($token);
            if (!$paymentData) {
                return response()->json(['success' => false, 'message' => 'Session invalide']);
            }
            
            $moyenPaiement = 'unknown';
            if (isset($paymentData['invoice']['channels'])) {
                $channels = $paymentData['invoice']['channels'];
                if (in_array('wave-senegal', $channels)) $moyenPaiement = 'wave';
                elseif (in_array('orange-money-senegal', $channels)) $moyenPaiement = 'om';
                elseif (in_array('free-money-senegal', $channels)) $moyenPaiement = 'free';
            }
            
            $buyer = Auth::user();
        }

        $phone = $request->phone_number ?: ($buyer?->telephone ?? '');
        
        $customerData = [
            'name' => trim($buyer?->name ?: ($buyer?->prenom . ' ' . $buyer?->nom)),
            'email' => $buyer?->email,
            'phone' => $phone
        ];

        try {
            $softPayResponse = $this->payDunyaService->softPay($token, $moyenPaiement, $customerData);
            
            if (isset($softPayResponse['success']) && $softPayResponse['success'] === true) {
                // Pour Wave et Orange Money, on donne l'URL de redirection
                if (isset($softPayResponse['url'])) {
                    return response()->json([
                        'success' => true,
                        'redirect_url' => $softPayResponse['url']
                    ]);
                }

                // Pour Free Money (Push USSD)
                $successUrl = route('checkout.success', ['info' => $softPayResponse['message'] ?? 'Demande envoyée']);
                
                // Si c'est une carte cadeau, on redirige vers gift-cards.index avec succès
                $paymentData = $paymentData ?? $this->payDunyaService->verifyPayment($token);
                if ($paymentData && ($paymentData['custom_data']['type'] ?? '') === 'gift_card_purchase') {
                    $successUrl = route('gift-cards.index', ['success' => 'Paiement initié. Votre carte sera générée après confirmation.']);
                }

                return response()->json([
                    'success' => true,
                    'redirect_url' => $successUrl
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $softPayResponse['message'] ?? 'Échec de l\'initiation du paiement'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur technique : ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Confirmation de commande
     */
    public function success()
    {
        // Récupérer les références des commandes pour la vue
        $orderRefs = session('last_order_refs', []);

        if (empty($orderRefs)) {
            return redirect()->route('home');
        }

        // Vider le panier après confirmation de commande (si pas déjà fait)
        $this->cartService->clear();

        $gestionPaiement = session('last_gestion_paiement', 'commande');

        // Récupérer les vrais objets Order pour l'affichage riche
        $orders = Order::whereIn('reference', $orderRefs)->with(['seller', 'items.annonce', 'items.variante'])->get();

        if ($orders->isEmpty()) {
            return redirect()->route('home');
        }

        // Nettoyer les données de session de checkout
        session()->forget(['checkout_adresse', 'checkout_mode', 'checkout_point_relais_id', 'last_order_refs', 'last_gestion_paiement']);

        return view('checkout.success', compact('orders', 'gestionPaiement'));
    }
}
