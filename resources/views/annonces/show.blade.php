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
        grid-template-columns: 80px 600px 1fr; /* Thumbnails | Main Image | Details */
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
        height: 550px;
        max-height: 85vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        position: relative;
    }
    .rk-main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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

    /* Premium Flat Product Card Styles (Consistent with Home) */
    .n1-top-grid {
        display: flex;
        flex-wrap: nowrap;
        gap: 15px;
        overflow-x: hidden;
        scroll-behavior: smooth;
        padding: 20px 5px;
    }

    .premium-card-flat {
        flex: 0 0 190px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 1.1rem;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: all 0.2s;
        box-sizing: border-box;
    }
    
    .premium-card-flat:hover {
        border-color: #eee;
    }

    .card-media-flat {
        width: 100%;
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    
    .card-media-flat img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .card-info-flat {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-title-flat {
        font-size: 0.85rem;
        line-height: 1.4;
        color: #1a1a1a;
        margin-bottom: 0.8rem;
        height: 2.4rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        font-weight: 500;
    }

    .card-price-row-flat {
        margin-bottom: 0.5rem;
        display: flex;
        align-items: baseline;
        gap: 4px;
        margin-top: auto;
    }
    
    .price-prefix {
        font-size: 0.75rem;
        color: #666;
        font-weight: 500;
    }
    
    .price-value-flat {
        color: #ff8c00;
        font-weight: 800;
        font-size: 1rem;
    }


    .carousel-arrow-btn {
        width: 35px;
        height: 35px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.2s;
        z-index: 10;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
    }

    .rk-sponsor-label {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #888;
        font-weight: 700;
        margin-bottom: 4px;
        display: block;
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
        padding: 0 1rem 0.5rem 1rem;
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
        transform: none;
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
        <div class="rk-main-image" style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; position: relative;">
            @if($annonce->video)
                <video id="display-video" controls autoplay muted style="width: 100%; height: 100%; border-radius: 12px;">
                    <source src="{{ $annonce->video->url }}" type="video/mp4">
                    Votre navigateur ne supporte pas la lecture de vidéos.
                </video>
                <img id="display-image" src="" alt="{{ $annonce->titre }}" style="display: none; width: 100%; height: 100%; object-fit: cover;">
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
                    style="position: absolute; top: 15px; right: 15px; background: white; border: 1px solid #eee; border-radius: 50%; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #666; transition: all 0.3s ease; z-index: 20;">
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
                    @if($annonce->should_show_etat)
                        <div class="rk-spec-item">
                            <span class="rk-spec-label"><i class="fas fa-tag" style="margin-right: 5px;"></i> État :</span>
                            <span class="rk-spec-value" style="color: {{ $annonce->etat_couleur }}; font-weight: 700;">{{ $annonce->etat_libelle }}</span>
                        </div>
                        <div class="rk-spec-separator" style="margin: 0 10px;">|</div>
                    @endif
                    <div class="rk-spec-item">
                        <span class="rk-spec-label"><i class="fas fa-check-circle" style="margin-right: 5px;"></i> Disponibilité :</span>
                        <span class="rk-spec-value" style="color: #28a745;">{{ ucfirst(str_replace('_', ' ', $annonce->disponibilite)) }}</span>
                    </div>
                     @if($annonce->category)
                    <div class="rk-spec-separator" style="margin: 0 10px;">|</div>
                    <div class="rk-spec-item">
                        <span class="rk-spec-label"><i class="fas fa-th-large" style="margin-right: 5px;"></i> Catégorie :</span>
                        <span class="rk-spec-value">{{ $annonce->category->nom }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Price & Action -->
            <div class="rk-price-box" style="display: flex; align-items: center; background: #ffffff; padding: 1.25rem; margin-top: 1.5rem; border-radius: 0;">
                <div style="flex: 1; border-right: 1px solid #e0e0e0; padding-right: 1rem;">
                    <div style="font-size: 0.8rem; color: #888; margin-bottom: 0.2rem; text-transform: uppercase; letter-spacing: 0.5px;">Prix de vente</div>
                    <div class="rk-main-price" id="main-price" style="color: #ff8c00; font-weight: 900; font-size: 1.8rem;">
                        {{ number_format($annonce->prix, 0, ',', ' ') }} <span style="font-size: 1rem;">FCFA</span>
                    </div>
                </div>
                
                <div class="rk-actions" style="padding-left: 1rem;">
                    @if($annonce->peutEtreAchete())
                        <form action="{{ route('cart.store') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">
                        <input type="hidden" name="quantite" value="1">
                        <button type="submit" class="rk-btn-cart" style="padding: 0.75rem 1.5rem; border-radius: 0; background: #000; font-size: 0.9rem;">
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
            <div class="rk-seller-card" style="background: #ffffff; padding: 1.25rem; margin-top: 1.5rem; border-radius: 0; display: flex; align-items: center; gap: 1.25rem; border-bottom: 1px solid #eee;">
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
                    <a href="#" style="font-size: 0.8rem; color: #ff8c00; font-weight: 700; text-decoration: none; border-bottom: 1px solid transparent; transition: all 0.2s;" onmouseover="this.style.borderBottom='1px solid #ff8c00'" onmouseout="this.style.borderBottom='1px solid transparent'">Voir la boutique</a>
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
        <h2 class="rk-offers-title" style="margin-top: 0;">Meilleures offres Pros</h2>
    </div>
    <div class="rakuten-product-carousel-container" style="max-width: 1280px; margin: 0 auto; background: #fff; position: relative; padding: 0 40px;">
        <button class="carousel-arrow-btn prev" onclick="scrollCarousel('carousel-pro', -1)" style="left: 0; border-radius: 0 50% 50% 0; border-left: none;"><i class="fas fa-chevron-left"></i></button>
        <div class="n1-top-grid" id="carousel-pro" style="display: flex; flex-wrap: nowrap; overflow-x: hidden; scroll-behavior: smooth; padding: 20px 0; gap: 15px;">
            @foreach($recommandations['meilleures_offres_pro'] as $rec)
                @include('partials.product-card-premium', ['annonce' => $rec])
            @endforeach
        </div>
        <button class="carousel-arrow-btn next" onclick="scrollCarousel('carousel-pro', 1)" style="right: 0; border-radius: 50% 0 0 50%; border-right: none;"><i class="fas fa-chevron-right"></i></button>
    </div>
    @endif

    <!-- Clients Also Viewed Section -->
    @if(isset($recommandations['aussi_vus']) && $recommandations['aussi_vus']->count() > 0)
    <div class="rk-section-header">
        <h2 class="rk-offers-title">Articles également vus</h2>
    </div>
    <div class="rakuten-product-carousel-container" style="max-width: 1280px; margin: 0 auto; background: #fff; position: relative; padding: 0 40px; margin-bottom: 3rem;">
        <button class="carousel-arrow-btn prev" onclick="scrollCarousel('carousel-seen', -1)" style="left: 0; border-radius: 0 50% 50% 0; border-left: none;"><i class="fas fa-chevron-left"></i></button>
        <div class="n1-top-grid" id="carousel-seen">
            @foreach($recommandations['aussi_vus'] as $rec)
                @include('partials.product-card-premium', ['annonce' => $rec, 'hideSeller' => true])
            @endforeach
        </div>
        <button class="carousel-arrow-btn next" onclick="scrollCarousel('carousel-seen', 1)" style="right: 0; border-radius: 50% 0 0 50%; border-right: none;"><i class="fas fa-chevron-right"></i></button>
    </div>
    @endif

    <!-- Clients Also Liked Section -->
    @if(isset($recommandations['aussi_aimes']) && $recommandations['aussi_aimes']->count() > 0)
    <div class="rk-section-header">
        <h2 class="rk-offers-title">Articles également aimés</h2>
    </div>
    <div class="rakuten-product-carousel-container" style="max-width: 1280px; margin: 0 auto; background: #fff; position: relative; padding: 0 40px; margin-bottom: 4rem;">
        <button class="carousel-arrow-btn prev" onclick="scrollCarousel('carousel-liked', -1)" style="left: 0; border-radius: 0 50% 50% 0; border-left: none;"><i class="fas fa-chevron-left"></i></button>
        <div class="n1-top-grid" id="carousel-liked">
            @foreach($recommandations['aussi_aimes'] as $rec)
                @include('partials.product-card-premium', ['annonce' => $rec, 'hideSeller' => true])
            @endforeach
        </div>
        <button class="carousel-arrow-btn next" onclick="scrollCarousel('carousel-liked', 1)" style="right: 0; border-radius: 50% 0 0 50%; border-right: none;"><i class="fas fa-chevron-right"></i></button>
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
                const imgHtml = `<img id="display-image" src="${url}" alt="{{ $annonce->titre }}" style="width: 100%; height: 100%; object-fit: cover;">`;
                container.insertAdjacentHTML('afterbegin', imgHtml);
            }
        }
        
        document.querySelectorAll('.rk-thumb').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
    }

    function scrollCarousel(id, direction) {
        const carousel = document.getElementById(id);
        const cardWidth = carousel.querySelector('.premium-card-flat')?.offsetWidth + 15 || 205;
        carousel.scrollBy({
            left: cardWidth * 3 * direction,
            behavior: 'smooth'
        });
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
