<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nom = $this->faker->unique()->words(2, true);
        
        return [
            'parent_id' => null,
            'nom' => ucwords($nom),
            'slug' => Category::generateSlug($nom),
            'description' => $this->faker->sentence(),
            'icone' => $this->faker->randomElement(['shopping-bag', 'car', 'home', 'briefcase', 'laptop', 'tshirt']),
            'ordre' => $this->faker->numberBetween(0, 100),
            'actif' => true,
        ];
    }

    /**
     * Indicate that the category is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'actif' => false,
        ]);
    }

    /**
     * Indicate that the category has a parent.
     */
    public function withParent(?Category $parent = null): static
    {
        return $this->state(function (array $attributes) use ($parent) {
            $parent = $parent ?? Category::factory()->create();
            
            return [
                'parent_id' => $parent->id,
            ];
        });
    }
}
