<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte - Mady Market</title>
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
        
        /* Banner style Rakuten */
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
            width: 22px;
            height: 22px;
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
</head>
<body>
    <!-- Bannière (Top Banner) -->
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
                            placeholder="Rechercher un produit, une marque..."
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
            
            <!-- Actions du header -->
            <div class="header-actions">
                <a href="#" class="club-r">Club R</a>
                
                <!-- Mettre en vente -->
                <div class="sell-button-container">
                    <button type="button" class="sell-button" onclick="toggleSellDropdown()">
                        <span>Mettre en vente</span>
                        <svg class="chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="sell-dropdown" id="sellDropdown">
                        <a href="{{ route('annonces.create') }}" class="sell-dropdown-item">
                            <div class="sell-dropdown-item-title">Vendre un produit en tant que particulier</div>
                            <div class="sell-dropdown-item-subtitle">Je dépose une annonce gratuitement</div>
                        </a>
                    </div>
                </div>
                
                <!-- Mon Compte -->
                <a href="{{ route('profile.show') }}" class="header-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>{{ auth()->user()->prenom ?? auth()->user()->name }}</span>
                </a>

                <!-- Favoris -->
                <a href="{{ route('dashboard') }}" class="header-link" title="Favoris">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </a>
                
                <!-- Panier -->
                <a href="{{ route('dashboard') }}" class="header-link" title="Panier">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </a>
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
                    <li><a href="#">Tous mes achats</a></li>
                    <li><a href="#">Mes cartes cadeaux</a></li>
                    <li><a href="#">Messages concernant mes achats</a></li>
                    <li><a href="#">Revendez vos achats</a></li>
                </ul>
            </div>

            <!-- Mes Rakuten Points -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Mes Rakuten Points
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Voir mes Rakuten Points</a></li>
                    <li><a href="#">Sites partenaires Club R</a></li>
                </ul>
            </div>

            <!-- Mes favoris -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    Mes favoris
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Mes alertes prix (souhaits)</a></li>
                    <li><a href="#">Voir ma liste de favoris</a></li>
                    <li><a href="#">Mes vendeurs favoris</a></li>
                </ul>
            </div>

            <!-- Mes avis -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    Mes avis
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Tous mes avis</a></li>
                    <li><a href="#">Donnez votre avis sur vos produits</a></li>
                </ul>
            </div>

            <!-- Mes ventes -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                    Mes ventes
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Toutes mes ventes</a></li>
                    <li><a href="#">Messages concernant mes ventes</a></li>
                    <li><a href="#">Voir mes notes</a></li>
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
                    <li><a href="#">Voir ma Boutique</a></li>
                    <li><a href="#">Mes préférences vendeur</a></li>
                </ul>
            </div>

            <!-- Communauté -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Communauté
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Mes messages</a></li>
                    <li><a href="#">Contacter Rakuten</a></li>
                </ul>
            </div>

            <!-- Parrainez -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Parrainez vos amis
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Mes filleuls</a></li>
                </ul>
            </div>

            <!-- Mes finances -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Mes finances
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Mon Porte-Monnaie</a></li>
                    <li><a href="#">Mes paiements</a></li>
                    <li><a href="#">Mes déclarations</a></li>
                </ul>
            </div>

            <!-- Mes informations -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Mes informations
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('profile.show') }}">Mon adresse e-mail</a></li>
                    <li><a href="{{ route('profile.show') }}">Mon mot de passe</a></li>
                    <li><a href="#">Double authentification</a></li>
                    <li><a href="#">Mes préférences acheteur</a></li>
                    <li><a href="#">Mes préférences vendeur</a></li>
                    <li><a href="{{ route('abonnements.index') }}">Mes abonnements</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h1>Mon compte</h1>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Déconnexion
                    </button>
                </form>
            </div>

            <!-- Greeting Card -->
            <div class="greeting-card">
                <div class="greeting-info">
                    <h2>Bonjour {{ $user->prenom }}, découvrez le Club R</h2>
                    <p>• Profitez de cashback sur tous vos achats, toute l'année !</p>
                    <p>• Gratuit et sans engagement</p>
                    <a href="#">Devenir membre gratuitement</a>
                </div>
                <div class="promo-box">
                    <div class="promo-text">
                        <p>Gagnez plus en achetant ailleurs !</p>
                        <span>Jusqu'à 20% de cashback sur plus de 2000 sites</span>
                    </div>
                </div>
            </div>

            <!-- Security Alert -->
            <div class="alert-security">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <p>Attention votre compte n'est pas correctement sécurisé ! Pour renforcer la sécurité de votre compte, veuillez paramétrer la double authentification <a href="#">ici</a></p>
            </div>

            <!-- NPS Survey -->
            <div class="nps-box">
                <h3>Recommanderiez-vous Rakuten à vos proches ?</h3>
                <div class="nps-scale">
                    @for ($i = 0; $i <= 10; $i++)
                        <button class="nps-btn">{{ $i }}</button>
                    @endfor
                </div>
                <div class="nps-labels">
                    <span>0 = Pas du tout probable</span>
                    <span>10 = Très probable</span>
                </div>
                <button class="btn-black">
                    Envoyer
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>

            <!-- Solde de Crédits -->
            <div style="background: linear-gradient(135deg, #bf0000 0%, #8b0000 100%); color: white; border-radius: 12px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 4px 20px rgba(191, 0, 0, 0.3);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 0.9rem; opacity: 0.9; margin-bottom: 0.5rem;">Mon solde de crédits</div>
                        <div style="font-size: 2.5rem; font-weight: bold;">{{ number_format($user->credit_balance, 0, ',', ' ') }}</div>
                        <p style="opacity: 0.9; font-size: 0.9rem; margin-top: 0.5rem;">Utilisez vos crédits pour booster vos annonces</p>
                    </div>
                    <a href="{{ route('credits.index') }}" style="background: white; color: #bf0000; padding: 1rem 2rem; border-radius: 8px; text-decoration: none; font-weight: bold; transition: all 0.2s;">
                        Recharger
                    </a>
                </div>
            </div>

            <!-- Mes Achats -->
            <div class="section" style="margin-top: 1rem; margin-bottom: 3rem;">
                <h2 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1.5rem;">Mes achats récents</h2>
                @if($orders->count() > 0)
                    <div style="background: white; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left;">
                            <thead>
                                <tr style="background: #f9f9f9; border-bottom: 1px solid #e0e0e0; font-size: 0.85rem; color: #666;">
                                    <th style="padding: 1rem;">Commande</th>
                                    <th style="padding: 1rem;">Date</th>
                                    <th style="padding: 1rem;">Vendeur</th>
                                    <th style="padding: 1rem;">Total</th>
                                    <th style="padding: 1rem;">Statut</th>
                                    <th style="padding: 1rem;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr style="border-bottom: 1px solid #f0f0f0; font-size: 0.9rem;">
                                        <td style="padding: 1rem; font-weight: bold;">#{{ $order->reference }}</td>
                                        <td style="padding: 1rem;">{{ $order->created_at->format('d/m/Y') }}</td>
                                        <td style="padding: 1rem;">{{ $order->seller->user->prenom }}</td>
                                        <td style="padding: 1rem; font-weight: bold;">{{ number_format($order->total_final, 0, ',', ' ') }} FCFA</td>
                                        <td style="padding: 1rem;">
                                            <span style="background: #fdf2f2; color: #bf0000; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.75rem; font-weight: bold;">
                                                {{ strtoupper(str_replace('_', ' ', $order->statut)) }}
                                            </span>
                                        </td>
                                        <td style="padding: 1rem;">
                                            <a href="{{ route('logistics.track', $order->reference) }}" style="color: #bf0000; text-decoration: none; font-weight: bold;">Suivre →</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="padding: 2rem; text-align: center; background: #f9f9f9; border-radius: 8px; border: 2px dashed #e0e0e0;">
                        <p style="color: #666;">Vous n'avez pas encore passé de commande.</p>
                        <a href="{{ route('home') }}" style="color: #bf0000; font-weight: bold; text-decoration: none; display: block; margin-top: 1rem;">Découvrir les produits</a>
                    </div>
                @endif
            </div>

            <!-- Mes Annonces -->
            <div class="section" style="margin-top: 3rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.25rem; font-weight: bold;">Mes annonces</h2>
                    <a href="{{ route('annonces.create') }}" class="btn-black" style="padding: 0.5rem 1rem; font-size: 0.9rem;">+ Nouvelle annonce</a>
                </div>

                @if($annonces->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                        @foreach($annonces as $annonce)
                            <div style="background: white; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
                                <div style="position: relative; aspect-ratio: 16/9; background: #f5f5f5;">
                                    @if($annonce->medias->where('type', 'photo')->count() > 0)
                                        @php
                                            $photoPrincipale = $annonce->medias->where('type', 'photo')->where('est_principale', true)->first() 
                                                ?? $annonce->medias->where('type', 'photo')->first();
                                        @endphp
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($photoPrincipale->chemin) }}" alt="{{ $annonce->titre }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @endif
                                    <div style="position: absolute; top: 0.5rem; right: 0.5rem;">
                                        @if($annonce->statut === 'publiee')
                                            <span style="background: #28a745; color: white; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.75rem;">Publiée</span>
                                        @else
                                            <span style="background: #ffc107; color: #333; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.75rem;">{{ ucfirst($annonce->statut) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div style="padding: 1rem;">
                                    <h3 style="font-size: 0.95rem; font-weight: bold; margin-bottom: 0.5rem;">{{ $annonce->titre }}</h3>
                                    <div style="font-size: 1.1rem; font-weight: bold; color: #bf0000; margin-bottom: 1rem;">{{ number_format($annonce->prix, 0, ',', ' ') }} €</div>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="{{ route('annonces.show', $annonce) }}" style="flex: 1; text-align: center; padding: 0.4rem; background: #f5f5f5; color: #333; text-decoration: none; border-radius: 4px; font-size: 0.85rem;">Voir</a>
                                        <a href="{{ route('annonces.edit', $annonce) }}" style="flex: 1; text-align: center; padding: 0.4rem; background: #333; color: white; text-decoration: none; border-radius: 4px; font-size: 0.85rem;">Modifier</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="padding: 3rem; text-align: center; background: #f9f9f9; border-radius: 8px; border: 2px dashed #e0e0e0;">
                        <p style="color: #666;">Vous n'avez pas encore d'annonces.</p>
                        <a href="{{ route('annonces.create') }}" style="color: #bf0000; font-weight: bold; text-decoration: none; display: block; margin-top: 1rem;">Commencer à vendre</a>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <script>
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
