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

    public function __construct(CartService $cartService, LogisticsService $logisticsService)
    {
        $this->cartService = $cartService;
        $this->logisticsService = $logisticsService;
        // Middleware handled in routes/web.php in Laravel 11
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

        return view('checkout.step1', compact('cartGrouped', 'subtotal', 'user'));
    }

    /**
     * Valider l'étape 1 et passer au paiement
     */
    public function postStep1(Request $request)
    {
        $request->validate([
            'adresse_livraison' => 'required|string|max:500',
            'mode_livraison' => 'required|in:domicile,point_relais'
        ]);

        session([
            'checkout_adresse' => $request->adresse_livraison,
            'checkout_mode' => $request->mode_livraison
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
        
        return view('checkout.step2', compact('subtotal'));
    }

    /**
     * Étape 3 : Traitement du paiement et création des commandes
     */
    public function process(Request $request)
    {
        $request->validate([
            'moyen_paiement' => 'required|in:om,momo,cb,paypal'
        ]);

        $cartGrouped = $this->cartService->getContentGroupedBySeller();
        if ($cartGrouped->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $adresse = session('checkout_adresse');
        $mode = session('checkout_mode');

        try {
            DB::beginTransaction();

            $orders = [];
            foreach ($cartGrouped as $vendeurId => $items) {
                // Calcul du total pour CE vendeur
                $totalProduits = $items->sum(function($item) {
                    return ($item->annonce->prix + ($item->variante ? $item->variante->prix_supplementaire : 0)) * $item->quantite;
                });

                $fraisPort = 0; 
                $totalFinal = $totalProduits + $fraisPort;
                $commission = $totalProduits * 0.15;

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'vendeur_id' => $vendeurId,
                    'reference' => 'MM-' . strtoupper(Str::random(8)),
                    'total_produits' => $totalProduits,
                    'frais_port' => $fraisPort,
                    'commission_plateforme' => $commission,
                    'total_final' => $totalFinal,
                    'statut' => 'en_attente', // En attente du paiement Stripe
                    'adresse_livraison' => $adresse,
                    'mode_livraison' => $mode,
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

            // Pour l'instant, on gère UNE session par tunnel d'achat même si plusieurs vendeurs (simplification)
            // Dans une version plus complexe, on ferait un total global ou des paiements séparés.
            // Ici on va créer une session Stripe pour le PREMIER order (ou le total si on veut regrouper)
            // Vu le code actuel qui crée plusieurs ordres, on va rediriger vers Stripe pour le TOTAL du panier.
            
            $totalPanier = collect($orders)->sum('total_final');
            $mainOrder = $orders[0]; // On utilise le premier pour la référence principale
            
            $stripeService = new \App\Services\StripeService();
            $session = $stripeService->createCheckoutSession($mainOrder, 
                route('checkout.success'), 
                route('checkout.step2')
            );

            // Associer l'ID de session à tous les ordres de cette transaction
            foreach($orders as $o) {
                $o->update(['stripe_session_id' => $session->id]);
            }

            DB::commit();

            return redirect($session->url);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue lors de l\'initialisation du paiement : ' . $e->getMessage());
        }
    }

    /**
     * Confirmation de commande
     */
    public function success()
    {
        return view('checkout.success');
    }
}
