<?php

namespace Database\Factories;

use App\Models\Annonce;
use App\Models\Category;
use App\Models\Vendeur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Annonce>
 */
class AnnonceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titre = $this->faker->sentence(4);
        
        return [
            'vendeur_id' => Vendeur::factory(),
            'categorie_id' => Category::factory(),
            'type' => $this->faker->randomElement([
                Annonce::TYPE_PRODUIT,
                Annonce::TYPE_SERVICE,
                Annonce::TYPE_IMMOBILIER,
                Annonce::TYPE_VEHICULE,
            ]),
            'titre' => $titre,
            'slug' => Str::slug($titre) . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'prix' => $this->faker->randomFloat(2, 1000, 100000),
            'description' => $this->faker->paragraphs(3, true),
            'type_livraison' => $this->faker->randomElement(['livraison', 'retrait', 'les_deux']),
            'disponibilite' => $this->faker->randomElement([
                Annonce::DISPONIBILITE_EN_STOCK,
                Annonce::DISPONIBILITE_RUPTURE_STOCK,
                Annonce::DISPONIBILITE_SUR_COMMANDE,
            ]),
            'nb_photos' => 0,
            'video_achetee' => false,
            'statut' => Annonce::STATUT_BROUILLON,
            'vues' => 0,
        ];
    }

    /**
     * Indicate that the announcement is published.
     */
    public function publiee(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
            'expire_le' => now()->addDays(30),
        ]);
    }

    /**
     * Indicate that the announcement is a product.
     */
    public function produit(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Annonce::TYPE_PRODUIT,
            'prix' => $this->faker->randomFloat(2, 1000, 50000),
        ]);
    }

    /**
     * Indicate that the announcement is a service.
     */
    public function service(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Annonce::TYPE_SERVICE,
            'prix' => null,
        ]);
    }

    /**
     * Indicate that the announcement is real estate.
     */
    public function immobilier(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Annonce::TYPE_IMMOBILIER,
            'prix' => $this->faker->randomFloat(2, 50000, 500000),
        ]);
    }

    /**
     * Indicate that the announcement is a vehicle.
     */
    public function vehicule(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Annonce::TYPE_VEHICULE,
            'prix' => $this->faker->randomFloat(2, 20000, 200000),
        ]);
    }
}
