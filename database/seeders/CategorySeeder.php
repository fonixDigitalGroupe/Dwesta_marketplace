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
        // Désactiver les contraintes de clés étrangères pour le nettoyage
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\Category::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. E-COMMERCE (Main Category)
        $ecommerce = Category::create([
            'nom' => 'E-commerce',
            'slug' => 'e-commerce',
            'description' => 'Produits et articles en vente',
            'icone' => '📦',
            'ordre' => 1,
            'actif' => true,
        ]);

        // 1.1 Téléphonie, Tablette (Level 2 under E-commerce or Main?)
        // In the image, "Téléphonie, Tablette" seems like a Main Category.
        // Let's make it a Main Category for clarity as per user request.

        $telephonie = Category::create([
            'nom' => 'Téléphonie, Tablette',
            'slug' => 'telephonie-tablette',
            'icone' => '📱',
            'ordre' => 2,
            'actif' => true,
        ]);

        // Sub-categories for Téléphonie, Tablette (Level 2)
        $subTelephonie = [
            'SMARTPHONE ET TÉLÉPHONIE' => [
                'iPhone', 'Xiaomi', 'Google', 'Sony', 'Samsung', 'Oneplus', 'Huawei', 'Realme', 'Tous les téléphones mobiles', 'Téléphone fixe'
            ],
            'TABLETTE ET LISEUSE' => [
                'iPad', 'Tablette Xiaomi', 'Liseuse Kobo', 'Tablette Samsung', 'Toutes les tablettes', 'Toutes les liseuses'
            ],
            'OBJET CONNECTÉ' => [
                'Apple watch', 'Bracelet Xiaomi', 'Toutes les montres connectées', 'Samsung watch', 'Montre Garmin', 'Tous les bracelets connectés'
            ],
            'ACCESSOIRE' => [
                'Coque iPhone', 'Coque Xiaomi', 'Chargeur, Connectique', 'Coque Samsung', 'Etui, Coque', 'Tous les Accessoires de téléphones mobiles'
            ],
            'SECONDE MAIN' => [
                'iPhone reconditionné', 'Samsung reconditionné', 'iPad reconditionné', 'Apple Watch reconditionnée'
            ]
        ];

        foreach ($subTelephonie as $subNom => $items) {
            $subCat = Category::create([
                'parent_id' => $telephonie->id,
                'nom' => $subNom,
                'slug' => \Illuminate\Support\Str::slug($subNom),
                'actif' => true,
            ]);

            foreach ($items as $itemNom) {
                Category::create([
                    'parent_id' => $subCat->id,
                    'nom' => $itemNom,
                    'slug' => \Illuminate\Support\Str::slug($itemNom . '-' . $subNom), // slug unique
                    'actif' => true,
                ]);
            }
        }

        // 2. SERVICES (Main Category)
        $services = Category::create([
            'nom' => 'Services',
            'slug' => 'services',
            'description' => 'Services professionnels et particuliers',
            'icone' => '🛠️',
            'ordre' => 3,
            'actif' => true,
        ]);

        $subServices = [
            'Services à la personne' => ['Ménage', 'Garde d\'enfants', 'Soutien scolaire'],
            'Services professionnels' => ['Conseil', 'Comptabilité', 'Marketing'],
            'Services de réparation' => ['Informatique', 'Plomberie', 'Électricité'],
            'Services de transport' => ['Déménagement', 'Livraison', 'Chauffeur'],
        ];
                    'nom' => $itemNom,
                    'slug' => \Illuminate\Support\Str::slug($itemNom . '-' . $subNom),
                    'actif' => true,
                ]);
            }
        }
    }

}
