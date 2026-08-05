<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Console\Command;

class ReleaseDeliveredFunds extends Command
{
    protected $signature = 'wallet:release-delivered';
    protected $description = 'Rend disponibles les fonds vendeurs des commandes déjà livrées (plus en séquestre)';

    public function handle(): int
    {
        $deliveredOrderIds = Order::where('statut', Order::STATUT_LIVRE)->pluck('id');

        $count = Transaction::whereIn('order_id', $deliveredOrderIds)
            ->where('wallet_status', Transaction::STATUS_PENDING)
            ->update([
                'wallet_status' => Transaction::STATUS_AVAILABLE,
                'release_at'    => now(),
            ]);

        $this->info("{$count} transaction(s) libérée(s) (en séquestre → disponible) pour les commandes livrées.");

        return self::SUCCESS;
    }
}
