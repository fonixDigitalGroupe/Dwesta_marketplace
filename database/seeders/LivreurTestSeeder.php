<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Livreur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class LivreurTestSeeder extends Seeder
{
    public function run(): void
    {
        // Assurer que le rôle existe
        if (!Role::where('name', 'livreur')->exists()) {
            Role::create(['name' => 'livreur']);
        }

        // Créer l'utilisateur Livreur
        $livreurUser = User::firstOrCreate(
            ['email' => 'livreur@test.com'],
            [
                'prenom' => 'Moussa',
                'nom' => 'Diop',
                'password' => Hash::make('password'),
                'civilite' => 'M.',
                'telephone' => '+221778889900',
                'date_de_naissance' => '1998-05-15',
                'nationalite' => 'Sénégalaise',
                'adresse' => 'Dakar, Colobane',
                'email_verified_at' => now(),
                'telephone_verified_at' => now(),
            ]
        );

        $livreurUser->assignRole('livreur');

        // Créer le profil Livreur associé avec tous les champs requis
        if ($livreurUser->livreur()->count() === 0) {
            Livreur::create([
                'user_id' => $livreurUser->id,
                'type_vehicule' => 'Scooter',
                'type_document' => 'CNI',
                'numero_document' => '1234567890',
                'document_recto' => 'seed/path/to/recto.jpg',
                'document_verso' => 'seed/path/to/verso.jpg',
                'statut_verification' => 'approuve',
                'actif' => true,
            ]);
        }


        $this->command->info('Utilisateur Livreur créé avec succès !');
        $this->command->info('Email : livreur@test.com');
        $this->command->info('Mot de passe : password');
    }
}
