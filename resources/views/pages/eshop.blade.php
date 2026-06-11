@extends('layouts.app')

@section('title', 'Ouvrir un e-shop - Vendez sur Karnou')

@section('content')
<div class="legal-page">
    <!-- Corporate Header -->
    <header class="corporate-header">
        <div class="about-container">
            <div class="corp-header-flex">
                <a href="{{ route('home') }}" class="corp-logo">
                    @if($logoUrl = \App\Models\Setting::logoUrl())
                        <img src="{{ $logoUrl }}" alt="Logo" style="height: 26px; width: auto;">
                    @else
                        <span class="corp-brand">Karnou</span>
                    @endif
                </a>
                <nav class="corp-nav">
                    <ul>
                        <li class="{{ Route::is('about') ? 'active' : '' }}"><a href="{{ route('about') }}">À propos de Karnou</a></li>
                        <li class="{{ Route::is('terms') ? 'active' : '' }}"><a href="{{ route('terms') }}">Conditions générales</a></li>
                        <li class="{{ Route::is('privacy') ? 'active' : '' }}"><a href="{{ route('privacy') }}">Vie privée</a></li>
                        <li class="{{ Route::is('cookies') ? 'active' : '' }}"><a href="{{ route('cookies') }}">Gestion des cookies</a></li>
                        <li><a href="#">Actualité</a></li>
                        <li class="{{ Route::is('help') ? 'active' : '' }}"><a href="{{ route('help') }}">Besoin d'aide ?</a></li>
                        <li class="{{ Route::is('eshop.landing') ? 'active' : '' }}"><a href="{{ route('eshop.landing') }}">Ouvrir un e-shop</a></li>
                        <li class="{{ Route::is('report') ? 'active' : '' }}"><a href="{{ route('report') }}">Signaler un contenu</a></li>
                        <li class="{{ Route::is('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <div class="legal-hero" style="background: linear-gradient(135deg, rgba(0, 74, 173, 0.9) 0%, rgba(0, 49, 130, 0.8) 100%), url('{{ asset('images/eshop_bannier.png') }}'); background-size: cover; background-position: center;">
        <div class="legal-hero-inner">
            <span class="legal-category-badge">Business & E-commerce</span>
            <h1>Développez votre activité avec Karnou</h1>
            <p class="legal-hero-desc">Rejoignez la première marketplace de Centrafrique et donnez une dimension digitale à votre commerce dès aujourd'hui.</p>
            <div class="legal-meta">
                <span><i class="fa-solid fa-earth-africa"></i> Audience nationale</span>
                <span class="meta-sep">·</span>
                <span><i class="fa-solid fa-rocket"></i> Lancement rapide</span>
                <span class="meta-sep">·</span>
                <span><i class="fa-solid fa-wallet"></i> Paiements locaux</span>
            </div>
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

