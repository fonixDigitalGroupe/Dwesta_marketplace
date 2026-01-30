@props(['annonce'])

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
            <div class="item-sponsor">{{ $annonce->estALaUne() ? 'Sponsorisée' : '' }}</div>
            <h3 class="item-title">{{ $annonce->titre }}</h3>
            <div class="item-brand">- {{ $annonce->categorie->nom ?? 'Produit' }}</div>
            <div class="item-rating">
                <div class="stars">
                    @for($i = 0; $i < 5; $i++)
                        <svg width="14" height="14" fill="#ffc107" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    @endfor
                </div>
                <span class="rating-count">{{ 100 + ($annonce->id * 7) % 500 }} avis</span>
            </div>
            <div class="item-pricing">
                <span class="price-main">{{ number_format($annonce->prix, 2, ',', ' ') }} €</span>
                <span class="condition">. Neuf</span>
            </div>
            <div class="item-seller">
                Par <span class="seller-name">{{ $annonce->vendeur->user->prenom ?? 'Vendeur' }} {{ $annonce->vendeur->user->nom ?? 'PRO' }}</span>
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

@once
@push('styles')
<style>
    .catalog-item {
        background: #fff;
        border-right: 1px solid #ebebeb;
        border-bottom: 1px solid #ebebeb;
        display: flex;
        flex-direction: column;
        padding-bottom: 1rem;
        height: 100%;
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

    .item-content {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .item-sponsor {
        font-size: 0.7rem;
        color: #999;
        margin-bottom: 0.2rem;
        height: 1rem;
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
</style>
@endpush
@endonce
