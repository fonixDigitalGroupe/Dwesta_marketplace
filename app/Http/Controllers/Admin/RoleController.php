<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected function getPermissionLabels()
    {
        // Aligné sur les menus du sidebar admin
        return [
            'view_dashboard'       => 'Tableau de bord',
            'approve_vendors'      => 'Vendeurs',
            'manage_users'         => 'Clients',
            'moderate_products'    => 'Articles',
            'manage_orders'        => 'Commandes',
            'view_finances'        => 'Détails financiers',
            'manage_messagerie'    => 'Messagerie',
            'manage_carriers'      => 'Transporteurs',
            'manage_drivers'       => 'Livreurs',
            'manage_pickup_points' => 'Dépôts Relais',
            'manage_banners'       => 'Bannières',
            'manage_coupons'       => 'Promotions',
            'manage_highlights'    => 'Actualités',
            'moderate_reviews'     => 'Avis',
            'manage_subscriptions' => 'Abonnements',
            'manage_withdrawals'   => 'Retraits',
            'manage_categories'    => 'Catégories',
            'manage_settings'      => 'Paramètres',
            'manage_roles'         => 'Rôles & permissions',
        ];
    }

    /**
     * Garantit que toutes les permissions (menus du sidebar) existent en base.
     */
    protected function ensurePermissions(): void
    {
        foreach (array_keys($this->getPermissionLabels()) as $name) {
            Permission::findOrCreate($name, 'web');
        }
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $roles = Role::with('permissions')
            ->when($search, function($query) use ($search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        $labels = $this->getPermissionLabels();
        
        return view('admin.roles.index', compact('roles', 'labels', 'search', 'perPage'));
    }

    public function create()
    {
        $this->ensurePermissions();
        $permissions = Permission::all();
        $labels = $this->getPermissionLabels();
        // Group permissions by their logical prefixes if exist
        $groupedPermissions = $permissions->groupBy(function($perm) {
            return explode('_', $perm->name)[0];
        });

        return view('admin.roles.create', compact('permissions', 'groupedPermissions', 'labels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'nullable|array',
            'is_active' => 'nullable|boolean'
        ]);

        $role = Role::create([
            'name' => strtolower($request->name),
            'is_active' => $request->has('is_active') ? $request->is_active : true
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rôle créé avec succès.');
    }

    public function edit(Role $role)
    {
        if ($role->name === 'admin' || $role->name === 'super-admin') {
            // Prevent changing super-admin if necessary, but we'll just allow it with a warning in view
        }

        $this->ensurePermissions();
        $permissions = Permission::all();
        $labels = $this->getPermissionLabels();
        $groupedPermissions = $permissions->groupBy(function($perm) {
            return explode('_', $perm->name)[0];
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissions', 'groupedPermissions', 'rolePermissions', 'labels'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'is_active' => 'nullable|boolean'
        ]);

        if (!in_array($role->name, ['admin', 'vendeur', 'client'])) {
            $role->name = strtolower($request->name);
            $role->is_active = $request->has('is_active') ? $request->is_active : true;
            $role->save();
        } else {
            // Force active for system roles
            $role->is_active = true;
            $role->save();
        }

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rôle mis à jour avec succès.');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['admin', 'vendeur', 'client'])) {
            return redirect()->route('admin.roles.index')->withErrors(['Impossible de supprimer les rôles systèmes de base.']);
        }
        
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Rôle supprimé avec succès.');
    }
}
