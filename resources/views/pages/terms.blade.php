@extends('layouts.app')

@section('title', 'Conditions Générales d\'Utilisation - Karnou')

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

    <!-- Sub Nav -->
    <div class="about-sub-nav">
        <div class="about-container">
            <ul>
                <li class="{{ Route::is('about') ? 'active' : '' }}"><a href="{{ route('about') }}">À propos</a></li>
                <li class="{{ Route::is('terms') ? 'active' : '' }}"><a href="{{ route('terms') }}">Conditions</a></li>
                <li class="{{ Route::is('privacy') ? 'active' : '' }}"><a href="{{ route('privacy') }}">Vie privée</a></li>
                <li class="{{ Route::is('cookies') ? 'active' : '' }}"><a href="{{ route('cookies') }}">Cookies</a></li>
                <li class="{{ Route::is('help') ? 'active' : '' }}"><a href="{{ route('help') }}">Aide</a></li>
                <li class="{{ Route::is('eshop.landing') ? 'active' : '' }}"><a href="{{ route('eshop.landing') }}">e-Shop</a></li>
                <li class="{{ Route::is('report') ? 'active' : '' }}"><a href="{{ route('report') }}">Signaler</a></li>
                <li class="{{ Route::is('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </div>
    </div>


    <!-- Hero Banner -->
    <div class="legal-hero">
        <div class="legal-hero-inner">
            <span class="legal-category-badge">Document légal</span>
            <h1>Conditions Générales d'Utilisation</h1>
            <p class="legal-hero-desc">Les présentes conditions régissent l'ensemble des relations entre Karnou Group et ses utilisateurs.</p>
            <div class="legal-meta">
                <span><i class="fa-regular fa-calendar"></i> Mis à jour le 1er juin 2025</span>
                <span class="meta-sep">·</span>
                <span><i class="fa-regular fa-file-lines"></i> 12 articles</span>
                <span class="meta-sep">·</span>
                <span><i class="fa-solid fa-globe"></i> Applicable en Afrique Centrale</span>
            </div>
        </div>
    </div>

    <!-- Layout 2 Colonnes -->
    <div class="legal-layout">

        <!-- Sidebar Table of Contents -->
        <aside class="legal-toc" id="legalToc">
            <p class="toc-title">Table des matières</p>
            <ul class="toc-list">
                <li><a href="#art1">Art. 1 — Définitions</a></li>
                <li><a href="#art2">Art. 2 — Objet et Acceptation</a></li>
                <li><a href="#art3">Art. 3 — Accès et Création de Compte</a></li>
                <li><a href="#art4">Art. 4 — Rôle de Karnou</a></li>
                <li><a href="#art5">Art. 5 — Publication des Annonces</a></li>
                <li><a href="#art6">Art. 6 — Transactions et Paiements</a></li>
                <li><a href="#art7">Art. 7 — Livraison</a></li>
                <li><a href="#art8">Art. 8 — Droit de Rétractation</a></li>
                <li><a href="#art9">Art. 9 — Propriété Intellectuelle</a></li>
                <li><a href="#art10">Art. 10 — Comportements Interdits</a></li>
                <li><a href="#art11">Art. 11 — Résiliation</a></li>
                <li><a href="#art12">Art. 12 — Loi Applicable</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="legal-main">

            <!-- Disclaimer Box -->


            <article id="art1" class="legal-article">
                <div class="article-num">01</div>
                <div class="article-body">
                    <h2>Définitions</h2>
                    <p>Dans les présentes CGU, les termes suivants ont la signification suivante :</p>
                    <ul>
                        <li><strong>Karnou / Nous :</strong> désigne le groupe Karnou, société de droit centrafricain opérant la Plateforme.</li>
                        <li><strong>Utilisateur :</strong> désigne toute personne physique ou morale accédant à la Plateforme, qu'elle soit Acheteur ou Vendeur.</li>
                        <li><strong>Acheteur :</strong> désigne tout Utilisateur qui effectue ou tente d'effectuer un achat sur la Plateforme.</li>
                        <li><strong>Vendeur :</strong> désigne tout Utilisateur qui publie des annonces et propose des produits à la vente.</li>
                        <li><strong>Annonce :</strong> désigne l'offre de vente d'un produit publiée par un Vendeur.</li>
                        <li><strong>Transaction :</strong> désigne l'ensemble des opérations réalisées entre un Acheteur et un Vendeur via la Plateforme.</li>
                    </ul>
                </div>
            </article>

            <article id="art2" class="legal-article">
                <div class="article-num">02</div>
                <div class="article-body">
                    <h2>Objet et Acceptation des CGU</h2>
                    <p>Les présentes CGU ont pour objet de définir les conditions d'accès et d'utilisation de la Plateforme ainsi que les droits et obligations des Utilisateurs. Karnou se réserve le droit de modifier les présentes CGU à tout moment. Les modifications entreront en vigueur dès leur publication sur la Plateforme. Il appartient à l'Utilisateur de consulter régulièrement les CGU en vigueur.</p>
                </div>
            </article>

            <article id="art3" class="legal-article">
                <div class="article-num">03</div>
                <div class="article-body">
                    <h2>Accès à la Plateforme et Création de Compte</h2>
                    <p>L'accès à la Plateforme est gratuit pour tout Utilisateur disposant d'un accès à internet. Toutefois, certaines fonctionnalités (achat, vente, messagerie) nécessitent la création d'un compte personnel. L'Utilisateur s'engage à :</p>
                    <ul>
                        <li>Fournir des informations exactes, complètes et à jour lors de son inscription.</li>
                        <li>Maintenir la confidentialité de ses identifiants de connexion.</li>
                        <li>Informer Karnou immédiatement en cas d'utilisation non autorisée de son compte.</li>
                        <li>Ne pas créer plusieurs comptes ou utiliser le compte d'un tiers.</li>
                    </ul>
                    <p>Karnou se réserve le droit de suspendre ou de supprimer tout compte en cas de violation des présentes CGU ou de suspicion de fraude.</p>
                </div>
            </article>

            <article id="art4" class="legal-article">
                <div class="article-num">04</div>
                <div class="article-body">
                    <h2>Rôle de Karnou et Responsabilité</h2>
                    <p>Karnou agit en qualité d'intermédiaire entre les Acheteurs et les Vendeurs. À ce titre, Karnou n'est pas vendeur des produits listés sur la Plateforme et ne peut être tenu responsable des informations communiquées par les Vendeurs, de la qualité ou de la conformité des produits vendus, ni de l'exécution des Transactions. Cependant, Karnou met à disposition des Utilisateurs un service client et un système de médiation pour faciliter la résolution des litiges.</p>
                </div>
            </article>

            <article id="art5" class="legal-article">
                <div class="article-num">05</div>
                <div class="article-body">
                    <h2>Publication des Annonces</h2>
                    <p>Tout Vendeur est seul responsable du contenu de ses Annonces. Sont strictement interdites les annonces relatives à :</p>
                    <ul>
                        <li>Des produits illicites ou dont la vente est réglementée (armes, substances contrôlées, etc.).</li>
                        <li>Des produits contrefaits ou portant atteinte aux droits de propriété intellectuelle de tiers.</li>
                        <li>Des produits dangereux pour la santé ou la sécurité des personnes.</li>
                        <li>Des denrées alimentaires ou médicaments sans les autorisations requises.</li>
                    </ul>
                    <p>Karnou se réserve le droit de supprimer toute Annonce non conforme sans préavis ni indemnité.</p>
                </div>
            </article>

            <article id="art6" class="legal-article">
                <div class="article-num">06</div>
                <div class="article-body">
                    <h2>Transactions et Paiements</h2>
                    <p>Les Transactions réalisées sur la Plateforme sont soumises aux conditions suivantes :</p>
                    <ul>
                        <li>Le prix d'un produit est celui indiqué dans l'Annonce au moment de la commande, hors frais de livraison.</li>
                        <li>Le paiement est encaissé par Karnou pour le compte du Vendeur et conservé en séquestre jusqu'à la bonne réception du produit par l'Acheteur.</li>
                        <li>La vente est finalisée lorsque l'Acheteur confirme la bonne réception ou à l'expiration du délai de réclamation.</li>
                    </ul>
                </div>
            </article>

            <article id="art7" class="legal-article">
                <div class="article-num">07</div>
                <div class="article-body">
                    <h2>Livraison et Karnou Express</h2>
                    <p>Les délais et frais de livraison sont indiqués dans chaque Annonce. Karnou met à disposition son service de livraison intégré, Karnou Express, permettant de suivre les colis en temps réel. En cas de retard ou de perte de colis, l'Acheteur doit contacter le service client dans un délai maximal de 30 jours suivant la date de livraison estimée.</p>
                </div>
            </article>

            <article id="art8" class="legal-article">
                <div class="article-num">08</div>
                <div class="article-body">
                    <h2>Droit de Rétractation et Retours</h2>
                    <p>Conformément aux dispositions légales en vigueur, tout Acheteur particulier bénéficie d'un droit de rétractation de <strong>14 jours</strong> à compter de la réception de son colis, sans avoir à justifier de motifs ni à payer de pénalités. Pour exercer ce droit, l'Acheteur doit notifier sa décision au Vendeur via la messagerie de la Plateforme. Les frais de retour sont à la charge de l'Acheteur, sauf accord contraire du Vendeur.</p>
                </div>
            </article>

            <article id="art9" class="legal-article">
                <div class="article-num">09</div>
                <div class="article-body">
                    <h2>Propriété Intellectuelle</h2>
                    <p>L'ensemble des contenus de la Plateforme (textes, images, logos, graphismes, logiciels) est protégé par la législation sur la propriété intellectuelle. Toute reproduction, représentation, modification ou exploitation, totale ou partielle, sans le consentement préalable et écrit de Karnou est strictement interdite.</p>
                </div>
            </article>

            <article id="art10" class="legal-article">
                <div class="article-num">10</div>
                <div class="article-body">
                    <h2>Comportements Interdits</h2>
                    <p>Sont strictement prohibés sur la Plateforme :</p>
                    <ul>
                        <li>Toute tentative de contournement des systèmes de paiement de la Plateforme.</li>
                        <li>Le harcèlement, les menaces ou insultes envers un autre Utilisateur.</li>
                        <li>La publication de faux avis ou de commentaires frauduleux.</li>
                        <li>La collecte de données personnelles d'autres Utilisateurs sans consentement.</li>
                        <li>L'utilisation de robots ou de tout autre procédé automatisé pour accéder à la Plateforme.</li>
                    </ul>
                </div>
            </article>

            <article id="art11" class="legal-article">
                <div class="article-num">11</div>
                <div class="article-body">
                    <h2>Résiliation et Suspension</h2>
                    <p>Karnou se réserve le droit de suspendre ou résoudre, de plein droit et sans préavis, le compte d'un Utilisateur en cas de manquement grave aux présentes CGU. L'Utilisateur peut également demander la clôture de son compte à tout moment depuis les paramètres de son profil ou en contactant notre service client.</p>
                </div>
            </article>

            <article id="art12" class="legal-article">
                <div class="article-num">12</div>
                <div class="article-body">
                    <h2>Loi Applicable et Juridiction Compétente</h2>
                    <p>Les présentes CGU sont régies par le droit applicable dans le pays de siège social de Karnou Group. Tout litige relatif à leur interprétation ou à leur exécution, qui n'aurait pas pu être résolu à l'amiable, sera soumis à la juridiction compétente.</p>
                </div>
            </article>

            <!-- Footer contact strip -->

        </main>
    </div>
