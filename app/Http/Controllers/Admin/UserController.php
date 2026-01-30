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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
