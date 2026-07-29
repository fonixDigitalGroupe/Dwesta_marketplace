<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;
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
    protected $stripeService;

    public function __construct(CartService $cartService, LogisticsService $logisticsService, \App\Services\StripeService $stripeService)
    {
        $this->cartService = $cartService;
        $this->logisticsService = $logisticsService;
        $this->stripeService = $stripeService;
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

        // Profil incomplet → on bloque la commande et on renvoie vers le profil.
        $manquants = Auth::user()->champsProfilManquants();
        if (!empty($manquants)) {
            return redirect()->route('profile.show')
                ->with('error', 'Veuillez compléter votre profil avant de commander. Informations manquantes : ' . implode(', ', $manquants) . '.');
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
        $sellerRegions = [];
        $sellerPaliers = [];
        foreach ($cartGrouped as $vendeurId => $items) {
            $vendeur = \App\Models\Vendeur::find($vendeurId);
            $sellerOrigins[$vendeurId] = $this->resolveCountryId($vendeur->user->pays ?? 'Sénégal');
            $sellerRegions[$vendeurId] = $vendeur->user->region ?? null;
            // Palier d'expédition du vendeur = le plus lourd parmi ses articles
            $sellerPaliers[$vendeurId] = $this->palierLePlusLourd($items);
        }
        $userCountryId = $this->resolveCountryId($user->pays ?? 'Sénégal');
        $userRegion = $user->region ?: $user->ville;

        // Tarifs inter-régions (même pays) indexés par "country_id|delivery_type|palier"
        // (palier = 'tous' quand la règle s'applique à tous les poids)
        $interRegionTariffs = \App\Models\InterRegionTariff::where('is_active', true)
            ->get()
            ->mapWithKeys(fn($t) => [
                $t->country_id . '|' . $t->delivery_type . '|' . ($t->poids_palier ?: 'tous') => [
                    'same' => (float) $t->same_region_price,
                    'inter' => (float) $t->inter_region_price,
                    'delay' => $t->delivery_delay,
                ],
            ]);

        return view('checkout.step1', compact('cartGrouped', 'subtotal', 'user', 'requiresPointRelais', 'pointRelais', 'shippingRules', 'sellerOrigins', 'userCountryId', 'sellerRegions', 'userRegion', 'interRegionTariffs', 'sellerPaliers'));
    }

    /** Ordre de "lourdeur" des paliers. */
    private const PALIER_ORDRE = ['petit' => 1, 'moyen' => 2, 'volumineux' => 3, 'lourd' => 4];

    /** Renvoie le palier le plus lourd parmi les articles (null si aucun). */
    private function palierLePlusLourd($items): ?string
    {
        $max = null; $maxRang = 0;
        foreach ($items as $item) {
            $p = $item->annonce->poids_palier ?? null;
            $rang = self::PALIER_ORDRE[$p] ?? 0;
            if ($rang > $maxRang) { $maxRang = $rang; $max = $p; }
        }
        return $max;
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
     * Calcule les frais de livraison pour un vendeur donné, selon les paramètres
     * de /admin/shipping :
     *  - même pays  : tarif inter-régions (même région vs régions différentes)
     *  - pays diff. : règle pays → pays (ShippingRule)
     */
    private function computeShippingFeeForVendeur($vendeur, string $mode, ?int $destCountryId, ?string $destRegion, ?string $palier = null): float
    {
        if (!$vendeur) {
            return 0;
        }
        $sourceCountryId = $this->resolveCountryId(optional($vendeur->user)->pays ?? 'Sénégal');
        $sourceRegion = optional($vendeur->user)->region;

        // Même pays → on s'appuie sur le tarif inter-régions configuré par l'admin.
        if ($destCountryId && $sourceCountryId && (int) $destCountryId === (int) $sourceCountryId) {
            $tarif = \App\Models\InterRegionTariff::where('country_id', $destCountryId)
                ->where('delivery_type', $mode)
                ->where('is_active', true)
                ->where(function ($q) use ($palier) {
                    $q->whereNull('poids_palier');
                    if ($palier) {
                        $q->orWhere('poids_palier', $palier);
                    }
                })
                ->orderByRaw("CASE WHEN poids_palier = ? THEN 0 ELSE 1 END", [$palier])
                ->first();

            if ($tarif) {
                $sameRegion = $sourceRegion && $destRegion
                    && mb_strtolower(trim($sourceRegion)) === mb_strtolower(trim($destRegion));

                return (float) ($sameRegion ? $tarif->same_region_price : $tarif->inter_region_price);
            }
            // Pas de tarif inter-régions défini → on retombe sur la règle pays → pays.
        }

        // Pays différents (ou pas de tarif national) → règle pays → pays.
        // On privilégie la règle du palier de poids exact, puis la règle "tous poids" (null).
        $rule = \App\Models\ShippingRule::active()
            ->where('delivery_type', $mode)
            ->where('source_country_id', $sourceCountryId)
            ->where('destination_country_id', $destCountryId)
            ->where(function ($q) use ($destRegion) {
                $q->where('zone_name', $destRegion)
                    ->orWhereNull('zone_name')
                    ->orWhere('zone_name', '');
            })
            ->where(function ($q) use ($palier) {
                $q->whereNull('poids_palier');
                if ($palier) {
                    $q->orWhere('poids_palier', $palier);
                }
            })
            ->orderByRaw("CASE WHEN poids_palier = ? THEN 0 ELSE 1 END", [$palier])
            ->orderByRaw("CASE WHEN zone_name = ? THEN 0 ELSE 1 END", [$destRegion])
            ->first();

        return $rule ? (float) $rule->price : 0;
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
            // Région de l'acheteur (pour le calcul inter-régions national)
            $region = Auth::user()->region ?: Auth::user()->ville;
        }

        $destCountryId = $this->resolveCountryId($destCountryName);

        // On calcule la somme des frais pour chaque vendeur du panier.
        // Le tarif dépend du palier de poids le plus lourd des articles du vendeur.
        $cartGrouped = $this->cartService->getContentGroupedBySeller();
        $shippingFee = 0;

        foreach ($cartGrouped as $vendeurId => $items) {
            $vendeur = \App\Models\Vendeur::find($vendeurId);
            if (!$vendeur) {
                continue;
            }
            $palier = $this->palierLePlusLourd($items);
            $shippingFee += $this->computeShippingFeeForVendeur($vendeur, $request->mode_livraison, $destCountryId, $region, $palier);
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
            // Le téléphone n'est plus requis : tous les paiements passent par Stripe (carte).
            'phone_number' => 'nullable|string'
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
                    return ($item->annonce->prix_affiche + ($item->variante ? $item->variante->prix_supplementaire : 0)) * $item->quantite;
                });

                $vendeurModel = \App\Models\Vendeur::find($vendeurId);

                // Destination country + région
                if ($mode === 'retrait_point_relais' && isset($pr)) {
                    $destCountryName = $pr->pays ?? 'Sénégal';
                    $destRegion = $pr->region;
                } else {
                    $destCountryName = Auth::user()->pays ?? 'Sénégal';
                    $destRegion = Auth::user()->region ?: Auth::user()->ville;
                }
                $destCountryId = $this->resolveCountryId($destCountryName);

                // Frais selon /admin/shipping : inter-régions (même pays) ou pays → pays.
                $fraisPort = $this->computeShippingFeeForVendeur($vendeurModel, $mode, $destCountryId, $destRegion, $this->palierLePlusLourd($items));
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
                        'prix_unitaire' => $item->annonce->prix_affiche + ($item->variante ? $item->variante->prix_supplementaire : 0),
                    ]);
                }

                $orders[] = $order;

                // --- Notification vendeur dans la boîte de réception ---
                try {
                    $karnouUser = User::where('email', 'karnou@karnou.fr')->first()
                        ?? User::find(1);

                    if ($karnouUser && $vendeurModel && $vendeurModel->user_id) {
                        $vendeurUserId = $vendeurModel->user_id;

                        // Trouver ou créer une conversation Karnou <-> Vendeur
                        $conversation = Conversation::where(function ($q) use ($karnouUser, $vendeurUserId) {
                            $q->where('user1_id', $karnouUser->id)->where('user2_id', $vendeurUserId);
                        })->orWhere(function ($q) use ($karnouUser, $vendeurUserId) {
                            $q->where('user1_id', $vendeurUserId)->where('user2_id', $karnouUser->id);
                        })->first();

                        if (!$conversation) {
                            $conversation = Conversation::create([
                                'user1_id' => $karnouUser->id,
                                'user2_id' => $vendeurUserId,
                                'annonce_id' => null,
                                'last_message_at' => now(),
                            ]);
                        } else {
                            $conversation->update(['last_message_at' => now()]);
                        }

                        // Construire le message de notification
                        $buyer = Auth::user();
                        $buyerName = trim(($buyer->prenom ?? '') . ' ' . ($buyer->nom ?? '')) ?: $buyer->name;
                        $itemsList = $items->map(fn($i) => '• ' . $i->annonce->titre . ' (x' . $i->quantite . ')')->implode("\n");
                        $modePaiementLabel = match ($moyenPaiement) {
                            'om' => 'Orange Money',
                            'wave' => 'Wave',
                            'free' => 'Free Money',
                            'cod' => 'Paiement à la livraison',
                            default => 'Carte / Autre',
                        };
                        $content = "🛍️ Nouvelle commande reçue !\n"
                            . "Référence : #{$order->reference}\n"
                            . "Client : {$buyerName}\n"
                            . "Articles commandés :\n{$itemsList}\n"
                            . "Total : " . number_format($order->total_final, 0, ',', ' ') . " FCFA\n"
                            . "Mode de paiement : {$modePaiementLabel}\n"
                            . "Adresse de livraison : {$order->adresse_livraison}";

                        Message::create([
                            'conversation_id' => $conversation->id,
                            'sender_id' => $karnouUser->id,
                            'content' => $content,
                        ]);
                    }
                } catch (\Exception $notifEx) {
                    // Ne jamais bloquer la commande à cause de la notification
                    \Illuminate\Support\Facades\Log::warning('Notification vendeur échouée', ['error' => $notifEx->getMessage()]);
                }

                // --- Code de validation livraison domicile (4 chiffres) ---
                if ($mode === 'livraison_domicile') {
                    try {
                        $codeLivraison = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
                        $order->update(['code_livraison' => $codeLivraison]);

                        $karnouUser = $karnouUser ?? (User::where('email', 'karnou@karnou.fr')->first() ?? User::find(1));
                        $buyerUser = Auth::user();

                        if ($karnouUser && $buyerUser) {
                            // Trouver ou créer une conversation Karnou <-> Acheteur
                            $buyerConv = Conversation::where(function ($q) use ($karnouUser, $buyerUser) {
                                $q->where('user1_id', $karnouUser->id)->where('user2_id', $buyerUser->id);
                            })->orWhere(function ($q) use ($karnouUser, $buyerUser) {
                                $q->where('user1_id', $buyerUser->id)->where('user2_id', $karnouUser->id);
                            })->first();

                            if (!$buyerConv) {
                                $buyerConv = Conversation::create([
                                    'user1_id' => $karnouUser->id,
                                    'user2_id' => $buyerUser->id,
                                    'annonce_id' => null,
                                    'last_message_at' => now(),
                                ]);
                            } else {
                                $buyerConv->update(['last_message_at' => now()]);
                            }

                            $msgClient = "📦 Votre commande #{$order->reference} a bien été enregistrée !\n\n"
                                . "🔑 Votre code de confirmation de livraison : **{$codeLivraison}**\n\n"
                                . "Communiquez ce code au livreur uniquement au moment de la remise de votre colis. "
                                . "Il servira à valider la livraison.\n\n"
                                . "Adresse de livraison : {$order->adresse_livraison}\n"
                                . "Total : " . number_format($order->total_final, 0, ',', ' ') . " FCFA\n\n"
                                . "Merci pour votre confiance — L'équipe Karnou";

                            Message::create([
                                'conversation_id' => $buyerConv->id,
                                'sender_id' => $karnouUser->id,
                                'content' => $msgClient,
                            ]);
                        }
                    } catch (\Exception $codeEx) {
                        \Illuminate\Support\Facades\Log::warning('Code livraison échoué', ['error' => $codeEx->getMessage()]);
                    }
                }
            }

            // Store order refs and payment type in session for success page
            session([
                'last_order_refs' => collect($orders)->pluck('reference')->toArray(),
                'last_gestion_paiement' => $gestionPaiement,
            ]);

            // La commande est créée : on vide le panier dès maintenant (toutes méthodes).
            $this->cartService->clear();

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
                    // ===== Tous les moyens de paiement passent par Stripe. =====
                    $stripeSession = $this->stripeService->createMarketplaceSession(
                        $remainingTotal,
                        route('checkout.success'),
                        route('cart.index'),
                        Auth::user()->email,
                        [
                            'order_ids' => implode(',', collect($orders)->pluck('id')->toArray()),
                            'gift_card_id' => $resolvedGiftCard?->id,
                            'gift_card_amount' => $deduction > 0 ? (int) $deduction : null,
                        ],
                        trim(Auth::user()->name ?: (Auth::user()->prenom . ' ' . Auth::user()->nom)) ?: null
                    );

                    foreach ($orders as $o) {
                        $o->update(['stripe_session_id' => $stripeSession->id]);
                    }

                    DB::commit();

                    if ($request->expectsJson()) {
                        return response()->json(['success' => true, 'redirect_url' => $stripeSession->url]);
                    }
                    return redirect($stripeSession->url);
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

        } catch (\Throwable $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Checkout process ÉCHEC', [
                'message' => $e->getMessage(),
                'exception' => get_class($e),
                'file' => $e->getFile() . ':' . $e->getLine(),
            ]);
            return back()->with('error', 'Une erreur est survenue lors de la validation de la commande : ' . $e->getMessage());
        }
    }

    /**
     * Confirmation de commande
     */
    public function success(Request $request)
    {
        // Filet de sécurité : si le webhook n'a pas encore validé le paiement,
        // on vérifie la session Stripe et on finalise (idempotent).
        app(\App\Services\StripeFulfillmentService::class)->fulfillById($request->query('session_id'));

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