</div>

@push('styles')
<style>
    /* Force hide marketplace elements */
    .top-banner, .header, .footer { display: none !important; visibility: hidden !important; height: 0 !important; overflow: hidden !important; }
    body { padding-top: 0 !important; margin-top: 0 !important; background: #f8f9fb !important; }

    /* --- Base --- */
    .legal-page { background: #f8f9fb; min-height: 100vh; position: relative; z-index: 1000; }
    .about-container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }

    /* --- Corporate Header --- */
    .corporate-header { background: #fff; padding: 1rem 0; border-bottom: 1px solid #eee; font-family: 'Inter', sans-serif; position: sticky; top: 0; z-index: 1000; }
    .corporate-header .about-container { max-width: 1350px; padding: 0 1.5rem; }
    .corp-header-flex { display: flex; justify-content: space-between; align-items: center; }

    .header-left, .header-right { flex: 1; display: flex; align-items: center; }
    .header-center { flex: 0; display: flex; justify-content: center; }
    .header-right { justify-content: flex-end; gap: 1.5rem; }

    .back-to-site, .header-auth, .cart-link { text-decoration: none; color: #555; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; gap: 0.6rem; transition: all 0.2s; }
    .back-to-site:hover, .header-auth:hover, .cart-link:hover { color: #004aad; }
    .back-to-site i, .header-auth i, .cart-link i { font-size: 1rem; }

    .corp-logo img { height: 28px; width: auto; display: block; }
    .corp-brand { font-size: 1.5rem; font-weight: 800; color: #004aad; letter-spacing: -1.5px; }

    /* --- Sub Nav --- */
    .about-sub-nav { background: #fff; border-bottom: 1px solid #eee; position: sticky; top: 61px; z-index: 900; padding: 1.2rem 0; box-shadow: 0 4px 6px -2px rgba(0,0,0,0.05); }
    .about-sub-nav .about-container { max-width: 1350px; }
    .about-sub-nav ul { display: flex; list-style: none; gap: 1rem; margin: 0; padding: 0; justify-content: center; flex-wrap: wrap; }
    .about-sub-nav ul li a { text-decoration: none; color: #555; font-size: 0.85rem; font-weight: 500; padding: 0.6rem 1rem; border-radius: 4px; transition: all 0.2s; }
    .about-sub-nav ul li a:hover { color: #004aad; background: #f0f7ff; }
    .about-sub-nav ul li.active a { background: #004aad; color: #fff; font-weight: 600; padding: 0.7rem 1.2rem; }

    /* --- Legal Hero --- */
    .legal-hero {
        background: linear-gradient(135deg, rgba(0, 74, 173, 0.9) 0%, rgba(0, 49, 130, 0.8) 100%), url('/images/condition.jpg');
        background-size: cover;
        background-position: center;
        padding: 4rem 2rem;
        color: #fff;
        min-height: 480px;
        display: flex;
        align-items: center;
    }
    .legal-hero-inner {
        max-width: 800px;
        margin: 0 auto;
    }
    .legal-category-badge {
        display: inline-block;
        background: rgba(255,255,255,0.15);
        color: rgba(255,255,255,0.9);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        padding: 0.35rem 0.9rem;
        border-radius: 50px;
        margin-bottom: 1.2rem;
        font-family: 'Inter', sans-serif;
        border: 1px solid rgba(255,255,255,0.2);
    }
    .legal-hero h1 {
        font-size: 2.2rem;
        font-weight: 700;
        font-family: 'Outfit', 'Inter', sans-serif;
        color: #fff;
        margin: 0 0 0.8rem;
        letter-spacing: -0.5px;
        line-height: 1.2;
    }
    .legal-hero-desc {
        font-size: 1rem;
        color: rgba(255,255,255,0.8);
        font-family: 'Inter', sans-serif;
        margin: 0 0 1.5rem;
        line-height: 1.6;
    }
    .legal-meta {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.85rem;
        color: rgba(255,255,255,0.7);
        font-family: 'Inter', sans-serif;
        flex-wrap: wrap;
    }
    .legal-meta i { margin-right: 0.3rem; font-size: 0.8rem; }
    .meta-sep { opacity: 0.4; }

    /* --- 2-Column Layout --- */
    .legal-layout {
        display: flex;
        align-items: flex-start;
        max-width: 1200px;
        margin: 3rem auto;
        padding: 0 2rem;
        gap: 3rem;
    }

    /* --- Sidebar --- */
    .legal-toc {
        width: 240px;
        flex-shrink: 0;
        position: sticky;
        top: 80px;
        background: #fff;
        border: 1px solid #e8ecf0;
        border-radius: 12px;
        padding: 1.5rem;
    }
    .toc-title {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #999;
        font-family: 'Inter', sans-serif;
        margin: 0 0 1rem;
    }
    .toc-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .toc-list li {
        margin-bottom: 0.1rem;
    }
    .toc-list li a {
        display: block;
        font-size: 0.82rem;
        color: #555;
        text-decoration: none;
        font-family: 'Inter', sans-serif;
        padding: 0.4rem 0.6rem;
        border-radius: 6px;
        transition: all 0.15s;
        line-height: 1.4;
    }
    .toc-list li a:hover {
        background: #fff5eb;
        color: #f68b1e;
    }

    /* --- Main Content --- */
    .legal-main {
        flex: 1;
        min-width: 0;
    }

    /* --- Disclaimer Box --- */
    .legal-disclaimer {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-left: 4px solid #004aad;
        border-radius: 8px;
        padding: 1.2rem 1.5rem;
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        color: #1e3a6a;
        line-height: 1.6;
        margin-bottom: 2.5rem;
    }
    .legal-disclaimer i {
        font-size: 1.2rem;
        color: #004aad;
        margin-top: 0.1rem;
        flex-shrink: 0;
    }

    /* --- Article Blocks --- */
    .legal-article {
        display: flex;
        gap: 1.5rem;
        align-items: flex-start;
        background: #fff;
        border: 1px solid #e8ecf0;
        border-radius: 12px;
        padding: 2rem 2rem 2rem 1.5rem;
        margin-bottom: 1.2rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .legal-article:hover {
        border-color: #f68b1e;
        box-shadow: 0 4px 16px rgba(246,139,30,0.1);
    }
    .article-num {
        font-size: 1.2rem;
        font-weight: 800;
        color: #ffe5cc;
        font-family: 'Outfit', sans-serif;
        letter-spacing: -1px;
        width: 36px;
        flex-shrink: 0;
        padding-top: 0.15rem;
        text-align: center;
        line-height: 1;
    }
    .article-body {
        flex: 1;
        min-width: 0;
    }
    .article-body h2 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1a1a1a;
        font-family: 'Outfit', 'Inter', sans-serif;
        margin: 0 0 1rem;
        padding: 0;
    }
    .article-body p {
        font-family: 'Inter', sans-serif;
        font-size: 0.92rem;
        color: #4b5563;
        line-height: 1.75;
        margin-bottom: 0.8rem;
    }
    .article-body ul {
        padding-left: 1.3rem;
        margin-bottom: 0.8rem;
    }
    .article-body li {
        font-family: 'Inter', sans-serif;
        font-size: 0.92rem;
        color: #4b5563;
        line-height: 1.7;
        margin-bottom: 0.5rem;
    }


    /* --- Responsive --- */
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
    // Highlight active TOC item on scroll
    document.addEventListener('DOMContentLoaded', () => {
        const articles = document.querySelectorAll('.legal-article');
        const tocLinks = document.querySelectorAll('.toc-list a');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    tocLinks.forEach(link => link.style.background = '');
                    tocLinks.forEach(link => link.style.color = '');
                    const active = document.querySelector(`.toc-list a[href="#${entry.target.id}"]`);
                    if (active) {
                        active.style.background = '#fff5eb';
                        active.style.color = '#f68b1e';
                        active.style.fontWeight = '600';
                    }
                } else {
                    const link = document.querySelector(`.toc-list a[href="#${entry.target.id}"]`);
                    if (link) {
                        link.style.background = '';
                        link.style.color = '';
                        link.style.fontWeight = '';
                    }
                }
            });
        }, { rootMargin: '-20% 0px -70% 0px' });

        articles.forEach(a => observer.observe(a));
    });
</script>
@endsection
