@extends('layouts.app')

@section('title', 'Finaliser mon profil - Karnou')

@push('styles')
    <style>
        body {
            background-color: #ffffff !important;
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        .auth-wrapper {
            max-width: 600px;
            margin: 0 auto;
            padding: 2.5rem 1rem;
        }

        .breadcrumbs {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .breadcrumbs a {
            color: #666;
            text-decoration: none;
        }

        .breadcrumbs span {
            margin: 0 0.4rem;
        }

        .auth-card {
            background: #fff;
            padding: 2.5rem;
            border: none;
            border-radius: 0;
            width: 100%;
            max-width: 500px;
            box-shadow: 8px 0 15px -10px rgba(0,0,0,0.05);
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: #000;
            text-align: left;
        }

        .section-header {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 2rem 0 1.25rem 0;
            padding-bottom: 0.4rem;
            border-bottom: 1px solid #f0f0f0;
            color: #000;
        }

        .section-header:first-of-type {
            margin-top: 0;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .floating-input {
            width: 100%;
            padding: 1.15rem 0.85rem 0.45rem 0.85rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.95rem;
            background: #fff;
            box-sizing: border-box;
            transition: all 0.2s ease;
            outline: none;
        }

        .floating-input:focus {
            border-color: #000;
            box-shadow: 0 0 0 2px rgba(0,0,0,0.04);
        }

        .floating-label {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.95rem;
            color: #666;
            pointer-events: none;
            transition: all 0.2s ease;
            background: transparent;
        }

        .floating-input:focus ~ .floating-label,
        .floating-input:not(:placeholder-shown) ~ .floating-label {
            top: 0.6rem;
            font-size: 0.7rem;
            color: #000;
            font-weight: 600;
            transform: translateY(0);
        }

        .radio-group {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 1rem;
        }

        .date-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0.75rem;
        }

        .date-grid select {
            padding-right: 1.5rem !important;
            cursor: pointer;
        }

        .btn-primary {
            background-color: #004aad;
            color: #fff;
            border: none;
            padding: 0.75rem 3rem;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 2rem;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #003a8a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,74,173,0.15);
        }

        .error-msg {
            color: #c53030;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .strength-checklist {
            margin-top: 0.75rem;
            padding: 0;
            list-style: none;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .strength-item {
            font-size: 0.8rem;
            color: #999;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .strength-item.valid {
            color: #28a745;
        }

        .strength-icon {
            width: 6px;
            height: 6px;
            background: #ccc;
            border-radius: 50%;
        }

        .strength-item.valid .strength-icon {
            background: #28a745;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 1.2rem;
            cursor: pointer;
            color: #666;
            z-index: 5;
        }

        #prenom, #adresse {
            text-transform: capitalize;
        }

        #nom {
            text-transform: uppercase;
        }
    </style>
@endpush

@section('content')
    <div class="auth-wrapper">
        <nav class="breadcrumbs">
            <a href="/">Accueil</a>
            <span>&gt;</span>
            <a href="{{ route('register') }}">Inscription</a>
            <span>&gt;</span>
            <span>Vérification</span>
        </nav>
        <div class="auth-card">
            <h1 class="page-title">Finalisez votre inscription</h1>
                
                <form method="POST" action="{{ route('register.complete.post') }}">
                    @csrf

                    @if(session('success'))
                        <div style="background: #f0f9ff; color: #0369a1; padding: 1rem; border-radius: 4px; margin-bottom: 2rem; font-size: 0.9rem; border: 1px solid #bae6fd;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h2 class="section-header">Informations personnelles</h2>
                    
                    <div class="form-group">
                        <label class="floating-label" style="position:static; transform:none; display:block; margin-bottom: 0.5rem; font-weight: 600; color: #000;">Civilité :</label>
                        <div class="radio-group">
                            <label class="radio-item">
                                <input type="radio" name="civilite" value="madame" {{ old('civilite') == 'madame' ? 'checked' : '' }} required>
                                Madame
                            </label>
                            <label class="radio-item">
                                <input type="radio" name="civilite" value="monsieur" {{ old('civilite') == 'monsieur' ? 'checked' : '' }}>
                                Monsieur
                            </label>
                        </div>
                        @error('civilite') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" name="prenom" id="prenom" class="floating-input" placeholder=" " value="{{ old('prenom', $user->prenom != 'Utilisateur' ? $user->prenom : '') }}" required>
                        <label for="prenom" class="floating-label">Prénom</label>
                        @error('prenom') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <input type="text" name="nom" id="nom" class="floating-input" placeholder=" " value="{{ old('nom', $user->nom != 'Karnou' ? $user->nom : '') }}" required>
                        <label for="nom" class="floating-label">Nom</label>
                        @error('nom') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="floating-label" style="position:static; transform:none; display:block; margin-bottom: 0.5rem; font-weight: 600; color: #000;">Date de naissance</label>
                        <div class="date-grid">
                            <select name="birth_day" class="floating-input" style="padding: 0.75rem;" required>
                                <option value="">Jour</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}" {{ old('birth_day') == $i ? 'selected' : '' }}>{{ sprintf('%02d', $i) }}</option>
                                @endfor
                            </select>
                            
                            <select name="birth_month" class="floating-input" style="padding: 0.75rem;" required>
                                <option value="">Mois</option>
                                @php
                                    $months = [
                                        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mai', 6 => 'Juin',
                                        7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
                                    ];
                                @endphp
                                @foreach($months as $num => $name)
                                    <option value="{{ $num }}" {{ old('birth_month') == $num ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            
                            <select name="birth_year" class="floating-input" style="padding: 0.75rem;" required>
                                <option value="">Année</option>
                                @for ($i = date('Y'); $i >= 1900; $i--)
                                    <option value="{{ $i }}" {{ old('birth_year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        @error('birth_day') <div class="error-msg">{{ $message }}</div> @enderror
                        @error('birth_month') <div class="error-msg">{{ $message }}</div> @enderror
                        @error('birth_year') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="nationalite" class="floating-label" style="position:static; transform:none; display:block; margin-bottom: 0.5rem; font-weight: 600; color: #000;">Nationalité</label>
                        <select name="nationalite" id="nationalite" class="floating-input" style="padding: 0.75rem;" required>
                            <option value="">Sélectionnez votre pays</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->name }}" {{ old('nationalite') == $country->name ? 'selected' : '' }}>
                                    {{ $country->flag }} {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('nationalite') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <textarea name="adresse" id="adresse" class="floating-input" placeholder=" " style="height: 80px; padding-top: 1.15rem;" required>{{ old('adresse') }}</textarea>
                        <label for="adresse" class="floating-label">Adresse complète</label>
                        @error('adresse') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>

                    <h2 class="section-header">Sécurité</h2>

                    <div class="form-group">
                        <input type="password" name="password" id="password" class="floating-input" placeholder=" " required>
                        <label for="password" class="floating-label">Mot de passe</label>
                        <span class="password-toggle" onclick="togglePassword('password')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </span>
                        
                        @error('password') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="floating-input" placeholder=" " required>
                        <label for="password_confirmation" class="floating-label">Confirmer le mot de passe</label>
                        <span class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </span>
                    </div>

                    <div class="form-group" style="margin-top: 2rem;">
                        <label class="radio-item" style="font-size: 0.9rem; align-items: start;">
                            <input type="checkbox" name="terms" value="1" style="margin-top: 3px;" required>
                            <span>J'accepte les <a href="{{ route('terms') }}" target="_blank" style="color: #f68b1e;">Conditions d'utilisation</a> et la <a href="{{ route('privacy') }}" target="_blank" style="color: #f68b1e;">Politique de confidentialité</a> de Karnou.</span>
                        </label>
                        @error('terms') <div class="error-msg">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn-primary">Créer mon compte</button>
                </form>
        </div> {{-- end auth-card --}}
    </div> {{-- end auth-wrapper --}}
@endsection

@push('scripts')
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

    </script>
@endpush
