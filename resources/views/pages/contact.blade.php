@extends('layouts.app')

@section('title', 'Contactez-nous - Karnou')

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
    <div class="legal-hero" style="background: linear-gradient(135deg, rgba(0, 74, 173, 0.9) 0%, rgba(0, 49, 130, 0.8) 100%), url('{{ asset('images/contact_bannier.png') }}'); background-size: cover; background-position: center;">
        <div class="legal-hero-inner">
            <span class="legal-category-badge">Contact</span>
            <h1>Nous sommes à votre écoute</h1>
            <p class="legal-hero-desc">Une question, un partenariat ou besoin d'assistance ? Notre équipe est prête à vous répondre.</p>
            <div class="legal-meta">
                <span><i class="fa-regular fa-calendar"></i> Disponibilité 24/7</span>
                <span class="meta-sep">·</span>
                <span><i class="fa-solid fa-location-dot"></i> Bangui, RCA</span>
                <span class="meta-sep">·</span>
                <span><i class="fa-solid fa-envelope"></i> contact@karnou.com</span>
            </div>
        </div>
    </div>

    <!-- Layout -->
    <div class="legal-layout">

        <!-- TOC Sidebar -->
        <aside class="legal-toc">
            <p class="toc-title">Table des matières</p>
            <ul class="toc-list">
                <li><a href="#con1">1 — Nos coordonnées</a></li>
                <li><a href="#con2">2 — Formulaire de contact</a></li>
                <li><a href="#con3">3 — Support technique</a></li>
                <li><a href="#con4">4 — Partenariats</a></li>
            </ul>
        </aside>

        <!-- Main -->
        <main class="legal-main">
            <p class="legal-intro">Vous avez plusieurs moyens d'entrer en contact avec l'équipe Karnou. Choisissez l'option qui vous convient le mieux selon votre besoin.</p>

            <article id="con1" class="legal-article">
                <div class="article-num">01</div>
                <div class="article-body">
                    <h2>Nos coordonnées officielles</h2>
                    <p>Pour toute correspondance officielle ou visite à nos bureaux :</p>
                    <ul style="list-style: none; padding-left: 0;">
                        <li><i class="fa-solid fa-location-dot" style="color: #004aad; margin-right: 0.8rem;"></i> <strong>Siège :</strong> Bangui, République Centrafricaine</li>
                        <li><i class="fa-solid fa-envelope" style="color: #004aad; margin-right: 0.8rem;"></i> <strong>Email général :</strong> contact@karnou.com</li>
                        <li><i class="fa-solid fa-phone" style="color: #004aad; margin-right: 0.8rem;"></i> <strong>Téléphone :</strong> +236 00 00 00 00</li>
                    </ul>
                </div>
            </article>

            <article id="con2" class="legal-article">
                <div class="article-num">02</div>
                <div class="article-body">
                    <h2>Formulaire de contact rapide</h2>
                    <p>Utilisez ce formulaire pour nous envoyer un message direct. Nous vous répondrons sous 24h ouvrées.</p>
                    
                    <form class="premium-form-legal">
                        <div class="form-row-legal">
                            <div class="form-group-legal">
                                <label>Nom complet</label>
                                <input type="text" placeholder="Votre nom" required>
                            </div>
                            <div class="form-group-legal">
                                <label>Email</label>
                                <input type="email" placeholder="votre@email.com" required>
                            </div>
                        </div>
                        <div class="form-group-legal">
                            <label>Message</label>
                            <textarea rows="4" placeholder="Comment pouvons-nous vous aider ?" required></textarea>
                        </div>
                        <button type="submit" class="btn-primary-corp-v2">Envoyer le message</button>
                    </form>
                </div>
            </article>

            <article id="con3" class="legal-article">
                <div class="article-num">03</div>
                <div class="article-body">
                    <h2>Support technique & Client</h2>
                    <p>Pour tout problème technique lié à votre compte ou à une annonce :</p>
                    <p><a href="mailto:support@karnou.com">support@karnou.com</a> (Disponible 24/7)</p>
                </div>
            </article>

            <article id="con4" class="legal-article">
                <div class="article-num">04</div>
                <div class="article-body">
                    <h2>Partenariats & Presse</h2>
                    <p>Vous souhaitez collaborer avec Karnou ou obtenir des informations pour vos médias ?</p>
                    <p><a href="mailto:media@karnou.com">media@karnou.com</a></p>
                </div>
            </article>

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
    .corporate-header { background: #fff; padding: 1.2rem 0; border-bottom: 1px solid #eee; font-family: 'Inter', sans-serif; }
    .corp-header-flex { display: flex; justify-content: space-between; align-items: center; }
    .corp-logo { display: block; text-decoration: none; }
    .corp-brand { font-size: 1.4rem; font-weight: 700; color: #004aad; letter-spacing: -1px; }
    .corp-nav ul { display: flex; list-style: none; gap: 0.8rem; margin: 0; padding: 0; flex-wrap: wrap; justify-content: flex-end; }
    .corp-nav ul li a { text-decoration: none; color: #555; font-size: 0.82rem; font-weight: 500; font-family: 'Inter', sans-serif; transition: all 0.2s; border-bottom: 2px solid transparent; padding-bottom: 0.3rem; }
    .corp-nav ul li a:hover { color: #004aad; }
    .corp-nav ul li.active a { color: #004aad; border-bottom: 2px solid #004aad; font-weight: 600; }

    .legal-hero {
        padding: 4rem 2rem;
        color: #fff;
        min-height: 400px;
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

    .legal-toc { width: 240px; flex-shrink: 0; position: sticky; top: 80px; background: #fff; border: 1px solid #e8ecf0; border-radius: 12px; padding: 1.5rem; }
    .toc-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #999; font-family: 'Inter', sans-serif; margin: 0 0 1rem; }
    .toc-list { list-style: none; padding: 0; margin: 0; }
    .toc-list li { margin-bottom: 0.1rem; }
    .toc-list li a { display: block; font-size: 0.82rem; color: #555; text-decoration: none; font-family: 'Inter', sans-serif; padding: 0.4rem 0.6rem; border-radius: 6px; transition: all 0.15s; line-height: 1.4; }
    .toc-list li a:hover { background: #fff5eb; color: #f68b1e; }

    .legal-main { flex: 1; min-width: 0; }
    .legal-intro { font-family: 'Inter', sans-serif; font-size: 0.95rem; color: #555; line-height: 1.75; margin-bottom: 2rem; }

    .legal-article { display: flex; gap: 1.5rem; align-items: flex-start; background: #fff; border: 1px solid #e8ecf0; border-radius: 12px; padding: 2rem 2rem 2rem 1.5rem; margin-bottom: 1.2rem; transition: border-color 0.2s, box-shadow 0.2s; }
    .legal-article:hover { border-color: #f68b1e; box-shadow: 0 4px 16px rgba(246,139,30,0.1); }
    .article-num { font-size: 1.2rem; font-weight: 800; color: #ffe5cc; font-family: 'Outfit', sans-serif; letter-spacing: -1px; width: 36px; flex-shrink: 0; padding-top: 0.15rem; text-align: center; line-height: 1; }
    .article-body { flex: 1; min-width: 0; }
    .article-body h2 { font-size: 1.05rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 1rem; }
    .article-body p { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.75; margin-bottom: 0.8rem; }
    .article-body a { color: #f68b1e; text-decoration: none; font-weight: 600; }
    .article-body a:hover { text-decoration: underline; }

    /* Form Styles within legal structure */
    .premium-form-legal { margin-top: 1.5rem; }
    .form-row-legal { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
    .form-group-legal { margin-bottom: 1rem; }
    .form-group-legal label { display: block; font-size: 0.8rem; font-weight: 600; color: #111; margin-bottom: 0.4rem; font-family: 'Inter', sans-serif; }
    .form-group-legal input, .form-group-legal textarea { width: 100%; padding: 0.7rem 1rem; border: 1px solid #e8ecf0; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 0.9rem; outline: none; transition: border-color 0.2s; }
    .form-group-legal input:focus, .form-group-legal textarea:focus { border-color: #004aad; }
    .btn-primary-corp-v2 { background: #004aad; color: #fff; border: none; padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s; font-size: 0.9rem; width: 100%; }
    .btn-primary-corp-v2:hover { background: #003a8a; }


    @media (max-width: 900px) {
        .legal-layout { flex-direction: column; }
        .legal-toc { position: static; width: 100%; }
        .toc-list { display: grid; grid-template-columns: 1fr 1fr; gap: 0.2rem; }
        .legal-hero h1 { font-size: 1.6rem; }
        .form-row-legal { grid-template-columns: 1fr; }
    }
</style>
@endpush

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
                    link.style.background = '#fff5eb';
                    link.style.color = '#f68b1e';
                    link.style.fontWeight = '600';
                }
            });
        }, { rootMargin: '-20% 0px -70% 0px' });
        articles.forEach(a => observer.observe(a));
    });
</script>
@endsection
