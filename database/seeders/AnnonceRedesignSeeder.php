<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Annonce;
use App\Models\Category;
use App\Models\Vendeur;
use App\Models\VendeurParticulier;
use App\Services\AnnonceService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AnnonceRedesignSeeder extends Seeder
{
    protected $annonceService;

    public function __construct(AnnonceService $annonceService)
    {
        $this->annonceService = $annonceService;
    }

    public function run(): void
    {
        // 1. Trouver ou créer un utilisateur de test
        $user = User::where('email', 'test_vendeur@example.com')->first();
        if (!$user) {
            $user = User::create([
                'prenom' => 'Test',
                'nom' => 'Vendeur',
                'email' => 'test_vendeur@example.com',
                'password' => Hash::make('password'),
                'telephone' => '+221770000000',
                'code_postal' => '12500',
                'email_verified_at' => now(),
            ]);
        }

        // 2. Assigner le rôle Vendeur Particulier (s'il ne l'a pas déjà)
        if (!$user->hasRole('Vendeur Particulier')) {
            $user->assignRole('Vendeur Particulier');
        }

        // 3. Créer ou récupérer le compte vendeur
        $vendeur = $user->vendeur;
        if (!$vendeur) {
            $vendeur = Vendeur::create([
                'user_id' => $user->id,
                'type' => 'particulier',
                'statut_verification' => 'en_attente',
                'actif' => true,
            ]);

            VendeurParticulier::create([
                'vendeur_id' => $vendeur->id,
                'type_document' => 'cni',
                'numero_document' => 'TEST12345',
            ]);
        }

        // 4. Créer deux annonces tests
        $categories = Category::limit(2)->get();

        if ($categories->isEmpty()) {
            $this->command->error('Aucune catégorie trouvée !');
            return;
        }

        $testData = [
            [
                'titre' => 'iPhone 13 Pro Max - État Clinique',
                'categorie_id' => $categories[0]->id,
                'prix' => 450000,
                'description' => 'Un iPhone 13 Pro Max en excellent état, peu utilisé. Batterie 95%. Boîte et accessoires inclus.',
                'type_livraison' => 'livraison_domicile',
                'statut' => 'publiee',
                'quantite' => 1,
                'etat' => 'Occasion',
            ],
            [
                'titre' => 'Canapé 3 places - Design Moderne',
                'categorie_id' => $categories->count() > 1 ? $categories[1]->id : $categories[0]->id,
                'prix' => 150000,
                'description' => 'Canapé confortable et élégant pour votre salon. Couleur gris anthracite, comme neuf.',
                'type_livraison' => 'retrait_boutique',
                'statut' => 'publiee',
                'quantite' => 2,
                'etat' => 'Neuf',
            ]
        ];

        foreach ($testData as $data) {
            try {
                $this->annonceService->creerAnnonce($vendeur, $data, 'produit');
                $this->command->info("Annonce '{$data['titre']}' créée avec succès.");
            } catch (\Exception $e) {
                $this->command->error("Erreur lors de la création de '{$data['titre']}': " . $e->getMessage());
            }
        }
    }
}
