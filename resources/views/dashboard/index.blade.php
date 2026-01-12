<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte - Mady Market</title>
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

        .header-row-2 .header-container {
            justify-content: flex-start;
            margin-left: calc((100% - 1400px) / 2);
        }

        @media (min-width: 1600px) {
            .header-row-2 .header-container {
                margin-left: 5%;
            }
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
            width: 24px;
            height: 24px;
        }

        .header-link:hover {
            color: #bf0000;
        }

        /* Category Nav */
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

        /* Mettre en vente (Standard) */
        .sell-button-container {
            position: relative;
        }

        .sell-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            background: #fff;
            border: none;
            border-radius: 4px;
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .sell-button:hover {
            background: #f9f9f9;
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

        /* User Dropdown */
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
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
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

        .sell-button .chevron {
            width: 16px;
            height: 16px;
            transition: transform 0.2s;
        }

        .sell-button.active .chevron {
            transform: rotate(180deg);
        }

        .sell-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            min-width: 320px;
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
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
        }

        .sell-dropdown-item:hover {
            background: #f9f9f9;
        }

        .sell-dropdown-item-title {
            color: #333;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 0.2rem;
        }

        .sell-dropdown-item-subtitle {
            color: #666;
            font-size: 0.85rem;
        }

        /* Breadcrumb */
        .breadcrumb {
            max-width: 1200px;
            margin: 1rem auto;
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

        /* Layout */
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem 2rem;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 2rem;
        }

        /* Sidebar style Rakuten */
        .sidebar {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem 0;
            height: fit-content;
        }

        .sidebar-user {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 1rem;
        }

        .sidebar-user h2 {
            font-size: 1.1rem;
            color: #333;
            word-break: break-all;
        }

        .sidebar-section {
            margin-bottom: 1.5rem;
        }

        .sidebar-title {
            padding: 0.5rem 1.5rem;
            font-weight: bold;
            font-size: 0.95rem;
            color: #333;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.25rem;
        }

        .sidebar-title svg {
            width: 20px;
            height: 20px;
            color: #bf0000;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li a {
            display: block;
            padding: 0.4rem 1.5rem 0.4rem 3.25rem;
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .sidebar-menu li a:hover {
            color: #bf0000;
            background-color: #f9f9f9;
        }

        /* Main Content */
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

        /* Greeting Card */
        .greeting-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 2rem;
        }

        .club-r-img {
            width: 120px;
            height: auto;
        }

        .greeting-info h2 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .greeting-info p {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .greeting-info a {
            color: #bf0000;
            text-decoration: none;
            font-weight: 500;
            display: block;
            margin-top: 0.5rem;
        }

        .promo-box {
            background: #fdf2f2;
            border: 1px solid #f9e2e2;
            border-radius: 8px;
            padding: 1rem;
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .promo-text p {
            font-size: 0.95rem;
            font-weight: bold;
            color: #333;
        }

        .promo-text span {
            font-size: 0.85rem;
            color: #666;
        }

        .promo-logos {
            display: flex;
            gap: 0.75rem;
        }

        .promo-logos img {
            height: 25px;
            width: auto;
        }

        /* Alert Box */
        .alert-security {
            background: #fff;
            border: 1px solid #ffcc00;
            border-left: 4px solid #ffcc00;
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.95rem;
        }

        .alert-security svg {
            width: 24px;
            height: 24px;
            color: #ff9900;
            flex-shrink: 0;
        }

        .alert-security a {
            color: #bf0000;
            text-decoration: none;
        }

        /* NPS Section */
        .nps-box {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .nps-box h3 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .nps-scale {
            display: flex;
            justify-content: space-between;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .nps-btn {
            flex: 1;
            height: 40px;
            border: 1px solid #e0e0e0;
            background: #fff;
            color: #333;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .nps-btn:hover {
            border-color: #bf0000;
            color: #bf0000;
        }

        .nps-labels {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #666;
            margin-top: -0.75rem;
            margin-bottom: 1.5rem;
        }

        .btn-black {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        @media (max-width: 1024px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            .sidebar {
                display: none;
            }
            .greeting-card {
                flex-direction: column;
            }
            .promo-box {
                width: 100%;
            }
        }
    </style>
</head>
<body x-data="{ mobileMenuOpen: false }">
    <div class="top-banner" style="background-color: #bf0000; height: 40px; padding: 0;"></div>

    <!-- Header -->
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
                    <!-- Mettre en vente (Standard) -->
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

                    @auth
                        <div class="user-dropdown-container">
                            <div class="user-dropdown-trigger" id="userMenuTrigger">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    style="width: 20px; height: 20px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span style="font-size: 0.9rem; font-weight: 500; color: #333;">{{ auth()->user()->prenom }}</span>
                                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    style="opacity: 0.5;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7">
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
                    @else
                        <a href="{{ route('login') }}" class="header-link">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Se connecter</span>
                        </a>
                    @endauth

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

        <div class="header-row-2">
            <div class="header-container">
                <div class="cat-nav-item" @click="mobileMenuOpen = !mobileMenuOpen">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Toutes les catégories
                </div>
                <a href="{{ route('search.index', ['category' => 'e-commerce']) }}" class="cat-nav-item badge-style">E-commerce</a>
                <a href="{{ route('search.index', ['category' => 'telephonie-tablette']) }}" class="cat-nav-item badge-style">Téléphonie, Tablette</a>
                <a href="{{ route('search.index', ['category' => 'immobilier']) }}" class="cat-nav-item badge-style">Immobilier</a>
                <a href="{{ route('search.index', ['category' => 'vehicules']) }}" class="cat-nav-item badge-style">Véhicules</a>
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

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <span>Mon Compte</span>
    </div>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-user">
                <h2>{{ $user->prenom }}</h2>
            </div>

            <!-- Mes achats -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 10-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Mes achats
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('dashboard') }}">Tous mes achats</a></li>
                    <li><a href="{{ route('dashboard') }}">Messages concernant mes achats</a></li>
                </ul>
            </div>



            <!-- Mes ventes -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
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
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l5 5v11a2 2 0 01-2 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6"></path></svg>
                    Mes annonces
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('dashboard') }}">Toutes mes annonces</a></li>
                    <li><a href="{{ route('dashboard') }}">Voir ma Boutique</a></li>
                </ul>
            </div>



            <!-- Mes finances -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Mes finances
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('dashboard') }}">Mon Porte-Monnaie</a></li>
                    <li><a href="{{ route('dashboard') }}">Mes paiements</a></li>
                </ul>
            </div>

            <!-- Mes informations -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Mes informations
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('dashboard') }}">Mon adresse e-mail</a></li>
                    <li><a href="{{ route('dashboard') }}">Mon mot de passe</a></li>
                    <li><a href="{{ route('dashboard') }}">Mes abonnements</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h1>Mon compte</h1>
            </div>
            <!-- Contenu à venir -->
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Profile Dropdown
            const profileTrigger = document.getElementById('userMenuTrigger');
            const profileMenu = document.getElementById('userDropdownMenu');

            if (profileTrigger && profileMenu) {
                profileTrigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileMenu.classList.toggle('show');
                });

                document.addEventListener('click', function(e) {
                    if (!profileTrigger.contains(e.target) && !profileMenu.contains(e.target)) {
                        profileMenu.classList.remove('show');
                    }
                });
            }

            // Sell Dropdown
            window.toggleSellDropdown = function() {
                const button = event.target.closest('.sell-button');
                const container = button.closest('.sell-button-container');
                const dropdown = container.querySelector('.sell-dropdown');
                
                dropdown.classList.toggle('show');
                button.classList.toggle('active');
            };
            
            document.addEventListener('click', function(event) {
                const container = document.querySelector('.sell-button-container');
                if (container && !container.contains(event.target)) {
                    const dropdown = container.querySelector('.sell-dropdown');
                    const button = container.querySelector('.sell-button');
                    if (dropdown) dropdown.classList.remove('show');
                    if (button) button.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
