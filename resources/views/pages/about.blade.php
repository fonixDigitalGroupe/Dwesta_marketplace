@extends('layouts.app')

@section('title', 'À propos de Karnou - Notre Mission et Nos Valeurs')

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


    <!-- Hero Section -->
    <div class="legal-hero">
        <div class="legal-hero-inner">
            <span class="legal-category-badge">Notre Histoire</span>
            <h1>Karnou, groupe d'innovation digitale au service de la société</h1>
            <p class="legal-hero-desc">Découvrez comment nous démocratisons le commerce numérique en Afrique à travers un écosystème complet et sécurisé.</p>
            <div class="legal-meta">
                <span><i class="fa-regular fa-calendar"></i> Fondé en 2024</span>
                <span class="meta-sep">·</span>
                <span><i class="fa-solid fa-location-dot"></i> Siège à Bangui</span>
                <span class="meta-sep">·</span>
                <span><i class="fa-solid fa-earth-africa"></i> Impact local</span>
            </div>
        </div>
    </div>

    <!-- Layout 2 Colonnes -->
    <div class="legal-layout">

        <!-- Sidebar Table of Contents -->
        <aside class="legal-toc" id="legalToc">
            <p class="toc-title">Sur cette page</p>
            <ul class="toc-list">
                <li><a href="#qui">01 — Qui sommes-nous ?</a></li>
                <li><a href="#philosophie">02 — Notre Philosophie</a></li>
                <li><a href="#ecosysteme">03 — Écosystème Unique</a></li>
                <li><a href="#fondateur">04 — Parole du Fondateur</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="legal-main">

            <!-- Section 01: Qui sommes-nous -->
            <article id="qui" class="legal-article">
                <div class="article-num">01</div>
                <div class="article-body">
                    <h2>Qui sommes-nous ?</h2>
                    <p>
                        Karnou, fondé en République Centrafricaine, est né de la volonté de démocratiser le commerce numérique en Afrique. Acteur incontournable de l'innovation locale, Karnou rassemble des services digitaux complémentaires dans des domaines aussi variés que l'e-commerce, la logistique, les services financiers et le développement technologique. 
                    </p>
                    <p>
                        Karnou accompagne chaque jour des milliers d'acheteurs et de vendeurs dans un écosystème sécurisé et adapté aux réalités africaines. Nous croyons fermement que la technologie peut transformer positivement la vie quotidienne des citoyens.
                    </p>
                </div>
            </article>

            <!-- Section 02: Philosophie & Valeurs -->
            <article id="philosophie" class="legal-article">
                <div class="article-num">02</div>
                <div class="article-body">
                    <h2>Notre Philosophie</h2>
                    
                    <!-- Tabs Navigation -->
                    <div class="qui-tabs">
                        <button class="qui-tab active" onclick="switchQuiTab('philosophie-content', this)">Philosophie</button>
                        <button class="qui-tab" onclick="switchQuiTab('mission-content', this)">Mission</button>
                        <button class="qui-tab" onclick="switchQuiTab('vision-content', this)">Vision</button>
                        <button class="qui-tab" onclick="switchQuiTab('valeurs-content', this)">Valeurs</button>
                    </div>

                    <!-- Tab Contents -->
                    <div class="qui-tab-content active" id="philosophie-content">
                        Karnou contribue au progrès de la société en valorisant l'innovation et l'entrepreneuriat. En fournissant des services de qualité à nos clients et partenaires pour les aider à se développer, nous permettons aux acteurs locaux de grandir et de s'approprier les nouvelles technologies de pointe mises à leur disposition.
                    </div>
                    <div class="qui-tab-content" id="mission-content">
                        Notre mission est de démocratiser l'accès au commerce en ligne de qualité en Afrique Centrale. Chaque transaction sur Karnou doit être une expérience fluide, sécurisée et valorisante pour tous.
                    </div>
                    <div class="qui-tab-content" id="vision-content">
                        Devenir la plateforme de référence en Afrique francophone, reconnue pour la qualité de son écosystème numérique et l'impact positif qu'elle génère pour les communautés locales.
                    </div>
                    <div class="qui-tab-content" id="valeurs-content">
                        Confiance, transparence, innovation et impact local. Ces quatre piliers guident chacune de nos décisions et définissent l'identité profonde de Karnou.
                    </div>
                </div>
            </article>

            <!-- Section 03: Écosystème -->
            <article id="ecosysteme" class="legal-article">
                <div class="article-num">03</div>
                <div class="article-body">
                    <h2>Un écosystème unique</h2>
                    <p>Karnou se compose de multiples entités, soit autant d'expertises qui positionnent le groupe comme un acteur incontournable de la scène tech africaine :</p>
                    
                    <div class="ecosystem-flex">
                        <div class="diagram-miniature">
                            <div class="ecosystem-drawing">
                                <div class="core-node">
                                    <span class="core-text">Karnou</span>
                                </div>
                                <div class="satellites small-satellites">
                                    <div class="satellite-node node-acheteurs"><i class="fa-solid fa-users"></i></div>
                                    <div class="satellite-node node-vendeurs"><i class="fa-solid fa-store"></i></div>
                                    <div class="satellite-node node-express"><i class="fa-solid fa-truck-fast"></i></div>
                                    <div class="satellite-node node-agence"><i class="fa-solid fa-building-user"></i></div>
                                    <div class="satellite-node node-vente"><i class="fa-solid fa-hand-holding-dollar"></i></div>
                                </div>
                                <svg class="connections-svg" viewBox="0 0 500 500">
                                    <line class="conn-line" x1="250" y1="250" x2="100" y2="150" />
                                    <line class="conn-line" x1="250" y1="250" x2="400" y2="150" />
                                    <line class="conn-line" x1="250" y1="250" x2="100" y2="350" />
                                    <line class="conn-line" x1="250" y1="250" x2="400" y2="350" />
                                    <line class="conn-line" x1="250" y1="250" x2="250" y2="80" />
                                </svg>
                            </div>
                        </div>
                        <div class="ecosystem-list-refined">
                            <ul>
                                <li><strong>Karnou Agence :</strong> Notre réseau de points de retrait pour une proximité maximale.</li>
                                <li><strong>Karnou Express :</strong> Société de livraison de colis innovante.</li>
                                <li><strong>Vente sur Karnou :</strong> Plateforme ouverte pour particuliers et pros.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Section 04: Fondateur -->
            <article id="fondateur" class="legal-article">
                <div class="article-num">04</div>
                <div class="article-body">
                    <h2>Parole du Fondateur</h2>
                    <div class="founder-card-refined">
                        <div class="founder-image-mini">
                            <img src="/images/founder_karnou.png" alt="Jean-Pierre Karnou">
                        </div>
                        <div class="founder-quote-content">
                            <i class="fa-solid fa-quote-left"></i>
                            <blockquote class="quote-text-refined">
                                "Nous continuons de croire que le monde numérique a le potentiel d'améliorer la vie de nous tous. Oubliez la peur. Adoptez l'optimisme."
                            </blockquote>
                            <cite class="quote-author-refined">
                                Jean-Pierre Karnou – <span>Fondateur & CEO</span>
                            </cite>
                        </div>
                    </div>
                </div>
            </article>


        </main>
    </div>
