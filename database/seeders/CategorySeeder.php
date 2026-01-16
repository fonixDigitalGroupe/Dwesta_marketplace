<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clés étrangères pour le nettoyage
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            Category::FAMILLE_ECOMMERCE => [
                'Informatique & Bureau' => ['Ordinateurs', 'Périphériques', 'Logiciels', 'Tablettes'],
                'Mode & Vêtements' => ['Homme', 'Femme', 'Enfant', 'Accessoires'],
                'Maison & Jardin' => ['Meubles', 'Décoration', 'Outillage', 'Plantes'],
            ],
            Category::FAMILLE_SERVICES => [
                'Services à domicile' => ['Ménage', 'Bricolage', 'Garde d\'enfants', 'Jardinage'],
                'Services Professionnels' => ['Conseil', 'Marketing', 'Traduction', 'Informatique'],
                'Bien-être & Santé' => ['Massage', 'Coaching', 'Nutrition', 'Soins'],
            ],
            Category::FAMILLE_IMMOBILIER => [
                'Vente' => ['Appartements', 'Maisons', 'Terrains', 'Commerces'],
                'Location' => ['Appartements', 'Maisons', 'Bureaux', 'Vacances'],
                'Colocation & Partage' => ['Chambre', 'Coworking', 'Parking', 'Garage'],
            ],
            Category::FAMILLE_VEHICULES => [
                'Voitures' => ['Berlines', 'SUV', 'Utilitaires', 'Sportives'],
                'Motos & Deux Roues' => ['Scooters', 'Motos Sportives', 'Vélos', 'Accessoires'],
                'Autres Véhicules' => ['Bateaux', 'Camions', 'Engins de chantier', 'Pièces détachées'],
            ],
        ];

        $icones = [
            Category::FAMILLE_ECOMMERCE => '📦',
            Category::FAMILLE_SERVICES => '🛠️',
            Category::FAMILLE_IMMOBILIER => '🏠',
            Category::FAMILLE_VEHICULES => '🚗',
        ];

        $ordreMain = 1;
        foreach ($data as $famille => $subCategories) {
            // Level 1: Main Category (One per Family)
            $mainCat = Category::create([
                'nom' => $famille,
                'slug' => Str::slug($famille),
                'description' => "Catégorie principale pour $famille",
                'icone' => $icones[$famille] ?? '📂',
                'ordre' => $ordreMain++,
                'actif' => true,
                'famille' => $famille,
            ]);

            $ordreL2 = 1;
            foreach ($subCategories as $l2Nom => $l3Noms) {
                // Level 2: Sub-category
                $l2Cat = Category::create([
                    'parent_id' => $mainCat->id,
                    'nom' => $l2Nom,
                    'slug' => Str::slug($l2Nom . '-' . $mainCat->id),
                    'ordre' => $ordreL2++,
                    'actif' => true,
                ]);

                $ordreL3 = 1;
                foreach ($l3Noms as $l3Nom) {
                    // Level 3: Detail element
                    Category::create([
                        'parent_id' => $l2Cat->id,
                        'nom' => $l3Nom,
                        'slug' => Str::slug($l3Nom . '-' . $l2Cat->id),
                        'ordre' => $ordreL3++,
                        'actif' => true,
                    ]);
                }
            }
        }
    }
}
