<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryPriceSeeder extends Seeder
{
    public function run()
    {
        // Immobilier : 25 000 FCFA
        Category::where('slug', 'like', '%immo%')
            ->orWhere('nom', 'like', '%Immobilier%')
            ->update(['listing_price' => 25000]);

        // Véhicules : 50 000 FCFA
        Category::where('slug', 'like', '%vehicule%')
            ->orWhere('nom', 'like', '%Véhicule%')
             ->orWhere('slug', 'like', '%auto%')
            ->update(['listing_price' => 50000]);
            
        $this->command->info('Prix des catégories mis à jour.');
    }
}
