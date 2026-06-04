<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmergencyWipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Désactiver les contraintes de clés étrangères
        Schema::disableForeignKeyConstraints();

        // 2. Récupérer toutes les tables
        $tables = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');
        $property = "Tables_in_{$dbName}";

        // 3. Tronquer toutes les tables sauf 'migrations'
        foreach ($tables as $table) {
            $tableName = $table->$property;
            if ($tableName !== 'migrations') {
                DB::table($tableName)->truncate();
                $this->command->info("Table $tableName vidée.");
            }
        }

        // 4. Restaurer la structure des rôles et permissions
        $this->command->info('Restauration des rôles et permissions...');
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
        ]);

        // 5. Créer le Super Admin
        $this->command->info('Création du super admin...');
        $admin = User::create([
            'civilite' => 'M.',
            'prenom' => 'Admin',
            'nom' => 'Karnou',
            'email' => 'admin@karnou.com',
            'password' => Hash::make('password'), // Mot de passe par défaut
            'email_verified_at' => now(),
            'telephone' => '+221770000000',
            'nationalite' => 'Sénégalaise',
        ]);

        // Assigner le rôle admin (Spatie)
        $admin->assignRole('admin');

        // 6. Réactiver les contraintes de clés étrangères
        Schema::enableForeignKeyConstraints();

        $this->command->info('✓ Base de données vidée. Super admin (admin@karnou.com) créé avec succès.');
    }
}
