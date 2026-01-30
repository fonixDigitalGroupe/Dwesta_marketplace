<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\AnnonceProduit;
use App\Models\AnnonceService;
use App\Models\AnnonceImmobilier;
use App\Models\AnnonceVehicule;
use App\Models\AnnonceMedia;
use App\Models\AnnonceOption;
use App\Models\Category;
use App\Models\Vendeur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AnnonceSeeder extends Seeder
{
    public function run(): void
    {
        // Nettoyage
        Schema::disableForeignKeyConstraints();
        Annonce::truncate();
        AnnonceProduit::truncate();
        AnnonceService::truncate();
        AnnonceImmobilier::truncate();
        AnnonceVehicule::truncate();
        AnnonceMedia::truncate();
        AnnonceOption::truncate();
        Schema::enableForeignKeyConstraints();

        $vendeurs = Vendeur::where('statut_verification', 'verifie')->get();
        
        if ($vendeurs->isEmpty()) {
            $this->command->warn('Aucun vendeur vérifié trouvé. Exécutez d\'abord VendeurSeeder.');
            return;
        }

        // --- PRODUITS (15 annonces) ---
        $this->createProduits($vendeurs);

        // --- SERVICES (10 annonces) ---
        $this->createServices($vendeurs);

        // --- IMMOBILIER (10 annonces) ---
        $this->createImmobilier($vendeurs);

        // --- VÉHICULES (10 annonces) ---
        $this->createVehicules($vendeurs);

        $this->command->info('✓ Annonces créées : 15 produits, 10 services, 10 immobilier, 10 véhicules');
    }

    private function createProduits($vendeurs)
    {
        $catElectronique = Category::where('slug', 'electronique')->first();
        $catMode = Category::where('slug', 'mode')->first();
        $catMaison = Category::where('slug', 'maison')->first();
        $catSport = Category::where('slug', 'sport-et-loisirs')->first();

        $produits = [
            ['cat' => $catElectronique, 'titre' => 'iPhone 15 Pro Max 256GB', 'prix' => 850000, 'desc' => 'Neuf, scellé. Garantie 1 an.', 'etat' => 'neuf', 'stock' => 5],
            ['cat' => $catElectronique, 'titre' => 'MacBook Air M2 2024', 'prix' => 750000, 'desc' => 'Parfait état, batterie 100%.', 'etat' => 'comme_neuf', 'stock' => 3],
            ['cat' => $catElectronique, 'titre' => 'Samsung Galaxy S24 Ultra', 'prix' => 780000, 'desc' => 'Neuf, toutes couleurs disponibles.', 'etat' => 'neuf', 'stock' => 8],
            ['cat' => $catElectronique, 'titre' => 'iPad Pro 12.9" M2', 'prix' => 650000, 'desc' => 'Avec Apple Pencil inclus.', 'etat' => 'neuf', 'stock' => 4],
            ['cat' => $catElectronique, 'titre' => 'Sony PlayStation 5', 'prix' => 450000, 'desc' => 'Console + 2 manettes + 3 jeux.', 'etat' => 'occasion', 'stock' => 2],
            
            ['cat' => $catMode, 'titre' => 'Sac à main Louis Vuitton', 'prix' => 180000, 'desc' => 'Authentique, avec certificat.', 'etat' => 'comme_neuf', 'stock' => 1],
            ['cat' => $catMode, 'titre' => 'Montre Rolex Submariner', 'prix' => 5500000, 'desc' => 'Authentique, boîte et papiers.', 'etat' => 'occasion', 'stock' => 1],
            ['cat' => $catMode, 'titre' => 'Baskets Nike Air Jordan 1', 'prix' => 95000, 'desc' => 'Neuves, taille 42.', 'etat' => 'neuf', 'stock' => 10],
            
            ['cat' => $catMaison, 'titre' => 'Canapé d\'angle 5 places', 'prix' => 250000, 'desc' => 'Tissu gris, très confortable.', 'etat' => 'neuf', 'stock' => 2],
            ['cat' => $catMaison, 'titre' => 'Table à manger + 6 chaises', 'prix' => 180000, 'desc' => 'Bois massif, style moderne.', 'etat' => 'neuf', 'stock' => 3],
            ['cat' => $catMaison, 'titre' => 'Réfrigérateur Samsung 400L', 'prix' => 320000, 'desc' => 'Neuf, garantie 2 ans.', 'etat' => 'neuf', 'stock' => 5],
            
            ['cat' => $catSport ?: $catElectronique, 'titre' => 'Vélo VTT Décathlon', 'prix' => 120000, 'desc' => 'Excellent état, peu utilisé.', 'etat' => 'occasion', 'stock' => 1],
            ['cat' => $catSport ?: $catElectronique, 'titre' => 'Tapis de course électrique', 'prix' => 280000, 'desc' => 'Neuf, pliable, écran LCD.', 'etat' => 'neuf', 'stock' => 2],
            ['cat' => $catSport ?: $catElectronique, 'titre' => 'Set de golf complet', 'prix' => 350000, 'desc' => 'Clubs + sac + accessoires.', 'etat' => 'comme_neuf', 'stock' => 1],
            ['cat' => $catSport ?: $catElectronique, 'titre' => 'Ballon de football Nike', 'prix' => 15000, 'desc' => 'Taille 5, officiel.', 'etat' => 'neuf', 'stock' => 20],
        ];

        foreach ($produits as $index => $p) {
            if (!$p['cat']) continue;
            
            $vendeur = $vendeurs->random();
            $statut = $index < 12 ? 'publiee' : ($index == 12 ? 'en_attente' : 'brouillon');
            
            $annonce = Annonce::create([
                'vendeur_id' => $vendeur->id,
                'categorie_id' => $p['cat']->id,
                'type' => 'produit',
                'titre' => $p['titre'],
                'slug' => Str::slug($p['titre'] . '-' . uniqid()),
                'description' => $p['desc'],
                'prix' => $p['prix'],
                'statut' => $statut,
                'publiee_le' => $statut == 'publiee' ? now()->subDays(rand(1, 30)) : null,
                'expire_le' => $statut == 'publiee' ? now()->addDays(30) : null,
                'vues' => $statut == 'publiee' ? rand(10, 500) : 0,
            ]);

            AnnonceProduit::create([
                'annonce_id' => $annonce->id,
                'etat' => $p['etat'],
                'quantite' => $p['stock'],
            ]);

            if ($index < 3) {
                AnnonceOption::create([
                    'annonce_id' => $annonce->id,
                    'a_la_une' => true,
                    'a_la_une_expire_le' => now()->addDays(7),
                    'urgent' => $index == 0,
                    'urgent_expire_le' => $index == 0 ? now()->addDays(3) : null,
                ]);
            }
        }
    }

    private function createServices($vendeurs)
    {
        $catAdom = Category::where('slug', 'services-a-la-personne')->first();
        $catPro = Category::where('slug', 'services-aux-professionnels')->first();
        $catSante = Category::where('slug', 'sante-et-bien-etre')->first();

        $services = [
            ['cat' => $catAdom, 'titre' => 'Électricien qualifié - Bangui', 'prix' => 0, 'desc' => 'Installation et dépannage 24/7. Devis gratuit.'],
            ['cat' => $catAdom, 'titre' => 'Plombier professionnel', 'prix' => 0, 'desc' => 'Tous travaux de plomberie. Intervention rapide.'],
            ['cat' => $catAdom, 'titre' => 'Ménage et repassage', 'prix' => 25000, 'desc' => 'Service de ménage professionnel. Prix par jour.'],
            
            ['cat' => $catPro, 'titre' => 'Comptable certifié', 'prix' => 0, 'desc' => 'Tenue de comptabilité pour PME.'],
            ['cat' => $catPro, 'titre' => 'Développeur Web & Mobile', 'prix' => 0, 'desc' => 'Création sites web et applications.'],
            
            ['cat' => $catSante, 'titre' => 'Coach Sportif', 'prix' => 15000, 'desc' => 'Entraînement personnalisé.'],
            ['cat' => $catSante, 'titre' => 'Massage Relaxant', 'prix' => 20000, 'desc' => 'Massage professionnel à domicile.'],
        ];

        foreach ($services as $index => $s) {
            if (!$s['cat']) continue;
            
            $vendeur = $vendeurs->random();
            $statut = $index < 8 ? 'publiee' : 'en_attente';
            
            $annonce = Annonce::create([
                'vendeur_id' => $vendeur->id,
                'categorie_id' => $s['cat']->id,
                'type' => 'service',
                'titre' => $s['titre'],
                'slug' => Str::slug($s['titre'] . '-' . uniqid()),
                'description' => $s['desc'],
                'prix' => $s['prix'],
                'statut' => $statut,
                'publiee_le' => $statut == 'publiee' ? now()->subDays(rand(1, 30)) : null,
                'vues' => $statut == 'publiee' ? rand(10, 300) : 0,
            ]);

            AnnonceService::create([
                'annonce_id' => $annonce->id,
            ]);
        }
    }

    private function createImmobilier($vendeurs)
    {
        $catVente = Category::where('slug', 'vente-immobiliere')->first();
        $catLocation = Category::where('slug', 'location-immobiliere')->first();

        $immobiliers = [
            ['cat' => $catLocation, 'titre' => 'T3 Centre-Ville Bangui', 'prix' => 350000, 'type' => 'location', 'surface' => 85, 'pieces' => 3],
            ['cat' => $catLocation, 'titre' => 'Studio meublé PK5', 'prix' => 150000, 'type' => 'location', 'surface' => 35, 'pieces' => 1],
            ['cat' => $catVente, 'titre' => 'Villa modern avec piscine', 'prix' => 120000000, 'type' => 'vente', 'surface' => 350, 'pieces' => 6],
            ['cat' => $catVente, 'titre' => 'Terrain 500m² viabilisé', 'prix' => 15000000, 'type' => 'vente', 'surface' => 500, 'pieces' => 0],
        ];

        foreach ($immobiliers as $index => $i) {
            if (!$i['cat']) continue;
            
            $vendeur = $vendeurs->random();
            $statut = $index < 4 ? 'publiee' : 'brouillon';
            
            $annonce = Annonce::create([
                'vendeur_id' => $vendeur->id,
                'categorie_id' => $i['cat']->id,
                'type' => 'immobilier',
                'titre' => $i['titre'],
                'slug' => Str::slug($i['titre'] . '-' . uniqid()),
                'description' => $i['titre'] . '. Contactez-nous pour plus d\'informations.',
                'prix' => $i['prix'],
                'statut' => $statut,
                'publiee_le' => $statut == 'publiee' ? now()->subDays(rand(1, 30)) : null,
                'vues' => $statut == 'publiee' ? rand(20, 400) : 0,
            ]);

            AnnonceImmobilier::create([
                'annonce_id' => $annonce->id,
                'type_transaction' => $i['type'],
                'loyer_mensuel' => $i['type'] == 'location' ? $i['prix'] : null,
                'prix_vente' => $i['type'] == 'vente' ? $i['prix'] : null,
                'surface' => $i['surface'],
                'nombre_pieces' => $i['pieces'],
            ]);
        }
    }

    private function createVehicules($vendeurs)
    {
        $catVoitures = Category::where('slug', 'voitures')->first();
        $catMotos = Category::where('slug', 'motos-et-deux-roues')->first();

        $vehicules = [
            ['cat' => $catVoitures, 'titre' => 'Toyota Hilux 4x4 2022', 'prix' => 25000000, 'marque' => 'Toyota', 'modele' => 'Hilux', 'annee' => 2022, 'km' => 15000, 'trans' => 'automatique'],
            ['cat' => $catVoitures, 'titre' => 'Mercedes Classe C 2021', 'prix' => 22000000, 'marque' => 'Mercedes', 'modele' => 'Classe C', 'annee' => 2021, 'km' => 25000, 'trans' => 'automatique'],
            ['cat' => $catMotos, 'titre' => 'Yamaha R1 2020', 'prix' => 8500000, 'marque' => 'Yamaha', 'modele' => 'R1', 'annee' => 2020, 'km' => 12000, 'trans' => 'manuelle'],
        ];

        foreach ($vehicules as $index => $v) {
            if (!$v['cat']) continue;
            
            $vendeur = $vendeurs->random();
            $statut = $index < 3 ? 'publiee' : 'en_attente';
            
            $annonce = Annonce::create([
                'vendeur_id' => $vendeur->id,
                'categorie_id' => $v['cat']->id,
                'type' => 'vehicule',
                'titre' => $v['titre'],
                'slug' => Str::slug($v['titre'] . '-' . uniqid()),
                'description' => 'Véhicule en excellent état. Entretien régulier. Papiers à jour.',
                'prix' => $v['prix'],
                'statut' => $statut,
                'publiee_le' => $statut == 'publiee' ? now()->subDays(rand(1, 30)) : null,
                'vues' => $statut == 'publiee' ? rand(30, 600) : 0,
            ]);

            AnnonceVehicule::create([
                'annonce_id' => $annonce->id,
                'marque' => $v['marque'],
                'modele' => $v['modele'],
                'annee' => $v['annee'],
                'kilometrage' => $v['km'],
                'boite_vitesse' => $v['trans'],
            ]);
        }
    }
}
