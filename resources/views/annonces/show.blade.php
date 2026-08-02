@extends('layouts.app')

@section('title', $annonce->titre)

@section('content')
<style>
    /* Global Reset & Fonts */
    .rakuten-page {
        font-family: "Rakuten Sans", "Rakuten Serif", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background-color: #f1f1f2;
        color: #333;
        padding-top: 0.25rem;
    }
    /* Cartes blanches sur fond gris, collées (galerie + détails) */
    .rk-main-grid > .rk-details {
        background: #fff;
        padding: 1.25rem 1.5rem;
        border-radius: 0 6px 6px 0;
    }
    .rk-gallery-col .rk-thumbnails { padding: 10px 12px 12px; }
    /* Avec colonne livraison : détails plat des deux côtés, marge avant livraison */
    .rk-main-grid.has-delivery > .rk-details { border-radius: 0; }
    .rk-main-grid.has-delivery > .rk-delivery-col { margin-left: 1.5rem; }

    /* Breadcrumb */
    .rk-breadcrumb {
        font-size: 0.82rem;
        font-weight: 500;
        color: #555;
        padding: 0.25rem 0 0.6rem 0;
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
        grid-template-columns: 400px 1fr; /* Galerie | Détails */
        grid-template-areas: "gallery details";
        gap: 0;
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 1rem 1rem 1rem;
        align-items: stretch;
    }
    .rk-main-grid.has-delivery {
        grid-template-columns: 380px 1fr 280px; /* Galerie | Détails | Livraison */
        grid-template-areas: "gallery details delivery";
    }
    .rk-main-grid > .rk-gallery-col { grid-area: gallery; }
    .rk-main-grid > .rk-details { grid-area: details; }
    .rk-main-grid > .rk-delivery-col { grid-area: delivery; display: flex; }
    .rk-main-grid > .rk-delivery-col > .rk-deliv-card { flex: 1; }
    /* Galerie : image en haut, miniatures dessous, dans une seule carte */
    .rk-gallery-col {
        display: flex;
        flex-direction: column;
        justify-content: center; /* contenu centré verticalement (symétrique) */
        background: #fff;
        border-radius: 6px 0 0 6px;
        overflow: hidden;
    }
    .rk-gallery-col > .rk-main-image { order: 0; } /* image en haut */
    .rk-gallery-col > .rk-thumbnails { order: 1; } /* miniatures dessous */

    /* Colonne Livraison & Retours (droite) */
    .rk-delivery-col { align-self: stretch; }
    .rk-deliv-card {
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 6px;
        overflow: hidden;
    }
    .rk-deliv-header {
        padding: 12px 15px;
        border-bottom: 1px solid #f2f2f2;
        font-family: 'Outfit','Inter',sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        color: #333;
    }
    .rk-deliv-body { padding: 6px 15px; }
    .rk-deliv-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 12px 0;
        border-bottom: 1px solid #f5f5f5;
    }
    .rk-deliv-item:last-child { border-bottom: none; }
    .rk-deliv-item > i { color: #b8bec7; font-size: 1rem; width: 22px; text-align: center; margin-top: 2px; flex-shrink: 0; }
    .rk-deliv-title { font-family: 'Outfit','Inter',sans-serif; font-size: 0.9rem; font-weight: 600; color: #1a1a1a; }
    .rk-deliv-sub { font-family: 'Inter',sans-serif; font-size: 0.8rem; color: #6b7280; line-height: 1.4; margin-top: 2px; }

    /* Gallery Section */
    .rk-thumbnails {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 0.6rem;
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
        height: 360px;
        max-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        position: relative;
        padding: 10px; /* Petit dé-zoom pour voir tout le produit */
    }
    .rk-main-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; /* Évite de zoomer/rogner l'image */
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
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.35;
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
        color: #f68b1e;
        line-height: 1;
        margin-bottom: 0;
        text-shadow: none !important;
    }

    .rk-actions {
        margin: 0;
    }
    
    .rk-btn-cart {
        width: auto;
        background: #004aad;
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
    .rk-btn-cart:hover { background: #003d8f; transform: translateY(-1px); }
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
        .rk-main-grid,
        .rk-main-grid.has-delivery {
            display: flex !important;
            flex-direction: column;
            grid-template-columns: none;
            grid-template-areas: none;
            gap: 0.9rem;
            padding: 0 0.6rem 1rem;
        }
        .rk-main-grid > .rk-gallery-col { order: 1; align-self: stretch; }
        .rk-main-grid > .rk-details { order: 2; align-self: stretch; }
        .rk-main-grid > .rk-delivery-col { order: 3; align-self: stretch; display: block; }
        /* Cartes pleine largeur, coins arrondis, sur mobile */
        .rk-gallery-col {
            width: 100%;
            border-radius: 8px;
            justify-content: flex-start;
        }
        .rk-gallery-col > .rk-main-image { height: 320px; width: 100%; border-radius: 8px 8px 0 0; }
        .rk-main-grid > .rk-details,
        .rk-main-grid.has-delivery > .rk-details {
            width: 100%;
            border-radius: 8px;
            padding: 1.25rem;
        }
        .rk-main-grid.has-delivery > .rk-delivery-col { margin-left: 0; }
        .rk-thumbnails { flex-direction: row; flex-wrap: wrap; }
    }

    /* Mobile/tablette : prix + boutons (panier / contacter vendeur) */
    @media (max-width: 1024px) {
        .rk-price-box {
            flex-direction: column;
            align-items: stretch !important;
            gap: 0.85rem;
            padding: 1rem 0 !important;
        }
        /* Bloc prix en pleine largeur (retire le séparateur vertical) */
        .rk-price-box > div:first-child {
            border-right: none !important;
            padding-right: 0 !important;
        }
        /* Le prix ne déborde plus même si le montant est grand */
        .rk-main-price {
            font-size: 1.4rem !important;
            flex-wrap: wrap;
            row-gap: 2px;
        }
        .rk-actions {
            padding-left: 0 !important;
            width: 100%;
        }
        .rk-actions form {
            display: block !important;
            width: 100%;
        }
        .rk-btn-cart {
            width: 100% !important;
            margin-left: 0 !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            padding: 0.85rem 1rem !important;
            font-size: 1rem !important;
        }

        /* Carte vendeur : empilée + bouton pleine largeur */
        .rk-seller-flex {
            flex-wrap: wrap;
            row-gap: 0.85rem;
        }
        .rk-seller-flex .rk-seller-info {
            flex: 1 1 calc(100% - 66px) !important;
            min-width: 0;
        }
        .seller-action-wrap {
            margin: 0 !important;
            width: 100%;
            flex: 1 1 100%;
        }
        .seller-action-wrap a {
            display: block !important;
            text-align: center;
            padding: 0.85rem 1rem !important;
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
        flex: 0 0 220px;
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
        color: #f68b1e;
        font-weight: 800;
        font-size: 1rem;
        text-shadow: none !important;
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
        font-weight: 600;
        color: #444;
        margin: 0;
    }

    /* Shop Identity Card (as requested replacement for breadcrumb) */
    .shop-identity-card-mini {
        max-width: 1248px; /* = 1280 - 2rem : aligné aux marges des conteneurs */
        margin: 0 auto 1rem auto;
        background: white;
        border-radius: 6px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 20px;
        border-bottom: 1px solid #eee;
    }

    .shop-logo-box-mini {
        width: 50px;
        height: 50px;
        background: white;
        border: 1px solid #eee;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px;
        flex-shrink: 0;
    }

    .shop-logo-box-mini img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .shop-meta-info-mini {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .shop-name-row-mini {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .shop-name-text-mini {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1a1a1a;
        text-decoration: none;
    }

    .tag-pro-mini {
        background: #fff;
        color: #666;
        font-size: 8px;
        font-weight: 800;
        padding: 1px 6px;
        border: 1px solid #ddd;
        border-radius: 10px;
        text-transform: uppercase;
    }

    .shop-stats-mini {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.8rem;
        color: #666;
    }

    .shop-rating-stars-mini { color: #ff9900; font-size: 0.75rem; }
    
    .mentions-legales-mini {
        font-size: 0.75rem;
        color: #004aad;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
        font-weight: 600;
    }
    .card-review-row i {
        color: #ffc107;
        font-size: 0.8rem;
    }
</style>

<div class="rakuten-page">
        <!-- Fil d'ariane (chemin complet des catégories) -->
        @php
            $trail = [];
            $cat = $annonce->category;
            while ($cat) { array_unshift($trail, $cat); $cat = $cat->parent; }
        @endphp
        <nav class="rk-breadcrumb">
            <a href="{{ route('home') }}">Accueil</a>
            @foreach($trail as $c)
                &gt; <a href="{{ route('categories.show', $c->slug) }}">{{ $c->nom }}</a>
            @endforeach
            &gt; <span style="font-weight: 700; color: #333;">{{ $annonce->titre }}</span>
        </nav>

    @php $estEcommerce = $annonce->category && $annonce->category->famille === \App\Models\Category::FAMILLE_ECOMMERCE; @endphp
    <div class="rk-main-grid has-delivery">
        <!-- Galerie : image + miniatures -->
        <div class="rk-gallery-col">
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
        <div class="rk-main-image" style="background: #ffffff; border: none; border-radius: 6px 0 0 0; overflow: hidden; position: relative;">
            @if($annonce->video)
                <video id="display-video" controls autoplay muted style="width: 100%; height: 100%; max-width: 100%; max-height: 100%; border-radius: 12px; object-fit: contain;">
                    <source src="{{ $annonce->video->url }}" type="video/mp4">
                    Votre navigateur ne supporte pas la lecture de vidéos.
                </video>
                <img id="display-image" src="" alt="{{ $annonce->titre }}" style="display: none; width: 100%; height: 100%; object-fit: contain;">
            @else
                @php $photoPrincipale = $annonce->photoPrincipale(); @endphp
                @if($photoPrincipale)
                    <img id="display-image" src="{{ $photoPrincipale->url }}" alt="{{ $annonce->titre }}" style="width: 100%; height: 100%; object-fit: contain;">
                @else
                    <div id="display-image-fallback" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; color: #ccc;">
                        <i class="fas fa-image" style="font-size: 5rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                        <span style="font-weight: 600; font-size: 0.9rem; opacity: 0.5;">Aucune image disponible</span>
                    </div>
                @endif
            @endif

        </div>
        </div><!-- /rk-gallery-col -->

        <!-- Right: Details -->
        <div class="rk-details" style="position: relative;">
            <!-- Wishlist Button (haut droite) -->
            <button class="rk-wishlist-btn"
                    id="wishlist-btn"
                    data-annonce-slug="{{ $annonce->slug }}"
                    style="position: absolute; top: 0; right: 0; background: transparent; border: none; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #f68b1e; box-shadow: none; transition: all 0.2s ease; z-index: 20;">
                <i class="{{ auth()->check() && auth()->user()->favorites()->where('annonce_id', $annonce->id)->exists() ? 'fas' : 'far' }} fa-heart"
                   style="font-size: 1.4rem; color: #f68b1e;"></i>
            </button>
            <!-- Header: Brand, Title, Stars -->
            <div style="margin-bottom: 1.5rem; padding-right: 44px;">
                <h1 class="rk-title">{{ $annonce->titre }}</h1>

                @php $estEcommerce = $annonce->category && $annonce->category->famille === \App\Models\Category::FAMILLE_ECOMMERCE; @endphp
                @if($estEcommerce)
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                    <div class="rk-stars" style="color: #ff9900; font-size: 0.85rem; display: flex; align-items: center; gap: 3px;">
                        @php
                            $moyenneNote = $annonce->note_moyenne;
                            $nbAvis = $annonce->nombre_avis;
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($moyenneNote))
                                <i class="fas fa-star"></i>
                            @elseif($i == ceil($moyenneNote) && ($moyenneNote - floor($moyenneNote)) >= 0.5)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span style="color: #007185; font-size: 0.85rem; font-weight: 500;">({{ $nbAvis }})</span>
                </div>
                @endif
            </div>

            <!-- Content: Description & Specs -->
            <div class="rk-content-section" style="margin-bottom: 0.5rem;">
                <div style="font-weight: 800; color: #1a1a1a; margin-bottom: 0.75rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">Description détaillée</div>
                <div class="rk-description-text" style="color: #555; line-height: 1.6; font-size: 0.95rem;">
                    {!! nl2br(e($annonce->description)) !!}
                </div>
            </div>

            <!-- Price & Action -->
            <div class="rk-price-box" style="display: flex; align-items: center; background: #ffffff; padding: 0.5rem 1.25rem; margin-top: 0; border-radius: 0;">
                <div style="flex: 1; border-right: 1px solid #e0e0e0; padding-right: 1rem;">
                    <div style="font-size: 0.8rem; color: #888; margin-bottom: 0.2rem; text-transform: uppercase; letter-spacing: 0.5px;">Prix de vente</div>
                    <div class="rk-main-price" id="main-price" style="display: flex; align-items: baseline; gap: 8px; color: #1a1a1a; font-weight: 700; font-size: 1.35rem; text-shadow: none !important;">
                        {{ number_format($annonce->prix_affiche, 0, ',', ' ') }} <span style="font-size: 1rem; color: #1a1a1a;">FCFA</span>
                        @if($annonce->estEnPromo())
                            <span style="font-size: 1rem; color: #999; text-decoration: line-through; font-weight: 400;">
                                {{ number_format($annonce->prix_original, 0, ',', ' ') }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="rk-actions" style="padding-left: 1rem;">
                    @if($annonce->peutEtreAchete())
                        <form action="{{ route('cart.store') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">
                        <input type="hidden" name="quantite" value="1">
                        <button type="submit" class="rk-btn-cart" style="padding: 0.75rem 1.5rem; border-radius: 0; font-size: 0.9rem; background: #f68b1e;"
                            onmouseover="this.style.background='#e07b10'" onmouseout="this.style.background='#f68b1e'">
                            <i class="fas fa-shopping-cart" style="margin-right: 0.75rem;"></i> Ajouter au panier
                        </button>
                    </form>
                    @else
                        @if(auth()->check())
                            <button onclick="openQuickChat('{{ route('conversations.create', ['recipient_id' => $annonce->vendeur->user_id, 'annonce_id' => $annonce->id]) }}')" class="rk-btn-cart" 
                                style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; background: #f68b1e; padding: 0.75rem 1.5rem; border-radius: 0; font-size: 0.9rem; transition: background 0.2s;"
                                onmouseover="this.style.background='#e07b10'" onmouseout="this.style.background='#f68b1e'">
                                <i class="fas fa-envelope" style="margin-right: 0.75rem;"></i> Contacter le vendeur
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="rk-btn-cart" 
                                style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; background: #f68b1e; padding: 0.75rem 1.5rem; border-radius: 0; font-size: 0.9rem; transition: background 0.2s;"
                                onmouseover="this.style.background='#e07b10'" onmouseout="this.style.background='#f68b1e'">
                                <i class="fas fa-envelope" style="margin-right: 0.75rem;"></i> Contacter le vendeur
                            </a>
                        @endif
                    @endif
                </div>
            </div> <!-- Close rk-price-box -->

            <!-- Caractéristiques techniques (sous le prix) -->
            <div class="rk-content-section" style="margin-top: 0.5rem;">
                <div style="font-weight: 800; color: #1a1a1a; margin-bottom: 0.75rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px;">Caractéristiques techniques</div>
                <div class="rk-specs-horizontal" style="margin-top: 0.5rem;">
                    @if($annonce->should_show_etat)
                        <div class="rk-spec-item">
                            <span class="rk-spec-label"><i class="fas fa-tag" style="margin-right: 5px;"></i> État :</span>
                            <span class="rk-spec-value" style="color: {{ $annonce->etat_couleur }}; font-weight: 700;">{{ $annonce->etat_libelle }}</span>
                        </div>
                    @endif

                    @foreach($annonce->filteredAttributes as $attr)
                        @if($attr->filter && $attr->value !== null && $attr->value !== '')
                            <div class="rk-spec-item">
                                <span class="rk-spec-label">{{ $attr->filter->nom }} :</span>
                                <span class="rk-spec-value" style="font-weight: 700;">{{ $attr->value }}{{ $attr->filter->unit ? ' ' . $attr->filter->unit : '' }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            
            @if($annonce->vendeur && $annonce->vendeur->type === 'professionnel')
            <!-- Seller Info: Only shown for Pro sellers -->
            <div class="rk-seller-card" style="background: #ffffff; padding: 1.5rem 0; margin-top: 0.5rem; border-radius: 0; border-top: 1px solid #f0f0f0; border-bottom: 1px solid #f0f0f0;">
                <div class="rk-seller-flex" style="display: flex; align-items: center; gap: 1.25rem;">
                     <div class="rk-seller-avatar" style="width: 50px; height: 50px; background: #ffffff; border: 1px solid #eee; border-radius: 4px; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 2px;">
                         @if($annonce->vendeur->type === 'professionnel' && $annonce->vendeur->pagePro && $annonce->vendeur->pagePro->logo)
                            <img src="{{ Storage::url($annonce->vendeur->pagePro->logo) }}" alt="Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                         @else
                            <i class="fas fa-store" style="font-size: 1.2rem; color: #adb5bd;"></i>
                         @endif
                     </div>
                     <div class="rk-seller-info" style="flex: 1;">
                          <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 2px;">
                            <span style="font-size: 0.75rem; color: #6c757d; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Vendeur vérifié</span>
                         </div>
                          <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                            @if($annonce->vendeur->type === 'professionnel')
                                <a href="{{ $annonce->vendeur->getBoutiqueUrl() ?? '#' }}" class="rk-seller-name" style="color: #1a1a1a; font-weight: 600; font-size: 1rem; text-decoration: none; transition: color 0.2s;">
                                    {{ $annonce->vendeur->identite }}
                                </a>
                                <span style="background: #ffffff; color: #333; font-size: 9px; font-weight: 700; padding: 1px 7px; letter-spacing: 1px; border-radius: 0; text-transform: uppercase; border: 1px solid #ddd;">PRO</span>
                            @else
                                <span class="rk-seller-name" style="color: #1a1a1a; font-weight: 600; font-size: 1rem;">
                                    {{ $annonce->vendeur->identite ?? ($annonce->user->prenom . ' ' . $annonce->user->nom) }}
                                </span>
                                <span style="background: #f8f9fa; color: #666; font-size: 9px; font-weight: 700; padding: 1px 7px; letter-spacing: 1px; border-radius: 0; text-transform: uppercase; border: 1px solid #ddd;">Particulier</span>
                            @endif

                            <span style="display: inline-flex; align-items: center; gap: 8px; margin-left: 6px; font-size: 0.85rem; flex-wrap: wrap;">
                                <span style="color: #f68b1e; font-weight: 700;"><i class="fas fa-star"></i> {{ number_format($boutique_rating, 1, ',', '') }}/5</span>
                                <span style="color: #888;">{{ number_format($boutique_avis_count, 0, ',', ' ') }} avis</span>
                            </span>
                         </div>
                     </div>
                     @if($annonce->vendeur->type === 'professionnel')
                     <div class="seller-action-wrap" style="margin-left: auto; margin-right: 1.25rem;">
                        <a href="{{ $annonce->vendeur->getBoutiqueUrl() ?? '#' }}" style="display: inline-block; font-size: 0.85rem; color: #fff; background: #2196F3; font-weight: 600; text-decoration: none; padding: 0.5rem 1.1rem; border-radius: 0; transition: background 0.2s;" onmouseover="this.style.background='#1976d2'" onmouseout="this.style.background='#2196F3'">Voir la boutique</a>
                     </div>
                     @else
                     <div class="seller-action-wrap" style="margin-left: auto; margin-right: 1.25rem;">
                        <a href="#" style="display: inline-block; font-size: 0.85rem; color: #fff; background: #2196F3; font-weight: 600; text-decoration: none; padding: 0.5rem 1.1rem; border-radius: 0; transition: background 0.2s;" onmouseover="this.style.background='#1976d2'" onmouseout="this.style.background='#2196F3'">Voir le profil</a>
                     </div>
                     @endif
                </div>
            </div>
            @endif

        </div>

        <!-- Colonne Livraison & Retours -->
        <div class="rk-delivery-col">
            <div class="rk-deliv-card">
                <div class="rk-deliv-header">Livraison &amp; retours</div>
                <div class="rk-deliv-body">
                    @if($estEcommerce)
                        <div class="rk-deliv-item">
                            <i class="fas fa-truck"></i>
                            <div>
                                <div class="rk-deliv-title">Livraison à domicile</div>
                                <div class="rk-deliv-sub">
                                    Recevez votre colis directement à votre adresse.
                                    @if(($shippingFees['domicile'] ?? null) !== null)
                                        <br>Frais : <strong style="color:#f68b1e;">{{ number_format($shippingFees['domicile'], 0, ',', ' ') }} FCFA</strong>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="rk-deliv-item">
                            <i class="fas fa-store"></i>
                            <div>
                                <div class="rk-deliv-title">Retrait en point relais</div>
                                <div class="rk-deliv-sub">
                                    Récupérez votre colis dans un point relais proche de chez vous.
                                    @if(($shippingFees['point_relais'] ?? null) !== null)
                                        <br>Frais : <strong style="color:#f68b1e;">{{ number_format($shippingFees['point_relais'], 0, ',', ' ') }} FCFA</strong>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="rk-deliv-item">
                            <i class="fas fa-box-open"></i>
                            <div>
                                <div class="rk-deliv-title">Suivi de commande</div>
                                <div class="rk-deliv-sub">Suivez l'acheminement de votre colis depuis « Mes commandes ».</div>
                            </div>
                        </div>
                    @else
                        <div class="rk-deliv-item">
                            <i class="fas fa-truck"></i>
                            <div>
                                <div class="rk-deliv-title">Livraison à domicile</div>
                                <div class="rk-deliv-sub">Non applicable pour ce type d'annonce.</div>
                            </div>
                        </div>
                        <div class="rk-deliv-item">
                            <i class="fas fa-store"></i>
                            <div>
                                <div class="rk-deliv-title">Retrait en point relais</div>
                                <div class="rk-deliv-sub">Non applicable pour ce type d'annonce.</div>
                            </div>
                        </div>
                        <div class="rk-deliv-item">
                            <i class="fas fa-comments"></i>
                            <div>
                                <div class="rk-deliv-title">Modalités à convenir</div>
                                <div class="rk-deliv-sub">Contactez directement le vendeur pour organiser la visite, l'essai ou la prestation et convenir des modalités.</div>
                            </div>
                        </div>
                    @endif
                    <div class="rk-deliv-item">
                        <i class="fas fa-flag"></i>
                        <div>
                            <div class="rk-deliv-title">Retour &amp; litige</div>
                            <div class="rk-deliv-sub">
                                Un problème avec cette annonce ?
                                <br><a href="{{ route('signalements.create', $annonce) }}" style="color:#dc2626; font-weight:600; text-decoration:none;">Signaler l'annonce</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div id="avis" class="rk-section-header" style="max-width: 1248px; margin: 2rem auto 0.75rem auto; padding: 0 1rem; background: transparent;">
        <h2 class="rk-offers-title" style="margin-top: 0; font-size: 1rem;">Avis et commentaires</h2>
    </div>

    @if($annonce->avisApprouves->count() > 0)
    <div class="rk-main-grid" style="margin-top: 1rem; grid-template-columns: 300px 1fr; grid-template-areas: none; gap: 4rem; max-width: 1248px;">
        <!-- Left: Rating Summary (Style Sidebar Page Pro) -->
        <div class="rating-summary-col">
            <div style="background: #f8f9fa; padding: 2rem; border-radius: 12px; position: sticky; top: 100px;">
                <div style="text-align: center; margin-bottom: 2rem;">
                    <div style="font-size: 3rem; font-weight: 800; color: #1a1a1a; line-height: 1;">{{ number_format($annonce->note_moyenne, 1) }}</div>
                    <div class="rk-stars" style="font-size: 1.2rem; margin: 0.5rem 0;">
                        @for($i=1; $i<=5; $i++)
                            <i class="fas fa-star" style="{{ $i <= $annonce->note_moyenne ? 'color: #ffbc00;' : 'color: #ddd;' }}"></i>
                        @endfor
                    </div>
                    <div style="color: #666; font-size: 0.9rem;">Basé sur {{ $annonce->nombre_avis }} avis</div>
                </div>

                <div class="rating-distributions">
                    @php
                        $stats = [
                            5 => $annonce->avisApprouves->where('note', 5)->count(),
                            4 => $annonce->avisApprouves->where('note', 4)->count(),
                            3 => $annonce->avisApprouves->where('note', 3)->count(),
                            2 => $annonce->avisApprouves->where('note', 2)->count(),
                            1 => $annonce->avisApprouves->where('note', 1)->count(),
                        ];
                        $total = max(1, $annonce->nombre_avis);
                    @endphp
                    @foreach([5, 4, 3, 2, 1] as $seuil)
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; font-size: 0.85rem;">
                            <span style="width: 45px; color: #555; white-space: nowrap;">{{ $seuil }} <i class="fas fa-star" style="color: #ffbc00; font-size: 0.7rem;"></i></span>
                            <div style="flex: 1; height: 8px; background: #eee; border-radius: 4px; overflow: hidden;">
                                <div style="width: {{ ($stats[$seuil] / $total) * 100 }}%; height: 100%; background: #ffbc00;"></div>
                            </div>
                            <span style="color: #999; width: 25px; text-align: right;">{{ $stats[$seuil] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right: Reviews List -->
        <div class="reviews-list-col">
            <div style="display: flex; flex-direction: column; gap: 2rem;">
                @foreach($annonce->avisApprouves as $avis)
                    <div style="padding-bottom: 2rem; border-bottom: 1px solid #f0f0f0;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 45px; height: 45px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #999; font-size: 0.9rem;">
                                    {{ strtoupper(substr($avis->user->prenom, 0, 1)) }}{{ strtoupper(substr($avis->user->nom, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #1a1a1a;">{{ $avis->user->prenom }} {{ $avis->user->nom }}</div>
                                    <div class="rk-stars" style="font-size: 0.75rem;">
                                        @for($i=1; $i<=5; $i++)
                                            <i class="fas fa-star" style="{{ $i <= $avis->note ? 'color: #ffbc00;' : 'color: #ddd;' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <span style="color: #888; font-size: 0.85rem;">{{ $avis->created_at->translatedFormat('d F Y') }}</span>
                        </div>
                        <p style="font-size: 0.95rem; color: #444; line-height: 1.6; margin: 0; padding-left: 60px;">{{ $avis->commentaire }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div style="max-width: 1248px; margin: 0 auto; padding: 2.5rem 1rem; background: #fff; border-radius: 8px; text-align: center; color: #888;">
        <i class="far fa-comment-dots" style="font-size: 2rem; color: #ddd; display: block; margin-bottom: 0.75rem;"></i>
        <div style="font-size: 0.95rem;">Aucun commentaire pour le moment.</div>
        <div style="font-size: 0.85rem; color: #aaa; margin-top: 0.25rem;">Soyez le premier à laisser un avis sur cette annonce.</div>
    </div>
    @endif

    <!-- Best Offers Section -->
    @if(isset($recommandations['meilleures_offres_pro']) && $recommandations['meilleures_offres_pro']->count() > 0)
    <div class="rk-section-header" style="max-width: 1248px; margin: 0.5rem auto 0.75rem auto; padding: 0 1rem; background: transparent;">
        <span class="rk-sponsor-label">Sponsorisée</span>
        <h2 class="rk-offers-title" style="margin-top: 0; font-size: 1rem;">Meilleures offres Pros</h2>
    </div>
    <div class="rk-sponsor-section" style="background: #fff; padding: 1.5rem 1rem 2rem 1rem; max-width: 1248px; margin: 0 auto; border-radius: 8px;">
        <div class="rakuten-product-carousel-container" style="max-width: 1280px; margin: 0 auto; background: #fff; position: relative; padding: 0 40px;">
        <button class="carousel-arrow-btn prev" onclick="scrollCarousel('carousel-pro', -1)" style="left: 0; border-radius: 0 50% 50% 0; border-left: none;"><i class="fas fa-chevron-left"></i></button>
        <div class="n1-top-grid" id="carousel-pro" style="display: flex; flex-wrap: nowrap; overflow-x: hidden; scroll-behavior: smooth; padding: 20px 0; gap: 15px;">
            @foreach($recommandations['meilleures_offres_pro'] as $rec)
                @include('partials.product-card-premium', ['annonce' => $rec])
            @endforeach
        </div>
        <button class="carousel-arrow-btn next" onclick="scrollCarousel('carousel-pro', 1)" style="right: 0; border-radius: 50% 0 0 50%; border-right: none;"><i class="fas fa-chevron-right"></i></button>
    </div>
    </div>
    @endif

    <!-- Clients Also Viewed Section -->
    @if(isset($recommandations['aussi_vus']) && $recommandations['aussi_vus']->count() > 0)
    <div class="rk-section-header" style="max-width: 1248px; margin: 0.5rem auto 0.75rem auto; padding: 0 1rem; background: transparent;">
        <h2 class="rk-offers-title" style="margin-top: 0; font-size: 1rem;">Articles également vus</h2>
    </div>
    <div style="background: #fff; padding: 1.5rem 1rem 3rem 1rem; max-width: 1248px; margin: 0 auto; border-radius: 8px;">
        <div class="rakuten-product-carousel-container" style="max-width: 1280px; margin: 0 auto; background: #fff; position: relative; padding: 0 40px;">
            <button class="carousel-arrow-btn prev" onclick="scrollCarousel('carousel-seen', -1)" style="left: 0; border-radius: 0 50% 50% 0; border-left: none;"><i class="fas fa-chevron-left"></i></button>
            <div class="n1-top-grid" id="carousel-seen">
                @foreach($recommandations['aussi_vus'] as $rec)
                    @include('partials.product-card-premium', ['annonce' => $rec, 'hideSeller' => true])
                @endforeach
            </div>
            <button class="carousel-arrow-btn next" onclick="scrollCarousel('carousel-seen', 1)" style="right: 0; border-radius: 50% 0 0 50%; border-right: none;"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
    @endif
</div>

{{-- Floating Quick Chat Window --}}
@if(auth()->check())
<div id="quick-chat-window" style="position: fixed; bottom: 0; right: 30px; width: 400px; height: 550px; background: #fff; border-top-left-radius: 12px; border-top-right-radius: 12px; box-shadow: 0 5px 40px rgba(0,0,0,0.2); z-index: 9999; display: none; flex-direction: column; overflow: hidden; border: 1px solid #e2e8f0; border-bottom: none;">
    <div style="background: #fff; padding: 14px 20px; border-bottom: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;" id="quick-chat-header">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 34px; height: 32px; border-radius: 50%; background: #ea580c; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: 800;">
                <i class="fas fa-comment-dots"></i>
            </div>
            <div>
                <div style="font-weight: 700; font-size: 0.9rem; color: #1e293b;">Messagerie</div>
                <div style="font-size: 0.75rem; color: #10b981; font-weight: 600;">Discuter à l'instant</div>
            </div>
        </div>
        <div style="display: flex; gap: 14px; align-items: center;">
            <a href="{{ route('conversations.index') }}" target="_blank" title="Plein écran" style="color: #64748b; font-size: 0.95rem;"><i class="fas fa-expand-alt"></i></a>
            <i class="fas fa-times" onclick="closeQuickChat()" style="color: #64748b; cursor: pointer; font-size: 1.2rem; padding: 4px;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#64748b'"></i>
        </div>
    </div>
    <iframe id="quick-chat-iframe" src="" style="width: 100%; height: calc(100% - 60px); border: none; background: #fff;"></iframe>
</div>

<style>
    #quick-chat-window.active { display: flex !important; }

    /* Popup messagerie en plein écran sur mobile */
    @media (max-width: 600px) {
        #quick-chat-window {
            right: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 88vh !important;
            height: 88dvh !important;
            border-top-left-radius: 14px;
            border-top-right-radius: 14px;
        }
    }
</style>
@endif

@push('scripts')
<script>
    const basePrice = {{ $annonce->prix_affiche }};
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
                const imgHtml = `<img id="display-image" src="${url}" alt="{{ $annonce->titre }}" style="width: 100%; height: 100%; object-fit: contain;">`;
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
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
            }
            icon.style.color = '#e11d48';
        })
        .catch(error => {
            console.error('Error:', error);
            btn.style.opacity = '1';
            btn.style.pointerEvents = 'auto';
        });
    });

    // Quick Chat Functions
    function openQuickChat(url) {
        // Add iframe=1 parameter to tell the layout to hide everything
        const chatUrl = url + (url.includes('?') ? '&' : '?') + 'layout=mini';
        const iframe = document.getElementById('quick-chat-iframe');
        const window = document.getElementById('quick-chat-window');
        
        iframe.src = chatUrl;
        window.classList.add('active');
    }

    function closeQuickChat() {
        document.getElementById('quick-chat-window').classList.remove('active');
        document.getElementById('quick-chat-iframe').src = "";
    }
</script>
@endpush
@endsection
