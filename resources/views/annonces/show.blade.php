@extends('layouts.app')

@section('title', $annonce->titre)

@section('content')
<style>
    /* Reset & Fonts */
    .product-page {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        background-color: #f6f6f6;
        padding-bottom: 4rem;
    }

    /* Breadcrumb */
    .breadcrumb {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem 1rem;
        font-size: 0.85rem;
        color: #666;
    }
    .breadcrumb a { color: #666; text-decoration: none; }
    .breadcrumb a:hover { text-decoration: underline; }

    /* Layout Main */
    .main-grid {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2rem;
        padding: 0 1rem;
    }

    /* Left Column */
    .product-main {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        overflow: hidden;
    }

    /* Image Gallery */
    .gallery-container {
        padding: 2rem;
        border-bottom: 1px solid #f0f0f0;
    }
    .main-image-box {
        width: 100%;
        height: 500px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: zoom-in;
        position: relative;
    }
    .main-image-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .thumbnails {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
        overflow-x: auto;
        padding: 0.5rem 0;
    }
    .thumb {
        width: 70px;
        height: 70px;
        border: 2px solid #e0e0e0;
        border-radius: 4px;
        cursor: pointer;
        padding: 2px;
        transition: all 0.2s;
    }
    .thumb.active { border-color: #bf0000; }
    .thumb img { width: 100%; height: 100%; object-fit: cover; }

    /* Product Header */
    .product-info { padding: 2rem; }
    .product-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }
    .product-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }
    .rating-stars { color: #ffc107; display: flex; align-items: center; gap: 0.25rem; }
    .review-count { color: #0066cc; text-decoration: none; }

    /* Badges */
    .badge-row { display: flex; gap: 0.5rem; margin-bottom: 1.5rem; }
    .badge-mm {
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-urgent { background: #bf0000; color: white; }
    .badge-pro { background: #17a2b8; color: white; }
    .badge-verified { background: #28a745; color: white; }

    /* Buy Box (Right Sidebar) */
    .buy-box {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 1.5rem;
        position: sticky;
        top: 2rem;
    }
    .price-tag {
        font-size: 2.25rem;
        font-weight: 800;
        color: #bf0000;
        margin-bottom: 0.5rem;
    }
    .price-sub { font-size: 0.9rem; color: #666; margin-bottom: 1.5rem; }
    .btn-buy {
        display: block;
        width: 100%;
        background: #bf0000;
        color: white;
        text-align: center;
        padding: 1rem;
        border-radius: 6px;
        font-size: 1.1rem;
        font-weight: bold;
        text-decoration: none;
        margin-bottom: 1rem;
        transition: background 0.2s;
        border: none;
        cursor: pointer;
    }
    .btn-buy:hover { background: #a00000; }
    .btn-secondary {
        display: block;
        width: 100%;
        background: #fff;
        border: 1px solid #bf0000;
        color: #bf0000;
        text-align: center;
        padding: 1rem;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: bold;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-secondary:hover { background: #fdf2f2; }

    /* Seller Info */
    .seller-card {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f0f0f0;
    }
    .seller-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
    .seller-avatar {
        width: 48px;
        height: 48px;
        background: #f0f0f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #999;
    }
    .seller-name { font-weight: bold; color: #333; }
    .seller-link { color: #0066cc; font-size: 0.85rem; text-decoration: none; }

    /* Sections */
    .product-section { padding: 2rem; border-top: 1px solid #f0f0f0; }
    .section-title { font-size: 1.25rem; font-weight: bold; margin-bottom: 1.5rem; color: #333; }
    .desc-content { line-height: 1.7; color: #444; }

    /* Specs Tab */
    .specs-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    .spec-item { padding: 0.75rem; background: #fafafa; border-radius: 4px; border-left: 3px solid #eee; }
    .spec-label { font-size: 0.8rem; color: #666; margin-bottom: 0.25rem; }
    .spec-value { font-weight: 600; color: #333; }

    /* Variants */
    .variant-selector { margin-bottom: 1.5rem; }
    .variant-label { font-size: 0.9rem; font-weight: bold; margin-bottom: 0.75rem; display: block; }
    .variant-options { display: flex; gap: 0.5rem; flex-wrap: wrap; }
    
    .variant-option-label { cursor: pointer; }
    .variant-radio { display: none; }
    .variant-btn {
        display: inline-block;
        padding: 0.6rem 1rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        background: white;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .variant-radio:checked + .variant-btn {
        border-color: #bf0000;
        color: #bf0000;
        background: #fdf2f2;
        font-weight: bold;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .main-grid { grid-template-columns: 1fr; }
        .buy-box { position: static; margin-bottom: 2rem; }
    }
</style>

<div class="product-page">
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> &gt; 
        @if($annonce->category)
            <a href="{{ route('categories.show', $annonce->category->slug) }}">{{ $annonce->category->nom }}</a> &gt;
        @endif
        <span>{{ $annonce->titre }}</span>
    </nav>

    <div class="main-grid">
        <!-- Content Column -->
        <div class="product-main">
            <!-- Top Section Header -->
            <div class="product-info">
                <div class="badge-row">
                    @if($annonce->options && $annonce->options->aLaUneActive())
                        <span class="badge-mm badge-urgent" style="background: #ef8b13;">À LA UNE</span>
                    @endif
                    @if($annonce->options && $annonce->options->urgentActive())
                        <span class="badge-mm badge-urgent">URGENT</span>
                    @endif
                    @if($annonce->vendeur->estVerifie())
                        <span class="badge-mm badge-verified">VÉRIFIÉ</span>
                    @endif
                    @if($annonce->vendeur->estProfessionnel())
                        <span class="badge-mm badge-pro">PRO</span>
                    @endif
                </div>

                <h1 class="product-title">{{ $annonce->titre }}</h1>
                
                <div class="product-meta">
                    @if($annonce->nombre_avis > 0)
                        <div class="rating-stars">
                            @for($i=1; $i<=5; $i++)
                                <i class="fas fa-star" style="{{ $i <= $annonce->note_moyenne ? '' : 'color: #ddd;' }}"></i>
                            @endfor
                            <span>{{ $annonce->note_moyenne }}</span>
                        </div>
                        <a href="#reviews" class="review-count">({{ $annonce->nombre_avis }} avis)</a>
                    @else
                        <span style="color: #999;">Aucun avis pour le moment</span>
                    @endif
                    <span style="color: #ccc;">|</span>
                    <span style="color: #666;">Vue par {{ $annonce->vues }} personnes</span>
                </div>
            </div>

            <!-- Gallery -->
            <div class="gallery-container">
                <div class="main-image-box" id="main-gallery">
                    @php $photoPrincipale = $annonce->photoPrincipale(); @endphp
                    @if($photoPrincipale)
                        <img id="display-image" src="{{ $photoPrincipale->url }}" alt="{{ $annonce->titre }}">
                    @else
                        <div style="font-size: 3rem; color: #eee;">📷</div>
                    @endif
                </div>
                @if($annonce->photos->count() > 1)
                    <div class="thumbnails">
                        @foreach($annonce->photos as $index => $photo)
                            <div class="thumb {{ $loop->first ? 'active' : '' }}" onclick="updateGallery('{{ $photo->url }}', this)">
                                <img src="{{ $photo->thumbnail_url ?? $photo->url }}" alt="Vue {{ $loop->iteration }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Description -->
            <div class="product-section">
                <h2 class="section-title">Description complète</h2>
                <div class="desc-content">
                    {!! nl2br(e($annonce->description)) !!}
                </div>
            </div>

            <!-- Specs Grid -->
            <div class="product-section">
                <h2 class="section-title">Fiche technique</h2>
                <div class="specs-grid">
                    <div class="spec-item">
                        <div class="spec-label">État</div>
                        <div class="spec-value">
                            @if($annonce->type == 'produit' && $annonce->produit) {{ $annonce->produit->etat ?? 'N/A' }} 
                            @elseif($annonce->type == 'vehicule' && $annonce->vehicule) {{ $annonce->vehicule->etat ?? 'N/A' }}
                            @else Neuf @endif
                        </div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-label">Disponibilité</div>
                        <div class="spec-value">{{ ucfirst(str_replace('_', ' ', $annonce->disponibilite)) }}</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-label">Catégorie</div>
                        <div class="spec-value">{{ $annonce->category->nom ?? 'Inconnue' }}</div>
                    </div>
                    <div class="spec-item">
                        <div class="spec-label">Livraison</div>
                        <div class="spec-value">
                            @if($annonce->type_livraison == 'livraison') 🚚 À domicile
                            @elseif($annonce->type_livraison == 'retrait') 📦 Point relais
                            @else Plusieurs options @endif
                        </div>
                    </div>

                    @if($annonce->type == 'vehicule' && $annonce->vehicule)
                        <div class="spec-item">
                            <div class="spec-label">Marque</div>
                            <div class="spec-value">{{ $annonce->vehicule->marque }}</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">Kilométrage</div>
                            <div class="spec-value">{{ number_format($annonce->vehicule->kilometrage, 0, ',', ' ') }} km</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Video Section (if applicable) -->
            @if($annonce->video)
            <div class="product-section">
                <h2 class="section-title">Présentation vidéo</h2>
                <div style="position: relative; padding-bottom: 56.25%; height: 0; border-radius: 8px; overflow: hidden; background: #000;">
                    <video controls style="position: absolute; top:0; left:0; width: 100%; height: 100%;">
                        <source src="{{ $annonce->video->url }}" type="{{ $annonce->video->mime_type }}">
                    </video>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column (Buy Box) -->
        <aside>
            <div class="buy-box">
                <div class="price-tag"><span id="main-price">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span></div>
                <div class="price-sub">Paiement sécurisé par Mady Market</div>

                <!-- Variants selection if any -->
                <form id="add-to-cart-form" action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="annonce_id" value="{{ $annonce->id }}">
                    
                    @if($annonce->variantes->count() > 0)
                        @php 
                            $typesVariantes = $annonce->variantes->groupBy('type');
                        @endphp
                        @foreach($typesVariantes as $type => $options)
                            <div class="variant-selector">
                                <span class="variant-label">Choisir {{ ucfirst($type) }}</span>
                                <div class="variant-options">
                                    @foreach($options as $opt)
                                        <label class="variant-option-label">
                                            <input type="radio" name="variante_id" value="{{ $opt->id }}" class="variant-radio" {{ $loop->first ? 'checked' : '' }} onchange="updatePrice('{{ $opt->prix_supplementaire }}')">
                                            <span class="variant-btn">{{ $opt->valeur }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <div style="margin-bottom: 1.5rem;">
                        <span class="variant-label">Quantité</span>
                        <input type="number" name="quantite" value="1" min="1" class="qty-input" style="width: 80px; padding: 0.8rem; border: 1px solid #ccc; border-radius: 4px;">
                    </div>

                    <button type="submit" class="btn-buy">Ajouter au panier</button>
                </form>
                <a href="#" class="btn-secondary">Ajouter aux favoris</a>

                <div class="seller-card">
                    <div class="seller-header">
                        <div class="seller-avatar">
                            {{ strtoupper(substr($annonce->vendeur->user->prenom, 0, 1)) }}
                        </div>
                        <div>
                            <div class="seller-name">
                                @if($annonce->vendeur->professionnel)
                                    {{ $annonce->vendeur->professionnel->nom_entreprise }}
                                @else
                                    {{ $annonce->vendeur->user->prenom }} {{ $annonce->vendeur->user->nom }}
                                @endif
                            </div>
                            @if($annonce->vendeur->pagePro)
                                <a href="{{ route('page-pro.show', $annonce->vendeur->pagePro->slug) }}" class="seller-link">Voir la boutique →</a>
                            @endif
                        </div>
                    </div>
                    <div style="font-size: 0.85rem; color: #666;">
                        <i class="fas fa-map-marker-alt"></i> {{ $annonce->vendeur->user->adresse ?? 'Bangui, RCA' }}
                    </div>
                </div>
            </div>

            <!-- Club R Promotion -->
            <div style="margin-top: 1.5rem; background: #fffbe6; border: 1px solid #ffe58f; border-radius: 8px; padding: 1rem; display: flex; align-items: center; gap: 0.75rem;">
                <div style="color: #faad14; font-size: 1.5rem;">💎</div>
                <div>
                    <div style="font-weight: bold; font-size: 0.9rem; color: #d48806;">Club R</div>
                    <div style="font-size: 0.8rem; color: #856404;">Cumulez 5% de ce montant en Super Points !</div>
                </div>
            </div>
        </aside>
    </div>

    <!-- Recommendations Carousel -->
    @if(isset($recommandations) && $recommandations['similaires']->count() > 0)
    <div style="max-width: 1200px; margin: 3rem auto; padding: 0 1rem;">
        <h2 class="section-title">Dans la même catégorie</h2>
        <div style="display: flex; gap: 1.5rem; overflow-x: auto; padding-bottom: 1rem;">
            @foreach($recommandations['similaires'] as $similar)
                <a href="{{ route('annonces.show', $similar) }}" style="text-decoration: none; color: inherit; min-width: 200px; background: white; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
                    <div style="width: 100%; height: 180px; background: #fff;">
                        <img src="{{ $similar->photoPrincipale()->thumbnail_url ?? $similar->photoPrincipale()->url }}" alt="{{ $similar->titre }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div style="padding: 1rem;">
                        <div style="font-weight: bold; font-size: 0.9rem; margin-bottom: 0.5rem; display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical; overflow: hidden; height: 2.5rem;">{{ $similar->titre }}</div>
                        <div style="color: #bf0000; font-weight: bold;">{{ number_format($similar->prix, 0, ',', ' ') }} FCFA</div>
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
        const total = parseFloat(basePrice) + parseFloat(extra);
        priceDisplay.innerText = total.toLocaleString('fr-FR', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) + ' FCFA';
    }

    function updateGallery(url, thumb) {
        document.getElementById('display-image').src = url;
        document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
    }
</script>
@endpush
@endsection
