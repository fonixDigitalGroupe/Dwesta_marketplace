<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,              // Rôles (admin, vendeur, acheteur) — DOIT ÊTRE EN PREMIER
            UserSeeder::class,              // Utilisateurs (admin, vendeurs, acheteurs)
            VendeurSeeder::class,           // Profils vendeurs
            AbonnementSeeder::class,        // Abonnements
            CategorySeeder::class,          // Catégories
            AnnonceSeeder::class,           // Annonces
            OrderSeeder::class,             // Commandes
            TransactionSeeder::class,       // Transactions
            ReviewSeeder::class,            // Avis
            MessageSeeder::class,           // Messages
            CreditTransactionSeeder::class, // Crédits
            LitigeSeeder::class,            // Litiges
            HighlightSeeder::class,         // Actualités (Bento Grid)
        ]);
    }
}
