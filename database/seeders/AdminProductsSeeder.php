<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Category;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminProductsSeeder extends Seeder
{
    public function run()
    {
        $user = User::where('email', 'admin@karnou.com')->first();
        if (!$user) {
            $this->command->error('User admin@karnou.com not found.');
            return;
        }

        $vendeur = Vendeur::firstOrCreate(
            ['user_id' => $user->id],
            [
                'type' => 'professionnel',
                'statut_verification' => 'verifie',
                'actif' => true,
                'verifie_le' => now()
            ]
        );

        $rootCategories = Category::racines()->get();

        foreach ($rootCategories as $root) {
            // Get all descendant categories for this root
            $allDescendants = $root->descendantsAndSelf();
            
            // Focus on Level 3 (leaf) categories for better mapping if possible
            $leafCategories = $allDescendants->filter(function($cat) {
                return $cat->enfants()->count() === 0;
            });

            if ($leafCategories->isEmpty()) {
                $leafCategories = collect([$root]);
            }

            $this->command->info("Creating 20 products for root category: {$root->nom}...");

            for ($i = 1; $i <= 20; $i++) {
                $category = $leafCategories->random();
                $titre = "Produit " . ucfirst($root->nom) . " #{$i} " . Str::random(5);
                
                $annonce = Annonce::create([
                    'vendeur_id' => $vendeur->id,
                    'categorie_id' => $category->id,
                    'type' => Annonce::TYPE_PRODUIT,
                    'titre' => $titre,
                    'slug' => Annonce::generateSlug($titre),
                    'prix' => rand(5000, 150000) / 100, // Prix entre 50 et 1500
                    'prix_original' => rand(150000, 200000) / 100,
                    'description' => "Ceci est une description détaillée pour le produit seeder #{$i} appartenant à la catégorie {$root->nom}. Idéal pour tester l'affichage et les fonctionnalités du marketplace.",
                    'statut' => Annonce::STATUT_PUBLIEE,
                    'nb_photos' => 0,
                    'vues' => rand(10, 1000),
                    'publiee_le' => now(),
                    'expire_le' => now()->addMonths(6),
                ]);
                
                // Add specific produit details
                $annonce->produit()->create([
                    'etat' => 'neuf',
                    'quantite' => rand(5, 100),
                    'marque' => 'Marque Seeder',
                    'modele' => 'Modèle ' . $i,
                ]);
                
                // Also add some attributes for filters
                if ($category->filters->count() > 0) {
                    foreach ($category->filters as $filter) {
                        if ($filter->options && count($filter->options) > 0) {
                            $annonce->filteredAttributes()->create([
                                'category_filter_id' => $filter->id,
                                'value' => $filter->options[array_rand($filter->options)],
                            ]);
                        }
                    }
                }
            }
        }
        
        $this->command->info('Seeding completed successfully!');
    }
}
