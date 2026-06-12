@extends('layouts.app')

@section('title', 'Ouvrir un e-shop - Vendez sur Karnou')

@section('content')
<div class="legal-page">
    <!-- Corporate Header -->
    <header class="corporate-header">
        <div class="about-container">
            <div class="corp-header-flex">
                <div class="header-left">
                    <a href="{{ route('home') }}" class="back-to-site">
                        <i class="fa-solid fa-chevron-left"></i> <span>Retour sur le site</span>
                    </a>
                </div>
                <div class="header-center">
                    <a href="{{ route('home') }}" class="corp-logo">
                        @if($logoUrl = \App\Models\Setting::logoUrl())
                            <img src="{{ $logoUrl }}" alt="Logo">
                        @else
                            <span class="corp-brand">Karnou</span>
                        @endif
                    </a>
                </div>
                <div class="header-right">
                    @auth
                        <a href="{{ route('account.index') }}" class="header-auth">
                            <i class="fa-regular fa-user"></i> <span>{{ auth()->user()->prenom ?? auth()->user()->name }}</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="header-auth">
                            <i class="fa-regular fa-user"></i> <span>Se connecter</span>
                        </a>
                    @endauth
                    <a href="{{ route('cart.index') }}" class="header-link cart-link" title="Mon Panier">
                        <i class="fa-solid fa-cart-shopping"></i> <span>Panier</span>
                    </a>
                </div>
            </div>
        </div>
    </header>


    <!-- Page Hero Banner -->
    <div class="page-hero" style="background-image: linear-gradient(135deg, rgba(0,74,173,0.88) 0%, rgba(0,30,90,0.82) 100%), url('/images/eshop_bannier.png');">
        <div class="about-container">
            <h1>Ouvrir un e-shop</h1>
            <p class="page-hero-desc">Karnou met à votre disposition une infrastructure complète pour vendre vos produits en ligne, que vous soyez un commerçant établi ou un particulier souhaitant vendre occasionnellement.</p>
            <p class="last-update">Dernière mise à jour : 12 Janvier 2026</p>
        </div>
    </div>

    <!-- Layout -->
    <div class="legal-layout">

        <!-- TOC Sidebar -->
        <aside class="legal-toc">
            <p class="toc-title">Table des matières</p>
            <ul class="toc-list">
                <li><a href="#esh1">1 — Pourquoi vendre sur Karnou ?</a></li>
                <li><a href="#esh2">2 — Nos outils de gestion</a></li>
                <li><a href="#esh3">3 — Vendeur Particulier</a></li>
                <li><a href="#esh4">4 — Vendeur Professionnel</a></li>
                <li><a href="#esh5">5 — Comment commencer ?</a></li>
            </ul>
        </aside>

        <!-- Main -->
        <main class="legal-main">

            <article id="esh1" class="legal-article">
                <div class="article-num">01</div>
                <div class="article-body">
                    <h2>Pourquoi vendre sur Karnou ?</h2>
                    <p>En tant que vendeur sur Karnou, vous bénéficiez d'une visibilité sans précédent auprès de milliers d'acheteurs potentiels à travers tout le pays. Notre plateforme est optimisée pour la conversion et le référencement de vos produits.</p>
                </div>
            </article>

            <article id="esh2" class="legal-article">
                <div class="article-num">02</div>
                <div class="article-body">
                    <h2>Nos outils de gestion avancés</h2>
                    <p>Nous vous fournissons un tableau de bord complet (Seller Central) pour :</p>
                    <ul>
                        <li>Gérer vos stocks et vos variantes de produits.</li>
                        <li>Suivre vos commandes et vos livraisons.</li>
                        <li>Consulter vos statistiques de vente en temps réel.</li>
                        <li>Interagir avec vos clients via notre messagerie intégrée.</li>
                    </ul>
                </div>
            </article>

            <article id="esh3" class="legal-article">
                <div class="article-num">03</div>
                <div class="article-body">
                    <h2>Vendeur Particulier</h2>
                    <p>Ce type de compte est idéal pour vendre des objets d'occasion ou occasionnels.</p>
                    <p><strong>Avantages :</strong> Inscription ultra-rapide avec CNI, jusqu'à 10 annonces actives simultanément, interface de gestion simplifiée.</p>

                </div>
            </article>

            <article id="esh4" class="legal-article">
                <div class="article-num">04</div>
                <div class="article-body">
                        <h2 style="margin-top: 0;">Vendeur Professionnel (Recommandé)</h2>
                        <p>Dédié aux entreprises, boutiques et artisans souhaitant une présence professionnelle forte.</p>
                        <p><strong>Avantages :</strong> Page Pro exclusive (vitrine), annonces illimitées, commissions réduites, support prioritaire, accès aux abonnements premium.</p>
                </div>
            </article>

            <article id="esh5" class="legal-article">
                <div class="article-num">05</div>
                <div class="article-body">
                    <h2>Comment commencer ?</h2>
                    <p>C'est très simple : choisissez votre type de compte, remplissez le formulaire d'inscription et déposez vos justificatifs. Notre équipe validera votre compte sous 24h à 48h.</p>
                </div>
            </article>

        </main>
    </div>
