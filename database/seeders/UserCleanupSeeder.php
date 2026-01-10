<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCleanupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Supprimer tous les utilisateurs
        \App\Models\User::query()->delete();

        // Créer l'Admin
        $admin = \App\Models\User::create([
            'civilite' => 'Monsieur',
            'prenom' => 'Admin',
            'nom' => 'Mady',
            'email' => 'admin@madymarket.com',
            'date_de_naissance' => '1990-01-01',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Administrateur');

        // Créer le Vendeur
        $vendeur = \App\Models\User::create([
            'civilite' => 'Monsieur',
            'prenom' => 'Vendeur',
            'nom' => 'Pro',
            'email' => 'vendeur@madymarket.com',
            'date_de_naissance' => '1985-05-15',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $vendeur->assignRole('Vendeur Professionnel');

        // Créer l'Acheteur
        $acheteur = \App\Models\User::create([
            'civilite' => 'Madame',
            'prenom' => 'Acheteuse',
            'nom' => 'Claire',
            'email' => 'acheteur@madymarket.com',
            'date_de_naissance' => '1995-10-20',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'email_verified_at' => now(),
        ]);
        $acheteur->assignRole('Acheteur');
    }
}
