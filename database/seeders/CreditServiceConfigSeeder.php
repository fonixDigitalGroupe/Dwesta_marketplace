<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CreditServiceConfig;

class CreditServiceConfigSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'cle' => 'mise_en_avant',
                'nom' => 'Mise en avant',
                'description' => 'Votre annonce apparaît en tête de liste dans les résultats de recherche.',
                'credits_requis' => 100,
                'duree_jours' => 7,
                'ordre' => 1,
                'actif' => true,
            ],
            [
                'cle' => 'boost',
                'nom' => 'Boost visibilité',
                'description' => 'Multipliez par 3 la visibilité de votre annonce sur tout le site.',
                'credits_requis' => 250,
                'duree_jours' => 15,
                'ordre' => 2,
                'actif' => true,
            ],
            [
                'cle' => 'urgent',
                'nom' => 'Badge Urgent',
                'description' => 'Affichez un badge "Urgent" pour attirer l\'attention des acheteurs.',
                'credits_requis' => 50,
                'duree_jours' => 7,
                'ordre' => 3,
                'actif' => true,
            ],
            [
                'cle' => 'video',
                'nom' => 'Ajout Vidéo',
                'description' => 'Permet d\'ajouter une vidéo de présentation à votre annonce.',
                'credits_requis' => 150,
                'duree_jours' => null,
                'ordre' => 4,
                'actif' => true,
            ],
        ];

        foreach ($services as $service) {
            CreditServiceConfig::updateOrCreate(['cle' => $service['cle']], $service);
        }
    }
}
