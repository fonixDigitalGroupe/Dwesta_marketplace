<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GiftCardOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            ['amount' => 10, 'description' => 'Petite attention', 'is_popular' => false, 'is_active' => true],
            ['amount' => 20, 'description' => 'Cadeau idéal', 'is_popular' => true, 'is_active' => true],
            ['amount' => 50, 'description' => 'Faites-vous plaisir', 'is_popular' => false, 'is_active' => true],
            ['amount' => 100, 'description' => 'Le grand luxe', 'is_popular' => false, 'is_active' => true],
            ['amount' => 150, 'description' => 'L\'expérience ultime', 'is_popular' => false, 'is_active' => true],
        ];

        foreach ($options as $option) {
            \App\Models\GiftCardOption::create($option);
        }
    }
}
