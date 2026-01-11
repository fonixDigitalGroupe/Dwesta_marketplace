<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Annonce;
use App\Models\Vendeur;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nettoyage
        Schema::disableForeignKeyConstraints();
        Review::truncate();
        Schema::enableForeignKeyConstraints();

        $acheteurs = User::whereHas('roles', function ($query) {
            $query->where('name', 'acheteur');
        })->get();

        $annonces = Annonce::where('statut', 'publiee')->get();
        $vendeurs = Vendeur::where('statut_verification', 'verifie')->get();

        if ($acheteurs->isEmpty() || $annonces->isEmpty()) {
            $this->command->warn('Pas assez de données pour créer des avis.');
            return;
        }

        $commentaires = [
            5 => [
                'Excellent produit, conforme à la description !',
                'Vendeur très professionnel, je recommande vivement.',
                'Livraison rapide, produit de qualité. Parfait !',
                'Très satisfait de mon achat, merci !',
                'Top qualité, rien à redire. 5 étoiles méritées.',
            ],
            4 => [
                'Bon produit, quelques petits détails à améliorer.',
                'Satisfait dans l\'ensemble, livraison un peu longue.',
                'Produit conforme, vendeur réactif.',
                'Bien, mais le prix pourrait être plus compétitif.',
            ],
            3 => [
                'Produit correct, sans plus.',
                'Conforme à la description mais qualité moyenne.',
                'Acceptable pour le prix.',
            ],
            2 => [
                'Déçu de la qualité, ne correspond pas aux photos.',
                'Livraison très longue, produit moyen.',
            ],
            1 => [
                'Très déçu, produit défectueux.',
                'Ne correspond pas du tout à la description.',
            ],
        ];

        // Créer 30 avis sur annonces
        for ($i = 0; $i < 30; $i++) {
            $note = rand(3, 5); // Majorité de bonnes notes
            $annonce = $annonces->random();
            $acheteur = $acheteurs->random();

            Review::create([
                'reviewer_id' => $acheteur->id,
                'reviewable_type' => Annonce::class,
                'reviewable_id' => $annonce->id,
                'note' => $note,
                'commentaire' => $commentaires[$note][array_rand($commentaires[$note])],
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        // Créer 15 avis sur vendeurs
        for ($i = 0; $i < 15; $i++) {
            $note = rand(3, 5);
            $vendeur = $vendeurs->random();
            $acheteur = $acheteurs->random();

            Review::create([
                'reviewer_id' => $acheteur->id,
                'reviewable_type' => Vendeur::class,
                'reviewable_id' => $vendeur->id,
                'note' => $note,
                'commentaire' => $commentaires[$note][array_rand($commentaires[$note])],
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        $this->command->info('✓ Avis créés : 30 sur annonces, 15 sur vendeurs');
    }
}
