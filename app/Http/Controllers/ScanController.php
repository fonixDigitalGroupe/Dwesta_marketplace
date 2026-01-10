<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\LogisticsService;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    protected $logisticsService;

    public function __construct(LogisticsService $logisticsService)
    {
        $this->logisticsService = $logisticsService;
    }

    /**
     * Interface de scan pour le point relais
     */
    public function index()
    {
        return view('logistics.scan');
    }

    /**
     * Suivi de commande pour l'acheteur
     */
    public function track($reference)
    {
        $order = Order::where('reference', $reference)
                    ->with('items.annonce', 'seller.user')
                    ->firstOrFail();

        return view('logistics.track', compact('order'));
    }

    /**
     * Traiter le scan d'un jeton (QR Code ou Manuel)
     */
    public function process(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $token = $request->token;

        // Recherche de la commande par QR Token ou Tracking Token
        $order = Order::where('qr_code_token', $token)
                    ->orWhere('tracking_token', $token)
                    ->first();

        if (!$order) {
            return back()->with('error', 'Commande non trouvée pour ce jeton.');
        }

        // Logique de changement de statut basée sur le scan
        $message = "";
        $status = $order->statut;

        if ($status == 'paye' || $status == 'en_attente_depot') {
            $this->logisticsService->updateStatus($order, 'en_point_relais');
            $message = "Commande #{$order->reference} réceptionnée au point relais. Le vendeur a déposé le colis.";
        } elseif ($status == 'en_point_relais') {
            $this->logisticsService->updateStatus($order, 'receptionne');
            $message = "Commande #{$order->reference} remise à l'acheteur. Livraison terminée.";
        } else {
            return back()->with('info', "La commande #{$order->reference} est déjà au statut : " . $status);
        }

        return back()->with('success', $message);
    }
}
