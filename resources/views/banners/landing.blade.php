@extends('layouts.app')

@section('title', $banner->title . ' - Karnou')

@push('styles')
<style>
    body { overflow-x: hidden; background-color: #fff !important; }

    /* ===== HERO BANNER ===== */
    .landing-hero {
        width: 100%;
        height: 260px;
        background-color: #ffffff;
        background-size: cover;
        background-position: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    /* Dimmer to ensure text holds regardless of the image */
    .landing-hero::before {
        content: '';
        position: absolute;
        top:0; left:0; right:0; bottom:0;
        background: rgba(0,0,0,0.3);
        z-index: 1;
    }
    .landing-hero-content { 
        position: relative; 
        z-index: 10; 
        width: 100%;
        max-width: 600px;
        padding: 0 20px;
    }
    .landing-hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 700;
        margin: 0 0 10px 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        color: #fff;
    }
    .landing-hero-subtitle {
        font-size: 1.3rem;
        font-weight: 400;
        font-style: italic;
        margin: 0;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
        color: #fff;
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

    /* ===== BREADCRUMB ===== */
    .landing-breadcrumb {
        background: #f9f9f9;
        border-bottom: 1px solid #eee;
        padding: 0.6rem 0;
        font-size: 0.8rem;
        color: #666;
    }
    .landing-breadcrumb a { color: #555; text-decoration: none; font-weight: 500; }
    .landing-breadcrumb a:hover { color: #ff8c00; text-decoration: underline; }
    .landing-breadcrumb span { margin: 0 6px; color: #999; }

    /* ===== MAIN CONTENT ===== */
    .landing-body {
        max-width: 1300px;
        margin: 0 auto;
        padding: 2.5rem 1.5rem 4rem;
    }

    /* ===== TOP SECTION ===== */
    .landing-top-section {
        margin-bottom: 3rem;
    }
    .landing-section-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f68b1e;
        display: inline-block;
    }

    /* ===== TOP PRODUCTS CAROUSEL ===== */
    .top-products-carousel-wrapper {
        position: relative;
        padding: 0 44px;
    }
    .top-products-track {
        display: flex;
        gap: 14px;
        overflow-x: hidden;
        scroll-behavior: smooth;
        padding: 4px 2px 12px;
    }
    .landing-product-card {
        flex: 0 0 190px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.2s, transform 0.2s;
        overflow: hidden;
    }
    .landing-product-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        transform: translateY(-3px);
        border-color: #ddd;
    }
    .landing-card-img {
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        padding: 10px;
    }
    .landing-card-img img {
        max-width: 100%; max-height: 100%;
        object-fit: contain;
    }
    .landing-card-body {
        padding: 10px 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .landing-card-title {
        font-size: 0.82rem;
        line-height: 1.4;
        color: #333;
        height: 2.3rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .landing-card-price {
        font-size: 1.05rem;
        font-weight: 800;
        color: #f68b1e;
    }
    .landing-card-state {
        font-size: 0.7rem;
        color: #999;
    }

    /* ===== CAROUSEL ARROWS ===== */
    .landing-carousel-arrow {
        position: absolute;
        top: 40%; transform: translateY(-50%);
        width: 34px; height: 34px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        color: #333;
        transition: box-shadow 0.2s;
        z-index: 10;
    }
    .landing-carousel-arrow:hover { box-shadow: 0 4px 14px rgba(0,0,0,0.18); }
    .landing-carousel-arrow.left { left: 4px; }
    .landing-carousel-arrow.right { right: 4px; }

    /* ===== PRODUCTS MAIN GRID ===== */
    .landing-products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
        margin-bottom: 1.75rem;
    }
    .landing-products-count {
        font-size: 0.85rem;
        color: #666;
    }
    .landing-sort-select {
        padding: 0.4rem 0.9rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 0.85rem;
        outline: none;
        background: #fff;
    }
    /* Section des annonces */
    .landing-products-section {
        margin-top: 1rem;
    }
    .landing-products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
        gap: 0.85rem;
        margin-bottom: 1.5rem;
    }
    .landing-grid-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 10px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .landing-grid-card:hover {
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        transform: translateY(-3px);
        border-color: #ddd;
    }
    .landing-grid-card-img {
        height: 150px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }
    .landing-grid-card-img img {
        max-width: 100%; max-height: 100%;
        object-fit: contain;
    }
    .landing-grid-card-body {
        padding: 10px 12px 12px;
        display: flex;
        flex-direction: column;
        gap: 5px;
        flex: 1;
    }
    .landing-grid-card-title {
        font-size: 0.8rem;
        line-height: 1.35;
        color: #333;
        height: 2.2rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .landing-grid-card-price {
        font-size: 1rem;
        font-weight: 800;
        color: #ff8c00;
    }
    .landing-grid-card-state {
        font-size: 0.72rem;
        color: #888;
    }
    .landing-grid-card-seller {
        font-size: 0.7rem;
        color: #777;
        margin-top: auto;
    }
    .pro-badge {
        display: inline-block;
        background: #f4f4f4;
        color: #555;
        font-size: 0.6rem;
        font-weight: 700;
        padding: 1px 5px;
        border-radius: 4px;
        border: 1px solid #ddd;
        text-transform: uppercase;
        margin-left: 3px;
        vertical-align: middle;
    }

    /* ===== EMPTY STATE ===== */
    .landing-empty {
        text-align: center;
        padding: 5rem 2rem;
        color: #999;
    }
    .landing-empty i {
        font-size: 3rem;
        margin-bottom: 1rem;
        display: block;
        color: #ddd;
    }

    @media (max-width: 768px) {
        .landing-hero img { max-height: 100px; }
        .landing-hero-title { font-size: 1.15rem; }
        .landing-hero-subtitle { font-size: 0.95rem; }
        .landing-hero-maintitle { font-size: 1.35rem !important; }
        .landing-hero-overlay { padding: 0.8rem; }
        .landing-products-grid { grid-template-columns: repeat(2, 1fr); gap: 0.6rem; }
        .landing-grid-card-img { height: 130px; }
    }
    @media (max-width: 480px) {
        /* 2 colonnes compactes sur téléphone (au lieu d'une grande carte) */
        .landing-products-grid { grid-template-columns: repeat(2, 1fr); gap: 0.55rem; }
        .landing-grid-card-img { height: 115px; padding: 8px; }
        .landing-grid-card-body { padding: 8px 10px 10px; }
        .landing-grid-card-title { font-size: 0.75rem; }
        .landing-grid-card-price { font-size: 0.92rem; }
    }

    /* ===== RAKUTEN STYLE TABS ===== */
    .rakuten-tabs-section {
        margin-top: 4rem;
        padding: 3rem 0;
        background: #fdf6ec; /* Very light warm peach background like Rakuten */
        border-radius: 20px;
    }
    .rakuten-tabs-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    .rakuten-tabs-nav {
        display: flex;
        gap: 15px;
        margin-bottom: 2.5rem;
        justify-content: center;
    }
    .rakuten-tab-btn {
        background: #fff;
        border: 2px solid #fff;
        padding: 14px 40px;
        border-radius: 12px;
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #333;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        font-size: 1rem;
    }
    .rakuten-tab-btn i { font-size: 1.2rem; color: #333; opacity: 0.7; }
    .rakuten-tab-btn.active {
        background: #fff4e6;
        border-color: #f68b1e;
        color: #333;
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.1);
    }
    .rakuten-tab-btn.active i { color: #f68b1e; opacity: 1; }

    /* Secondary Category Tabs */
    .rakuten-pref-headline {
        text-align: center;
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 2rem;
        color: #333;
    }
    .rakuten-sub-tabs {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-bottom: 3rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        padding-bottom: 5px;
    }
    .rakuten-sub-tab-btn {
        background: none;
        border: none;
        padding: 10px 0;
        font-weight: 600;
        color: #666;
        cursor: pointer;
        font-size: 1.05rem;
        position: relative;
        transition: all 0.3s;
    }
    .rakuten-sub-tab-btn.active {
        color: #333;
    }
    .rakuten-sub-tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 100%;
        height: 3px;
        background: #333;
        border-radius: 10px;
    }

    .rakuten-tab-content {
        display: none;
    }
    .rakuten-tab-content.active {
        display: block;
        animation: fadeIn 0.4s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .rakuten-grid {
        display: flex;
        gap: 15px;
        overflow-x: auto;
        padding: 10px 5px 20px;
        scroll-behavior: smooth;
        scrollbar-width: none;
    }
    .rakuten-grid::-webkit-scrollbar { display: none; }

    .rakuten-card {
        flex: 0 0 200px;
        background: #fff;
        border-radius: 14px;
        padding: 12px;
        text-decoration: none;
        color: inherit;
        border: 1px solid #fff;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .rakuten-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        border-color: #f68b1e;
    }
    .rakuten-card-img {
        height: 160px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }
    .rakuten-card-img img {
        max-width: 100%; max-height: 100%;
        object-fit: contain;
    }
    .rakuten-card-title {
        font-size: 0.85rem;
        font-weight: 500;
        line-height: 1.4;
        height: 2.4rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        margin-bottom: 8px;
    }
    .rakuten-card-price {
        color: #f68b1e;
        font-weight: 800;
        font-size: 1.1rem;
    }
    .rakuten-sub-content {
        display: none;
    }
    .rakuten-sub-content.active {
        display: block;
        animation: fadeIn 0.4s ease;
    }
</style>
@endpush

@section('content')

{{-- HERO BANNER --}}
@php
    $heroImg = $banner->landing_page_image ?? $banner->image_url;
@endphp
<div class="landing-hero" style="background-image: url('{{ $heroImg }}');">
    <div class="landing-hero-content">
        <p class="landing-hero-subtitle landing-hero-maintitle" style="font-weight: 700; font-style: normal; font-size: 1.8rem; margin-bottom: 5px;">{{ $banner->description ?? 'Profitez de nos offres exceptionnelles' }}</p>
        
        <div class="n1-banner-search-wrapper">
            <i class="fas fa-search n1-banner-search-icon"></i>
            <input type="text" id="n1-page-search" class="n1-banner-search-input" placeholder="Rechercher dans cette offre..." oninput="handleInPageSearch(this.value)">
        </div>
    </div>
</div>

{{-- BREADCRUMB --}}
<div class="landing-breadcrumb">
    <div style="max-width: 1300px; margin: 0 auto; padding: 0 1.5rem;">
        <a href="{{ route('home') }}">Accueil</a>
        @if($category && $category->parent)
            <span>›</span>
            <a href="{{ route('search.index', ['category' => $category->parent->slug]) }}">{{ $category->parent->nom }}</a>
        @endif
        @if($category)
            <span>›</span>
            <a href="{{ route('search.index', ['category' => $category->slug]) }}">{{ $category->nom }}</a>
        @endif
    </div>
</div>

<div class="landing-body">


    {{-- GRILLE PRINCIPALE --}}
    <div class="landing-products-section">
        <div class="landing-products-header" style="justify-content: flex-end;">
            <div style="flex: 1;">
                <div class="landing-products-count">{{ $annonces->total() }} produit(s) trouvé(s)</div>
            </div>
            <select class="landing-sort-select" onchange="window.location.href='?sort='+this.value">
                <option value="relevance" {{ !request('sort') || request('sort') == 'relevance' ? 'selected' : '' }}>Pertinence</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
            </select>
        </div>

        <div class="landing-products-grid">
            @forelse($annonces as $annonce)
                <a href="{{ route('annonces.show', $annonce->slug) }}" class="landing-grid-card global-filter-item">
                    <div class="landing-grid-card-img">
                        @if($annonce->photoPrincipale())
                            <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                        @else
                            <span style="color:#ccc; font-size:0.75rem;">Pas de photo</span>
                        @endif
                    </div>
                    <div class="landing-grid-card-body">
                        <div class="landing-grid-card-title">{{ $annonce->titre }}</div>
                        <div class="landing-grid-card-state">{{ $annonce->produit ? ucfirst($annonce->produit->etat) : 'Neuf' }}</div>
                        <div class="landing-grid-card-price">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</div>
                        @if($annonce->vendeur && $annonce->vendeur->type === 'professionnel')
                            <div class="landing-grid-card-seller">
                                Par {{ $annonce->vendeur->professionnel->nom_entreprise ?? 'Boutique' }}
                                <span class="pro-badge">PRO</span>
                            </div>
                        @endif
                    </div>
                </a>
            @empty
                <div class="landing-empty" style="grid-column:1/-1;">
                    <i class="fas fa-box-open"></i>
                    Aucun produit disponible dans cette catégorie pour le moment.
                </div>
            @endforelse
        </div>

        <div style="display:flex; justify-content:center; margin-top: 2rem;">
            {{ $annonces->links() }}
        </div>
    </div>

</div>


@endsection

@push('scripts')
<script>
function landingCarouselScroll(id, direction) {
    const track = document.getElementById(id);
    if (!track) return;
    const card = track.querySelector('.landing-product-card');
    const width = card ? card.offsetWidth + 14 : 204;
    track.scrollBy({ left: direction * width * 3, behavior: 'smooth' });
}

function handleInPageSearch(query) {
    const q = query.toLowerCase().trim();
    const items = document.querySelectorAll('.global-filter-item');
    
    items.forEach(item => {
        const titleEl = item.querySelector('.landing-grid-card-title, .landing-card-title');
        if (!titleEl) return;
        
        const title = titleEl.innerText.toLowerCase();
        if (title.includes(q)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
@endpush