<style>
    .legal-page { background: #f8f9fb; min-height: 100vh; }
    .about-container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
    .header, .top-banner { display: none !important; }

    /* --- Corporate Header --- */
    .corporate-header { background: #fff; padding: 1.2rem 0; border-bottom: 1px solid #eee; font-family: 'Inter', sans-serif; }
    .corp-header-flex { display: flex; justify-content: space-between; align-items: center; }
    .corp-logo { display: block; text-decoration: none; }
    .corp-brand { font-size: 1.4rem; font-weight: 700; color: #004aad; letter-spacing: -1px; }
    .corp-nav ul { display: flex; list-style: none; gap: 0.8rem; margin: 0; padding: 0; flex-wrap: wrap; justify-content: flex-end; }
    .corp-nav ul li a { text-decoration: none; color: #555; font-size: 0.82rem; font-weight: 500; font-family: 'Inter', sans-serif; transition: all 0.2s; border-bottom: 2px solid transparent; padding-bottom: 0.3rem; }
    .corp-nav ul li a:hover { color: #004aad; }
    .corp-nav ul li.active a { color: #004aad; border-bottom: 2px solid #004aad; font-weight: 600; }

    .legal-hero { padding: 4rem 2rem; color: #fff; }
    .legal-hero-inner { max-width: 800px; margin: 0 auto; }
    .legal-category-badge { display: inline-block; background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; padding: 0.35rem 0.9rem; border-radius: 50px; margin-bottom: 1.2rem; font-family: 'Inter', sans-serif; border: 1px solid rgba(255,255,255,0.2); }
    .legal-hero h1 { font-size: 2.2rem; font-weight: 700; font-family: 'Outfit', 'Inter', sans-serif; color: #fff; margin: 0 0 0.8rem; letter-spacing: -0.5px; line-height: 1.2; }
    .legal-hero-desc { font-size: 1rem; color: rgba(255,255,255,0.8); font-family: 'Inter', sans-serif; margin: 0 0 1.5rem; line-height: 1.6; }
    .legal-meta { display: flex; align-items: center; gap: 0.6rem; font-size: 0.85rem; color: rgba(255,255,255,0.7); font-family: 'Inter', sans-serif; flex-wrap: wrap; }
    .legal-meta i { margin-right: 0.3rem; font-size: 0.8rem; }
    .meta-sep { opacity: 0.4; }

    .legal-layout { display: flex; align-items: flex-start; max-width: 1200px; margin: 3rem auto; padding: 0 2rem; gap: 3rem; }

    .legal-toc { width: 240px; flex-shrink: 0; position: sticky; top: 80px; background: #fff; border: 1px solid #e8ecf0; border-radius: 12px; padding: 1.5rem; }
    .toc-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #999; font-family: 'Inter', sans-serif; margin: 0 0 1rem; }
    .toc-list { list-style: none; padding: 0; margin: 0; }
    .toc-list li { margin-bottom: 0.1rem; }
    .toc-list li a { display: block; font-size: 0.82rem; color: #555; text-decoration: none; font-family: 'Inter', sans-serif; padding: 0.4rem 0.6rem; border-radius: 6px; transition: all 0.15s; line-height: 1.4; }
    .toc-list li a:hover { background: #f0f4ff; color: #004aad; }

    .legal-main { flex: 1; min-width: 0; }
    .legal-intro { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #555; line-height: 1.75; margin-bottom: 2rem; }

    .legal-article { display: flex; gap: 1.5rem; align-items: flex-start; background: #fff; border: 1px solid #e8ecf0; border-radius: 12px; padding: 2rem 2rem 2rem 1.5rem; margin-bottom: 1.2rem; transition: border-color 0.2s, box-shadow 0.2s; }
    .legal-article:hover { border-color: #c7d8f8; box-shadow: 0 4px 16px rgba(0,74,173,0.06); }
    .article-num { font-size: 1.2rem; font-weight: 800; color: #d0ddf5; font-family: 'Outfit', sans-serif; letter-spacing: -1px; width: 36px; flex-shrink: 0; padding-top: 0.15rem; text-align: center; line-height: 1; }
    .article-body { flex: 1; min-width: 0; }
    .article-body h2 { font-size: 1.05rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 1rem; }
    .article-body p { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.75; margin-bottom: 0.8rem; }
    .article-body a { color: #004aad; text-decoration: none; }
    .article-body a:hover { text-decoration: underline; }

    .btn-primary-corp-v2 { background: #004aad; color: #fff; border: none; padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s; font-size: 0.9rem; text-decoration: none; text-align: center; }
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

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const articles = document.querySelectorAll('.legal-article');
        const tocLinks = document.querySelectorAll('.toc-list a');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const link = document.querySelector(`.toc-list a[href="#${entry.target.id}"]`);
                if (!link) return;
                if (entry.isIntersecting) {
                    tocLinks.forEach(l => { l.style.background=''; l.style.color=''; l.style.fontWeight=''; });
                    link.style.background = '#eff6ff';
                    link.style.color = '#004aad';
                    link.style.fontWeight = '600';
                }
            });
        }, { rootMargin: '-20% 0px -70% 0px' });
        articles.forEach(a => observer.observe(a));
    });
</script>
@endsection
