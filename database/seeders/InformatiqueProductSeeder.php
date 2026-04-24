<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\AnnonceProduit;
use App\Models\AnnonceMedia;
use App\Models\Category;
use App\Models\Vendeur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InformatiqueProductSeeder extends Seeder
{
    private array $images = [
        'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=400&fit=crop',
        'https://images.unsplash.com/photo-1587831990711-23ca6441447b?w=400&fit=crop',
        'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=400&fit=crop',
        'https://images.unsplash.com/photo-1504991679164-ba7fda7b5fb1?w=400&fit=crop',
        'https://images.unsplash.com/photo-1527814050087-3793815479db?w=400&fit=crop',
        'https://images.unsplash.com/photo-1531492746076-161ca9bcad58?w=400&fit=crop',
    ];

    private array $motsKeys = ['Laptop', 'Souris', 'Clavier', 'Ecran', 'Disque', 'SSD', 'Cable', 'Imprimante', 'Routeur', 'Webcam'];

    public function run(): void
    {
        $vendeur = Vendeur::inRandomOrder()->first();
        if (!$vendeur) {
            $this->command->error("Aucun vendeur trouvé.");
            return;
        }

        $categorie = Category::where('nom', 'like', '%Informatique%')->first();
        if (!$categorie) {
            $this->command->error("Categorie Informatique introuvable.");
            return;
        }

        $this->command->info("Insertion de 30 annonces dans " . $categorie->nom);

        for ($i = 1; $i <= 30; $i++) {
            $mot = $this->motsKeys[array_rand($this->motsKeys)];
            $titre = "$mot Pro " . Str::random(3) . " - Edition Spéciale";
            
            $annonce = Annonce::create([
                'vendeur_id'   => $vendeur->id,
                'categorie_id' => $categorie->id,
                'type'         => Annonce::TYPE_PRODUIT,
                'titre'        => $titre,
                'slug'         => Annonce::generateSlug($titre) . '-' . Str::random(4),
                'prix'         => rand(15000, 500000),
                'description'  => "Ce $mot est en parfait état et prêt à être expédié.",
                'statut'       => Annonce::STATUT_PUBLIEE,
                'publiee_le'   => now()->subDays(rand(0, 10)),
                'expire_le'    => now()->addDays(60),
                'vues'         => rand(5, 500),
            ]);

            AnnonceProduit::create([
                'annonce_id' => $annonce->id,
                'etat'       => collect(['Neuf', 'Occasion', 'Reconditionné'])->random(),
                'quantite'   => rand(1, 10),
            ]);

            AnnonceMedia::create([
                'annonce_id'    => $annonce->id,
                'type'          => 'photo',
                'chemin'        => $this->images[array_rand($this->images)],
                'est_principale' => true,
                'ordre'         => 1,
            ]);
        }

        $this->command->info("✅ 30 produits ajoutés avec succès !");
    }
}
