<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nettoyer le cache des permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les permissions array
        $permissions = [
            // Marketing & Contenu Front
            'manage_banners',
            'manage_highlights',
            'manage_coupons',
            'manage_categories',

            // Finance
            'view_finances',
            'manage_withdrawals',
            'manage_subscriptions',

            // Modération du catalogue
            'moderate_products',
            'moderate_reviews',

            // Gestion Utilisateurs & Vendeurs
            'approve_vendors',
            'manage_users',

            // Logistique
            'manage_carriers',
            'manage_pickup_points',

            // Super Admin
            'manage_settings',
            'manage_roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Créer les rôles de base s'ils n'existent pas
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $vendeurRole = Role::firstOrCreate(['name' => 'vendeur']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Le rôle 'admin' (super-admin) reçoit toutes les permissions
        $adminRole->syncPermissions(Permission::all());

        $this->command->info('Les permissions ont été générées avec succès.');
    }
}
