@extends('layouts.app')

@section('title', 'Contactez-nous - Karnou')

@section('content')
<div class="contact-page">
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

    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="contact-container">
            <h1>Comment pouvons-nous vous aider ?</h1>
            <p class="contact-hero-sub">Sélectionnez la catégorie qui correspond à votre besoin. Notre équipe vous répondra dans les meilleurs délais.</p>
            <p class="last-update">Dernière mise à jour : 02 Août 2026</p>
        </div>
    </section>

    <!-- Category Cards -->
    <section class="contact-categories">
        <div class="contact-container">
            <div class="category-grid">

                <div class="category-card">
                    <div class="cat-icon-box"><i class="fa-solid fa-bag-shopping"></i></div>
                    <h2>Vous êtes acheteur</h2>
                    <p>Suivi de commande, remboursement, problème de livraison ou question sur un produit.</p>
                    <a href="mailto:support@karnou.com" class="cat-cta">Contacter le support acheteur</a>
                </div>

                <div class="category-card">
                    <div class="cat-icon-box cat-icon-orange"><i class="fa-solid fa-store"></i></div>
                    <h2>Vous êtes vendeur</h2>
                    <p>Ouvrir un e-shop, gérer vos annonces, questions sur les commissions et les abonnements.</p>
                    <a href="mailto:vendeurs@karnou.com" class="cat-cta">Contacter l'équipe vendeurs</a>
                </div>

                <div class="category-card">
                    <div class="cat-icon-box cat-icon-green"><i class="fa-solid fa-life-ring"></i></div>
                    <h2>Support technique</h2>
                    <p>Problème de connexion, bug sur la plateforme, ou question technique sur votre compte.</p>
                    <a href="mailto:tech@karnou.com" class="cat-cta">Contacter le support tech</a>
                </div>

                <div class="category-card">
                    <div class="cat-icon-box cat-icon-purple"><i class="fa-solid fa-handshake"></i></div>
                    <h2>Partenariats & Presse</h2>
                    <p>Proposer une collaboration, obtenir un communiqué de presse ou des informations médias.</p>
                    <a href="mailto:media@karnou.com" class="cat-cta">Contacter l'équipe médias</a>
                </div>

            </div>
        </div>
    </section>

    <!-- Divider -->
    <div class="contact-divider">
        <div class="contact-container">
            <div class="divider-line"></div>
            <p class="divider-label">ou envoyez-nous un message directement</p>
        </div>
    </div>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="contact-container contact-form-inner">

            <!-- Infos Column -->
            <aside class="contact-infos">
                <h3>Nos coordonnées</h3>
                <ul class="infos-list">
                    @php
                        $contactAddress = \App\Models\Setting::get('contact_address');
                        $contactEmails  = json_decode(\App\Models\Setting::get('contact_emails', '[]'), true) ?: [];
                        $contactPhones  = json_decode(\App\Models\Setting::get('contact_phones', '[]'), true) ?: [];
                    @endphp

                    @if($contactAddress)
                    <li>
                        <span class="info-icon"><i class="fa-solid fa-location-dot"></i></span>
                        <div>
                            <strong>Siège social</strong><br>
                            {{ $contactAddress }}
                        </div>
                    </li>
                    @endif

                    @foreach($contactEmails as $email)
                    @if($email)
                    <li>
                        <span class="info-icon"><i class="fa-solid fa-envelope"></i></span>
                        <div>
                            <strong>Email</strong><br>
                            <a href="mailto:{{ $email }}">{{ $email }}</a>
                        </div>
                    </li>
                    @endif
                    @endforeach

                    @foreach($contactPhones as $phone)
                    @if($phone)
                    <li>
                        <span class="info-icon"><i class="fa-solid fa-phone"></i></span>
                        <div>
                            <strong>Téléphone</strong><br>
                            {{ $phone }}
                        </div>
                    </li>
                    @endif
                    @endforeach

                    <li>
                        <span class="info-icon"><i class="fa-solid fa-clock"></i></span>
                        <div>
                            <strong>Disponibilité</strong><br>
                            Support 24h/7j — Réponse sous 24h ouvrées
                        </div>
                    </li>
                </ul>
            </aside>

            <!-- Form Column -->
            <div class="contact-form-col contact-form-card">
                <h3>Envoyez-nous un message</h3>
                <form class="contact-form">
                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="contact-name">Nom complet</label>
                            <input type="text" id="contact-name" placeholder="Votre nom" required>
                        </div>
                        <div class="form-group">
                            <label for="contact-email">Email</label>
                            <input type="email" id="contact-email" placeholder="votre@email.com" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact-subject">Sujet</label>
                        <select id="contact-subject">
                            <option value="">Sélectionnez un sujet</option>
                            <option>Commande / Livraison</option>
                            <option>Compte acheteur</option>
                            <option>Devenir vendeur</option>
                            <option>Support technique</option>
                            <option>Partenariat / Presse</option>
                            <option>Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contact-message">Message</label>
                        <textarea id="contact-message" rows="5" placeholder="Décrivez votre demande en détail…" required></textarea>
                    </div>
                    <button type="submit" class="btn-send">Envoyer le message <i class="fa-solid fa-paper-plane"></i></button>
                </form>
            </div>

        </div>
    </section>

</div>

