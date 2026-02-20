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
        $query = User::latest();

        // Filtre par rôle (par défaut : admin si premier chargement)
        $role = $request->has('role') ? $request->role : 'admin';
        
        if ($role === 'admin') {
            $query->role('admin');
        } elseif ($role === 'vendeur') {
            $query->has('vendeur');
        } elseif ($role === 'acheteur') {
            $query->doesntHave('vendeur')->role('acheteur');
        }

        // Filtre par nationalité
        if ($request->has('nationalite') && !empty($request->nationalite)) {
            $query->where('nationalite', $request->nationalite);
        }

        // Filtre par civilité
        if ($request->has('civilite') && !empty($request->civilite)) {
            $query->where('civilite', $request->civilite);
        }

        $users = $query->paginate(10);
        $nationalites = User::whereNotNull('nationalite')->where('nationalite', '!=', '')->distinct()->pluck('nationalite');
        $civilites = User::whereNotNull('civilite')->where('civilite', '!=', '')->distinct()->pluck('civilite');

        return view('admin.users.index', compact('users', 'nationalites', 'civilites', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Rôles spécifiques demandés
        $roles = [
            'admin' => 'Administrateur',
            'transporteur' => 'Transporteur',
            'livreur' => 'Livreur',
            'point relais' => 'Point Relais',
        ];

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
            'role' => 'required|string|in:admin,transporteur,livreur,point relais',
            'civilite' => 'nullable|string',
            'telephone' => 'nullable|string',
            'nationalite' => 'nullable|string',
            'adresse' => 'nullable|string',
        ]);

        $user = User::create([
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'civilite' => $validated['civilite'],
            'telephone' => $validated['telephone'],
            'nationalite' => $validated['nationalite'],
            'adresse' => $validated['adresse'],
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Assignation du rôle
        $user->assignRole($validated['role']);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès.');
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
            'transporteur' => 'Transporteur',
            'livreur' => 'Livreur',
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
            'civilite' => 'nullable|string',
            'telephone' => 'nullable|string',
            'nationalite' => 'nullable|string',
            'adresse' => 'nullable|string',
        ]);

        $data = [
            'prenom' => $validated['prenom'],
            'nom' => $validated['nom'],
            'email' => $validated['email'],
            'civilite' => $validated['civilite'],
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
