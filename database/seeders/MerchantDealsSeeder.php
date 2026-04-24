<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\AnnonceProduit;
use App\Models\AnnonceOption;
use App\Models\Category;
use App\Models\Vendeur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MerchantDealsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get the target category (N1)
        $category = Category::where('slug', 'e-commerce')->first() 
                 ?? Category::where('parent_id', null)->first();

        if (!$category) {
            $this->command->error('No root category found.');
            return;
        }

        // 2. Get a Professional Seller
        $vendeur = Vendeur::where('type', 'professionnel')->first();
        
        if (!$vendeur) {
            $this->command->error('No professional seller found. Please run VendeurSeeder first.');
            return;
        }

        $this->command->info("Creating 12 sponsored Pro deals for category: {$category->nom}");

        // 3. Create 12 sponsored Pro products
        $products = [
            'Smartphone Ultra Pro Max',
            'Laptop Gamer Extreme',
            'Wireless Headphones Noise Cancelling',
            'Smartwatch Series X',
            'Tablet Air Display',
            'Digital Camera 4K',
            'Console de Jeu NextGen',
            'Clavier Mécanique RGB',
            'Souris Gaming High Precision',
            'Moniteur 4K 144Hz',
            'Enceinte Bluetooth Premium',
            'Disque Dur SSD 2To'
        ];

        foreach ($products as $index => $name) {
            $annonce = Annonce::create([
                'vendeur_id' => $vendeur->id,
                'categorie_id' => $category->id,
                'type' => 'produit',
                'titre' => $name,
                'slug' => Str::slug($name . '-' . uniqid()),
                'description' => "Découvrez le meilleur de la technologie avec ce {$name}. Produit neuf sous garantie.",
                'prix' => rand(50000, 950000),
                'statut' => 'publiee',
                'publiee_le' => now()->subHours($index),
                'expire_le' => now()->addDays(30),
                'vues' => rand(100, 2000),
            ]);

            AnnonceProduit::create([
                'annonce_id' => $annonce->id,
                'etat' => 'neuf',
                'quantite' => rand(5, 50),
            ]);

            AnnonceOption::create([
                'annonce_id' => $annonce->id,
                'a_la_une' => 1,
                'a_la_une_expire_le' => now()->addDays(15),
            ]);
        }

        $this->command->info('✓ 12 sponsored professional deals created successfully.');
    }
}
