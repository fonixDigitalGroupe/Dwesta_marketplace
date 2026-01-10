<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Préparer la date de naissance si présente
        if ($request->filled(['annee', 'mois', 'jour'])) {
            $request->merge([
                'date_de_naissance' => "{$request->annee}-{$request->mois}-{$request->jour}"
            ]);
        }

        $request->validate([
            'civilite' => ['required', 'string', 'in:Madame,Monsieur'],
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'confirmed'],
            'date_de_naissance' => ['required', 'date'],
            'telephone' => ['nullable', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.unique' => 'Cet email est déjà utilisé.',
            'email.confirmed' => 'La confirmation de l\'email ne correspond pas.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'date_de_naissance.date' => 'La date de naissance n\'est pas valide.',
        ]);

        $user = User::create([
            'civilite' => $request->civilite,
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'date_de_naissance' => $request->date_de_naissance,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
        ]);

        // Assigner le rôle Acheteur par défaut
        $user->assignRole('Acheteur');

        // TODO: Implémenter vérification email dans Phase 12 (Notifications)
        // event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}


