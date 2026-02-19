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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MarketplaceDemoSeeder extends Seeder
{
    public function run()
    {
        // Ensure Categories for each family exist (basic setup)
        // We will try to find existing ones or create dummy ones if needed, 
        // assuming the main category seeder has run or we just create placeholders.
        // For simplicity in a demo seeder, let's ensure we have at least one category per family.
        
        $categories = [
            Category::FAMILLE_ECOMMERCE => $this->getOrCreateCategory('High-Tech', Category::FAMILLE_ECOMMERCE),
            Category::FAMILLE_SERVICES => $this->getOrCreateCategory('Bricolage', Category::FAMILLE_SERVICES),
            Category::FAMILLE_IMMOBILIER => $this->getOrCreateCategory('Appartements', Category::FAMILLE_IMMOBILIER),
            Category::FAMILLE_VEHICULES => $this->getOrCreateCategory('Voitures', Category::FAMILLE_VEHICULES),
        ];

        // 1. Create 5 Buyers (Simple Users)
        $this->command->info('Creating 5 Buyers...');
        for ($i = 1; $i <= 5; $i++) {
            $user = User::firstOrCreate(
                ['email' => "client{$i}@demo.com"],
                [
                    'prenom' => "Client",
                    'nom' => "Numero {$i}",
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'telephone' => '77' . rand(1000000, 9999999),
                ]
            );
            $user->assignRole('client');
        }

        // 2. Create 5 Individual Sellers
        $this->command->info('Creating 5 Individual Sellers...');
        for ($i = 1; $i <= 5; $i++) {
            $user = User::firstOrCreate(
                ['email' => "vendeur.part{$i}@demo.com"],
                [
                    'prenom' => "VendeurPart",
                    'nom' => "Numero {$i}",
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'telephone' => '77' . rand(1000000, 9999999),
                ]
            );
            $user->assignRole('vendeur');

            $vendeur = Vendeur::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'type' => 'particulier',
                    'statut_verification' => 'verifie',
                    'actif' => true,
                    'verifie_le' => now(),
                ]
            );

            VendeurParticulier::firstOrCreate(
                ['vendeur_id' => $vendeur->id],
                [
                    'type_document' => 'CNI',
                    'numero_document' => '1234567890' . $i,
                    'date_expiration_document' => now()->addYears(5),
                ]
            );

            $this->createAnnoncesForVendeur($vendeur, $categories);
        }

        // 3. Create 5 Professional Sellers
        $this->command->info('Creating 5 Professional Sellers...');
        for ($i = 1; $i <= 5; $i++) {
            $user = User::firstOrCreate(
                ['email' => "vendeur.pro{$i}@demo.com"],
                [
                    'prenom' => "VendeurPro",
                    'nom' => "Numero {$i}",
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'is_active' => true,
                    'telephone' => '77' . rand(1000000, 9999999),
                ]
            );
            $user->assignRole('vendeur');

            $vendeur = Vendeur::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'type' => 'professionnel',
                    'statut_verification' => 'verifie',
                    'actif' => true,
                    'verifie_le' => now(),
                ]
            );

            VendeurProfessionnel::firstOrCreate(
                ['vendeur_id' => $vendeur->id],
                [
                    'nom_entreprise' => "Entreprise Pro {$i}",
                    'numero_registre_commerce' => "RC-SN-DKR-2023-B-{$i}000",
                    'numero_identification_fiscale' => "NINEA-{$i}0000",
                    'adresse_entreprise' => "Zone Industrielle {$i}, Dakar",
                    'telephone_entreprise' => '33' . rand(1000000, 9999999),
                    'email_entreprise' => "contact@pro{$i}.com",
                ]
            );

            $this->createAnnoncesForVendeur($vendeur, $categories);
        }
        
        $this->command->info('Marketplace Demo Data Seeded Successfully!');
    }

    private function getOrCreateCategory($name, $family)
    {
        // Try to find a category with this family first
        $cat = Category::where('famille', $family)->first();
        if ($cat) return $cat;

        // If not, try to find by name and update/set family
        $cat = Category::where('nom', 'LIKE', "%{$name}%")->first();
        if ($cat) {
            $cat->famille = $family;
            $cat->save();
            return $cat;
        }

        // Create new one
        return Category::create([
            'nom' => $name,
            'slug' => Str::slug($name),
            'famille' => $family,
            'actif' => true,
            'ordre' => 0,
            'description' => "Catégorie demo pour {$family}",
        ]);
    }

    private function createAnnoncesForVendeur($vendeur, $categories)
    {
        // 1. E-commerce Product
        $this->createEcommerceAnnonce($vendeur, $categories[Category::FAMILLE_ECOMMERCE]);

        // 2. Service
        $this->createServiceAnnonce($vendeur, $categories[Category::FAMILLE_SERVICES]);

        // 3. Immobilier
        $this->createImmobilierAnnonce($vendeur, $categories[Category::FAMILLE_IMMOBILIER]);

        // 4. Véhicule
        $this->createVehiculeAnnonce($vendeur, $categories[Category::FAMILLE_VEHICULES]);
    }

    private function createEcommerceAnnonce($vendeur, $category)
    {
        $titre = 'Smartphone Model ' . rand(100, 999);
        $annonce = Annonce::create([
            'vendeur_id' => $vendeur->id,
            'categorie_id' => $category->id,
            'type' => Annonce::TYPE_PRODUIT,
            'titre' => $titre,
            'slug' => Str::slug($titre . '-' . uniqid()),
            'prix' => rand(50000, 500000),
            'description' => 'Un excellent smartphone avec toutes les fonctionnalités modernes.',
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
            'disponibilite' => Annonce::DISPONIBILITE_EN_STOCK,
            'type_livraison' => 'expedition', // Important for E-commerce
        ]);

        AnnonceProduit::create([
            'annonce_id' => $annonce->id,
            'marque' => 'Samsung',
            'etat' => 'Neuf',
            'quantite' => rand(1, 50),
        ]);
    }

    private function createServiceAnnonce($vendeur, $category)
    {
        $titre = 'Service de Plomberie ' . rand(1, 100);
        $annonce = Annonce::create([
            'vendeur_id' => $vendeur->id,
            'categorie_id' => $category->id,
            'type' => Annonce::TYPE_SERVICE,
            'titre' => $titre,
            'slug' => Str::slug($titre . '-' . uniqid()),
            'prix' => rand(5000, 50000),
            'description' => 'Réparation de fuites et installation sanitaire.',
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
        ]);

        AnnonceService::create([
            'annonce_id' => $annonce->id,
            'type_tarification' => AnnonceService::TARIF_HORAIRE,
            'tarif_horaire' => 5000,
            'zone_intervention' => 'Dakar et banlieue',
        ]);
    }

    private function createImmobilierAnnonce($vendeur, $category)
    {
        $titre = 'Appartement F' . rand(2, 5) . ' à Louer';
        $annonce = Annonce::create([
            'vendeur_id' => $vendeur->id,
            'categorie_id' => $category->id,
            'type' => Annonce::TYPE_IMMOBILIER,
            'titre' => $titre,
            'slug' => Str::slug($titre . '-' . uniqid()),
            'prix' => rand(150000, 1500000), // Loyer
            'description' => 'Bel appartement spacieux, bien situé.',
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
        ]);

        AnnonceImmobilier::create([
            'annonce_id' => $annonce->id,
            'type_transaction' => AnnonceImmobilier::TRANSACTION_LOCATION,
            'loyer_mensuel' => $annonce->prix,
            'surface' => rand(50, 200),
            'nombre_pieces' => rand(2, 5),
            'ville' => 'Dakar',
            'adresse' => 'Quartier Résidentiel',
        ]);
    }

    private function createVehiculeAnnonce($vendeur, $category)
    {
        $titre = 'Toyota Corolla ' . rand(2015, 2022);
        $annonce = Annonce::create([
            'vendeur_id' => $vendeur->id,
            'categorie_id' => $category->id,
            'type' => Annonce::TYPE_VEHICULE,
            'titre' => $titre,
            'slug' => Str::slug($titre . '-' . uniqid()),
            'prix' => rand(3000000, 12000000),
            'description' => 'Véhicule en très bon état, climatisé.',
            'statut' => Annonce::STATUT_PUBLIEE,
            'publiee_le' => now(),
        ]);

        AnnonceVehicule::create([
            'annonce_id' => $annonce->id,
            'marque' => 'Toyota',
            'modele' => 'Corolla',
            'annee' => rand(2015, 2022),
            'kilometrage' => rand(20000, 150000),
            'carburant' => 'Essence',
            'boite_vitesse' => 'Automatique',
        ]);
    }
}
