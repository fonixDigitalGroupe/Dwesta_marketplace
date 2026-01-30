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

        $acheteurs = User::role('acheteur')->get();
        $annonces = Annonce::where('statut', 'publiee')->get();
        $vendeurs = Vendeur::where('statut_verification', 'verifie')->get();

        if ($acheteurs->isEmpty()) {
            $this->command->warn('Pas d\'acheteurs trouvés pour créer des avis.');
            return;
        }

        $commentaires = [
            5 => ['Excellent produit !', 'Vendeur pro.', 'Livraison rapide.', 'Parfait !', 'Top qualité.'],
            4 => ['Bon produit.', 'Satisfait.', 'Vendeur réactif.', 'Bien.'],
            3 => ['Correct.', 'Conforme.', 'Acceptable.'],
            2 => ['Déçu.', 'Moyen.'],
            1 => ['Très déçu.', 'Défectueux.'],
        ];

        // Créer des avis sur annonces (sans doublons)
        $pairs = [];
        $count = 0;
        $maxAttempts = 100;

        while ($count < 20 && $maxAttempts > 0) {
            $note = rand(3, 5);
            $annonce = $annonces->random();
            $acheteur = $acheteurs->random();
            $key = "annonce-{$annonce->id}-user-{$acheteur->id}";

            if (!isset($pairs[$key])) {
                Review::create([
                    'reviewer_id' => $acheteur->id,
                    'reviewable_type' => Annonce::class,
                    'reviewable_id' => $annonce->id,
                    'rating' => $note,
                    'comment' => $commentaires[$note][array_rand($commentaires[$note])],
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
                $pairs[$key] = true;
                $count++;
            }
            $maxAttempts--;
        }

        // Créer des avis sur vendeurs (sans doublons)
        $count = 0;
        $maxAttempts = 100;
        while ($count < 10 && $maxAttempts > 0) {
            $note = rand(3, 5);
            $vendeur = $vendeurs->random();
            $acheteur = $acheteurs->random();
            $key = "vendeur-{$vendeur->id}-user-{$acheteur->id}";

            if (!isset($pairs[$key])) {
                Review::create([
                    'reviewer_id' => $acheteur->id,
                    'reviewable_type' => Vendeur::class,
                    'reviewable_id' => $vendeur->id,
                    'rating' => $note,
                    'comment' => $commentaires[$note][array_rand($commentaires[$note])],
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
                $pairs[$key] = true;
                $count++;
            }
            $maxAttempts--;
        }

        $this->command->info("✓ Avis créés : $count avis générés avec succès.");
    }
}
