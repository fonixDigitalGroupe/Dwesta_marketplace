<?php

namespace Database\Factories;

use App\Models\Annonce;
use App\Models\Avis;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvisFactory extends Factory
{
    protected $model = Avis::class;

    public function definition(): array
    {
        return [
            'annonce_id' => Annonce::factory(),
            'user_id' => User::factory(),
            'note' => $this->faker->numberBetween(1, 5),
            'commentaire' => $this->faker->paragraph(),
            'photos' => null,
            'statut' => Avis::STATUT_EN_ATTENTE,
        ];
    }
}
