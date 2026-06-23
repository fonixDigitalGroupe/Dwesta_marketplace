@extends('layouts.app')

@section('title', $pagePro->vendeur->identite . ' - Boutique Officielle')

@push('styles')
<style>
    html, body {
        background-color: white;
    }

    /* Hide number input spinners */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }

    /* Global Shop Styles */
    .shop-container {
        background-color: white;
        max-width: none;
        margin: 0 auto;
        padding: 0 0 4rem 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    /* Header / Banner Area */
    .shop-header-container {
        position: relative;
        margin-bottom: 0; /* Reduced as card is now sticky and adds its own space */
        width: 100%;
    }

    .shop-banner {
        height: 240px;
        background-color: #fff;
        background-size: cover; /* Back to cover for full width as requested */
        background-position: center 20%; /* Prioritize top for the text */
        width: 100%;
    }

    /* Floating identity card */
    .shop-identity-card {
        position: sticky;
        top: 0px; /* Adjust if the main site header is also sticky */
        margin: -60px auto 0 auto; /* Negative margin to overlap banner */
        width: 100%;
        max-width: 1250px; /* Increased from 1150px */
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.02);
        padding: 15px 30px;
        display: flex;
        align-items: center;
        z-index: 1000;
        gap: 25px;
        border: 1px solid #eee;
        transition: all 0.3s ease;
    }

    .shop-logo-box {
        width: 80px;
        height: 80px;
        background: white;
        border: 1px solid #eee;
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
        flex-shrink: 0;
    }

    .shop-logo-box img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .shop-meta-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .shop-name-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .shop-name-text {
        font-size: 1.4rem;
        font-weight: 800;
        color: #1a1a1a;
    }

    .tag-pro {
        background: #fff;
        color: #666;
        font-size: 9px;
        font-weight: 800;
        padding: 2px 6px;
        border: 1px solid #ddd;
        border-radius: 10px;
        text-transform: uppercase;
    }

    .shop-stats-row {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.85rem;
        color: #666;
    }

    .shop-rating-stars { color: #ffc107; font-size: 0.8rem; }
    
    .mentions-legales {
        font-size: 0.75rem;
        color: {{ $pagePro->couleur_primaire ?? '#004aad' }};
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: 5px;
        transition: color 0.2s;
    }

    .mentions-legales:hover {
        filter: brightness(0.9);
        text-decoration: underline;
    }

    /* Internal Search Bar */
    .shop-search-container {
        width: 350px;
        position: relative;
    }

    .shop-search-input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 0.9rem;
        background: #fbfbfb;
        outline: none;
    }

    .shop-search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #999;
    }

    .mobile-filter-trigger, .close-filters-btn {
        display: none;
    }

    /* Layout structure */
    .shop-layout {
        margin-top: 0;
        display: grid;
        grid-template-columns: 240px 1fr;
        gap: 0; 
        border-top: 1px solid #eee;
        padding-bottom: 0;
    }

    /* Main Content Area Styling */
    .shop-info-section {
        background: transparent;
        border: none;
        padding: 10px 40px;
        margin-bottom: 0;
        border-bottom: 1px solid #eeeeee;
    }

    .shop-breadcrumb {
        font-size: 0.75rem;
        color: #999;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
    }

    .shop-breadcrumb a { color: #999; text-decoration: none; }
    .shop-breadcrumb a:hover { text-decoration: underline; }

    .shop-title-main {
        font-size: 1.8rem;
        font-weight: 800;
        color: #000;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .shop-description-text {
        font-size: 0.95rem;
        line-height: 1.5;
        color: #666;
        max-width: 850px;
        margin-bottom: 5px;
    }

    .voir-plus-link {
        font-weight: 700;
        color: #333;
        text-decoration: underline;
        margin-left: 5px;
        cursor: pointer;
    }



    /* Responsive Design Refinements */
    @media (max-width: 768px) {
        .shop-banner {
            height: 160px;
        }

        .shop-identity-card {
            flex-direction: column;
            margin: -40px 10px 0 10px;
            padding: 20px;
            gap: 15px;
            position: relative; /* Remove sticky on mobile to save space */
            width: auto;
            text-align: center;
        }

        .shop-logo-box {
            width: 70px;
            height: 70px;
            margin-top: -50px; /* Overlap effect even more on mobile */
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .shop-meta-info {
            align-items: center;
        }

        .shop-name-row {
            flex-direction: column;
            gap: 5px;
        }

        .shop-name-text {
            font-size: 1.2rem;
        }

        .shop-search-container {
            width: 100%;
        }

        .shop-layout {
            grid-template-columns: 1fr;
        }

        .shop-sidebar {
            display: none; /* Collapsed by default on mobile */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 2000;
            overflow-y: auto;
            padding: 60px 20px 20px 20px;
        }

        .shop-sidebar.active {
            display: block;
        }

        .close-filters-btn {
            display: block;
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
        }

        .mobile-filter-trigger {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #f8f8f8;
            border: 1px solid #ddd;
            padding: 12px;
            margin: 15px 15px 0 15px;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
        }

        .shop-info-section {
            padding: 20px 15px;
            text-align: center;
        }

        .shop-breadcrumb {
            justify-content: center;
            flex-wrap: wrap;
        }

        .shop-title-main {
            font-size: 1.4rem;
            text-align: center;
            word-wrap: break-word;
            width: 100%;
        }

        .shop-description-text {
            text-align: center;
            font-size: 0.88rem;
            margin: 0 auto;
        }

        .products-header {
            display: none !important;
        }

        .products-grid-container {
            grid-template-columns: 1fr !important;
        }

        .product-card {
            flex-direction: row !important;
            flex-wrap: wrap !important; /* Allow button to wrap to a new line */
            padding: 12px !important;
            min-height: auto !important;
            gap: 12px !important;
            align-items: flex-start !important;
            border-right: none;
            border-bottom: 1px solid #f0f0f0;
            display: flex !important;
        }

        .product-image-container {
            width: 90px !important;
            height: 90px !important;
            flex-shrink: 0 !important;
            margin-bottom: 0 !important;
        }

        .product-info {
            flex: 1 !important;
            gap: 2px !important;
            display: flex !important;
            flex-direction: column !important;
            overflow: hidden;
        }

        .product-title {
            font-size: 0.9rem !important;
            line-height: 1.2 !important;
            margin-bottom: 2px !important;
            font-weight: 700 !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-subtitle {
            font-size: 0.75rem !important;
            color: #888 !important;
            margin-bottom: 5px !important;
        }

        .product-price-row {
            margin-top: 5px !important;
            display: flex !important;
            align-items: baseline !important;
            gap: 5px !important;
        }

        .product-price-value {
            font-size: 1.15rem !important;
            color: #ff9900 !important; /* Back to Orange */
            font-weight: 700 !important;
        }

        .product-status {
            font-size: 0.75rem !important;
            color: #ff9900 !important;
            font-weight: 600;
        }

        .review-stars {
            font-size: 0.75rem !important;
            margin: 5px 0 !important;
            display: flex !important;
        }

        .btn-voir-produit {
            display: flex !important;
            width: 100% !important;
            margin-top: 10px !important;
            justify-content: center !important;
            padding: 10px !important;
            border: 1px solid #ddd !important;
            border-radius: 6px !important;
            background: #fff !important;
            font-weight: 600 !important;
        }

        /* Sticky Bottom Navigation */
        .mobile-bottom-nav {
            display: flex;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50px;
            background: #444;
            z-index: 1001;
            color: white;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }

        .bottom-nav-item {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.9rem;
            font-weight: 500;
            border-right: 1px solid #555;
        }

        .bottom-nav-item:last-child { border-right: none; }

        .mobile-filter-trigger { display: none; } /* Replaced by bottom nav */
        
        .shop-container { padding-bottom: 60px; } /* Space for bottom nav */

        .custom-pagination {
            gap: 20px;
            padding: 20px 10px;
        }

        .pagination-next-btn {
            padding: 10px 15px;
            font-size: 0.9rem;
        }
    }



    /* Sidebar Styling Refinement */
    .shop-sidebar {
        border-right: 1px solid #eeeeee;
        padding: 0;
        background: #fff;
    }

    .sidebar-section {
        padding: 15px 20px;
        border-bottom: 1px solid #eeeeee;
    }

    .sidebar-section:last-child { border-bottom: none; }

    .sidebar-header {
        font-size: 0.75rem;
        font-weight: 800;
        color: #000;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .sidebar-subtitle {
        font-size: 0.75rem;
        font-weight: 800;
        color: #000;
        text-transform: uppercase;
        margin-bottom: 10px;
        display: block;
    }

    .category-list, .status-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
        color: #333;
        font-size: 0.95rem;
    }

    .category-item.parent {
        font-weight: 700;
        color: #000;
    }

    .category-item.child {
        padding-left: 15px;
        color: #666;
        font-size: 0.9rem;
    }

    .category-item:hover { color: {{ $pagePro->couleur_primaire ?? '#004aad' }}; text-decoration: underline; }
    .category-item.active { color: {{ $pagePro->couleur_primaire ?? '#004aad' }}; font-weight: 800; text-decoration: underline; }

    /* Custom Checkbox Color */
    input[type="checkbox"] {
        accent-color: {{ $pagePro->couleur_primaire ?? '#004aad' }};
    }

    .sidebar-menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu li a {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        color: #333;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .sidebar-menu li a:hover {
        color: #000;
        font-weight: 700;
    }

    .sidebar-menu li a.active {
        color: #000;
        font-weight: 800;
    }

    .filter-count {
        color: #999;
        font-size: 0.75rem;
        font-weight: 400;
    }

    /* Price Filter Rakuten Style */
    .price-filter-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .price-input-box {
        position: relative;
        flex: 1;
    }

    .price-input-box input {
        width: 100%;
        padding: 8px 22px 8px 8px;
        border: 1px solid #eee;
        border-radius: 4px;
        font-size: 0.85rem;
        outline: none;
        box-sizing: border-box;
        background: #f9f9f9;
    }

    .price-currency {
        position: absolute;
        right: 7px;
        top: 50%;
        transform: translateY(-50%);
        font-weight: 500;
        font-size: 0.7rem;
        color: #aaa;
        letter-spacing: 0.5px;
        pointer-events: none;
        user-select: none;
    }

    .btn-price-ok {
        background: {{ $pagePro->couleur_primaire ?? '#004aad' }}; /* Dynamic Theme Color */
        color: #fff;
        border: none;
        padding: 5px 12px;
        border-radius: 4px;
        font-weight: 700;
        font-size: 0.8rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-price-ok:hover {
        filter: brightness(0.9);
    }

    /* Checkbox list (Shipping & Reviews) */
    .status-list { list-style: none; padding: 0; margin: 0; }
    .filter-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 0.85rem;
        color: #333;
        cursor: pointer;
    }

    .filter-item input {
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: {{ $pagePro->couleur_primaire ?? '#004aad' }};
    }

    .star-rating {
        color: #f5a623;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 3px;
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
        padding: 12px 40px;
        background: white;
        border-top: 1px solid #eeeeee;
        border-bottom: 1px solid #eeeeee;
    }

    .products-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .products-header-right {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 4px;
    }

    .view-icons {
        display: flex;
        gap: 10px;
        color: #aaa;
        font-size: 1rem;
        cursor: pointer;
    }

    .view-icons i.active, .view-icons i:hover { color: #333; }

    .view-divider {
        width: 1px;
        height: 18px;
        background: #ddd;
    }

    .products-count { font-size: 0.9rem; color: #555; }
    .products-count strong { color: #000; font-weight: 700; }

    .sort-select {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 6px 30px 6px 12px;
        color: #333;
        font-size: 0.88rem;
        outline: none;
        appearance: none;
        min-width: 180px;
        background: #ffffff; /* Fond blanc */
        cursor: pointer;
        transition: all 0.2s;
    }

    .sort-select:hover {
        background: #e8e8e8;
        border-color: #ccc;
    }

    .sort-about-link {
        font-size: 0.75rem;
        color: #666;
        margin-top: 4px;
    }

    .sort-about-link a {
        color: {{ $pagePro->couleur_primaire ?? '#004aad' }}; /* Dynamic Theme Color */
        text-decoration: underline;
        font-weight: 600;
    }

    .sort-about-link a:hover {
        filter: brightness(0.9);
    }


    .products-count { font-size: 1.1rem; color: #666; }
    
    .view-icons {
        display: flex;
        gap: 15px;
        color: #666;
        font-size: 1.1rem;
    }

    .products-grid-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        background: #fff;
        border-top: 1px solid #eeeeee;
    }

    .product-card {
        background: white;
        padding: 20px;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        min-height: 480px;
        border-right: 1px solid #eeeeee;
        border-bottom: 1px solid #eeeeee;
        position: relative;
    }

    .product-card:hover {
        z-index: 1 !important;
        box-shadow: none !important;
    }
    
    .product-image-container {
        height: 220px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-image {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .product-info {
        display: flex;
        flex-direction: column;
        gap: 3px;
        flex-grow: 1;
    }

    .product-title {
        font-size: 1rem;
        font-weight: 800;
        color: #333;
        line-height: 1.3;
        margin-bottom: 0;
    }

    .product-subtitle {
        font-size: 0.8rem;
        color: #777;
    }

    .review-stars {
        color: #f5a623;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 3px;
        margin: 2px 0;
    }

    .review-count {
        color: #007185;
        font-size: 0.8rem;
        margin-left: 5px;
        text-decoration: none;
    }

    .product-price-row {
        margin: 5px 0;
        display: flex;
        align-items: baseline;
        gap: 8px;
    }

    .product-price-value {
        font-size: 1.25rem;
        font-weight: 800;
        color: #ff9900;
    }

    .product-status {
        font-size: 0.85rem;
        color: #000;
        font-weight: 800;
        margin-left: 5px;
    }

    .btn-voir-produit {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 15px;
        border: 1px solid #333;
        color: #000;
        font-weight: 700;
        font-size: 0.85rem;
        border-radius: 4px;
        transition: background 0.2s;
        text-decoration: none;
        background: #fff;
    }

    .btn-voir-produit:hover {
        background: #f9f9f9;
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
    /* Pagination Refinement */
    .custom-pagination {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 80px;
        margin-top: 0;
        padding-top: 40px;
        padding-bottom: 30px;
        border-top: 1px solid #dfdfdf;
        border-bottom: 1px solid #dfdfdf;
        background: white;
    }

    .page-numbers {
        display: flex;
        gap: 20px;
    }

    .page-link-custom {
        text-decoration: none;
        color: #777;
        font-weight: 500;
        font-size: 1.1rem;
        padding-bottom: 5px;
        position: relative;
    }

    .page-link-custom.active {
        color: #000;
        font-weight: 800;
    }

    .page-link-custom.active::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: #000;
    }

    .pagination-next-btn {
        background: #000;
        color: white;
        text-decoration: none;
        padding: 12px 25px;
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: background 0.2s;
    }

    .pagination-next-btn:hover {
        background: #222;
    }

    .pagination-next-btn.disabled {
        background: #f5f5f5;
        color: #ccc;
        cursor: not-allowed;
        pointer-events: none;
        border: 1px solid #eee;
    }
</style>
@endpush

@section('content')
<div class="shop-container">
    
    <!-- Banner Section -->
    <div class="shop-header-container">
        <div class="shop-banner" style="{{ $pagePro->banniere ? 'background-image: url('.Storage::url($pagePro->banniere).')' : '' }}"></div>
    </div>

    <!-- Sticky Identity Card (Moved outside for persistent scroll) -->
    <div class="shop-identity-card">
        <div class="shop-logo-box">
            @if($pagePro->logo)
                <img src="{{ Storage::url($pagePro->logo) }}" alt="Logo">
            @else
                <i class="fas fa-store" style="font-size: 2rem; color: #eee;"></i>
            @endif
        </div>

        <div class="shop-meta-info">
            <div class="shop-name-row">
                <span class="shop-name-text">{{ $pagePro->nom_boutique ?? $pagePro->vendeur->identite }}</span>
                <span class="tag-pro">PRO</span>
            </div>
            <div class="shop-stats-row">
                <span class="shop-rating-stars"><i class="fas fa-star"></i> {{ number_format($boutique_rating, 1, ',', '') }}/5</span>
                <span>sur {{ number_format($boutique_sales, 0, ',', ' ') }} {{ $boutique_sales > 1 ? 'ventes' : 'vente' }}</span>
            </div>
        </div>

        <form action="{{ route('page-pro.show', $pagePro->slug) }}" method="GET" class="shop-search-container">
            <i class="fas fa-search shop-search-icon" onclick="this.parentElement.submit()" style="cursor:pointer;"></i>
            <input type="text" name="q" class="shop-search-input" value="{{ request('q') }}" placeholder="Rechercher chez {{ $pagePro->nom_boutique ?? $pagePro->vendeur->identite }}">
        </form>
    </div>

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-bottom-nav">
        <div class="bottom-nav-item" onclick="toggleFilters(true)" style="border-right: none;">
            <i class="fas fa-sliders-h"></i> Filtrer et catégories
        </div>
    </div>

    <!-- Mobile Sort Drawer (Removed sorting as per user request, keeping ID for no-error if JS remains) -->
    <div class="shop-sidebar" id="mobileSortDrawer" style="display: none;"></div>

    <!-- Main Content Layout -->
    <div class="shop-layout">
        
        <!-- Sidebar -->
        <aside class="shop-sidebar" id="mobileSidebar">
            <div class="close-filters-btn" onclick="toggleFilters(false)">
                <i class="fas fa-times"></i>
            </div>
            
            <!-- Categories Block -->
            <div class="sidebar-section">
                <div class="sidebar-header">Catégories</div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('page-pro.show', $pagePro->slug) }}" class="{{ is_null($active_category) ? 'active' : '' }}">
                            <span>Tous les produits</span>
                            <span class="filter-count">+ {{ number_format($pagePro->vendeur->annonces()->where('statut', 'publiee')->count(), 0, ',', ' ') }}</span>
                        </a>
                    </li>
                    @foreach($vendeur_categories as $cat)
                        @php
                            $isLevel3 = $cat->parent && $cat->parent->parent_id !== null;
                            $isActive = $active_category == $cat->id;
                        @endphp
                        <li style="{{ $isLevel3 ? 'margin-left: 15px;' : '' }}">
                            <a href="?category={{ $cat->id }}&sort={{ request('sort', 'latest') }}" class="{{ $isActive ? 'active' : '' }}">
                                <span>{{ $cat->nom }}</span>
                                <span class="filter-count">+ {{ number_format($cat->annonces_count, 0, ',', ' ') }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Filtres -->
            <div class="sidebar-section">
                <div class="sidebar-header">Filtres</div>
                
                <!-- Prix -->
                <div style="margin-bottom: 20px;">
                    <div class="sidebar-subtitle">Prix (FCFA)</div>
                    <div class="price-filter-row">
                        <div class="price-input-box">
                            <input type="number" id="price_min" placeholder="Min" value="{{ request('price_min') }}">
                            <span class="price-currency">CFA</span>
                        </div>
                        <span style="color: #999;">-</span>
                        <div class="price-input-box">
                            <input type="number" id="price_max" placeholder="Max" value="{{ request('price_max') }}">
                            <span class="price-currency">CFA</span>
                        </div>
                        <button class="btn-price-ok" onclick="applyPriceFilter()">Ok</button>
                    </div>
                </div>

                <!-- Avis client -->
                <div style="margin-bottom: 20px;">
                    <div class="sidebar-subtitle">Avis client</div>
                    @foreach([4 => 4, 3 => 3, 2 => 2, 1 => 1] as $seuil)
                    <div class="status-item-wrap" style="margin-bottom: 8px;">
                        <label class="filter-item" style="margin-bottom: 0;">
                            <input type="checkbox" class="rating-checkbox" {{ request('rating') == $seuil ? 'checked' : '' }}>
                            <div class="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $seuil ? 'fas fa-star' : 'far fa-star' }}"></i>
                                @endfor
                            </div>
                            <span style="font-size: 0.85rem; color: #555;">& plus</span>
                            <span class="filter-count" style="margin-left: auto;">{{ $avis_stats[$seuil] ?? 0 }}</span>
                        </label>
                    </div>
                    @endforeach
                </div>

                <!-- État -->
                <div style="margin-bottom: 20px;">
                    <div class="sidebar-subtitle">État</div>
                    @foreach(['neuf' => 'Neuf', 'reconditionne' => 'Reconditionné', 'occasion' => 'Occasion'] as $val => $label)
                    <label class="filter-item">
                        <input type="checkbox" class="etat-checkbox" data-val="{{ $val }}" {{ request('etat') == $val ? 'checked' : '' }}>
                        <span>{{ $label }}</span>
                    </label>
                    @endforeach
                </div>

                @if($category_filters->count() > 0)
                <!-- Critères dynamiques -->
                <div style="margin-top: 20px; border-top: 1px solid #eee; padding-top: 20px;">
                    <div class="sidebar-header" style="margin-bottom: 15px;">Critères</div>
                    @foreach($category_filters as $filter)
                    <div style="margin-bottom: 15px;">
                        <span class="sidebar-subtitle" style="font-size: 0.7rem; color: #666;">{{ $filter->nom }}</span>
                        @if(is_array($filter->options))
                            @foreach($filter->options as $option)
                            <label class="filter-item">
                                <input type="checkbox" class="filter-checkbox" 
                                       data-filter-id="{{ $filter->id }}" 
                                       data-val="{{ $option }}"
                                       {{ (request()->has('filters.'.$filter->id) && request('filters')[$filter->id] == $option) ? 'checked' : '' }}>
                                <span>{{ $option }}</span>
                            </label>
                            @endforeach
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </aside>

        <!-- Main Content Area -->
        <main class="shop-main">
            
            <!-- Boutique Identity Section -->
            <section class="shop-info-section">

                @if($active_category_obj)
                    {{-- MODE CATÉGORIE : arborescence + titre catégorie --}}
                    <div class="shop-breadcrumb">
                        <a href="{{ route('page-pro.show', $pagePro->slug) }}" style="font-weight:700; color:#666;">
                            {{ $pagePro->nom_boutique ?? $pagePro->vendeur->identite }}
                        </a>
                        <span style="color:#ccc;">&gt;</span>
                        {{-- Parent de la catégorie s'il existe --}}
                        @if($active_category_obj->parent)
                            <a href="?category={{ $active_category_obj->parent->id }}">{{ $active_category_obj->parent->nom }}</a>
                            <span style="color:#ccc;">&gt;</span>
                        @endif
                        <a href="?category={{ $active_category_obj->id }}" style="color:#1a1a1a; font-weight:600;">
                            {{ $active_category_obj->nom }}
                        </a>
                    </div>

                    <h1 class="shop-title-main">{{ $active_category_obj->nom }}</h1>

                @elseif(request()->filled('q'))
                    {{-- MODE RECHERCHE : breadcrumb spécifique sans description --}}
                    <div class="shop-breadcrumb">
                        <a href="{{ route('page-pro.show', $pagePro->slug) }}" style="font-weight:700; color:#666;">
                            {{ $pagePro->nom_boutique ?? $pagePro->vendeur->identite }}
                        </a>
                        <span style="color:#ccc;">&gt;</span>
                        <span style="color:#1a1a1a; font-weight:600;">Résultats pour "{{ request('q') }}"</span>
                    </div>

                    <h1 class="shop-title-main">Recherche : "{{ request('q') }}"</h1>

                @else
                    {{-- MODE TOUS LES PRODUITS : breadcrumb simple + description boutiqu --}}
                    <div class="shop-breadcrumb">
                        <a href="{{ route('page-pro.show', $pagePro->slug) }}" style="font-weight:700; color:#666;">
                            {{ $pagePro->nom_boutique ?? $pagePro->vendeur->identite }}
                        </a>
                        <span style="color:#ccc;">&gt;</span>
                        <a href="#">Tous les produits</a>
                    </div>

                    <h1 class="shop-title-main">{{ $pagePro->nom_boutique ?? $pagePro->vendeur->identite }}</h1>

                    <div class="shop-description-text">
                        {{ Str::limit($pagePro->description, 250) }}
                        @if(strlen($pagePro->description) > 250)
                            <span class="voir-plus-link">Voir plus</span>
                        @endif
                    </div>
                @endif

            </section>

            <!-- Products List -->
            <div class="products-section">
                <div class="products-header">
                    <!-- Left: count -->
                    <div class="products-header-left">
                        <div class="products-count">
                            <strong>{{ $annonces->total() }}</strong> résultats
                        </div>
                    </div>

                    <!-- Right: Sort dropdown + about link -->
                    <div class="products-header-right">
                        <div style="position:relative;">
                            <select onchange="window.location.href=this.value" class="sort-select">
                                <option value="?sort=latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Meilleures ventes</option>
                                <option value="?sort=price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                                <option value="?sort=price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                                <option value="?sort=newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Nouveautés</option>
                            </select>
                            <i class="fas fa-chevron-down" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); font-size:0.65rem; color:#999; pointer-events:none;"></i>
                        </div>
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
                                        <i class="fas fa-image fa-4x" style="color:#f0f0f0;"></i>
                                    @endif
                                </div>
                                <div class="product-info">
                                    <h3 class="product-title">{{ $annonce->titre }}</h3>
                                    <div class="product-subtitle">- {{ $annonce->categorie ? $annonce->categorie->nom : 'Divers' }}</div>
                                    
                                    <div class="product-price-row">
                                        @if($annonce->should_show_etat)
                                            <span class="product-status" style="color: {{ $annonce->etat_couleur }}; font-weight: 700;">{{ $annonce->etat_libelle }}</span>
                                            <span style="color: #666; font-size: 0.85rem; margin: 0 2px;">dès</span>
                                        @endif
                                        <span class="product-price-value">{{ number_format($annonce->prix, 0, ',', ' ') }} FCFA</span>
                                    </div>

                                    <div class="review-stars">
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
                                        <span class="review-count">({{ $nbAvis }})</span>
                                    </div>

                                    @if($annonce->vendeur && $annonce->vendeur->type === 'professionnel')
                                        <div style="font-size: 0.78rem; color: #666; margin-bottom: 10px;">
                                            par <span style="color: #333;">{{ $annonce->vendeur->identite }}</span> <span class="tag-pro" style="margin-left: 2px;">PRO</span>
                                        </div>
                                    @endif

                                    <div class="btn-voir-produit">
                                        <span>{{ $annonce->label_voir_bouton }}</span>
                                        <i class="fas fa-chevron-right" style="font-size: 0.65rem;"></i>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="custom-pagination">
                        <div class="page-numbers">
                            @for ($i = 1; $i <= $annonces->lastPage(); $i++)
                                <a href="{{ $annonces->url($i) }}" class="page-link-custom {{ $annonces->currentPage() == $i ? 'active' : '' }}">
                                    {{ $i }}
                                </a>
                            @endfor
                        </div>
                        <a href="{{ $annonces->nextPageUrl() ?? '#' }}" class="pagination-next-btn {{ !$annonces->hasMorePages() ? 'disabled' : '' }}">
                            Suivant <i class="fas fa-chevron-right" style="font-size: 0.8rem;"></i>
                        </a>
                    </div>
                @else
                    <div style="text-align: center; padding: 100px 20px; background: white; border: 1px solid #eee; border-radius: 12px;">
                        <i class="fas fa-box-open" style="font-size: 3rem; color: #eee; margin-bottom: 20px;"></i>
                        <h3 style="font-weight: 600; font-size: 1.2rem; color: #1a1a1a;">Aucun produit disponible</h3>
                        <p style="color: #666;">Ce vendeur n'a pas encore ajouté de produits dans cette section.</p>
                    </div>
                @endif
            </div>

        </main>
    </div>
</div>
@endsection

@push('scripts')
<script>
function applyPriceFilter() {
    const min = document.getElementById('price_min').value.trim();
    const max = document.getElementById('price_max').value.trim();

    // Construire l'URL en conservant les paramètres existants
    const params = new URLSearchParams(window.location.search);
    
    if (min !== '') params.set('price_min', min);
    else params.delete('price_min');
    
    if (max !== '') params.set('price_max', max);
    else params.delete('price_max');

    // Revenir à la première page
    params.delete('page');

    window.location.href = window.location.pathname + '?' + params.toString();
}

function toggleFilters(show) {
    const sidebar = document.getElementById('mobileSidebar');
    if (sidebar) {
        if (show) sidebar.classList.add('active');
        else sidebar.classList.remove('active');
    }
}

function toggleSortDrawer(show) {
    const drawer = document.getElementById('mobileSortDrawer');
    if (drawer) {
        if (show) drawer.classList.add('active');
        else drawer.classList.remove('active');
    }
}

// Permettre la touche Entrée dans les champs de prix
document.addEventListener('DOMContentLoaded', function() {
    ['price_min', 'price_max'].forEach(function(id) {
        const el = document.getElementById(id);
        if (el) el.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') applyPriceFilter();
        });
    });

    // Filtrage par note via les checkboxes
    document.querySelectorAll('.rating-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const allCheckboxes = document.querySelectorAll('.rating-checkbox');
            
            // Décocher les autres
            allCheckboxes.forEach(cb => { if (cb !== this) cb.checked = false; });

            const params = new URLSearchParams(window.location.search);
            params.delete('page');

            if (this.checked) {
                // Trouver la note associée (position dans la liste : 4, 3, 2, 1)
                const items = Array.from(allCheckboxes);
                const index = items.indexOf(this);
                const notes = [4, 3, 2, 1];
                params.set('rating', notes[index]);
            } else {
                params.delete('rating');
            }

            window.location.href = window.location.pathname + '?' + params.toString();
        });
    });

    // Filtrage par état (Neuf / Reconditionné / Occasion)
    document.querySelectorAll('.etat-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Décocher les autres
            document.querySelectorAll('.etat-checkbox').forEach(cb => {
                if (cb !== this) cb.checked = false;
            });

            const params = new URLSearchParams(window.location.search);
            params.delete('page');

            if (this.checked) {
                params.set('etat', this.dataset.val);
            } else {
                params.delete('etat');
            }

            window.location.href = window.location.pathname + '?' + params.toString();
        });
    });

    // Filtrage par critères (dynamiques)
    document.querySelectorAll('.filter-checkbox').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const filterId = this.dataset.filterId;
            // Décocher les autres pour le MÊME filtre
            document.querySelectorAll(`.filter-checkbox[data-filter-id="${filterId}"]`).forEach(cb => {
                if (cb !== this) cb.checked = false;
            });

            const params = new URLSearchParams(window.location.search);
            params.delete('page');

            if (this.checked) {
                params.set(`filters[${filterId}]`, this.dataset.val);
            } else {
                params.delete(`filters[${filterId}]`);
            }

            window.location.href = window.location.pathname + '?' + params.toString();
        });
    });
});
</script>
@endpush
