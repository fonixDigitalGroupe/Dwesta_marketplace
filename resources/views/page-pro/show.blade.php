@extends('layouts.app')

@section('title', $pagePro->vendeur->identite . ' - Boutique Officielle')

@push('styles')
<style>
    /* Global Shop Styles */
    .shop-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem 3rem;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    /* Header / Banner Area */
    .shop-header {
        position: relative;
        margin-bottom: 3rem;
        background: white;
        border-radius: 0 0 12px 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .shop-banner {
        height: 300px;
        background-color: #eee;
        background-size: cover;
        background-position: center;
        position: relative;
    }
    
    .shop-banner::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100px;
        background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
    }

    .shop-info-bar {
        position: relative;
        padding: 20px 30px;
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-top: -80px; /* Overlap banner */
        z-index: 10;
        flex-wrap: wrap;
        gap: 20px;
    }

    .shop-identity {
        display: flex;
        align-items: flex-end;
        gap: 20px;
    }

    .shop-logo {
        width: 160px;
        height: 160px;
        background: white;
        border-radius: 12px;
        border: 4px solid white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        object-fit: cover;
        flex-shrink: 0;
    }

    .shop-logo-placeholder {
        width: 160px;
        height: 160px;
        background: #f5f5f5;
        border-radius: 12px;
        border: 4px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: bold;
        color: #ddd;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .shop-text {
        padding-bottom: 10px;
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5); /* Shadow for banner overlap */
    }

    .shop-name {
        font-size: 2rem;
        font-weight: 800;
        margin: 0 0 5px 0;
        line-height: 1.2;
    }

    .shop-badges {
        display: flex;
        gap: 10px;
    }

    .badge {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 50px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-verified {
        background: #e3f2fd;
        color: #1565c0;
        display: flex;
        align-items: center;
        gap: 5px;
        text-shadow: none;
    }

    .badge-pro {
        background: #f3e5f5;
        color: #7b1fa2;
        text-shadow: none;
    }

    .shop-actions {
        padding-bottom: 10px;
        display: flex;
        gap: 10px;
    }

    .btn-contact {
        background: {{ $pagePro->couleur_primaire ?? '#333' }};
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: opacity 0.2s;
        text-shadow: none;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .btn-contact:hover { opacity: 0.9; }

    /* Fix text color when not overlapping banner for responsiveness if wrapped */
    @media (max-width: 768px) {
        .shop-info-bar {
            margin-top: 0;
            background: white;
            padding: 20px;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }
        .shop-identity {
            flex-direction: column;
            align-items: center;
            width: 100%;
        }
        .shop-logo, .shop-logo-placeholder {
            margin-top: -90px;
        }
        .shop-text {
            color: #333;
            text-shadow: none;
            padding-bottom: 0;
        }
        .shop-actions {
            padding-bottom: 0;
            width: 100%;
            justify-content: center;
        }
        .shop-grid {
            grid-template-columns: 1fr; /* Stack sidebar and content */
        }
    }

    /* Main Content Layout */
    .shop-grid {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
    }

    /* Sidebar Styles */
    .shop-sidebar {
        align-self: start;
    }

    .sidebar-block {
        background: white;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .sidebar-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #333;
        border-bottom: 2px solid {{ $pagePro->couleur_primaire ?? '#f0f0f0' }};
        padding-bottom: 10px;
        display: inline-block;
    }

    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category-list li a {
        display: block;
        padding: 8px 0;
        color: #666;
        text-decoration: none;
        border-bottom: 1px solid #f9f9f9;
        transition: color 0.2s;
    }

    .category-list li a:hover, .category-list li a.active {
        color: {{ $pagePro->couleur_primaire ?? '#bf0000' }};
        font-weight: 600;
    }

    .contact-info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        color: #555;
        font-size: 0.9rem;
    }

    .contact-info-item svg { width: 18px; height: 18px; color: #999; }
    .contact-info-item a { color: inherit; text-decoration: none; }
    .contact-info-item a:hover { text-decoration: underline; }

    /* Product Grid */
    .products-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .products-count { font-size: 1.1rem; color: #666; }
    
    .sort-select {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px 10px;
        color: #555;
        outline: none;
    }

    .products-grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 20px;
    }

    .product-card {
        background: white;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: #ddd;
    }

    .product-image-container {
        height: 200px;
        background: #f9f9f9;
        position: relative;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .product-title {
        font-size: 0.95rem;
        font-weight: 500;
        margin-bottom: 5px;
        color: #333;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #bf0000;
        margin-top: auto;
    }

    /* About Section (Bottom) */
    .about-section {
        margin-top: 40px;
        background: white;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 30px;
    }

    .reviews-mini {
        background: #fcfcfc;
        border-top: 1px solid #eee;
        padding-top: 15px;
        margin-top: 15px;
    }
    .review-item {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 8px;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 8px;
    }
    .star-rating { color: #fbc02d; font-size: 0.9rem; }
    
</style>
@endpush

@section('content')
<div class="shop-container">
    
    <!-- Banner & Header -->
    <header class="shop-header">
        <div class="shop-banner" style="{{ $pagePro->banniere ? 'background-image: url('.Storage::url($pagePro->banniere).')' : '' }}"></div>
        
        <div class="shop-info-bar">
            <div class="shop-identity">
                @if($pagePro->logo)
                    <img src="{{ Storage::url($pagePro->logo) }}" class="shop-logo" alt="Logo">
                @else
                    <div class="shop-logo-placeholder">
                        {{ substr($pagePro->vendeur->identite, 0, 1) }}
                    </div>
                @endif

                <div class="shop-text">
                    <h1 class="shop-name">{{ $pagePro->vendeur->identite }}</h1>
                    <div class="shop-badges">
                        @if($pagePro->vendeur->estVerifie())
                            <span class="badge badge-verified">
                                <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Vérifié
                            </span>
                        @endif
                        @if($pagePro->vendeur->estProfessionnel())
                            <span class="badge badge-pro">PRO</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="shop-actions">
                <a href="{{ route('conversations.create', ['recipient_id' => $pagePro->vendeur->user->id]) }}" class="btn-contact">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Contacter le vendeur
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Layout -->
    <div class="shop-grid">
        
        <!-- Sidebar -->
        <aside class="shop-sidebar">
            <!-- Contact Info Block -->
            <div class="sidebar-block">
                <h3 class="sidebar-title">Contact</h3>
                @if($pagePro->telephone_contact)
                    <div class="contact-info-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>{{ $pagePro->telephone_contact }}</span>
                    </div>
                @endif
                @if($pagePro->email_contact)
                    <div class="contact-info-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span class="text-truncate">{{ $pagePro->email_contact }}</span>
                    </div>
                @endif
                @if($pagePro->site_web)
                    <div class="contact-info-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        <a href="{{ $pagePro->site_web }}" target="_blank">Visiter le site web</a>
                    </div>
                @endif
            </div>

            <!-- Categories Block -->
            <div class="sidebar-block">
                <h3 class="sidebar-title">Catégories</h3>
                <ul class="category-list">
                    <li><a href="?category=" class="{{ !request('category') ? 'active' : '' }}">Toutes les catégories</a></li>
                    @foreach($annonces->pluck('categorie')->unique('id') as $cat)
                        @if($cat)
                            <li><a href="?category={{ $cat->id }}" class="{{ request('category') == $cat->id ? 'active' : '' }}">{{ $cat->nom }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <!-- Reviews Summary Block -->
            @if($avis->count() > 0)
            <div class="sidebar-block">
                <h3 class="sidebar-title">Avis Clients</h3>
                <div style="display: flex; align-items: baseline; gap: 10px; margin-bottom: 10px;">
                    <span style="font-size: 2rem; font-weight: 800; color: #333;">4.8</span>
                    <span class="star-rating">★★★★★</span>
                </div>
                <div style="font-size: 0.9rem; color: #666;">{{ $avis->count() }} avis vérifiés</div>
                
                <div class="reviews-mini">
                    @foreach($avis->take(3) as $a)
                        <div class="review-item">
                            <div style="display: flex; justify-content: space-between;">
                                <strong>{{ $a->user->prenom }}</strong>
                                <span class="star-rating" style="font-size: 0.7rem;">{{ str_repeat('★', $a->note) }}</span>
                            </div>
                            <div style="font-style: italic; margin-top: 2px;">"{{ Str::limit($a->commentaire, 50) }}"</div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </aside>

        <!-- Product Grid Area -->
        <main>
            <!-- About Description (Mobile only or Top) -->
            @if($pagePro->description)
                <div class="about-section" style="margin-top: 0; margin-bottom: 30px;">
                    <h3 style="font-weight: 700; margin-bottom: 10px; font-size: 1.1rem;">À propos</h3>
                    <p style="color: #555; line-height: 1.6;">{{ $pagePro->description }}</p>
                </div>
            @endif

            <div class="products-header">
                <div class="products-count">
                    <strong>{{ $annonces->total() }}</strong> produits disponibles
                </div>
                <div>
                    <select onchange="window.location.href=this.value" class="sort-select">
                        <option value="?sort=latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Nouveautés</option>
                        <option value="?sort=price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                        <option value="?sort=price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                    </select>
                </div>
            </div>

            @if($annonces->count() > 0)
                <div class="products-grid-container">
                    @foreach($annonces as $annonce)
                        <a href="{{ route('annonces.show', $annonce->slug) }}" class="product-card">
                            <div class="product-image-container">
                                @if($annonce->photoPrincipale())
                                    <img src="{{ Storage::url($annonce->photoPrincipale()->chemin) }}" class="product-image" alt="{{ $annonce->titre }}">
                                @else
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #aaa;">
                                        Sans image
                                    </div>
                                @endif
                            </div>
                            <div class="product-info">
                                <h3 class="product-title">{{ $annonce->titre }}</h3>
                                <div class="product-price">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div style="margin-top: 40px;">
                    {{ $annonces->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 60px; background: white; border: 1px solid #eee; border-radius: 8px;">
                    <svg style="width: 64px; height: 64px; margin: 0 auto 20px; color: #ddd;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <h3 style="font-weight: 600; font-size: 1.2rem; color: #333;">Aucun produit trouvé</h3>
                    <p style="color: #777;">Cette boutique n'a pas encore mis de produits en ligne dans cette catégorie.</p>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
