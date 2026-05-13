<?php

namespace Database\Seeders;

use App\Models\CreditPack;
use Illuminate\Database\Seeder;

class CreditPackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packs = [
            [
                'nom' => 'Pack Bronze',
                'description' => 'Idéal pour tester nos services. Obtenez 10 crédits pour booster vos annonces.',
                'credits' => 10,
                'bonus_credits' => 0,
                'prix' => 5000,
                'actif' => true,
                'ordre' => 1,
            ],
            [
                'nom' => 'Pack Silver',
                'description' => 'Le choix populaire pour les vendeurs réguliers. Comprend 5 crédits bonus.',
                'credits' => 50,
                'bonus_credits' => 5,
                'prix' => 20000,
                'actif' => true,
                'ordre' => 2,
            ],
            [
                'nom' => 'Pack Gold',
                'description' => 'Pour une visibilité maximale. 15 crédits offerts en bonus.',
                'credits' => 100,
                'bonus_credits' => 15,
                'prix' => 35000,
                'actif' => true,
                'ordre' => 3,
            ],
            [
                'nom' => 'Pack Premium',
                'description' => 'L\'offre ultime pour les professionnels. 50 crédits offerts pour une croissance rapide.',
                'credits' => 250,
                'bonus_credits' => 50,
                'prix' => 75000,
                'actif' => true,
                'ordre' => 4,
            ],
        ];

        foreach ($packs as $pack) {
            CreditPack::updateOrCreate(['nom' => $pack['nom']], $pack);
        }
    }
}
