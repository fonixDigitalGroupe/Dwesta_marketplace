<?php

namespace Database\Seeders;

use App\Models\Litige;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LitigeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nettoyage
        Schema::disableForeignKeyConstraints();
        Litige::truncate();
        Schema::enableForeignKeyConstraints();

        $orders = Order::whereIn('statut', [
            Order::STATUT_LIVRE,
            Order::STATUT_EN_ROUTE,
            Order::STATUT_DISPONIBLE,
        ])->limit(5)->get();

        $admin = User::whereHas('roles', function ($query) {
            $query->where('name', 'admin');
        })->first();

        if ($orders->isEmpty()) {
            $this->command->warn('Pas assez de commandes pour créer des litiges.');
            return;
        }

        $motifs = [
            'Produit non conforme à la description',
            'Produit endommagé à la livraison',
            'Produit jamais reçu',
            'Mauvaise qualité du produit',
            'Vendeur non joignable',
        ];

        $descriptions = [
            'Le produit reçu ne correspond pas du tout aux photos de l\'annonce.',
            'Le colis est arrivé endommagé, le produit est cassé.',
            'Je n\'ai jamais reçu ma commande malgré le statut "livré".',
            'La qualité est vraiment médiocre, ce n\'est pas ce qui était promis.',
            'Le vendeur ne répond plus à mes messages depuis la livraison.',
        ];

        // Créer 5 litiges avec différents statuts
        foreach ($orders as $index => $order) {
            $statut = match($index) {
                0 => 'ouvert',
                1 => 'en_cours',
                2 => 'resolu_acheteur',
                3 => 'resolu_vendeur',
                4 => 'resolu_partage',
            };

            $litige = Litige::create([
                'order_id' => $order->id,
                'initiateur_id' => $order->user_id,
                'motif' => $motifs[$index],
                'description' => $descriptions[$index],
                'statut' => $statut,
                'decision_admin' => $statut != 'ouvert' && $statut != 'en_cours' ? 'Après examen des preuves, décision prise en faveur de ' . ($statut == 'resolu_acheteur' ? 'l\'acheteur' : ($statut == 'resolu_vendeur' ? 'le vendeur' : 'partage 50/50')) : null,
                'traite_par' => $statut != 'ouvert' ? $admin?->id : null,
                'traite_le' => $statut != 'ouvert' ? now()->subDays(rand(1, 10)) : null,
                'created_at' => now()->subDays(rand(5, 20)),
            ]);

            // Mettre à jour le statut de la commande si litige ouvert
            if ($statut == 'ouvert' || $statut == 'en_cours') {
                $order->update(['statut' => Order::STATUT_LITIGE]);
            }
        }

        $this->command->info('✓ Litiges créés : 5 litiges avec différents statuts');
    }
}