</div>

@push('styles')
<style>
    /* Force hide marketplace elements */
    .top-banner, .header { display: none !important; visibility: hidden !important; height: 0 !important; overflow: hidden !important; }
    body { padding-top: 0 !important; margin-top: 0 !important; background: #ffffff !important; }


    /* --- Base --- */
    .legal-page { background: #ffffff; min-height: 100vh; position: relative; z-index: 1000; }
    .about-container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }

    /* --- Corporate Header --- */
    .corporate-header { background: #fff; padding: 1rem 0; border-bottom: 1px solid #eee; font-family: 'Inter', sans-serif; position: sticky; top: 0; z-index: 1000; }
    .corporate-header .about-container { max-width: 1350px; padding: 0 1.5rem; }
    .corp-header-flex { display: flex; justify-content: space-between; align-items: center; }

    .header-left, .header-right { flex: 1 1 0px; display: flex; align-items: center; }
    .header-center { flex: 0 0 auto; display: flex; justify-content: center; }
    .header-right { justify-content: flex-end; gap: 1.5rem; }

    /* --- Page Hero --- */
    .page-hero { 
        background-size: cover; 
        background-position: center; 
        padding: 5rem 0 4rem; 
        text-align: center;
        color: #fff;
    }
    .page-hero h1 { 
        font-family: 'Outfit', sans-serif; 
        font-size: 2rem; 
        font-weight: 800; 
        color: #fff; 
        margin-bottom: 0.8rem; 
        letter-spacing: -0.5px; 
    }
    .page-hero .last-update { 
        font-family: 'Inter', sans-serif; 
        font-size: 0.78rem; 
        color: rgba(255,255,255,0.45); 
        font-weight: 500; 
        text-transform: uppercase; 
        letter-spacing: 0.5px; 
    }
    .page-hero-desc { 
        font-family: 'Inter', sans-serif;
        font-size: 1rem; 
        color: rgba(255,255,255,0.8); 
        max-width: 680px; 
        margin: 0 auto 1.2rem; 
        line-height: 1.6; 
    }

    .back-to-site, .header-auth, .cart-link { text-decoration: none; color: #555; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; gap: 0.6rem; }
    .back-to-site:hover, .header-auth:hover, .cart-link:hover { color: #004aad; }
    .back-to-site i, .header-auth i, .cart-link i { font-size: 1rem; }

    .corp-logo img { height: 22px; width: auto; display: block; }
    .corp-brand { font-size: 1.25rem; font-weight: 800; color: #004aad; letter-spacing: -1px; }



    .legal-hero {
        padding: 4rem 2rem;
        color: #fff;
        min-height: 480px;
        display: flex;
        align-items: center;
    }
    .legal-hero-inner { max-width: 800px; margin: 0 auto; }
    .legal-category-badge { display: inline-block; background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; padding: 0.35rem 0.9rem; border-radius: 50px; margin-bottom: 1.2rem; font-family: 'Inter', sans-serif; border: 1px solid rgba(255,255,255,0.2); }
    .legal-hero h1 { font-size: 2.2rem; font-weight: 700; font-family: 'Outfit', 'Inter', sans-serif; color: #fff; margin: 0 0 0.8rem; letter-spacing: -0.5px; line-height: 1.2; }
    .legal-hero-desc { font-size: 1rem; color: rgba(255,255,255,0.8); font-family: 'Inter', sans-serif; margin: 0 0 1.5rem; line-height: 1.6; }
    .legal-meta { display: flex; align-items: center; gap: 0.6rem; font-size: 0.85rem; color: rgba(255,255,255,0.7); font-family: 'Inter', sans-serif; flex-wrap: wrap; }
    .legal-meta i { margin-right: 0.3rem; font-size: 0.8rem; }
    .meta-sep { opacity: 0.4; }

    .legal-layout { display: flex; align-items: flex-start; max-width: 1200px; margin: 3rem auto; padding: 0 2rem; gap: 3rem; }

    .legal-toc { width: 240px; flex-shrink: 0; position: sticky; top: 80px; background: #fff; border: 1px solid #f1f3f5; border-radius: 12px; padding: 1.5rem; }
    .toc-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #999; font-family: 'Inter', sans-serif; margin: 0 0 1rem; }
    .toc-list { list-style: none; padding: 0; margin: 0; }
    .toc-list li { margin-bottom: 0.1rem; }
    .toc-list li a { display: block; font-size: 0.82rem; color: #555; text-decoration: none; font-family: 'Inter', sans-serif; padding: 0.4rem 0.6rem; border-radius: 6px; line-height: 1.4; }
    .toc-list li a:hover { background: #fff5eb; color: #f68b1e; }

    .legal-main { flex: 1; min-width: 0; }
    .legal-intro { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #555; line-height: 1.75; margin-bottom: 2rem; }

    .legal-article { display: block; padding: 0.5rem 0; margin-bottom: 2.5rem; border: none; background: transparent; border-radius: 0; box-shadow: none; }
    .article-num { display: none; }
    .article-body { width: 100%; }
    .article-body h2 { font-size: 1.4rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 1rem; }
    .article-body p { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #4b5563; line-height: 1.8; margin-bottom: 1.2rem; }
    .article-body a { color: #f68b1e; text-decoration: none; font-weight: 600; }
    .article-body a:hover { text-decoration: underline; }

    .btn-primary-corp-v2:hover { background: #003a8a; }


    @media (max-width: 900px) {
        .legal-layout { flex-direction: column; gap: 2rem; margin: 2rem auto; }
        .legal-toc { position: static; width: 100%; top: 0; padding: 1.2rem; }
        .toc-list { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; }
        .legal-hero h1 { font-size: 1.6rem; }
        .page-hero { padding: 3.5rem 0 3rem; }
        .page-hero h1 { font-size: 1.75rem; }
    }
    @media (max-width: 600px) {
        .about-container { padding: 0 1.2rem; }
        .corp-header-flex { display: flex; align-items: center; justify-content: space-between; position: relative; }
        .header-left, .header-right { flex: 0 1 auto; }
        .header-center { flex: 1; }
        .back-to-site span, .header-auth span, .cart-link span { display: none; }
        
        .header-right { gap: 1rem; }
        .back-to-site, .header-auth, .cart-link { font-size: 1.1rem; }
        .back-to-site { width: 32px; height: 32px; justify-content: center; }
        .back-to-site i { margin: 0; }

        .page-hero { padding: 2.5rem 0 2rem; }
        .page-hero h1 { font-size: 1.5rem; line-height: 1.2; }
        .page-hero-desc { font-size: 0.9rem; padding: 0 0.5rem; }

        .legal-layout { padding: 0 1rem; margin: 1.5rem auto; }
        .article-num { display: none; }
        .legal-article { padding: 1.5rem; flex-direction: column; gap: 1rem; }
        .article-body h2 { font-size: 1.15rem; margin-bottom: 0.8rem; }
        .article-body p, .article-body li { font-size: 0.9rem; line-height: 1.6; }

        .toc-list { grid-template-columns: 1fr; }
    }
</style>
@endpush

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Observer removed for static experience
    });
</script>
@endsection
