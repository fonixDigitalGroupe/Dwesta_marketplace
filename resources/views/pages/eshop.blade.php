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


    <!-- Layout -->

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
            <p class="legal-intro">Karnou met à votre disposition une infrastructure complète pour vendre vos produits en ligne, que vous soyez un commerçant établi ou un particulier souhaitant vendre occasionnellement.</p>

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
                    <div style="margin-top: 1rem;">
                        <a href="{{ route('vendeur.create', ['type' => 'particulier']) }}" class="btn-primary-corp-v2" style="display: inline-block; width: auto; padding: 0.6rem 2rem;">S'inscrire comme Particulier</a>
                    </div>
                </div>
            </article>

            <article id="esh4" class="legal-article">
                <div class="article-num">04</div>
                <div class="article-body">
                    <div style="background: #f0f7ff; border: 1px solid #c7d8f8; padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
                        <h2 style="margin-top: 0;">Vendeur Professionnel (Recommandé)</h2>
                        <p>Dédié aux entreprises, boutiques et artisans souhaitant une présence professionnelle forte.</p>
                        <p><strong>Avantages :</strong> Page Pro exclusive (vitrine), annonces illimitées, commissions réduites, support prioritaire, accès aux abonnements premium.</p>
                        <div style="margin-top: 1rem;">
                            <a href="{{ route('vendeur.create', ['type' => 'professionnel']) }}" class="btn-primary-corp-v2" style="display: inline-block; width: auto; padding: 0.6rem 2rem;">Ouvrir un compte Pro</a>
                        </div>
                    </div>
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
    .top-banner, .header, .footer { display: none !important; visibility: hidden !important; height: 0 !important; overflow: hidden !important; }
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

    .corp-logo img { height: 28px; width: auto; display: block; }
    .corp-brand { font-size: 1.5rem; font-weight: 800; color: #004aad; letter-spacing: -1.5px; }



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

    .legal-article { display: flex; gap: 1.5rem; align-items: flex-start; background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; padding: 2rem 2rem 2rem 1.5rem; margin-bottom: 1.2rem; }
    .article-num { font-size: 1.2rem; font-weight: 800; color: #ffe5cc; font-family: 'Outfit', sans-serif; letter-spacing: -1px; width: 36px; flex-shrink: 0; padding-top: 0.15rem; text-align: center; line-height: 1; }
    .article-body { flex: 1; min-width: 0; }
    .article-body h2 { font-size: 1.05rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 1rem; }
    .article-body p { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.75; margin-bottom: 0.8rem; }
    .article-body a { color: #f68b1e; text-decoration: none; font-weight: 600; }
    .article-body a:hover { text-decoration: underline; }

    .btn-primary-corp-v2:hover { background: #003a8a; }


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

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Observer removed for static experience
    });
</script>
@endsection
