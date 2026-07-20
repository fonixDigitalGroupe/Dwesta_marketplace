<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 8);
        $role = $request->get('role', 'admin');
        if ($role === 'client') $role = 'acheteur';

        $query = User::latest();

        // Recherche
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('prenom', 'like', "%{$search}%")
                  ->orWhere('nom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        // Filtre par rôle (whereHas tolérant : ne plante pas si un rôle est absent)
        if ($role === 'admin') {
            $query->whereHas('roles', fn($q) => $q->whereIn('name', ['admin', 'point relais']));
        } elseif ($role === 'vendeur_pro') {
            $query->whereHas('vendeur', function($q) {
                $q->where('type', 'professionnel');
            });
        } elseif ($role === 'vendeur_particulier') {
            $query->whereHas('vendeur', function($q) {
                $q->where('type', 'particulier');
            });
        } elseif ($role === 'vendeur') {
            // Uniquement les vendeurs (particulier/professionnel), pas les admins
            $query->has('vendeur')->whereDoesntHave('roles', fn($q) => $q->where('name', 'admin'));
        } elseif ($role === 'acheteur') {
            $query->doesntHave('vendeur')->whereHas('roles', fn($q) => $q->where('name', 'acheteur'));
        } elseif (in_array($role, ['transporteur', 'livreur', 'point relais'])) {
            $query->whereHas('roles', fn($q) => $q->where('name', $role));
        } elseif (!empty($role)) {
            // Rôle personnalisé (créé dans /admin/roles)
            $query->whereHas('roles', fn($q) => $q->where('name', $role));
        }

        // Filtre par nationalité
        if ($request->filled('nationalite')) {
            $query->where('nationalite', $request->nationalite);
        }

        // Filtre par civilité
        if ($request->filled('civilite')) {
            $query->where('civilite', $request->civilite);
        }

        // Nouveau Filtre: Type de Vendeur
        $typeVendeur = $request->get('type_vendeur');
        if (!empty($typeVendeur)) {
            $query->whereHas('vendeur', function($q) use ($typeVendeur) {
                $q->where('type', $typeVendeur);
            });
        }

        // Nouveau Filtre: Statut
        $status = $request->get('status');
        if (!empty($status)) {
            if ($status === 'suspendu') {
                $query->where('is_active', false);
            } elseif ($status === 'attente') {
                $query->where('is_active', true)->whereHas('vendeur', function($q) {
                    $q->where('statut_verification', '!=', 'verifie');
                });
            } elseif ($status === 'actif') {
                $query->where('is_active', true)->where(function($q) {
                    $q->doesntHave('vendeur')
                      ->orWhereHas('vendeur', function($v) {
                          $v->where('statut_verification', 'verifie');
                      });
                });
            }
        }

        $users = $query->paginate($perPage)->withQueryString();

        // Statistiques vendeurs (total / professionnel / particulier)
        $vendeurTotalCount = \App\Models\Vendeur::count();
        $vendeurProCount = \App\Models\Vendeur::where('type', 'professionnel')->count();
        $vendeurParticulierCount = \App\Models\Vendeur::where('type', 'particulier')->count();

        // Rôles personnalisés (créés dans /admin/roles) pour le filtre
        $customRoles = \Spatie\Permission\Models\Role::whereNotIn('name', ['admin', 'vendeur', 'client', 'acheteur', 'point relais', 'transporteur', 'livreur'])
            ->orderBy('name')
            ->pluck('name', 'name')
            ->toArray();

        return view('admin.users.index', compact('users', 'role', 'search', 'perPage', 'typeVendeur', 'status', 'customRoles', 'vendeurTotalCount', 'vendeurProCount', 'vendeurParticulierCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Rôles de base
        $roles = [
            'admin' => 'Administrateur',
            'point relais' => 'Point Relais',
        ];

        // + rôles personnalisés enregistrés dans /admin/roles
        $customRoles = \Spatie\Permission\Models\Role::whereNotIn('name', ['admin', 'vendeur', 'client', 'point relais'])
            ->orderBy('name')
            ->pluck('name', 'name')
            ->toArray();

        $roles = $roles + $customRoles;

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|exists:roles,name',
            'telephone' => 'nullable|string',
            'nationalite' => 'nullable|string',
            'adresse' => 'nullable|string',
        ]);

        $user = User::create([
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'telephone' => $validated['telephone'],
            'nationalite' => $validated['nationalite'],
            'adresse' => $validated['adresse'],
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Assignation du rôle
        $user->assignRole($validated['role']);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Utilisateur créé avec succès.',
                'user' => [
                    'id' => $user->id,
                    'prenom' => $user->prenom,
                    'nom' => $user->nom,
                    'email' => $user->email,
                    'password' => $request->password, // Envoyer le MDP en clair pour la popup
                ]
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Envoyer les accès par email.
     */
    public function sendCredentials(Request $request, User $user)
    {
        try {
            $password = $request->password;
            $user->notify(new \App\Notifications\UserCredentialsNotification($user->prenom, $user->email, $password));

            return response()->json([
                'success' => true,
                'message' => 'Informations de connexion envoyées par email.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return redirect()->route('admin.users.edit', $user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = [
            'admin' => 'Administrateur',
            'point relais' => 'Point Relais',
        ];
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string',
            'telephone' => 'nullable|string',
            'nationalite' => 'nullable|string',
            'adresse' => 'nullable|string',
        ]);

        $data = [
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'nationalite' => $validated['nationalite'],
            'adresse' => $validated['adresse'],
        ];

        if (!empty($validated['password'])) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        }

        $user->update($data);

        // Mise à jour du rôle
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Toggle the active status of the user.
     */
    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'activé' : 'suspendu';
        return redirect()->back()->with('success', "Compte utilisateur {$status} avec succès.");
    }
}
