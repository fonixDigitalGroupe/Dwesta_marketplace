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
            background-color: #ffffff;
            color: #333;
        }
        [x-cloak] {
            display: none !important;
        }
    </style>
    <style>
        /* Modern Header Design */
        .header {
            background-color: #ffffff;
            position: relative;
            z-index: 100;
        }

        .header-row-1 {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .header-row-2 {
            background-color: #fff;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e0e0e0;
            margin-top: 15px;
            /* Increase space from search bar */
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        /* Logo */
        .logo {
            display: block;
            width: 140px;
            height: 40px;
            background-image: url("{{ asset('images/logo.png') }}");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            flex-shrink: 0;
        }

        /* Search Bar */
        .search-container {
            flex: 1;
            margin: 0 2rem;
            max-width: 800px;
            display: flex;
            align-items: center;
            position: relative;
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
            margin-left: auto;
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
            position: relative;
        }

        .header-link:hover {
            color: #bf0000;
        }

        .header-link svg {
            width: 22px;
            height: 22px;
        }

        /* Sell Button */
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

        .sell-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 0.5rem;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 280px;
            z-index: 1000;
            display: none;
        }

        .sell-dropdown.show {
            display: block;
        }

        /* Category Nav Items */
        .cat-nav-item {
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            color: #333;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .cat-nav-item.badge-style {
            background: #f0f0f0;
            padding: 5px 15px;
            border-radius: 50px;
            font-weight: 500;
        }

        .cat-nav-item.badge-style:hover {
            background: #e0e0e0;
        }

        /* Inactive Buttons Style */
        .disabled-action {
            cursor: default !important;
            opacity: 0.6;
            pointer-events: none;
        }

        .disabled-action:hover {
            color: inherit !important;
            background: inherit !important;
        }

        /* Mobile Menu */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            color: #333;
            margin-right: 1rem;
        }

        @media (max-width: 1024px) {
            .mobile-menu-btn {
                display: block;
            }
            .search-container {
                display: none;
            }
            .header-container {
                gap: 1rem;
            }
        }

        .header-row-2 .header-container {
            justify-content: flex-start;
            margin-left: calc((100% - 1400px) / 2);
        }

        @media (min-width: 1600px) {
            .header-row-2 .header-container {
                margin-left: 5%;
            }
        }

        /* Mega Menu Positioning */
        .mobile-menu-drawer {
            position: absolute;
            top: 100%;
            left: 0;
            width: 250px;
            background: white;
            z-index: 2010;
            flex-direction: column;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid #e5e5e5;
            border-top: none;
            max-height: 85vh;
            border-radius: 0 0 4px 4px;
            overflow: hidden;
            transition: width 0.3s ease-in-out;
        }

        .mobile-menu-drawer.expanded {
            width: 1200px;
        }

        .active-cat-item {
            background: #000 !important;
            color: #fff !important;
        }

        .active-cat-item svg {
            color: #fff !important;
            opacity: 1 !important;
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
    </style>
    <style>
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

<body x-data="{ mobileMenuOpen: false }">
    <div class="top-banner" style="background-color: #bf0000; height: 40px; padding: 0;"></div>

    <!-- Header -->
    <header class="header">
        <div class="header-row-1">
            <div class="header-container" style="position: relative; min-height: 50px;">
                <button class="mobile-menu-btn">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Logo (Zone vide cliquable) -->
                <a href="{{ route('home') }}" class="logo"></a>

                <!-- Barre de recherche -->
                <div class="search-container">
                    <form action="{{ route('annonces.index') }}" method="GET" style="width: 100%;">
                        <div class="search-field">
                            <input type="text" name="search" class="search-input" placeholder="Rechercher un produit"
                                value="{{ request('search') }}">
                            <button type="submit" class="search-button">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="header-actions" style="margin-left: auto;">
                    @auth
                        @if(auth()->user()->hasRole('Administrateur'))
                            <a href="{{ route('admin.categories.l1') }}" class="header-link">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span style="font-weight: 800; color: #bf0000;">Back Office</span>
                            </a>
                        @endif
                    @endauth
                    <!-- Mettre en vente (Format home page) -->
                    <div class="sell-button-container">
                        <button type="button" class="sell-button" style="cursor: default;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                            <span>Mettre en vente</span>
                            <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div class="sell-dropdown" id="sellDropdown">
                            <!-- Inactif -->
                        </div>
                    </div>

                    <a href="{{ route('login') }}" class="header-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Connexion</span>
                    </a>

                    @inject('cartService', 'App\Services\CartService')
                    <span class="header-link disabled-action" title="Panier">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        @if($cartService->getItemsCount() > 0)
                            <span
                                style="position: absolute; top: -8px; right: -8px; background: #bf0000; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid white;">
                                {{ $cartService->getItemsCount() }}
                            </span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
        </div>

        <div class="header-row-2">
            <div class="header-container">
                <div class="cat-nav-item" @click="mobileMenuOpen = !mobileMenuOpen">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Toutes les catégories
                </div>
                <a href="{{ route('search.index', ['category' => 'e-commerce']) }}"
                    class="cat-nav-item badge-style">E-commerce</a>
                <a href="{{ route('search.index', ['category' => 'telephonie-tablette']) }}"
                    class="cat-nav-item badge-style">Téléphonie, Tablette</a>
                <a href="{{ route('search.index', ['category' => 'immobilier']) }}"
                    class="cat-nav-item badge-style">Immobilier</a>
                <a href="{{ route('search.index', ['category' => 'vehicules']) }}"
                    class="cat-nav-item badge-style">Véhicules</a>
            </div>
        </div>

        @php 
            $cats = \App\Models\Category::racines()->actives()->parOrdre()->get(); 
        @endphp

        <!-- Mega Menu Dropdown -->
        <div class="mobile-menu-drawer" x-show="mobileMenuOpen"
            :class="{ 'expanded': selectedCategory }" x-data="{ selectedCategory: null }"
            @click.away="mobileMenuOpen = false" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            style="display: none;">


            <!-- Main Content Panel -->
            <div style="display: flex; height: 600px; overflow: hidden; background: #fff;">
                <!-- Left Sidebar: All Categories -->
                <div
                style="width: 250px; min-width: 250px; background: #fff; border-right: 1px solid #f0f0f0; overflow-y: auto;">
                @foreach($cats as $cat)
                    <div class="cat-sidebar-item" :class="{ 'active-cat-item': selectedCategory == {{ $cat->id }} }"
                         @mouseenter="selectedCategory = {{ $cat->id }}" 
                         @click="selectedCategory = {{ $cat->id }}">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span
                                style="font-size: 1.25rem; width: 24px; text-align: center; color: inherit;">{!! $cat->icone ?? '📁' !!}</span>
                            <span style="font-size: 0.88rem; font-weight: 400;">{{ $cat->nom }}</span>
                        </div>
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </div>
                @endforeach
                </div>

                <!-- Right Pane: Hierarchical Content -->
                <div x-show="selectedCategory" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                style="flex: 1; overflow-y: auto; padding: 40px; background: #fff; border-left: 1px solid #eee;">
                    @foreach($cats as $cat)
                        <template x-if="selectedCategory == {{ $cat->id }}">
                            <div style="display: flex; gap: 60px;">
                                <!-- Hierarchical Groups -->
                                <div style="flex: 1; display: flex; flex-direction: column; gap: 0;">
                                    @foreach($cat->enfantsActifs as $sousCat)
                                        <div style="display: flex; border-bottom: 1px solid #eee; padding: 20px 0;">
                                            <!-- Level 2 Header -->
                                            <div style="width: 250px; padding-right: 30px;">
                                                <h3 style="font-size: 0.75rem; font-weight: 800; color: #000; text-transform: uppercase; letter-spacing: 0.5px; margin: 4px 0 0 0; line-height: 1.2;">
                                                    <a href="{{ route('categories.show', $sousCat->slug) }}" style="text-decoration: none; color: inherit;">{{ $sousCat->nom }}</a>
                                                </h3>
                                            </div>
                                            <!-- Level 3 Links Grid -->
                                            <div style="flex: 1; display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px 40px;">
                                                @foreach($sousCat->enfantsActifs as $enfant)
                                                    <a href="{{ route('categories.show', $enfant->slug) }}" style="text-decoration: none; color: #666; font-size: 0.85rem; transition: color 0.1s; font-weight: 400;" onmouseover="this.style.color='#000'; this.style.textDecoration='underline';" onmouseout="this.style.color='#666'; this.style.textDecoration='none';">
                                                        {{ $enfant->nom }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </template>
                    @endforeach
                </div>
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

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <input type="text" name="login" placeholder="E-mail ou pseudo" class="form-input-box"
                            value="{{ old('login') }}" required autofocus>
                        @error('login')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group password-container">
                        <input type="password" id="password" name="password" placeholder="Mot de passe"
                            class="form-input-box" required>
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
        document.addEventListener('click', function (event) {
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