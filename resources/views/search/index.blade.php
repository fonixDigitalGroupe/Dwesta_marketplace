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
<div class="search-results-container">
    <!-- Sidebar -->
    <aside class="filters-sidebar">
        <div class="filter-group">
            <h3 class="filter-title">Catégories</h3>
            <ul class="filter-list">
                @foreach($categories as $cat)
                    <li class="filter-item">
                        <a href="{{ route('search.index', ['category' => $cat->slug, 'q' => request('q')]) }}" class="filter-link @if(request('category') == $cat->slug) active @endif">
                            {{ $cat->nom }}
                        </a>
                        @if($cat->enfantsActifs->isNotEmpty())
                            <ul class="filter-list" style="padding-left: 1rem; margin-top: 0.25rem;">
                                @foreach($cat->enfantsActifs->take(5) as $child)
                                    <li class="filter-item">
                                        <a href="{{ route('search.index', ['category' => $child->slug, 'q' => request('q')]) }}" class="filter-link @if(request('category') == $child->slug) active @endif" style="font-size: 0.85rem;">
                                            {{ $child->nom }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <form action="{{ route('search.index') }}" method="GET">
            <input type="hidden" name="q" value="{{ request('q') }}">
            <input type="hidden" name="category" value="{{ request('category') }}">
            
            <div class="filter-group">
                <h3 class="filter-title">Prix (€)</h3>
                <div class="price-range-inputs">
                    <input type="number" name="min_prix" class="price-input" placeholder="Min" value="{{ request('min_prix') }}">
                    <span>-</span>
                    <input type="number" name="max_prix" class="price-input" placeholder="Max" value="{{ request('max_prix') }}">
                </div>
            </div>

            <div class="filter-group">
                <h3 class="filter-title">État</h3>
                <div class="filter-item">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="etat[]" value="Neuf" @if(is_array(request('etat')) && in_array('Neuf', request('etat'))) checked @endif> Neuf
                    </label>
                </div>
                <div class="filter-item">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="etat[]" value="Occasion" @if(is_array(request('etat')) && in_array('Occasion', request('etat'))) checked @endif> Occasion
                    </label>
                </div>
            </div>

            <div class="filter-group">
                <h3 class="filter-title">Type de vendeur</h3>
                <div class="filter-item">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="radio" name="vendeur_type" value="" @if(!request('vendeur_type')) checked @endif> Tous
                    </label>
                </div>
                <div class="filter-item">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="radio" name="vendeur_type" value="professionnel" @if(request('vendeur_type') == 'professionnel') checked @endif> Professionnels
                    </label>
                </div>
                <div class="filter-item">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="radio" name="vendeur_type" value="particulier" @if(request('vendeur_type') == 'particulier') checked @endif> Particuliers
                    </label>
                </div>
            </div>

            <button type="submit" class="apply-btn">Appliquer les filtres</button>
        </form>
    </aside>

    <!-- Results Section -->
    <main class="results-main">
        <div class="results-header">
            <h1 class="results-count">
                @if(request('q'))
                    Résultats pour "{{ request('q') }}" ({{ $annonces->total() }})
                @else
                    Toutes les annonces ({{ $annonces->total() }})
                @endif
            </h1>
            
            <div class="results-sort">
                <select class="sort-select" onchange="window.location.href = this.value">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'relevance']) }}" @if(request('sort') == 'relevance') selected @endif>Trier par : Pertinence</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" @if(request('sort') == 'price_asc') selected @endif>Trier par : Prix croissant</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" @if(request('sort') == 'price_desc') selected @endif>Trier par : Prix décroissant</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" @if(request('sort') == 'newest') selected @endif>Trier par : Nouveautés</option>
                </select>
            </div>
        </div>

        <div class="products-grid">
            @forelse($annonces as $annonce)
                <a href="{{ route('annonces.show', $annonce->slug) }}" class="product-card">
                    <div class="product-image">
                        @if($annonce->photoPrincipale())
                            <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                        @else
                            <img src="https://via.placeholder.com/300?text=Sans+Photo" alt="Pas de photo">
                        @endif
                        
                        @if($annonce->estALaUne())
                            <span class="product-badge">À la une</span>
                        @endif
                    </div>
                    <div class="product-info">
                        <h2 class="product-title">{{ $annonce->titre }}</h2>
                        <div class="product-price">{{ number_format($annonce->prix, 2, ',', ' ') }} €</div>
                        <div class="product-meta">
                            <span>{{ $annonce->vendeur->user->name }} @if($annonce->vendeur->estProfessionnel()) <strong style="color: #bf0000;">PRO</strong> @endif</span>
                            <span>{{ $annonce->publiee_le->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: white; border-radius: 8px; border: 1px solid #e0e0e0;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                    <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem;">Aucun résultat trouvé</h3>
                    <p style="color: #666;">Essayez d'ajuster vos filtres ou de modifier votre recherche.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination-container">
            {{ $annonces->links() }}
        </div>
    </main>
</div>
@endsection
