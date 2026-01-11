<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nettoyage
        Schema::disableForeignKeyConstraints();
        Transaction::truncate();
        Schema::enableForeignKeyConstraints();

        $orders = Order::whereIn('statut', [
            Order::STATUT_PAYE,
            Order::STATUT_PRET,
            Order::STATUT_EN_ROUTE,
            Order::STATUT_DISPONIBLE,
            Order::STATUT_LIVRE,
        ])->get();

        if ($orders->isEmpty()) {
            $this->command->warn('Aucune commande payée trouvée.');
            return;
        }

        $moyensPaiement = ['carte_bancaire', 'mobile_money', 'orange_money', 'moov_money'];

        foreach ($orders as $order) {
            // Transaction principale (paiement de la commande)
            $moyen = $moyensPaiement[array_rand($moyensPaiement)];
            
            Transaction::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'reference_externe' => 'TXN-' . strtoupper(Str::random(12)),
                'montant' => $order->total_final,
                'moyen_paiement' => $moyen,
                'statut' => 'completed',
                'wallet_status' => $order->statut == Order::STATUT_LIVRE ? 'released' : 'held',
                'release_at' => $order->statut == Order::STATUT_LIVRE ? now()->subDays(rand(1, 7)) : null,
                'metadata' => [
                    'payment_method' => $moyen,
                    'payment_date' => now()->subDays(rand(1, 30))->toDateTimeString(),
                    'commission' => $order->commission_plateforme,
                ],
                'created_at' => $order->created_at->addMinutes(rand(5, 30)),
            ]);
        }

        // Créer quelques transactions échouées
        $ordersEnAttente = Order::where('statut', Order::STATUT_EN_ATTENTE)
            ->limit(3)
            ->get();

        foreach ($ordersEnAttente as $order) {
            Transaction::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'reference_externe' => 'TXN-' . strtoupper(Str::random(12)),
                'montant' => $order->total_final,
                'moyen_paiement' => $moyensPaiement[array_rand($moyensPaiement)],
                'statut' => 'failed',
                'wallet_status' => null,
                'metadata' => [
                    'error' => 'Insufficient funds',
                    'attempt_date' => now()->subDays(rand(1, 10))->toDateTimeString(),
                ],
                'created_at' => $order->created_at->addMinutes(rand(5, 30)),
            ]);
        }

        $this->command->info('✓ Transactions créées pour les commandes payées et quelques échecs');
    }
}
