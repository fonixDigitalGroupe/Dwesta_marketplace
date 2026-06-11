@extends('layouts.app')

@section('title', 'Gestion des Cookies - Karnou')

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
                        <li class="{{ Route::is('terms') ? 'active' : '' }}"><a href="{{ route('terms') }}">Conditions générales</a></li>
                        <li class="{{ Route::is('privacy') ? 'active' : '' }}"><a href="{{ route('privacy') }}">Vie privée</a></li>
                        <li class="{{ Route::is('cookies') ? 'active' : '' }}"><a href="{{ route('cookies') }}">Gestion des cookies</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>


    <!-- Hero -->
    <div class="legal-hero">
        <div class="legal-hero-inner">
            <span class="legal-category-badge">Document légal</span>
            <h1>Politique de Gestion des Cookies</h1>
            <p class="legal-hero-desc">Transparence totale sur les technologies de traçage utilisées par Karnou et vos moyens de contrôle.</p>
            <div class="legal-meta">
                <span><i class="fa-regular fa-calendar"></i> Mis à jour le 1er juin 2025</span>
                <span class="meta-sep">·</span>
                <span><i class="fa-regular fa-file-lines"></i> 6 sections</span>
                <span class="meta-sep">·</span>
                <span><i class="fa-solid fa-cookie-bite"></i> Contrôle total</span>
            </div>
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

        <!-- Main -->
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

            <div class="legal-contact-strip">
                <i class="fa-regular fa-envelope"></i>
                <div>
                    <strong>Des questions sur nos cookies ?</strong><br>
                    Contactez notre équipe à <a href="mailto:privacy@karnou.net">privacy@karnou.net</a> — réponse garantie sous 48h ouvrées.
                </div>
            </div>
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
    .corp-nav ul { display: flex; list-style: none; gap: 2rem; margin: 0; padding: 0; }
    .corp-nav ul li a { text-decoration: none; color: #555; font-size: 0.9rem; font-weight: 500; font-family: 'Inter', sans-serif; transition: all 0.2s; border-bottom: 2px solid transparent; padding-bottom: 0.5rem; }
    .corp-nav ul li a:hover { color: #004aad; }
    .corp-nav ul li.active a { color: #004aad; border-bottom: 2px solid #004aad; font-weight: 600; }

    .legal-hero {
        background: linear-gradient(135deg, rgba(0, 74, 173, 0.9) 0%, rgba(0, 49, 130, 0.8) 100%), url('/images/cookies.jpg');
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

    .legal-layout { display: flex; align-items: flex-start; max-width: 1200px; margin: 3rem auto; padding: 0 2rem; gap: 3rem; }

    .legal-toc { width: 240px; flex-shrink: 0; position: sticky; top: 80px; background: #fff; border: 1px solid #e8ecf0; border-radius: 12px; padding: 1.5rem; }
    .toc-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #999; font-family: 'Inter', sans-serif; margin: 0 0 1rem; }
    .toc-list { list-style: none; padding: 0; margin: 0; }
    .toc-list li { margin-bottom: 0.1rem; }
    .toc-list li a { display: block; font-size: 0.82rem; color: #555; text-decoration: none; font-family: 'Inter', sans-serif; padding: 0.4rem 0.6rem; border-radius: 6px; transition: all 0.15s; line-height: 1.4; }
    .toc-list li a:hover { background: #f0f4ff; color: #004aad; }

    .legal-main { flex: 1; min-width: 0; }
    .legal-intro { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #555; line-height: 1.75; margin-bottom: 2rem; }

    .legal-disclaimer { display: flex; align-items: flex-start; gap: 1rem; background: #eff6ff; border: 1px solid #bfdbfe; border-left: 4px solid #004aad; border-radius: 8px; padding: 1.2rem 1.5rem; font-family: 'Inter', sans-serif; font-size: 0.9rem; color: #1e3a6a; line-height: 1.6; margin-bottom: 2rem; }
    .legal-disclaimer i { font-size: 1.2rem; color: #004aad; margin-top: 0.1rem; flex-shrink: 0; }

    .legal-article { display: flex; gap: 1.5rem; align-items: flex-start; background: #fff; border: 1px solid #e8ecf0; border-radius: 12px; padding: 2rem 2rem 2rem 1.5rem; margin-bottom: 1.2rem; transition: border-color 0.2s, box-shadow 0.2s; }
    .legal-article:hover { border-color: #c7d8f8; box-shadow: 0 4px 16px rgba(0,74,173,0.06); }
    .article-num { font-size: 1.2rem; font-weight: 800; color: #d0ddf5; font-family: 'Outfit', sans-serif; letter-spacing: -1px; width: 36px; flex-shrink: 0; padding-top: 0.15rem; text-align: center; line-height: 1; }
    .article-body { flex: 1; min-width: 0; }
    .article-body h2 { font-size: 1.05rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 1rem; }
    .article-body p { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.75; margin-bottom: 0.8rem; }
    .article-body ul { padding-left: 1.3rem; margin-bottom: 0.8rem; }
    .article-body li { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.7; margin-bottom: 0.5rem; }
    .article-body a { color: #004aad; text-decoration: none; }
    .article-body a:hover { text-decoration: underline; }

    .legal-contact-strip { display: flex; align-items: center; gap: 1.2rem; background: linear-gradient(135deg, #f0f4ff 0%, #e8f0fe 100%); border: 1px solid #c7d8f8; border-radius: 12px; padding: 1.5rem 2rem; margin-top: 2rem; font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #1a1a1a; line-height: 1.6; }
    .legal-contact-strip i { font-size: 1.8rem; color: #004aad; flex-shrink: 0; }
    .legal-contact-strip a { color: #004aad; text-decoration: none; font-weight: 600; }
    .legal-contact-strip a:hover { text-decoration: underline; }

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
