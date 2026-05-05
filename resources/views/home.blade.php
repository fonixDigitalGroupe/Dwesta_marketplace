@extends('layouts.app')

@section('title', 'Votre marketplace en ligne')

@push('styles')
    <style>
        /* Styles spécifiques à la home page */
        .hero-section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: flex;
            gap: 2rem;
            align-items: center;
            border: 1px solid #e0e0e0;
        }

        .hero-text {
            flex: 1;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .hero-image {
            flex: 1;
            text-align: center;
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .category-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            color: #333;
            border: 1px solid #e0e0e0;
            transition: all 0.2s;
        }

        .category-card:hover {
            border-color: #bf0000;
            color: #bf0000;
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .category-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        .main-content {
            max-width: 1300px; /* Wider frame for premium feel */
            margin: 1.5rem auto;
            padding: 0 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="main-content">
        <!-- Hero Section -->
        <div class="hero-slider">
            <div class="slider-container" id="sliderContainer">
                @if($banners->count() > 0)
                    @foreach($banners as $banner)
                        <div class="slider-slide {{ $loop->first ? 'active' : '' }}">
                            <div class="rakuten-banner-content">
                                <!-- Background Image covering full width without gradient -->
                                <a href="{{ $banner->link_url ?? '#' }}" class="banner-bg-image" style="background-image: url('{{ $banner->image_url }}'); display: block;"></a>
                                
                                <div class="banner-inner-container">
                                    <div class="banner-text-content">
                                        @if($banner->promo_discount)
                                            <div class="banner-badge-promo" style="display: inline-block; background: #bf0000; color: #fff; padding: 4px 12px; border-radius: 4px; font-weight: 800; font-size: 0.9rem; margin-bottom: 1rem; text-transform: uppercase;">{{ $banner->promo_discount }}</div>
                                        @endif
                                        
                                        <h2 class="banner-title" style="margin-bottom: 1rem;">{!! str_replace(' ', ' <span>', $banner->title) !!}</span></h2>
                                        
                                        @if($banner->promo_code)
                                            <div style="margin-bottom: 2rem; color: #fff; font-weight: 500;">
                                                Code: <strong style="background: rgba(255,255,255,0.2); padding: 4px 8px; border-radius: 4px; border: 1px dashed #fff;">{{ $banner->promo_code }}</strong>
                                            </div>
                                        @endif

                                        @if($banner->has_payment_4x)
                                            <div class="payment-4x-badge" style="display: flex; align-items: center; gap: 8px; margin-bottom: 2rem; color: #fff; font-weight: 700;">
                                                <i class="fas fa-credit-card"></i> Paiement en 4x disponible
                                            </div>
                                        @endif

                                        <a href="{{ $banner->link_url ?? '#' }}" class="banner-cta">Découvrir <i class="fas fa-arrow-right" style="margin-left: 10px; font-size: 0.8rem;"></i></a>
                                    </div>
                                    

                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Fallback if no banners -->
                    <div class="slider-slide active">
                        <div class="rakuten-banner-content" style="background: #f9f9f9; height: 320px; display: flex; align-items: center; justify-content: center;">
                             <p style="color: #999;">Aucune bannière disponible</p>
                        </div>
                    </div>
                @endif
            </div>

            @if($banners->count() > 1)
                <button class="slider-btn prev" onclick="moveSlide(-1)">&#10094;</button>
                <button class="slider-btn next" onclick="moveSlide(1)">&#10095;</button>
                
                <div class="slider-dots">
                    @foreach($banners as $index => $banner)
                        <span class="dot {{ $loop->first ? 'active' : '' }}" onclick="currentSlide({{ $index }})"></span>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Sections Dynamiques -->
        @foreach($homeSections as $section)
            @if($section->products->count() > 0)
                <section class="n1-top-consulted-section" style="margin-top: 3rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                        <h2 class="sections-global-title" style="margin-bottom: 0; text-align: left;">{{ $section->title }}</h2>
                        @if($section->source_type == 'flash_sale')
                            <div class="flash-sale-timer" style="display: flex; align-items: center; gap: 10px; background: #fee2e2; padding: 5px 15px; border-radius: 20px; color: #dc2626; font-weight: 700; font-size: 0.9rem;">
                                <i class="fas fa-bolt"></i> VENTE FLASH <span id="timer-{{ $section->id }}">00:00:00</span>
                            </div>
                        @endif
                    </div>
                    
                    @if($section->type == 'slider' || $section->type == 'list')
                        <div class="n1-top-consulted-carousel">
                            <button class="carousel-arrow-btn btn-left" onclick="scrollCarousel('section-{{ $section->id }}', -1)" aria-label="Précédent">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                            </button>
                            
                            <div class="n1-top-grid" id="section-{{ $section->id }}">
                                @foreach($section->products as $annonce)
                                    @include('partials.product-card-premium', ['annonce' => $annonce])
                                @endforeach
                            </div>

                            <button class="carousel-arrow-btn btn-right" onclick="scrollCarousel('section-{{ $section->id }}', 1)" aria-label="Suivant">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                            </button>
                        </div>
                    @else {{-- Grid --}}
                        <div class="category-grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
                            @foreach($section->products as $annonce)
                                @include('partials.product-card-premium', ['annonce' => $annonce])
                            @endforeach
                        </div>
                    @endif
                </section>
            @endif
        @endforeach

        @if(isset($topConsultes) && $topConsultes->count() > 0)
        <section class="n1-top-consulted-section" style="margin-top: 4rem;">
            <h2 class="sections-global-title">Top des produits les plus consultés</h2>
            
            <div class="n1-top-consulted-carousel">
                <button class="carousel-arrow-btn btn-left" onclick="scrollCarousel('n1-top-products', -1)" aria-label="Précédent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                
                <div class="n1-top-grid" id="n1-top-products">
                    @foreach($topConsultes as $annonce)
                        @include('partials.product-card-premium', ['annonce' => $annonce])
                    @endforeach
                </div>

                <button class="carousel-arrow-btn btn-right" onclick="scrollCarousel('n1-top-products', 1)" aria-label="Suivant">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>

            <div class="n1-top-footer">
                <a href="{{ route('search.index', ['sort' => 'vues_desc']) }}" class="btn-clean-pill">Voir plus</a>
            </div>
        </section>
        @endif

        @if(isset($highlightTabs) && $highlightTabs->count() > 0)
        <!-- Actualités (Bento Grid) -->
        <section class="actualites-section">
            <div class="actualites-container">
                <h2 class="sections-global-title">Les actualités Karnou à ne pas manquer</h2>
                
                <div class="news-tabs">
                    @foreach($highlightTabs as $tab)
                        <button class="news-tab-btn {{ $loop->first ? 'active' : '' }}" 
                                onclick="switchNewsTab('tab-{{ $tab->id }}', this)">
                            {{ $tab->name }}
                        </button>
                    @endforeach
                </div>

                <div class="news-tab-contents">
                    @foreach($highlightTabs as $tab)
                        <div id="tab-{{ $tab->id }}" class="news-tab-content {{ $loop->first ? 'active' : '' }}">
                            <div class="bento-grid">
                                @php
                                    $highlights = $tab->highlights->keyBy('position');
                                @endphp
                                
                                {{-- Position 1: Grand Carré Gauche --}}
                                @if(isset($highlights[1]))
                                    <a href="{{ $highlights[1]->link_url ?? '#' }}" class="bento-item large">
                                        <div class="bento-img-wrapper">
                                            <img src="{{ $highlights[1]->image_url }}" alt="{{ $highlights[1]->title }}">
                                        </div>
                                        <div class="bento-content">
                                            <h3>{{ $highlights[1]->title }}</h3>
                                            <p>{{ $highlights[1]->subtitle }}</p>
                                        </div>
                                    </a>
                                @endif

                                <div class="bento-small-group">
                                    {{-- Position 2: Petit Haut Droite --}}
                                    @if(isset($highlights[2]))
                                        <a href="{{ $highlights[2]->link_url ?? '#' }}" class="bento-item small">
                                            <div class="bento-img-wrapper">
                                                <img src="{{ $highlights[2]->image_url }}" alt="{{ $highlights[2]->title }}">
                                            </div>
                                            <div class="bento-content">
                                                <h3>{{ $highlights[2]->title }}</h3>
                                                <p>{{ $highlights[2]->subtitle }}</p>
                                            </div>
                                        </a>
                                    @endif

                                    {{-- Position 3: Petit Bas Droite --}}
                                    @if(isset($highlights[3]))
                                        <a href="{{ $highlights[3]->link_url ?? '#' }}" class="bento-item small">
                                            <div class="bento-img-wrapper">
                                                <img src="{{ $highlights[3]->image_url }}" alt="{{ $highlights[3]->title }}">
                                            </div>
                                            <div class="bento-content">
                                                <h3>{{ $highlights[3]->title }}</h3>
                                                <p>{{ $highlights[3]->subtitle }}</p>
                                            </div>
                                        </a>
                                    @endif
                                </div>

                                {{-- Position 4: Large Horizontal Bas --}}
                                @if(isset($highlights[4]))
                                    <a href="{{ $highlights[4]->link_url ?? '#' }}" class="bento-item wide">
                                        <div class="bento-img-wrapper">
                                            <img src="{{ $highlights[4]->image_url }}" alt="{{ $highlights[4]->title }}">
                                        </div>
                                        <div class="bento-content">
                                            <div class="wide-header">
                                                <span class="category-tag">{{ $tab->name }}</span>
                                                <h3>{{ $highlights[4]->title }}</h3>
                                            </div>
                                            <p>{{ $highlights[4]->subtitle }}</p>
                                            <span class="btn-discover">Découvrir <i class="fas fa-arrow-right"></i></span>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Nos top produits du moment (Tabs Section) -->
        <section class="top-produits-moment-section">
            <div class="actualites-container">
                <h2 class="sections-global-title">Nos top produits du moment</h2>
                
                <div class="news-tabs">
                    <button class="news-tab-btn active" onclick="switchMainTab('tab-neufs', this)">Neufs</button>
                    <button class="news-tab-btn" onclick="switchMainTab('tab-reconditionnes', this)">Reconditionné certifié</button>
                    <button class="news-tab-btn" onclick="switchMainTab('tab-occasions', this)">Occasion</button>
                </div>

                <div class="main-tab-contents">
                    {{-- Tab: Neufs --}}
                    <div id="tab-neufs" class="main-tab-content active">
                        <div class="product-carousel-wrapper">
                            <button class="carousel-arrow-btn prev" onclick="scrollCarousel('carousel-neufs', -1)" style="left: -20px;"><i class="fas fa-chevron-left"></i></button>
                            <div class="n1-top-grid" id="carousel-neufs">
                                @foreach($topNeufs as $annonce)
                                    @include('partials.product-card-premium', ['annonce' => $annonce])
                                @endforeach
                            </div>
                            <button class="carousel-arrow-btn next" onclick="scrollCarousel('carousel-neufs', 1)" style="right: -20px;"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>

                    {{-- Tab: Reconditionnés --}}
                    <div id="tab-reconditionnes" class="main-tab-content">
                        <div class="product-carousel-wrapper">
                            <button class="carousel-arrow-btn prev" onclick="scrollCarousel('carousel-reco', -1)" style="left: -20px;"><i class="fas fa-chevron-left"></i></button>
                            <div class="n1-top-grid" id="carousel-reco">
                                @foreach($topReconditionnes as $annonce)
                                    @include('partials.product-card-premium', ['annonce' => $annonce])
                                @endforeach
                            </div>
                            <button class="carousel-arrow-btn next" onclick="scrollCarousel('carousel-reco', 1)" style="right: -20px;"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>

                    {{-- Tab: Occasions --}}
                    <div id="tab-occasions" class="main-tab-content">
                        <div class="product-carousel-wrapper">
                            <button class="carousel-arrow-btn prev" onclick="scrollCarousel('carousel-occasion', -1)" style="left: -20px;"><i class="fas fa-chevron-left"></i></button>
                            <div class="n1-top-grid" id="carousel-occasion">
                                @foreach($topOccasions as $annonce)
                                    @include('partials.product-card-premium', ['annonce' => $annonce])
                                @endforeach
                            </div>
                            <button class="carousel-arrow-btn next" onclick="scrollCarousel('carousel-occasion', 1)" style="right: -20px;"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- L'univers KARNOU -->
        <section class="karnou-universe-section">
            <div class="actualites-container">
                <div class="rakuten-separator-bar"></div>
                <h2 class="sections-global-title">L'univers KARNOU</h2>
                
                <div class="universe-grid">
                    <a href="#" class="universe-item">
                        <div class="universe-circle">
                            <span class="brand-part" style="color: #000; font-weight: 900; font-size: 1.15rem;">Karnou</span>
                            <span class="service-part" style="color: #bf0000; font-weight: 500; font-size: 1.15rem; margin-left: 4px;">agence</span>
                        </div>
                    </a>

                    <a href="#" class="universe-item">
                        <div class="universe-circle">
                            <span class="brand-part" style="color: #000; font-weight: 900; font-size: 1.15rem;">Karnou</span>
                            <span class="service-part" style="color: #000; font-weight: 500; font-size: 1.15rem; margin-left: 4px;">logistique</span>
                        </div>
                    </a>

                    <a href="#" class="universe-item">
                        <div class="universe-circle">
                            <span class="brand-part" style="color: #000; font-weight: 900; font-size: 1.15rem;">Karnou</span>
                            <span class="service-part" style="color: #720e9e; font-weight: 500; font-size: 1.15rem; margin-left: 4px;">services</span>
                        </div>
                    </a>
                </div>

                <!-- Barre Institutionnelle RCA -->
                <div class="rca-legal-bar">
                    <div class="rca-flag-container">
                        <div class="rca-flag">
                            <div class="rca-stripe stripe-blue"></div>
                            <div class="rca-stripe stripe-white"></div>
                            <div class="rca-stripe stripe-green"></div>
                            <div class="rca-stripe stripe-yellow"></div>
                            <div class="rca-vertical-red"></div>
                            <div class="rca-star">★</div>
                        </div>
                    </div>
                    <div class="rca-legal-text">
                        <strong>Interdiction de vente de boissons alcooliques aux mineurs de moins de 18 ans</strong><br>
                        La preuve de majorité de l'acheteur est exigée au moment de la vente en ligne.
                        <div class="rca-legal-subtext">CODE DE LA SANTÉ PUBLIQUE, ART. L. 3342-1 ET L. 3353-3</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Marketing Footer Section -->
        <section class="marketing-footer-section">
            <div class="marketing-footer-container">
                <p><strong>Karnou est la marketplace leader pour l'achat de produits neufs, reconditionnés ou d'occasion au meilleur prix</strong></p>
            </div>
        </section>

        <!-- Le meilleur de nos catégories -->
        @if(isset($bestCategories) && count($bestCategories) > 0)
        <section class="best-categories-section">
            <div class="actualites-container">
                <h2 class="sections-global-title">Le meilleur de nos catégories</h2>
                
                <div class="best-categories-grid">
                    @foreach($bestCategories as $data)
                        <div class="best-category-col">
                            <h3 class="best-category-title">{{ $data['title'] }}</h3>
                            <ul class="best-category-list">
                                @foreach($data['items'] as $item)
                                    <li><a href="{{ route('search.index', ['category' => $item->id]) }}" title="{{ $item->nom }}">{{ $item->nom }}</a></li>
                                @endforeach
                            </ul>
                            <a href="{{ route('search.index', ['category' => $data['parent']->id]) }}" class="best-category-more">Voir plus</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </div>
@endsection

@push('styles')
<style>
    .main-content {
        background: white;
        padding-top: 0;
    }

    /* Actualités Section */
    .actualites-section {
        padding: 4rem 0;
        background: #fff;
        border-top: 1px solid #f0f0f0;
    }
    .actualites-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .sections-global-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: #1a1a1a;
        text-align: center;
        margin-bottom: 3.5rem;
    }

    .news-tabs {
        display: flex;
        justify-content: center;
        gap: 2.5rem;
        margin-bottom: 3rem;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 0;
    }
    .news-tab-btn {
        padding: 0 0 12px 0;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        font-family: 'Outfit', sans-serif;
        font-size: 1.05rem;
        font-weight: 500;
        color: #666;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        box-shadow: none;
        border-radius: 0;
    }
    .news-tab-btn:hover {
        color: #000;
        transform: none;
    }
    .news-tab-btn.active {
        background: none;
        border-bottom-color: #000;
        color: #000;
        font-weight: 700;
        box-shadow: none;
    }
    .news-tab-btn.active::after {
        display: none;
    }

    .news-tab-content {
        display: none;
    }
    .news-tab-content.active {
        display: block;
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Bento Grid */
    .bento-grid {
        display: grid;
        grid-template-columns: 1fr 0.8fr;
        gap: 20px;
    }
    .bento-small-group {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    .bento-item {
        position: relative;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        box-shadow: none;
        border: 1px solid #eee;
    }
    .bento-item:hover {
        border-color: #ddd;
    }

    .bento-img-wrapper {
        position: relative;
        width: 100%;
        overflow: hidden;
    }
    .bento-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: none;
    }
    .bento-item:hover .bento-img-wrapper img {
        transform: none;
    }

    .bento-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #ee8800;
        color: #fff;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        z-index: 2;
    }

    .bento-item.large {
        grid-row: span 1;
    }
    .bento-item.large .bento-img-wrapper {
        height: 400px;
    }
    .bento-item.small .bento-img-wrapper {
        height: 150px;
    }
    .bento-item.wide {
        grid-column: span 2;
        flex-direction: row;
        height: 250px;
    }
    .bento-item.wide .bento-img-wrapper {
        width: 45%;
        height: 100%;
    }
    .bento-item.wide .bento-content {
        width: 55%;
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .bento-content {
        padding: 1.5rem;
    }
    .bento-content h3 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #1a1a1a;
    }
    .bento-content p {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .category-tag {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 700;
        color: #ee8800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
    }

    .btn-discover {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        font-weight: 700;
        color: #ee8800;
        margin-top: auto;
    }

    @media (max-width: 992px) {
        .bento-grid { grid-template-columns: 1fr; }
        .bento-item.wide { grid-column: span 1; flex-direction: column; height: auto; }
        .bento-item.wide .bento-img-wrapper { width: 100%; height: 200px; }
        .bento-item.wide .bento-content { width: 100%; padding: 1.5rem; }
    }

    .home-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .promo-carousel-wrapper {
        position: relative;
        max-width: 100%;
        margin: 0 auto;
        padding: 0 45px;
    }
    
    .promo-carousel {
        display: flex;
        gap: 1.5rem;
        overflow-x: hidden;
        scroll-behavior: smooth;
        padding: 1rem 0;
    }
    
    .promo-carousel .promo-card {
        flex: 0 0 calc(16.666% - 1.25rem); /* 6 items per line */
        min-width: 170px;
    }

    .promo-carousel .top-promo-card {
        flex: 0 0 calc(20% - 1.2rem); /* 5 items per line for top products */
        min-width: 200px;
    }
    
    .carousel-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .carousel-arrow:hover {
        background: #f5f5f5;
        border-color: #bf0000;
        color: #bf0000;
        transform: translateY(-50%) scale(1.1);
    }
    
    .carousel-arrow-left { border-radius: 50%; left: 0; }
    .carousel-arrow-right { border-radius: 50%; right: 0; }

    /* Rakuten-Style Hero Section CSS */
    .hero-slider {
        position: relative;
        max-width: 100%;
        margin-top: 20px; /* Reduced to push banner up */
        margin-bottom: 4rem; /* Increased spacing after banner */
        background: white;
    }
    
    .slider-container {
        position: relative;
        height: 340px; /* Increased to 340px as requested */
        width: 100%;
        overflow: visible; /* Allow shape to overflow */
    }

    .slider-slide {
        display: none;
        height: 100%;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }
    
    .slider-slide.active {
        display: block;
        z-index: 5;
    }

    .rakuten-banner-content {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
    }

    .banner-bg-image {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        z-index: 0;
    }
    .banner-bg-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0) 100%);
        z-index: 1;
    }


    .banner-inner-container {
        position: relative;
        z-index: 2;
        display: flex;
        width: 100%;
        height: 100%;
        padding: 0 5rem;
        align-items: center;
        justify-content: space-between;
    }

    .banner-logos {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .club-r-logo {
        background: white;
        padding: 4px 10px;
        border-radius: 6px;
        color: #000;
        font-weight: 900;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .club-r-logo span {
        color: #db0001;
        margin-left: 2px;
    }

    .hotels-tag {
        background: white;
        padding: 4px 10px;
        border-radius: 4px;
        color: #333;
        font-weight: bold;
        font-size: 0.75rem;
        margin-left: 10px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .banner-text-content {
        flex: 1;
        max-width: 50%;
        color: white;
        margin-top: 150px; /* Pushes the button lower on the banner */
    }

    .banner-title {
        font-size: 3.2rem;
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 2rem;
        color: white;
        text-shadow: 0 5px 20px rgba(0,0,0,0.6);
    }

    .banner-title span {
        font-weight: 900;
    }

    .banner-cta {
        display: inline-block;
        padding: 8px 36px;
        background: transparent;
        color: white;
        font-weight: 600;
        text-decoration: none;
        border-radius: 9999px;
        font-size: 1rem;
        transition: all 0.3s;
        border: 1.5px solid white;
    }

    .banner-cta:hover {
        background: white;
        color: #333;
    }

    /* Promo Card Overlay (Right Side) */
    .promo-card-wrapper {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 1.2rem;
    }

    .rakuten-promo-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem 2.5rem;
        display: flex;
        align-items: center;
        box-shadow: 0 15px 40px rgba(0,0,0,0.12);
        min-width: 280px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .promo-left {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .promo-discount {
        font-size: 3.5rem;
        font-weight: 900;
        color: #ff750f;
        line-height: 1;
        letter-spacing: -1px;
    }

    .promo-cond {
        font-size: 0.95rem;
        color: #666;
        margin: 10px 0 15px;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
    }

    .plus-icon-container {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 18px;
        height: 18px;
        border: 1px solid #999;
        border-radius: 50%;
        color: #666;
    }

    .plus-icon-inline {
        font-size: 0.75rem;
        font-weight: bold;
    }

    .promo-code-box {
        background: #333;
        color: white;
        padding: 6px 14px;
        border-radius: 4px;
        font-weight: bold;
        font-size: 1rem;
        letter-spacing: 0.5px;
    }

    .promo-divider {
        width: 1px;
        height: 70px;
        background: #eee;
        margin: 0 1.8rem;
    }

    .promo-right {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .promo-cashback {
        font-size: 2.5rem;
        font-weight: 900;
        color: #000;
        line-height: 1;
    }

    .promo-cashback-label {
        font-size: 1rem;
        font-weight: 700;
        color: #000;
        white-space: nowrap;
    }

    .payment-badge {
        background: #db0001;
        color: white;
        padding: 10px 20px;
        border-radius: 9999px;
        font-size: 1rem;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(219,0,1,0.3);
        margin-right: 20px;
    }
    
    .slider-btn {
        cursor: pointer;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        color: #333;
        font-weight: bold;
        font-size: 16px;
        transition: 0.3s;
        border-radius: 50%;
        user-select: none;
        background-color: white;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .slider-btn.next { right: 1rem; }
    .slider-btn.prev { left: 1rem; }
    
    .slider-btn:hover {
        background-color: #f1f1f1;
        transform: translateY(-50%) scale(1.05);
    }
    
    .slider-dots {
        text-align: center;
        position: absolute;
        bottom: -25px; /* Moved slightly further down as requested */
        width: 100%;
        z-index: 10;
        display: flex;
        justify-content: center;
        gap: 8px;
    }
    
    .dot {
        cursor: pointer;
        height: 8px;
        width: 8px;
        background-color: rgba(0,0,0,0.2); /* Changed to light gray for visibility on white */
        border-radius: 50%;
        display: inline-block;
        transition: all 0.3s;
    }
    
    .dot.active, .dot:hover {
        background-color: #333; /* Changed to dark gray for visibility */
        transform: scale(1.2);
    }
    
    @keyframes fade {
        from {opacity: .7} 
        to {opacity: 1}
    }

    @media (max-width: 1024px) {
        .home-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .promo-carousel .promo-card {
            flex: 0 0 calc(50% - 0.75rem);
        }
        
        .promo-carousel-wrapper {
            padding: 0 2.5rem;
        }
    }
    
    @media (max-width: 640px) {
        .home-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Top Consulted Section (Style Page Catégories) */
    .n1-top-consulted-section {
        padding: 3rem 0;
        background: #fff;
    }
    .n1-top-consulted-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.6rem;
        font-weight: 700;
        color: #333;
        text-align: center;
        margin-bottom: 2rem;
    }
    .n1-top-consulted-carousel {
        position: relative;
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 50px;
    }
    .n1-top-card {
        flex: 0 0 calc(16.66% - 13px);
        min-width: 190px;
        background: #fff;
        border: 1px solid #efefef;
        border-radius: 8px;
        padding: 1.25rem;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .n1-top-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: #ddd;
    }
    .n1-top-media {
        width: 100%;
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    .n1-top-media img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .n1-top-info {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .n1-top-item-title {
        font-size: 0.85rem;
        line-height: 1.4;
        color: #555;
        margin-bottom: 0.8rem;
        height: 2.8rem;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .n1-top-price-row {
        margin-bottom: 0.8rem;
    }
    .n1-top-price-state {
        font-size: 0.85rem;
        color: #333;
        font-weight: 500;
    }
    .n1-top-price-val {
        color: #ee8800;
        font-weight: 700;
        font-size: 1.05rem;
    }
    .n1-top-rating {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: auto;
    }
    .n1-top-stars {
        color: #ffc107;
        font-size: 0.75rem;
        display: flex;
    }
    .n1-top-rating-count {
        font-size: 0.75rem;
        color: #999;
    }

    .n1-top-footer {
        text-align: center;
        margin-top: 2rem;
    }
    .btn-voir-plus-outline {
        display: inline-block;
        padding: 0.8rem 3rem;
        border: 1.5px solid #333;
        border-radius: 999px;
        background: #fff;
        color: #333;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-voir-plus-outline:hover {
        background: #333;
        color: #fff;
    }


    .carousel-arrow-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .carousel-arrow-btn:hover { background: #f5f5f5; border-color: #ee8800; color: #ee8800; }
    .btn-left { left: 0; }
    .btn-right { right: 0; }

    @media (max-width: 1200px) {
        .n1-top-card { flex: 0 0 calc(25% - 10px); }
    }
    @media (max-width: 768px) {
        .n1-top-card { flex: 0 0 calc(50% - 10px); }
    }
</style>
@endpush

@push('scripts')
<script>
    let slideIndex = 0;
    let sliderTimer;

    function showSlides(n) {
        let slides = document.getElementsByClassName("slider-slide");
        let dots = document.getElementsByClassName("dot");
        
        if (slides.length === 0) return;
        
        if (n >= slides.length) {slideIndex = 0}
        if (n < 0) {slideIndex = slides.length - 1}
        
        for (let i = 0; i < slides.length; i++) {
            slides[i].classList.remove("active");
        }
        for (let i = 0; i < dots.length; i++) {
            dots[i].classList.remove("active");
        }
        
        if (slides[slideIndex]) slides[slideIndex].classList.add("active");
        if (dots[slideIndex]) dots[slideIndex].classList.add("active");
    }

    function moveSlide(n) {
        slideIndex += n;
        showSlides(slideIndex);
        resetTimer();
    }

    function currentSlide(n) {
        slideIndex = n;
        showSlides(slideIndex);
        resetTimer();
    }

    function resetTimer() {
        clearInterval(sliderTimer);
        sliderTimer = setInterval(function() {
            moveSlide(1);
        }, 5000);
    }

    function scrollCarouselTop(id, direction) {
        const carousel = document.getElementById(id);
        const cardWidth = carousel.querySelector('.n1-top-card')?.offsetWidth + 12 || 202;
        carousel.scrollBy({
            left: cardWidth * 3 * direction,
            behavior: 'smooth'
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        showSlides(slideIndex);
        resetTimer();
    });

    function switchNewsTab(tabId, btn) {
        // Remove active class from all buttons and contents
        document.querySelectorAll('.news-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.news-tab-content').forEach(c => c.classList.remove('active'));
        
        // Add active class to selected
        btn.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    }
</script>
@endpush

@push('styles')
<style>
    /* Nos top produits du moment */
    .top-produits-moment-section {
        padding: 4rem 0;
        background: #fff;
    }
    .main-tab-content {
        display: none;
    }
    .main-tab-content.active {
        display: block;
        animation: fadeIn 0.4s ease;
    }

    .product-carousel-wrapper {
        position: relative;
        padding: 0 40px;
    }

    /* Flat Product Card (Inspiré Rakuten/Image) */
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
        padding: 1.25rem;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        transition: all 0.2s;
    }
    .premium-card-flat:hover {
        border-color: #eee;
    }

    .card-media-flat {
        width: 100%;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
    }
    .card-media-flat img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .no-photo-flat {
        font-family: 'Outfit', sans-serif;
        font-size: 0.9rem;
        color: #ccc;
        font-weight: 400;
        text-align: center;
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
        margin-bottom: 1rem;
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
        gap: 6px;
        margin-top: auto;
    }
    .price-prefix {
        font-size: 0.85rem;
        color: #333;
        font-weight: 700;
    }
    .price-value-flat {
        color: #ff8c00;
        font-weight: 700;
        font-size: 1.05rem;
    }


    .carousel-arrow-btn {
        width: 40px;
        height: 40px;
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
    .carousel-arrow-btn:hover {
        background: #f8f8f8;
        border-color: #ccc;
    }
    .carousel-arrow-btn i {
        font-size: 0.8rem;
        color: #333;
    }

    .btn-clean-pill {
        display: inline-block;
        padding: 0.75rem 3.5rem;
        border: 1px solid #331f1f;
        border-radius: 999px;
        background: #fff;
        color: #331f1f;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        font-family: 'Outfit', sans-serif;
        font-size: 0.95rem;
    }
    .btn-clean-pill:hover {
        background: #331f1f;
        color: #fff;
    }

    /* L'univers KARNOU */
    .karnou-universe-section {
        padding: 0 0 5rem 0;
        background: #fff;
    }
    .rakuten-separator-bar {
        width: 100%;
        height: 35px;
        background: #f8f8f8;
        border-radius: 999px;
        margin-bottom: 4rem;
    }
    .universe-grid {
        display: flex;
        justify-content: center;
        gap: 3rem;
        flex-wrap: wrap;
    }
    .universe-item {
        text-decoration: none;
    }
    .universe-circle {
        width: 180px;
        height: 180px;
        background: #fafafa;
        border-radius: 50%;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        box-shadow: none;
        border: none;
        padding: 30px;
    }
    .brand-part, .service-part {
        font-family: 'Outfit', sans-serif;
        white-space: nowrap;
    }

    /* Barre RCA Legal - Imposante avec double cadre */
    .rca-legal-bar {
        margin-top: 6rem;
        border: 8px double #000; /* Effet "Double Cadre" traditionnel et imposant */
        background: #fff;
        padding: 0;
        display: flex;
        align-items: stretch; /* Permet au drapeau de prendre toute la hauteur */
        justify-content: flex-start;
        width: 100%;
        max-width: 950px;
        margin: 2.5rem auto;
        min-height: 42px; /* Ultra compact */
        box-sizing: border-box;
        border: 4px double #000; /* Bordure un peu plus fine pour la petite taille */
        overflow: hidden;
    }
    
    .rca-flag-container {
        padding: 0; /* Supprimé pour que le drapeau touche les bords */
        background: #fff;
        border-right: 3px solid #000; /* Séparateur vertical plus net */
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .rca-flag {
        position: relative;
        width: 65px;
        height: 100%;
        display: flex;
        flex-direction: column;
        border: none; /* Pas de bordure interne si on touche déjà le bord */
        overflow: hidden;
    }
    
    .rca-stripe {
        flex: 1;
        width: 100%;
    }
    .stripe-blue { background: #003082; }
    .stripe-white { background: #FFFFFF; }
    .stripe-green { background: #288133; }
    .stripe-yellow { background: #FCD116; }
    
    .rca-vertical-red {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 22px; /* Proportionnel à la nouvelle largeur */
        height: 100%;
        background: #D21034;
        z-index: 2;
    }
    
    .rca-star {
        position: absolute;
        top: 4px;
        left: 8px;
        color: #FCD116;
        font-size: 14px; /* Star size adjusted */
        z-index: 3;
        line-height: 1;
    }
    
    .rca-legal-text {
        font-family: 'Outfit', sans-serif;
        font-size: 0.78rem;
        line-height: 1.1;
        color: #000;
        padding: 4px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        flex: 1;
    }
    
    .rca-legal-text strong {
        font-weight: 800;
        font-size: 1.25rem;
    }
    
    .rca-legal-subtext {
        text-align: right;
        font-size: 0.75rem;
        font-weight: 700;
        color: #000;
        margin-top: 10px;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .n1-top-footer {
        text-align: center;
        margin-top: 3rem;
        margin-bottom: 2rem;
    }

    @media (max-width: 1200px) {
        .premium-card-flat { flex: 0 0 calc(25% - 10px); }
    }
    @media (max-width: 768px) {
        .premium-card-flat { flex: 0 0 calc(45% - 10px); }
    }


    /* Le meilleur de nos catégories - Version Image */
    .best-categories-section {
        padding: 5rem 0 0;
        background: #fff;
    }
    .best-categories-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 5rem;
        max-width: 1200px;
        margin: 0 auto;
        padding-left: 4rem;
        border-bottom: 1px solid #e5e5e5; /* La ligne grise */
        padding-bottom: 1.2rem; /* Rapproché encore plus du "Voir plus" */
        margin-bottom: 3rem;
    }
    .best-category-col {
        display: flex;
        flex-direction: column;
        align-items: flex-start; /* Aligné à gauche pour le même X */
    }
    .best-category-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.25rem;
        font-weight: 900;
        color: #000;
        margin-bottom: 2.5rem;
        border-bottom: none;
        padding-bottom: 0;
    }
    .best-category-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex; /* Utilisation de flex-column pour la verticalité parfaite */
        flex-direction: column;
        gap: 0.8rem;
        margin-bottom: 2.5rem;
    }
    .best-category-list li a {
        font-size: 0.95rem;
        color: #444;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
    }
    .best-category-list li a:hover {
        color: #bf0000;
        transform: none;
    }
    .best-category-more {
        font-size: 1.05rem;
        font-weight: 900;
        color: #000;
        text-decoration: none;
        margin-top: auto;
        display: inline-block;
        transition: opacity 0.2s;
    }
    .best-category-more:hover {
        text-decoration: none;
        opacity: 0.7;
    }
    .best-category-more::after {
        display: none; /* Supprimé pour correspondre à l'image */
    }

    @media (max-width: 1200px) {
        .best-categories-grid { gap: 3rem; }
    }
    @media (max-width: 1024px) {
        .best-categories-grid { grid-template-columns: repeat(2, 1fr); gap: 4rem; }
    }
    @media (max-width: 600px) {
        .best-categories-grid { grid-template-columns: 1fr; }
    }

    /* Marketing Footer */
    .marketing-footer-section {
        background: #f6f6f6;
        padding: 3.5rem 1rem;
        margin-top: 0;
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        border-top: 1px solid #eee;
    }
    .marketing-footer-container {
        max-width: 1100px;
        margin: 0 auto;
        text-align: center;
    }
    .marketing-footer-container p {
        font-family: 'Outfit', sans-serif;
        font-size: 1.3rem;
        color: #1a1a1a;
        line-height: 1.5;
        margin: 0;
    }

    @media (max-width: 768px) {
        .marketing-footer-container p {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function switchMainTab(tabId, btn) {
        // Parent container scope
        const section = btn.closest('.top-produits-moment-section');
        
        // Buttons
        section.querySelectorAll('.news-tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        // Contents
        section.querySelectorAll('.main-tab-content').forEach(c => c.classList.remove('active'));
        section.querySelector('#' + tabId).classList.add('active');
    }

    function scrollCarousel(id, direction) {
        const carousel = document.getElementById(id);
        const scrollAmount = carousel.offsetWidth * 0.8;
        carousel.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }

    // Scope specific switch function for News Bento
    function switchNewsTab(tabId, btn) {
        const section = btn.closest('.actualites-section');
        section.querySelectorAll('.news-tab-btn').forEach(b => b.classList.remove('active'));
        section.querySelectorAll('.news-tab-content').forEach(c => c.classList.remove('active'));
        btn.classList.add('active');
        section.querySelector('#' + tabId).classList.add('active');
    }

    // Flash Sale Countdown Timer
    function updateTimers() {
        const timers = document.querySelectorAll('[id^="timer-"]');
        timers.forEach(timer => {
            let now = new Date().getTime();
            let countTo = new Date().setHours(23, 59, 59, 999); // Simulation
            
            let distance = countTo - now;
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            timer.innerHTML = 
                (hours < 10 ? "0" + hours : hours) + ":" + 
                (minutes < 10 ? "0" + minutes : minutes) + ":" + 
                (seconds < 10 ? "0" + seconds : seconds);
            
            if (distance < 0) {
                timer.innerHTML = "EXPIRED";
            }
        });
    }
    setInterval(updateTimers, 1000);
    updateTimers();
</script>
@endpush
