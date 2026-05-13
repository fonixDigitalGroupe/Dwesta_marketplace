@extends('layouts.app')

@section('title', 'Modifier mon Profil')

@push('styles')
    <style>
        body {
            background-color: #fff !important;
        }
        .main-content {
            background-color: #fff;
            min-height: 100vh;
        }
    </style>
@endpush

@section('content')
    <div
        style="max-width: 600px; margin: 3rem auto; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 2rem;">
            <div style="display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
                <a href="{{ route('profile.show') }}"
                    style="display: inline-block; color: #EF3B2D; text-decoration: none; font-weight: 500;">
                    ← Retour au profil
                </a>
                <a href="{{ route('home') }}"
                    style="display: inline-block; color: #6c757d; text-decoration: none; font-weight: 500;">
                    Accueil
                </a>
            </div>
        </div>
        <div style="text-align: center; margin-bottom: 2rem;">
            <img src="https://laravel.com/img/logomark.min.svg" alt="Laravel" style="height: 60px; margin-bottom: 1rem;">
            <h1 style="color: #333; margin: 0;">Modifier mon Profil</h1>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1rem;">
                <label for="prenom" style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Prénom
                    <span style="color: #EF3B2D;">*</span></label>
                <input type="text" id="prenom" name="prenom" value="{{ old('prenom', $user->prenom) }}" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('prenom')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="nom" style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Nom</label>
                <input type="text" id="nom" name="nom" value="{{ old('nom', $user->nom) }}"
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('nom')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="nationalite"
                    style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Nationalité</label>
                <input type="text" id="nationalite" name="nationalite" value="{{ old('nationalite', $user->nationalite) }}"
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('nationalite')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="email"
                    style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('email')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="telephone"
                    style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Téléphone</label>
                <input type="tel" id="telephone" name="telephone" value="{{ old('telephone', $user->telephone) }}"
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('telephone')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="adresse"
                    style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Adresse</label>
                <textarea id="adresse" name="adresse" rows="3"
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">{{ old('adresse', $user->adresse) }}</textarea>
                @error('adresse')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="avatar"
                    style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Avatar</label>
                @if($user->avatar)
                    <div style="margin-bottom: 0.5rem;">
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                            style="height: 60px; width: 60px; border-radius: 50%; object-fit: cover;">
                    </div>
                @endif
                <input type="file" id="avatar" name="avatar" accept="image/*"
                    style="width: 100%; padding: 0.5rem; border: 1px solid #ddd; border-radius: 4px;">
                @error('avatar')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit"
                style="width: 100%; background: #EF3B2D; color: white; border: none; padding: 0.75rem; border-radius: 4px; font-size: 1rem; font-weight: 500; cursor: pointer; margin-bottom: 2rem;">
                Enregistrer les modifications
            </button>
        </form>

        <hr style="border: none; border-top: 1px solid #ddd; margin: 2rem 0;">

        <h2 style="color: #333; margin-bottom: 1rem;">Changer le mot de passe</h2>

        <form method="POST" action="{{ route('profile.password.update') }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1rem;">
                <label for="current_password"
                    style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Mot de passe actuel <span
                        style="color: #EF3B2D;">*</span></label>
                <input type="password" id="current_password" name="current_password" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('current_password')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Nouveau
                    mot de passe <span style="color: #EF3B2D;">*</span></label>
                <input type="password" id="password" name="password" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
                @error('password')
                    <span style="color: #EF3B2D; font-size: 0.875rem;">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="password_confirmation"
                    style="display: block; margin-bottom: 0.5rem; color: #333; font-weight: 500;">Confirmer le nouveau mot
                    de passe <span style="color: #EF3B2D;">*</span></label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem;">
            </div>

            <button type="submit"
                style="width: 100%; background: #dc3545; color: white; border: none; padding: 0.75rem; border-radius: 4px; font-size: 1rem; font-weight: 500; cursor: pointer; margin-bottom: 1rem;">
                Changer le mot de passe
            </button>
        </form>

        <div style="text-align: center;">
            <a href="{{ route('profile.show') }}" style="color: #EF3B2D; text-decoration: none;">← Retour au profil</a>
        </div>
    </div>
@endsection