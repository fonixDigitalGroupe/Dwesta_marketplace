@extends('layouts.app')

@section('title', $banner->title . ' - Dwesta Marketplace')

@push('styles')
<style>
    body { overflow-x: hidden; width: 100%; }

    /* === PROMO BAR === */
    .n1-promo-bar {
        background: #000; color: #fff; padding: 8px 0;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.85rem; width: 100%; overflow: hidden;
    }
    .n1-promo-content { display: flex; align-items: center; gap: 1.5rem; }
    .n1-promo-badge { font-weight: 700; display: flex; align-items: center; gap: 4px; }
    .n1-promo-text { font-weight: 400; }
    .n1-promo-code { background: #fff; color: #000; padding: 1px 4px; font-weight: 800; margin-left: 4px; border-radius: 1px; }

    /* === GRAND BANNER === */
    .n1-grand-banner { width: 100%; display: block; line-height: 0; }
    .n1-grand-banner img { width: 100%; height: 180px; display: block; object-fit: cover; object-position: center; }

    /* === TOP CONSULTED === */
    .n1-top-consulted-section { padding: 3rem 0; background: #fff; }
    .n1-top-consulted-title {
        font-family: 'Outfit', sans-serif; font-size: 1.6rem; font-weight: 700;
        color: #333; text-align: center; margin-bottom: 2rem;
    }
    .n1-top-consulted-carousel { position: relative; max-width: 1300px; margin: 0 auto; padding: 0 50px; }
    .n1-top-grid { display: flex; gap: 12px; overflow-x: hidden; scroll-behavior: smooth; padding: 10px 0; }
    .n1-top-card {
        flex: 0 0 calc(16.66% - 10px); min-width: 190px;
        background: #fff; border: 1px solid #efefef; border-radius: 8px;
        padding: 1.25rem; text-decoration: none; color: inherit;
        display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s;
    }
    .n1-top-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); border-color: #ddd; }
    .n1-top-media { width: 100%; height: 160px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
    .n1-top-media img { max-width: 100%; max-height: 100%; object-fit: contain; }
    .n1-top-info { flex: 1; display: flex; flex-direction: column; }
    .n1-top-item-title { font-size: 0.85rem; line-height: 1.4; color: #555; margin-bottom: 0.8rem; height: 2.8rem; overflow: hidden; }
    .n1-top-price-row { display: flex; flex-direction: column; gap: 2px; margin-bottom: 0.5rem; }
    .n1-top-price-state { font-size: 0.7rem; color: #888; }
    .n1-top-price-val { font-size: 1rem; font-weight: 800; color: #bf0000; }
    .n1-top-rating { display: flex; align-items: center; gap: 5px; }
    .n1-top-stars { display: flex; gap: 1px; color: #ffbc00; font-size: 0.75rem; }
    .n1-top-rating-count { font-size: 0.75rem; color: #888; }
    .n1-top-footer { display: flex; justify-content: center; margin-top: 1.5rem; }
    .btn-voir-plus-outline {
        background: transparent; color: #333; border: 1px solid #333;
        padding: 0.7rem 2.5rem; border-radius: 30px; font-weight: 600; font-size: 0.9rem;
        cursor: pointer; text-decoration: none; transition: all 0.3s ease;
    }
    .btn-voir-plus-outline:hover { background: #333; color: #fff; transform: translateY(-2px); }

    /* === OFFER / DEAL CAROUSEL === */
    .n1-offers-section { padding: 1.5rem 0 3rem; margin: 0 auto; max-width: 1300px; overflow: hidden; }
    .n1-offers-title { text-align: center; font-size: 1.3rem; font-weight: 700; color: #000; margin-bottom: 1.5rem; }
    .n1-carousel-wrapper { position: relative; padding: 0 40px; }
    .n1-catalog-grid {
        display: flex; flex-direction: row; overflow-x: auto; overflow-y: hidden;
        scroll-behavior: smooth; gap: 1.25rem; padding: 0.5rem 0.25rem;
        -webkit-overflow-scrolling: touch; scrollbar-width: none;
    }
    .n1-catalog-grid::-webkit-scrollbar { display: none !important; }
    .n1-promo-card {
        background: #fff; border: 1px solid #eee; border-radius: 8px; padding: 1rem;
        display: flex; flex-direction: column; text-decoration: none; color: inherit;
        min-width: 220px; max-width: 220px; flex-shrink: 0;
    }
    .n1-promo-card:hover { border-color: #ddd; }
    .n1-card-media { height: 180px; width: 100%; display: flex; align-items: center; justify-content: center; padding: 0.5rem; }
    .n1-card-media img { max-height: 100%; max-width: 100%; object-fit: contain; }
    .n1-card-title { height: 38px; font-size: 13px; line-height: 1.4; color: #333; margin: 10px 0 8px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; padding: 0 10px; }
    .n1-card-footer { margin-top: auto; padding: 10px; border-top: 1px solid #f0f0f0; }
    .n1-footer-left { display: flex; flex-direction: column; gap: 2px; }
    .n1-price-label { font-size: 11px; color: #888; }
    .n1-price-comparison { display: flex; align-items: center; gap: 6px; }
    .n1-old-price { font-size: 12px; color: #888; text-decoration: line-through; }
    .n1-discount-badge { background: #ee8800; color: white; font-size: 11px; font-weight: 700; padding: 2px 5px; border-radius: 4px; }
    .n1-actual-price { font-size: 18px; font-weight: 800; color: #bf0000; margin-top: 4px; }
    .n1-merchant-deals-info { padding: 0 10px 15px; display: flex; flex-direction: column; gap: 4px; }
    .n1-v2-price-row { display: flex; align-items: center; gap: 8px; color: #bf0000; font-weight: 700; font-size: 16px; }
    .n1-v2-merchant-row { display: flex; align-items: center; gap: 8px; color: #777; font-size: 13px; }
    .n1-v2-shop-name { max-width: 130px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .n1-v2-badge-pro { background: #f4f4f4; color: #555; padding: 1px 6px; border-radius: 4px; font-size: 11px; font-weight: 700; }
    .n1-section-footer { display: flex; justify-content: center; margin-top: 1.5rem; }
    .btn-voir-plus-white {
        background: transparent; color: #333; border: 1px solid #333;
        padding: 0.7rem 2.5rem; border-radius: 30px; font-weight: 600; font-size: 0.9rem;
        cursor: pointer; transition: all 0.3s ease; text-decoration: none;
    }
    .btn-voir-plus-white:hover { background: #333; color: #fff; transform: translateY(-2px); }

    /* === CAROUSEL ARROWS === */
    .n1-carousel-arrow {
        position: absolute; top: 40%; transform: translateY(-50%); z-index: 20;
        display: flex; align-items: center; justify-content: center;
        width: 32px; height: 32px; background: #fff; border: 1px solid #ccc;
        border-radius: 50%; cursor: pointer; box-shadow: 0 1px 6px rgba(0,0,0,0.18);
        color: #444; transition: box-shadow 0.2s, color 0.2s;
    }
    .n1-carousel-arrow:hover { box-shadow: 0 3px 12px rgba(0,0,0,0.22); color: #111; }
    .n1-arrow-left  { left: 8px; }
    .n1-arrow-right { right: 8px; }

    /* === SELECTION GRID (main product grid) === */
    .n1-selection-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        gap: 0.75rem;
        margin-bottom: 3rem;
    }
    .n1-selection-item {
        width: 220px;
        flex-shrink: 0;
    }

    /* === CATALOG GRID (legacy, kept for other reuse) === */
    .catalog-page-container { background-color: #fff; min-height: 100vh; }
    .catalog-layout { display: grid; grid-template-columns: 1fr; gap: 0; border-top: 1px solid #ebebeb; }
    .catalog-main-column { padding: 0; margin: 0; overflow: hidden; }
    .catalog-grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 0; padding: 0; }
    .catalog-item { background: #fff; border-right: 1px solid #ebebeb; border-bottom: 1px solid #ebebeb; display: flex; flex-direction: column; padding-bottom: 1rem; }
    .catalog-item:nth-child(7n+1), .catalog-item:nth-child(7n+2), .catalog-item:nth-child(7n+3) { grid-column: span 4; }
    .catalog-item:nth-child(7n+4), .catalog-item:nth-child(7n+5), .catalog-item:nth-child(7n+6), .catalog-item:nth-child(7n+7) { grid-column: span 3; }
    .catalog-item:nth-child(7n+3), .catalog-item:nth-child(7n+7) { border-right: none; }
    .catalog-card { background: #fff; display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s; text-decoration: none; color: inherit; height: 100%; }
    .catalog-card:hover { transform: translateY(-4px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .card-media { height: 200px; background: #fcfcfc; position: relative; overflow: hidden; }
    .card-media img { width: 100%; height: 100%; object-fit: cover; }
    .no-photo { display: flex; align-items: center; justify-content: center; height: 100%; color: #ccc; font-size: 0.8rem; }
    .badge-sponsored { position: absolute; top: 0.5rem; left: 0.5rem; background: #fff; color: #111; font-size: 0.6rem; font-weight: 800; padding: 0.2rem 0.5rem; border-radius: 4px; text-transform: uppercase; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: 1px solid #eee; z-index: 10; }
    .card-content { padding: 0.75rem 0.75rem 1rem; flex: 1; display: flex; flex-direction: column; gap: 0.4rem; }
    .card-title { font-size: 0.85rem; font-weight: 700; line-height: 1.25; height: 2.1rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; margin-bottom: 0.25rem; color: #333; }
    .card-rating { display: flex; align-items: center; gap: 0.5rem; }
    .card-rating .stars { display: flex; gap: 1px; color: #ffbc00; font-size: 0.8rem; }
    .card-rating .reviews-count { font-size: 0.75rem; color: #777; }
    .card-price-state { display: flex; align-items: center; gap: 0.4rem; }
    .price-val { font-size: 1.15rem; font-weight: 800; color: #db0001; }
    .state-sep { font-weight: bold; color: #db0001; }
    .state-label { font-size: 0.8rem; font-weight: 700; color: #db0001; }
    .seller-info-line { font-size: 0.75rem; color: #777; display: flex; align-items: center; gap: 4px; }
    .seller-name-text { font-weight: 600; color: #333; }
    .pro-tag { background: #fff; color: #666; font-size: 7px; font-weight: 700; padding: 1px 5px; border-radius: 10px; margin-left: 2px; border: 1px solid #ddd; text-transform: uppercase; vertical-align: middle; }
    .card-actions { margin-top: auto; }
    .btn-see-product { display: flex; align-items: center; justify-content: center; width: 100%; padding: 0.6rem; border: 1.5px solid #111; border-radius: 8px; background: #fff; color: #111; font-size: 0.9rem; font-weight: 800; transition: all 0.2s; }
    .catalog-card:hover .btn-see-product { background: #111; color: #fff; }

    .results-toolbar { display: flex; justify-content: space-between; align-items: center; padding: 0.4rem 1rem 1.25rem; border-bottom: 1px solid #ebebeb; }
    .results-count { font-size: 0.75rem; font-weight: 400; color: #666; margin: 0; }
    .sort-options { display: flex; align-items: center; gap: 1rem; }
    .sort-options label { font-size: 0.85rem; font-weight: 600; color: #666; }
    .sort-options select { padding: 0.5rem 1rem; background: #fff; border: 1px solid #ddd; border-radius: 4px; font-size: 0.875rem; outline: none; }
    .pagination-wrapper { display: flex; justify-content: center; margin-top: 4rem; }
    .empty-state { grid-column: 1/-1; text-align: center; padding: 4rem 2rem; color: #666; }
    .catalog-header { padding: 0.25rem 1rem 1.25rem; border-bottom: 1px solid #ebebeb; }
    .header-title { font-size: 1.25rem; font-weight: 800; color: #000; }
</style>
@endpush

@section('content')

{{-- PROMO BAR --}}
<div class="n1-promo-bar">
    <div class="n1-promo-content">
        <span class="n1-promo-badge">
            <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24" style="vertical-align: middle; margin-top: -2px;"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.4 0-8-3.6-8-8s3.6-8 8-8 8 3.6 8 8-3.6 8-8 8zm.5-13H11v6l5.2 3.2.8-1.3-4.5-2.7V7z"/></svg>
            Durée limitée !
        </span>
        <span class="n1-promo-text">
            @if($banner->promo_discount)
                <strong>{{ $banner->promo_discount }} OFFERTS*</strong>
                @if($banner->description) {{ $banner->description }} @endif
                @if($banner->promo_code) avec le code <span class="n1-promo-code">{{ $banner->promo_code }}</span> @endif
            @else
                {{ $banner->title }}
            @endif
        </span>
    </div>
</div>

{{-- GRAND BANNER --}}
<div class="n1-grand-banner">
    <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}">
</div>

{{-- TOP CONSULTES --}}
@if($topConsultes->count() > 0)
<section class="n1-top-consulted-section">
    <h2 class="n1-top-consulted-title">Top des produits les plus consultés</h2>
    <div class="n1-top-consulted-carousel">
        <button class="n1-carousel-arrow n1-arrow-left" onclick="n1CarouselScroll('n1-top-products', -1)" style="background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <div class="n1-top-grid" id="n1-top-products">
            @foreach($topConsultes as $annonce)
                <a href="{{ route('annonces.show', $annonce->slug) }}" class="n1-top-card">
                    <div class="n1-top-media">
                        @if($annonce->photoPrincipale())
                            <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                        @else
                            <div class="no-photo" style="font-size:0.7rem;color:#ccc;">No photo</div>
                        @endif
                    </div>
                    <div class="n1-top-info">
                        <h3 class="n1-top-item-title">{{ $annonce->titre }}</h3>
                        <div class="n1-top-price-row">
                            <span class="n1-top-price-state">{{ ($annonce->produit && $annonce->produit->etat == 'occasion') ? 'Occasions dès' : 'Neufs dès' }}</span>
                            <span class="n1-top-price-val">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @php $rating = $annonce->note_moyenne ?? rand(4,5); @endphp
                        <div class="n1-top-rating">
                            <div class="n1-top-stars">
                                @for($i=0; $i<5; $i++)
                                    @if($i < floor($rating))
                                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @else
                                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="n1-top-rating-count">{{ $annonce->nombre_avis ?? rand(5,120) }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <button class="n1-carousel-arrow n1-arrow-right" onclick="n1CarouselScroll('n1-top-products', 1)" style="background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.1);">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </div>
</section>
@endif

{{-- OFFRES --}}
@if($offresReductions->count() > 0)
<div class="n1-offers-section">
    <h2 class="n1-offers-title">Les offres qui valent le coup</h2>
    <div class="n1-carousel-wrapper">
        <button class="n1-carousel-arrow n1-arrow-left" onclick="n1CarouselScroll('n1-carousel-offers', -1)">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <div class="n1-catalog-grid" id="n1-carousel-offers">
            @foreach($offresReductions as $annonce)
                @php
                    $oldPrice = $annonce->produit->prix_moyen_marche ?? ($annonce->prix * 1.15);
                    $discount = $oldPrice > $annonce->prix ? round((($oldPrice - $annonce->prix) / $oldPrice) * 100) : 0;
                @endphp
                <a href="{{ route('annonces.show', $annonce->slug) }}" class="n1-promo-card">
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
                                @if($discount > 0)<span class="n1-discount-badge">-{{ $discount }}%</span>@endif
                            </div>
                            <div class="n1-actual-price">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <button class="n1-carousel-arrow n1-arrow-right" onclick="n1CarouselScroll('n1-carousel-offers', 1)">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </div>
    <div class="n1-section-footer">
        <a href="#" class="btn-voir-plus-white">Voir plus d'offres</a>
    </div>
</div>
@endif

{{-- DEALS MARCHANDS --}}
@if($dealsMarchands->count() > 0)
<div class="n1-offers-section" style="margin-top: 2rem; background: #fff; padding: 2rem 0; border-radius: 8px;">
    <h2 class="n1-offers-title" style="color: #333;">Nos deals marchands du moment</h2>
    <div class="n1-carousel-wrapper">
        <button class="n1-carousel-arrow n1-arrow-left" onclick="n1CarouselScroll('n1-carousel-deals', -1)" style="background:rgba(255,255,255,0.9); color:#333; border:1px solid #ddd;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </button>
        <div class="n1-catalog-grid" id="n1-carousel-deals">
            @foreach($dealsMarchands as $annonce)
                <a href="{{ route('annonces.show', $annonce->slug) }}" class="n1-promo-card">
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
                            <span class="n1-v2-price">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
                            <span class="n1-v2-state">{{ $annonce->produit ? ucfirst($annonce->produit->etat) : 'Neuf' }}</span>
                        </div>
                        <div class="n1-v2-merchant-row">
                            <span class="n1-v2-shop-name">Par {{ $annonce->vendeur->professionnel->nom_entreprise ?? 'Boutique' }}</span>
                            <span class="n1-v2-badge-pro">PRO</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <button class="n1-carousel-arrow n1-arrow-right" onclick="n1CarouselScroll('n1-carousel-deals', 1)" style="background:rgba(255,255,255,0.9); color:#333; border:1px solid #ddd;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </div>
</div>
@endif

{{-- GRILLE PRINCIPALE --}}
<div style="max-width: 1300px; margin: 0 auto; padding: 2rem 1rem 4rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #ebebeb; padding-bottom: 1rem;">
        <h2 style="font-size: 1.3rem; font-weight: 700; color: #000; margin: 0;">Notre sélection {{ $banner->title }}</h2>
        <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.85rem; color: #666;">
            <span>{{ $annonces->total() }} résultat(s)</span>
            <select onchange="window.location.href='?sort='+this.value" style="padding: 0.4rem 0.8rem; border: 1px solid #ddd; border-radius: 4px; font-size: 0.875rem; outline: none;">
                <option value="relevance" {{ !request('sort') || request('sort') == 'relevance' ? 'selected' : '' }}>Pertinence</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
            </select>
        </div>
    </div>

    <div class="n1-selection-grid">
        @forelse($annonces as $annonce)
            <div class="n1-selection-item">
                <a href="{{ route('annonces.show', $annonce->slug) }}" class="n1-promo-card">
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
                            <span class="n1-v2-price">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
                            <span class="n1-v2-state" style="font-size:12px; color:#777; font-weight:400;">{{ $annonce->produit ? ucfirst($annonce->produit->etat) : 'Neuf' }}</span>
                        </div>
                        @if($annonce->vendeur && $annonce->vendeur->type === 'professionnel')
                        <div class="n1-v2-merchant-row">
                            <span class="n1-v2-shop-name">Par {{ $annonce->vendeur->professionnel->nom_entreprise ?? 'Boutique' }}</span>
                            <span class="n1-v2-badge-pro">PRO</span>
                        </div>
                        @endif
                    </div>
                </a>
            </div>
        @empty
            <div style="text-align:center; padding:4rem; color:#666; width:100%;">Aucun produit trouvé pour cette collection.</div>
        @endforelse
    </div>

    <div style="display:flex; justify-content:center; margin-top:3rem;">
        {{ $annonces->links() }}
    </div>
</div>


@endsection

@push('scripts')
<script>
function n1CarouselScroll(id, direction) {
    const carousel = document.getElementById(id);
    if (!carousel) return;
    const card = carousel.querySelector('.n1-top-card, .n1-promo-card');
    const cardWidth = card ? card.offsetWidth + 12 : 232;
    carousel.scrollBy({ left: direction * cardWidth * 3, behavior: 'smooth' });
}
</script>
@endpush
