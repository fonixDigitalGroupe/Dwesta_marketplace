@extends('layouts.app')

@section('title', $banner->title . ' - Karnou')

@push('styles')
<style>
    body { overflow-x: hidden; background-color: #fff !important; }

    /* ===== HERO BANNER ===== */
    .landing-hero {
        width: 100%;
        position: relative;
        background: #fff;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .landing-hero img {
        width: 100%;
        max-height: 220px; /* Aligned with category hero height */
        object-fit: cover;
        object-position: center;
        display: block;
    }
    .landing-hero-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        background: rgba(0,0,0,0.25);
    }
    .landing-hero-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.8rem;
        font-weight: 800;
        color: #fff;
        margin: 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        text-align: center;
    }
    .landing-hero-subtitle {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.95);
        margin-top: 4px;
        text-align: center;
    }

    /* ===== BREADCRUMB ===== */
    .landing-breadcrumb {
        background: #fff;
        border-bottom: 1px solid #eee;
        padding: 0.6rem 0;
        font-size: 0.8rem;
        color: #888;
    }
    .landing-breadcrumb a { color: #555; text-decoration: none; }
    .landing-breadcrumb a:hover { color: #f68b1e; }
    .landing-breadcrumb span { margin: 0 6px; }

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
    .landing-products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: 1rem;
        margin-bottom: 3rem;
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
        height: 200px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 12px;
    }
    .landing-grid-card-img img {
        max-width: 100%; max-height: 100%;
        object-fit: contain;
    }
    .landing-grid-card-body {
        padding: 12px 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        flex: 1;
    }
    .landing-grid-card-title {
        font-size: 0.875rem;
        line-height: 1.4;
        color: #333;
        height: 2.45rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .landing-grid-card-price {
        font-size: 1.15rem;
        font-weight: 800;
        color: #f68b1e;
    }
    .landing-grid-card-state {
        font-size: 0.75rem;
        color: #888;
    }
    .landing-grid-card-seller {
        font-size: 0.72rem;
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
        .landing-hero-subtitle { font-size: 0.75rem; }
        .landing-hero-overlay { padding: 0.8rem; }
        .landing-products-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 480px) {
        .landing-products-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')

{{-- HERO BANNER --}}
<div class="landing-hero">
    @if($banner->landing_page_image)
        <img src="{{ $banner->landing_page_image }}" alt="{{ $banner->title }}">
    @elseif($banner->image_url)
        <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}">
    @endif
</div>

{{-- BREADCRUMB --}}
<div class="landing-breadcrumb">
    <div style="max-width: 1300px; margin: 0 auto; padding: 0 1.5rem;">
        <a href="{{ route('home') }}">Accueil</a>
        <span>›</span>
        @if($category && $category->parent)
            <a href="{{ route('search.index', ['category' => $category->parent->slug]) }}">{{ $category->parent->nom }}</a>
            <span>›</span>
        @endif
        @if($category)
            <a href="{{ route('search.index', ['category' => $category->slug]) }}">{{ $category->nom }}</a>
            <span>›</span>
        @endif
        <span style="color: #333;">{{ $banner->title }}</span>
    </div>
</div>

<div class="landing-body">

    {{-- TOP PRODUITS LES PLUS CONSULTÉS --}}
    @if($topConsultes->count() > 0)
    <div class="landing-top-section">
        <h2 class="landing-section-title">Top dans cette catégorie</h2>
        <div class="top-products-carousel-wrapper">
            <button class="landing-carousel-arrow left" onclick="landingCarouselScroll('landing-top-track', -1)">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="top-products-track" id="landing-top-track">
                @foreach($topConsultes as $annonce)
                    <a href="{{ route('annonces.show', $annonce->slug) }}" class="landing-product-card">
                        <div class="landing-card-img">
                            @if($annonce->photoPrincipale())
                                <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                            @else
                                <span style="color:#ddd; font-size:0.75rem;">Pas de photo</span>
                            @endif
                        </div>
                        <div class="landing-card-body">
                            <div class="landing-card-title">{{ $annonce->titre }}</div>
                            <div class="landing-card-state">{{ $annonce->produit ? ucfirst($annonce->produit->etat) : 'Neuf' }}</div>
                            <div class="landing-card-price">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</div>
                        </div>
                    </a>
                @endforeach
            </div>
            <button class="landing-carousel-arrow right" onclick="landingCarouselScroll('landing-top-track', 1)">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div>
    </div>
    @endif

    {{-- GRILLE PRINCIPALE --}}
    <div>
        <div class="landing-products-header">
            <div>
                <h2 class="landing-section-title" style="margin-bottom:0; border-bottom:none; padding-bottom:0;">Notre sélection complète</h2>
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
                <a href="{{ route('annonces.show', $annonce->slug) }}" class="landing-grid-card">
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
</script>
@endpush
