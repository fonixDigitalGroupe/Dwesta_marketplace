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
    <div class="legal-hero" style="background-image: linear-gradient(rgba(0, 74, 173, 0.9), rgba(0, 74, 173, 0.9)), url('{{ asset('images/contact_bannier.png') }}');">
        <div class="legal-hero-inner">
            <span class="legal-category-badge">Contact</span>
            <h1>Nous sommes à votre écoute</h1>
            <p>Une question, un partenariat ou besoin d'assistance ? Notre équipe est là pour vous répondre.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="about-container">
        <div class="contact-grid">
            <!-- Contact Info -->
            <div class="contact-info">
                <h2>Informations de contact</h2>
                <p>N'hésitez pas à nous contacter via nos différents canaux.</p>
                
                <div class="info-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <div>
                        <h3>Siège social</h3>
                        <p>Bangui, République Centrafricaine</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fa-solid fa-envelope"></i>
                    <div>
                        <h3>Email</h3>
                        <p>contact@karnou.com</p>
                    </div>
                </div>

                <div class="info-item">
                    <i class="fa-solid fa-phone"></i>
                    <div>
                        <h3>Téléphone</h3>
                        <p>+236 00 00 00 00</p>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form-wrapper">
                <form class="premium-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nom complet</label>
                            <input type="text" placeholder="Votre nom" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" placeholder="votre@email.com" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Sujet</label>
                        <select required>
                            <option value="">Sélectionnez un sujet</option>
                            <option value="support">Support technique</option>
                            <option value="vendeur">Devenir vendeur</option>
                            <option value="partenariat">Partenariat</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea rows="5" placeholder="Comment pouvons-nous vous aider ?" required></textarea>
                    </div>
                    <button type="submit" class="btn-primary-corp">Envoyer le message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Consistent styles */
    .legal-page { font-family: 'Outfit', sans-serif; color: #333; background-color: #fff; }
    .about-container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
    
    .corporate-header { background: #fff; padding: 1.25rem 0; border-bottom: 1px solid #efefef; position: sticky; top: 0; z-index: 1000; }
    .corp-header-flex { display: flex; justify-content: space-between; align-items: center; padding: 0 2rem; }
    .corp-logo { display: block; text-decoration: none; }
    .corp-brand { font-size: 1.4rem; font-weight: 700; color: #004aad; letter-spacing: -1px; }
    .corp-nav ul { display: flex; list-style: none; gap: 0.8rem; margin: 0; padding: 0; flex-wrap: wrap; justify-content: flex-end; }
    .corp-nav ul li a { text-decoration: none; color: #555; font-size: 0.82rem; font-weight: 500; font-family: 'Inter', sans-serif; transition: all 0.2s; border-bottom: 2px solid transparent; padding-bottom: 0.3rem; }
    .corp-nav ul li a:hover { color: #004aad; }
    .corp-nav ul li.active a { color: #004aad; border-bottom: 2px solid #004aad; font-weight: 600; }

    .legal-hero { height: 350px; background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; text-align: center; color: #fff; }
    .legal-hero-inner { max-width: 800px; padding: 2rem; }
    .legal-category-badge { display: inline-block; padding: 0.5rem 1.25rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); border-radius: 50px; font-size: 0.85rem; font-weight: 600; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px; backdrop-filter: blur(5px); }
    .legal-hero h1 { font-size: 3rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.1; letter-spacing: -1px; }
    .legal-hero p { font-size: 1.2rem; opacity: 0.9; font-weight: 400; }

    .contact-grid { display: grid; grid-template-columns: 1fr 1.5fr; gap: 5rem; padding: 5rem 0; }
    .contact-info h2 { font-size: 2rem; font-weight: 800; margin-bottom: 1rem; color: #111; }
    .contact-info p { color: #666; margin-bottom: 2.5rem; }
    
    .info-item { display: flex; gap: 1.5rem; margin-bottom: 2rem; align-items: flex-start; }
    .info-item i { font-size: 1.5rem; color: #004aad; background: #f0f7ff; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 12px; }
    .info-item h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem; }
    .info-item p { margin-bottom: 0; }

    .contact-form-wrapper { background: #fff; border: 1px solid #efefef; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
    .premium-form .form-group { margin-bottom: 1.5rem; }
    .premium-form .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    .premium-form label { display: block; font-size: 0.85rem; font-weight: 600; color: #111; margin-bottom: 0.5rem; }
    .premium-form input, .premium-form select, .premium-form textarea { width: 100%; padding: 0.8rem 1.2rem; border: 1px solid #e1e1e1; border-radius: 10px; font-family: 'Inter', sans-serif; transition: all 0.2s; outline: none; }
    .premium-form input:focus, .premium-form select:focus, .premium-form textarea:focus { border-color: #004aad; box-shadow: 0 0 0 4px rgba(0, 74, 173, 0.1); }
    
    .btn-primary-corp { background: #004aad; color: #fff; border: none; padding: 1rem 2rem; border-radius: 10px; font-weight: 600; cursor: pointer; transition: all 0.2s; width: 100%; margin-top: 1rem; font-size: 1rem; }
    .btn-primary-corp:hover { background: #003a8a; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0, 74, 173, 0.2); }

    @media (max-width: 968px) {
        .contact-grid { grid-template-columns: 1fr; gap: 3rem; }
        .contact-form-wrapper { padding: 2rem; }
        .premium-form .form-row { grid-template-columns: 1fr; }
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@endsection
