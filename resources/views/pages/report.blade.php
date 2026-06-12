@extends('layouts.app')

@section('title', 'Signaler un contenu - Karnou')

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

    <!-- Sub Nav -->


    <!-- Layout -->

    <!-- Page Hero Banner -->
    <div class="page-hero" style="background-image: linear-gradient(135deg, rgba(0,74,173,0.88) 0%, rgba(0,30,90,0.82) 100%), url('/images/report_bannier.png');">
        <div class="about-container">
            <h1>Signaler un abus</h1>
            <p class="page-hero-desc">La sécurité et l'intégrité de notre marketplace sont nos priorités. Cette page vous explique comment signaler un contenu qui vous semble abusif ou non conforme à nos règles.</p>
            <p class="last-update">Dernière mise à jour : 22 Mai 2026</p>
        </div>
    </div>

    <!-- Layout -->
    <div class="legal-layout">

        <!-- TOC Sidebar -->
        <aside class="legal-toc">
            <p class="toc-title">Table des matières</p>
            <ul class="toc-list">
                <li><a href="#rep1">1 — Pourquoi signaler ?</a></li>
                <li><a href="#rep2">2 — Comment signaler ?</a></li>
                <li><a href="#rep3">3 — Notre processus</a></li>
                <li><a href="#rep4">4 — Sanctions</a></li>
            </ul>
        </aside>

        <!-- Main -->
        <main class="legal-main">

            <article id="rep1" class="legal-article">
                <div class="article-num">01</div>
                <div class="article-body">
                    <h2>Pourquoi signaler un contenu ?</h2>
                    <p>Vous devez signaler tout contenu qui :</p>
                    <ul>
                        <li>Est illégal, frauduleux ou trompeur.</li>
                        <li>Est haineux, harcelant ou violent.</li>
                        <li>Porte atteinte à la propriété intellectuelle.</li>
                        <li>Est une tentative d'arnaque ou de phishing.</li>
                    </ul>
                </div>
            </article>

            <article id="rep2" class="legal-article">
                <div class="article-num">02</div>
                <div class="article-body">
                    <h2>Comment signaler ?</h2>
                    <p>Pour chaque annonce, vous trouverez un bouton "Signaler" qui vous permet de nous alerter directement.</p>
                    <p>Vous pouvez également envoyer un email détaillé à notre équipe de modération en précisant le lien de l'annonce ou l'identifiant du vendeur incriminé.</p>
                </div>
            </article>

            <article id="rep3" class="legal-article">
                <div class="article-num">03</div>
                <div class="article-body">
                    <h2>Notre processus de modération</h2>
                    <p>Chaque signalement est examiné manuellement par nos équipes de confiance et sécurité sous 24h ouvrées. Nous analysons le contenu par rapport à nos conditions générales d'utilisation.</p>
                </div>
            </article>

            <article id="rep4" class="legal-article">
                <div class="article-num">04</div>
                <div class="article-body">
                    <h2>Sanctions possibles</h2>
                    <p>En cas de violation confirmée, nous pouvons :</p>
                    <ul>
                        <li>Supprimer le contenu concerné.</li>
                        <li>Avertir l'utilisateur.</li>
                        <li>Suspendre temporairement le compte.</li>
                        <li>Bannir définitivement l'utilisateur de la plateforme.</li>
                    </ul>
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
    .corp-logo img { height: 22px; width: auto; display: block; }
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
    .legal-intro { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #555; line-height: 1.75; margin-bottom: 2rem; }

    .legal-article { display: block; padding: 0.5rem 0; margin-bottom: 2.5rem; border: none; background: transparent; border-radius: 0; box-shadow: none; }
    .article-num { display: none; }
    .article-body { width: 100%; }
    .article-body h2 { font-size: 1.4rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 1rem; }
    .article-body p { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #4b5563; line-height: 1.8; margin-bottom: 1.2rem; }
    .article-body ul { padding-left: 1.3rem; margin-bottom: 1.2rem; }
    .article-body li { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.8; margin-bottom: 0.5rem; }
    .article-body a { color: #f68b1e; text-decoration: none; font-weight: 600; }
    .article-body a:hover { text-decoration: underline; }


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
