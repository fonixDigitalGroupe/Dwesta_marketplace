<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class DebugLastOrders extends Command
{
    protected $signature = 'orders:debug-last {--limit=10}';

    protected $description = 'Affiche les dernières commandes avec leur statut (diagnostic).';

    public function handle(): int
    {
        $orders = Order::latest()->take((int) $this->option('limit'))->get();

        if ($orders->isEmpty()) {
            $this->warn('Aucune commande en base.');
            return self::SUCCESS;
        }

        $this->table(
            ['ID', 'Réf', 'Vendeur', 'Statut', 'Gestion', 'Moyen', 'Stripe session', 'Créée'],
            $orders->map(fn (Order $o) => [
                $o->id,
                $o->reference,
                $o->vendeur_id,
                $o->statut,
                $o->gestion_paiement,
                $o->moyen_paiement,
                $o->stripe_session_id ? substr($o->stripe_session_id, 0, 18) . '…' : '—',
                (string) $o->created_at,
            ])->toArray()
        );

        return self::SUCCESS;
    }
}
