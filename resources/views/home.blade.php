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
        <!-- Hero Section (Bannières) -->
        <div class="hero-slider">
            @if($banners->count() > 0)
                <div class="slider-container" id="sliderContainer">
                    @foreach($banners as $banner)
                        <div class="slider-slide {{ $loop->first ? 'active' : '' }}">
                            <a href="{{ $banner->link_url ?? '#' }}" class="banner-link">
                                <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="banner-image">
                                @if($banner->title)
                                    <div class="banner-caption">
                                        {{ $banner->title }}
                                    </div>
                                @endif
                            </a>
                        </div>
                    @endforeach
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
            @else
                <div style="background: white; padding: 3rem; border-radius: 12px; margin-bottom: 3rem; border: 1px solid #e0e0e0; min-height: 300px; display: flex; align-items: center; justify-content: center; color: #999;">
                    Aucune bannière disponible
                </div>
            @endif
        </div>

        <!-- Nos offres imbattables -->
        <div style="margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 700; color: #333; margin: 0;">
                    Nos offres imbattables</h2>
            </div>
            @if($offresImbattables->isNotEmpty())
                <div class="promo-carousel-wrapper">
                    <button class="carousel-arrow carousel-arrow-left" onclick="scrollCarousel('promoCarousel', -1)">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <div class="promo-carousel" id="promoCarousel">
                        @foreach($offresImbattables as $annonce)
                            <div class="promo-card">
                                <x-annonce-card :annonce="$annonce" />
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-arrow carousel-arrow-right" onclick="scrollCarousel('promoCarousel', 1)">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            @else
                <p style="text-align: center; color: #999;">Aucune offre disponible pour le moment.</p>
            @endif
        </div>

        <!-- Top des produits les plus consultés -->
        <div style="margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Top des produits les plus consultés</h2>
            </div>
            @if($topConsultes->isNotEmpty())
                <div class="home-grid">
                    @foreach($topConsultes as $annonce)
                        <x-annonce-card :annonce="$annonce" />
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: #999;">Aucun produit consulté.</p>
            @endif
        </div>

        <!-- Nos top produits du moment -->
        <div style="margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Nos top produits du moment</h2>
            </div>
            @if($topProduits->isNotEmpty())
                <div class="home-grid">
                    @foreach($topProduits as $annonce)
                        <x-annonce-card :annonce="$annonce" />
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: #999;">Aucun produit à la une.</p>
            @endif
        </div>

        <!-- Dernières opportunités -->
        <div style="margin-bottom: 5rem;">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">
                    Dernières opportunités</h2>
            </div>
            @if($dernieresOpportunites->isNotEmpty())
                <div class="home-grid">
                    @foreach($dernieresOpportunites as $annonce)
                        <x-annonce-card :annonce="$annonce" />
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: #999;">Aucune opportunité récente.</p>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
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
        flex: 0 0 calc(25% - 1.2rem);
        min-width: 280px;
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
    
    .carousel-arrow-left { left: 0; }
    .carousel-arrow-right { right: 0; }

    /* Hero Slider CSS */
    .hero-slider {
        position: relative;
        max-width: 100%;
        margin-bottom: 3rem;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .slider-container {
        position: relative;
        height: 450px;
        width: 100%;
        background: #f8f9fa;
    }
    
    .slider-slide {
        display: none;
        height: 100%;
        width: 100%;
        position: relative;
    }
    
    .slider-slide.active {
        display: block;
        animation: fade 1s ease-in-out;
    }
    
    .banner-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .banner-caption {
        position: absolute;
        bottom: 2.5rem;
        left: 2.5rem;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 1.5rem 2.5rem;
        border-radius: 8px;
        font-size: 2rem;
        font-weight: 800;
        backdrop-filter: blur(8px);
        max-width: 60%;
    }
    
    .slider-btn {
        cursor: pointer;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        color: white;
        font-weight: bold;
        font-size: 20px;
        transition: 0.3s;
        border-radius: 50%;
        user-select: none;
        background-color: rgba(255,255,255,0.2);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        margin: 0 1rem;
    }
    
    .slider-btn.next { right: 0; }
    .slider-btn.prev { left: 0; }
    
    .slider-btn:hover {
        background-color: #fff;
        color: #000;
    }
    
    .slider-dots {
        text-align: center;
        position: absolute;
        bottom: 1.5rem;
        width: 100%;
        z-index: 10;
    }
    
    .dot {
        cursor: pointer;
        height: 10px;
        width: 10px;
        margin: 0 6px;
        background-color: rgba(255,255,255,0.4);
        border-radius: 50%;
        display: inline-block;
        transition: all 0.3s;
    }
    
    .dot.active, .dot:hover {
        background-color: #fff;
        width: 30px;
        border-radius: 5px;
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

    function scrollCarousel(id, direction) {
        const carousel = document.getElementById(id);
        const scrollAmount = 300 * direction;
        carousel.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        showSlides(slideIndex);
        resetTimer();
    });
</script>
@endpush
