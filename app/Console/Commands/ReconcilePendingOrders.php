<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\StripeFulfillmentService;
use Illuminate\Console\Command;

class ReconcilePendingOrders extends Command
{
    protected $signature = 'orders:reconcile-pending {--hours=24}';

    protected $description = 'Vérifie auprès de Stripe les commandes en_attente récentes et les passe à payé si le paiement a bien été effectué (filet de sécurité si le webhook a été manqué).';

    public function handle(StripeFulfillmentService $fulfillment): int
    {
        $hours = (int) $this->option('hours');
        $since = now()->subHours($hours);

        $pending = Order::where('statut', 'en_attente')
            ->whereNotNull('stripe_session_id')
            ->where('created_at', '>=', $since)
            ->get();

        $confirmed = 0;

        foreach ($pending as $order) {
            try {
                if ($fulfillment->fulfillById($order->stripe_session_id)) {
                    $order->refresh();
                    if ($order->statut === 'paye') {
                        $confirmed++;
                    }
                }
            } catch (\Throwable $e) {
                // On ignore : sera retenté au prochain passage.
            }
        }

        $this->info("Commandes réconciliées (passées à payé) : {$confirmed} / {$pending->count()} vérifiées.");

        return self::SUCCESS;
    }
}
