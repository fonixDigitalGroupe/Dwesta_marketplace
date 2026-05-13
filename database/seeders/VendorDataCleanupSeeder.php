<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class VendorDataCleanupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key constraints to allow truncation
        Schema::disableForeignKeyConstraints();

        $tables = [
            'annonce_medias',
            'annonce_options',
            'annonce_variantes',
            'annonce_attributes',
            'annonce_produits',
            'annonce_services',
            'annonce_immobiliers',
            'annonce_vehicules',
            'annonce_credit_services',
            'avis',
            'favorites',
            'cart_items',
            'order_items',
            'transactions',
            'litiges',
            'annonces',
            'vendeur_particuliers',
            'vendeur_professionnels',
            'page_pro',
            'vendeur_abonnements',
            'vendeurs',
            'orders',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                $this->command?->info("Table $table tronquée.");
            }
        }

        // Nettoyage optionnel des colonnes liées dans la table users (si nécessaire)
        // Mais ici on garde les utilisateurs, on supprime juste leur statut vendeur et données liées.

        // Re-enable foreign key constraints
        Schema::enableForeignKeyConstraints();

        $this->command?->info('✓ Toutes les données vendeurs et produits ont été supprimées.');
    }
}
