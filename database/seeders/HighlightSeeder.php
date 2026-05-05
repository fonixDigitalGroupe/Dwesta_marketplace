<?php

namespace Database\Seeders;

use App\Models\Highlight;
use App\Models\HighlightTab;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HighlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nettoyage préalable en respectant les contraintes FK
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Highlight::truncate();
        HighlightTab::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Onglet : E-commerce
        $ecommerce = HighlightTab::create([
            'name' => 'E-commerce',
            'slug' => 'e-commerce',
            'position' => 1,
            'active' => true,
        ]);

        $this->createHighlightsForTab($ecommerce, [
            [
                'position' => 1,
                'title' => 'Mobiles & Tablettes',
                'subtitle' => 'Découvrez les dernières tendances high-tech',
                'image_path' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=800&q=80',
                'link_url' => '/categories/informatique',
            ],
            [
                'position' => 2,
                'title' => 'Mode Homme',
                'subtitle' => 'Nouveautés été',
                'image_path' => 'https://images.unsplash.com/photo-1490578474895-699cd4e2cf59?w=500&q=80',
                'link_url' => '/categories/e-commerce',
            ],
            [
                'position' => 3,
                'title' => 'Accessoires',
                'subtitle' => 'Élégance garantie',
                'image_path' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&q=80',
                'link_url' => '/categories/e-commerce',
            ],
            [
                'position' => 4,
                'title' => 'Électroménager Intelligent',
                'subtitle' => 'Simplifiez votre quotidien avec nos produits connectés',
                'image_path' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=1000&q=80',
                'link_url' => '/categories/e-commerce',
            ],
        ]);

        // 2. Onglet : Immobilier
        $immo = HighlightTab::create([
            'name' => 'Immobilier',
            'slug' => 'immobilier',
            'position' => 2,
            'active' => true,
        ]);

        $this->createHighlightsForTab($immo, [
            [
                'position' => 1,
                'title' => 'Appartements Modernes',
                'subtitle' => 'Vivre au cœur de la ville avec tout le confort',
                'image_path' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80',
                'link_url' => '/categories/immobilier',
            ],
            [
                'position' => 2,
                'title' => 'Bureaux',
                'subtitle' => 'Espaces de travail',
                'image_path' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=500&q=80',
                'link_url' => '/categories/immobilier',
            ],
            [
                'position' => 3,
                'title' => 'Villas',
                'subtitle' => 'Luxe et calme',
                'image_path' => 'https://images.unsplash.com/photo-1613977257363-707ba9348227?w=500&q=80',
                'link_url' => '/categories/immobilier',
            ],
            [
                'position' => 4,
                'title' => 'Terrains Constructibles',
                'subtitle' => 'Investissez dès aujourd\'hui dans votre futur foyer',
                'image_path' => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=1000&q=80',
                'link_url' => '/categories/immobilier',
            ],
        ]);

        // 3. Onglet : Véhicules
        $auto = HighlightTab::create([
            'name' => 'Véhicules',
            'slug' => 'vehicules',
            'position' => 3,
            'active' => true,
        ]);

        $this->createHighlightsForTab($auto, [
            [
                'position' => 1,
                'title' => 'Berlines Premium',
                'subtitle' => 'Le confort et la puissance réunis pour vos trajets',
                'image_path' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=800&q=80',
                'link_url' => '/categories/vehicules',
            ],
            [
                'position' => 2,
                'title' => 'Motos',
                'subtitle' => 'Liberté totale',
                'image_path' => 'https://images.unsplash.com/photo-1558981403-c5f91cbba527?w=500&q=80',
                'link_url' => '/categories/vehicules',
            ],
            [
                'position' => 3,
                'title' => 'SUV',
                'subtitle' => 'Aventure en famille',
                'image_path' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=500&q=80',
                'link_url' => '/categories/vehicules',
            ],
            [
                'position' => 4,
                'title' => 'Utilitaires Professionnels',
                'subtitle' => 'Boostez votre activité avec des véhicules robustes',
                'image_path' => 'https://images.unsplash.com/photo-1519003722824-194d4455a60c?w=1000&q=80',
                'link_url' => '/categories/vehicules',
            ],
        ]);
    }

    private function createHighlightsForTab(HighlightTab $tab, array $items)
    {
        foreach ($items as $item) {
            Highlight::create(array_merge($item, [
                'highlight_tab_id' => $tab->id,
                'active' => true,
            ]));
        }
    }
}
