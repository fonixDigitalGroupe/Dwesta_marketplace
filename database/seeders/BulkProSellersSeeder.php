<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\AnnonceProduit;
use App\Models\AnnonceService;
use App\Models\AnnonceImmobilier;
use App\Models\AnnonceVehicule;
use App\Models\Category;
use App\Models\User;
use App\Models\Vendeur;
use App\Models\VendeurProfessionnel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BulkProSellersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fr_FR');
        
        $familles = [
            Category::FAMILLE_ECOMMERCE,
            Category::FAMILLE_SERVICES,
            Category::FAMILLE_IMMOBILIER,
            Category::FAMILLE_VEHICULES,
        ];

        $categoriesByFamily = [];
        foreach ($familles as $famille) {
            $categoriesByFamily[$famille] = Category::where('famille', $famille)->get();
        }

        $this->command->info('Création de 10 vendeurs professionnels...');

        for ($i = 1; $i <= 10; $i++) {
            // 1. Créer l'utilisateur
            $user = User::create([
                'prenom' => $faker->firstName,
                'nom' => $faker->lastName,
                'email' => "pro.seller{$i}@karnou.com",
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);

            // 2. Créer le vendeur
            $vendeur = Vendeur::create([
                'user_id' => $user->id,
                'type' => 'professionnel',
                'statut_verification' => 'verifie',
                'verifie_le' => now(),
                'actif' => true,
            ]);

            // 3. Créer les détails pro
            VendeurProfessionnel::create([
                'vendeur_id' => $vendeur->id,
                'nom_entreprise' => $faker->company,
                'numero_registre_commerce' => 'RC-' . strtoupper($faker->bothify('??-####')),
                'date_expiration_registre' => now()->addYears(2),
                'numero_identification_fiscale' => $faker->numerify('NIF-##########'),
                'adresse_entreprise' => $faker->address,
                'telephone_entreprise' => $faker->phoneNumber,
                'email_entreprise' => $user->email,
                'description_entreprise' => $faker->paragraph,
            ]);

            // 3bis. Créer la Page Pro (Boutique)
            \App\Models\PagePro::create([
                'vendeur_id' => $vendeur->id,
                'slug' => \App\Models\PagePro::generateSlug($vendeur->professionnel->nom_entreprise),
                'description' => $vendeur->professionnel->description_entreprise,
                'actif' => true,
                'email_contact' => $user->email,
                'telephone_contact' => $vendeur->professionnel->telephone_entreprise,
            ]);

            $this->command->info("- Vendeur {$i} créé : " . $vendeur->professionnel->nom_entreprise);

            // 4. Créer 10 annonces pour ce vendeur
            for ($j = 1; $j <= 10; $j++) {
                // Choisir une famille tournante
                $famille = $familles[($j - 1) % count($familles)];
                $category = $categoriesByFamily[$famille]->random();

                $titre = "Annonce #{$j} - " . $faker->sentence(3);
                $prix = $faker->randomFloat(0, 1000, 1000000);
                
                $type = 'produit';
                if ($famille === Category::FAMILLE_SERVICES) $type = 'service';
                if ($famille === Category::FAMILLE_IMMOBILIER) $type = 'immobilier';
                if ($famille === Category::FAMILLE_VEHICULES) $type = 'vehicule';

                $prix_original = rand(0, 1) === 1 ? $prix * rand(1.1, 1.4) : null;

                $annonce = Annonce::create([
                    'vendeur_id' => $vendeur->id,
                    'categorie_id' => $category->id,
                    'type' => $type,
                    'titre' => $titre,
                    'slug' => Str::slug($titre . '-' . uniqid()),
                    'description' => $faker->paragraphs(3, true),
                    'prix' => $prix,
                    'prix_original' => $prix_original,
                    'statut' => 'publiee',
                    'publiee_le' => now()->subHours(rand(1, 100)),
                    'expire_le' => now()->addDays(30),
                    'vues' => rand(5, 200),
                ]);

                // Créer le modèle spécifique
                switch ($type) {
                    case 'produit':
                        AnnonceProduit::create([
                            'annonce_id' => $annonce->id,
                            'etat' => $faker->randomElement(['neuf', 'occasion', 'comme_neuf']),
                            'quantite' => rand(1, 50),
                            'marque' => $faker->word,
                            'modele' => $faker->word,
                        ]);
                        break;
                    case 'service':
                        AnnonceService::create(['annonce_id' => $annonce->id]);
                        break;
                    case 'immobilier':
                        AnnonceImmobilier::create([
                            'annonce_id' => $annonce->id,
                            'type_transaction' => $faker->randomElement(['vente', 'location']),
                            'surface' => rand(20, 500),
                            'nombre_pieces' => rand(1, 10),
                        ]);
                        break;
                    case 'vehicule':
                        AnnonceVehicule::create([
                            'annonce_id' => $annonce->id,
                            'marque' => $faker->randomElement(['Toyota', 'Mercedes', 'Nissan', 'Hyundai']),
                            'modele' => $faker->word,
                            'annee' => rand(2010, 2024),
                            'kilometrage' => rand(0, 200000),
                            'boite_vitesse' => $faker->randomElement(['manuelle', 'automatique']),
                        ]);
                        break;
                }
            }
        }

        $this->command->info('BulkProSellersSeeder terminé avec succès !');
    }
}
