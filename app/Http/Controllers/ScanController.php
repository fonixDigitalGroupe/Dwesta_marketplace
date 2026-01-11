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

        // 1. Essayer de trouver par Tracking Token (Colis physique)
        $orderByTracking = Order::where('tracking_token', $token)->first();

        // 2. Essayer de trouver par QR Token (Preuve de retrait client)
        $orderByQR = Order::where('qr_code_token', $token)->first();

        $order = $orderByTracking ?? $orderByQR;

        if (!$order) {
            return back()->with('error', 'Commande non trouvée pour ce jeton.');
        }

        $message = "";
        $status = $order->statut;
        $newStatus = null;

        try {
            if ($orderByTracking) {
                // C'est un scan de COLIS (par Transporteur ou Relais)
                if ($status == Order::STATUT_PRET) {
                    $newStatus = Order::STATUT_EN_ROUTE;
                    $message = "📦 Ramassage réussi ! Le colis est désormais 'En cours de livraison'.";
                } elseif ($status == Order::STATUT_EN_ROUTE) {
                    $newStatus = Order::STATUT_DISPONIBLE;
                    $message = "📍 Réception en relais réussie ! Le colis est 'Disponible' pour le client.";
                } else {
                    return back()->with('info', "Scan Tracking : La commande est déjà en statut '{$order->statut_label}'.");
                }
            } elseif ($orderByQR) {
                // C'est un scan de CLIENT (par Relais pour remise)
                if ($status == Order::STATUT_DISPONIBLE) {
                    $newStatus = Order::STATUT_LIVRE;
                    $message = "✅ Livraison confirmée ! Le colis a été remis au client.";
                } else {
                    return back()->with('error', "Scan Client : Impossible de livrer un colis qui n'est pas encore 'Disponible' (Statut actuel : {$order->statut_label}).");
                }
            }

            if ($newStatus) {
                $this->logisticsService->updateStatus($order, $newStatus);
                return back()->with('success', $message);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur de transition : ' . $e->getMessage());
        }

        return back()->with('warning', "Aucune action effectuée.");
    }
}
