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
                                <div class="banner-bg-image" style="background-image: url('{{ $banner->image_url }}')"></div>
                                
                                <div class="banner-inner-container">
                                    <div class="banner-text-content">
                                        <a href="{{ $banner->link_url ?? '#' }}" class="banner-cta">En profiter</a>
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

    </div>
@endsection

@push('styles')
<style>
    .main-content {
        background: white;
        padding-top: 0;
    }

    .home-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    /* News Tabs */
    .news-tabs {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        border-bottom: none;
    }
    .news-tab-btn {
        padding: 0.6rem 1.2rem;
        background: none;
        border: none;
        border-bottom: 2px solid transparent;
        font-size: 0.9rem;
        font-weight: 500;
        color: #666;
        cursor: pointer;
        transition: all 0.2s;
    }
    .news-tab-btn:hover {
        color: #333;
    }
    .news-tab-btn.active {
        color: #333;
        border-bottom-color: #333;
        font-weight: 700;
    }

    /* Bento Grid */
    .bento-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        grid-template-rows: auto auto;
        gap: 12px;
        margin-top: 1rem;
    }
    .bento-item {
        display: block;
        background: #f5f5f5;
        border-radius: 10px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        position: relative;
    }
    .bento-item.large {
        grid-row: span 2;
        grid-column: span 1;
    }
    .bento-item.small {
        /* default: 1 col, 1 row */
    }
    .bento-item.wide {
        grid-column: span 2;
        display: flex;
        flex-direction: row;
    }
    .bento-item.wide .bento-img-wrapper {
        width: 50%;
        flex-shrink: 0;
    }
    .bento-item.wide .bento-content {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 1.25rem;
    }
    .bento-img-wrapper {
        width: 100%;
        height: 160px;
        overflow: hidden;
    }
    .bento-item.large .bento-img-wrapper {
        height: 340px;
    }
    .bento-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .bento-content {
        padding: 1rem 1.25rem 1.25rem;
    }
    .bento-content h3 {
        font-size: 0.9rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 0.2rem;
    }
    .bento-content p {
        font-size: 0.8rem;
        color: #666;
        margin: 0;
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
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 2rem;
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
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
