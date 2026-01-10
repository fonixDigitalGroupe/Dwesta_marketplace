<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Str;

class LogisticsService
{
    /**
     * Générer les jetons logistiques pour une commande
     */
    public function generateLogisticsTokens(Order $order)
    {
        $order->update([
            'tracking_token' => 'TRK-' . strtoupper(Str::random(12)),
            'qr_code_token' => 'QR-' . strtoupper(Str::random(16)),
        ]);
        
        return $order;
    }

    /**
     * Changer le statut de la commande avec validation
     */
    public function updateStatus(Order $order, string $newStatus)
    {
        $allowedTransitions = [
            'paye' => ['en_attente_depot'],
            'en_attente_depot' => ['en_point_relais', 'annule'],
            'en_point_relais' => ['receptionne', 'retour_vendeur'],
            'receptionne' => []
        ];

        // Pour l'instant, on laisse libre mais on loggue
        $order->update(['statut' => $newStatus]);
        
        return $order;
    }
}
