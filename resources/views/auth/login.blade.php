<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Mady Market</title>
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

        /* Banner - Boost livres style */
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

        /* Two Column Layout */
        .login-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        @media (max-width: 1024px) {
            .header-container {
                gap: 1rem;
            }
            .search-container {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .login-grid {
                grid-template-columns: 1fr;
            }
        }

        .auth-card {
            background: white;
            padding: 2.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }

        .auth-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
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

        .forgot-password {
            display: block;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #0066cc;
            text-decoration: none;
        }

        .btn-black {
            width: auto;
            min-width: 150px;
            background: #000;
            color: white;
            border: none;
            padding: 0.85rem 2rem;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 1.5rem;
            transition: background 0.2s;
        }

        .btn-black:hover {
            background: #333;
        }

        /* New Client Section */
        .new-client-card {
            background: white;
            padding: 2.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .error-message {
            color: #bf0000;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* Footer info style Rakuten */
        .footer-benefits {
            margin-top: 4rem;
            display: flex;
            justify-content: space-around;
            border-top: 1px solid #e0e0e0;
            padding-top: 2rem;
            text-align: center;
        }

        .benefit-item {
            flex: 1;
            padding: 0 1rem;
        }

        .benefit-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .benefit-title {
            font-weight: bold;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .benefit-desc {
            font-size: 0.8rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="top-banner">
        Mady Market : Profitez de nos meilleures offres sur tous les produits !
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
                
                <!-- Mettre en vente (Format home page) -->
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
            Accueil > Identification
        </div>

        <div class="login-grid">
            <!-- Left Column: Existing Customer -->
            <div class="auth-card">
                <h2 class="auth-title">Déjà client Mady Market ?</h2>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <input 
                            type="text" 
                            name="login" 
                            placeholder="E-mail ou pseudo" 
                            class="form-input-box"
                            value="{{ old('login') }}" 
                            required 
                            autofocus
                        >
                        @error('login')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
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

                    <a href="#" class="forgot-password">J'ai oublié mon mot de passe</a>

                    <button type="submit" class="btn-black">
                        Me connecter
                    </button>
                </form>
            </div>

            <!-- Right Column: New Customer -->
            <div class="new-client-card">
                <h2 class="auth-title">Nouveau client ?</h2>
                <a href="{{ route('register') }}" style="text-decoration: none;">
                    <button type="button" class="btn-black">
                        Continuer
                    </button>
                </a>
            </div>
        </div>

        <!-- Footer Benefits -->
        <div class="footer-benefits">
            <div class="benefit-item">
                <span class="benefit-icon">📦</span>
                <div class="benefit-title">Le choix</div>
                <div class="benefit-desc">Neuf et occasion</div>
            </div>
            <div class="benefit-item">
                <span class="benefit-icon">🎁</span>
                <div class="benefit-title">Club Mady</div>
                <div class="benefit-desc">Minimum 5% remboursés</div>
            </div>
            <div class="benefit-item">
                <span class="benefit-icon">🛡️</span>
                <div class="benefit-title">La sécurité</div>
                <div class="benefit-desc">Satisfait ou remboursé</div>
            </div>
            <div class="benefit-item">
                <span class="benefit-icon">🎧</span>
                <div class="benefit-title">Le service clients</div>
                <div class="benefit-desc">À votre écoute</div>
            </div>
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
        
        // Fermer le dropdown si on clique en dehors
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
