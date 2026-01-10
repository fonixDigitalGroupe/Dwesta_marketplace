<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte - Mady Market</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f6f6f6;
            color: #333;
        }
        
        /* Header style Rakuten */
        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 0.75rem 0;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
            color: #bf0000;
            flex-shrink: 0;
        }
        
        .logo img {
            height: 40px;
            margin-right: 0.5rem;
        }

        /* Barre de recherche style Rakuten */
        .search-container {
            flex: 1;
            display: flex;
            align-items: center;
            max-width: 600px;
        }
        
        .search-field {
            flex: 1;
            display: flex;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            font-size: 1rem;
            outline: none;
        }
        
        .search-button {
            background-color: #333;
            color: white;
            border: none;
            padding: 0 1.25rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .search-button:hover {
            background-color: #000;
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-shrink: 0;
        }

        .header-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #333;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .header-link:hover {
            color: #bf0000;
        }

        .header-link svg {
            width: 20px;
            height: 20px;
        }

        /* Bouton Mettre en vente */
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
        
        .sell-button .chevron {
            width: 12px;
            height: 12px;
            transition: transform 0.2s;
        }
        
        .sell-button.active .chevron {
            transform: rotate(180deg);
        }
        
        /* Dropdown Mettre en vente */
        .sell-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 0.5rem;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            min-width: 280px;
            z-index: 1000;
            display: none;
        }
        
        .sell-dropdown.show {
            display: block;
        }
        
        .sell-dropdown-item {
            display: block;
            padding: 1rem;
            text-decoration: none;
            color: #333;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
            text-align: left;
        }
        
        .sell-dropdown-item:last-child {
            border-bottom: none;
        }
        
        .sell-dropdown-item:hover {
            background-color: #f5f5f5;
        }
        
        .sell-dropdown-item-title {
            font-weight: 500;
            font-size: 0.95rem;
            color: #333;
            margin-bottom: 0.25rem;
        }
        
        .sell-dropdown-item-subtitle {
            font-size: 0.85rem;
            color: #666;
        }

        .club-r {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.4rem 0.8rem;
            background: #fdf2f2;
            border-radius: 20px;
            color: #bf0000;
            font-weight: bold;
            font-size: 0.85rem;
            text-decoration: none;
        }

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
</head>
<body>
    <div class="top-banner">
        Mady Market : Créez votre compte et profitez d'avantages exclusifs !
        <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="logo">
                <img src="https://laravel.com/img/logomark.min.svg" alt="Logo">
                Mady Market
            </a>

            <!-- Barre de recherche -->
            <div class="search-container">
                <form action="{{ route('annonces.index') }}" method="GET" style="width: 100%;">
                    <div class="search-field">
                        <input 
                            type="text" 
                            name="search" 
                            class="search-input" 
                            placeholder="Rechercher un produit"
                            value="{{ request('search') }}"
                        >
                        <button type="submit" class="search-button">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="header-actions">
                <a href="#" class="club-r">
                    Club R
                </a>
                
                <div class="sell-button-container">
                    <button type="button" class="sell-button" onclick="toggleSellDropdown()">
                        <span>Mettre en vente</span>
                        <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="sell-dropdown" id="sellDropdown">
                        <a href="{{ route('login') }}" class="sell-dropdown-item">
                            <div class="sell-dropdown-item-title">Vendre un produit en tant que particulier</div>
                            <div class="sell-dropdown-item-subtitle">Je dépose une annonce gratuitement</div>
                        </a>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="header-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Se connecter</span>
                </a>
            </div>
        </div>
    </header>
    
    <main class="main-content">
        <div class="breadcrumb">
            Accueil > Inscription
        </div>

        <h1 class="page-title">Création de compte</h1>

        <div class="register-card">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Section: Informations d'authentification -->
                <h2 class="section-title">Informations d'authentification</h2>
                
                <div class="form-group">
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="E-mail" 
                        class="form-input-box"
                        value="{{ old('email') }}" 
                        required 
                    >
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input 
                        type="email" 
                        name="email_confirmation" 
                        placeholder="Confirmer votre e-mail" 
                        class="form-input-box"
                        required 
                    >
                </div>

                <div class="form-group password-container">
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        placeholder="Mot de passe" 
                        class="form-input-box"
                        required
                    >
                    <span class="toggle-password" onclick="togglePassword()">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Section: Informations personnelles -->
                <h2 class="section-title">Informations personnelles</h2>

                <div class="form-group">
                    <label class="form-label">Civilité :</label>
                    <div class="radio-group">
                        <label class="radio-item">
                            <input type="radio" name="civilite" value="Madame" {{ old('civilite') == 'Madame' ? 'checked' : '' }} required>
                            Madame
                        </label>
                        <label class="radio-item">
                            <input type="radio" name="civilite" value="Monsieur" {{ old('civilite') == 'Monsieur' ? 'checked' : '' }} required>
                            Monsieur
                        </label>
                    </div>
                    @error('civilite')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input 
                        type="text" 
                        name="prenom" 
                        placeholder="Prénom" 
                        class="form-input-box"
                        value="{{ old('prenom') }}" 
                        required 
                    >
                    @error('prenom')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input 
                        type="text" 
                        name="nom" 
                        placeholder="Nom" 
                        class="form-input-box"
                        value="{{ old('nom') }}" 
                        required 
                    >
                    @error('nom')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Date de naissance :</label>
                    <div class="date-selectors">
                        <select name="jour" required>
                            <option value="">Jour</option>
                            @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ sprintf('%02d', $i) }}" {{ old('jour') == sprintf('%02d', $i) ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        <select name="mois" required>
                            <option value="">Mois</option>
                            @php
                                $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                            @endphp
                            @foreach ($mois as $key => $m)
                                <option value="{{ sprintf('%02d', $key + 1) }}" {{ old('mois') == sprintf('%02d', $key + 1) ? 'selected' : '' }}>{{ $m }}</option>
                            @endforeach
                        </select>
                        <select name="annee" required>
                            <option value="">Année</option>
                            @for ($i = date('Y') - 18; $i >= date('Y') - 100; $i--)
                                <option value="{{ $i }}" {{ old('annee') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    @error('date_de_naissance')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <input 
                        type="tel" 
                        name="telephone" 
                        placeholder="Téléphone (en cas de besoin pour vos commandes)" 
                        class="form-input-box"
                        value="{{ old('telephone') }}" 
                    >
                    @error('telephone')
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

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }

        function toggleSellDropdown() {
            const button = event.target.closest('.sell-button');
            const container = button.closest('.sell-button-container');
            const dropdown = container.querySelector('.sell-dropdown');
            
            dropdown.classList.toggle('show');
            button.classList.toggle('active');
        }
        
        document.addEventListener('click', function(event) {
            const container = document.querySelector('.sell-button-container');
            if (container && !container.contains(event.target)) {
                const dropdown = container.querySelector('.sell-dropdown');
                const button = container.querySelector('.sell-button');
                if (dropdown) dropdown.classList.remove('show');
                if (button) button.classList.remove('active');
            }
        });
    </script>
</body>
</html>
