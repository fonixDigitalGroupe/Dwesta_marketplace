<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Abonnement>
 */
class AbonnementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->unique()->randomElement(['gratuit', 'basic', 'expert']),
            'nom' => fake()->words(2, true),
            'description' => fake()->sentence(),
            'nombre_annonces' => fake()->numberBetween(0, 50),
            'commission' => fake()->randomFloat(2, 3, 15),
            'prix_mensuel' => fake()->numberBetween(0, 20000),
            'page_pro' => false,
            'actif' => true,
            'ordre' => fake()->numberBetween(1, 10),
        ];
    }
}
