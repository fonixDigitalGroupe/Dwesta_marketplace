<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Rôles de base avant le cahier des charges
        $roles = [
            'admin',
            'vendeur',
            'acheteur',
            'Vendeur Particulier',
            'Vendeur Professionnel',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }
        
        $this->command->info('✓ Rôles créés : admin, vendeur, acheteur, Vendeur Particulier, Vendeur Professionnel');
    }
}
