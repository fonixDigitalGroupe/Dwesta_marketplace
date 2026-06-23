@extends('layouts.app')

@section('title', 'Recherche - Karnou')

@push('styles')
<style>
    :root {
        --primary-color: #004aad;
        --p-orange: #f0c14b;
        --p-orange-hover: #f5d78e;
        --p-blue: #007185;
        --p-blue-hover: #c8f3fa;
        --bg-gray: #f3f3f3;
        --border-main: #D5D9D9;
        --text-dark: #111;
        --text-muted: #565959;
    }

    /* Hide number input spinners */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }

    .catalog-page-container {
        max-width: 1500px;
        margin: 0 auto;
        background: #fff;
    }

    .shop-layout {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 0;
        border-top: 1px solid #f5f5f5;
        border-bottom: 1px solid #f5f5f5;
    }

    /* Sidebar area */
    .sidebar-column {
        border-right: 1px solid #eeeeee;
        padding: 0 15px 20px 15px;
        background: #fff;
    }

    .sidebar-section {
        margin-bottom: 5px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eeeeee;
    }

    .sidebar-header {
        background: #f7f7f7;
        padding: 6px 15px;
        font-size: 0.75rem;
        font-weight: 800;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #eeeeee;
        border-top: 1px solid #eeeeee;
        margin: 0 -15px 15px -15px;
    }

    .sidebar-subtitle {
        display: block;
        font-weight: 800;
        font-size: 0.75rem;
        color: #000;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sidebar-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-list li {
        margin-bottom: 8px;
    }

    .sidebar-list li a {
        color: #444;
        text-decoration: none;
        font-size: 0.88rem;
        transition: color 0.2s;
    }

    .sidebar-list li a:hover {
        color: var(--primary-color);
        text-decoration: underline;
    }

    .sidebar-list li a.active {
        color: #000 !important;
        font-weight: 800;
    }

    .filter-item {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
        font-size: 0.88rem;
        color: #444;
        cursor: pointer;
    }

    .filter-item input {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: var(--primary-color);
    }

    /* Price inputs stylisés */
    .price-filter-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 5px;
        padding-bottom: 15px;
    }

    .price-input-container {
        position: relative;
        flex: 1;
    }

    .price-input-container input {
        width: 100%;
        padding: 8px 25px 8px 10px;
        border: 1px solid #f5f5f5;
        border-radius: 4px;
        font-size: 0.85rem;
        color: #333;
        background: #f9f9f9;
    }

    .price-input-container .currency-symbol {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
        font-size: 0.8rem;
    }

    .btn-ok {
        background: #004aad; /* Bleu Header */
        color: #fff;
        border: none;
        padding: 5px 12px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.85rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-ok:hover {
        background: #003a8a;
    }

    .filter-count {
        margin-left: auto;
        color: #999;
        font-size: 0.75rem;
        font-weight: 400;
    }

    /* Main Area */
    .results-main {
        padding: 0;
    }

    .results-header {
        padding: 15px 25px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
    }

    .results-count {
        font-size: 1.1rem;
        color: #666;
    }

    .results-count strong {
        color: #000;
        font-weight: 700;
    }

    .sort-select {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 4px 30px 4px 12px;
        color: #333;
        font-size: 0.85rem;
        outline: none;
        appearance: none;
        background: #ffffff url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMiIgaGVpZ2h0PSIxMiIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM5OTkiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cG9seWxpbmUgcG9pbnRzPSI2IDkgMTIgMTUgMTggOSI+PC9wb2x5bGluZT48L3N2Zz4=') no-repeat right 10px center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .sort-select:hover {
        background-color: #e8e8e8;
        border-color: #ccc;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        background: #fff;
        border-top: 1px solid #eeeeee;
    }

    .product-card {
        padding: 20px;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        border-right: 1px solid #f5f5f5;
        border-bottom: 1px solid #f5f5f5;
        transition: background 0.2s;
        min-height: 480px;
        background: #fff;
    }

    .product-card:hover {
        background: #fcfcfc;
    }

    .product-image-container {
        height: 220px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .product-info {
        display: flex;
        flex-direction: column;
        gap: 3px;
        flex-grow: 1;
    }

    .product-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #333;
        line-height: 1.3;
        height: 2.6rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .review-stars {
        color: #f5a623;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 3px;
        margin: 2px 0;
    }

    .review-count {
        color: var(--p-blue);
        font-size: 0.8rem;
        margin-left: 5px;
    }

    .product-price-row {
        margin: 5px 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .product-price-value {
        font-size: 1.25rem;
        color: #ff9900;
        font-weight: 800; /* Prix en gras */
    }

    .product-view-btn {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 15px;
        border: 1px solid #333;
        color: #000;
        font-weight: 700;
        font-size: 0.85rem;
        border-radius: 4px;
        transition: background 0.2s;
        text-decoration: none;
        background: #fff;
    }

    .sell-yours {
        display: block;
        margin-top: 10px;
        font-size: 0.75rem;
        color: #333;
        text-decoration: underline;
        text-align: left;
    }

    .product-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 5px;
    }

    .tag-pro {
        background: #fff;
        color: #666;
        font-size: 9px;
        font-weight: 800;
        padding: 2px 6px;
        border: 1px solid #ddd;
        border-radius: 10px;
        text-transform: uppercase;
    }

    .tag-sponsored {
        font-size: 0.8rem;
        color: var(--text-muted);
        font-weight: 500;
    }

    .empty-state {
        grid-column: span 4;
        padding: 100px 20px;
        text-align: center;
        color: #666;
    }

    .pagination-container {
        padding: 40px;
        display: flex;
        justify-content: center;
        border-top: 1px solid #eee;
    }

    .btn-pagination {
        padding: 10px 30px;
        background: #fff;
        border: 1px solid #ddd;
        color: #333;
        text-decoration: none;
        border-radius: 4px;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.2s;
    }

    .btn-pagination:hover {
        background: #f7f7f7;
    }

    .btn-pagination.next {
        background: var(--primary-color);
        color: #fff;
        border: none;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .btn-pagination.next:hover {
        opacity: 0.9;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .products-grid { grid-template-columns: repeat(3, 1fr); }
    }
    @media (max-width: 900px) {
        .shop-layout { grid-template-columns: 1fr; }
        .sidebar-column { display: none; }
        .products-grid { grid-template-columns: 1fr !important; }
        
        .results-header {
            display: none !important;
        }

        .product-card {
            flex-direction: row !important;
            flex-wrap: wrap !important;
            padding: 12px !important;
            min-height: auto !important;
            gap: 12px !important;
            align-items: flex-start !important;
            border-right: none;
            border-bottom: 1px solid #f0f0f0;
            display: flex !important;
        }

        .product-image-container {
            width: 90px !important;
            height: 90px !important;
            flex-shrink: 0 !important;
            margin-bottom: 0 !important;
        }

        .product-info {
            flex: 1 !important;
            gap: 2px !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden;
        }

        .product-title {
            font-size: 0.9rem !important;
            line-height: 1.2 !important;
            margin-bottom: 2px !important;
            font-weight: 700 !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .product-price-value {
            font-size: 1.15rem !important;
            color: #ff9900 !important;
            font-weight: 700 !important;
        }

        .product-status {
            font-size: 0.75rem !important;
            color: #ff9900 !important;
            font-weight: 600;
        }

        .product-view-btn {
            display: flex !important;
            width: 100% !important;
            margin-top: 10px !important;
            justify-content: center !important;
            padding: 10px !important;
            border: 1px solid #ddd !important;
            border-radius: 6px !important;
            background: #fff !important;
            font-weight: 600 !important;
        }

        /* Sticky Bottom Navigation */
        .mobile-bottom-nav {
            display: flex !important;
            position: fixed !important;
            bottom: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 55px !important;
            background: #444 !important; /* Matches Pro Shop pages */
            z-index: 10000 !important;
            box-shadow: 0 -2px 15px rgba(0,0,0,0.3) !important;
        }

        .bottom-nav-item {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff !important;
            font-size: 1rem !important;
            font-weight: 700 !important;
            cursor: pointer;
        }

        .bottom-nav-item i {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        /* Drawer for Mobile Sidebar */
        .sidebar-column.mobile-active {
            display: block !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: white !important;
            z-index: 11000 !important;
            overflow-y: auto !important;
            padding: 70px 20px 20px 20px !important;
        }

        .close-filters-btn {
            display: block !important;
            position: fixed !important;
            top: 20px !important;
            right: 20px !important;
            z-index: 11001 !important;
            font-size: 1.8rem !important;
            color: #333 !important;
            cursor: pointer;
        }
        
        .catalog-page-container {
            padding-bottom: 60px;
        }
    }

    .mobile-bottom-nav, .close-filters-btn {
        display: none;
    }
</style>
@endpush

@section('content')
<!-- Mobile Bottom Navigation -->
<div class="mobile-bottom-nav">
    <div class="bottom-nav-item" onclick="toggleFilters(true)">
        <i class="fas fa-sliders-h"></i> Filtrer et catégories
    </div>
</div>

<div class="catalog-page-container">
    <div class="shop-layout">
        <!-- Sidebar Drawer -->
        <aside class="sidebar-column" id="mobileSidebar">
            <div class="close-filters-btn" onclick="toggleFilters(false)">
                <i class="fas fa-times"></i>
            </div>
            <!-- Categories -->
            <div class="sidebar-section" style="padding-bottom: 0; border-bottom: none; margin-bottom: 0;">
                <div class="sidebar-header">Catégories</div>
                <ul class="sidebar-list">
                    @if(!$sidebarParent)
                        <li><a href="{{ route('search.index', ['q' => request('q')]) }}" class="{{ !request('category') ? 'active' : '' }}">Toutes catégories</a></li>
                    @else
                        <li style="margin-bottom: 15px;">
                            <a href="{{ request()->fullUrlWithQuery(['category' => $sidebarParent->slug]) }}" style="font-weight: 800; color: #000; display: flex; align-items: center; gap: 5px; text-decoration: none;">
                                <i class="fas fa-chevron-left" style="font-size: 0.7rem; color: #999;"></i> {{ $sidebarParent->nom }}
                            </a>
                        </li>
                    @endif

                    @foreach($sidebarCategories as $cat)
                        <li style="{{ $sidebarParent ? 'margin-left: 15px;' : '' }}">
                            <a href="{{ request()->fullUrlWithQuery(['category' => $cat->slug]) }}" 
                               class="{{ ($category && $category->slug == $cat->slug) || (!$category && $activeCategory && $activeCategory->id == $cat->id) ? 'active' : '' }}"
                               style="{{ ($category && $category->slug == $cat->slug) || (!$category && $activeCategory && $activeCategory->id == $cat->id) ? 'font-weight: 800; color: #000;' : '' }} display: flex; justify-content: space-between; align-items: center;">
                                <span>{{ $cat->nom }}</span>
                                <span class="filter-count">+ {{ number_format($cat->real_count, 0, ',', ' ') }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Filtres -->
            <form action="{{ request()->url() }}" method="GET" id="filter-form">
                @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                

                
                <!-- Filtres -->
                <div class="sidebar-header" style="margin-bottom: 5px;">Filtres</div>

                @php
                    $hideEtat = ($activeCategory && ($activeCategory->famille === 'Services' || $activeCategory->famille === 'Immobilier'));
                @endphp

                <!-- Etat -->
                @if(!$hideEtat)
                <div class="sidebar-section">
                    <div class="sidebar-subtitle">État</div>
                    <label class="filter-item">
                        <input type="checkbox" name="etat[]" value="neuf" @if(is_array(request('etat')) && in_array('neuf', request('etat'))) checked @endif onchange="this.form.submit()">
                        Neuf <span class="filter-count">+ {{ number_format($countsEtats['neuf'] ?? 0, 0, ',', ' ') }}</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" name="etat[]" value="reconditionne" @if(is_array(request('etat')) && in_array('reconditionne', request('etat'))) checked @endif onchange="this.form.submit()">
                        Reconditionné <span class="filter-count">+ {{ number_format($countsEtats['reconditionne'] ?? 0, 0, ',', ' ') }}</span>
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" name="etat[]" value="occasion" @if(is_array(request('etat')) && in_array('occasion', request('etat'))) checked @endif onchange="this.form.submit()">
                        Occasion <span class="filter-count">+ {{ number_format($countsEtats['occasion'] ?? 0, 0, ',', ' ') }}</span>
                    </label>
                </div>
                @endif

                <!-- Prix -->
                <div class="sidebar-section">
                    <div class="sidebar-subtitle">Prix (FCFA)</div>
                    <div class="price-filter-row">
                        <div class="price-input-container">
                            <input type="number" name="min_prix" placeholder="Min" value="{{ request('min_prix') }}">
                            <span class="currency-symbol">CFA</span>
                        </div>
                        <span style="color: #999;">-</span>
                        <div class="price-input-container">
                            <input type="number" name="max_prix" placeholder="Max" value="{{ request('max_prix') }}">
                            <span class="currency-symbol">CFA</span>
                        </div>
                        <button type="submit" class="btn-ok">Ok</button>
                    </div>
                </div>

                <!-- Expédition -->
                @if(!$hideEtat)
                <div class="sidebar-section">
                    <div class="sidebar-subtitle">Option d'expédition</div>
                    <label class="filter-item">
                        <input type="checkbox" name="shipping[]" value="retrait_point_relais" @if(is_array(request('shipping')) && in_array('retrait_point_relais', request('shipping'))) checked @endif onchange="this.form.submit()">
                        Retrait en point retrait
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" name="shipping[]" value="retrait_boutique" @if(is_array(request('shipping')) && in_array('retrait_boutique', request('shipping'))) checked @endif onchange="this.form.submit()">
                        Retrait en boutique
                    </label>
                    <label class="filter-item">
                        <input type="checkbox" name="shipping[]" value="livraison_point_special" @if(is_array(request('shipping')) && in_array('livraison_point_special', request('shipping'))) checked @endif onchange="this.form.submit()">
                        Livraison en point spécial
                    </label>
                </div>
                @endif

                <!-- Avis client -->
                <div class="sidebar-section">
                    <div class="sidebar-title">Avis client</div>
                    @for($i = 4; $i >= 1; $i--)
                        <label class="filter-item" style="cursor: pointer;">
                            <input type="checkbox" name="rating[]" value="{{ $i }}" @if(is_array(request('rating')) && in_array($i, request('rating'))) checked @endif onchange="this.form.submit()">
                            <div class="review-stars" style="margin: 0; font-size: 0.8rem;">
                                @for($j = 1; $j <= 5; $j++)
                                    <i class="{{ $j <= $i ? 'fas fa-star' : 'far fa-star' }}"></i>
                                @endfor
                            </div>
                            <span style="font-size: 0.85rem; color: #555;">& plus</span>
                        </label>
                    @endfor
                </div>

                {{-- Critères spécifiques à la catégorie (Niveau 3) --}}
                @if($category && $category->filters->count() > 0)
                    <div class="sidebar-section">
                        <div class="sidebar-title">Critères</div>
                        @foreach($category->filters as $filter)
                            @if($filter->is_filterable)
                                <div style="margin-bottom: 15px; padding: 0 5px;">
                                    <div style="font-size: 0.75rem; font-weight: 800; color: #000; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;">
                                        {{ $filter->nom }}
                                    </div>
                                    @if(in_array($filter->type, ['select', 'radio', 'checkbox']))
                                        @php $options = is_array($filter->options) ? $filter->options : explode(',', $filter->options); @endphp
                                        @foreach($options as $option)
                                            <label class="filter-item" style="margin-bottom: 6px;">
                                                <input type="checkbox" name="f[{{ $filter->slug }}][]" value="{{ trim($option) }}" 
                                                    @if(is_array(request("f.{$filter->slug}")) && in_array(trim($option), request("f.{$filter->slug}"))) checked @endif 
                                                    onchange="this.form.submit()">
                                                <span style="font-size: 0.9rem; color: #444;">{{ trim($option) }}</span>
                                            </label>
                                        @endforeach
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </form>
        </aside>

        <!-- Main Results -->
        <main class="results-main">
            <!-- Breadcrumbs / Top header -->
            <div style="padding: 15px 25px 0 25px; font-size: 0.75rem; color: #555;">
                <a href="{{ route('home') }}" style="color: inherit; text-decoration: none;">Accueil</a>
                <span style="margin: 0 5px;">></span>
                @if(request('sort') === 'vues_desc' && !request('q'))
                    <span style="color: #111; font-weight: 500;">Produits les plus consultés</span>
                @elseif($category)
                    @if($category->parent)
                        <a href="{{ request()->fullUrlWithQuery(['category' => $category->parent->slug]) }}" style="color: inherit; text-decoration: none;">{{ $category->parent->nom }}</a>
                        <span style="margin: 0 5px;">></span>
                    @endif
                    <span style="color: #111; font-weight: 500;">{{ $category->nom }}</span>
                @else
                    <span style="color: #111; font-weight: 500;">Recherche</span>
                @endif
            </div>

            <div style="padding: 10px 25px 20px 25px;">
                <h1 style="font-size: 1.8rem; font-weight: 800; color: #333; margin: 0;">
                    @if(request('sort') === 'vues_desc' && !request('q'))
                        Produits les plus consultés {{ $category ? '- ' . $category->nom : '' }}
                    @else
                        {{ $category ? $category->nom : (request('q') ?: 'Recherche') }}
                    @endif
                </h1>
            </div>


            <div class="results-header" style="border-top: 1px solid #ddd; background: #fff; padding: 10px 25px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div class="results-count" style="font-size: 0.9rem; color: #333;">
                        @if($annonces->total() > 0)
                            Plus de <strong>{{ number_format($annonces->total(), 0, ',', ' ') }} résultats</strong>
                        @else
                            Aucun résultat trouvé
                        @endif
                    </div>
                </div>
                
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <select class="sort-select" onchange="window.location.href=this.value">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'relevance']) }}" @if(request('sort') == 'relevance') selected @endif>Meilleures ventes</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" @if(request('sort') == 'price_asc') selected @endif>Prix : croissant</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" @if(request('sort') == 'price_desc') selected @endif>Prix : décroissant</option>
                        </select>
                    </div>
            </div>

            <!-- Grid -->
            <div class="products-grid">
                @forelse($annonces as $annonce)
                    <a href="{{ route('annonces.show', $annonce->slug) }}" class="product-card">
                        <div class="product-image-container">
                            @if($annonce->photoPrincipale())
                                <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" class="product-image" alt="{{ $annonce->titre }}">
                            @else
                                <div style="color: #ccc;">Aucune photo</div>
                            @endif
                        </div>

                        <div class="product-info">
                            @if($annonce->vendeur && $annonce->vendeur->type === 'professionnel')
                                <div style="font-size: 0.75rem; color: #565959; margin-bottom: 2px; font-weight: 500;">Sponsorisée</div>
                            @endif
                            <h2 class="product-title">{{ $annonce->titre }}</h2>
                            
                            <div class="review-stars">
                                @php 
                                    $moyenneNote = $annonce->note_moyenne;
                                    $nbAvis = $annonce->nombre_avis;
                                @endphp
                                
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($moyenneNote))
                                        <i class="fas fa-star"></i>
                                    @elseif($i == ceil($moyenneNote) && ($moyenneNote - floor($moyenneNote)) >= 0.5)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span class="review-count">({{ $nbAvis }})</span>
                            </div>

                             <div class="product-price-row">
                                 <span class="product-price-value">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
                                 @if($annonce->should_show_etat)
                                    <span class="product-status" style="color: {{ $annonce->etat_couleur }}; font-weight: 700;">{{ $annonce->etat_libelle }}</span>
                                 @endif
                             </div>

                            @if($annonce->vendeur && $annonce->vendeur->type === 'professionnel')
                                <div style="font-size: 0.78rem; color: #666; margin-bottom: 8px;">
                                    Par <span style="color: #333;">{{ $annonce->vendeur->identite }}</span> <span class="tag-pro" style="margin-left: 2px;">PRO</span>
                                </div>
                            @endif

                            <div class="product-view-btn">
                                <span>{{ $annonce->label_voir_bouton }}</span>
                                <i class="fas fa-chevron-right" style="font-size: 0.65rem;"></i>
                            </div>
                            
                             {{-- Sell yours removed --}}

                            <div class="product-tags">
                                @if($annonce->estALaUne())
                                    <span class="tag-sponsored">Sponsorisé</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="empty-state">
                        <div style="font-size: 3rem; margin-bottom: 20px; opacity: 0.3;">🔍</div>
                        <h3>Aucun résultat trouvé</h3>
                        <p>Essayez d'utiliser des mots-clés plus génériques ou vérifiez l'orthographe.</p>
                        <a href="{{ route('home') }}" style="color: var(--p-blue); text-decoration: underline; margin-top: 20px; display: inline-block;">Retour à l'accueil</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                @if($annonces->hasPages())
                    <div style="display: flex; gap: 20px; align-items: center;">
                        @if(!$annonces->onFirstPage())
                            <a href="{{ $annonces->previousPageUrl() }}" class="btn-pagination">
                                <i class="fas fa-chevron-left"></i> Précédent
                            </a>
                        @endif
                        
                        @if($annonces->hasMorePages())
                            <a href="{{ $annonces->nextPageUrl() }}" class="btn-pagination next">
                                Suivant <i class="fas fa-chevron-right"></i>
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </main>
    </div>
</div>
<script>
function toggleFilters(show) {
    const sidebar = document.getElementById('mobileSidebar');
    if (show) {
        sidebar.classList.add('mobile-active');
        document.body.style.overflow = 'hidden';
    } else {
        sidebar.classList.remove('mobile-active');
        document.body.style.overflow = '';
    }
}
</script>
@endsection
