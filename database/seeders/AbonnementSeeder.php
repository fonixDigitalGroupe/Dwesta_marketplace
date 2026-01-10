<?php

namespace Database\Seeders;

use App\Models\Abonnement;
use Illuminate\Database\Seeder;

class AbonnementSeeder extends Seeder
{
    public function run(): void
    {
        $abonnements = [
            [
                'type' => 'gratuit',
                'nom' => 'Gratuit',
                'description' => 'Idéal pour débuter sur Mady Market',
                'nombre_annonces' => 5,
                'commission' => 15.00, // 15%
                'prix_mensuel' => 0,
                'page_pro' => false,
                'actif' => true,
                'ordre' => 1,
            ],
            [
                'type' => 'pro',
                'nom' => 'Pro',
                'description' => 'Pour les vendeurs réguliers qui veulent plus de visibilité',
                'nombre_annonces' => 50,
                'commission' => 12.00, // 12%
                'prix_mensuel' => 5000, // 5000 FCFA
                'page_pro' => true,
                'actif' => true,
                'ordre' => 2,
            ],
            [
                'type' => 'gold',
                'nom' => 'Gold',
                'description' => 'Pour les professionnels qui veulent dominer leur marché',
                'nombre_annonces' => 0, // Illimité
                'commission' => 10.00, // 10%
                'prix_mensuel' => 15000, // 15000 FCFA
                'page_pro' => true,
                'actif' => true,
                'ordre' => 3,
            ],
        ];

        foreach ($abonnements as $abonnement) {
            Abonnement::updateOrCreate(
                ['type' => $abonnement['type']],
                $abonnement
            );
        }
    }
}
