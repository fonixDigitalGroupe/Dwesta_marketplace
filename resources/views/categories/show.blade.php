@extends('layouts.app')

@section('title', $category->nom . ' - Mady Market')

@push('styles')
<style>
    .category-show-container { max-width: 1200px; margin: 1rem auto; padding: 0 1rem; }
    
    .breadcrumbs { margin-bottom: 1rem; font-size: 0.85rem; color: #666; display: flex; align-items: center; gap: 0.5rem; }
    .breadcrumbs a { color: #333; text-decoration: none; }
    .breadcrumbs a:hover { color: #bf0000; }
    .breadcrumbs span { color: #ccc; }

    .category-header { background: white; padding: 2rem; border-radius: 8px; border: 1px solid #e0e0e0; margin-bottom: 1.5rem; }
    .category-title-row { display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem; }
    .category-title { font-size: 2rem; color: #333; font-weight: 800; }
    .category-desc { color: #666; font-size: 1rem; }

    /* Horizontal Category Nav */
    .horizontal-cat-nav { background: white; border-bottom: 1px solid #e0e0e0; margin-bottom: 2rem; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }
    .horizontal-cat-nav::-webkit-scrollbar { display: none; }
    .cat-nav-list { display: flex; list-style: none; padding: 0; margin: 0; }
    .cat-nav-item { border-bottom: 2px solid transparent; transition: all 0.2s; }
    .cat-nav-item.active { border-bottom-color: #bf0000; }
    .cat-nav-link { display: block; padding: 1rem 1.5rem; text-decoration: none; color: #333; font-weight: 500; font-size: 0.95rem; }
    .cat-nav-item.active .cat-nav-link { color: #bf0000; font-weight: bold; }
    .cat-nav-item:hover .cat-nav-link { color: #bf0000; }

    .ads-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem; }
    
    .ad-card { background: white; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; text-decoration: none; color: inherit; transition: all 0.2s; display: flex; flex-direction: column; }
    .ad-card:hover { transform: translateY(-4px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-color: #bf0000; }
    .ad-image { aspect-ratio: 1; background: #f9f9f9; position: relative; }
    .ad-image img { width: 100%; height: 100%; object-fit: cover; }
    .ad-price { color: #bf0000; font-weight: bold; font-size: 1.2rem; margin-top: 0.5rem; }
    .ad-info { padding: 1rem; flex: 1; display: flex; flex-direction: column; gap: 0.25rem; }
    .ad-title { font-size: 0.95rem; line-height: 1.4; height: 2.8rem; overflow: hidden; }
</style>
@endpush

@section('content')
<div class="catalog-page-container">
    <div class="catalog-layout">
        <!-- Sidebar -->
        <aside class="catalog-sidebar-column">
            @include('partials.catalog-sidebar')
        </aside>

        <!-- Main Content -->
        <main class="catalog-main-column">
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


            <div class="results-toolbar">
                <div></div> {{-- Spacer to keep sort to the right --}}
                <div class="sort-options">
                    <select onchange="window.location.href = this.value">
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'relevance']) }}" @if(request('sort') == 'relevance') selected @endif>Le plus pertinent</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" @if(request('sort') == 'price_asc') selected @endif>Prix croissant</option>
                        <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" @if(request('sort') == 'price_desc') selected @endif>Prix décroissant</option>
                    </select>
                </div>
            </div>

            <div class="catalog-grid">
                @forelse($annonces as $annonce)
                    <div class="catalog-item">
                        <a href="{{ route('annonces.show', $annonce->slug) }}" class="item-link">
                            <div class="item-media">
                                @if($annonce->photoPrincipale())
                                    <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                                @else
                                    <div class="no-photo">Pas de photo</div>
                                @endif
                            </div>
                            <div class="item-content">
                                <div class="item-sponsor">Sponsorisée</div>
                                <h3 class="item-title">{{ $annonce->titre }}</h3>
                                <div class="item-brand">- {{ $category->nom }}</div>
                                <div class="item-rating">
                                    <div class="stars">
                                        <svg width="14" height="14" fill="#ffc107" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" fill="#ffc107" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" fill="#ffc107" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" fill="#ffc107" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                        <svg width="14" height="14" fill="#ffc107" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    </div>
                                    <span class="rating-count">560 avis</span>
                                </div>
                                <div class="item-pricing">
                                    <span class="price-main">{{ number_format($annonce->prix, 2, ',', ' ') }} €</span>
                                    <span class="condition">. Neuf</span>
                                </div>
                                <div class="item-seller">
                                    Par <span class="seller-name">{{ $annonce->vendeur->user->prenom }} {{ $annonce->vendeur->user->nom }}</span>
                                    <span class="badge-pro">PRO</span>
                                </div>
                                <div class="item-button">
                                    <span>Voir le produit</span>
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </div>
                        </a>
                        <div class="item-footer">
                            <a href="#" class="sell-link">
                                Vendez le vôtre
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <p>Aucun produit trouvé dans cette catégorie.</p>
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
    .catalog-page-container {
        background-color: #fff;
        min-height: 100vh;
        padding: 0;
    }

    .catalog-layout {
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 0;
        border-top: 1px solid #ebebeb;
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
    .catalog-item:nth-child(7n+7),
    .catalog-item:nth-child(7n) {
        grid-column: span 3;
    }

    /* Remove right border for items at the end of their rows */
    .catalog-item:nth-child(7n+3), /* End of 3-item row */
    .catalog-item:nth-child(7n)   /* End of 4-item row */ {
        border-right: none;
    }

    .item-link {
        text-decoration: none;
        color: inherit;
        padding: 0.75rem 1.25rem 0.25rem 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .item-media {
        aspect-ratio: 1.15;
        background: #fff;
        position: relative;
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-media img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
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

    .item-content {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .item-sponsor {
        font-size: 0.7rem;
        color: #999;
        margin-bottom: 0.2rem;
    }

    .item-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: #333;
        line-height: 1.3;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 2.4rem;
    }

    .item-brand {
        font-size: 0.85rem;
        color: #333;
        margin-top: -0.1rem;
    }

    .item-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.25rem;
    }

    .stars {
        display: flex;
        gap: 1px;
    }

    .rating-count {
        font-size: 0.75rem;
        color: #666;
    }

    .item-pricing {
        margin-top: 0.5rem;
        display: flex;
        align-items: baseline;
        gap: 0.3rem;
    }

    .price-main {
        font-size: 1.3rem;
        font-weight: 900;
        color: #e60000;
    }

    .condition {
        font-size: 0.8rem;
        color: #e60000;
        font-weight: 500;
    }

    .item-seller {
        font-size: 0.75rem;
        color: #666;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .seller-name {
        text-transform: uppercase;
        font-weight: 500;
    }

    .badge-pro {
        font-size: 0.6rem;
        font-weight: 800;
        border: 1px solid #ccc;
        padding: 0 0.2rem;
        border-radius: 4px;
        color: #333;
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
</style>
@endsection


