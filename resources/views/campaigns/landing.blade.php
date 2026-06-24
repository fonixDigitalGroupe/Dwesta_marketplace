@extends('layouts.app')

@section('title', $campaign->title . ' - Karnou')

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
        grid-template-columns: repeat(auto-fill, minmax(175px, 1fr));
        gap: 0.85rem;
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
    .landing-grid-card-price-container {
        display: flex;
        align-items: baseline;
        gap: 8px;
        flex-wrap: wrap;
    }
    .landing-grid-card-price {
        font-size: 1rem;
        font-weight: 800;
        color: #ff8c00;
    }
    .landing-grid-card-old-price {
        font-size: 0.85rem;
        color: #999;
        text-decoration: line-through;
    }
    .landing-grid-card-discount {
        font-size: 0.75rem;
        font-weight: 700;
        color: #d32f2f;
        background: #ffebee;
        padding: 2px 6px;
        border-radius: 4px;
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

    .landing-breadcrumb-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 1.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .campaign-timer-container {
        display: inline-flex;
        gap: 12px;
        align-items: center;
    }
    .timer-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 48px;
        padding: 6px 8px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(246, 139, 30, 0.12);
        border: 1px solid rgba(246, 139, 30, 0.1);
        transition: transform 0.2s;
    }
    .timer-val {
        font-family: 'Outfit', sans-serif;
        font-size: 1.3rem;
        font-weight: 900;
        background: linear-gradient(135deg, #f68b1e 0%, #e74c3c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1.1;
        display: block;
    }
    .timer-label {
        font-size: 0.65rem;
        font-weight: 700;
        color: #999;
        text-transform: uppercase;
        margin-top: 1px;
        letter-spacing: 0.5px;
    }
    .timer-expired-msg {
        padding: 4px 12px;
        background: #ffebee;
        color: #d32f2f;
        font-weight: 700;
        border-radius: 6px;
        font-size: 0.8rem;
        border: 1px solid #ffcdd2;
    }

    @keyframes heartbeat {
        0% { transform: scale(1); }
        50% { transform: scale(1.08); }
        100% { transform: scale(1); }
    }
    #seconds {
        display: inline-block;
        animation: heartbeat 1s infinite ease-in-out;
    }

    @media (max-width: 768px) {
        .campaign-timer-container { margin-top: 8px; gap: 8px; }
        .timer-item { min-width: 42px; padding: 4px 6px; }
        .timer-val { font-size: 1.1rem; }
    }
</style>
@endpush

@section('content')

{{-- HERO BANNER --}}
@php
    $heroImg = $coupon->landing_page_image ? asset('storage/' . $coupon->landing_page_image) : asset('images/default-campaign.jpg');
@endphp
<div class="landing-hero" style="background-image: url('{{ $heroImg }}');">
    <div class="landing-hero-content">
        <p class="landing-hero-subtitle" style="font-weight: 700; font-style: normal; font-size: 1.6rem; margin-bottom: 5px;">{{ $campaign->title }}</p>
        <p class="landing-hero-subtitle" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.5); color: #fff;">
            @php
                $discountText = ($coupon->type === 'percent' ? '-' . $coupon->value . '%' : '-' . number_format($coupon->value, 0) . ' FCFA') . ' de remise !';
            @endphp
            {{ $discountText }}
        </p>
        
        <div class="n1-banner-search-wrapper">
            <i class="fas fa-search n1-banner-search-icon"></i>
            <input type="text" id="n1-page-search" class="n1-banner-search-input" placeholder="Rechercher dans cette offre..." oninput="handleInPageSearch(this.value)">
        </div>
    </div>
</div>

{{-- BREADCRUMB --}}
<div class="landing-breadcrumb">
    <div class="landing-breadcrumb-container">
        {{-- BREADCRUMB TEXT REMOVED AS REQUESTED --}}

        {{-- COUNTDOWN TIMER --}}
        @if($campaign->ends_at)
            <div id="campaign-countdown" class="campaign-timer-container" data-end="{{ $campaign->ends_at->format('Y-m-d H:i:s') }}">
                <div class="timer-item">
                    <span class="timer-val" id="days">00</span>
                    <span class="timer-label">Jours</span>
                </div>
                <div class="timer-item">
                    <span class="timer-val" id="hours">00</span>
                    <span class="timer-label">Heures</span>
                </div>
                <div class="timer-item">
                    <span class="timer-val" id="minutes">00</span>
                    <span class="timer-label">Min</span>
                </div>
                <div class="timer-item">
                    <span class="timer-val" id="seconds">00</span>
                    <span class="timer-label">Sec</span>
                </div>
            </div>
            <div id="timer-expired" class="timer-expired-msg" style="display: none;">
                <i class="fas fa-clock"></i> Expirée
            </div>
        @endif
    </div>
</div>

<div class="landing-body">

    {{-- GRILLE PRINCIPALE --}}
    <div>
        <div class="landing-products-header" style="justify-content: flex-end;">
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
                        <div class="landing-grid-card-price-container">
                            <div class="landing-grid-card-price">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</div>
                            @if($annonce->prix_original && $annonce->prix_original > $annonce->prix)
                                <div class="landing-grid-card-old-price">{{ number_format($annonce->prix_original, 0, ',', ' ') }} FCFA</div>
                                <div class="landing-grid-card-discount">-{{ $annonce->discount_percentage }}%</div>
                            @endif
                        </div>
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
function handleInPageSearch(query) {
    const q = query.toLowerCase().trim();
    const items = document.querySelectorAll('.global-filter-item');
    
    items.forEach(item => {
        const titleEl = item.querySelector('.landing-grid-card-title');
        if (!titleEl) return;
        
        const title = titleEl.innerText.toLowerCase();
        if (title.includes(q)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

// COUNTDOWN TIMER LOGIC
document.addEventListener('DOMContentLoaded', function() {
    const countdownEl = document.getElementById('campaign-countdown');
    if (!countdownEl) return;

    const endDateStr = countdownEl.getAttribute('data-end');
    if (!endDateStr) return;

    const endDate = new Promise((resolve) => {
        // Fix for Safari and different date formats
        const d = new Date(endDateStr.replace(/-/g, "/"));
        resolve(d.getTime());
    });

    endDate.then(endValue => {
        const timer = setInterval(function() {
            const now = new Date().getTime();
            const distance = endValue - now;

            if (distance < 0) {
                clearInterval(timer);
                countdownEl.style.display = 'none';
                const expiredMsg = document.getElementById('timer-expired');
                if (expiredMsg) expiredMsg.style.display = 'inline-block';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').innerText = days.toString().padStart(2, '0');
            document.getElementById('hours').innerText = hours.toString().padStart(2, '0');
            document.getElementById('minutes').innerText = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').innerText = seconds.toString().padStart(2, '0');
        }, 1000);
    });
});
</script>
@endpush
