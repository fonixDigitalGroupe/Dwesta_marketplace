@php use Illuminate\Support\Facades\Storage; @endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pagePro->vendeur->estProfessionnel() && $pagePro->vendeur->professionnel ? $pagePro->vendeur->professionnel->nom_entreprise : $pagePro->vendeur->user->prenom . ' ' . ($pagePro->vendeur->user->nom ?? '') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
        }
        
        /* Bannière promotionnelle */
        .promo-banner {
            background-color: #193D23;
            color: white;
            padding: 0.75rem 1rem;
            width: 100%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            gap: 1rem;
        }
        
        .promo-banner-content {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex: 1;
            justify-content: center;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .promo-chevron {
            cursor: pointer;
            padding: 0.25rem;
            display: flex;
            align-items: center;
        }
        
        .promo-chevron:hover {
            background-color: rgba(255,255,255,0.1);
            border-radius: 4px;
        }
        
        .promo-link {
            color: white;
            text-decoration: underline;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        
        .promo-link:hover {
            text-decoration: none;
        }
        
        /* Header principal */
        .header {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        /* Barre de recherche */
        .search-container {
            flex: 1;
            display: flex;
            align-items: center;
            max-width: 600px;
        }
        
        .search-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px 0 0 4px;
            font-size: 1rem;
            outline: none;
        }
        
        .search-input:focus {
            border-color: #193D23;
        }
        
        .search-button {
            background-color: #666;
            color: white;
            border: none;
            padding: 0.75rem 1.25rem;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .search-button:hover {
            background-color: #555;
        }
        
        .search-icon {
            width: 20px;
            height: 20px;
        }
        
        /* Actions du header */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
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
            color: #193D23;
        }
        
        .header-icon {
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
            color: #193D23;
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
        
        /* Page Pro - Bannière */
        .page-pro-banner {
            width: 100%;
            height: 250px;
            overflow: hidden;
            position: relative;
            background: linear-gradient(135deg, #193D23 0%, #0f2415 100%);
        }
        
        .page-pro-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Page Pro - Header */
        .page-pro-header {
            background: white;
            border-bottom: 1px solid #e0e0e0;
            padding: 2rem 0;
        }
        
        .page-pro-header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            align-items: flex-start;
            gap: 2rem;
        }
        
        .page-pro-logo {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-top: -60px;
            background: white;
            padding: 0.25rem;
        }
        
        .page-pro-logo-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-top: -60px;
            font-size: 3rem;
        }
        
        .page-pro-info {
            flex: 1;
            padding-top: 0.5rem;
        }
        
        .page-pro-name {
            font-size: 1.75rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .page-pro-description {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1rem;
        }
        
        .page-pro-stats {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }
        
        .page-pro-stat {
            display: flex;
            flex-direction: column;
        }
        
        .page-pro-stat-value {
            font-size: 1.25rem;
            font-weight: 600;
            color: #193D23;
        }
        
        .page-pro-stat-label {
            font-size: 0.85rem;
            color: #666;
        }
        
        .page-pro-contact {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }
        
        .page-pro-contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #666;
            font-size: 0.9rem;
        }
        
        .page-pro-contact-item a {
            color: #193D23;
            text-decoration: none;
        }
        
        .page-pro-contact-item a:hover {
            text-decoration: underline;
        }
        
        .page-pro-social {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }
        
        .page-pro-social-link {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
            font-size: 0.875rem;
        }
        
        .page-pro-social-link.facebook { background: #1877F2; }
        .page-pro-social-link.instagram { background: #E4405F; }
        .page-pro-social-link.twitter { background: #1DA1F2; }
        .page-pro-social-link.linkedin { background: #0077B5; }
        
        /* Contenu principal */
        .page-pro-content {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        /* Filtres et tri */
        .page-pro-filters {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .page-pro-filters-left {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .page-pro-filters-right {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .filter-select {
            padding: 0.5rem 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-size: 0.9rem;
            background: white;
            cursor: pointer;
        }
        
        .filter-select:focus {
            outline: none;
            border-color: #193D23;
        }
        
        /* Grille de produits */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }
        
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
        }
        
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        }
        
        .product-card-image {
            width: 100%;
            aspect-ratio: 1;
            overflow: hidden;
            background: #f5f5f5;
            position: relative;
        }
        
        .product-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .product-card-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: #193D23;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .product-card-content {
            padding: 1rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .product-card-title {
            font-size: 0.95rem;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.4;
        }
        
        .product-card-category {
            font-size: 0.8rem;
            color: #999;
            margin-bottom: 0.75rem;
        }
        
        .product-card-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: #193D23;
            margin-top: auto;
        }
        
        .product-card-rating {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: #666;
        }
        
        .product-card-rating-stars {
            color: #ffc107;
        }
        
        /* Section avis */
        .reviews-section {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .reviews-list {
            display: grid;
            gap: 1.5rem;
        }
        
        .review-item {
            padding: 1.5rem;
            background: #f9f9f9;
            border-radius: 8px;
            border-left: 4px solid #193D23;
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 0.75rem;
        }
        
        .review-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .review-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #193D23;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }
        
        .review-user-name {
            font-weight: 500;
            color: #333;
        }
        
        .review-rating {
            display: flex;
            gap: 0.25rem;
            color: #ffc107;
        }
        
        .review-text {
            color: #666;
            line-height: 1.6;
            margin-bottom: 0.5rem;
        }
        
        .review-product {
            font-size: 0.85rem;
            color: #999;
        }
        
        .review-product a {
            color: #193D23;
            text-decoration: none;
        }
        
        .review-product a:hover {
            text-decoration: underline;
        }
        
        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }
        
        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 8px;
        }
        
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .empty-state-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }
        
        .empty-state-text {
            color: #666;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <!-- Barre de recherche -->
            <div class="search-container">
                <form action="{{ route('annonces.index') }}" method="GET" style="display: flex; width: 100%;">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input" 
                        placeholder="Rechercher un produit"
                        value="{{ request('search') }}"
                    >
                    <button type="submit" class="search-button">
                        <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>
            
            <!-- Actions du header -->
            <div class="header-actions">
                @auth
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
                    
                    <!-- Profil -->
                    <a href="{{ route('profile.show') }}" class="header-link">
                        <svg class="header-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>{{ auth()->user()->prenom ?? auth()->user()->name }}</span>
                    </a>
                    
                    <!-- Favoris -->
                    <a href="{{ route('dashboard') }}" class="header-link" title="Favoris">
                        <svg class="header-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </a>
                    
                    <!-- Panier -->
                    <a href="{{ route('dashboard') }}" class="header-link" title="Panier">
                        <svg class="header-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </a>
                @else
                    <!-- Mettre en vente -->
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
                    
                    <!-- Se connecter -->
                    <a href="{{ route('login') }}" class="header-link">
                        <svg class="header-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Se connecter</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>
    
    <!-- Bannière de la page pro -->
    <div class="page-pro-banner">
        @if($pagePro->banniere)
            <img src="{{ Storage::url($pagePro->banniere) }}" alt="Bannière">
        @endif
    </div>
    
    <!-- Header de la page pro -->
    <div class="page-pro-header">
        <div class="page-pro-header-content">
            @if($pagePro->logo)
                <img src="{{ Storage::url($pagePro->logo) }}" alt="Logo" class="page-pro-logo">
            @else
                <div class="page-pro-logo-placeholder">📦</div>
            @endif
            
            <div class="page-pro-info">
                <h1 class="page-pro-name">
                    @if($pagePro->vendeur->estProfessionnel() && $pagePro->vendeur->professionnel)
                        {{ $pagePro->vendeur->professionnel->nom_entreprise }}
                    @else
                        {{ $pagePro->vendeur->user->prenom }} {{ $pagePro->vendeur->user->nom ?? '' }}
                    @endif
                </h1>
                
                @if($pagePro->description)
                    <p class="page-pro-description">{{ $pagePro->description }}</p>
                @endif
                
                <div class="page-pro-stats">
                    <div class="page-pro-stat">
                        <span class="page-pro-stat-value">{{ $annonces->total() }}</span>
                        <span class="page-pro-stat-label">Produits</span>
                    </div>
                    @php
                        $noteMoyenne = $avis->avg('note') ?? 0;
                        $nombreAvis = $avis->count();
                    @endphp
                    <div class="page-pro-stat">
                        <span class="page-pro-stat-value">{{ number_format($noteMoyenne, 1) }}</span>
                        <span class="page-pro-stat-label">Note moyenne ({{ $nombreAvis }} avis)</span>
                    </div>
                    <div class="page-pro-stat">
                        <span class="page-pro-stat-value">{{ $pagePro->vues }}</span>
                        <span class="page-pro-stat-label">Vues</span>
                    </div>
                </div>
                
                <div class="page-pro-contact">
                    @if($pagePro->telephone_contact)
                        <div class="page-pro-contact-item">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <a href="tel:{{ $pagePro->telephone_contact }}">{{ $pagePro->telephone_contact }}</a>
                        </div>
                    @endif
                    
                    @if($pagePro->email_contact)
                        <div class="page-pro-contact-item">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <a href="mailto:{{ $pagePro->email_contact }}">{{ $pagePro->email_contact }}</a>
                        </div>
                    @endif
                    
                    @if($pagePro->site_web)
                        <div class="page-pro-contact-item">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                            </svg>
                            <a href="{{ $pagePro->site_web }}" target="_blank">Site web</a>
                        </div>
                    @endif
                </div>
                
                @if($pagePro->reseaux_sociaux && !empty($pagePro->reseaux_sociaux))
                    <div class="page-pro-social">
                        @if(isset($pagePro->reseaux_sociaux['facebook']))
                            <a href="{{ $pagePro->reseaux_sociaux['facebook'] }}" target="_blank" class="page-pro-social-link facebook" title="Facebook">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                        @endif
                        @if(isset($pagePro->reseaux_sociaux['instagram']))
                            <a href="{{ $pagePro->reseaux_sociaux['instagram'] }}" target="_blank" class="page-pro-social-link instagram" title="Instagram">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        @endif
                        @if(isset($pagePro->reseaux_sociaux['twitter']))
                            <a href="{{ $pagePro->reseaux_sociaux['twitter'] }}" target="_blank" class="page-pro-social-link twitter" title="Twitter">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                        @endif
                        @if(isset($pagePro->reseaux_sociaux['linkedin']))
                            <a href="{{ $pagePro->reseaux_sociaux['linkedin'] }}" target="_blank" class="page-pro-social-link linkedin" title="LinkedIn">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Contenu principal -->
    <div class="page-pro-content">
        <!-- Filtres et tri -->
        @if($annonces->count() > 0)
            <div class="page-pro-filters">
                <div class="page-pro-filters-left">
                    <span style="font-weight: 500; color: #333;">{{ $annonces->total() }} produit{{ $annonces->total() > 1 ? 's' : '' }}</span>
                </div>
                <div class="page-pro-filters-right">
                    <select class="filter-select" onchange="window.location.href=this.value">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" {{ request('sort') == 'latest' ? 'selected' : '' }}>Plus récent</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                    </select>
                </div>
            </div>
        @endif
        
        <!-- Grille de produits -->
        @if($annonces->count() > 0)
            <div class="products-grid">
                @foreach($annonces as $annonce)
                    <a href="{{ route('annonces.show', $annonce->slug) }}" class="product-card">
                        <div class="product-card-image">
                            @php
                                $photoPrincipale = $annonce->medias->where('type', 'photo')->where('est_principale', true)->first() 
                                    ?? $annonce->medias->where('type', 'photo')->first();
                            @endphp
                            @if($photoPrincipale)
                                <img src="{{ Storage::url($photoPrincipale->chemin) }}" alt="{{ $annonce->titre }}">
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: #999;">
                                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            @if($annonce->estALaUne())
                                <span class="product-card-badge">À la une</span>
                            @endif
                            @if($annonce->estUrgent())
                                <span class="product-card-badge" style="background: #dc3545;">Urgent</span>
                            @endif
                        </div>
                        <div class="product-card-content">
                            <h3 class="product-card-title">{{ $annonce->titre }}</h3>
                            @if($annonce->categorie)
                                <div class="product-card-category">{{ $annonce->categorie->nom }}</div>
                            @endif
                            <div class="product-card-price">{{ number_format($annonce->prix, 0, ',', ' ') }} €</div>
                            @if($annonce->note_moyenne > 0)
                                <div class="product-card-rating">
                                    <span class="product-card-rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($annonce->note_moyenne))
                                                ★
                                            @elseif($i - 0.5 <= $annonce->note_moyenne)
                                                ☆
                                            @else
                                                ☆
                                            @endif
                                        @endfor
                                    </span>
                                    <span>({{ $annonce->nombre_avis }})</span>
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($annonces->hasPages())
                <div class="pagination-wrapper">
                    {{ $annonces->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📦</div>
                <h3 class="empty-state-title">Aucun produit disponible</h3>
                <p class="empty-state-text">Ce vendeur n'a pas encore publié de produits.</p>
            </div>
        @endif
        
        <!-- Section avis -->
        @if($avis->count() > 0)
            <div class="reviews-section">
                <h2 class="section-title">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                    Avis clients ({{ $avis->count() }})
                </h2>
                <div class="reviews-list">
                    @foreach($avis as $review)
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-user">
                                    <div class="review-user-avatar">
                                        {{ strtoupper(substr($review->user->prenom ?? $review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="review-user-name">{{ $review->user->prenom ?? $review->user->name }}</div>
                                        <div style="font-size: 0.85rem; color: #999;">{{ $review->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->note)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            @if($review->commentaire)
                                <div class="review-text">{{ $review->commentaire }}</div>
                            @endif
                            @if($review->annonce)
                                <div class="review-product">
                                    Avis pour : <a href="{{ route('annonces.show', $review->annonce->slug) }}">{{ $review->annonce->titre }}</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
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
            const containers = document.querySelectorAll('.sell-button-container');
            
            containers.forEach(container => {
                const dropdown = container.querySelector('.sell-dropdown');
                const button = container.querySelector('.sell-button');
                
                if (container && !container.contains(event.target)) {
                    if (dropdown) dropdown.classList.remove('show');
                    if (button) button.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
