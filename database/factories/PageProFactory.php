<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PagePro>
 */
class PageProFactory extends Factory
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
            'slug' => fake()->unique()->slug(),
            'logo' => null,
            'banniere' => null,
            'description' => fake()->paragraph(),
            'telephone_contact' => fake()->phoneNumber(),
            'email_contact' => fake()->email(),
            'site_web' => fake()->url(),
            'reseaux_sociaux' => [
                'facebook' => fake()->url(),
                'instagram' => fake()->url(),
            ],
            'actif' => true,
            'vues' => fake()->numberBetween(0, 1000),
        ];
    }
}
