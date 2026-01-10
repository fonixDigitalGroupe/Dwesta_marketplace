<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VendeurProfessionnel>
 */
class VendeurProfessionnelFactory extends Factory
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
            'nom_entreprise' => fake()->company(),
            'numero_registre_commerce' => fake()->numerify('RC#######'),
            'registre_commerce_path' => 'documents/vendeurs/1/registre_commerce/test.pdf',
            'date_expiration_registre' => fake()->dateTimeBetween('now', '+5 years'),
            'numero_identification_fiscale' => fake()->numerify('NIF#######'),
            'adresse_entreprise' => fake()->address(),
            'telephone_entreprise' => fake()->phoneNumber(),
            'email_entreprise' => fake()->companyEmail(),
            'description_entreprise' => fake()->paragraph(),
            'site_web' => fake()->url(),
        ];
    }
}
