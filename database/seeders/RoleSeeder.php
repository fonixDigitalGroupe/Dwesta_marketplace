<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les rôles
        $roles = [
            'acheteur',
            'vendeur',
            'transporteur',
            'depot_relais',
            'Administrateur',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Créer les permissions de base (à étendre plus tard)
        $permissions = [
            'voir annonces',
            'créer annonce',
            'modifier annonce',
            'supprimer annonce',
            'gérer commandes',
            'gérer utilisateurs',
            'gérer litiges',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assigner toutes les permissions à l'administrateur
        $admin = Role::where('name', 'Administrateur')->first();
        if ($admin) {
            $admin->givePermissionTo(Permission::all());
        }
    }
}


