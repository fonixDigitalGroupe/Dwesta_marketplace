@extends('layouts.app')

@section('title', 'Offre : ' . $coupon->code . ' - Karnou')

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
        max-height: 280px; 
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
        font-size: 2.2rem;
        font-weight: 800;
        color: #fff;
        margin: 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.5);
        text-align: center;
    }

    /* ===== BREADCRUMB ===== */
    .landing-breadcrumb {
        background: #f8fafc;
        border-bottom: 1px solid #eff3f6;
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

    /* ===== SECTIONS ===== */
    .landing-top-section { margin-bottom: 3rem; }
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

    /* ===== CAROUSELS & GRIDS (REUSED FROM BANNERS) ===== */
    .top-products-carousel-wrapper { position: relative; padding: 0 44px; }
    .top-products-track { display: flex; gap: 14px; overflow-x: hidden; scroll-behavior: smooth; padding: 4px 2px 12px; }
    .landing-product-card {
        flex: 0 0 190px; background: #fff; border: 1px solid #eee; border-radius: 10px;
        text-decoration: none; color: inherit; display: flex; flex-direction: column; transition: all 0.2s; overflow: hidden;
    }
    .landing-product-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.08); transform: translateY(-3px); }
    .landing-card-img { height: 160px; display: flex; align-items: center; justify-content: center; background: #fff; padding: 10px; }
    .landing-card-img img { max-width: 100%; max-height: 100%; object-fit: contain; }
    .landing-card-body { padding: 10px 12px 14px; display: flex; flex-direction: column; gap: 5px; }
    .landing-card-title { font-size: 0.82rem; line-height: 1.4; color: #333; height: 2.3rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .landing-card-price { font-size: 1.05rem; font-weight: 800; color: #f68b1e; }
    
    /* Arrows */
    .landing-carousel-arrow {
        position: absolute; top: 40%; transform: translateY(-50%); width: 34px; height: 34px;
        background: #fff; border: 1px solid #ddd; border-radius: 50%; display: flex; align-items: center; justify-content: center;
        cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,0.12); z-index: 10;
    }
    .landing-carousel-arrow.left { left: 4px; }
    .landing-carousel-arrow.right { right: 4px; }

    /* Grid */
    .landing-products-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 1rem; margin-bottom: 1.75rem; }
    .landing-products-count { font-size: 0.85rem; color: #666; }
    .landing-products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(210px, 1fr)); gap: 1rem; margin-bottom: 3rem; }
    .landing-grid-card { background: #fff; border: 1px solid #eee; border-radius: 10px; overflow: hidden; text-decoration: none; color: inherit; display: flex; flex-direction: column; transition: all 0.2s; }
    .landing-grid-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.08); transform: translateY(-3px); }
    .landing-grid-card-img { height: 200px; display: flex; align-items: center; justify-content: center; padding: 12px; }
    .landing-grid-card-img img { max-width: 100%; max-height: 100%; object-fit: contain; }
    .landing-grid-card-body { padding: 12px 14px 16px; display: flex; flex-direction: column; gap: 6px; flex: 1; }
    .landing-grid-card-price { font-size: 1.15rem; font-weight: 800; color: #f68b1e; }

    /* RAKUTEN STYLE TABS */
    .rakuten-tabs-section { margin-top: 4rem; padding: 3rem 0; background: #fdf6ec; border-radius: 20px; }
    .rakuten-tabs-nav { display: flex; gap: 15px; margin-bottom: 2.5rem; justify-content: center; }
    .rakuten-tab-btn { background: #fff; border: 2px solid #fff; padding: 12px 30px; border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all 0.2s; box-shadow: 0 4px 12px rgba(0,0,0,0.03); }
    .rakuten-tab-btn.active { border-color: #f68b1e; background: #fff4e6; }
    .rakuten-grid { display: flex; gap: 15px; overflow-x: auto; padding: 10px 5px 20px; scrollbar-width: none; }
    .rakuten-card { flex: 0 0 200px; background: #fff; border-radius: 14px; padding: 12px; text-decoration: none; color: inherit; border: 1px solid #fff; transition: all 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    .rakuten-card:hover { transform: translateY(-5px); border-color: #f68b1e; }
    .rakuten-card-img { height: 150px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; }
    .rakuten-card-img img { max-width: 100%; max-height: 100%; object-fit: contain; }
</style>
@endpush

@section('content')

{{-- HERO BANNER --}}
<div class="landing-hero">
    @if($coupon->landing_page_image)
        <img src="{{ Storage::url($coupon->landing_page_image) }}" alt="{{ $coupon->code }}">
    @else
        <div class="landing-hero-overlay" style="background: linear-gradient(135deg, #f68b1e 0%, #e77600 100%); min-height: 200px; width: 100%;">
            <h1 class="landing-hero-title">OFFRE SPÉCIALE : {{ $coupon->code }}</h1>
            <p style="color: white; font-weight: 600; font-size: 1.2rem; margin-top: 10px;">
                {{ $coupon->type === 'percent' ? '-' . $coupon->value . '%' : '-' . number_format($coupon->value, 0) . ' FCFA' }} de remise !
            </p>
        </div>
    @endif
</div>

{{-- BREADCRUMB --}}
<div class="landing-breadcrumb">
    <div style="max-width: 1300px; margin: 0 auto; padding: 0 1.5rem;">
        <a href="{{ route('home') }}">Accueil</a>
        <span>›</span>
        @if($category)
            <a href="{{ route('search.index', ['category' => $category->slug]) }}">{{ $category->nom }}</a>
            <span>›</span>
        @endif
        <span style="color: #333;">Promotion {{ $coupon->code }}</span>
    </div>
</div>

<div class="landing-body">

    {{-- TOP PRODUITS LES PLUS CONSULTÉS --}}
    @if($topConsultes->count() > 0)
    <div class="landing-top-section">
        <h2 class="landing-section-title">Les favoris du moment</h2>
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
                            @endif
                        </div>
                        <div class="landing-card-body">
                            <div class="landing-card-title">{{ $annonce->titre }}</div>
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
                <h2 class="landing-section-title" style="margin-bottom:0; border-bottom:none; padding-bottom:0;">Sélectionnée pour vous</h2>
                <div class="landing-products-count">{{ $annonces->total() }} produit(s)</div>
            </div>
        </div>

        <div class="landing-products-grid">
            @forelse($annonces as $annonce)
                <a href="{{ route('annonces.show', $annonce->slug) }}" class="landing-grid-card">
                    <div class="landing-grid-card-img">
                        @if($annonce->photoPrincipale())
                            <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                        @endif
                    </div>
                    <div class="landing-grid-card-body">
                        <div class="landing-grid-card-title">{{ $annonce->titre }}</div>
                        <div class="landing-grid-card-price">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</div>
                    </div>
                </a>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: #999;">
                    Aucun produit ne correspond à cette promotion pour le moment.
                </div>
            @endforelse
        </div>

        <div style="display:flex; justify-content:center;">
            {{ $annonces->links() }}
        </div>
    </div>

</div>

{{-- RAKUTEN STYLE TABS --}}
@if($produitsNeufs->count() > 0 || $produitsOccasion->count() > 0)
<div class="rakuten-tabs-section">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1.5rem;">
        <div class="rakuten-tabs-nav">
            <button class="rakuten-tab-btn active" onclick="switchRakutenTab('tab-neuf', this)">
                <i class="fas fa-box"></i> Tout le Neuf
            </button>
            <button class="rakuten-tab-btn" onclick="switchRakutenTab('tab-occasion', this)">
                <i class="fas fa-recycle"></i> Reconditionné
            </button>
        </div>

        <div id="tab-neuf" class="rakuten-tab-content" style="display: block;">
            <div class="rakuten-grid">
                @foreach($produitsNeufs as $p)
                    <a href="{{ route('annonces.show', $p->slug) }}" class="rakuten-card">
                        <div class="rakuten-card-img">
                            @if($p->photoPrincipale())
                                <img src="{{ Storage::url($p->photoPrincipale()->chemin) }}" alt="{{ $p->titre }}">
                            @endif
                        </div>
                        <div style="font-size: 0.8rem; height: 2.2rem; overflow: hidden; margin-bottom: 5px;">{{ $p->titre }}</div>
                        <div style="color: #f68b1e; font-weight: 800;">{{ number_format($p->prix, 0, ',', ' ') }} FCFA</div>
                    </a>
                @endforeach
            </div>
        </div>

        <div id="tab-occasion" class="rakuten-tab-content" style="display: none;">
            <div class="rakuten-grid">
                @foreach($produitsOccasion as $p)
                    <a href="{{ route('annonces.show', $p->slug) }}" class="rakuten-card">
                        <div class="rakuten-card-img">
                            @if($p->photoPrincipale())
                                <img src="{{ Storage::url($p->photoPrincipale()->chemin) }}" alt="{{ $p->titre }}">
                            @endif
                        </div>
                        <div style="font-size: 0.8rem; height: 2.2rem; overflow: hidden; margin-bottom: 5px;">{{ $p->titre }}</div>
                        <div style="color: #f68b1e; font-weight: 800;">{{ number_format($p->prix, 0, ',', ' ') }} FCFA</div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
function landingCarouselScroll(id, direction) {
    const track = document.getElementById(id);
    const width = 204;
    track.scrollBy({ left: direction * width * 3, behavior: 'smooth' });
}
function switchRakutenTab(id, btn) {
    document.querySelectorAll('.rakuten-tab-content').forEach(c => c.style.display = 'none');
    document.querySelectorAll('.rakuten-tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById(id).style.display = 'block';
    btn.classList.add('active');
}
</script>
@endpush
