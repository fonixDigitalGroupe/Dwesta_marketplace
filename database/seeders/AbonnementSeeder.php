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
                'description' => 'Idéal pour débuter',
                'nombre_annonces' => 5,
                'commission' => 3.00, // 3% selon CDC
                'prix_mensuel' => 0,
                'page_pro' => false,
                'actif' => true,
                'ordre' => 1,
            ],
            [
                'type' => 'basic',
                'nom' => 'Basic',
                'description' => 'Usage illimité avec page pro standard',
                'nombre_annonces' => 0, // Illimité
                'commission' => 7.00, // 7% selon CDC
                'prix_mensuel' => 3000, // 3000 FCFA selon CDC
                'page_pro' => true,
                'page_pro_personnalisable' => false,
                'actif' => true,
                'ordre' => 2,
            ],
            [
                'type' => 'expert',
                'nom' => 'Expert',
                'description' => 'Commission réduite et boutique entièrement personnalisable',
                'nombre_annonces' => 0, // Illimité
                'commission' => 5.00, // 5% selon CDC
                'prix_mensuel' => 5000, // 5000 FCFA selon CDC
                'page_pro' => true,
                'page_pro_personnalisable' => true,
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
