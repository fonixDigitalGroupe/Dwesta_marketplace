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
        ])->with('seller.user')->limit(5)->get();

        if ($orders->isEmpty()) {
            $this->command->warn('Pas assez de commandes pour créer des litiges.');
            return;
        }

        $motifs = [
            'non_conforme',
            'non_conforme',
            'non_recu',
            'non_conforme',
            'autre',
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
                0 => 'en_cours',
                1 => 'en_cours',
                2 => 'resolu',
                3 => 'resolu',
                4 => 'ferme',
            };

            Litige::create([
                'commande_id' => $order->id,
                'reporter_id' => $order->user_id,
                'reported_id' => $order->vendeur_id ? ($order->seller->user->id ?? $order->user_id) : $order->user_id, // Fallback if no seller user
                'motif' => $motifs[$index],
                'description' => $descriptions[$index],
                'statut' => $statut,
                'resolution' => $statut == 'resolu' ? 'Decision prise apres analyse.' : null,
                'created_at' => now()->subDays(rand(5, 20)),
            ]);

            // Mettre à jour le statut de la commande si litige ouvert
            if ($statut == 'en_cours') {
                $order->update(['statut' => Order::STATUT_LITIGE]);
            }
        }

        $this->command->info('✓ Litiges créés : 5 litiges avec différents statuts');
    }
}
