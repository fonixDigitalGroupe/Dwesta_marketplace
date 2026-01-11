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
        // Définition des transitions autorisées
        $allowedTransitions = [
            Order::STATUT_PAYE => [Order::STATUT_PRET, Order::STATUT_ANNULE],
            Order::STATUT_PRET => [Order::STATUT_EN_ROUTE, Order::STATUT_ANNULE],
            Order::STATUT_EN_ROUTE => [Order::STATUT_DISPONIBLE, Order::STATUT_LITIGE],
            Order::STATUT_DISPONIBLE => [Order::STATUT_LIVRE, Order::STATUT_LITIGE],
            Order::STATUT_LIVRE => [Order::STATUT_LITIGE],
        ];

        if (isset($allowedTransitions[$order->statut]) && !in_array($newStatus, $allowedTransitions[$order->statut])) {
            throw new \Exception("Transition de statut non autorisée de {$order->statut} vers {$newStatus}");
        }

        $order->update(['statut' => $newStatus]);
        
        return $order;
    }
}
