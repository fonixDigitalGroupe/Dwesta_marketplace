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

    <!-- Hero Section -->
    <div class="legal-hero" style="background-image: linear-gradient(rgba(0, 74, 173, 0.8), rgba(0, 74, 173, 0.8)), url('{{ asset('images/eshop_bannier.png') }}');">
        <div class="legal-hero-inner">
            <span class="legal-category-badge">Business & E-commerce</span>
            <h1>Développez votre activité avec Karnou</h1>
            <p>Rejoignez la première marketplace de Centrafrique et touchez des milliers de clients chaque jour.</p>
            <div style="margin-top: 2.5rem; display: flex; gap: 1rem; justify-content: center;">
                <a href="{{ route('vendeur.create') }}" class="btn-cta-primary">Créer mon e-shop gratuitement</a>
                <a href="#avantages" class="btn-cta-secondary">En savoir plus</a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="about-container">
        <section id="avantages" class="benefits-section">
            <div class="section-header">
                <h2>Pourquoi choisir Karnou ?</h2>
                <p>Nous mettons à votre disposition des outils puissants pour gérer vos ventes sans effort.</p>
            </div>

            <div class="benefits-grid">
                <div class="benefit-card">
                    <i class="fa-solid fa-earth-africa"></i>
                    <h3>Visibilité maximale</h3>
                    <p>Vos produits sont visibles par une audience nationale en constante croissance.</p>
                </div>
                <div class="benefit-card">
                    <i class="fa-solid fa-wallet"></i>
                    <h3>Paiements sécurisés</h3>
                    <p>Acceptez les paiements mobile (Orange Money, Wave) en toute simplicité.</p>
                </div>
                <div class="benefit-card">
                    <i class="fa-solid fa-chart-line"></i>
                    <h3>Tableau de bord pro</h3>
                    <p>Gérez vos stocks, vos commandes et suivez vos performances en temps réel.</p>
                </div>
                <div class="benefit-card">
                    <i class="fa-solid fa-headset"></i>
                    <h3>Support dédié</h3>
                    <p>Une équipe à votre écoute pour vous accompagner dans votre succès digital.</p>
                </div>
            </div>
        </section>

        <!-- Pricing / Types -->
        <section class="seller-types">
            <div class="type-box Particulier">
                <h3>Vendeur Particulier</h3>
                <p>Idéal pour vendre occasionnellement vos objets de seconde main.</p>
                <ul class="type-features">
                    <li><i class="fa-solid fa-check"></i> Inscription simplifiée</li>
                    <li><i class="fa-solid fa-check"></i> Jusqu'à 10 annonces</li>
                    <li><i class="fa-solid fa-check"></i> Commission standard</li>
                </ul>
                <a href="{{ route('vendeur.create', ['type' => 'particulier']) }}" class="btn-type">Commencer</a>
            </div>

            <div class="type-box Professionnel featured">
                <div class="popular-badge">Recommandé</div>
                <h3>Vendeur Professionnel</h3>
                <p>Pour les entreprises et commerçants souhaitant une présence forte.</p>
                <ul class="type-features">
                    <li><i class="fa-solid fa-check"></i> Page Pro exclusive</li>
                    <li><i class="fa-solid fa-check"></i> Annonces illimitées</li>
                    <li><i class="fa-solid fa-check"></i> Statistiques avancées</li>
                    <li><i class="fa-solid fa-check"></i> Support VIP</li>
                </ul>
                <a href="{{ route('vendeur.create', ['type' => 'professionnel']) }}" class="btn-type-pro">Devenir Pro</a>
            </div>
        </section>
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

    .legal-hero { height: 500px; background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; text-align: center; color: #fff; }
    .legal-hero-inner { max-width: 900px; padding: 2rem; }
    .legal-category-badge { display: inline-block; padding: 0.5rem 1.25rem; background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.3); border-radius: 50px; font-size: 0.85rem; font-weight: 600; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px; backdrop-filter: blur(5px); }
    .legal-hero h1 { font-size: 3.5rem; font-weight: 800; margin-bottom: 1.5rem; line-height: 1.1; letter-spacing: -1px; }
    .legal-hero p { font-size: 1.3rem; opacity: 0.9; margin-bottom: 0; }

    .btn-cta-primary { background: #f68b1e; color: #fff; text-decoration: none; padding: 1.2rem 2.5rem; border-radius: 50px; font-weight: 700; font-size: 1.1rem; transition: all 0.3s; }
    .btn-cta-primary:hover { background: #e57a18; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(246, 139, 30, 0.3); }
    .btn-cta-secondary { background: rgba(255,255,255,0.1); color: #fff; text-decoration: none; padding: 1.2rem 2.5rem; border-radius: 50px; font-weight: 600; border: 1px solid rgba(255,255,255,0.3); transition: all 0.3s; backdrop-filter: blur(5px); }
    .btn-cta-secondary:hover { background: rgba(255,255,255,0.2); }

    .benefits-section { padding: 6rem 0; text-align: center; }
    .section-header h2 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; color: #111; }
    .section-header p { color: #666; font-size: 1.2rem; margin-bottom: 4rem; }

    .benefits-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2.5rem; }
    .benefit-card { background: #fdfdfd; border: 1px solid #efefef; padding: 3rem 2rem; border-radius: 20px; transition: all 0.3s; }
    .benefit-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.05); border-color: #004aad; }
    .benefit-card i { font-size: 2.5rem; color: #004aad; margin-bottom: 1.5rem; }
    .benefit-card h3 { font-size: 1.3rem; font-weight: 700; margin-bottom: 1rem; }
    .benefit-card p { color: #666; font-size: 0.95rem; line-height: 1.6; }

    .seller-types { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 3rem; padding-bottom: 6rem; }
    .type-box { background: #fff; border: 1px solid #efefef; padding: 3.5rem; border-radius: 25px; display: flex; flex-direction: column; position: relative; }
    .type-box.featured { border: 2px solid #004aad; box-shadow: 0 20px 50px rgba(0, 74, 173, 0.1); }
    .popular-badge { position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: #004aad; color: #fff; padding: 0.4rem 1.25rem; border-radius: 50px; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; }
    
    .type-box h3 { font-size: 1.8rem; font-weight: 800; margin-bottom: 1.5rem; }
    .type-box p { color: #666; margin-bottom: 2.5rem; font-size: 1rem; }
    
    .type-features { list-style: none; padding: 0; margin: 0 0 3rem 0; flex-grow: 1; }
    .type-features li { display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem; font-weight: 500; font-size: 0.95rem; }
    .type-features li i { color: #2ecc71; font-size: 1rem; }

    .btn-type { border: 2px solid #efefef; color: #333; text-decoration: none; padding: 1rem; border-radius: 12px; text-align: center; font-weight: 700; transition: all 0.2s; }
    .btn-type:hover { border-color: #333; background: #333; color: #fff; }
    .btn-type-pro { background: #004aad; color: #fff; text-decoration: none; padding: 1rem; border-radius: 12px; text-align: center; font-weight: 700; transition: all 0.2s; }
    .btn-type-pro:hover { background: #003a8a; transform: scale(1.02); }

    @media (max-width: 968px) {
        .legal-hero h1 { font-size: 2.5rem; }
        .seller-types { grid-template-columns: 1fr; }
        .type-box { padding: 2.5rem; }
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
@endsection
