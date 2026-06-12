@extends('layouts.app')

@section('title', 'Astuces pour Vendeurs Particuliers - Karnou')

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
    <div class="page-hero" style="background-image: linear-gradient(135deg, rgba(0,74,173,0.88) 0%, rgba(0,30,90,0.82) 100%), url('/images/apropos_bannier.jpg');">
        <div class="about-container">
            <h1>Astuces Vendeurs Particuliers</h1>
            <p class="page-hero-desc">Découvrez nos conseils et bonnes pratiques pour vendre vos objets en toute sécurité et au meilleur prix sur la plateforme Karnou.</p>
            <p class="last-update">Dernière mise à jour : 11 Juin 2026</p>
        </div>
    </div>

    <!-- Layout -->
    <div class="legal-layout">

        <!-- TOC Sidebar -->
        <aside class="legal-toc">
            <p class="toc-title">Guide du vendeur</p>
            <ul class="toc-list">
                <li><a href="#tips1">1 — Des photos de qualité</a></li>
                <li><a href="#tips2">2 — Le juste prix</a></li>
                <li><a href="#tips3">3 — La transparence</a></li>
                <li><a href="#tips4">4 — Sécurité & Transactions</a></li>
            </ul>
        </aside>

        <!-- Main -->
        <main class="legal-main">

            <article id="tips1" class="legal-article">
                <div class="article-num">01</div>
                <div class="article-body">
                    <h2>Des photos qui font la différence</h2>
                    <p>La première impression est cruciale. Une annonce avec de belles photos a 7 fois plus de chances d'aboutir à une vente.</p>
                    <ul>
                        <li>Privilégiez la lumière naturelle.</li>
                        <li>Utilisez un fond neutre et propre.</li>
                        <li>Montrez l'objet sous tous ses angles.</li>
                        <li>Ne masquez pas les éventuels défauts, montrez-les en gros plan.</li>
                    </ul>
                </div>
            </article>

            <article id="tips2" class="legal-article">
                <div class="article-num">02</div>
                <div class="article-body">
                    <h2>Fixer le juste prix</h2>
                    <p>Le prix est le premier critère de décision pour un acheteur d'occasion.</p>
                    <p>Regardez à quel prix se vendent des objets similaires sur Karnou. N'hésitez pas à proposer un prix légèrement inférieur pour vendre plus rapidement, ou à laisser une petite marge de négociation si vous le souhaitez.</p>
                </div>
            </article>

            <article id="tips3" class="legal-article">
                <div class="article-num">03</div>
                <div class="article-body">
                    <h2>La transparence pour rassurer</h2>
                    <p>Un acheteur rassuré est un acheteur qui valide son panier.</p>
                    <ul>
                        <li>Rédigez un titre clair et explicite.</li>
                        <li>Mentionnez la marque, le modèle et l'état exact (neuf, très bon état, usagé).</li>
                        <li>Répondez rapidement aux messages reçus via la messagerie Karnou.</li>
                    </ul>
                </div>
            </article>

            <article id="tips4" class="legal-article">
                <div class="article-num">04</div>
                <div class="article-body">
                    <h2>Vendre en toute sécurité</h2>
                    <p>Karnou sécurise vos transactions. Pour votre tranquillité :</p>
                    <p>Restez sur la messagerie interne de la plateforme pour tous vos échanges. Ne communiquez jamais vos coordonnées bancaires en dehors de l'interface de paiement sécurisée de Karnou.</p>
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

    .back-to-site, .header-auth, .cart-link { text-decoration: none; color: #555; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; gap: 0.6rem; }
    .back-to-site:hover, .header-auth:hover, .cart-link:hover { color: #004aad; }
    .back-to-site i, .header-auth i, .cart-link i { font-size: 1rem; }

    .corp-logo img { height: 26px; width: auto; display: block; }
    .corp-brand { font-size: 1.25rem; font-weight: 800; color: #004aad; letter-spacing: -1px; }

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

    .legal-layout { display: flex; align-items: flex-start; max-width: 1200px; margin: 3rem auto; padding: 0 2rem; gap: 3rem; }

    .legal-toc { width: 240px; flex-shrink: 0; position: sticky; top: 80px; background: #fff; border: 1px solid #f1f3f5; border-radius: 12px; padding: 1.5rem; }
    .toc-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #999; font-family: 'Inter', sans-serif; margin: 0 0 1rem; }
    .toc-list { list-style: none; padding: 0; margin: 0; }
    .toc-list li { margin-bottom: 0.1rem; }
    .toc-list li a { display: block; font-size: 0.82rem; color: #555; text-decoration: none; font-family: 'Inter', sans-serif; padding: 0.4rem 0.6rem; border-radius: 6px; line-height: 1.4; }
    .toc-list li a:hover { background: #fff5eb; color: #f68b1e; }

    .legal-main { flex: 1; min-width: 0; }
    .legal-article { display: flex; gap: 1.5rem; align-items: flex-start; padding: 0.5rem 0; margin-bottom: 2.5rem; border: none; background: transparent; border-radius: 0; box-shadow: none; }
    .article-num { font-size: 1.2rem; font-weight: 800; color: #f68b1e; font-family: 'Outfit', sans-serif; letter-spacing: -1px; width: 36px; flex-shrink: 0; padding-top: 0.15rem; text-align: center; line-height: 1; opacity: 0.8; }
    .article-body { flex: 1; min-width: 0; }
    .article-body h2 { font-size: 1.4rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 1rem; }
    .article-body p { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #4b5563; line-height: 1.8; margin-bottom: 1.2rem; }
    .article-body ul { padding-left: 1.3rem; margin-bottom: 1.2rem; }
    .article-body li { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.8; margin-bottom: 0.5rem; }

    @media (max-width: 900px) {
        .legal-layout { flex-direction: column; gap: 2rem; margin: 2rem auto; }
        .legal-toc { position: static; width: 100%; top: 0; padding: 1.2rem; }
        .toc-list { display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; }
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

@endsection
