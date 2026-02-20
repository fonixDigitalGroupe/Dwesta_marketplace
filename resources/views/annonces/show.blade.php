@extends('layouts.app')

@section('title', $annonce->titre)

@section('content')
<style>
    /* Global Reset & Fonts */
    .rakuten-page {
        font-family: "Rakuten Sans", "Rakuten Serif", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background-color: #ffffff;
        color: #333;
    }

    /* Breadcrumb */
    .rk-breadcrumb {
        font-size: 0.8rem;
        color: #777;
        padding: 1rem 0;
        max-width: 1280px;
        margin: 0 auto;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    .rk-breadcrumb a { color: #777; text-decoration: none; }
    .rk-breadcrumb a:hover { text-decoration: underline; }

    /* Main Grid */
    .rk-main-grid {
        display: grid;
        grid-template-columns: 80px 500px 1fr; /* Thumbnails | Main Image | Details */
        gap: 1.5rem;
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem 1rem 1rem;
        align-items: start;
    }

    /* Gallery Section */
    .rk-thumbnails {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .rk-thumb {
        width: 70px;
        height: 70px;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 2px;
        cursor: pointer;
        opacity: 0.7;
        transition: all 0.2s;
    }
    .rk-thumb.active {
        border-color: #bf0000;
        opacity: 1;
        box-shadow: 0 0 0 1px #bf0000;
    }
    .rk-thumb img { width: 100%; height: 100%; object-fit: contain; }

    .rk-main-image {
        width: 100%;
        height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        position: relative;
    }
    .rk-main-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .rk-wishlist-btn {
        position: absolute;
        top: 0;
        right: 0;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #666;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .rk-wishlist-btn:hover { color: #bf0000; border-color: #bf0000; }

    /* Details Section */
    .rk-details {
        padding-left: 1rem;
    }

    .rk-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.3;
        margin-bottom: 0.25rem;
    }
    .rk-brand { font-size: 0.9rem; color: #666; margin-bottom: 0.5rem; }
    
    .rk-subtitle {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 1rem;
    }
    .rk-link { color: #333; text-decoration: underline; font-size: 0.85rem; cursor: pointer; }

    /* Sales Banner */
    .rk-sales-banner {
        background: #bf0000;
        color: white;
        padding: 0.5rem 1rem;
        font-weight: 700;
        font-size: 0.95rem;
        border-radius: 4px;
        margin-bottom: 1rem;
        display: inline-block;
    }

    /* Ratings */
    .rk-rating-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 1rem;
    }
    .rk-stars { color: #ffc107; font-size: 0.9rem; }
    .rk-review-link { color: #777; font-size: 0.85rem; text-decoration: none; }
    .rk-sell-link {
        margin-left: auto;
        border: 1px solid #28a745;
        color: #28a745;
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
        text-decoration: none;
        border-radius: 4px;
        font-weight: 600;
    }
    .rk-sell-link:hover { background: #f0fff4; }

    /* Cleaned up Price Box & Actions */
    .rk-price-box {
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .rk-main-price {
        font-size: 2.5rem;
        font-weight: 800;
        color: #bf0000;
        line-height: 1;
        margin-bottom: 0;
    }

    .rk-actions {
        margin: 0;
    }
    
    .rk-btn-cart {
        width: auto;
        background: #bf0000;
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        font-size: 1rem;
        font-weight: 700;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        box-shadow: 0 4px 6px rgba(191, 0, 0, 0.2);
        margin-left: 1rem;
    }
    .rk-btn-cart:hover { background: #a00000; transform: translateY(-1px); }
    .rk-btn-cart:active { transform: translateY(1px); }

    /* Seller Info Card */
    .rk-seller-card {
        margin-top: 1.5rem;
        padding-top: 1rem; 
        border-top: 1px solid #eee;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .rk-seller-avatar {
        width: 40px; 
        height: 40px; 
        background: #f0f0f0; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-weight: bold;
        color: #666;
    }
    .rk-seller-info {
        flex: 1;
    }
    .rk-seller-name {
        font-weight: 700;
        color: #333;
        text-decoration: none;
        font-size: 1rem;
    }
    .rk-seller-rating {
        font-size: 0.85rem;
        color: #666;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .rk-main-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        .rk-thumbnails {
            flex-direction: row;
            order: 2;
        }
        .rk-main-image {
            height: 350px;
            order: 1;
        }
        .rk-details {
            order: 3;
            padding-left: 0;
        }
    }

    /* Product Content Tabs (Integrated) */
    .rk-content-section {
        margin-top: 1rem;
        margin-bottom: 2rem;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
    }
    .rk-section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .rk-description-text {
        font-size: 0.9rem;
        line-height: 1.5;
        color: #555;
        margin-bottom: 1.5rem;
    }
    .rk-specs-horizontal {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        font-size: 0.85rem;
    }
    .rk-spec-item {
        color: #333;
    }
    .rk-spec-label {
        color: #666;
    }
    .rk-spec-value {
        font-weight: 600;
        color: #333;
    }
    .rk-spec-separator {
        color: #ccc;
        font-size: 0.8rem;
    }

    /* Best Offers Section */
    .rk-best-offers {
        background-color: #f4f6f8;
        padding: 3rem 1rem;
        margin-top: 0; 
        border-top: 1px solid #e0e0e0;
    }
    .rk-section-header {
        max-width: 1280px;
        margin: 0.5rem auto 0.5rem auto;
        padding-left: 1rem;
    }
    .rk-offers-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
    }
</style>

<div class="rakuten-page">
    <!-- Breadcrumb -->
    <nav class="rk-breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> &gt; 
        @if($annonce->category)
            <a href="{{ route('categories.show', $annonce->category->slug) }}">{{ $annonce->category->nom }}</a> &gt;
        @endif
        @if($annonce->produit && $annonce->produit->marque)
           <span>{{ $annonce->produit->marque }}</span> &gt;
        @endif
        <span>{{ $annonce->titre }}</span>
    </nav>

    <div class="rk-main-grid">
        <!-- Left: Thumbnails -->
        <div class="rk-thumbnails">
            @if($annonce->photos->count() > 0)
                @foreach($annonce->photos as $photo)
                    <div class="rk-thumb {{ $loop->first ? 'active' : '' }}" onclick="updateGallery('{{ $photo->url }}', this)">
                        <img src="{{ $photo->thumbnail_url ?? $photo->url }}" alt="Vue {{ $loop->iteration }}">
                    </div>
                @endforeach
            @else
                 <div class="rk-thumb active">
                    <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:#f0f0f0; color:#ccc;">📷</div>
                </div>
            @endif
        </div>

        <!-- Center: Main Image -->
        <div class="rk-main-image">
            @php $photoPrincipale = $annonce->photoPrincipale(); @endphp
            <img id="display-image" src="{{ $photoPrincipale ? $photoPrincipale->url : asset('images/no-image.png') }}" alt="{{ $annonce->titre }}">
        </div>

        <!-- Right: Details -->
        <div class="rk-details">
            <!-- Header: Brand, Title, Stars -->
            <div style="margin-bottom: 1.5rem;">
                @if($annonce->produit && $annonce->produit->marque)
                    <div class="rk-brand">{{ $annonce->produit->marque }}</div>
                @endif
                <h1 class="rk-title">{{ $annonce->titre }}</h1>
                
                <div style="display: flex; align-items: center; gap: 1rem; margin-top: 0.5rem;">
                    <div class="rk-stars">
                        @for($i=1; $i<=5; $i++)
                            <i class="fas fa-star" style="{{ $i <= $annonce->note_moyenne ? '' : 'color: #ddd;' }}"></i>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Content: Description & Specs -->
            <div class="rk-content-section">
                <div style="font-weight: 700; margin-bottom: 0.5rem;">Description détaillée</div>
                <div class="rk-description-text" style="max-height: 150px; overflow-y: auto;">
                    {!! nl2br(e($annonce->description)) !!}
                </div>

                <div style="font-weight: 700; margin-bottom: 0.5rem;">Caractéristiques techniques</div>
                <div class="rk-specs-horizontal">
                    <div class="rk-spec-item">
                        <span class="rk-spec-label">État :</span>
                        <span class="rk-spec-value">{{ $annonce->produit->etat ?? 'Neuf' }}</span>
                    </div>
                    <div class="rk-spec-separator">|</div>
                    <div class="rk-spec-item">
                        <span class="rk-spec-label">Disponibilité :</span>
                        <span class="rk-spec-value">{{ ucfirst(str_replace('_', ' ', $annonce->disponibilite)) }}</span>
                    </div>
                     @if($annonce->category)
                    <div class="rk-spec-separator">|</div>
                    <div class="rk-spec-item">
                        <span class="rk-spec-label">Catégorie :</span>
                        <span class="rk-spec-value">{{ $annonce->category->nom }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Price & Action -->
            <div class="rk-price-box">
                <div class="rk-main-price" id="main-price">
                    {{ number_format($annonce->prix, 0, ',', ' ') }} €
                </div>
                
                <div class="rk-actions">
                    @if($annonce->peutEtreAchete())
                        <form action="{{ route('cart.store') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">
                        <input type="hidden" name="quantite" value="1">
                        <button type="submit" class="rk-btn-cart">
                            <i class="fas fa-shopping-cart" style="margin-right: 0.75rem;"></i> Ajouter au panier
                        </button>
                    </form>
                    @else
                        <a href="{{ auth()->check() ? route('conversations.create', ['recipient_id' => $annonce->vendeur->user_id, 'annonce_id' => $annonce->id]) : route('login') }}" class="rk-btn-cart" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; background: #000;">
                            <i class="fas fa-envelope" style="margin-right: 0.75rem;"></i> Contacter le vendeur
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Seller Info -->
            <div class="rk-seller-card">
                 <div class="rk-seller-info">
                     <div style="font-size: 0.8rem; color: #888; margin-bottom: 0.1rem;">Vendeur</div>
                     <a href="#" class="rk-seller-name">
                        @if($annonce->vendeur && $annonce->vendeur->professionnel)
                            {{ $annonce->vendeur->professionnel->nom_entreprise }}
                        @elseif($annonce->vendeur && $annonce->vendeur->user)
                            {{ $annonce->vendeur->user->prenom }}
                        @else
                            Vendeur inconnu
                        @endif
                     </a>
                 </div>
            </div>
        </div>
    </div>

    </div>

    <!-- Best Offers Section -->
    <div class="rk-section-header">
        <h2 class="rk-offers-title">Les meilleures offres de nos vendeurs professionnels</h2>
    </div>
    <div class="rk-best-offers">
        <div style="max-width: 1280px; margin: 0 auto; height: 100px; display: flex; align-items: center; justify-content: center; color: #999; font-style: italic;">
            <!-- Aucun produit pour le moment -->
        </div>
    </div>

    <!-- Clients Also Viewed Section -->
    <div class="rk-section-header">
        <h2 class="rk-offers-title">Les clients ayant vu ce produit ont également vu</h2>
    </div>
    <div class="rk-best-offers">
        <div style="max-width: 1280px; margin: 0 auto; height: 100px; display: flex; align-items: center; justify-content: center; color: #999; font-style: italic;">
             <!-- Placeholder -->
        </div>
    </div>

    <!-- Sponsored Products Section -->
    <div class="rk-section-header">
        <h2 class="rk-offers-title">Les clients ayant vu ce produit ont également aimé</h2>
    </div>
    <div class="rk-best-offers">
        <div style="max-width: 1280px; margin: 0 auto; height: 100px; display: flex; align-items: center; justify-content: center; color: #999; font-style: italic;">
             <!-- Placeholder -->
        </div>
    </div>
</div>

@push('scripts')
<script>
    const basePrice = {{ $annonce->prix }};
    const priceDisplay = document.getElementById('main-price');

    function updatePrice(extra) {
        // Simple client-side updates (symbolic as real price calc is backend)
        const total = parseFloat(basePrice) + parseFloat(extra || 0);
        priceDisplay.innerText = total.toLocaleString('fr-FR', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) + ' €';
    }

    function updateGallery(url, thumb) {
        document.getElementById('display-image').src = url;
        document.querySelectorAll('.rk-thumb').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
    }
</script>
@endpush
@endsection
