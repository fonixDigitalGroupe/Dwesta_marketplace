@extends('layouts.app')

@section('title', 'Mon Profil - Mady Market')

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }

        .cat-sidebar-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 7px 20px;
            cursor: pointer;
            color: #333;
            transition: all 0.1s;
            border-bottom: 1px solid transparent;
        }

        .cat-sidebar-item:hover:not(.active-cat-item) {
            background: #f8f8f8;
        }

        .cat-sidebar-item svg {
            opacity: 0.4;
            color: #666;
        }

        .sell-button-container {
            position: relative;
        }

        .sell-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #333;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            background: white;
            border: none;
            padding: 0.5rem;
        }

        .sell-button:hover {
            color: #bf0000;
        }

        .disabled-action {
            cursor: default !important;
            opacity: 0.6;
            pointer-events: none;
        }

        .user-dropdown-container {
            position: relative;
        }

        .user-dropdown-trigger {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .user-dropdown-trigger:hover {
            background-color: #f6f6f6;
        }

        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            width: 200px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
            display: none;
            z-index: 3000;
            overflow: hidden;
        }

        .user-dropdown-menu.show {
            display: block;
        }

        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #333;
            text-decoration: none;
            font-size: 0.9rem;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: background 0.1s;
        }

        .user-dropdown-item:hover {
            background-color: #f8f8f8;
        }

        .user-dropdown-divider {
            height: 1px;
            background-color: #f0f0f0;
            margin: 0.25rem 0;
        }

        .breadcrumb {
            max-width: 1400px;
            margin: 3rem auto 0;
            padding: 0 2rem 0 7rem;
            font-size: 0.85rem;
            color: #666;
        }

        .breadcrumb a {
            color: #666;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto 2rem;
            padding: 0.5rem 2rem 2rem 7rem;
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 2.5rem;
        }

        .sidebar {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 0;
            padding: 1.5rem 0;
            height: fit-content;
        }

        .sidebar-user {
            padding: 1rem 0.5rem;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 0.5rem;
        }

        .sidebar-user h2 {
            font-size: 1.1rem;
            color: #333;
            padding-left: 0.8rem;
            font-weight: 700;
        }

        .sidebar-section {
            margin-bottom: 0.5rem;
        }

        .sidebar-title {
            padding: 0.3rem 0.8rem;
            font-weight: 700;
            font-size: 0.95rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 0px;
        }

        .sidebar-title svg,
        .sidebar-title .icon-img {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li a {
            display: block;
            padding: 1px 0.5rem 1px 3.2rem;
            color: #888;
            text-decoration: none;
            font-size: 0.88rem;
            transition: all 0.2s;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            color: #222;
        }

        .sidebar-menu li a.active {
            font-weight: 700;
        }

        .sidebar-divider {
            height: 1px;
            background: #eee;
            margin: 1rem 1.5rem;
        }

        .main-content {
            background: transparent;
            padding-top: 0.5rem;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .content-header h1 {
            font-size: 1.5rem;
            color: #333;
            font-weight: 700;
        }

        /* Rakuten Style Forms */
        .rakuten-form-container {
            max-width: 600px;
            padding: 1rem 0;
            text-align: left;
        }

        .rakuten-title {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }

        .rakuten-radio-group {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .rakuten-radio-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .rakuten-radio-item input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #0076ad;
        }

        .rakuten-field-group {
            margin-bottom: 1rem;
            max-width: 320px;
        }

        .rakuten-field {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0.1rem 0.75rem;
            background: #fff;
            transition: border-color 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .rakuten-field:focus-within {
            border-color: #000;
        }

        .rakuten-label {
            display: block;
            font-size: 0.7rem;
            color: #888;
            margin-bottom: 0px;
            line-height: 1;
        }

        .rakuten-error-alert {
            background-color: #fff6f6;
            border: 1px solid #ff0000;
            color: #333;
            padding: 0.5rem 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.88rem;
            max-width: 100%;
            border-radius: 2px;
        }

        .rakuten-error-alert .error-icon {
            background-color: #ff0000;
            color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 12px;
            font-weight: bold;
        }

        .rakuten-success-alert {
            background-color: #f6fff6;
            border: 1px solid #00a650;
            color: #333;
            padding: 0.5rem 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.88rem;
            max-width: 100%;
            border-radius: 2px;
        }

        .rakuten-success-alert .success-icon {
            background-color: #00a650;
            color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 10px;
            font-weight: bold;
        }

        .rakuten-input {
            width: 100%;
            border: none;
            outline: none;
            font-size: 0.9rem;
            color: #333;
            padding: 0;
            background: transparent;
        }

        .btn-rakuten {
            background: #000;
            color: #fff;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-weight: 700;
            cursor: pointer;
            font-size: 1rem;
            margin: 1.25rem 0 2rem;
            width: 220px;
            transition: opacity 0.2s;
        }

        .btn-rakuten:hover {
            opacity: 0.85;
        }

        .password-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .eye-toggle {
            background: none;
            border: none;
            padding: 0;
            margin-left: 0.5rem;
            cursor: pointer;
            color: #888;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .eye-toggle svg {
            width: 20px;
            height: 20px;
        }

        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }
        }
    </style>
@endpush

@section('content')

    <!-- Breadcrumb (Above sidebar) -->
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('profile.show') }}">Mon Compte</a> > <span>Mon
            Profil</span>
    </div>

    <div class="dashboard-container">
        <!-- Sidebar (Left) -->
        <aside class="sidebar">
            <div class="sidebar-user">
                <h2>{{ $user->prenom }}</h2>
            </div>

            <!-- Mes achats -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg viewBox="0 0 24 24" style="width: 22px; height: 22px;">
                        <path d="M4 9h16v11H4z" fill="#f39c12" />
                        <path d="M2 7l4 2h12l4-2-4-3H6z" fill="#ffb74d" />
                    </svg>
                    Mes achats
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Tous mes achats</a></li>
                    <li><a href="#">Mes favoris</a></li>
                    <li><a href="#">Cartes cadeaux</a></li>
                </ul>
            </div>

            <!-- Mes avis -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg viewBox="0 0 24 24" fill="#fbc02d">
                        <path
                            d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                    </svg>
                    Mes avis
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Tous mes avis</a></li>
                </ul>
            </div>

            <div class="sidebar-divider"></div>

            <!-- Mes ventes -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg viewBox="0 0 24 24" fill="#757575">
                        <path
                            d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21v-.05c0-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                    </svg>
                    Mes ventes
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Toutes mes ventes</a></li>
                </ul>
            </div>

            <!-- Mes annonces -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                        <path d="M20,4H4V6H20V4M21,14V12L20,7H4L3,12V14H4V20H14V14H18V20H20V14H21M12,18H6V14H12V18Z" fill="#e67e22" />
                    </svg>
                    Mes annonces
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Toutes mes annonces</a></li>
                    <li><a href="#">Voir ma Boutique</a></li>
                    <li><a href="#">Mes préférences vendeur</a></li>
                </ul>
            </div>

            <!-- Communauté -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg viewBox="0 0 24 24" fill="#3498db">
                        <path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"/>
                    </svg>
                    Communauté
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Mes messages</a></li>
                    <li><a href="#">Contacter Aide & support</a></li>
                </ul>
            </div>

            <!-- Mes finances -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg viewBox="0 0 24 24" style="width: 22px; height: 22px;">
                        <rect x="2" y="5" width="20" height="14" rx="2" fill="#34495e" />
                        <rect x="2" y="8" width="20" height="3" fill="#2c3e50" />
                    </svg>
                    Mes finances
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Mon Porte-Monnaie</a></li>
                    <li><a href="#">Statistiques</a></li>
                    <li><a href="#">Mes paiements</a></li>
                </ul>
            </div>

            <!-- Mes informations -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg viewBox="0 0 24 24" fill="#d32f2f">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                    Mes informations
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('profile.show') }}" class="active">Mon adresse e-mail</a></li>
                    <li><a href="{{ route('profile.show') }}#changement-mot-de-passe">Mon mot de passe</a></li>
                    <li><a href="{{ route('abonnements.index') }}">Mes abonnements</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content (Right) -->
        <main class="main-content">

            <div class="content-header">
                <h1>Mes informations</h1>
            </div>

            <div class="rakuten-form-container">
                <h2 class="rakuten-title">Informations personnelles</h2>

                @if(session('success'))
                    <div class="rakuten-success-alert">
                        <div class="success-icon">✓</div>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="rakuten-error-alert">
                        <div class="error-icon">✕</div>
                        <span>
                            @if($errors->has('current_password_info'))
                                {{ $errors->first('current_password_info') }}
                            @else
                                {{ $errors->first() }}
                            @endif
                        </span>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="rakuten-radio-group">
                        <span style="color: #333;">Civilité :</span>
                        <label class="rakuten-radio-item">
                            <input type="radio" name="civilite" value="Madame" {{ old('civilite', $user->civilite) == 'Madame' ? 'checked' : '' }}>
                            Madame
                        </label>
                        <label class="rakuten-radio-item">
                            <input type="radio" name="civilite" value="Monsieur" {{ old('civilite', $user->civilite) == 'Monsieur' ? 'checked' : '' }}>
                            Monsieur
                        </label>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Prénom</label>
                            <input type="text" name="prenom" class="rakuten-input"
                                value="{{ old('prenom', $user->prenom) }}" required>
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Nom</label>
                            <input type="text" name="nom" class="rakuten-input" value="{{ old('nom', $user->nom) }}">
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Nationalité</label>
                            <input type="text" name="nationalite" class="rakuten-input"
                                value="{{ old('nationalite', $user->nationalite) }}">
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Tel</label>
                            <input type="tel" name="telephone" class="rakuten-input"
                                value="{{ old('telephone', $user->telephone) }}">
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">E-mail actuel</label>
                            <input type="email" name="email" class="rakuten-input" value="{{ old('email', $user->email) }}"
                                required>
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Mot de passe actuel</label>
                            <div class="password-container">
                                <input type="password" name="current_password_info"
                                    class="rakuten-input password-toggle-input">
                                <button type="button" class="eye-toggle" @click="togglePassword($event)">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-rakuten">Valider</button>
                </form>

                <h2 id="changement-mot-de-passe" class="rakuten-title">Changement de mot de passe</h2>
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Ancien mot de passe</label>
                            <div class="password-container">
                                <input type="password" name="current_password" class="rakuten-input password-toggle-input"
                                    required>
                                <button type="button" class="eye-toggle" @click="togglePassword($event)">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Nouveau mot de passe</label>
                            <div class="password-container">
                                <input type="password" name="password" class="rakuten-input password-toggle-input" required>
                                <button type="button" class="eye-toggle" @click="togglePassword($event)">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Confirmez votre nouveau mot de passe</label>
                            <div class="password-container">
                                <input type="password" name="password_confirmation"
                                    class="rakuten-input password-toggle-input" required>
                                <button type="button" class="eye-toggle" @click="togglePassword($event)">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-rakuten">Valider</button>
                </form>
            </div>
        </main>
    </div>

@endsection

@push('scripts')
    <script>
        function togglePassword(event) {
            const button = event.currentTarget;
            const container = button.closest('.password-container');
            const input = container.querySelector('.password-toggle-input');

            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    </script>
@endpush