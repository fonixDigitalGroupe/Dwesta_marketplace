<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Mady Market</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }

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
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            gap: 2rem;
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
            position: relative;
        }

        .header-link svg {
            width: 22px;
            height: 22px;
        }

        .header-link:hover {
            color: #bf0000;
        }

        .cat-nav-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            color: #333;
            text-decoration: none;
            cursor: pointer;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background 0.2s;
        }

        .cat-nav-item:hover {
            background: #f5f5f5;
        }

        .badge-style {
            background: #f1f1f1;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
        }

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
            margin: 1rem 0 1rem 10rem;
            padding: 0 1rem;
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
            margin: 0 6rem 2rem 10rem;
            padding: 0 1rem 2rem;
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 2rem;
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

        .btn-logout {
            color: #666;
            text-decoration: none;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .btn-logout:hover {
            text-decoration: underline;
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

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>

<body x-data="{ mobileMenuOpen: false }">
    <div class="top-banner" style="background-color: #bf0000; height: 40px; padding: 0;"></div>

    <!-- Header (Same as Dashboard) -->
    <header class="header">
        <div class="header-row-1">
            <div class="header-container">
                <a href="{{ route('home') }}" class="logo"></a>

                <div class="search-container">
                    <form action="{{ route('search.index') }}" method="GET" style="width: 100%; display: flex;">
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

                <div class="header-actions">
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
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="sell-dropdown" id="layoutSellDropdown">
                            <!-- Inactif -->
                        </div>
                    </div>

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

                    <div class="user-dropdown-container">
                        <div class="user-dropdown-trigger" id="userMenuTrigger">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="width: 20px; height: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span
                                style="font-size: 0.9rem; font-weight: 500; color: #333;">{{ auth()->user()->prenom }}</span>
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                style="opacity: 0.5;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                        <div class="user-dropdown-menu" id="userDropdownMenu">
                            <a href="{{ route('dashboard') }}" class="user-dropdown-item">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Mon compte
                            </a>
                            <div class="user-dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="user-dropdown-item" style="color: #e03131;">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                    <span class="header-link disabled-action" title="Favoris">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </span>

                    @inject('cartService', 'App\Services\CartService')
                    <span class="header-link disabled-action" title="Panier">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </span>
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
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('dashboard') }}">Mon Compte</a> > <span>Mon
            Profil</span>
    </div>

    <div class="dashboard-container">
        <!-- Sidebar (Same as Dashboard) -->
        <aside class="sidebar">
            <div class="sidebar-user">
                <h2>{{ $user->prenom }}</h2>
            </div>

            <!-- Mes achats -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <!-- Orange Box Icon -->
                    <svg viewBox="0 0 24 24" style="width: 22px; height: 22px;">
                        <path d="M4 9h16v11H4z" fill="#f39c12" />
                        <path d="M2 7l4 2h12l4-2-4-3H6z" fill="#ffb74d" />
                        <path d="M4 9l-2-2v2l2 2z" fill="#e67e22" />
                        <path d="M20 9l2-2v2l-2 2z" fill="#e67e22" />
                    </svg>
                    Mes achats
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Tous mes achats</a></li>
                    <li><a href="#">Mes cartes cadeaux</a></li>
                    <li><a href="#">Mes favoris</a></li>
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
                    <li><a href="#">Donnez votre avis sur vos produits</a></li>
                </ul>
            </div>

            <div class="sidebar-divider"></div>

            <!-- Mes ventes -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg viewBox="0 0 24 24" fill="#757575">
                        <path
                            d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z" />
                    </svg>
                    Mes ventes
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('dashboard') }}">Toutes mes ventes</a></li>
                    <li><a href="{{ route('dashboard') }}">Messages concernant mes ventes</a></li>
                </ul>
            </div>

            <!-- Mes annonces -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg viewBox="0 0 24 24" style="width: 22px; height: 22px;">
                        <path d="M18.36 11l.64-3H5l.64 3h12.72z" fill="#f44336" />
                        <path
                            d="M3 11c0 1.1.9 2 2 2h1c1.1 0 2-.9 2-2 0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2 0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2"
                            fill="#f44336" />
                        <path d="M4 12v8c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8H4z" fill="#ff9800" />
                        <path d="M9 22v-4h6v4H9z" fill="#fff" opacity="0.5" />
                        <path d="M7 8h2l-0.5 3h-2z" fill="#fff" opacity="0.9" />
                        <path d="M11 8h2l-0.5 3h-2z" fill="#fff" opacity="0.9" />
                        <path d="M15 8h2l-0.5 3h-2z" fill="#fff" opacity="0.9" />
                    </svg>
                    Mes annonces
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Toutes mes annonces</a></li>
                    <li><a href="#">Voir ma Boutique</a></li>
                </ul>
            </div>

            <!-- Communauté -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <!-- Dual Speech Bubbles Icon -->
                    <svg viewBox="0 0 24 24" style="width: 22px; height: 22px;">
                        <!-- Dark blue bubble -->
                        <path d="M4 4h12c1.1 0 2 .9 2 2v8c0 1.1-.9 2-2 2h-4l-4 4v-4H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                            fill="#2c3e50" />
                        <path d="M6 8h8M6 11h5" stroke="#fff" stroke-width="1.5" stroke-linecap="round" />
                        <!-- Light blue bubble -->
                        <path
                            d="M10 10h10c1.1 0 2 .9 2 2v6c0 1.1-.9 2-2 2h-3l-3 3v-3h-4c-1.1 0-2-.9-2-2v-6c0-1.1.9-2 2-2z"
                            fill="#d1d9e6" stroke="#2c3e50" stroke-width="0.5" />
                        <path d="M12 13h6M12 16h4" stroke="#2c3e50" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                    Communauté
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Mes messages</a></li>
                    <li><a href="#">Contacter Mady Market</a></li>
                </ul>
            </div>

            <!-- Mes finances -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <!-- Credit Card Icon -->
                    <svg viewBox="0 0 24 24" style="width: 22px; height: 22px;">
                        <rect x="2" y="5" width="20" height="14" rx="2" fill="#34495e" />
                        <rect x="2" y="8" width="20" height="3" fill="#2c3e50" />
                        <rect x="16" y="14" width="3" height="2" rx="0.5" fill="#ecf0f1" opacity="0.8" />
                    </svg>
                    Mes finances
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('dashboard') }}">Mon Porte-Monnaie</a></li>
                    <li><a href="{{ route('dashboard') }}">Mes paiements</a></li>
                    <li><a href="#">Statistique</a></li>
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

        <!-- Main Content -->
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
                            <input type="email" name="email" class="rakuten-input"
                                value="{{ old('email', $user->email) }}" required>
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
                                <input type="password" name="current_password"
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

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Nouveau mot de passe</label>
                            <div class="password-container">
                                <input type="password" name="password" class="rakuten-input password-toggle-input"
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

        document.addEventListener('DOMContentLoaded', function () {
            // Profile Dropdown
            const profileTrigger = document.getElementById('userMenuTrigger');
            const profileMenu = document.getElementById('userDropdownMenu');

            if (profileTrigger && profileMenu) {
                profileTrigger.addEventListener('click', function (e) {
                    e.stopPropagation();
                    profileMenu.classList.toggle('show');
                });

                document.addEventListener('click', function (e) {
                    if (!profileTrigger.contains(e.target) && !profileMenu.contains(e.target)) {
                        profileMenu.classList.remove('show');
                    }
                });
            }
    });
    </script>
</body>

</html>