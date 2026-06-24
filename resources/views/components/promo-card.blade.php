@props(['annonce'])

<div class="promo-card">
    <a href="{{ route('annonces.show', $annonce->slug) }}" class="promo-link">
        <div class="promo-badge">
            <span class="badge-soldes">SOLDES</span>
            <span class="badge-top">à top offres</span>
        </div>
        
        <div class="promo-content">
            <div class="promo-info">
                <h3 class="promo-title">{{ $annonce->titre }}</h3>
                
                <div class="promo-delivery">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 18.5a1.5 1.5 0 01-1.5-1.5 1.5 1.5 0 011.5-1.5 1.5 1.5 0 011.5 1.5 1.5 1.5 0 01-1.5 1.5m1.5-9l1.96 2.5H17V9.5m-11 9A1.5 1.5 0 014.5 17 1.5 1.5 0 016 15.5 1.5 1.5 0 017.5 17 1.5 1.5 0 016 18.5M20 8h-3V4H3c-1.11 0-2 .89-2 2v11h2a3 3 0 003 3 3 3 0 003-3h6a3 3 0 003 3 3 3 0 003-3h2v-5l-3-4z"/>
                    </svg>
                    <span>Livraison <strong>gratuite</strong></span>
                </div>
                
                <div class="promo-pricing">
                    @php
                        if ($annonce->estEnPromo()) {
                            $originalPrice = $annonce->prix_original;
                            $discount = $annonce->prix_original - $annonce->prix;
                        } else {
                            $originalPrice = $annonce->prix_affiche * 1.15;
                            $discount = $originalPrice - $annonce->prix_affiche;
                        }
                    @endphp
                    <div class="price-row">
                        <span class="price-original">{{ number_format($originalPrice, 0, ',', ' ') }} FCFA</span>
                        <span class="price-discount">-{{ number_format($discount, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <p class="price-label">à partir de</p>
                    <div class="price-main-promo">{{ number_format($annonce->prix_affiche, 0, ',', ' ') }}<span class="price-currency">FCFA</span></div>
                </div>
            </div>
            
            <div class="promo-image">
                @if($annonce->photoPrincipale())
                    <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" alt="{{ $annonce->titre }}">
                @else
                    <div class="no-photo-promo">Pas de photo</div>
                @endif
            </div>
        </div>
    </a>
</div>

@once
@push('styles')
<style>
    .promo-card {
        background: #f5f5f5;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .promo-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    
    .promo-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }
    
    .promo-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .badge-soldes {
        background: #e60000;
        color: white;
        font-size: 0.9rem;
        font-weight: 900;
        padding: 6px 12px;
        border-radius: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .badge-top {
        background: white;
        color: #e60000;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 4px 8px;
        border-radius: 4px;
        border: 1px solid #e60000;
    }
    
    .promo-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
        padding: 2rem 0.75rem 0.25rem 0.75rem;
        min-height: 150px;
    }
    
    .promo-info {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }
    
    .promo-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #333;
        margin: 0;
        line-height: 1.2;
    }
    
    .promo-subtitle {
        font-size: 0.7rem;
        color: #666;
        margin: 0;
        line-height: 1.2;
    }
    
    .promo-delivery {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.7rem;
        color: #333;
    }
    
    .promo-delivery svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
    }
    
    .promo-pricing {
        margin-top: auto;
    }
    
    .price-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.25rem;
    }
    
    .price-original {
        font-size: 0.8rem;
        color: #999;
        text-decoration: line-through;
    }
    
    .price-discount {
        background: #0066cc;
        color: white;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 3px 6px;
        border-radius: 3px;
    }
    
    .price-label {
        font-size: 0.65rem;
        color: #666;
        margin: 0.15rem 0;
    }
    
    .price-main-promo {
        font-size: 1.8rem;
        font-weight: 900;
        color: #e60000;
        line-height: 1;
        margin: 0.15rem 0;
    }
    
    .price-currency {
        font-size: 1.2rem;
        vertical-align: super;
    }
    
    .price-club {
        font-size: 0.7rem;
        color: #333;
        margin: 0.3rem 0 0 0;
    }
    
    .promo-image {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
    }
    
    .promo-image img {
        max-width: 100%;
        max-height: 110px;
        object-fit: contain;
    }
    
    .no-photo-promo {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 110px;
        color: #ccc;
        font-size: 0.8rem;
    }
    
    .promo-footer {
        background: white;
        padding: 0.4rem 0.75rem;
        border-top: 1px solid #e0e0e0;
    }
    
    .delivery-date {
        font-size: 0.7rem;
        color: #0066cc;
        font-weight: 600;
        margin: 0;
        text-align: center;
    }
    
    @media (max-width: 768px) {
        .promo-content {
            grid-template-columns: 1fr;
            min-height: auto;
        }
        
        .price-main-promo {
            font-size: 2.5rem;
        }
    }
</style>
@endpush
@endonce
