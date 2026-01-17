@extends('layouts.app')

@section('title', 'Création de compte - Mady Market')

@push('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #ffffff;
            color: #333;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    <style>
        /* Banner */
        .top-banner {
            background-color: #bf0000;
            color: white;
            text-align: center;
            padding: 0.5rem;
            font-size: 0.9rem;
            position: relative;
        }

        .top-banner .close-btn {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        /* Main Content */
        .main-content {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .breadcrumb {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .breadcrumb a {
            color: #666;
            text-decoration: none;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        /* Form Layout */
        .register-card {
            background: white;
            padding: 2.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            max-width: 600px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-input-box {
            width: 100%;
            padding: 0.85rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            outline: none;
        }

        .form-input-box:focus {
            border-color: #333;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }

        /* Civilité Radio Group */
        .radio-group {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .radio-item input {
            cursor: pointer;
        }

        /* Date de naissance selectors */
        .date-selectors {
            display: flex;
            gap: 1rem;
        }

        .date-selectors select {
            flex: 1;
            padding: 0.85rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            outline: none;
            background: white;
        }

        .btn-black {
            width: auto;
            min-width: 200px;
            background: #000;
            color: white;
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 4px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 1rem;
            transition: background 0.2s;
        }

        .btn-black:hover {
            background: #333;
        }

        .error-message {
            color: #bf0000;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .login-link {
            display: block;
            margin-top: 2rem;
            font-size: 0.95rem;
            color: #333;
            text-align: center;
        }

        .login-link a {
            color: #bf0000;
            font-weight: bold;
            text-decoration: none;
        }

        @media (max-width: 1024px) {
            .search-container {
                display: none;
            }
        }
    </style>
@endpush

@section('content')

    <main class="main-content">
        <div class="breadcrumb">
            Accueil > Inscription
        </div>

        <h1 class="page-title">Création de compte</h1>

        <div class="register-card">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Section: Informations personnelles -->
                <h2 class="section-title">Informations personnelles</h2>

                <div class="form-group">
                    <input type="text" name="prenom" placeholder="Prénom" class="form-input-box" value="{{ old('prenom') }}"
                        required>
                    @error('prenom')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" name="nom" placeholder="Nom" class="form-input-box" value="{{ old('nom') }}"
                        required>
                    @error('nom')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" name="nationalite" placeholder="Nationalité" class="form-input-box"
                        value="{{ old('nationalite') }}" required>
                    @error('nationalite')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="tel" name="telephone" placeholder="Téléphone" class="form-input-box"
                        value="{{ old('telephone') }}" required>
                    @error('telephone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="E-mail" class="form-input-box" value="{{ old('email') }}"
                        required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <textarea name="adresse" placeholder="Adresse complète" class="form-input-box"
                        style="height: 100px; resize: vertical;" required>{{ old('adresse') }}</textarea>
                    @error('adresse')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group password-container">
                    <input type="password" id="password" name="password" placeholder="Mot de passe" class="form-input-box"
                        required>
                    <span class="toggle-password" onclick="togglePassword()">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div style="text-align: center;">
                    <button type="submit" class="btn-black">
                        Créer un compte
                    </button>
                </div>

                <div class="login-link">
                    Déjà inscrit ? <a href="{{ route('login') }}">Connectez-vous</a>
                </div>
            </form>
        </div>
    </main>

@endsection

@push('scripts')
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
@endpush