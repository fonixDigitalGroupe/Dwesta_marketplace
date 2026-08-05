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

        $transactions = Transaction::whereIn('order_id', $deliveredOrderIds)
            ->where('wallet_status', Transaction::STATUS_PENDING)
            ->get();

        $count = 0;
        foreach ($transactions as $tx) {
            $tx->update([
                'wallet_status' => Transaction::STATUS_AVAILABLE,
                'release_at'    => now(),
            ]);
            if ($tx->user) {
                $tx->user->increment('credit_balance', $tx->montant);
            }
            $count++;
        }

        $this->info("{$count} transaction(s) libérée(s) (en séquestre → disponible) pour les commandes livrées.");

        return self::SUCCESS;
    }
}
