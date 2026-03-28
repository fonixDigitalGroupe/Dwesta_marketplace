<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\AnnonceProduit;
use App\Models\AnnonceService;
use App\Models\AnnonceImmobilier;
use App\Models\AnnonceVehicule;
use App\Models\Category;
use App\Models\Vendeur;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnnonceDemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Récupérer les vendeurs créés par UserDemoSeeder
        $vendeurEmails = [];
        for ($i = 1; $i <= 5; $i++) {
            $vendeurEmails[] = "vendeur.part$i.demo@example.com";
            $vendeurEmails[] = "vendeur.pro$i.demo@example.com";
        }

        $vendeurs = Vendeur::whereHas('user', function($query) use ($vendeurEmails) {
            $query->whereIn('email', $vendeurEmails);
        })->get();

        if ($vendeurs->isEmpty()) {
            $this->command->warn('Aucun vendeur de démo trouvé. Exécutez d\'abord UserDemoSeeder.');
            return;
        }

        // 2. Récupérer toutes les catégories feuilles (celles qui n'ont pas d'enfants)
        $categories = Category::whereDoesntHave('enfants')->get();

        $this->command->info("Début de la génération pour " . $vendeurs->count() . " vendeurs et " . $categories->count() . " catégories...");

        // 3. Génération des annonces
        foreach ($vendeurs as $vendeur) {
            foreach ($categories as $category) {
                $famille = $this->getCategoryFamille($category);
                $type = $this->getAnnonceType($famille);
                $title = $this->generateTitle($category, $vendeur);
                
                $annonce = Annonce::create([
                    'vendeur_id' => $vendeur->id,
                    'categorie_id' => $category->id,
                    'type' => $type,
                    'titre' => $title,
                    'slug' => Annonce::generateSlug($title),
                    'prix' => rand(500, 500000),
                    'description' => "Ceci est une annonce de démonstration pour $title dans la catégorie {$category->nom}.",
                    'statut' => Annonce::STATUT_PUBLIEE,
                    'publiee_le' => now()->subDays(rand(0, 30)),
                    'expire_le' => now()->addDays(30),
                    'vues' => rand(0, 100),
                ]);
                $annonce->setRelation('vendeur', $vendeur);

                $this->createMetadata($annonce, $category);
            }
        }

        $this->command->info('✓ Génération des annonces terminée.');
    }

    private function getCategoryFamille(Category $category): string
    {
        $current = $category;
        while ($current && empty($current->famille)) {
            $current = $current->parent;
        }
        return $current ? $current->famille : Category::FAMILLE_ECOMMERCE;
    }

    private function getAnnonceType(string $famille): string
    {
        return match ($famille) {
            Category::FAMILLE_SERVICES => Annonce::TYPE_SERVICE,
            Category::FAMILLE_IMMOBILIER => Annonce::TYPE_IMMOBILIER,
            Category::FAMILLE_VEHICULES => Annonce::TYPE_VEHICULE,
            default => Annonce::TYPE_PRODUIT,
        };
    }

    private function generateTitle(Category $category, Vendeur $vendeur): string
    {
        $vendeurName = $vendeur->user->prenom;
        return "{$category->nom} proposé par $vendeurName";
    }

    private function createMetadata(Annonce $annonce, Category $category): void
    {
        switch ($annonce->type) {
            case Annonce::TYPE_PRODUIT:
                $badges = [];
                if ($annonce->vendeur && $annonce->vendeur->type === 'professionnel') {
                    $badges[] = 'Pro';
                }
                AnnonceProduit::create([
                    'annonce_id' => $annonce->id,
                    'etat' => 'Neuf',
                    'quantite' => rand(1, 10),
                    'badges' => !empty($badges) ? $badges : null,
                ]);
                break;
            case Annonce::TYPE_SERVICE:
                AnnonceService::create([
                    'annonce_id' => $annonce->id,
                ]);
                break;
            case Annonce::TYPE_IMMOBILIER:
                AnnonceImmobilier::create([
                    'annonce_id' => $annonce->id,
                    'type_transaction' => rand(0, 1) ? 'location' : 'vente',
                    'surface' => rand(20, 500),
                    'nombre_pieces' => rand(1, 10),
                ]);
                break;
            case Annonce::TYPE_VEHICULE:
                AnnonceVehicule::create([
                    'annonce_id' => $annonce->id,
                    'marque' => 'Marque Démo',
                    'modele' => 'Modèle Démo',
                    'annee' => rand(2010, 2024),
                    'kilometrage' => rand(0, 200000),
                    'boite_vitesse' => rand(0, 1) ? 'manuelle' : 'automatique',
                ]);
                break;
        }
    }
}
