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
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0;
        }
    </style>
@endpush

@section('content')
    <div class="main-content">
        <!-- Hero Section -->
        <div
            style="background: white; padding: 3rem; border-radius: 12px; margin-bottom: 3rem; border: 1px solid #e0e0e0; min-height: 300px;">
        </div>


        <!-- Les sections d'articles ont été vidées par l'utilisateur mais les titres sont conservés -->

        <!-- Nos offres imbattables -->
        <div style="margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #333; margin: 0;">
                    Nos offres imbattables</h2>
            </div>
            <div class="promo-carousel-wrapper">
                <button class="carousel-arrow carousel-arrow-left" onclick="scrollPromoCarousel(-1)">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <div class="promo-carousel" id="promoCarousel">
                    @foreach($offresImbattables as $annonce)
                        <x-promo-card :annonce="$annonce" />
                    @endforeach
                </div>
                <button class="carousel-arrow carousel-arrow-right" onclick="scrollPromoCarousel(1)">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

        <script>
            function scrollPromoCarousel(direction) {
                const carousel = document.getElementById('promoCarousel');
                const scrollAmount = carousel.offsetWidth * 0.8;
                carousel.scrollBy({
                    left: direction * scrollAmount,
                    behavior: 'smooth'
                });
            }
        </script>

        <!-- Top des produits les plus consultés -->
        <div style="margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Top des produits les plus consultés</h2>
            </div>
            <div class="home-grid">
                @foreach($topConsultes as $annonce)
                    <x-product-item :annonce="$annonce" />
                @endforeach
            </div>
        </div>

        <!-- Nos top produits du moment -->
        <div style="margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Nos top produits du moment</h2>
            </div>
            <div class="home-grid">
                @foreach($topProduits as $annonce)
                    <x-product-item :annonce="$annonce" />
                @endforeach
            </div>
        </div>

        <!-- Dernières opportunités -->
        <div style="margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Dernières opportunités</h2>
            </div>
            <div class="home-grid">
                @foreach($dernieresOpportunites as $annonce)
                    <x-product-item :annonce="$annonce" />
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .home-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
    }
    
    .promo-carousel-wrapper {
        position: relative;
        max-width: 100%;
        margin: 0 auto;
        padding: 0 3rem;
    }
    
    .promo-carousel {
        display: flex;
        gap: 1.5rem;
        overflow-x: auto;
        scroll-behavior: smooth;
        scrollbar-width: none;
        -ms-overflow-style: none;
        padding: 0.5rem 0;
    }
    
    .promo-carousel::-webkit-scrollbar {
        display: none;
    }
    
    .promo-carousel .promo-card {
        flex: 0 0 calc(33.333% - 1rem);
        min-width: 350px;
    }
    
    .carousel-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 50%;
        width: 48px;
        height: 48px;
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
        border-color: #333;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    .carousel-arrow-left {
        left: 0;
    }
    
    .carousel-arrow-right {
        right: 0;
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
</style>
@endpush