@push('styles')
<style>
    /* Force hide marketplace elements */
    .top-banner, .header { display: none !important; visibility: hidden !important; height: 0 !important; overflow: hidden !important; }
    body { padding-top: 0 !important; margin-top: 0 !important; background: #ffffff !important; }

    /* --- Base --- */
    .contact-page { background: #fff; min-height: 100vh; font-family: 'Inter', sans-serif; }
    .contact-container { max-width: 1160px; margin: 0 auto; padding: 0 2rem; }

    /* --- Corporate Header --- */
    .corporate-header { background: #fff; padding: 1rem 0; border-bottom: 1px solid #eee; position: sticky; top: 0; z-index: 1000; }
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

    /* --- Hero --- */
    .contact-hero { background: linear-gradient(135deg, rgba(0, 74, 173, 0.88) 0%, rgba(0, 30, 90, 0.82) 100%), url('/images/contact_bannier.png') center/cover no-repeat; padding: 5rem 0 4rem; border-bottom: none; text-align: center; }
    .contact-hero h1 { font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 0.8rem; letter-spacing: -0.5px; }
    .contact-hero-sub { font-size: 1rem; color: rgba(255,255,255,0.8); max-width: 560px; margin: 0 auto 0.8rem; line-height: 1.7; }
    .last-update { font-size: 0.78rem; color: rgba(255,255,255,0.45); font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }

    /* --- Category Cards --- */
    .contact-categories { padding: 4rem 0; background: #fff; }
    .category-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }

    .category-card { background: #fff; border: 1px solid #f0f0f0; border-radius: 16px; padding: 2rem 1.5rem; display: flex; flex-direction: column; align-items: flex-start; }
    .cat-icon-box { width: 48px; height: 48px; border-radius: 12px; background: #eef3ff; display: flex; align-items: center; justify-content: center; color: #004aad; font-size: 1.3rem; margin-bottom: 1.2rem; }
    .cat-icon-orange { background: #fff5eb; color: #f68b1e; }
    .cat-icon-green { background: #ecfdf5; color: #059669; }
    .cat-icon-purple { background: #f5f3ff; color: #7c3aed; }

    .category-card h2 { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #111; margin: 0 0 0.6rem; }
    .category-card p { font-size: 0.88rem; color: #6b7280; line-height: 1.65; flex: 1; margin-bottom: 1.5rem; }
    .cat-cta { font-size: 0.85rem; font-weight: 600; color: #004aad; text-decoration: none; border-bottom: 1px solid #c7d7f5; padding-bottom: 1px; }
    .cat-cta:hover { color: #f68b1e; border-color: #f68b1e; }

    /* --- Divider --- */
    .contact-divider { padding: 1.5rem 0; }
    .contact-divider .contact-container { display: flex; align-items: center; gap: 1.5rem; }
    .divider-line { flex: 1; height: 1px; background: #f0f0f0; }
    .divider-label { font-size: 0.82rem; color: #aaa; white-space: nowrap; font-style: italic; }

    /* --- Form Section --- */
    .contact-form-section { padding: 2rem 0 6rem; }
    .contact-form-inner { display: grid; grid-template-columns: 300px 1fr; gap: 4rem; align-items: flex-start; }

    /* Info aside */
    .contact-infos h3 { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #111; margin-bottom: 1.5rem; }
    .infos-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1.5rem; }
    .infos-list li { display: flex; gap: 1rem; align-items: flex-start; }
    .info-icon { width: 36px; height: 36px; border-radius: 10px; background: #f5f7fa; display: flex; align-items: center; justify-content: center; color: #004aad; font-size: 0.95rem; flex-shrink: 0; margin-top: 2px; }
    .infos-list strong { font-size: 0.82rem; font-weight: 700; color: #111; display: block; margin-bottom: 2px; }
    .infos-list a { color: #004aad; text-decoration: none; font-size: 0.88rem; }
    .infos-list a:hover { text-decoration: underline; }
    .infos-list div { font-size: 0.88rem; color: #6b7280; line-height: 1.5; }

    /* Form */
    .contact-form-col h3 { font-family: 'Outfit', sans-serif; font-size: 1rem; font-weight: 700; color: #111; margin-bottom: 1.5rem; }
    .contact-form-card { background: #fff; border: 1px solid #f0f0f0; border-radius: 16px; padding: 2rem 2.5rem; }
    .contact-form { display: flex; flex-direction: column; gap: 1rem; }
    .form-row-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
    .form-group { display: flex; flex-direction: column; gap: 0.35rem; }
    .form-group label { font-size: 0.8rem; font-weight: 600; color: #374151; }
    .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 0.7rem 0.9rem; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.9rem; font-family: 'Inter', sans-serif; color: #111; background: #fff; outline: none; box-sizing: border-box; }
    .form-group input:focus, .form-group textarea:focus, .form-group select:focus { border-color: #004aad; }
    .form-group textarea { resize: vertical; }
    .form-group select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='%23999' d='M6 8L0 0h12z'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 0.9rem center; padding-right: 2.5rem; }

    .btn-send { align-self: flex-start; background: #004aad; color: #fff; border: none; padding: 0.75rem 2rem; border-radius: 8px; font-size: 0.9rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.6rem; font-family: 'Inter', sans-serif; }
    .btn-send:hover { background: #003a8a; }

    /* --- Responsive --- */
    @media (max-width: 1024px) {
        .category-grid { grid-template-columns: repeat(2, 1fr); }
        .contact-form-inner { grid-template-columns: 1fr; gap: 2.5rem; }
    }
    @media (max-width: 600px) {
        .category-grid { grid-template-columns: 1fr; }
        .form-row-2 { grid-template-columns: 1fr; }
        .contact-hero h1 { font-size: 1.5rem; }
        .btn-send { width: 100%; justify-content: center; }
    }
</style>
@endpush

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Static experience — no animations
    });
</script>
@endsection