</div>

<style>
    /* --- Base --- */
    .legal-page { background: #f8f9fb; min-height: 100vh; }
    .about-container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
    .header, .top-banner { display: none !important; }

    /* --- Corporate Header --- */
    .corporate-header { background: #fff; padding: 1.2rem 0; border-bottom: 1px solid #eee; font-family: 'Inter', sans-serif; }
    .corp-header-flex { display: flex; justify-content: space-between; align-items: center; padding: 0 2rem; }
    .corp-logo { display: block; text-decoration: none; }
    .corp-brand { font-size: 1.4rem; font-weight: 700; color: #004aad; letter-spacing: -1px; }
    .corp-nav ul { display: flex; list-style: none; gap: 0.8rem; margin: 0; padding: 0; flex-wrap: wrap; justify-content: flex-end; }
    .corp-nav ul li a { text-decoration: none; color: #555; font-size: 0.82rem; font-weight: 500; font-family: 'Inter', sans-serif; transition: all 0.2s; border-bottom: 2px solid transparent; padding-bottom: 0.3rem; }
    .corp-nav ul li a:hover { color: #004aad; }
    .corp-nav ul li.active a { color: #004aad; border-bottom: 2px solid #004aad; font-weight: 600; }

    /* --- Sub Nav --- */
    .about-sub-nav { background: #fff; border-bottom: 1px solid #eee; position: sticky; top: 0; z-index: 100; padding: 1.2rem 0; box-shadow: 0 4px 6px -2px rgba(0,0,0,0.05); }
    .about-sub-nav .about-container { display: flex; justify-content: center; align-items: center; }
    .sub-nav-list { display: flex; list-style: none; gap: 2.5rem; margin: 0; padding: 0; }
    .sub-nav-list li a { text-decoration: none; color: #555; font-size: 0.9rem; border-bottom: 2px solid transparent; padding-bottom: 0.3rem; font-family: 'Inter', sans-serif; transition: color 0.2s; }
    .sub-nav-list li.active a { border-bottom: 2px solid #004aad; color: #1a1a1a; font-weight: 600; }

    /* --- Legal Hero --- */
    .legal-hero { 
        background: linear-gradient(135deg, rgba(0, 74, 173, 0.9) 0%, rgba(0, 49, 130, 0.8) 100%), url('/images/apropos_bannier.jpg');
        background-size: cover;
        background-position: center;
        padding: 4rem 2rem; 
        color: #fff; 
    }
    .legal-hero-inner { max-width: 800px; margin: 0 auto; }
    .legal-category-badge { display: inline-block; background: rgba(255,255,255,0.15); color: rgba(255,255,255,0.9); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; padding: 0.35rem 0.9rem; border-radius: 50px; margin-bottom: 1.2rem; font-family: 'Inter', sans-serif; border: 1px solid rgba(255,255,255,0.2); }
    .legal-hero h1 { font-size: 2.2rem; font-weight: 700; font-family: 'Outfit', 'Inter', sans-serif; color: #fff; margin: 0 0 0.8rem; letter-spacing: -0.5px; line-height: 1.2; }
    .legal-hero-desc { font-size: 1rem; color: rgba(255,255,255,0.8); font-family: 'Inter', sans-serif; margin: 0 0 1.5rem; line-height: 1.6; }
    .legal-meta { display: flex; align-items: center; gap: 0.6rem; font-size: 0.85rem; color: rgba(255,255,255,0.7); font-family: 'Inter', sans-serif; flex-wrap: wrap; }
    .legal-meta i { margin-right: 0.3rem; font-size: 0.8rem; }
    .meta-sep { opacity: 0.4; }

    /* --- Layout --- */
    .legal-layout { display: flex; align-items: flex-start; max-width: 1200px; margin: 3rem auto; padding: 0 2rem; gap: 3rem; }
    .legal-toc { width: 240px; flex-shrink: 0; position: sticky; top: 80px; background: #fff; border: 1px solid #e8ecf0; border-radius: 12px; padding: 1.5rem; }
    .toc-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #999; font-family: 'Inter', sans-serif; margin: 0 0 1rem; }
    .toc-list { list-style: none; padding: 0; margin: 0; }
    .toc-list li { margin-bottom: 0.1rem; }
    .toc-list li a { display: block; font-size: 0.82rem; color: #555; text-decoration: none; font-family: 'Inter', sans-serif; padding: 0.4rem 0.6rem; border-radius: 6px; transition: all 0.15s; }
    .toc-list li a:hover { background: #f0f4ff; color: #004aad; }
    .legal-main { flex: 1; min-width: 0; }

    /* --- Articles --- */
    .legal-article { display: flex; gap: 1.5rem; align-items: flex-start; background: #fff; border: 1px solid #e8ecf0; border-radius: 12px; padding: 2.5rem; margin-bottom: 1.5rem; transition: all 0.2s; }
    .legal-article:hover { border-color: #c7d8f8; box-shadow: 0 4px 16px rgba(0,74,173,0.06); }
    .article-num { font-size: 1.2rem; font-weight: 800; color: #d0ddf5; font-family: 'Outfit', sans-serif; width: 36px; flex-shrink: 0; text-align: center; }
    .article-body { flex: 1; min-width: 0; }
    .article-body h2 { font-size: 1.3rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 1.2rem; }
    .article-body p { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #4b5563; line-height: 1.8; margin-bottom: 1rem; }

    /* --- Tabs --- */
    .qui-tabs { display: flex; border-bottom: 1px solid #eee; margin-bottom: 1.5rem; gap: 1rem; }
    .qui-tab { background: none; border: none; padding: 0.8rem 0; color: #888; cursor: pointer; font-family: 'Inter', sans-serif; font-size: 0.85rem; font-weight: 500; border-bottom: 2px solid transparent; transition: all 0.3s; }
    .qui-tab.active { color: #004aad; border-bottom: 2px solid #004aad; }
    .qui-tab-content { display: none; font-size: 0.92rem; line-height: 1.7; color: #666; font-family: 'Inter', sans-serif; }
    .qui-tab-content.active { display: block; animation: fadeIn 0.4s ease; }

    /* --- Ecosystem Diagram --- */
    .ecosystem-flex { display: flex; gap: 2rem; align-items: center; margin-top: 1.5rem; flex-wrap: wrap; }
    .diagram-miniature { width: 300px; height: 300px; flex-shrink: 0; position: relative; background: #fbfcfe; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
    .ecosystem-drawing { position: relative; width: 250px; height: 250px; }
    .core-node { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 80px; height: 80px; background: #004aad; border-radius: 50%; display: flex; align-items: center; justify-content: center; z-index: 10; box-shadow: 0 0 20px rgba(0,74,173,0.3); }
    .core-text { color: #fff; font-weight: 700; font-size: 0.9rem; font-family: 'Outfit', sans-serif; }
    .satellite-node { position: absolute; width: 40px; height: 40px; background: #fff; border: 1px solid #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; color: #004aad; z-index: 5; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .node-acheteurs { top: 0; left: 20%; }
    .node-vendeurs { top: 0; right: 20%; }
    .node-express { bottom: 0; left: 20%; }
    .node-agence { bottom: 0; right: 20%; }
    .node-vente { top: 50%; left: -10%; transform: translateY(-50%); }
    .connections-svg { position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; }
    .conn-line { stroke: #004aad; stroke-width: 1; stroke-dasharray: 4; opacity: 0.2; }
    .ecosystem-list-refined ul { list-style: none; padding: 0; }
    .ecosystem-list-refined li { margin-bottom: 0.8rem; font-size: 0.9rem; color: #444; position: relative; padding-left: 1.2rem; }
    .ecosystem-list-refined li::before { content: "→"; position: absolute; left: 0; color: #004aad; font-weight: bold; }

    /* --- Founder Quote --- */
    .founder-card-refined { display: flex; gap: 2rem; background: #fdfdfd; border: 1px solid #f0f0f0; border-radius: 12px; padding: 2rem; margin-top: 1rem; align-items: center; }
    .founder-image-mini { width: 120px; height: 120px; border-radius: 12px; overflow: hidden; flex-shrink: 0; border: 4px solid #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .founder-image-mini img { width: 100%; height: 100%; object-fit: cover; }
    .founder-quote-content { flex: 1; }
    .founder-quote-content i { font-size: 1.5rem; color: #004aad; opacity: 0.2; margin-bottom: 0.5rem; display: block; }
    .quote-text-refined { font-size: 1.1rem; font-style: italic; color: #1a1a1a; font-family: 'Outfit', sans-serif; margin: 0 0 1rem; line-height: 1.5; }
    .quote-author-refined { font-size: 0.9rem; font-weight: 700; color: #333; font-family: 'Inter', sans-serif; }
    .quote-author-refined span { font-weight: 400; color: #888; display: block; margin-top: 2px; }


    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

    @media (max-width: 900px) {
        .legal-layout { flex-direction: column; }
        .legal-toc { position: static; width: 100%; }
        .toc-list { display: grid; grid-template-columns: 1fr 1fr; gap: 0.2rem; }
        .ecosystem-flex { justify-content: center; }
        .founder-card-refined { flex-direction: column; text-align: center; }
    }
</style>

<script>
    function switchQuiTab(tabId, btn) {
        document.querySelectorAll('.qui-tab-content').forEach(c => c.classList.remove('active'));
        document.querySelectorAll('.qui-tab').forEach(b => b.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        btn.classList.add('active');
    }

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
