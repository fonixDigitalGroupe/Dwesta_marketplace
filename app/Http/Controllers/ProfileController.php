<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $countries = \App\Models\Country::active()->orderBy('name')->get();
        return view('profile.show', [
            'user' => Auth::user(),
            'countries' => $countries
        ]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $messages = [
            'current_password_info.required' => 'Veuillez entrer votre mot de passe actuel pour enregistrer vos modifications.',
            'current_password_info.current_password' => 'Veuillez entrer votre mot de passe actuel pour enregistrer vos modifications.',
            'telephone.unique' => 'Ce numéro de téléphone est déjà utilisé par un autre compte.',
            'email.unique' => 'Cet email est déjà utilisé par un autre compte.',
            'prenom.required' => 'Le prénom est requis.',
        ];

        $request->validate([
            'civilite' => ['nullable', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'nom' => ['nullable', 'string', 'max:255'],
            'nationalite' => ['nullable', 'string', 'max:255'],
            'date_de_naissance' => ['nullable', 'date'],
            'telephone' => ['nullable', 'string', 'max:20', 'unique:users,telephone,' . $user->id],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'adresse' => ['nullable', 'string', 'max:500'],
            'code_postal' => ['nullable', 'string', 'max:10'],
            'pays' => ['nullable', 'string', 'max:100'],
            'region' => ['nullable', 'string', 'max:100'],
            'ville' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ], $messages);

        $data = $request->only(['civilite', 'prenom', 'nom', 'nationalite', 'date_de_naissance', 'telephone', 'email', 'adresse', 'code_postal', 'pays', 'region', 'ville', 'latitude', 'longitude']);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $messages = [
            'current_password.required' => 'Veuillez entrer votre mot de passe actuel.',
            'current_password.current_password' => 'Le mot de passe actuel est incorrect.',
            'password.required' => 'Veuillez entrer un nouveau mot de passe.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ];

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], $messages);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')->with('success', 'Mot de passe mis à jour avec succès.');
    }
}


