@extends('layouts.app')

@section('title', 'Service Clients : À votre écoute - Karnou')

@section('content')
<div class="legal-page">
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

    <div class="page-hero" style="background-image: linear-gradient(135deg, rgba(0,74,173,0.88) 0%, rgba(0,30,90,0.82) 100%), url('/images/apropos_bannier.jpg');">
        <div class="about-container">
            <h1>Service Clients : À votre écoute</h1>
            <p class="page-hero-desc">Besoin d'aide ou d'un renseignement ? Notre service clients est disponible pour vous accompagner dans votre expérience Karnou.</p>
            <p class="last-update">Dernière mise à jour : 11 Juin 2026</p>
        </div>
    </div>

    <div class="legal-layout">
        <aside class="legal-toc">
            <p class="toc-title">Sur cette page</p>
            <ul class="toc-list">
                <li><a href="#srv1">1 — Support 24/7</a></li>
                <li><a href="#srv2">2 — Centre d'aide</a></li>
                <li><a href="#srv3">3 — Nous Contacter</a></li>
            </ul>
        </aside>

        <main class="legal-main">
            <article id="srv1" class="legal-article">
                <div class="article-num">01</div>
                <div class="article-body">
                    <h2>Un support réactif</h2>
                    <p>Notre équipe dédiée répond à vos questions sur les commandes, les comptes vendeurs, ou tout problème technique que vous pourriez rencontrer.</p>
                </div>
            </article>

            <article id="srv2" class="legal-article">
                <div class="article-num">02</div>
                <div class="article-body">
                    <h2>Centre d'aide en ligne</h2>
                    <p>Consultez notre <a href="{{ route('help') }}">FAQ</a> pour trouver des réponses immédiates aux questions les plus fréquentes sur le fonctionnement de la plateforme.</p>
                </div>
            </article>

            <article id="srv3" class="legal-article">
                <div class="article-num">03</div>
                <div class="article-body">
                    <h2>Plusieurs moyens de contact</h2>
                    <p>Vous pouvez nous joindre via notre formulaire de contact, par email ou directement via la messagerie instantanée sur votre espace compte.</p>
                </div>
            </article>
        </main>
    </div>
</div>

@push('styles')
<style>
    .top-banner, .header { display: none !important; visibility: hidden !important; height: 0 !important; overflow: hidden !important; }
    body { padding-top: 0 !important; margin-top: 0 !important; background: #ffffff !important; }
    .legal-page { background: #ffffff; min-height: 100vh; position: relative; z-index: 1000; }
    .about-container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }
    .corporate-header { background: #fff; padding: 1rem 0; border-bottom: 1px solid #eee; font-family: 'Inter', sans-serif; position: sticky; top: 0; z-index: 1000; }
    .corporate-header .about-container { max-width: 1350px; padding: 0 1.5rem; }
    .corp-header-flex { display: flex; justify-content: space-between; align-items: center; }
    .header-left, .header-right { flex: 1; display: flex; align-items: center; }
    .header-center { flex: 0; display: flex; justify-content: center; }
    .header-right { justify-content: flex-end; gap: 1.5rem; }
    .back-to-site, .header-auth, .cart-link { text-decoration: none; color: #555; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; gap: 0.6rem; }
    .back-to-site:hover, .header-auth:hover, .cart-link:hover { color: #004aad; }
    .corp-logo img { height: 28px; width: auto; display: block; }
    .corp-brand { font-size: 1.5rem; font-weight: 800; color: #004aad; letter-spacing: -1.5px; }
    .page-hero { background-size: cover; background-position: center; padding: 5rem 0 4rem; text-align: center; color: #fff; }
    .page-hero h1 { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 0.8rem; letter-spacing: -0.5px; }
    .page-hero .last-update { font-family: 'Inter', sans-serif; font-size: 0.78rem; color: rgba(255,255,255,0.45); font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
    .page-hero-desc { font-family: 'Inter', sans-serif; font-size: 1rem; color: rgba(255,255,255,0.8); max-width: 680px; margin: 0 auto 1.2rem; line-height: 1.6; }
    .legal-layout { display: flex; align-items: flex-start; max-width: 1200px; margin: 3rem auto; padding: 0 2rem; gap: 3rem; }
    .legal-toc { width: 240px; flex-shrink: 0; position: sticky; top: 80px; background: #fff; border: 1px solid #f1f3f5; border-radius: 12px; padding: 1.5rem; }
    .toc-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1.5px; color: #999; font-family: 'Inter', sans-serif; margin: 0 0 1rem; }
    .toc-list { list-style: none; padding: 0; margin: 0; }
    .toc-list li { margin-bottom: 0.1rem; }
    .toc-list li a { display: block; font-size: 0.82rem; color: #555; text-decoration: none; font-family: 'Inter', sans-serif; padding: 0.4rem 0.6rem; border-radius: 6px; line-height: 1.4; }
    .toc-list li a:hover { background: #fff5eb; color: #f68b1e; }
    .legal-main { flex: 1; min-width: 0; }
    .legal-article { display: flex; gap: 1.5rem; align-items: flex-start; background: #fff; border: 1px solid #f0f0f0; border-radius: 12px; padding: 2rem 2rem 2rem 1.5rem; margin-bottom: 1.2rem; }
    .article-num { font-size: 1.2rem; font-weight: 800; color: #ffe5cc; font-family: 'Outfit', sans-serif; letter-spacing: -1px; width: 36px; flex-shrink: 0; padding-top: 0.15rem; text-align: center; line-height: 1; }
    .article-body { flex: 1; min-width: 0; }
    .article-body h2 { font-size: 1.05rem; font-weight: 700; color: #1a1a1a; font-family: 'Outfit', 'Inter', sans-serif; margin: 0 0 1rem; }
    .article-body p { font-family: 'Inter', sans-serif; font-size: 0.92rem; color: #4b5563; line-height: 1.75; margin-bottom: 0.8rem; }
    .article-body a { color: #f68b1e; text-decoration: none; font-weight: 600; }
    @media (max-width: 900px) { .legal-layout { flex-direction: column; } .legal-toc { position: static; width: 100%; } .toc-list { display: grid; grid-template-columns: 1fr 1fr; gap: 0.2rem; } }
    @media (max-width: 600px) { .legal-layout { padding: 0 1rem; margin: 1.5rem auto; } .article-num { display: none; } .legal-article { padding: 1.5rem; } .toc-list { grid-template-columns: 1fr; } }
</style>
@endpush

@endsection
