<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendeur;
use App\Models\VendeurParticulier;
use App\Models\VendeurProfessionnel;
use App\Models\Annonce;
use App\Models\Category;
use App\Models\AnnonceProduit;
use App\Models\AnnonceService;
use App\Models\AnnonceImmobilier;
use App\Models\AnnonceVehicule;
use App\Models\HomeSection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MarketplaceCompleteSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Démarrage du Seeder Complet Marketplace...');

        // 1. Création des Rôles (via RoleSeeder existant si besoin)
        $this->call(RoleSeeder::class);

        // 2. Création de l'ADMIN
        $admin = User::firstOrCreate(
            ['email' => 'admin@karnou.com'],
            [
                'prenom' => 'Admin',
                'nom' => 'Karnou',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'telephone' => '770000001',
            ]
        );
        $admin->assignRole('admin');
        $this->command->info('✓ Admin créé: admin@karnou.com / password');

        // 3. Création du VENDEUR PRO
        $userPro = User::firstOrCreate(
            ['email' => 'pro@karnou.com'],
            [
                'prenom' => 'Hamed',
                'nom' => 'Tech',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'telephone' => '770000002',
            ]
        );
        $userPro->assignRole('vendeur');
        $vendeurPro = Vendeur::firstOrCreate(['user_id' => $userPro->id], [
            'type' => 'professionnel',
            'statut_verification' => 'verifie',
            'actif' => true,
            'verifie_le' => now(),
        ]);
        VendeurProfessionnel::firstOrCreate(['vendeur_id' => $vendeurPro->id], [
            'nom_entreprise' => 'Karnou Electronics & Tech',
            'numero_registre_commerce' => 'RC-SN-DKR-2024-B-999',
            'numero_identification_fiscale' => 'NINEA-1234567',
            'adresse_entreprise' => 'Avenue Bourguiba, Dakar',
            'telephone_entreprise' => '338000000',
            'email_entreprise' => 'contact@karnoutech.com',
        ]);
        $this->command->info('✓ Vendeur Pro créé: pro@karnou.com / password');

        // 4. Création du VENDEUR PARTICULIER
        $userPart = User::firstOrCreate(
            ['email' => 'part@karnou.com'],
            [
                'prenom' => 'Alice',
                'nom' => 'Dio',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'is_active' => true,
                'telephone' => '770000003',
            ]
        );
        $userPart->assignRole('vendeur');
        $vendeurPart = Vendeur::firstOrCreate(['user_id' => $userPart->id], [
            'type' => 'particulier',
            'statut_verification' => 'verifie',
            'actif' => true,
            'verifie_le' => now(),
        ]);
        VendeurParticulier::firstOrCreate(['vendeur_id' => $vendeurPart->id], [
            'type_document' => 'CNI',
            'numero_document' => 'SN-123-456-789',
        ]);
        $this->command->info('✓ Vendeur Particulier créé: part@karnou.com / password');

        // 5. Création des Catégories de base si besoin
        $catHighTech = $this->ensureCategory('Informatique & High-Tech', Category::FAMILLE_ECOMMERCE);
        $catImmo = $this->ensureCategory('Appartements & Villas', Category::FAMILLE_IMMOBILIER);
        $catAuto = $this->ensureCategory('Véhicules & Auto', Category::FAMILLE_VEHICULES);
        $catService = $this->ensureCategory('Services à domicile', Category::FAMILLE_SERVICES);

        // 6. Création des Produits / Annonces avec Promotions
        
        // Ventes Flash (Promo active)
        $this->createAnnonce($vendeurPro, $catHighTech, 'iPhone 15 Pro Max 256GB', 850000, 1100000, now()->addHours(12));
        $this->createAnnonce($vendeurPro, $catHighTech, 'MacBook Air M2 13"', 750000, 950000, now()->addDays(2));
        $this->createAnnonce($vendeurPart, $catAuto, 'Toyota RAV4 2018', 12500000, 14000000, now()->addHours(6));

        // Produits Standards
        for($i=1; $i<=5; $i++) {
            $this->createAnnonce($vendeurPro, $catHighTech, "Smartphone Samsung S2$i", 450000 + ($i*1000));
            $this->createAnnonce($userPart->vendeur, $catImmo, "Studio Meublé F$i Dakar", 25000 * $i);
        }

        // 7. Configuration des Sections de la Home
        HomeSection::truncate(); // On recommence à zéro pour la clarté
        HomeSection::create(['title' => '⚡ Ventes Flash (Offres limitées)', 'source_type' => 'flash_sale', 'type' => 'slider', 'order' => 1, 'limit' => 6]);
        HomeSection::create(['title' => '🔥 Les plus consultés', 'source_type' => 'most_viewed', 'type' => 'grid', 'order' => 2, 'limit' => 8]);
        HomeSection::create(['title' => '✨ Nouveautés sur Karnou', 'source_type' => 'newest', 'type' => 'slider', 'order' => 3, 'limit' => 10]);
        HomeSection::create(['title' => '💰 Prix cassés (Promos)', 'source_type' => 'cheapest', 'type' => 'grid', 'order' => 4, 'limit' => 8]);

        // 8. Bannières Publicitaires (Style Amazon/Rakuten)
        \App\Models\Banner::truncate();
        \App\Models\Banner::create([
            'title' => 'La Tech de demain est déjà là',
            'slug' => 'la-tech-de-demain',
            'image_url' => 'https://images.unsplash.com/photo-1531297484001-80022131f5a1?q=80&w=2020&auto=format&fit=crop',
            'link_url' => route('collections.show', ['slug' => 'la-tech-de-demain']),
            'category_id' => $catHighTech->id,
            'promo_discount' => 'Jusqu\'à -40%',
            'promo_code' => 'KTECH24',
            'order' => 1,
            'active' => true,
        ]);


        \App\Models\Banner::create([
            'title' => 'Redéfinissez votre Style',
            'slug' => 'mode-et-style',
            'image_url' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=2070&auto=format&fit=crop',
            'link_url' => route('collections.show', ['slug' => 'mode-et-style']),
            'promo_discount' => 'Collection Fashion 2024',
            'promo_conditions' => 'Cumulable avec les offres en cours',
            'order' => 2,
            'active' => true,
        ]);


        \App\Models\Banner::create([
            'title' => 'Paiement en 4x sans frais',
            'slug' => 'paiement-facile',
            'image_url' => 'https://images.unsplash.com/photo-1556742044-3c52d6e88c62?q=80&w=2070&auto=format&fit=crop',
            'link_url' => route('collections.show', ['slug' => 'paiement-facile']),
            'has_payment_4x' => true,
            'promo_conditions' => 'À partir de 100 000 FCFA d\'achats',
            'order' => 3,
            'active' => true,
        ]);


        $this->command->info('✓ HomeSections configurées dynamiquement.');
        $this->command->info('Seeder Complet terminé avec succès !');
    }

    private function ensureCategory($name, $family)
    {
        return Category::firstOrCreate(
            ['nom' => $name],
            [
                'slug' => Str::slug($name),
                'famille' => $family,
                'actif' => true,
                'ordre' => 0,
            ]
        );
    }

    private function createAnnonce($vendeur, $category, $titre, $prix, $prixOriginal = null, $expiresAt = null)
    {
        $annonce = Annonce::create([
            'vendeur_id' => $vendeur->id,
            'categorie_id' => $category->id,
            'type' => $this->getAnnonceType($category->famille),
            'titre' => $titre,
            'slug' => Str::slug($titre . '-' . uniqid()),
            'prix' => $prix,
            'prix_original' => $prixOriginal,
            'promo_expires_at' => $expiresAt,
            'description' => "Description de test pour $titre. Produit de haute qualité disponible sur Karnou.",
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
            'vues' => rand(10, 500),
            'disponibilite' => Annonce::DISPONIBILITE_EN_STOCK,
            'type_livraison' => 'expedition',
        ]);

        // Créer les tables liées selon le type
        if ($annonce->type === Annonce::TYPE_PRODUIT) {
            AnnonceProduit::create(['annonce_id' => $annonce->id, 'etat' => 'neuf', 'quantite' => rand(1, 100)]);
        } elseif ($annonce->type === Annonce::TYPE_VEHICULE) {
            AnnonceVehicule::create(['annonce_id' => $annonce->id, 'marque' => 'Toyota', 'modele' => 'Corolla', 'annee' => 2020]);
        } elseif ($annonce->type === Annonce::TYPE_IMMOBILIER) {
            AnnonceImmobilier::create(['annonce_id' => $annonce->id, 'type_transaction' => 'location', 'surface' => 100]);
        } elseif ($annonce->type === Annonce::TYPE_SERVICE) {
            AnnonceService::create(['annonce_id' => $annonce->id, 'type_tarification' => 'forfait', 'zone_intervention' => 'Dakar']);
        }
        
        return $annonce;
    }

    private function getAnnonceType($family)
    {
        switch ($family) {
            case Category::FAMILLE_ECOMMERCE: return Annonce::TYPE_PRODUIT;
            case Category::FAMILLE_IMMOBILIER: return Annonce::TYPE_IMMOBILIER;
            case Category::FAMILLE_VEHICULES: return Annonce::TYPE_VEHICULE;
            case Category::FAMILLE_SERVICES: return Annonce::TYPE_SERVICE;
            default: return Annonce::TYPE_PRODUIT;
        }
    }
}
