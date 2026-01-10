<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Catégories principales
        $ecommerce = Category::create([
            'nom' => 'E-commerce',
            'slug' => Category::generateSlug('E-commerce'),
            'description' => 'Produits et articles en vente',
            'icone' => 'shopping-bag',
            'ordre' => 1,
            'actif' => true,
        ]);

        $services = Category::create([
            'nom' => 'Services',
            'slug' => Category::generateSlug('Services'),
            'description' => 'Services professionnels et particuliers',
            'icone' => 'briefcase',
            'ordre' => 2,
            'actif' => true,
        ]);

        $immobilier = Category::create([
            'nom' => 'Immobilier',
            'slug' => Category::generateSlug('Immobilier'),
            'description' => 'Vente et location de biens immobiliers',
            'icone' => 'home',
            'ordre' => 3,
            'actif' => true,
        ]);

        $vehicules = Category::create([
            'nom' => 'Véhicules',
            'slug' => Category::generateSlug('Véhicules'),
            'description' => 'Véhicules d\'occasion et neufs',
            'icone' => 'car',
            'ordre' => 4,
            'actif' => true,
        ]);

        // Sous-catégories E-commerce
        $sousCategoriesEcommerce = [
            ['nom' => 'Électronique', 'icone' => 'laptop', 'ordre' => 1],
            ['nom' => 'Mode & Accessoires', 'icone' => 'tshirt', 'ordre' => 2],
            ['nom' => 'Maison & Jardin', 'icone' => 'home', 'ordre' => 3],
            ['nom' => 'Sport & Loisirs', 'icone' => 'football', 'ordre' => 4],
            ['nom' => 'Livres & Médias', 'icone' => 'book', 'ordre' => 5],
            ['nom' => 'Beauté & Santé', 'icone' => 'heart', 'ordre' => 6],
            ['nom' => 'Jouets & Enfants', 'icone' => 'baby', 'ordre' => 7],
            ['nom' => 'Autres', 'icone' => 'box', 'ordre' => 8],
        ];

        foreach ($sousCategoriesEcommerce as $sousCat) {
            Category::create([
                'parent_id' => $ecommerce->id,
                'nom' => $sousCat['nom'],
                'slug' => Category::generateSlug($sousCat['nom']),
                'icone' => $sousCat['icone'],
                'ordre' => $sousCat['ordre'],
                'actif' => true,
            ]);
        }

        // Sous-catégories Services
        $sousCategoriesServices = [
            ['nom' => 'Services à la personne', 'icone' => 'user', 'ordre' => 1],
            ['nom' => 'Services professionnels', 'icone' => 'briefcase', 'ordre' => 2],
            ['nom' => 'Services de réparation', 'icone' => 'tools', 'ordre' => 3],
            ['nom' => 'Services de transport', 'icone' => 'truck', 'ordre' => 4],
            ['nom' => 'Services de formation', 'icone' => 'graduation-cap', 'ordre' => 5],
            ['nom' => 'Services événementiels', 'icone' => 'calendar', 'ordre' => 6],
            ['nom' => 'Autres services', 'icone' => 'ellipsis-h', 'ordre' => 7],
        ];

        foreach ($sousCategoriesServices as $sousCat) {
            Category::create([
                'parent_id' => $services->id,
                'nom' => $sousCat['nom'],
                'slug' => Category::generateSlug($sousCat['nom']),
                'icone' => $sousCat['icone'],
                'ordre' => $sousCat['ordre'],
                'actif' => true,
            ]);
        }

        // Sous-catégories Immobilier
        $sousCategoriesImmobilier = [
            ['nom' => 'Appartements', 'icone' => 'building', 'ordre' => 1],
            ['nom' => 'Maisons', 'icone' => 'home', 'ordre' => 2],
            ['nom' => 'Terrains', 'icone' => 'map', 'ordre' => 3],
            ['nom' => 'Locaux commerciaux', 'icone' => 'store', 'ordre' => 4],
            ['nom' => 'Bureaux', 'icone' => 'briefcase', 'ordre' => 5],
            ['nom' => 'Autres', 'icone' => 'ellipsis-h', 'ordre' => 6],
        ];

        foreach ($sousCategoriesImmobilier as $sousCat) {
            Category::create([
                'parent_id' => $immobilier->id,
                'nom' => $sousCat['nom'],
                'slug' => Category::generateSlug($sousCat['nom']),
                'icone' => $sousCat['icone'],
                'ordre' => $sousCat['ordre'],
                'actif' => true,
            ]);
        }

        // Sous-catégories Véhicules
        $sousCategoriesVehicules = [
            ['nom' => 'Voitures', 'icone' => 'car', 'ordre' => 1],
            ['nom' => 'Motos', 'icone' => 'motorcycle', 'ordre' => 2],
            ['nom' => 'Vélos', 'icone' => 'bicycle', 'ordre' => 3],
            ['nom' => 'Utilitaires', 'icone' => 'truck', 'ordre' => 4],
            ['nom' => 'Bateaux', 'icone' => 'ship', 'ordre' => 5],
            ['nom' => 'Pièces & Accessoires', 'icone' => 'cog', 'ordre' => 6],
            ['nom' => 'Autres', 'icone' => 'ellipsis-h', 'ordre' => 7],
        ];

        foreach ($sousCategoriesVehicules as $sousCat) {
            Category::create([
                'parent_id' => $vehicules->id,
                'nom' => $sousCat['nom'],
                'slug' => Category::generateSlug($sousCat['nom']),
                'icone' => $sousCat['icone'],
                'ordre' => $sousCat['ordre'],
                'actif' => true,
            ]);
        }
    }
}
