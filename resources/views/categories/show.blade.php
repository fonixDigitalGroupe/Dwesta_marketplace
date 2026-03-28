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
                                    <span class="price-val">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
                                    <span class="state-sep">·</span>
                                    <span class="state-label">
                                        {{ $annonce->etat_libelle }}
                                    </span>
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
                                    <span class="btn-see-product">Voir le produit <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg></span>
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
        color: #db0001;
    }

    .state-sep {
        font-weight: bold;
        color: #db0001;
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
</style>
@endsection


