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
        border-color: #999;
        opacity: 1;
        box-shadow: 0 0 0 1px #ccc;
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
    .rk-stars { color: #ffbc00; font-size: 0.9rem; }
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
        background: #ff8c00;
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        font-size: 0.9rem;
        font-weight: 700;
        border-radius: 0;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
        box-shadow: none;
        margin-left: 1rem;
    }
    .rk-btn-cart:hover { background: #e67e00; transform: translateY(-1px); }
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

    /* Pro Row Styling to match image */
    .rk-pro-container {
        max-width: 1280px;
        margin: 0 auto;
        border: 1px solid #e0e0e0;
        background: #fff;
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        overflow-y: hidden;
        scrollbar-width: thin;
        -webkit-overflow-scrolling: touch;
    }
    .rk-pro-container::-webkit-scrollbar {
        height: 6px;
    }
    .rk-pro-container::-webkit-scrollbar-thumb {
        background: #ddd;
        border-radius: 3px;
    }
    .rk-pro-item {
        flex: 0 0 250px;
        border-right: 1px solid #e0e0e0;
    }
    .rk-pro-item:last-child {
        border-right: none;
    }
    .rk-pro-container .annonce-card-component {
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        height: 100% !important;
    }
    .rk-pro-container .annonce-card-component .card-img {
        max-height: 120px !important;
        width: auto !important;
        margin: 0 auto;
    }
    .rk-pro-container .annonce-card-component h3 {
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        height: auto !important;
        -webkit-line-clamp: 2 !important;
        margin-bottom: 0px !important;
    }
    .rk-pro-container .annonce-card-component .rk-stars {
        margin-bottom: 5px;
    }
    .rk-pro-container .annonce-card-component span[style*="color: #db0001"] {
        font-size: 1.2rem !important;
        font-weight: 900 !important;
    }
    .rk-pro-container .annonce-card-component span[style*="color: #db0001"]:after {
        content: " Neuf";
        font-size: 0.85rem;
        font-weight: 800;
        margin-left: 5px;
    }
    /* Hide the original state separator and text if they exist */
    .rk-pro-container .annonce-card-component span[style*="font-weight: bold; color: #db0001"] {
        display: none !important;
    }
    .rk-pro-container .annonce-card-component span[style*="font-size: 0.75rem; font-weight: 700; color: #db0001"] {
        display: none !important;
    }
    
    .rk-pro-container .annonce-card-component div[style*="margin-top: auto"] > div:first-child {
        margin-bottom: 15px !important;
    }

    .rk-pro-container .annonce-card-component div[style*="padding-top: 4px"] {
        display: none !important;
    }
    
    .rk-pro-container .annonce-card-component .card-img {
        max-height: 160px !important;
        margin-bottom: 10px;
    }
    
    .rk-pro-container .annonce-card-component span[style*="border: 1px solid #ddd"] {
        padding: 1px 6px !important;
        font-size: 8px !important;
    }
    
    .rk-pro-container .annonce-card-component div[style*="aspect-ratio: 1"] {
        padding: 8px !important;
        aspect-ratio: auto !important;
        height: 130px !important;
    }
    .rk-pro-container .annonce-card-component div[style*="padding: 0.9rem"] {
        padding: 0.6rem !important;
        flex: none !important;
    }
    .rk-best-offers {
        background: transparent;
        padding-top: 0;
        padding-bottom: 2rem;
        position: relative;
    }
    /* Ensure section headers always appear above the carousel */
    .rk-section-header {
        max-width: 1280px;
        margin: 3rem auto 1rem auto;
        padding: 0 1rem 0.75rem 1rem;
        border-bottom: 2px solid #f0f0f0;
        position: relative;
        z-index: 5;
    }
    .rk-offers-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #1a1a1a;
        margin: 0;
    }

    /* Trust indicators */
    .rk-trust-badges {
        display: flex;
        gap: 1.5rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
    }
    .rk-trust-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: #666;
    }
    .rk-trust-item i {
        color: #28a745;
        font-size: 1rem;
    }
    .rk-wishlist-btn:hover { 
        transform: scale(1.1);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15) !important;
    }
    .rk-wishlist-btn:active { 
        transform: scale(0.95);
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
            @if($annonce->video)
                <div class="rk-thumb active" onclick="updateGallery('{{ $annonce->video->url }}', this, 'video')" style="position: relative;">
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 10;">
                        <i class="fas fa-play-circle" style="color: white; font-size: 1.5rem; text-shadow: 0 2px 4px rgba(0,0,0,0.5);"></i>
                    </div>
                    <video src="{{ $annonce->video->url }}" style="width: 100%; height: 100%; object-fit: cover;"></video>
                </div>
            @endif
            
            @if($annonce->photos->count() > 0)
                @foreach($annonce->photos as $photo)
                    <div class="rk-thumb {{ (!$annonce->video && $photo->est_principale) ? 'active' : '' }}" onclick="updateGallery('{{ $photo->url }}', this, 'image')">
                        <img src="{{ $photo->thumbnail_url }}" alt="Vue {{ $loop->iteration }}">
                    </div>
                @endforeach
            @elseif(!$annonce->video)
                 <div class="rk-thumb active" style="background: #f8f9fa; display: flex; align-items: center; justify-content: center; border: 1px dashed #ccc;">
                    <i class="fas fa-camera" style="color: #ccc; font-size: 1.2rem;"></i>
                </div>
            @endif
        </div>

        <!-- Center: Main Image -->
        <div class="rk-main-image" style="background: #fbfbfb; border: 1px solid #f0f0f0; border-radius: 12px; overflow: hidden; box-shadow: inset 0 0 10px rgba(0,0,0,0.02); position: relative;">
            @if($annonce->video)
                <video id="display-video" controls autoplay muted style="width: 100%; height: 100%; border-radius: 12px;">
                    <source src="{{ $annonce->video->url }}" type="video/mp4">
                    Votre navigateur ne supporte pas la lecture de vidéos.
                </video>
                <img id="display-image" src="" alt="{{ $annonce->titre }}" style="display: none; max-width: 100%; max-height: 100%; object-fit: contain;">
            @else
                @php $photoPrincipale = $annonce->photoPrincipale(); @endphp
                @if($photoPrincipale)
                    <img id="display-image" src="{{ $photoPrincipale->url }}" alt="{{ $annonce->titre }}">
                @else
                    <div id="display-image-fallback" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #ccc;">
                        <i class="fas fa-image" style="font-size: 5rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <span style="font-weight: 600; font-size: 0.9rem; opacity: 0.5;">Aucune image disponible</span>
                    </div>
                @endif
            @endif

            <!-- Wishlist Button -->
            <button class="rk-wishlist-btn" 
                    id="wishlist-btn" 
                    data-annonce-slug="{{ $annonce->slug }}"
                    style="position: absolute; top: 15px; right: 15px; background: white; border: none; border-radius: 50%; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #666; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: all 0.3s ease; z-index: 20;">
                <i class="{{ auth()->check() && auth()->user()->favorites()->where('annonce_id', $annonce->id)->exists() ? 'fas' : 'far' }} fa-heart" 
                   style="font-size: 1.4rem; color: {{ auth()->check() && auth()->user()->favorites()->where('annonce_id', $annonce->id)->exists() ? '#bf0000' : '#666' }};"></i>
            </button>
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
                            <i class="fas fa-star" style="{{ $i <= $annonce->note_moyenne ? 'color: #ffbc00;' : 'color: #ddd;' }}"></i>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Content: Description & Specs -->
            <div class="rk-content-section">
                <div style="font-weight: 800; color: #1a1a1a; margin-bottom: 0.75rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">Description détaillée</div>
                <div class="rk-description-text" style="color: #555; line-height: 1.6; font-size: 0.95rem;">
                    {!! nl2br(e($annonce->description)) !!}
                </div>

                <div style="font-weight: 800; color: #1a1a1a; margin-top: 1.5rem; margin-bottom: 0.75rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">Caractéristiques techniques</div>
                <div class="rk-specs-horizontal" style="margin-top: 0.5rem;">
                    <div class="rk-spec-item">
                        <span class="rk-spec-label"><i class="fas fa-tag" style="margin-right: 5px;"></i> État :</span>
                        <span class="rk-spec-value" style="color: #bf0000;">{{ $annonce->produit->etat ?? 'Neuf' }}</span>
                    </div>
                    <div class="rk-spec-separator" style="margin: 0 10px;">|</div>
                    <div class="rk-spec-item">
                        <span class="rk-spec-label"><i class="fas fa-check-circle" style="margin-right: 5px;"></i> Disponibilité :</span>
                        <span class="rk-spec-value" style="color: #28a745;">{{ ucfirst(str_replace('_', ' ', $annonce->disponibilite)) }}</span>
                    </div>
                     @if($annonce->category)
                    <div class="rk-spec-separator" style="margin: 0 10px;">|</div>
                    <div class="rk-spec-item">
                        <span class="rk-spec-label"><i class="fas fa-folder" style="margin-right: 5px;"></i> Catégorie :</span>
                        <span class="rk-spec-value">{{ $annonce->category->nom }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Price & Action -->
            <div class="rk-price-box" style="display: flex; align-items: center; border: 1px solid #e0e0e0; background: #ffffff; padding: 1.25rem; margin-top: 1.5rem; border-radius: 0;">
                <div style="flex: 1; border-right: 1px solid #e0e0e0; padding-right: 1rem;">
                    <div style="font-size: 0.8rem; color: #888; margin-bottom: 0.2rem; text-transform: uppercase; letter-spacing: 0.5px;">Prix de vente</div>
                    <div class="rk-main-price" id="main-price" style="color: #db0001; font-weight: 900;">
                        {{ number_format($annonce->prix, 0, ',', ' ') }} <span style="font-size: 1.2rem;">FCFA</span>
                    </div>
                </div>
                
                <div class="rk-actions" style="padding-left: 1rem;">
                    @if($annonce->peutEtreAchete())
                        <form action="{{ route('cart.store') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">
                        <input type="hidden" name="quantite" value="1">
                        <button type="submit" class="rk-btn-cart" style="padding: 0.75rem 1.5rem; border-radius: 0; background: #ff8c00; font-size: 0.9rem;">
                            <i class="fas fa-shopping-cart" style="margin-right: 0.75rem;"></i> Ajouter au panier
                        </button>
                    </form>
                    @else
                        <a href="{{ auth()->check() ? route('conversations.create', ['recipient_id' => $annonce->vendeur->user_id, 'annonce_id' => $annonce->id]) : route('login') }}" class="rk-btn-cart" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; background: #000; padding: 0.75rem 1.5rem; border-radius: 0; font-size: 0.9rem;">
                            <i class="fas fa-envelope" style="margin-right: 0.75rem;"></i> Contacter le vendeur
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Seller Info -->
            <div class="rk-seller-card" style="background: #ffffff; padding: 1.25rem; border: 1px solid #e0e0e0; margin-top: 1.5rem; border-radius: 0; display: flex; align-items: center; gap: 1.25rem;">
                 <div class="rk-seller-avatar" style="width: 50px; height: 50px; background: #f8f9fa; border: 1px solid #eee; border-radius: 0; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #adb5bd;">
                     <i class="fas fa-store"></i>
                 </div>
                 <div class="rk-seller-info" style="flex: 1;">
                     <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 2px;">
                        <i class="fas fa-check-circle" style="color: #28a745; font-size: 0.8rem;"></i>
                        <span style="font-size: 0.75rem; color: #6c757d; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Vendeur vérifié</span>
                     </div>
                     <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <a href="#" class="rk-seller-name" style="color: #1a1a1a; font-weight: 900; font-size: 1.1rem; text-decoration: none; transition: color 0.2s;">
                            @if($annonce->vendeur && $annonce->vendeur->professionnel)
                                {{ $annonce->vendeur->professionnel->nom_entreprise }}
                            @elseif($annonce->vendeur && $annonce->vendeur->user)
                                {{ $annonce->vendeur->user->prenom }} {{ $annonce->vendeur->user->nom }}
                            @else
                                Vendeur inconnu
                            @endif
                        </a>
                        @if($annonce->vendeur && $annonce->vendeur->type === 'professionnel')
                            <span style="background: #ffffff; color: #333; font-size: 9px; font-weight: 900; padding: 1px 7px; letter-spacing: 1px; border-radius: 0; text-transform: uppercase; border: 1px solid #ddd;">PRO</span>
                        @endif
                     </div>
                 </div>
                 <div style="padding-left: 1rem; border-left: 1px solid #eee;">
                    <a href="#" style="font-size: 0.8rem; color: #004aad; font-weight: 700; text-decoration: none; border-bottom: 1px solid transparent; transition: all 0.2s;" onmouseover="this.style.borderBottom='1px solid #004aad'" onmouseout="this.style.borderBottom='1px solid transparent'">Voir la boutique</a>
                 </div>
            </div>

            <!-- Trust Badges -->
            <div class="rk-trust-badges">
                <div class="rk-trust-item">
                    <i class="fas fa-shield-alt"></i>
                    <span>Paiement sécurisé</span>
                </div>
                <div class="rk-trust-item">
                    <i class="fas fa-shipping-fast"></i>
                    <span>Livraison rapide</span>
                </div>
                <div class="rk-trust-item">
                    <i class="fas fa-undo"></i>
                    <span>Retours acceptés</span>
                </div>
            </div>
        </div>
    </div>

    </div>

    <!-- Reviews Section -->
    @if($annonce->avisApprouves->count() > 0)
    <div id="avis" class="rk-section-header" style="margin-top: 3rem; border-top: 1px solid #eee; padding-top: 2rem;">
        <h2 class="rk-offers-title">Avis clients</h2>
        <div style="display: flex; align-items: center; gap: 1rem; margin-top: 0.5rem;">
            <div class="rk-stars">
                @for($i=1; $i<=5; $i++)
                    <i class="fas fa-star" style="{{ $i <= $annonce->note_moyenne ? 'color: #ffbc00;' : 'color: #ddd;' }}"></i>
                @endfor
            </div>
            <span style="font-weight: 700; font-size: 1.1rem;">{{ number_format($annonce->note_moyenne, 1) }}/5</span>
            <span style="color: #666;">({{ $annonce->nombre_avis }} avis)</span>
        </div>
    </div>

    <div class="rk-main-grid" style="margin-top: 1rem;">
        <div style="grid-column: 1 / -1;">
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                @foreach($annonce->avisApprouves as $avis)
                    <div style="padding: 1.5rem; background: #f9f9f9; border-radius: 8px; border-left: 4px solid #bf0000;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="font-weight: 700;">{{ $avis->user->prenom }} {{ $avis->user->nom }}</span>
                            <span style="color: #888; font-size: 0.8rem;">{{ $avis->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="rk-stars" style="margin-bottom: 0.5rem; font-size: 0.8rem;">
                            @for($i=1; $i<=5; $i++)
                                <i class="fas fa-star" style="{{ $i <= $avis->note ? 'color: #ffbc00;' : 'color: #ddd;' }}"></i>
                            @endfor
                        </div>
                        <p style="font-size: 0.9rem; color: #555; margin: 0;">{{ $avis->commentaire }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Best Offers Section -->
    @if(isset($recommandations['meilleures_offres_pro']) && $recommandations['meilleures_offres_pro']->count() > 0)
    <div class="rk-section-header" style="margin-top: 4rem;">
        <span class="rk-sponsor-label">Sponsorisée</span>
        <h2 class="rk-offers-title" style="margin-top: 0;">Les meilleures offres de nos vendeurs professionnels</h2>
    </div>
    <div class="rk-best-offers" style="background: transparent; padding-top: 0.5rem; padding-bottom: 2rem; position: relative;">
    <div style="display: flex; flex-direction: row; flex-wrap: nowrap; overflow-x: auto; overflow-y: hidden; border: 1px solid #e0e0e0; background: #fff; max-width: 1280px; margin: 0 auto;">
        @foreach($recommandations['meilleures_offres_pro'] as $rec)
        @php
            $rating = $rec->note_moyenne;
            $full = floor($rating); $half = ($rating - $full) >= 0.5; $empty = 5 - $full - ($half?1:0);
        @endphp
        <a href="{{ route('annonces.show', $rec->slug) }}" style="flex: 0 0 210px; min-width: 210px; border-right: 1px solid #e0e0e0; text-decoration: none; color: inherit; display: flex; flex-direction: column; background: #fff; padding: 0;">
            <div style="height: 160px; background: #fff; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 10px;">
                @if($rec->photoPrincipale())
                    <img src="{{ Storage::url($rec->photoPrincipale()->chemin) }}" alt="{{ $rec->titre }}" style="max-height: 140px; max-width: 100%; object-fit: contain;">
                @else
                    <div style="color: #ccc; font-size: 0.75rem;">Pas d'image</div>
                @endif
            </div>
            <div style="padding: 0.75rem; flex: 1; display: flex; flex-direction: column; gap: 4px;">
                @if($rec->produit && $rec->produit->marque)
                    <div style="font-size: 0.7rem; color: #888;">{{ $rec->produit->marque }}</div>
                @endif
                <div style="font-size: 0.82rem; font-weight: 600; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; color: #1a1a1a;">{{ $rec->titre }}</div>
                <div style="display: flex; gap: 2px; align-items: center; margin-top: 2px;">
                    <div style="color: #ffbc00; font-size: 0.7rem;">
                        @for($i=0;$i<$full;$i++)<i class="fas fa-star"></i>@endfor
                        @if($half)<i class="fas fa-star-half-alt"></i>@endif
                        @for($i=0;$i<$empty;$i++)<i class="far fa-star"></i>@endfor
                    </div>
                    <span style="font-size: 0.68rem; color: #777;">{{ $rec->nombre_avis ?? 0 }} avis</span>
                </div>
                <div style="margin-top: 4px;">
                    <span style="font-size: 1.1rem; font-weight: 900; color: #db0001;">{{ number_format($rec->prix, 0, ',', ' ') }} FCFA</span>
                    <span style="font-size: 0.78rem; font-weight: 700; color: #db0001; margin-left: 4px;">{{ ucfirst($rec->metadata?->etat ?? 'Neuf') }}</span>
                </div>
                @if($rec->vendeur && $rec->vendeur->type === 'professionnel')
                <div style="font-size: 0.7rem; color: #777; margin-top: 4px; display: flex; align-items: center; gap: 4px; flex-wrap: wrap;">
                    <span>Par <strong style="color: #333;">{{ $rec->vendeur->professionnel->nom_entreprise ?? 'Boutique' }}</strong></span>
                    <span style="background: #fff; color: #333; font-size: 8px; font-weight: 800; padding: 1px 5px; border: 1px solid #ccc; text-transform: uppercase;">PRO</span>
                </div>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    </div>
    @endif

    <!-- Clients Also Viewed Section -->
    @if(isset($recommandations['aussi_vus']) && $recommandations['aussi_vus']->count() > 0)
    <div class="rk-section-header">
        <h2 class="rk-offers-title">Les clients ayant vu ce produit ont également vu</h2>
    </div>
    <div class="rk-best-offers" style="background: transparent; padding-top: 0.5rem; padding-bottom: 2rem; position: relative;">
    <div style="display: flex; flex-direction: row; flex-wrap: nowrap; overflow-x: auto; overflow-y: hidden; border: 1px solid #e0e0e0; background: #fff; max-width: 1280px; margin: 0 auto;">
        @foreach($recommandations['aussi_vus'] as $rec)
        @php
            $rating = $rec->note_moyenne;
            $full = floor($rating); $half = ($rating - $full) >= 0.5; $empty = 5 - $full - ($half?1:0);
        @endphp
        <a href="{{ route('annonces.show', $rec->slug) }}" style="flex: 0 0 210px; min-width: 210px; border-right: 1px solid #e0e0e0; text-decoration: none; color: inherit; display: flex; flex-direction: column; background: #fff;">
            <div style="height: 160px; background: #fff; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 10px;">
                @if($rec->photoPrincipale())
                    <img src="{{ Storage::url($rec->photoPrincipale()->chemin) }}" alt="{{ $rec->titre }}" style="max-height: 140px; max-width: 100%; object-fit: contain;">
                @else
                    <div style="color: #ccc; font-size: 0.75rem;">Pas d'image</div>
                @endif
            </div>
            <div style="padding: 0.75rem; flex: 1; display: flex; flex-direction: column; gap: 4px;">
                @if($rec->produit && $rec->produit->marque)
                    <div style="font-size: 0.7rem; color: #888;">{{ $rec->produit->marque }}</div>
                @endif
                <div style="font-size: 0.82rem; font-weight: 600; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; color: #1a1a1a;">{{ $rec->titre }}</div>
                <div style="display: flex; gap: 2px; align-items: center; margin-top: 2px;">
                    <div style="color: #ffbc00; font-size: 0.7rem;">
                        @for($i=0;$i<$full;$i++)<i class="fas fa-star"></i>@endfor
                        @if($half)<i class="fas fa-star-half-alt"></i>@endif
                        @for($i=0;$i<$empty;$i++)<i class="far fa-star"></i>@endfor
                    </div>
                    <span style="font-size: 0.68rem; color: #777;">{{ $rec->nombre_avis ?? 0 }} avis</span>
                </div>
                <div style="margin-top: 4px;">
                    <span style="font-size: 1.1rem; font-weight: 900; color: #db0001;">{{ number_format($rec->prix, 0, ',', ' ') }} FCFA</span>
                    <span style="font-size: 0.78rem; font-weight: 700; color: #db0001; margin-left: 4px;">{{ ucfirst($rec->metadata?->etat ?? 'Neuf') }}</span>
                </div>
                @if($rec->vendeur && $rec->vendeur->type === 'professionnel')
                <div style="font-size: 0.7rem; color: #777; margin-top: 4px; display: flex; align-items: center; gap: 4px; flex-wrap: wrap;">
                    <span>Par <strong style="color: #333;">{{ $rec->vendeur->professionnel->nom_entreprise ?? 'Boutique' }}</strong></span>
                    <span style="background: #fff; color: #333; font-size: 8px; font-weight: 800; padding: 1px 5px; border: 1px solid #ccc; text-transform: uppercase;">PRO</span>
                </div>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    </div>
    @endif

    <!-- Clients Also Liked Section -->
    @if(isset($recommandations['aussi_aimes']) && $recommandations['aussi_aimes']->count() > 0)
    <div class="rk-section-header">
        <h2 class="rk-offers-title">Les clients ayant vu ce produit ont également aimé</h2>
    </div>
    <div class="rk-best-offers" style="background: transparent; padding-top: 0.5rem; padding-bottom: 4rem; position: relative;">
    <div style="display: flex; flex-direction: row; flex-wrap: nowrap; overflow-x: auto; overflow-y: hidden; border: 1px solid #e0e0e0; background: #fff; max-width: 1280px; margin: 0 auto;">
        @foreach($recommandations['aussi_aimes'] as $rec)
        @php
            $rating = $rec->note_moyenne;
            $full = floor($rating); $half = ($rating - $full) >= 0.5; $empty = 5 - $full - ($half?1:0);
        @endphp
        <a href="{{ route('annonces.show', $rec->slug) }}" style="flex: 0 0 210px; min-width: 210px; border-right: 1px solid #e0e0e0; text-decoration: none; color: inherit; display: flex; flex-direction: column; background: #fff;">
            <div style="height: 160px; background: #fff; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 10px;">
                @if($rec->photoPrincipale())
                    <img src="{{ Storage::url($rec->photoPrincipale()->chemin) }}" alt="{{ $rec->titre }}" style="max-height: 140px; max-width: 100%; object-fit: contain;">
                @else
                    <div style="color: #ccc; font-size: 0.75rem;">Pas d'image</div>
                @endif
            </div>
            <div style="padding: 0.75rem; flex: 1; display: flex; flex-direction: column; gap: 4px;">
                @if($rec->produit && $rec->produit->marque)
                    <div style="font-size: 0.7rem; color: #888;">{{ $rec->produit->marque }}</div>
                @endif
                <div style="font-size: 0.82rem; font-weight: 600; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; color: #1a1a1a;">{{ $rec->titre }}</div>
                <div style="display: flex; gap: 2px; align-items: center; margin-top: 2px;">
                    <div style="color: #ffbc00; font-size: 0.7rem;">
                        @for($i=0;$i<$full;$i++)<i class="fas fa-star"></i>@endfor
                        @if($half)<i class="fas fa-star-half-alt"></i>@endif
                        @for($i=0;$i<$empty;$i++)<i class="far fa-star"></i>@endfor
                    </div>
                    <span style="font-size: 0.68rem; color: #777;">{{ $rec->nombre_avis ?? 0 }} avis</span>
                </div>
                <div style="margin-top: 4px;">
                    <span style="font-size: 1.1rem; font-weight: 900; color: #db0001;">{{ number_format($rec->prix, 0, ',', ' ') }} FCFA</span>
                    <span style="font-size: 0.78rem; font-weight: 700; color: #db0001; margin-left: 4px;">{{ ucfirst($rec->metadata?->etat ?? 'Neuf') }}</span>
                </div>
                @if($rec->vendeur && $rec->vendeur->type === 'professionnel')
                <div style="font-size: 0.7rem; color: #777; margin-top: 4px; display: flex; align-items: center; gap: 4px; flex-wrap: wrap;">
                    <span>Par <strong style="color: #333;">{{ $rec->vendeur->professionnel->nom_entreprise ?? 'Boutique' }}</strong></span>
                    <span style="background: #fff; color: #333; font-size: 8px; font-weight: 800; padding: 1px 5px; border: 1px solid #ccc; text-transform: uppercase;">PRO</span>
                </div>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    const basePrice = {{ $annonce->prix }};
    const priceDisplay = document.getElementById('main-price');

    function updatePrice(extra) {
        // Simple client-side updates (symbolic as real price calc is backend)
        const total = parseFloat(basePrice) + parseFloat(extra || 0);
        priceDisplay.innerText = total.toLocaleString('fr-FR', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) + ' FCFA';
    }

    function updateGallery(url, thumb, type = 'image') {
        const container = document.querySelector('.rk-main-image');
        const displayImage = document.getElementById('display-image');
        const displayVideo = document.getElementById('display-video');
        const fallback = document.getElementById('display-image-fallback');
        
        if (fallback) fallback.style.display = 'none';

        if (type === 'video') {
            if (displayImage) displayImage.style.display = 'none';
            if (displayVideo) {
                displayVideo.style.display = 'block';
                displayVideo.querySelector('source').src = url;
                displayVideo.load();
            } else {
                const videoHtml = `
                    <video id="display-video" controls autoplay muted style="width: 100%; height: 100%; border-radius: 12px;">
                        <source src="${url}" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>`;
                container.insertAdjacentHTML('afterbegin', videoHtml);
            }
        } else {
            if (displayVideo) {
                displayVideo.pause();
                displayVideo.style.display = 'none';
            }
            if (displayImage) {
                displayImage.style.display = 'block';
                displayImage.src = url;
            } else {
                const imgHtml = `<img id="display-image" src="${url}" alt="{{ $annonce->titre }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">`;
                container.insertAdjacentHTML('afterbegin', imgHtml);
            }
        }
        
        document.querySelectorAll('.rk-thumb').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
    }

    // Wishlist Toggle Logic (using event delegation for robustness)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('#wishlist-btn');
        if (!btn) return;

        e.preventDefault();
        const icon = btn.querySelector('i');
        const annonceSlug = btn.dataset.annonceSlug;

        if (!{{ auth()->check() ? 'true' : 'false' }}) {
            window.location.href = "{{ route('login') }}";
            return;
        }

        btn.style.opacity = '0.5';
        btn.style.pointerEvents = 'none';

        fetch(`/annonces/${annonceSlug}/favorite`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            btn.style.opacity = '1';
            btn.style.pointerEvents = 'auto';
            if (data.status === 'added') {
                icon.classList.remove('far');
                icon.classList.add('fas');
                icon.style.color = '#bf0000';
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                icon.style.color = '#666';
            }

            // Optional: Provide feedback via toast
            window.dispatchEvent(new CustomEvent('notify', {
                detail: { message: data.message, type: 'success' }
            }));
        })
        .catch(error => {
            console.error('Error:', error);
            btn.style.opacity = '1';
            btn.style.pointerEvents = 'auto';
        });
    });
</script>
@endpush
@endsection
