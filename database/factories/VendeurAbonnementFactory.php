<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VendeurAbonnement>
 */
class VendeurAbonnementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vendeur_id' => \App\Models\Vendeur::factory(),
            'abonnement_id' => \App\Models\Abonnement::factory(),
            'date_debut' => now(),
            'date_fin' => now()->addMonth(),
            'actif' => true,
            'renouvellement_automatique' => false,
            'nombre_annonces_utilisees' => 0,
        ];
    }
}
