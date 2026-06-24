@extends('layouts.app')

@section('title', $category->nom . ' - Karnou')

@push('styles')
<style>
    .category-show-container { max-width: 1200px; margin: 1rem auto; padding: 0 1rem; }
    
    .breadcrumbs { margin-bottom: 1rem; font-size: 0.85rem; color: #666; display: flex; align-items: center; gap: 0.5rem; }
    .breadcrumbs a { color: #333; text-decoration: none; }
    .breadcrumbs a:hover { color: #bf0000; }
    .breadcrumbs span { color: #ccc; }

    /* N1 Grand Presentation Header */
    .n1-grand-banner {
        width: 100%;
        height: 260px;
        background-color: #ffffff;
        background-image: url('https://images.unsplash.com/photo-1589923188900-85dae523342b?q=80&w=2070&auto=format&fit=crop'); /* Placeholder image representing garden/tools */
        background-size: cover;
        background-position: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        position: relative;
    }
    /* Dimmer to ensure text holds regardless of the image */
    .n1-grand-banner::before {
        content: '';
        position: absolute;
        top:0; left:0; right:0; bottom:0;
        background: rgba(0,0,0,0.3);
    }
    .n1-grand-banner-content { 
        position: relative; 
        z-index: 10; 
        width: 100%;
        max-width: 600px;
        padding: 0 20px;
    }

    /* In-page Search Bar */
    .n1-banner-search-wrapper {
        margin-top: 25px;
        position: relative;
    }
    .n1-banner-search-input {
        width: 100%;
        padding: 14px 20px 14px 50px;
        border-radius: 50px;
        border: none;
        background: rgba(255, 255, 255, 0.95);
        color: #333;
        font-size: 1rem;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        backdrop-filter: blur(5px);
    }
    .n1-banner-search-input:focus {
        background: #fff;
        outline: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.25);
        transform: translateY(-2px);
    }
    .n1-banner-search-icon {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        font-size: 1.2rem;
    }
    
    .n1-grand-banner h1 {
        font-family: 'Playfair Display', serif; /* or something elegant */
        font-size: 3.5rem;
        font-weight: 700;
        margin: 0 0 10px 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }
    .n1-grand-banner p {
        font-size: 1.5rem;
        font-weight: 400;
        font-style: italic;
        margin: 0;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }

    /* Horizontal Category Nav */
    .n1-horizontal-menu-wrapper {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 0 10px;
        margin-bottom: 2rem;
        width: calc(100% - 20px);
        margin-left: 10px;
        margin-right: 10px;
        position: relative; /* Remove sticky if requested, but let's see */
    }
    .n1-horizontal-menu {
        display: flex;
        align-items: center;
        gap: 2.2rem;
        padding: 10px 5px;
        overflow-x: auto;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
    .n1-horizontal-menu::-webkit-scrollbar { display: none; }
    
    /* Green home icon circle -> White */
    .n1-nav-home-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        background-color: #ff8c00;
        color: #fff;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    .n1-nav-home-btn:hover { background-color: #e67e00; transform: scale(1.05); }

    body { 
        margin: 0; 
        padding: 0; 
        overflow-x: hidden; /* Global fix for the horizontal bar */
        width: 100%;
        background-color: #fff !important;
    }
    .catalog-page-container {
        overflow-x: hidden;
        width: 100%;
        max-width: 100vw;
    }
    /* Redundant rules removed */

    .n1-cat-nav-link { 
        display: block; 
        padding: 8px 0; 
        text-decoration: none; 
        color: #555;
        font-weight: 500; 
        font-size: 0.95rem; 
        white-space: nowrap;
        transition: color 0.2s;
        background: transparent;
        border: none;
        box-shadow: none;
    }
    .n1-cat-nav-link:hover { 
        color: #ff8c00; 
    }
    .n1-cat-nav-link.active {
        background-color: transparent;
        color: #ff8c00 !important;
        font-weight: 800;
        border: none;
        box-shadow: none;
    }
    .n1-nav-home-btn.active {
        background-color: #ff8c00 !important;
        color: #fff !important;
        box-shadow: none;
    }

    .n1-promo-bar {
        background-color: #c43b1d;
        color: #fff;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        width: 100%;
        overflow: hidden;
    }
    .n1-promo-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    .n1-promo-badge {
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .n1-promo-text {
        font-weight: 400;
    }
    .n1-promo-code {
        background: #fff;
        color: #000;
        padding: 1px 4px;
        font-weight: 800;
        margin-left: 4px;
        border-radius: 1px;
    }
    
    .ads-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem; }
    .catalog-main-column { overflow: hidden; }

    /* Top Consulted Section (Homepage Style) */
    .n1-top-consulted-section {
        padding: 4rem 0 1rem 0;
        background: #fff;
        margin-top: 2rem;
    }
    .sections-global-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.5rem;
        font-weight: 600;
        color: #334155;
        text-align: center;
        margin-bottom: 2rem;
        letter-spacing: -0.01em;
    }
    .n1-top-consulted-carousel {
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
        padding: 0 50px;
    }
    .n1-top-grid {
        display: flex;
        gap: 1.5rem;
        overflow-x: hidden;
        scroll-behavior: smooth;
        padding: 1.5rem 0.5rem;
    }
    
    /* Product Card Premium (Flat Style) */
    .premium-card-flat {
        flex: 0 0 220px;
        background: #fff;
        border: 1px solid #efefef;
        border-radius: 12px;
        padding: 1rem;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: border-color 0.2s;
    }
    .premium-card-flat:hover {
        border-color: #eee;
        transform: none !important;
        box-shadow: none !important;
    }
    .card-media-flat {
        width: 100%;
        height: 180px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #fff;
    }
    .card-media-flat img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .card-info-flat {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .card-title-flat {
        font-size: 0.95rem;
        line-height: 1.4;
        color: #1a1a1a;
        margin-bottom: 8px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        font-weight: 800;
        min-height: 2.8rem;
    }
    .card-price-row-flat {
        margin-top: auto;
        display: flex;
        align-items: baseline;
        gap: 6px;
        flex-wrap: wrap;
    }
    .price-value-flat {
        color: #f68b1e;
        font-weight: 800;
        font-size: 1.2rem;
        text-shadow: none !important;
    }
    .card-etat-badge {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .card-review-row {
        display: flex;
        align-items: center;
        gap: 2px;
        color: #ffc107;
        font-size: 0.75rem;
        margin-top: 6px;
    }
    .card-review-count {
        color: #007185;
        margin-left: 4px;
    }

    .carousel-arrow-btn {
        width: 44px;
        height: 44px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: all 0.2s;
        z-index: 10;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
    }
    .carousel-arrow-btn:hover {
        background: #f8f8f8;
        border-color: #004aad;
        color: #004aad;
    }
    .btn-left { left: 0; }
    .btn-right { right: 0; }

    .btn-clean-pill {
        display: inline-block;
        padding: 0.7rem 3rem;
        border: 1.5px solid #1a1a1a;
        border-radius: 999px;
        background: transparent;
        color: #1a1a1a;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        font-family: 'Outfit', sans-serif;
    }
    .btn-clean-pill:hover {
        background: #1a1a1a;
        color: #fff;
    }
    
    @media (max-width: 1200px) {
        .n1-top-card { flex: 0 0 calc(25% - 10px); }
    }
    @media (max-width: 768px) {
        .n1-top-card { flex: 0 0 calc(50% - 10px); }
    }
</style>
@endpush

@section('content')

<!-- GRANDE PRESENTATION POUR LES CATEGORIES DE NIVEAU 1 -->
@if($category->parent_id === null && request('view') !== 'list')

    @php
        $bgImage = 'https://images.unsplash.com/photo-1589923188900-85dae523342b?q=80&w=2070&auto=format&fit=crop';
        if ($category->image) {
            $bgImage = $category->image;
        } elseif ($banner) {
            $bgImage = $banner->image_url;
        }
    @endphp
    <div class="n1-grand-banner" style="background-image: url('{{ $bgImage }}');">
        @php
            $bannerLink = $banner->link_url ?? '#';
            if ($banner && $banner->is_promo && $banner->slug) {
                $bannerLink = route('collections.show', $banner->slug);
            }
        @endphp
        @if($banner && $bannerLink)
            <a href="{{ $bannerLink }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 5;"></a>
        @endif

        <div class="n1-grand-banner-content">
            <h1>{{ $category->nom }}</h1>
            <p>{{ $category->description ?? 'Découvrez notre sélection exclusive' }}</p>
            
            <div class="n1-banner-search-wrapper">
                <i class="fas fa-search n1-banner-search-icon"></i>
                <input type="text" id="n1-page-search" class="n1-banner-search-input" placeholder="Rechercher dans cette catégorie..." oninput="handleInPageSearch(this.value)">
            </div>
        </div>
    </div>

    <div class="n1-horizontal-menu-wrapper">
        <div class="n1-horizontal-menu">
            <a href="#" class="n1-nav-home-btn active" onclick="filterWholePage('all', this); return false;" title="Accueil catégorie">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" width="18" height="18">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
            </a>
            
            @if(isset($category->enfantsActifs))
                @foreach($category->enfantsActifs as $enfant)
                    <a href="#" class="n1-cat-nav-link" data-n2-id="{{ $enfant->id }}" data-slug="{{ $enfant->slug }}" onclick="filterWholePage('{{ $enfant->id }}', this); return false;">{{ $enfant->nom }}</a>
                @endforeach
            @endif
        </div>
    </div>
@endif

@if($category->parent_id === null && request('view') !== 'list' && isset($topConsultes) && $topConsultes->count() > 0)
    <section class="n1-top-consulted-section">
        <h2 class="sections-global-title">Top des produits les plus consultés</h2>
        
        <div class="n1-top-consulted-carousel">
            <button class="carousel-arrow-btn btn-left" onclick="n1CarouselScroll('n1-top-products', -1)" aria-label="Précédent">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            
            <div class="n1-top-grid" id="n1-top-products">
                @foreach($topConsultes as $annonce)
                    @php
                        $itemN2Id = ($annonce->category->parent && $annonce->category->parent->parent_id === null) ? $annonce->categorie_id : $annonce->category->parent_id;
                    @endphp
                    @include('partials.product-card-premium', [
                        'annonce' => $annonce, 
                        'class' => 'global-filter-item', 
                        'attributes' => 'data-n2="' . $itemN2Id . '"'
                    ])
                @endforeach
            </div>

            <button class="carousel-arrow-btn btn-right" onclick="n1CarouselScroll('n1-top-products', 1)" aria-label="Suivant">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>

    </section>
@endif

<div class="catalog-page-container">
    <div class="catalog-layout {{ ($category->parent_id === null && request('view') !== 'list') ? 'no-sidebar' : '' }}">
        <!-- Sidebar -->
        @if($category->parent_id !== null || request('view') === 'list')
        <aside class="catalog-sidebar-column">
            @include('partials.catalog-sidebar')
        </aside>
        @endif

        <!-- Main Content -->
        <main class="catalog-main-column">
            
            @if($category->parent_id !== null || request('view') === 'list')
                <!-- Affichage classique pour les N2 et N3 (Breadcrumbs) -->
                <div class="catalog-breadcrumbs">
                    <a href="{{ route('home') }}">Accueil</a>
                    @foreach($category->ancetres as $ancetre)
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 2px; opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                        <a href="{{ route('categories.show', $ancetre->slug) }}">{{ $ancetre->nom }}</a>
                    @endforeach
                    <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 2px; opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    <span>{{ $category->nom }}</span>
                </div>

                <div class="catalog-header">
                    <h1 class="header-title">{{ $category->nom }}</h1>
                </div>
            @endif




            @if($category->parent_id === null && request('view') !== 'list')
                @if(count($offresReductions) > 0)
                <div class="n1-offers-section">
                    <h2 class="n1-offers-title">Les offres qui valent le coup</h2>
                    <div class="n1-carousel-wrapper">
                        <button class="n1-carousel-arrow n1-arrow-left" onclick="n1CarouselScroll('n1-carousel-offers', -1)" aria-label="Précédent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <div class="n1-catalog-grid" id="n1-carousel-offers">
                            @foreach($offresReductions as $annonce)
                                @php
                                    $oldPrice = $annonce->produit->prix_moyen_marche ?? ($annonce->prix * 1.15);
                                    $discount = 0;
                                    if ($oldPrice > $annonce->prix) {
                                        $discount = round((($oldPrice - $annonce->prix) / $oldPrice) * 100);
                                    }
                                    $itemN2Id = ($annonce->category->parent && $annonce->category->parent->parent_id === null) ? $annonce->categorie_id : $annonce->category->parent_id;
                                @endphp
                                <a href="{{ route('annonces.show', $annonce->slug) }}" class="n1-promo-card global-filter-item" data-n2="{{ $itemN2Id }}">
                                    <div class="n1-card-media">
                                        @if($annonce->photoPrincipale())
                                            <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                                        @else
                                            <div class="no-photo">Pas de photo</div>
                                        @endif
                                    </div>
                                    <div class="n1-card-title">{{ \Illuminate\Support\Str::limit($annonce->titre, 55) }}</div>
                                    
                                    <div class="n1-card-footer">
                                        <div class="n1-footer-left">
                                            <div class="n1-price-label">Prix conseillé</div>
                                            <div class="n1-price-comparison">
                                                <span class="n1-old-price">{{ number_format($oldPrice, 0, ',', ' ') }} FCFA</span>
                                                <span class="n1-discount-badge">-{{ $discount }}%</span>
                                            </div>
                                            <div class="n1-actual-price" style="color: #f68b1e; text-shadow: none !important;">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <button class="n1-carousel-arrow n1-arrow-right" onclick="n1CarouselScroll('n1-carousel-offers', 1)" aria-label="Suivant">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                    
                    <div class="n1-section-footer">
                        <a href="#" class="btn-voir-plus-white">Voir plus d'offres</a>
                    </div>
                </div>
            @elseif($annonces->count() > 0)
                <div class="n1-offers-section">
                    <h2 class="sections-global-title">Nos produits phares de nos marchands pro</h2>
                    <div class="n1-top-consulted-carousel">
                        <button class="carousel-arrow-btn btn-left" onclick="n1CarouselScroll('n1-carousel-offers', -1)" aria-label="Précédent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <div class="n1-top-grid" id="n1-carousel-offers">
                            @foreach($annonces as $annonce)
                                @php
                                    $itemN2Id = ($annonce->category->parent && $annonce->category->parent->parent_id === null) ? $annonce->categorie_id : $annonce->category->parent_id;
                                @endphp
                                @include('partials.product-card-premium', [
                                    'annonce' => $annonce, 
                                    'class' => 'global-filter-item', 
                                    'attributes' => 'data-n2="' . $itemN2Id . '"'
                                ])
                            @endforeach
                        </div>
                        <button class="carousel-arrow-btn btn-right" onclick="n1CarouselScroll('n1-carousel-offers', 1)" aria-label="Suivant">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                </div>
            @endif

            @if($dealsMarchands->count() > 0)
                <div class="n1-offers-section" style="margin-top: 2rem; background: #fff; padding: 2rem 0; border-radius: 8px;">
                    <h2 class="n1-offers-title">Nos deals marchands du moment</h2>
                    <div class="n1-carousel-wrapper">
                        <button class="n1-carousel-arrow n1-arrow-left" onclick="n1CarouselScroll('n1-carousel-deals', -1)" aria-label="Précédent" style="background: rgba(255,255,255,0.9); color: #333; border: 1px solid #ddd;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                        </button>
                        <div class="n1-catalog-grid" id="n1-carousel-deals">
                            @foreach($dealsMarchands as $index => $annonce)
                                @php
                                    $itemN2Id = ($annonce->category->parent && $annonce->category->parent->parent_id === null) ? $annonce->categorie_id : $annonce->category->parent_id;
                                @endphp
                                <a href="{{ route('annonces.show', $annonce->slug) }}" class="n1-promo-card n1-deal-item global-filter-item {{ $index >= 18 ? 'deal-hidden' : '' }}" 
                                   data-n2="{{ $itemN2Id }}"
                                   style="{{ $index >= 18 ? 'display: none;' : '' }}">
                                    <div class="n1-card-media">
                                        @if($annonce->photoPrincipale())
                                            <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                                        @else
                                            <div class="no-photo">Pas de photo</div>
                                        @endif
                                    </div>
                                    <div class="n1-card-title">{{ \Illuminate\Support\Str::limit($annonce->titre, 55) }}</div>
                                    
                                    <div class="n1-merchant-deals-info">
                                        <div class="n1-v2-price-row">
                                            <span class="n1-v2-price" style="color: #f68b1e; text-shadow: none !important;">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
                                            @if($annonce->should_show_etat)
                                                <span class="n1-v2-state" style="color: {{ $annonce->etat_couleur }}; font-weight: 700;">{{ $annonce->etat_libelle }}</span>
                                            @endif
                                        </div>
                                        <div class="n1-v2-merchant-row">
                                            <span class="n1-v2-shop-name">Par {{ $annonce->vendeur->professionnel->nom_entreprise ?? 'Boutique' }}</span>
                                            <span class="n1-v2-badge-pro">PRO</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <button class="n1-carousel-arrow n1-arrow-right" onclick="n1CarouselScroll('n1-carousel-deals', 1)" aria-label="Suivant" style="background: rgba(255,255,255,0.9); color: #333; border: 1px solid #ddd;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                        </button>
                    </div>
                </div>
                @endif


                @if($selectionAnnonces->count() > 0)
                    <div class="n1-selection-section">
                        <div class="n1-selection-container">
                            <h2 class="sections-global-title">Notre sélection {{ $category->nom }}</h2>
                            
                            <div class="n1-filter-bar">
                                <div class="n1-filter-item">
                                    <select name="id_categorie_n2" onchange="updateN3Dropdown()">
                                        <option value="">Catégories</option>
                                        @foreach($category->enfantsActifs as $enfant)
                                            <option value="{{ $enfant->id }}" data-slug="{{ $enfant->slug }}">{{ $enfant->nom }}</option>
                                        @endforeach
                                    </select>
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                </div>
                                <div class="n1-filter-item">
                                    <select name="id_categorie_n3" id="n3-select" onchange="applyN1Filters()">
                                        <option value="">Sous-catégories</option>
                                    </select>
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                </div>
                                <div class="n1-filter-item">
                                    <select name="etat" onchange="applyN1Filters()">
                                        <option value="">État</option>
                                        <option value="neuf">Neuf</option>
                                        <option value="occasion">Occasion</option>
                                        <option value="reconditionne">Reconditionné</option>
                                    </select>
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                </div>
                                <div class="n1-filter-item">
                                    <select name="prix" onchange="applyN1Filters()">
                                        <option value="">Prix</option>
                                        <option value="0-50000">0 - 50 000 FCFA</option>
                                        <option value="50000-200000">50 000 - 200 000 FCFA</option>
                                        <option value="200000+">Plus de 200 000 FCFA</option>
                                    </select>
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                                </div>
                            </div>

                            <div class="n1-selection-grid" id="selection-grid">
                                @foreach($selectionAnnonces as $index => $annonce)
                                    @php
                                        $n2Id = null;
                                        $n3Id = null;
                                        $cat = $annonce->category;
                                        if ($cat) {
                                            if ($cat->parent_id == $category->id) {
                                                $n2Id = $cat->id;
                                            } elseif ($cat->parent && $cat->parent->parent_id == $category->id) {
                                                $n2Id = $cat->parent_id;
                                                $n3Id = $cat->id;
                                            }
                                        }
                                        $normEtat = 'neuf';
                                        $rawEtat = strtolower($annonce->produit->etat ?? 'neuf');
                                        if (strpos($rawEtat, 'occasion') !== false) $normEtat = 'occasion';
                                        elseif (strpos($rawEtat, 'reconditionne') !== false) $normEtat = 'reconditionne';
                                    @endphp
                                    <div class="n1-selection-item global-filter-item {{ $index >= 18 ? 'selection-hidden' : '' }}"
                                         data-n2="{{ $n2Id }}"
                                         data-n3="{{ $n3Id }}"
                                         data-etat="{{ $normEtat }}"
                                         data-price="{{ $annonce->prix }}"
                                         style="{{ $index >= 18 ? 'display: none;' : '' }}">
                                        @include('partials.product-card-premium', ['annonce' => $annonce])
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>

                @endif
            @else
                <!-- Grille Classique pour N2 / N3 -->
                <div class="catalog-grid">
                    @forelse($annonces as $annonce)
                        <div class="catalog-item">
                            <a href="{{ route('annonces.show', $annonce->slug) }}" class="catalog-card">
                                <div class="card-media">
                                    @if($annonce->photoPrincipale())
                                        <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                                    @else
                                        <div class="no-photo">Pas de photo</div>
                                    @endif
                                    @if($annonce->estALaUne()) <span class="badge-sponsored">Sponsorisée</span> @endif
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title">{{ $annonce->titre }}</h3>
                                    
                                    <div class="card-rating">
                                        @php
                                            $rating = $annonce->note_moyenne;
                                            $fullStars = floor($rating);
                                            $halfStar = ($rating - $fullStars) >= 0.5;
                                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                        @endphp
                                        <div class="stars">
                                            @for($i = 0; $i < $fullStars; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            @if($halfStar)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                            @for($i = 0; $i < $emptyStars; $i++)
                                                <i class="far fa-star"></i>
                                            @endfor
                                        </div>
                                        <span class="reviews-count">{{ $annonce->nombre_avis ?? 0 }} avis</span>
                                    </div>

                                    <div class="card-price-state">
                                        <span class="price-val" style="font-weight: 800;">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
                                        @if($annonce->should_show_etat)
                                            <span class="state-sep">·</span>
                                            <span class="state-label" style="color: {{ $annonce->etat_couleur }}; font-weight: 700;">
                                                {{ $annonce->etat_libelle }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($annonce->vendeur && $annonce->vendeur->type === 'professionnel')
                                    <div class="seller-info-line">
                                        <span class="seller-prefix">Par</span>
                                        <span class="seller-name-text">
                                            {{ $annonce->vendeur->professionnel->nom_entreprise ?? 'Boutique' }}
                                            <span class="pro-tag">PRO</span>
                                        </span>
                                    </div>
                                    @endif

                                    <div class="card-actions">
                                        <span class="btn-see-product">{{ $annonce->label_voir_bouton }} <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="empty-state">
                            <p>Aucun produit trouvé dans cette catégorie.</p>
                            <a href="{{ route('home') }}" class="btn-back">Retour à l'accueil</a>
                        </div>
                    @endforelse
                </div>
            @endif

            @if($category->parent_id !== null)
                <div class="pagination-wrapper">
                    {{ $annonces->links() }}
                </div>
            @endif
        </main>
    </div>
</div>

<style>
    /* N1 Promo Cards Styling */
    .n1-offers-section {
        padding: 0.5rem 0 3rem;
        margin: 0 auto;
        max-width: 1300px; /* Limit width to show only ~5-6 cards */
        overflow: hidden;
    }
    .n1-offers-title {
        text-align: center;
        font-size: 1.4rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 1.5rem;
        letter-spacing: -0.01em;
    }
    .n1-carousel-wrapper {
        position: relative;
        padding: 0 40px; /* Leave space for arrows on the sides */
    }
    .n1-catalog-grid {
        display: flex;
        flex-direction: row;
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: smooth;
        gap: 1.25rem;
        padding: 0.5rem 0.25rem;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* IE 10+ */
    }
    .n1-catalog-grid::-webkit-scrollbar { 
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }
    /* Arrow buttons — float on the edges like the reference */
    .n1-carousel-arrow {
        position: absolute;
        top: 40%;
        transform: translateY(-50%);
        z-index: 20;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 1px 6px rgba(0,0,0,0.18);
        color: #444;
        transition: box-shadow 0.2s, color 0.2s;
    }
    .n1-carousel-arrow:hover {
        box-shadow: 0 3px 12px rgba(0,0,0,0.22);
        color: #111;
    }
    .n1-arrow-left  { left: 8px; }
    .n1-arrow-right { right: 8px; }
    .n1-promo-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
        min-width: 220px;
        max-width: 220px;
        flex-shrink: 0;
    }
    .n1-promo-card:hover {
        border-color: #eee;
    }
    .n1-card-media {
        height: 180px;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
    }
    .n1-card-media img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
    }
    .n1-card-title {
        height: 38px;
        font-size: 13px;
        line-height: 1.4;
        color: #333;
        margin-top: 10px;
        margin-bottom: 8px; /* Reduced margin to fit extra info */
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        padding: 0 10px;
    }
    .n1-card-merchant-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 12px;
        font-size: 0.75rem;
        padding: 0 10px;
    }
    .n1-merchant-deals-info {
        padding: 0 10px 15px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .n1-v2-price-row {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #000;
        font-weight: 800; /* Plus gras */
        font-size: 16px;
    }
    .n1-v2-merchant-row {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #777;
        font-size: 13px;
    }
    .n1-v2-shop-name {
        max-width: 130px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .n1-v2-badge-pro {
        background: #f4f4f4;
        color: #555;
        padding: 1px 6px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        line-height: normal;
    }
    .n1-card-state {
        color: #666;
        padding-right: 0.5rem;
        border-right: 1px solid #ddd;
    }
    .n1-card-shop-name {
        color: #444;
        font-weight: 600;
        max-width: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .n1-badge-pro {
        background: #f5f5f5;
        color: #777;
        padding: 0px 5px;
        border-radius: 3px;
        font-size: 0.65rem;
        font-weight: 800;
        text-transform: uppercase;
        border: 1px solid #e0e0e0;
    }
    .n1-card-footer {
        margin-top: auto;
        padding: 10px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }
    .n1-footer-left {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .n1-price-label {
        font-size: 11px;
        color: #888;
    }
    .n1-price-comparison {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .n1-old-price {
        font-size: 12px;
        color: #888;
        text-decoration: line-through;
    }
    .n1-discount-badge {
        background: #ee8800;
        color: white;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 5px;
        border-radius: 4px;
        letter-spacing: 0.3px;
    }
    .n1-actual-price {
        font-size: 18px;
        font-weight: 800;
        color: #bf0000;
        margin-top: 4px;
    }

    /* Notre Sélection Styling (Professional Cool Gray) */
    .n1-selection-section {
        background: #f9f9f9;
        padding: 5rem 0;
        margin-top: 2rem;
        position: relative;
    }
    .n1-selection-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 1rem 1rem;
        background: transparent;
    }
    .n1-filter-bar {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin-bottom: 3rem;
        flex-wrap: wrap;
        width: 100%;
    }
    .n1-filter-item {
        position: relative;
        background: #fff;
        padding: 0;
        border-radius: 4px;
        display: flex;
        align-items: center;
        flex: 1;
        min-width: 260px;
        max-width: 320px;
        cursor: pointer;
        box-shadow: none;
        overflow: hidden;
    }
    .n1-filter-item select {
        width: 100%;
        padding: 0.75rem 1.25rem;
        border: none;
        background: transparent;
        color: #444;
        font-size: 0.9rem;
        font-weight: 500;
        font-family: inherit;
        appearance: none;
        outline: none;
        cursor: pointer;
        z-index: 1;
    }
    .n1-filter-item svg {
        position: absolute;
        right: 1.25rem;
        pointer-events: none;
        z-index: 2;
        color: #888;
    }
    .n1-selection-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 3rem;
        max-width: 920px;
        margin-left: auto;
        margin-right: auto;
    }
    .n1-selection-item {
        width: 220px;
        flex-shrink: 0;
    }
    .n1-selection-item.selection-hidden {
        display: none;
    }
    .n1-selection-footer {
        display: flex;
        justify-content: center;
    }
    .btn-voir-plus {
        background: transparent;
        color: #ff8c00;
        border: 2px solid #ff8c00;
        padding: 0.8rem 3rem;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: none;
        letter-spacing: 0.5px;
    }
    .btn-voir-plus:hover {
        background: #ff8c00;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
    }

    .n1-section-footer {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
        width: 100%;
    }
    .btn-voir-plus-white {
        background: transparent;
        color: #ff8c00;
        border: 2px solid #ff8c00;
        padding: 0.7rem 2.5rem;
        border-radius: 30px;
        font-weight: 700;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .btn-voir-plus-white:hover {
        background: #ff8c00;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 140, 0, 0.3);
    }

    /* Responsive Grid */
    @media (max-width: 1100px) {
        .n1-selection-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 800px) {
        .n1-selection-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 500px) {
        .n1-selection-grid { grid-template-columns: 1fr; }
    }
    .n1-footer-right {
        padding-bottom: 2px;
    }
    .n1-branding {
        font-size: 16px;
        font-weight: 700;
        color: #000;
        letter-spacing: -0.5px;
    }
    .n1-brand-accent {
        color: #bf0000;
    }

    .catalog-page-container {
        background-color: #fff;
        min-height: 100vh;
        padding: 0;
    }

    .catalog-layout {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 0;
    }

    .catalog-layout.no-sidebar {
        grid-template-columns: 1fr;
    }

    .catalog-main-column {
        padding: 0;
        margin: 0;
    }

    .catalog-breadcrumbs {
        display: flex;
        align-items: center;
        font-size: 0.75rem;
        color: #666;
        padding: 0.75rem 1rem 0.25rem 1rem;
        margin: 0;
        gap: 0.25rem;
    }

    .catalog-breadcrumbs a {
        color: inherit;
        text-decoration: none;
    }

    .catalog-breadcrumbs a:hover {
        text-decoration: underline;
    }

    .catalog-header {
        padding: 0.25rem 1rem 1.25rem 1rem;
        margin-bottom: 1.25rem;
        border-bottom: 1px solid #ebebeb;
    }

    .header-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #000;
        letter-spacing: -0.01em;
    }

    .header-description {
        font-size: 1rem;
        color: #666;
        line-height: 1.6;
    }

    .header-icon {
        font-size: 3rem;
        opacity: 0.1;
    }


    .results-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0;
        padding: 0.4rem 1rem 1.25rem 1rem;
        border-bottom: 1px solid #ebebeb;
    }

    .results-count {
        font-size: 0.75rem;
        font-weight: 400;
        color: #666;
        margin: 0;
    }

    .sort-options {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .sort-options label {
        font-size: 0.85rem;
        font-weight: 600;
        color: #666;
    }

    .sort-options select {
        padding: 0.5rem 1rem;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 0.875rem;
        outline: none;
    }

    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 0;
        padding: 0;
    }

    .catalog-item {
        background: #fff;
        border-right: 1px solid #ebebeb;
        border-bottom: 1px solid #ebebeb;
        display: flex;
        flex-direction: column;
        padding-bottom: 1rem;
    }

    /* Pattern: 3 items (span 4) then 4 items (span 3) */
    /* Total cycle of 7 items (3 + 4) */
    
    /* Items 1, 2, 3 of each cycle of 7 */
    .catalog-item:nth-child(7n+1),
    .catalog-item:nth-child(7n+2),
    .catalog-item:nth-child(7n+3) {
        grid-column: span 4;
    }

    /* Items 4, 5, 6, 7 of each cycle of 7 */
    .catalog-item:nth-child(7n+4),
    .catalog-item:nth-child(7n+5),
    .catalog-item:nth-child(7n+6),
    .catalog-item:nth-child(7n+7) {
        grid-column: span 3;
    }

    /* Remove right border for items at the end of their rows */
    .catalog-item:nth-child(7n+3), /* End of 3-item row */
    .catalog-item:nth-child(7n+7)  /* End of 4-item row */ {
        border-right: none;
    }

    .catalog-card {
        background: #fff;
        border-right: 1px solid #ebebeb;
        border-bottom: 1px solid #ebebeb;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        color: inherit;
        height: 100%;
    }

    .catalog-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: #ddd;
    }

    .card-media {
        aspect-ratio: 1;
        background: #fcfcfc;
        position: relative;
    }

    .card-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-photo {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #ccc;
        font-size: 0.8rem;
    }

    .badge-sponsored {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        background: #fff;
        color: #111;
        font-size: 0.6rem;
        font-weight: 800;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        text-transform: uppercase;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: 1px solid #eee;
        z-index: 10;
    }

    .card-content {
        padding: 0.75rem 0.75rem 1rem 0.75rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }
    
    .card-title {
        font-size: 0.85rem;
        font-weight: 700;
        line-height: 1.25;
        height: 2.1rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        margin-bottom: 0.25rem;
        color: #333;
    }

    .card-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
    }

    .card-rating .stars {
        display: flex;
        gap: 1px;
        color: #ffbc00;
        font-size: 0.8rem;
    }

    .card-rating .reviews-count {
        font-size: 0.75rem;
        color: #777;
    }

    .card-price-state {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin: 0.25rem 0;
    }

    .price-val {
        font-size: 1.15rem;
        font-weight: 800;
        color: #000;
    }

    .state-sep {
        font-weight: bold;
        color: #000;
    }

    .state-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: #db0001;
    }

    .seller-info-line {
        font-size: 0.75rem;
        color: #777;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .seller-name-text {
        font-weight: 600;
        color: #333;
    }

    .pro-tag {
        background: #fff;
        color: #666;
        font-size: 7px;
        font-weight: 700;
        padding: 1px 5px;
        border-radius: 10px;
        margin-left: 2px;
        border: 1px solid #ddd;
        text-transform: uppercase;
        vertical-align: middle;
    }

    .card-actions {
        margin-top: auto;
    }

    .btn-see-product {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 0.6rem;
        border: 1.5px solid #111;
        border-radius: 8px;
        background: #fff;
        color: #111;
        font-size: 0.9rem;
        font-weight: 800;
        transition: all 0.2s;
    }

    .catalog-card:hover .btn-see-product {
        background: #111;
        color: #fff;
    }

    .item-button {
        margin-top: 0.4rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: 1px solid #000;
        border-radius: 4px;
        padding: 0.4rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: #000;
        transition: background-color 0.2s;
    }

    .item-button:hover {
        background-color: #f5f5f5;
    }

    .item-footer {
        padding: 0 1.25rem;
        text-align: center;
    }

    .sell-link {
        font-size: 0.75rem;
        color: #333;
        text-decoration: underline;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .sell-link svg {
        opacity: 0.7;
    }

    .pagination-wrapper {
        margin-top: 4rem;
        display: flex;
        justify-content: center;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 5rem 2rem;
        background: #fff;
        border-radius: 4px;
        border: 1px solid #eee;
    }

    .empty-state p {
        color: #666;
        margin-bottom: 2rem;
    }

    .btn-back {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background: #000;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        font-weight: 600;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .catalog-layout {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .catalog-sidebar-column {
            display: none; /* Hide sidebar on small screens for now or use a drawer */
        }
    }

    /* Annonces : la mosaïque 12 colonnes devient une grille propre sur mobile */
    @media (max-width: 768px) {
        .catalog-grid {
            grid-template-columns: repeat(2, 1fr) !important;
        }
        /* Annule le pattern mosaïque (span 4 / span 3 via nth-child(7n+...)) */
        .catalog-grid .catalog-item {
            grid-column: span 1 !important;
        }
        /* Bordures cohérentes pour 2 colonnes */
        .catalog-grid .catalog-item:nth-child(odd) {
            border-right: 1px solid #ebebeb;
        }
        .catalog-grid .catalog-item:nth-child(even) {
            border-right: none;
        }
        .card-title {
            font-size: 0.85rem;
        }
        .card-price-state .price-val {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 380px) {
        /* Très petits écrans : une seule colonne pour rester lisible */
        .catalog-grid {
            grid-template-columns: 1fr !important;
        }
        .catalog-grid .catalog-item {
            border-right: none;
        }
    }
</style>

<script>
function n1CarouselScroll(id, direction) {
    const carousel = document.getElementById(id);
    if (!carousel) return;
    const cardWidth = carousel.querySelector('.n1-promo-card')?.offsetWidth + 16 || 226;
    carousel.scrollBy({ left: direction * cardWidth * 3, behavior: 'smooth' });
}

const n2ToN3Map = {
    @foreach($category->enfantsActifs as $n2)
        "{{ $n2->id }}": [
            @foreach($n2->enfantsActifs as $n3)
                { "id": "{{ $n3->id }}", "nom": {!! json_encode($n3->nom) !!} },
            @endforeach
        ],
    @endforeach
};

function updateN3Dropdown() {
    const n2Select = document.querySelector('select[name="id_categorie_n2"]');
    const n3Select = document.getElementById('n3-select');
    const selectedN2 = n2Select.value;
    
    n3Select.innerHTML = '<option value="">Sous-catégories</option>';
    
    if (selectedN2 && n2ToN3Map[selectedN2]) {
        n2ToN3Map[selectedN2].forEach(n3 => {
            const opt = document.createElement('option');
            opt.value = n3.id;
            opt.textContent = n3.nom;
            n3Select.appendChild(opt);
        });
    }
    applyN1Filters();
}

function applyN1Filters() {
    const n2Val = document.querySelector('select[name="id_categorie_n2"]').value;
    const n3Val = document.getElementById('n3-select').value;
    const etatVal = document.querySelector('select[name="etat"]').value;
    const prixVal = document.querySelector('select[name="prix"]').value;
    
    const items = document.querySelectorAll('.n1-selection-item');
    
    let selectionMatchCount = 0;
    
    items.forEach((item, index) => {
        let match = true;
        if (n2Val && item.dataset.n2 !== n2Val) match = false;
        if (n3Val && item.dataset.n3 !== n3Val) match = false;
        if (etatVal && item.dataset.etat !== etatVal) match = false;
        
        if (prixVal) {
            const price = parseInt(item.dataset.price);
            if (prixVal === '0-50000' && (price < 0 || price > 50000)) match = false;
            else if (prixVal === '50000-200000' && (price < 50000 || price > 200000)) match = false;
            else if (prixVal === '200000+' && price < 200000) match = false;
        }
        
        if (match) {
            selectionMatchCount++;
            if (selectionMatchCount > 18) {
                item.style.display = 'none';
                item.classList.add('selection-hidden');
            } else {
                item.style.display = 'block';
                item.classList.remove('selection-hidden');
            }
        } else {
            item.style.display = 'none';
            item.classList.remove('selection-hidden'); // remove to avoid expanding non-matching items
        }
    });

    const btn = document.querySelector('.n1-selection-footer .btn-voir-plus');
    if (btn) {
        btn.style.display = (selectionMatchCount > 18) ? 'inline-block' : 'none';
    }
}
function toggleSelectionGrid() {
    const hiddenItems = document.querySelectorAll('.n1-selection-item.selection-hidden');
    hiddenItems.forEach(item => {
        item.classList.remove('selection-hidden');
        item.style.display = 'block';
    });
    const btn = document.querySelector('.btn-voir-plus');
    if (btn) btn.style.display = 'none';
}


function toggleDealsGrid() {
    const hiddenItems = document.querySelectorAll('.n1-deal-item.deal-hidden');
    hiddenItems.forEach(item => {
        item.classList.remove('deal-hidden');
        item.style.display = 'block';
    });
    const btn = document.querySelector('button[onclick="toggleDealsGrid()"]');
    if (btn) btn.style.display = 'none';
}
function redirectVoirPlus(parentSlug) {
    let activeN2Link = document.querySelector('.n1-cat-nav-link.active');
    
    // Check if dropdown changed
    let n2Select = document.querySelector('select[name="id_categorie_n2"]');
    if (n2Select && n2Select.value) {
        let option = n2Select.options[n2Select.selectedIndex];
        if (option && option.dataset.slug) {
            window.location.href = '/categories/' + option.dataset.slug;
            return;
        }
    }

    if (activeN2Link) {
        const slug = activeN2Link.dataset.slug;
        if (slug) {
            window.location.href = '/categories/' + slug;
            return;
        }
    }
    
    window.location.href = '/categories/' + parentSlug + '?view=list';
}

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const activeId = urlParams.get('active');
    if (activeId) {
        const link = document.querySelector(`.n1-cat-nav-link[data-n2-id="${activeId}"]`);
        if (link) {
            link.click(); // This sets N2 and triggers global filter

            // If N3 is also specified, apply it shortly after N3 dropdown populates
            const n3Id = urlParams.get('n3');
            if (n3Id) {
                setTimeout(() => {
                    const n3Select = document.getElementById('n3-select');
                    if (n3Select) {
                        n3Select.value = n3Id;
                        applyN1Filters();
                    }
                }, 50);
            }
        }
    }
});

function filterWholePage(n2Id, element) {
    // 1. Update Menu Styling
    document.querySelectorAll('.n1-cat-nav-link, .n1-nav-home-btn').forEach(el => {
        el.classList.remove('active');
    });
    element.classList.add('active');

    // 2. Filter all "global-filter-item" across all sections
    const items = document.querySelectorAll('.global-filter-item');
    let selCount = 0;
    let dealCount = 0;
    
    items.forEach(item => {
        const isSelection = item.classList.contains('n1-selection-item');
        const isDeal = item.classList.contains('n1-deal-item');

        if (n2Id === 'all') {
            const index = Array.from(item.parentNode.children).indexOf(item);
            
            if (isSelection && index >= 18) {
                item.style.display = 'none';
                item.classList.add('selection-hidden');
            } else if (isDeal && index >= 18) {
                item.style.display = 'none';
                item.classList.add('deal-hidden');
            } else {
                item.style.display = 'block';
                if (isSelection) item.classList.remove('selection-hidden');
                if (isDeal) item.classList.remove('deal-hidden');
            }
        } else {
            if (item.dataset.n2 === n2Id) {
                if (isSelection) {
                    selCount++;
                    if (selCount > 18) {
                        item.style.display = 'none';
                        item.classList.add('selection-hidden');
                    } else {
                        item.style.display = 'block';
                        item.classList.remove('selection-hidden');
                    }
                } else if (isDeal) {
                    dealCount++;
                    if (dealCount > 18) {
                        item.style.display = 'none';
                        item.classList.add('deal-hidden');
                    } else {
                        item.style.display = 'block';
                        item.classList.remove('deal-hidden');
                    }
                } else {
                    item.style.display = 'block';
                }
            } else {
                item.style.display = 'none';
                if (isSelection) item.classList.remove('selection-hidden');
                if (isDeal) item.classList.remove('deal-hidden');
            }
        }
    });

    // 3. Update "Voir plus" buttons visibility
    const selectionBtn = document.querySelector('.n1-selection-section .btn-voir-plus');
    if (selectionBtn) {
        if (n2Id === 'all') {
            const totalSel = document.querySelectorAll('.n1-selection-item').length;
            selectionBtn.style.display = (totalSel > 18) ? 'inline-block' : 'none';
        } else {
            selectionBtn.style.display = (selCount > 18) ? 'inline-block' : 'none';
        }
    }
    
    const dealsBtn = document.querySelector('.n1-offers-section .btn-voir-plus');
    if (dealsBtn) {
        if (n2Id === 'all') {
            const totalDeals = document.querySelectorAll('.n1-deal-item').length;
            dealsBtn.style.display = (totalDeals > 18) ? 'inline-block' : 'none';
        } else {
            dealsBtn.style.display = (dealCount > 18) ? 'inline-block' : 'none';
        }
    }

    // 4. Update N2 dropdown in filter bar if it exists
    const n2Select = document.querySelector('select[name="id_categorie_n2"]');
    if (n2Select) {
        n2Select.value = (n2Id === 'all') ? '' : n2Id;
        if (typeof updateN3Dropdown === 'function') updateN3Dropdown();
    }
}

function handleInPageSearch(query) {
    const q = query.toLowerCase().trim();
    const items = document.querySelectorAll('.global-filter-item');
    
    // Clear N2 active state when searching if needed, or keep it as combined filter
    // For simplicity and matching user "recherches sur la page", search in ALL items
    
    items.forEach(item => {
        const title = item.querySelector('.card-title-flat').innerText.toLowerCase();
        if (title.includes(q)) {
            // Respect the N2 filter if any? 
            // Better: reset N2 filter to "all" to allow global search on page
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });

    // Reset N2 nav active state if query is not empty
    if (q.length > 0) {
        document.querySelectorAll('.n1-cat-nav-link').forEach(l => l.classList.remove('active'));
        const homeBtn = document.querySelector('.n1-nav-home-btn');
        if (homeBtn) homeBtn.classList.remove('active');
    } else {
        // If query cleared, reset to "All"
        const homeBtn = document.querySelector('.n1-nav-home-btn');
        if (homeBtn) {
            homeBtn.click();
            homeBtn.classList.add('active');
        }
    }
}
</script>

@endsection


