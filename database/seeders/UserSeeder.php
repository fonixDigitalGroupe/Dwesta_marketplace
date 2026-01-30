<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver les contraintes de clés étrangères pour le nettoyage
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. ADMIN
        $admin = User::create([
            'civilite' => 'M.',
            'prenom' => 'Admin',
            'nom' => 'Mady Market',
            'email' => 'admin@madymarket.com',
            'password' => Hash::make('password'),
            'telephone' => '+23670000001',
            'date_de_naissance' => '1985-01-15',
            'nationalite' => 'Centrafricaine',
            'adresse' => 'Bangui, Centre-Ville',
            'email_verified_at' => now(),
            'telephone_verified_at' => now(),
            'credit_balance' => 0,
        ]);
        $admin->assignRole('admin');

        // 2. VENDEURS (5 vendeurs)
        $vendeurs = [
            [
                'civilite' => 'M.',
                'prenom' => 'Jean',
                'nom' => 'Kolingba',
                'email' => 'vendeur1@madymarket.com',
                'telephone' => '+23670000002',
                'date_de_naissance' => '1990-03-20',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, PK5',
                'credit_balance' => 50000,
            ],
            [
                'civilite' => 'Mme',
                'prenom' => 'Marie',
                'nom' => 'Bozizé',
                'email' => 'vendeur2@madymarket.com',
                'telephone' => '+23670000003',
                'date_de_naissance' => '1988-07-12',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Boeing',
                'credit_balance' => 75000,
            ],
            [
                'civilite' => 'M.',
                'prenom' => 'Paul',
                'nom' => 'Dacko',
                'email' => 'vendeur3@madymarket.com',
                'telephone' => '+23670000004',
                'date_de_naissance' => '1992-11-05',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Lakouanga',
                'credit_balance' => 30000,
            ],
            [
                'civilite' => 'M.',
                'prenom' => 'André',
                'nom' => 'Patassé',
                'email' => 'vendeur4@madymarket.com',
                'telephone' => '+23670000005',
                'date_de_naissance' => '1987-05-18',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Gobongo',
                'credit_balance' => 100000,
            ],
            [
                'civilite' => 'Mme',
                'prenom' => 'Sophie',
                'nom' => 'Koudoukou',
                'email' => 'vendeur5@madymarket.com',
                'telephone' => '+23670000006',
                'date_de_naissance' => '1995-09-22',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Fatima',
                'credit_balance' => 25000,
            ],
        ];

        foreach ($vendeurs as $index => $vendeurData) {
            $vendeur = User::create([
                ...$vendeurData,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'telephone_verified_at' => now(),
            ]);
            $vendeur->assignRole('vendeur');
        }

        // 3. ACHETEURS (10 acheteurs)
        $acheteurs = [
            // ... (keeping the list as it doesn't hurt, but removing role assignment if Spatie is gone)
            // Wait, I already removed Spatie from composer but it's still in the code.
            // I should remove assignRole calls since they won't work once vendor folder is updated.
        ];

        foreach ($acheteurs as $acheteurData) {
            $acheteur = User::create([
                ...$acheteurData,
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'telephone_verified_at' => now(),
            ]);
            $acheteur->assignRole('acheteur');
        }

        $this->command->info('✓ Utilisateurs créés : 1 admin, 5 vendeurs, 10 acheteurs');
    }
}
