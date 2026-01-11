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
        $admin->assignRole('Administrateur');

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

        foreach ($vendeurs as $vendeurData) {
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
            [
                'civilite' => 'M.',
                'prenom' => 'Ibrahim',
                'nom' => 'Samba',
                'email' => 'acheteur1@madymarket.com',
                'telephone' => '+23670000011',
                'date_de_naissance' => '1993-02-14',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, KM5',
                'credit_balance' => 10000,
            ],
            [
                'civilite' => 'Mme',
                'prenom' => 'Fatima',
                'nom' => 'Oumar',
                'email' => 'acheteur2@madymarket.com',
                'telephone' => '+23670000012',
                'date_de_naissance' => '1991-06-08',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Combattant',
                'credit_balance' => 5000,
            ],
            [
                'civilite' => 'M.',
                'prenom' => 'David',
                'nom' => 'Ngbandi',
                'email' => 'acheteur3@madymarket.com',
                'telephone' => '+23670000013',
                'date_de_naissance' => '1994-10-30',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Miskine',
                'credit_balance' => 15000,
            ],
            [
                'civilite' => 'Mme',
                'prenom' => 'Grace',
                'nom' => 'Mboli',
                'email' => 'acheteur4@madymarket.com',
                'telephone' => '+23670000014',
                'date_de_naissance' => '1989-04-17',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Petevo',
                'credit_balance' => 20000,
            ],
            [
                'civilite' => 'M.',
                'prenom' => 'Samuel',
                'nom' => 'Kette',
                'email' => 'acheteur5@madymarket.com',
                'telephone' => '+23670000015',
                'date_de_naissance' => '1996-12-25',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Fouh',
                'credit_balance' => 8000,
            ],
            [
                'civilite' => 'Mme',
                'prenom' => 'Aïcha',
                'nom' => 'Diallo',
                'email' => 'acheteur6@madymarket.com',
                'telephone' => '+23670000016',
                'date_de_naissance' => '1992-08-19',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Ouango',
                'credit_balance' => 12000,
            ],
            [
                'civilite' => 'M.',
                'prenom' => 'Christian',
                'nom' => 'Zanga',
                'email' => 'acheteur7@madymarket.com',
                'telephone' => '+23670000017',
                'date_de_naissance' => '1990-01-11',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Ngaragba',
                'credit_balance' => 6000,
            ],
            [
                'civilite' => 'Mme',
                'prenom' => 'Sylvie',
                'nom' => 'Banda',
                'email' => 'acheteur8@madymarket.com',
                'telephone' => '+23670000018',
                'date_de_naissance' => '1995-05-07',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Boy-Rabe',
                'credit_balance' => 18000,
            ],
            [
                'civilite' => 'M.',
                'prenom' => 'Rodrigue',
                'nom' => 'Yakoma',
                'email' => 'acheteur9@madymarket.com',
                'telephone' => '+23670000019',
                'date_de_naissance' => '1988-09-03',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Lakouanga',
                'credit_balance' => 22000,
            ],
            [
                'civilite' => 'Mme',
                'prenom' => 'Nadège',
                'nom' => 'Mandja',
                'email' => 'acheteur10@madymarket.com',
                'telephone' => '+23670000020',
                'date_de_naissance' => '1997-03-28',
                'nationalite' => 'Centrafricaine',
                'adresse' => 'Bangui, Galabadja',
                'credit_balance' => 9000,
            ],
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
