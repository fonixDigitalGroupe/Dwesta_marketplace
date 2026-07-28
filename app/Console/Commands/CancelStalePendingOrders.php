<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\StripeFulfillmentService;
use Illuminate\Console\Command;

class CancelStalePendingOrders extends Command
{
    protected $signature = 'orders:cancel-stale {--hours=24}';

    protected $description = 'Annule les commandes en_attente (paiement Stripe non confirmé) plus vieilles que N heures';

    public function handle(StripeFulfillmentService $fulfillment): int
    {
        $hours = (int) $this->option('hours');
        $cutoff = now()->subHours($hours);

        $stale = Order::where('statut', 'en_attente')
            ->where('created_at', '<', $cutoff)
            ->get();

        $cancelled = 0;
        $rescued = 0;

        foreach ($stale as $order) {
            // Dernière chance : si la session Stripe a en fait été payée
            // (webhook manqué), on finalise au lieu d'annuler.
            if ($order->stripe_session_id) {
                try {
                    if ($fulfillment->fulfillById($order->stripe_session_id)) {
                        $order->refresh();
                        $rescued++;
                    }
                } catch (\Throwable $e) {
                    // On ignore et on tentera l'annulation ci-dessous.
                }
            }

            if ($order->statut === 'en_attente') {
                $order->update(['statut' => Order::STATUT_ANNULE]);
                $cancelled++;
            }
        }

        $this->info("Commandes annulées : {$cancelled} — récupérées (payées) : {$rescued} (seuil : {$hours}h).");

        return self::SUCCESS;
    }
}
