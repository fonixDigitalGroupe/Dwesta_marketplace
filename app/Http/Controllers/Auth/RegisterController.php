<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegistered;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {

        $request->validate([
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nationalite' => ['required', 'string', 'max:100'],
            'adresse' => ['required', 'string', 'max:500'],
            'telephone' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
        ], [
            'email.unique' => 'Cet email est déjà utilisé.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'telephone.required' => 'Le numéro de téléphone est requis.',
        ]);

        $user = User::create([
            'prenom' => $request->prenom,
            'nom' => $request->nom,
            'email' => $request->email,
            'nationalite' => $request->nationalite,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('acheteur');

        // Déclencher l'événement d'inscription (qui envoie le mail de vérification)
        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('profile.show');
    }
}


