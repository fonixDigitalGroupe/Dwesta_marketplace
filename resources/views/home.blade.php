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

        .legal-warning-section {
            max-width: 800px;
            margin: 0 auto 1.5rem auto;
            padding: 0 2rem;
        }

        @media (max-width: 768px) {
            .legal-warning-section {
                width: 100%;
                max-width: none;
                padding: 0 10px;
            }
        }
    </style>
@endpush

@section('content')
    <div style="background: white; margin-top: -1.5rem; padding: 1.5rem 0 2rem 0;">
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

        <!-- Section Promotions & Cashback Partenaires -->
        <div class="promo-brand-carousel-wrapper">
        <button class="brand-carousel-btn prev" id="promo-brand-prev" onclick="scrollBrandCarousel(-1)" aria-label="Précédent" style="display:none;">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="promo-brand-cards" id="promo-brand-carousel">
                @foreach($proSellers as $seller)
                    <a href="{{ $seller->pagePro->url }}" class="brand-card">
                        <div class="brand-card-content">
                            <div class="brand-card-logo">
                                @if($seller->pagePro && $seller->pagePro->logo)
                                    <div class="brand-logo-circle">
                                        <img src="{{ Storage::url($seller->pagePro->logo) }}" alt="{{ $seller->identite }}">
                                    </div>
                                @else
                                    <div class="brand-logo-circle">
                                        <img src="{{ asset('mock_logos/' . ($loop->index % 2 == 0 ? 'logo1.png' : 'logo2.png')) }}" alt="{{ $seller->identite }}">
                                    </div>
                                @endif
                            </div>
                            <div class="brand-card-info">
                                <div class="brand-card-promo-val">{{ $seller->promo_val }}</div>
                                @if($seller->promo_sub)
                                    <div class="brand-card-promo-sub">{{ $seller->promo_sub }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="brand-card-middle-text">{{ $seller->identite }}</div>
                        <div class="brand-card-red-footer">
                            <div class="footer-plus-icon">
                                <i class="fas fa-plus" style="color: #fff;"></i>
                            </div>
                            <span class="footer-karnou-text">Karnou <span class="marchand-badge">Marchand Pro</span></span>
                        </div>
                    </a>
                @endforeach
            </div>

            <button class="brand-carousel-btn next" id="promo-brand-next" onclick="scrollBrandCarousel(1)" aria-label="Suivant">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <div class="main-content">

        @if(isset($topConsultes) && $topConsultes->count() > 0)
        <section class="n1-top-consulted-section" style="margin-top: 1rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 class="sections-global-title" style="margin-bottom: 0;">Top des produits les plus consultés</h2>
            </div>
            
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

            <div class="n1-top-footer" style="text-align: center; margin-top: 2rem;">
                <a href="{{ route('search.index', ['sort' => 'vues_desc']) }}" class="btn-clean-pill">Découvrir plus</a>
            </div>
        </section>
        @endif

        <!-- Sections Dynamiques -->
        @foreach($homeSections as $section)
            @if($section->products->count() > 0 && !Str::contains($section->title, ['Ventes Flash', 'Les plus consultés', 'Prix cassés', 'Nouveautés']))
                <section class="n1-top-consulted-section" style="margin-top: 3rem;">
                    <div style="text-align: center; margin-bottom: 2rem;">
                        <h2 class="sections-global-title" style="margin-bottom: 0;">{{ $section->title }}</h2>
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
                            <div class="bento-grid-custom">
                                @php
                                    $highlights = $tab->highlights->keyBy('position');
                                @endphp
                                
                                <div class="bento-left">
                                    {{-- Position 1: Grand Carré Gauche --}}
                                    @if(isset($highlights[1]))
                                        <a href="{{ $highlights[1]->link_url ?? '#' }}" class="bento-item-custom full-height">
                                            <img src="{{ $highlights[1]->image_url }}" alt="Actualité {{ $tab->name }}">
                                        </a>
                                    @endif
                                </div>

                                <div class="bento-right">
                                    <div class="bento-right-top">
                                        {{-- Position 2: Petit Haut Gauche --}}
                                        @if(isset($highlights[2]))
                                            <a href="{{ $highlights[2]->link_url ?? '#' }}" class="bento-item-custom">
                                                <img src="{{ $highlights[2]->image_url }}" alt="Actualité {{ $tab->name }}">
                                            </a>
                                        @endif

                                        {{-- Position 3: Petit Haut Droite --}}
                                        @if(isset($highlights[3]))
                                            <a href="{{ $highlights[3]->link_url ?? '#' }}" class="bento-item-custom">
                                                <img src="{{ $highlights[3]->image_url }}" alt="Actualité {{ $tab->name }}">
                                            </a>
                                        @endif
                                    </div>

                                    <div class="bento-right-bottom">
                                        {{-- Position 4: Large Horizontal Bas --}}
                                        @if(isset($highlights[4]))
                                            <a href="{{ $highlights[4]->link_url ?? '#' }}" class="bento-item-custom">
                                                <img src="{{ $highlights[4]->image_url }}" alt="Actualité {{ $tab->name }}">
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Nos top produits du moment (Tabs Section) -->
        <section class="top-produits-moment-section">
            <div style="width: 95%; margin: 0 auto;">
                <h2 class="sections-global-title">Nos top produits du moment</h2>
                
                <div class="news-tabs">
                    <button class="news-tab-btn active" onclick="switchMainTab('tab-neufs', this)">Neuf</button>
                    <button class="news-tab-btn" onclick="switchMainTab('tab-reconditionnes', this)">Reconditionné</button>
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

        <!-- Univers Karnous -->
        <section class="best-categories-section" style="margin-top: -1.5rem;">
            <style>
                .univers-karnous-grid {
                    display: flex;
                    justify-content: center;
                    gap: 3rem;
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 1rem 2rem;
                }
                .univers-item {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    text-align: center;
                    text-decoration: none;
                    color: inherit;
                    width: 280px;
                }
                .univers-circle {
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    margin-bottom: 1.5rem;
                }
                .univers-circle-1 {
                    background-color: #f5f5f5;
                }
                .univers-circle-2 {
                    background-color: #f5f5f5;
                }
                @media (max-width: 768px) {
                    .univers-karnous-grid {
                        flex-direction: column;
                        gap: 3rem;
                    }
                }
            </style>

            <div class="actualites-container">
                <div style="height: 48px; background-color: #f3f3f3; border-radius: 20px 0 0 20px; margin: 0 -40px 3rem 0;"></div>
                <h2 class="sections-global-title">Univers KARNOU</h2>
                
                <div class="univers-karnous-grid">
                    
                    <!-- Karnou Logistique -->
                    <a href="#" class="univers-item">
                        <div class="univers-circle univers-circle-1">
                            <i class="fas fa-truck-fast" style="font-size: 2.2rem; color: #ff9900;"></i>
                        </div>
                        <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; font-weight: 800; margin: 0 0 0.5rem 0; color: #222;">Karnou Logistique</h3>
                        <p style="font-size: 0.95rem; color: #666; margin: 0; line-height: 1.4;">La solution d'expédition rapide et fiable pour toutes vos livraisons.</p>
                    </a>

                    <!-- Karnou Agence -->
                    <a href="#" class="univers-item">
                        <div class="univers-circle univers-circle-2">
                            <i class="fas fa-handshake" style="font-size: 2.2rem; color: #ff9900;"></i>
                        </div>
                        <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.4rem; font-weight: 800; margin: 0 0 0.5rem 0; color: #222;">Karnou Agence</h3>
                        <p style="font-size: 0.95rem; color: #666; margin: 0; line-height: 1.4;">Notre réseau d'agences partenaires à votre service partout dans le pays.</p>
                    </a>
                    
                </div>
            </div>
        </section>

        <!-- Avertissement Légal -->
        <section class="legal-warning-section">
            <div style="border: 4px solid #000; padding: 10px 20px; display: flex; align-items: center; gap: 15px; background: #fff;">
                <div style="display: flex; flex-direction: column; align-items: center; border: 1px solid #ddd; padding: 6px 10px; flex-shrink: 0;">
                    <!-- Drapeau Centrafrique stylisé en CSS -->
                    <div style="display: flex; width: 45px; height: 30px; flex-direction: column; position: relative;">
                        <div style="background: #003082; flex:1;"></div>
                        <div style="background: #fff; flex:1;"></div>
                        <div style="background: #289728; flex:1;"></div>
                        <div style="background: #ffce00; flex:1;"></div>
                        <div style="position: absolute; left: 50%; top: 0; bottom: 0; width: 8px; background: #d21034; transform: translateX(-50%);"></div>
                        <i class="fas fa-star" style="position: absolute; top: 1px; left: 2px; color: #ffce00; font-size: 6px;"></i>
                    </div>
                    <div style="font-size: 0.45rem; text-transform: uppercase; margin-top: 4px; font-weight: 800; text-align: center; line-height: 1.1;">République<br>Centrafricaine</div>
                </div>
                <div style="flex: 1;">
                    <div style="font-weight: 900; font-size: 0.9rem; color: #111; line-height: 1.2;">Interdiction de vente de boissons alcooliques aux mineurs de moins de 18 ans</div>
                    <div style="font-size: 0.8rem; color: #333; margin-top: 2px;">La preuve de majorité de l'acheteur est exigée au moment de la vente en ligne.</div>
                </div>
            </div>
        </section>

    </div></div>
    
    <!-- SEO Block Karnou -->
    <section style="background-color: #f7f7f7; padding: 0.4rem 0 2rem 0; margin-top: 2rem; width: 100%; display: flex; align-items: flex-start; justify-content: center;">
        <div style="width: 100%; padding: 0 2rem;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #111; margin: 0; text-align: center; line-height: 1.4;">
                Karnou est la marketplace leader en République Centrafricaine pour l'achat de produits neufs, reconditionnés ou d'occasion au meilleur prix
            </h3>
        </div>
    </section>

    <!-- Le meilleur de nos catégories -->
    @if(isset($bestCategories) && count($bestCategories) > 0)
    <section class="best-categories-section" style="background-color: #fff; padding: 4rem 0;">
        <div class="actualites-container">
            <h2 class="sections-global-title">Le meilleur de nos catégories</h2>
            
            <div class="best-categories-grid">
                @foreach($bestCategories as $data)
                    <div class="best-category-col">
                        <h3 class="best-category-title">Top {{ $data['topNumber'] }} {{ $data['title'] }}</h3>
                        <ul class="best-category-list">
                            @foreach($data['items']->take(5) as $item)
                                <li><a href="{{ route('search.index', ['category' => $item->slug]) }}" title="{{ $item->nom }}" style="color: #555; text-decoration: none; font-size: 0.9rem; line-height: 1.6;">{{ $item->nom }}</a></li>
                            @endforeach
                        </ul>
                        @if($data['items']->count() > 5)
                            <a href="{{ route('search.index', ['category' => $data['root_parent']->slug]) }}" class="best-category-more" style="display: block; color: #004aad; font-weight: 700; text-decoration: none; font-size: 0.9rem;">Voir plus</a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Séparateur horizontal pleine largeur -->
        <div style="border-bottom: 2px solid #eeeeee; margin-top: 1.5rem; width: 100%;"></div>
    </section>
    @endif
@endsection

@push('styles')
<style>
    .main-content {
        background: transparent;
        padding-top: 0;
    }

    /* Supprimer l'animation pour les cartes dans Top des produits */
    #n1-top-products .premium-card-flat:hover {
        transform: none !important;
        box-shadow: none !important;
        border-color: #eee !important;
    }

    /* Actualités Section */
    .actualites-section {
        padding: 2.5rem 0;
        background: #fff;
    }
    .actualites-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .sections-global-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: #1a1a1a;
        text-align: center;
        margin-bottom: 2rem;
    }

    .news-tabs {
        display: flex;
        justify-content: center;
        gap: 4.5rem;
        margin-bottom: 3rem;
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
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Bento Grid Custom (Inspiration Leroy Merlin) */
    .bento-grid-custom {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 20px;
    }
    
    .bento-left {
        display: flex;
        flex-direction: column;
    }
    
    .bento-right {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .bento-right-top {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        flex: 1; /* Prend l'espace pour équilibrer la hauteur */
    }
    
    .bento-right-bottom {
        flex: none;
    }
    
    .bento-item-custom {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        display: block;
        height: 100%;
        width: 100%;
    }
    
    .bento-item-custom:hover {
        transform: none;
        box-shadow: none;
    }
    
    .bento-item-custom img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    
    .bento-item-custom.full-height {
        min-height: 400px;
    }
    
    .bento-right-bottom .bento-item-custom {
        height: 190px; /* Adapte la hauteur du bloc horizontal bas */
    }

    @media (max-width: 992px) {
        .bento-grid-custom { grid-template-columns: 1fr; }
        .bento-right-bottom .bento-item-custom { height: auto; min-height: 180px;}
        .bento-item-custom.full-height { min-height: 220px; }
        .news-tabs { 
            gap: 1.5rem; 
            margin-bottom: 2rem; 
            justify-content: flex-start !important;
            overflow-x: auto !important;
            white-space: nowrap;
            padding: 0 5px 15px 5px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .news-tabs::-webkit-scrollbar { display: none; }
        .news-tab-btn { flex-shrink: 0; padding-bottom: 8px; font-size: 0.95rem; }
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
    
    .carousel-arrow-left { border-radius: 50%; left: -22px; }
    .carousel-arrow-right { border-radius: 50%; right: -22px; }

    /* Rakuten-Style Hero Section CSS */
    .hero-slider {
        position: relative;
        width: 95%;
        margin: 10px auto 2rem auto;
        background: transparent;
    }
    
    .slider-container {
        position: relative;
        height: 320px;
        width: 100%;
        overflow: hidden;
        border-radius: 8px;
    }

    .slider-slide {
        display: none;
        height: 100%;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }

    @media (max-width: 768px) {
        .hero-slider {
            width: 100% !important;
            margin-top: 0;
            margin-bottom: 1.5rem;
        }

        .slider-container {
            height: 220px;
            border-radius: 0;
        }

        .actualites-container {
            padding: 0 15px;
            overflow-x: hidden; /* Prevent horizontal movement from news section */
        }

        .sections-global-title {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }
        
        .banner-inner-container {
            padding: 0 1.5rem;
        }

        /* Prevent overflow from specific components */
        .univers-karnous-grid {
            padding: 1rem 1rem !important;
            gap: 2rem !important;
        }
        
        .univers-item {
            width: 100% !important;
            max-width: 320px;
        }
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
        margin-top: 100px; /* Ajusté pour la nouvelle hauteur */
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
    
    .slider-btn.next { right: -22px; }
    .slider-btn.prev { left: -22px; }
    
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
        padding: 1.5rem 0;
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
        width: 95%;
        margin: 0 auto;
        padding: 0;
    }
    .n1-top-card {
        flex: 0 0 calc(16.66% - 13px);
        min-width: 215px;
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
    .btn-left { left: -22px; }
    .btn-right { right: -22px; }

    @media (max-width: 1200px) {
        .n1-top-card { flex: 0 0 calc(25% - 10px); }
    }
    @media (max-width: 768px) {
        .n1-top-card { flex: 0 0 calc(50% - 10px); }
    }
    .promo-brand-carousel-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 95%;
        margin: 10px auto;
        padding: 0;
    }

    .promo-brand-cards {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        scroll-behavior: smooth;
        padding: 10px 5px 10px 0;
        scrollbar-width: none; /* Firefox */
        width: 100%;
    }

    .promo-brand-cards::-webkit-scrollbar {
        display: none; /* Chrome/Safari */
    }

    .brand-card {
        flex: 0 0 310px;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: none;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .brand-carousel-btn {
        position: absolute;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: #fff;
        border: 1px solid #eee;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: transform 0.2s, background 0.2s;
        color: #333;
    }

    .brand-carousel-btn:hover {
        background: #f8f8f8;
        transform: scale(1.05);
    }

    .brand-carousel-btn.prev {
        left: -22px;
    }

    .brand-carousel-btn.next {
        right: -22px;
    }

    .brand-card-content {
        display: flex;
        align-items: center;
        padding: 1.2rem 1.2rem 0.8rem 1.2rem;
        gap: 15px;
    }

    .brand-card-logo {
        width: 100px;
        flex-shrink: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 60px;
    }
    
    .brand-card-logo img {
        max-width: 100%;
        max-height: 55px;
        object-fit: contain;
        background: #ffffff;
        padding: 2px;
        border-radius: 4px;
    }

    .brand-logo-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: none;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
    }

    .brand-logo-circle img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(1.2); /* Zoom léger pour supprimer les bordures de l'image source */
        background: transparent;
    }

    .brand-logo-circle.fallback {
        background: #f8f8f8;
        color: #999;
        font-size: 1.4rem;
        border: 1px solid #eee;
    }

    .brand-card-info {
        flex: 1.5;
        text-align: right;
    }

    .brand-card-promo-val {
        font-weight: 900;
        font-size: 1.4rem;
        color: #1a1a1a;
        line-height: 1;
    }

    .brand-card-promo-sub {
        font-size: 0.8rem;
        color: #666;
        margin-top: 4px;
    }

    .brand-card-middle-text {
        text-align: center;
        font-size: 0.95rem;
        color: #000;
        padding-bottom: 1.2rem;
        font-weight: 500;
        letter-spacing: 0;
    }

    .brand-card-red-footer {
        width: 100%;
        background: #004aad;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px;
        gap: 8px;
        margin-top: auto;
        border-radius: 0;
    }

    .footer-plus-icon {
        font-size: 0.85rem;
        color: #f39c12; /* Orange sombre */
    }

    .footer-karnou-text {
        font-weight: 400;
        font-size: 0.85rem;
        letter-spacing: 0.2px;
    }

    .marchand-badge {
        font-weight: 700;
        background: transparent;
        color: #fff;
        margin-left: 4px;
        text-transform: uppercase;
    }

    /* Ajustement responsive pour petits écrans */
    @media (max-width: 900px) {
        .promo-brand-cards {
            max-width: 100%;
        }
        .brand-card {
            flex: 0 0 calc(50% - 7.5px);
        }
    }
    @media (max-width: 600px) {
        .brand-card {
            flex: 0 0 calc(85%);
        }
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
        padding: 0.5rem 0 2.5rem 0;
        background: #fff;
    }
    .main-tab-content {
        display: none;
    }
    .main-tab-content.active {
        display: block;
    }

    .product-carousel-wrapper {
        position: relative;
        padding: 0;
    }

    /* Flat Product Card (Inspiré Rakuten/Image) */
    .n1-top-grid {
        display: flex;
        flex-wrap: nowrap;
        gap: 15px;
        overflow-x: hidden;
        scroll-behavior: smooth;
        padding: 20px 0;
    }

    .premium-card-flat {
        flex: 0 0 215px;
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
        font-size: 1rem;
        line-height: 1.3;
        color: #1a1a1a;
        margin-bottom: 6px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        font-weight: 800;
    }

    /* Avis clients */
    .card-review-row {
        display: flex;
        align-items: center;
        gap: 2px;
        color: #f5a623;
        font-size: 0.8rem;
        margin: 4px 0 6px 0;
    }
    .card-review-count {
        color: #007185;
        font-size: 0.8rem;
        margin-left: 4px;
        font-weight: 400;
    }


    .card-price-row-flat {
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
        margin-top: auto;
    }
    .price-prefix {
        font-size: 0.85rem;
        color: #333;
        font-weight: 700;
    }
    .price-value-flat {
        color: #ff9900;
        font-weight: 800;
        font-size: 1.25rem;
    }
    .card-price-separator {
        color: #bbb;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1;
    }
    .card-etat-badge {
        font-size: 0.8rem;
        font-weight: 700;
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
        padding: 0.7rem 3.5rem;
        border: 1.2px solid #1a1a1a;
        border-radius: 999px;
        background: #fdfdfd;
        color: #1a1a1a;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s;
        font-family: 'Outfit', sans-serif;
        font-size: 0.95rem;
    }
    .btn-clean-pill:hover {
        background: #f0f0f0;
        transform: translateY(-2px);
    }

    /* L'univers KARNOU */
    .karnou-universe-section {
        padding: 0 0 4rem 0;
        background: #fff;
    }
    /* L'univers KARNOU - AliExpress Style */

    /* Barre Légale Moderne */
    .rca-legal-bar-modern {
        max-width: 850px;
        margin: 0 auto;
        border: 4px double #000;
        padding: 6px 1px;
        display: flex;
        align-items: center;
        gap: 15px;
        background: #fff;
    }
    .marianne-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        border-right: 2px solid #000;
        padding-right: 15px;
        padding-left: 10px;
        min-width: 100px;
    }
    .marianne-logo {
        display: flex;
        width: 45px;
        height: 24px;
        border: 1px solid #000;
        margin-bottom: 2px;
    }
    .marianne-blue { flex: 1; background: #000091; }
    .marianne-white { 
        flex: 1; 
        background: #fff; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 10px;
        color: #000;
    }
    .marianne-red { flex: 1; background: #e1000f; }
    .marianne-text {
        font-size: 7px;
        font-weight: 900;
        line-height: 1.1;
        text-align: center;
    }
    .legal-warning-text {
        flex: 1;
        font-family: 'Outfit', sans-serif;
        font-size: 0.85rem;
        line-height: 1.2;
    }
    .legal-warning-text strong {
        font-size: 1rem;
        font-weight: 800;
    }
    .legal-warning-text span {
        font-size: 0.8rem;
        color: #333;
    }
    .legal-code {
        text-align: right;
        font-size: 0.6rem;
        font-weight: 700;
        margin-top: 2px;
        padding-right: 10px;
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


    /* Le meilleur de nos catégories - Version Image AliExpress */
    .best-categories-section {
        padding: 1rem 0 5rem 0;
        background: #fff;
    }
    .best-categories-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 3rem;
        max-width: 1350px;
        margin: 0 auto;
        padding: 0 4rem;
    }
    .best-category-col {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        height: 100%;
    }
    .best-category-title {
        font-family: 'Outfit', sans-serif;
        font-size: 1.15rem;
        font-weight: 800;
        color: #000;
        margin-bottom: 2rem;
        min-height: 3rem; /* Aligne les titres */
    }
    .best-category-list {
        list-style: none;
        padding: 0;
        margin: 0 0 1.5rem 0;
        display: grid;
        grid-template-columns: 1fr;
        gap: 0.7rem;
        flex-grow: 1; /* Prend tout l'espace restant pour pousser le bouton */
    }
    .best-category-more {
        margin-top: auto !important;
    }
    .best-category-list li a {
        font-size: 0.95rem;
        color: #333;
        font-weight: 700;
        text-decoration: none;
        transition: color 0.1s;
        display: block;
        line-height: 1.3;
    }
    .best-category-list li a:hover {
        text-decoration: underline;
    }
    .best-category-more {
        font-size: 1.05rem;
        font-weight: 800;
        color: #000;
        text-decoration: none;
        margin-top: 0.5rem;
    }
    .best-category-more:hover {
        text-decoration: underline;
    }
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
        .best-categories-grid { gap: 2rem; padding: 0 2rem; }
    }
    @media (max-width: 768px) {
        .best-categories-grid {
            display: flex !important;
            flex-wrap: nowrap !important;
            overflow-x: auto !important;
            gap: 1.5rem !important;
            padding: 0 1rem 1.5rem 1rem !important;
            scrollbar-width: none;
            -ms-overflow-style: none;
            justify-content: flex-start !important;
        }
        .best-categories-grid::-webkit-scrollbar { display: none; }
        .best-category-col {
            flex: 0 0 280px !important;
            min-width: 280px !important;
            background: #fff;
            padding: 1.25rem;
            border-radius: 12px;
            border: 1px solid #eee;
        }
    }

    /* Marketing Footer */
    .marketing-footer-section {
        background: #f6f6f6;
        padding: 2.5rem 1rem;
        margin-top: 0;
        border-top: 1px solid #eee;
    }
    .marketing-footer-container {
        max-width: 1200px;
        margin: 0 auto;
        text-align: center;
        position: relative;
    }
    .marketing-footer-container p {
        font-family: 'Outfit', sans-serif;
        font-size: 1.25rem;
        color: #333;
        font-weight: 700;
        line-height: 1.4;
        margin: 0;
    }
    .footer-arrow-down {
        margin-top: 10px;
        color: #ccc;
        font-size: 1.2rem;
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

    // Smart arrows for boutique carousel
    function updateBrandArrows() {
        const carousel = document.getElementById('promo-brand-carousel');
        const prevBtn = document.getElementById('promo-brand-prev');
        const nextBtn = document.getElementById('promo-brand-next');
        if (!carousel || !prevBtn || !nextBtn) return;
        const atStart = carousel.scrollLeft <= 2;
        const atEnd = carousel.scrollLeft + carousel.offsetWidth >= carousel.scrollWidth - 2;
        prevBtn.style.display = atStart ? 'none' : 'flex';
        nextBtn.style.display = atEnd ? 'none' : 'flex';
    }

    function scrollBrandCarousel(direction) {
        const carousel = document.getElementById('promo-brand-carousel');
        const scrollAmount = carousel.offsetWidth * 0.8;
        carousel.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
        setTimeout(updateBrandArrows, 400);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.getElementById('promo-brand-carousel');
        if (carousel) {
            updateBrandArrows();
            carousel.addEventListener('scroll', updateBrandArrows);
        }
    });

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
