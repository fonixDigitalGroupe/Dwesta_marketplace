@extends('layouts.app')

@section('title', 'Recherche - Mady Market')

@push('styles')
<style>
    .search-results-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2rem;
    }

    /* Sidebar de filtres */
    .filters-sidebar {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        height: fit-content;
        position: sticky;
        top: 1rem;
    }

    .filter-group {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .filter-group:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .filter-title {
        font-weight: bold;
        font-size: 1rem;
        margin-bottom: 1rem;
        color: #333;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .filter-list {
        list-style: none;
        padding: 0;
    }

    .filter-item {
        margin-bottom: 0.5rem;
    }

    .filter-link {
        text-decoration: none;
        color: #666;
        font-size: 0.9rem;
        transition: color 0.2s;
        display: flex;
        justify-content: space-between;
    }

    .filter-link:hover, .filter-link.active {
        color: #bf0000;
        font-weight: 500;
    }

    .filter-count {
        color: #999;
        font-size: 0.8rem;
    }

    /* Grille de résultats */
    .results-main {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .results-count {
        font-size: 1.1rem;
        color: #333;
    }

    .sort-select {
        padding: 0.5rem;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        font-size: 0.9rem;
        outline: none;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }

    .product-card {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: #bf0000;
    }

    .product-image {
        position: relative;
        aspect-ratio: 1;
        background: #f9f9f9;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-badge {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        background: #bf0000;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: bold;
        text-transform: uppercase;
    }

    .product-info {
        padding: 1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .product-title {
        font-size: 0.95rem;
        font-weight: 500;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.8rem;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: bold;
        color: #bf0000;
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.8rem;
        color: #999;
    }

    /* Pagination */
    .pagination-container {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }

    /* Price Range */
    .price-range-inputs {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .price-input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    .apply-btn {
        margin-top: 1rem;
        width: 100%;
        background: #333;
        color: white;
        border: none;
        padding: 0.5rem;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
    }

    .apply-btn:hover {
        background: #000;
    }
</style>
@endpush

@section('content')
<div class="catalog-page-container">
    <div class="catalog-layout">
        <!-- Sidebar -->
        <div class="catalog-sidebar-column">
            @include('partials.catalog-sidebar')
        </div>

        <!-- Main Content -->
        <main class="catalog-main-column">
            <div class="catalog-breadcrumbs">
                <a href="{{ route('home') }}">Accueil</a>
                <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin: 0 4px; opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                <span style="font-weight: 700; color: #000;">Recherche</span>
            </div>

            <div class="catalog-header">
                <h1 class="header-title">
                    @if(request('q'))
                        Résultats pour "{{ request('q') }}"
                    @else
                        Toutes les annonces
                    @endif
                </h1>
            </div>

            <div class="results-toolbar">
                <h2 class="results-count">Tous les résultats ({{ $annonces->total() }})</h2>
                <div class="sort-options">
                    <label>Trier par</label>
                    <select onchange="window.location.href = this.value">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'relevance']) }}" @if(request('sort') == 'relevance') selected @endif>Le plus pertinent</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" @if(request('sort') == 'price_asc') selected @endif>Prix croissant</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" @if(request('sort') == 'price_desc') selected @endif>Prix décroissant</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" @if(request('sort') == 'newest') selected @endif>Nouveautés</option>
                    </select>
                </div>
            </div>

            <div class="catalog-grid">
                @forelse($annonces as $annonce)
                    <a href="{{ route('annonces.show', $annonce->slug) }}" class="catalog-card">
                        <div class="card-media">
                            @if($annonce->photoPrincipale())
                                <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                            @else
                                <div class="no-photo">Pas de photo</div>
                            @endif
                            @if($annonce->estALaUne()) <span class="badge-featured">À la une</span> @endif
                        </div>
                        <div class="card-content">
                            <h3 class="card-title">{{ $annonce->titre }}</h3>
                            <div class="card-price">{{ number_format($annonce->prix, 0, ',', ' ') }} F CFA</div>
                            <div class="card-footer">
                                <span class="seller-name">
                                    {{ $annonce->vendeur?->user?->prenom ?? 'Utilisateur' }} 
                                    {{ $annonce->vendeur?->user?->nom ?? '' }}
                                </span>
                                <span class="date">{{ $annonce->publiee_le?->diffForHumans() ?? '' }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="empty-state">
                        <p>Aucun produit ne correspond à vos critères.</p>
                        <a href="{{ route('home') }}" class="btn-back">Retour à l'accueil</a>
                    </div>
                @endforelse
            </div>

            <div class="pagination-wrapper">
                {{ $annonces->links() }}
            </div>
        </main>
    </div>
</div>

<style>
    /* Reuse styles from category page for consistency */
    .catalog-page-container {
        background-color: #fff;
        min-height: 100vh;
        padding: 0;
    }

    .catalog-layout {
        max-width: 1400px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 210px 1fr;
        gap: 2rem;
    }

    .catalog-breadcrumbs {
        display: flex;
        align-items: center;
        font-size: 0.75rem;
        color: #666;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .catalog-breadcrumbs a {
        color: #333;
        text-decoration: none;
    }

    .catalog-breadcrumbs a:hover {
        text-decoration: underline;
    }

    .catalog-header {
        padding: 1.5rem 0;
        margin-bottom: 2rem;
        border-bottom: 1px solid #ebebeb;
    }

    .header-title {
        font-size: 1.5rem;
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
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .results-count {
        font-size: 1.125rem;
        font-weight: 700;
        color: #000;
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
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.5rem;
    }

    .catalog-card {
        background: #fff;
        border: 1px solid #ebebeb;
        border-radius: 4px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
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

    .badge-featured {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        background: #000;
        color: #fff;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 0.25rem 0.5rem;
        border-radius: 2px;
        text-transform: uppercase;
    }

    .card-content {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-title {
        font-size: 0.95rem;
        line-height: 1.4;
        font-weight: 500;
        height: 2.1rem; /* 2 lines */
        overflow: hidden;
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .card-price {
        font-size: 1.25rem;
        font-weight: 800;
        color: #000;
        margin-bottom: auto;
    }

    .card-footer {
        margin-top: 1rem;
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: #999;
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
            display: none;
        }
    }
</style>
@endsection
