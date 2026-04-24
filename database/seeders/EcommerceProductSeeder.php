<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\AnnonceProduit;
use App\Models\AnnonceMedia;
use App\Models\Category;
use App\Models\Vendeur;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EcommerceProductSeeder extends Seeder
{
    /**
     * 30 produits réalistes pour la catégorie E-commerce et ses sous-catégories.
     */
    private array $produits = [
        // Informatique & Bureau
        ['titre' => 'MacBook Air M2 - 8Go RAM - 256Go SSD', 'prix' => 899000, 'etat' => 'Neuf', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=400&fit=crop'],
        ['titre' => 'PC Bureau DELL Optiplex - Intel Core i5 - 16Go', 'prix' => 450000, 'etat' => 'Occasion', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?w=400&fit=crop'],
        ['titre' => 'Écran HP 27 pouces Full HD IPS - HDMI/DisplayPort', 'prix' => 185000, 'etat' => 'Neuf', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=400&fit=crop'],
        ['titre' => 'Clavier mécanique Logitech MX Keys - Sans fil', 'prix' => 65000, 'etat' => 'Neuf', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1504991679164-ba7fda7b5fb1?w=400&fit=crop'],
        ['titre' => 'Souris gaming Razer DeathAdder V3 - 30 000 DPI', 'prix' => 42000, 'etat' => 'Neuf', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1527814050087-3793815479db?w=400&fit=crop'],
        ['titre' => 'Disque dur externe WD 2To - USB 3.0', 'prix' => 38000, 'etat' => 'Neuf', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1531492746076-161ca9bcad58?w=400&fit=crop'],
        ['titre' => 'SSD Samsung 870 EVO 1To - SATA III', 'prix' => 55000, 'etat' => 'Neuf', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=400&fit=crop'],
        ['titre' => 'Imprimante laser HP LaserJet Pro - WiFi', 'prix' => 120000, 'etat' => 'Neuf', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6?w=400&fit=crop'],

        // Mode & Vêtements
        ['titre' => 'Nike Air Max 270 - Baskets Homme - Taille 43', 'prix' => 95000, 'etat' => 'Neuf', 'categorie' => 'Mode & Vêtements', 'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&fit=crop'],
        ['titre' => 'Veste cuir vintage - Marron - Taille M', 'prix' => 78000, 'etat' => 'Occasion', 'categorie' => 'Mode & Vêtements', 'image' => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400&fit=crop'],
        ['titre' => 'Jean Slim Levi\'s 511 - Bleu foncé - W32 L32', 'prix' => 45000, 'etat' => 'Neuf', 'categorie' => 'Mode & Vêtements', 'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400&fit=crop'],
        ['titre' => 'Robe de soirée élégante - Noire - Taille 38', 'prix' => 62000, 'etat' => 'Neuf', 'categorie' => 'Mode & Vêtements', 'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=400&fit=crop'],
        ['titre' => 'Manteau long cachemire - Gris - Unisexe M/L', 'prix' => 130000, 'etat' => 'Neuf', 'categorie' => 'Mode & Vêtements', 'image' => 'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?w=400&fit=crop'],
        ['titre' => 'Sac à main cuir Guess - Marron - Neuf avec étiquette', 'prix' => 88000, 'etat' => 'Neuf', 'categorie' => 'Mode & Vêtements', 'image' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=400&fit=crop'],
        ['titre' => 'Sneakers Adidas Ultraboost 22 - Blanc - Taille 42', 'prix' => 105000, 'etat' => 'Neuf', 'categorie' => 'Mode & Vêtements', 'image' => 'https://images.unsplash.com/photo-1568702846914-96b305d2aaeb?w=400&fit=crop'],

        // Maison & Jardin
        ['titre' => 'Robot aspirateur Roomba i7+ - Vidage automatique', 'prix' => 320000, 'etat' => 'Neuf', 'categorie' => 'Maison & Jardin', 'image' => 'https://images.unsplash.com/photo-1567690187548-f07b1d7bf5a9?w=400&fit=crop'],
        ['titre' => 'Machine à café Nespresso Vertuo Next - Capsules', 'prix' => 98000, 'etat' => 'Neuf', 'categorie' => 'Maison & Jardin', 'image' => 'https://images.unsplash.com/photo-1516224498413-84ecf3a1e7fd?w=400&fit=crop'],
        ['titre' => 'Canapé 3 places en tissu gris - Livraison incluse', 'prix' => 285000, 'etat' => 'Neuf', 'categorie' => 'Maison & Jardin', 'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=400&fit=crop'],
        ['titre' => 'Réfrigérateur américain Samsung - No Frost - 600L', 'prix' => 780000, 'etat' => 'Neuf', 'categorie' => 'Maison & Jardin', 'image' => 'https://images.unsplash.com/photo-1584568694244-14fbdf83bd30?w=400&fit=crop'],
        ['titre' => 'Lit adulte 160x200 cm + matelas mémoire de forme', 'prix' => 450000, 'etat' => 'Neuf', 'categorie' => 'Maison & Jardin', 'image' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?w=400&fit=crop'],
        ['titre' => 'Table basse en bois massif - Design scandinave', 'prix' => 85000, 'etat' => 'Occasion', 'categorie' => 'Maison & Jardin', 'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=400&fit=crop'],

        // Smartphones & Téléphonie
        ['titre' => 'iPhone 15 Pro - 256Go - Titane naturel - Débloqué', 'prix' => 1050000, 'etat' => 'Neuf', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1696446702183-cbd29f0da873?w=400&fit=crop'],
        ['titre' => 'Samsung Galaxy S24 Ultra - 512Go - Noir', 'prix' => 980000, 'etat' => 'Neuf', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1610945264803-c22b62d2a7b3?w=400&fit=crop'],
        ['titre' => 'AirPods Pro 2 - Réduction bruit active - Boitier USB-C', 'prix' => 195000, 'etat' => 'Neuf', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?w=400&fit=crop'],
        ['titre' => 'Tablette iPad 10ème génération - 64Go - WiFi', 'prix' => 480000, 'etat' => 'Neuf', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400&fit=crop'],

        // Sports & Loisirs
        ['titre' => 'Vélo de route BTWIN - 21 vitesses - Alu', 'prix' => 195000, 'etat' => 'Occasion', 'categorie' => 'Mode & Vêtements', 'image' => 'https://images.unsplash.com/photo-1485965120184-e220f721d03e?w=400&fit=crop'],
        ['titre' => 'Tapis de yoga épais 10mm - Antidérapant - Sac inclus', 'prix' => 18500, 'etat' => 'Neuf', 'categorie' => 'Mode & Vêtements', 'image' => 'https://images.unsplash.com/photo-1601925228008-4c9c4daf6451?w=400&fit=crop'],
        ['titre' => 'Haltères réglables 2x 32kg - Rack inclus', 'prix' => 145000, 'etat' => 'Neuf', 'categorie' => 'Mode & Vêtements', 'image' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=400&fit=crop'],

        // Beauté & Santé
        ['titre' => 'Sèche-cheveux Dyson Supersonic - Rouge - 1600W', 'prix' => 290000, 'etat' => 'Neuf', 'categorie' => 'Mode & Vêtements', 'image' => 'https://images.unsplash.com/photo-1590439471364-192aa70c0b53?w=400&fit=crop'],
        ['titre' => 'Montre connectée Apple Watch Series 9 - 45mm GPS', 'prix' => 420000, 'etat' => 'Neuf', 'categorie' => 'Informatique & Bureau', 'image' => 'https://images.unsplash.com/photo-1434493651957-4ec291c8a826?w=400&fit=crop'],
    ];

    public function run(): void
    {
        // Récupérer la catégorie racine E-commerce
        $ecommerce = Category::where('nom', 'like', '%commerce%')
            ->orWhere('nom', 'like', '%Ecommerce%')
            ->orWhere('nom', 'like', '%E-commerce%')
            ->first();

        if (!$ecommerce) {
            $this->command->error('Catégorie E-commerce introuvable. Vérifiez le nom exact en base de données.');
            $this->command->line('Catégories disponibles :');
            Category::whereNull('parent_id')->each(function($cat) {
                $this->command->line("  - [{$cat->id}] {$cat->nom}");
            });
            return;
        }

        $this->command->info("✓ Catégorie racine trouvée : {$ecommerce->nom} (ID: {$ecommerce->id})");

        // Récupérer un vendeur existant (ou le premier disponible)
        $vendeur = Vendeur::inRandomOrder()->first();
        if (!$vendeur) {
            $this->command->error('Aucun vendeur trouvé. Exécutez d\'abord un seeder de vendeurs.');
            return;
        }

        $this->command->info("✓ Vendeur utilisé : {$vendeur->user->name} (ID: {$vendeur->id})");

        // Récupérer toutes les sous-catégories de E-commerce
        $sousCategories = Category::where('parent_id', $ecommerce->id)
            ->orWhere(function($q) use ($ecommerce) {
                $q->whereHas('parent', fn($q2) => $q2->where('parent_id', $ecommerce->id));
            })
            ->get()
            ->keyBy('nom');

        $inserted = 0;

        foreach ($this->produits as $data) {
            // Trouver la sous-catégorie (ou utiliser la catégorie racine)
            $categorie = null;
            foreach ($sousCategories as $nom => $cat) {
                if (str_contains(strtolower($nom), strtolower(explode(' ', $data['categorie'])[0]))) {
                    $categorie = $cat;
                    break;
                }
            }
            $categorie = $categorie ?? $ecommerce;

            $titre = $data['titre'];
            $slug = Annonce::generateSlug($titre);

            // Créer l'annonce
            $annonce = Annonce::create([
                'vendeur_id'   => $vendeur->id,
                'categorie_id' => $categorie->id,
                'type'         => Annonce::TYPE_PRODUIT,
                'titre'        => $titre,
                'slug'         => $slug,
                'prix'         => $data['prix'],
                'description'  => "Produit de qualité - {$titre}. Disponible immédiatement. Livraison rapide sur toute la zone.",
                'statut'       => Annonce::STATUT_PUBLIEE,
                'publiee_le'   => now()->subDays(rand(0, 15)),
                'expire_le'    => now()->addDays(60),
                'vues'         => rand(5, 350),
            ]);

            // Créer les détails produit
            AnnonceProduit::create([
                'annonce_id' => $annonce->id,
                'etat'       => $data['etat'],
                'quantite'   => rand(1, 20),
                'badges'     => null,
            ]);

            // Ajouter une image externe (URL Unsplash)
            AnnonceMedia::create([
                'annonce_id'    => $annonce->id,
                'type'          => 'photo',
                'chemin'        => $data['image'],
                'est_principale' => true,
                'ordre'         => 1,
            ]);

            $inserted++;
            $this->command->info("  [{$inserted}/30] ✓ {$titre}");
        }

        $this->command->info("");
        $this->command->info("✅ {$inserted} produits créés avec succès dans la catégorie E-commerce !");
    }
}
