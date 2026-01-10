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
        $this->middleware('auth');
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

                // Commission 15% (exemple)
                $commission = $totalProduits * 0.15;
                $fraisPort = 0; // À dynamiser plus tard
                $totalFinal = $totalProduits + $fraisPort;

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'vendeur_id' => $vendeurId,
                    'reference' => 'MM-' . strtoupper(Str::random(8)),
                    'total_produits' => $totalProduits,
                    'frais_port' => $fraisPort,
                    'commission_plateforme' => $commission,
                    'total_final' => $totalFinal,
                    'statut' => 'paye', // Simulé : on considère le paiement comme réussi
                    'adresse_livraison' => $adresse,
                    'mode_livraison' => $mode,
                ]);

                // Génération des tokens logistiques
                $this->logisticsService->generateLogisticsTokens($order);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'annonce_id' => $item->annonce_id,
                        'annonce_variante_id' => $item->annonce_variante_id,
                        'quantite' => $item->quantite,
                        'prix_unitaire' => $item->annonce->prix + ($item->variante ? $item->variante->prix_supplementaire : 0),
                    ]);
                }

                // Enregistrement de la transaction (une transaction par vendeur pour simplifier le séquestre)
                Transaction::create([
                    'order_id' => $order->id,
                    'user_id' => Auth::id(),
                    'reference_externe' => 'SIM-' . strtoupper(Str::random(12)),
                    'montant' => $totalFinal,
                    'moyen_paiement' => $request->moyen_paiement,
                    'statut' => 'succes',
                    'metadata' => ['mode' => 'simulation']
                ]);

                $orders[] = $order;
            }

            // Vider le panier
            $this->cartService->clear();
            
            // Nettoyage session checkout
            session()->forget(['checkout_adresse', 'checkout_mode']);

            DB::commit();

            return redirect()->route('checkout.success')->with('orders', $orders);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
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
