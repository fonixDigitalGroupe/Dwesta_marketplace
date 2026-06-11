@extends('layouts.app')

@section('title', 'Gestion des Cookies - Karnou')

@section('content')
<div class="legal-page">
    <!-- Corporate Header -->
    <header class="corporate-header">
        <div class="about-container">
            <div class="corp-header-flex">
                <div class="header-left">
                    <a href="{{ route('home') }}" class="back-to-site">
                        <i class="fa-solid fa-chevron-left"></i> Retour sur le site
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
                            <i class="fa-regular fa-user"></i> {{ auth()->user()->prenom ?? auth()->user()->name }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="header-auth">
                            <i class="fa-regular fa-user"></i> Se connecter
                        </a>
                    @endauth
                    <a href="{{ route('cart.index') }}" class="header-link cart-link" title="Mon Panier">
                        <i class="fa-solid fa-cart-shopping"></i> Panier
                    </a>
                </div>
            </div>
        </div>
    </header>

    </div>


    <!-- Layout -->

    <!-- Page Hero Banner -->
    <div class="page-hero" style="background-image: linear-gradient(135deg, rgba(0,74,173,0.88) 0%, rgba(0,30,90,0.82) 100%), url('/images/apropos_bannier.jpg');">
        <div class="about-container">
            <h1>Politique des Cookies</h1>
            <p class="last-update">Dernière mise à jour : 05 Avril 2026</p>
        </div>
    </div>

    <!-- Layout -->
    <div class="legal-layout">

        <!-- TOC Sidebar -->
        <aside class="legal-toc">
            <p class="toc-title">Table des matières</p>
            <ul class="toc-list">
                <li><a href="#ck1">1 — Qu'est-ce qu'un cookie ?</a></li>
                <li><a href="#ck2">2 — Catégories de cookies</a></li>
                <li><a href="#ck3">3 — Finalités</a></li>
                <li><a href="#ck4">4 — Paramétrage</a></li>
                <li><a href="#ck5">5 — Cookies tiers</a></li>
                <li><a href="#ck6">6 — Mise à jour</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="legal-main">



            <p class="legal-intro">La présente politique a pour objet de vous informer sur la manière dont Karnou utilise des traceurs (cookies) lors de votre navigation sur la Plateforme et de vous expliquer comment les gérer.</p>

            <article id="ck1" class="legal-article">
                <div class="article-num">01</div>
                <div class="article-body">
                    <h2>Qu'est-ce qu'un cookie ?</h2>
                    <p>Un cookie est un petit fichier texte déposé sur le disque dur de votre terminal (ordinateur, smartphone, tablette) lors de votre visite sur notre site. Il permet à la Plateforme de vous reconnaître lors de vos prochaines visites, de mémoriser vos préférences et d'améliorer votre expérience de navigation. Les cookies ne contiennent aucune donnée permettant de vous identifier directement.</p>
                </div>
            </article>

            <article id="ck2" class="legal-article">
                <div class="article-num">02</div>
                <div class="article-body">
                    <h2>Catégories de cookies utilisés</h2>
                    <p>Karnou utilise quatre catégories de cookies selon leur finalité :</p>

                    <p><strong>a) Cookies strictement nécessaires</strong><br>
                    Indispensables au bon fonctionnement de la Plateforme. Sans eux, certains services essentiels (maintien de session, panier, sécurisation des formulaires) ne peuvent fonctionner. Ils ne nécessitent pas votre consentement.</p>

                    <p><strong>b) Cookies de préférences</strong><br>
                    Permettent de mémoriser vos réglages personnels : langue d'affichage, devise, région de livraison, pour vous offrir une expérience personnalisée.</p>

                    <p><strong>c) Cookies analytiques et de statistiques</strong><br>
                    Nous permettent de mesurer l'audience de la Plateforme, d'analyser les comportements de navigation (pages les plus visitées, temps de visite, taux de rebond) et d'améliorer nos services. Les données sont agrégées et anonymisées.</p>

                    <p><strong>d) Cookies de ciblage et marketing</strong><br>
                    Permettent de vous proposer des publicités adaptées à vos centres d'intérêts. Ils limitent également la répétition d'une même publicité. Ces cookies ne sont activés qu'avec votre consentement explicite.</p>
                </div>
            </article>

            <article id="ck3" class="legal-article">
                <div class="article-num">03</div>
                <div class="article-body">
                    <h2>Finalités de l'usage</h2>
                    <p>Nous utilisons ces technologies pour :</p>
                    <ul>
                        <li>Personnaliser les contenus et les offres proposées sur la Plateforme.</li>
                        <li>Mesurer l'audience et la performance de nos campagnes marketing.</li>
                        <li>Assurer la protection contre les tentatives d'usurpation de compte.</li>
                        <li>Améliorer la navigation et la fluidité du parcours d'achat.</li>
                    </ul>
                    <p>Les cookies de session expirent automatiquement à la fermeture de votre navigateur. Les cookies persistants ont une durée de vie maximale de <strong>13 mois</strong>, conformément aux recommandations des autorités de protection des données.</p>
                </div>
            </article>

            <article id="ck4" class="legal-article">
                <div class="article-num">04</div>
                <div class="article-body">
                    <h2>Paramétrage et contrôle</h2>
                    <p>Vous pouvez gérer votre consentement via le bandeau de gestion des cookies ou directement via les paramètres de votre navigateur :</p>
                    <ul>
                        <li><strong>Google Chrome :</strong> Paramètres › Confidentialité et sécurité › Cookies et autres données de site.</li>
                        <li><strong>Mozilla Firefox :</strong> Paramètres › Vie privée et sécurité › Cookies et données de sites.</li>
                        <li><strong>Microsoft Edge :</strong> Paramètres › Cookies et autorisations de site.</li>
                        <li><strong>Safari (macOS) :</strong> Préférences › Confidentialité › Cookies et données de sites web.</li>
                        <li><strong>Safari (iOS) :</strong> Réglages › Safari › Confidentialité et sécurité.</li>
                    </ul>
                    <p><strong>Attention :</strong> la désactivation des cookies strictement nécessaires peut altérer le bon fonctionnement de la Plateforme (connexion, panier, etc.).</p>
                </div>
            </article>

            <article id="ck5" class="legal-article">
                <div class="article-num">05</div>
                <div class="article-body">
                    <h2>Cookies déposés par des tiers</h2>
                    <p>Certains cookies présents sur notre Plateforme sont déposés par des partenaires tiers (réseaux sociaux, outils d'analyse comme Google Analytics). Karnou n'a aucun contrôle direct sur ces cookies. Nous vous encourageons à consulter les politiques de confidentialité de ces partenaires si vous souhaitez en savoir plus sur leurs pratiques.</p>
                </div>
            </article>

            <article id="ck6" class="legal-article">
                <div class="article-num">06</div>
                <div class="article-body">
                    <h2>Mise à jour de la politique</h2>
                    <p>La présente politique est susceptible d'être modifiée à tout moment pour s'adapter à l'évolution de nos services ou à la réglementation en vigueur. La version en vigueur est celle disponible en permanence sur cette page. À l'expiration de la durée de vie des cookies, votre consentement sera à nouveau sollicité lors de votre prochaine visite.</p>
                    <p>Pour toute question, consultez également notre <a href="{{ route('privacy') }}">Politique de Vie Privée</a>.</p>
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

    .header-left, .header-right { flex: 1; display: flex; align-items: center; }
    .header-center { flex: 0; display: flex; justify-content: center; }
    .header-right { justify-content: flex-end; gap: 1.5rem; }

    .back-to-site, .header-auth, .cart-link { text-decoration: none; color: #555; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; gap: 0.6rem; }
    .back-to-site:hover, .header-auth:hover, .cart-link:hover { color: #004aad; }
    .back-to-site i, .header-auth i, .cart-link i { font-size: 1rem; }

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

    .corp-logo img { height: 28px; width: auto; display: block; }
    .corp-brand { font-size: 1.5rem; font-weight: 800; color: #004aad; letter-spacing: -1.5px; }



    .legal-hero {
        background: linear-gradient(135deg, rgba(0, 74, 173, 0.9) 0%, rgba(0, 49, 130, 0.8) 100%), url('/images/cookies.jpg');
        background-size: cover;
        background-position: center;
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

    .legal-disclaimer { display: flex; align-items: flex-start; gap: 1rem; background: #eff6ff; border: 1px solid #dbeafe; border-left: 4px solid #004aad; border-radius: 8px; padding: 1.2rem 1.5rem; font-family: 'Inter', sans-serif; font-size: 0.9rem; color: #1e3a6a; line-height: 1.6; margin-bottom: 2rem; }
    .legal-disclaimer i { font-size: 1.2rem; color: #004aad; margin-top: 0.1rem; flex-shrink: 0; }

    .legal-article { display: flex; gap: 1.5rem; align-items: flex-start; background: #fff; border: 1px solid #f1f3f5; border-radius: 12px; padding: 2rem 2rem 2rem 1.5rem; margin-bottom: 1.2rem; }
    .article-num { font-size: 1.2rem; font-weight: 800; color: #ffe5cc; font-family: 'Outfit', sans-serif; letter-spacing: -1px; width: 36px; flex-shrink: 0; padding-top: 0.15rem; text-align: center; line-height: 1; }
    .article-body { flex: 1; min-width: 0; }
    .article-body h2 { font-size: 1.05rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 1rem; }
    .article-body p { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.75; margin-bottom: 0.8rem; }
    .article-body ul { padding-left: 1.3rem; margin-bottom: 0.8rem; }
    .article-body li { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.7; margin-bottom: 0.5rem; }
    .article-body a { color: #f68b1e; text-decoration: none; font-weight: 600; }
    .article-body a:hover { text-decoration: underline; }


    @media (max-width: 900px) {
        .legal-layout { flex-direction: column; }
        .legal-toc { position: static; width: 100%; }
        .toc-list { display: grid; grid-template-columns: 1fr 1fr; gap: 0.2rem; }
        .legal-hero h1 { font-size: 1.6rem; }
    }
    @media (max-width: 600px) {
        .legal-layout { padding: 0 1rem; margin: 1.5rem auto; }
        .article-num { display: none; }
        .legal-article { padding: 1.5rem; }
        .toc-list { grid-template-columns: 1fr; }
    }
</style>
@endpush

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Observer removed for static experience
    });
</script>
@endsection
