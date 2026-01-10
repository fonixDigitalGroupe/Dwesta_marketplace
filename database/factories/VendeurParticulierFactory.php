<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VendeurParticulier>
 */
class VendeurParticulierFactory extends Factory
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
            'type_document' => fake()->randomElement(['cni', 'passeport', 'recepisse']),
            'numero_document' => fake()->numerify('##########'),
            'document_path' => 'documents/vendeurs/1/cni/test.pdf',
            'date_emission_document' => fake()->dateTimeBetween('-5 years', '-1 year'),
            'date_expiration_document' => fake()->dateTimeBetween('now', '+5 years'),
            'lieu_emission' => fake()->city(),
        ];
    }
}
