<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#004aad">
        <title>Karnou Agence - Réseau de Points Relais</title>
        <!-- Fonts — same as Karnou Marketplace -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Inter', Roboto, 'Helvetica Neue', Arial, sans-serif;
                background-color: #f5f5f5;
                color: #333;
                overflow-x: hidden;
            }

            /* ——— TOP BANNER ——— */
            .top-banner {
                background-color: #004aad;
                height: 40px; width: 100%;
                display: flex; align-items: center; justify-content: center;
            }
            .top-banner p { color: #fff; font-size: 0.78rem; font-weight: 600; letter-spacing: 0.3px; }

            /* ——— HEADER ——— */
            .site-header {
                background-color: #ffffff; border-bottom: 1px solid #eee;
                box-shadow: 0 1px 3px rgba(0,0,0,0.04); position: sticky; top: 0; z-index: 1000;
            }
            .header-inner {
                max-width: 1400px; margin: 0 auto; padding: 0 2rem;
                display: flex; align-items: center; gap: 1.5rem; height: 70px;
            }
            .logo-text {
                font-size: 1.5rem; font-weight: 900; color: #000;
                text-decoration: none; letter-spacing: -0.5px; flex-shrink: 0;
            }
            .logo-text span { color: #bf0000; }
            .logo-badge {
                background: #16a34a; color: #fff; font-size: 0.65rem; font-weight: 800;
                padding: 2px 8px; border-radius: 50px; letter-spacing: 0.5px;
                text-transform: uppercase; margin-left: 10px; vertical-align: middle;
            }
            .header-spacer { flex: 1; }
            .header-nav { display: flex; align-items: center; gap: 1rem; }
            .header-nav a {
                font-size: 0.9rem; font-weight: 600; color: #333; text-decoration: none;
                padding: 8px 16px; border-radius: 8px; transition: background 0.15s;
            }
            .header-nav a:hover { background: #f5f5f5; }
            .header-nav .btn-cta { background: #ff8c00; color: #fff !important; border-radius: 8px; font-weight: 700; }
            .header-nav .btn-cta:hover { background: #e67e00; }
            .header-nav .btn-outline { border: 1.5px solid #004aad; color: #004aad !important; }
            .header-nav .btn-outline:hover { background: #eef2ff; }

            /* ——— HERO ——— */
            .hero {
                background: #ffffff; padding: 80px 2rem 90px; text-align: center;
                border-bottom: 1px solid #eee; position: relative; overflow: hidden;
            }
            .hero::before {
                content: ''; position: absolute; top: -100px; right: -100px;
                width: 400px; height: 400px;
                background: radial-gradient(circle, #e8f0fe 0%, transparent 70%); border-radius: 50%;
            }
            .hero::after {
                content: ''; position: absolute; bottom: -100px; left: -100px;
                width: 350px; height: 350px;
                background: radial-gradient(circle, #dcfce7 0%, transparent 70%); border-radius: 50%;
            }
            .hero-content { position: relative; z-index: 2; max-width: 860px; margin: 0 auto; }
            .hero-eyebrow {
                display: inline-flex; align-items: center; gap: 8px;
                background: #eef2ff; color: #004aad; font-size: 0.75rem; font-weight: 700;
                padding: 4px 14px; border-radius: 50px; margin-bottom: 28px; letter-spacing: 0.4px;
            }
            .hero-eyebrow span { width: 6px; height: 6px; background: #004aad; border-radius: 50%; display: inline-block; }
            .hero h1 {
                font-size: clamp(2.4rem, 5vw, 4rem); font-weight: 900; color: #1a1a1a;
                line-height: 1.1; margin-bottom: 20px; letter-spacing: -1.5px;
            }
            .hero h1 em { color: #16a34a; font-style: normal; }
            .hero h1 strong { color: #004aad; font-weight: 900; }
            .hero p { font-size: 1.1rem; color: #555; max-width: 560px; margin: 0 auto 40px; line-height: 1.65; }
            .hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
            .btn-primary {
                background: #ff8c00; color: #fff; font-weight: 800; font-size: 1rem;
                padding: 14px 34px; border-radius: 10px; text-decoration: none;
                transition: background 0.2s, transform 0.1s; border: none; cursor: pointer;
                box-shadow: 0 4px 16px rgba(255,140,0,0.3);
            }
            .btn-primary:hover { background: #e67e00; transform: translateY(-1px); }
            .btn-secondary {
                background: #fff; color: #333; font-weight: 700; font-size: 1rem;
                padding: 14px 34px; border-radius: 10px; text-decoration: none;
                border: 1.5px solid #e0e0e0; transition: border-color 0.2s, background 0.2s;
            }
            .btn-secondary:hover { border-color: #ccc; background: #fafafa; }

            /* ——— STATS BAND ——— */
            .stats-band { background: #004aad; padding: 28px 2rem; }
            .stats-inner { max-width: 960px; margin: 0 auto; display: flex; justify-content: space-around; gap: 24px; flex-wrap: wrap; }
            .stat-item { text-align: center; color: #fff; }
            .stat-item .num { font-size: 2rem; font-weight: 900; letter-spacing: -1px; }
            .stat-item .lbl { font-size: 0.78rem; font-weight: 600; opacity: 0.75; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px; }

            /* ——— FEATURES ——— */
            .features { padding: 80px 2rem; background: #f5f5f5; }
            .section-label { text-align: center; font-size: 0.75rem; font-weight: 800; color: #004aad; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px; }
            .section-title { text-align: center; font-size: 2rem; font-weight: 900; color: #1a1a1a; letter-spacing: -0.5px; margin-bottom: 60px; }
            .features-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
            .feature-card { background: #fff; border: 1px solid #e8e8e8; border-radius: 16px; padding: 32px 28px; transition: box-shadow 0.2s, transform 0.2s; }
            .feature-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.08); transform: translateY(-2px); }
            .feature-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; }
            .feature-icon.blue { background: #e8f0fe; }
            .feature-icon.green { background: #dcfce7; }
            .feature-icon.orange { background: #fff3e0; }
            .feature-card h3 { font-size: 1.05rem; font-weight: 800; color: #1a1a1a; margin-bottom: 10px; }
            .feature-card p { font-size: 0.88rem; color: #666; line-height: 1.65; }

            /* ——— HOW IT WORKS ——— */
            .how-it-works { padding: 80px 2rem; background: #fff; }
            .steps-grid { max-width: 960px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 40px; }
            .step { text-align: center; }
            .step-number { width: 56px; height: 56px; background: #004aad; color: #fff; border-radius: 50%; font-size: 1.3rem; font-weight: 900; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
            .step h3 { font-size: 1rem; font-weight: 800; color: #1a1a1a; margin-bottom: 10px; }
            .step p { font-size: 0.87rem; color: #666; line-height: 1.65; }

            /* ——— CTA BAND ——— */
            .cta-band { background: linear-gradient(135deg, #004aad 0%, #0062e0 100%); padding: 80px 2rem; text-align: center; color: #fff; }
            .cta-band h2 { font-size: 2rem; font-weight: 900; margin-bottom: 16px; letter-spacing: -0.5px; }
            .cta-band p { font-size: 1rem; opacity: 0.85; margin-bottom: 36px; }

            /* ——— FOOTER ——— */
            .site-footer { background: #1a1a1a; color: #fff; padding: 56px 2rem 28px; }
            .footer-top { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 48px; padding-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.08); }
            .footer-logo { font-size: 1.4rem; font-weight: 900; letter-spacing: -0.5px; margin-bottom: 12px; }
            .footer-logo span { color: #16a34a; }
            .footer-desc { font-size: 0.85rem; color: rgba(255,255,255,0.5); line-height: 1.6; }
            .footer-col h4 { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 16px; color: rgba(255,255,255,0.5); }
            .footer-col ul { list-style: none; }
            .footer-col ul li { margin-bottom: 10px; }
            .footer-col ul li a { color: rgba(255,255,255,0.7); text-decoration: none; font-size: 0.88rem; transition: color 0.15s; }
            .footer-col ul li a:hover { color: #fff; }
            .footer-bottom { max-width: 1100px; margin: 24px auto 0; display: flex; align-items: center; justify-content: space-between; font-size: 0.78rem; color: rgba(255,255,255,0.35); }
            .footer-bottom a { color: rgba(255,255,255,0.4); text-decoration: none; }
            .footer-bottom a:hover { color: rgba(255,255,255,0.7); }
        </style>
    </head>
    <body>
        <!-- Top Banner -->
        <div class="top-banner">
            <p>📦 Devenez Point Relais partenaire Karnou — Rejoignez le réseau dès aujourd'hui !</p>
        </div>

        <!-- Header -->
        <header class="site-header">
            <div class="header-inner">
                <a href="/" class="logo-text">
                    KARNOU<span>.</span>
                    <span class="logo-badge">Agence</span>
                </a>
                <div class="header-spacer"></div>
                <nav class="header-nav">
                    <a href="#how-it-works">Comment ça marche</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-outline">Mon espace</a>
                        @else
                            <a href="{{ route('login') }}">Connexion</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-cta">Devenir Point Relais</a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>

        <!-- Hero -->
        <section class="hero">
            <div class="hero-content">
                <div class="hero-eyebrow">
                    <span></span> Solution officielle pour les Points Relais Karnou
                </div>
                <h1>
                    Gérez vos colis, <em>Simplifiez</em><br>
                    <strong>votre Point Relais.</strong>
                </h1>
                <p>
                    Rejoignez le réseau officiel des agences et points relais partenaires de Karnou. Réceptionnez, stockez et remettez les colis en toute simplicité.
                </p>
                <div class="hero-actions">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary">Accéder à mon tableau de bord →</a>
                    @else
                        <a href="{{ route('register') }}" class="btn-primary">Devenir Point Relais →</a>
                        <a href="#how-it-works" class="btn-secondary">Comment ça marche ?</a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Stats Band -->
        <div class="stats-band">
            <div class="stats-inner">
                <div class="stat-item">
                    <div class="num">500+</div>
                    <div class="lbl">Agences Actives</div>
                </div>
                <div class="stat-item">
                    <div class="num">1M+</div>
                    <div class="lbl">Colis traités</div>
                </div>
                <div class="stat-item">
                    <div class="num">99%</div>
                    <div class="lbl">Taux de remise</div>
                </div>
                <div class="stat-item">
                    <div class="num">72h</div>
                    <div class="lbl">Durée max de stockage</div>
                </div>
            </div>
        </div>

        <!-- Features -->
        <section class="features">
            <p class="section-label">Avantages Agence</p>
            <h2 class="section-title">Tout ce dont vous avez besoin</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon blue">
                        <svg width="24" height="24" fill="none" stroke="#004aad" viewBox="0 0 24 24"><path d="M7 16l-4-4m0 0l4-4m-4 4h18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </div>
                    <h3>Réception Simplifiée</h3>
                    <p>Scannez les arrivées des livreurs et mettez à jour instantanément le statut du colis. Zéro paperasse.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon green">
                        <svg width="24" height="24" fill="none" stroke="#16a34a" viewBox="0 0 24 24"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </div>
                    <h3>Gestion de Stock</h3>
                    <p>Vue en temps réel de tous les colis présents dans votre établissement. Suivi précis et sans erreur.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon orange">
                        <svg width="24" height="24" fill="none" stroke="#ff8c00" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </div>
                    <h3>Remise Sécurisée</h3>
                    <p>Vérifiez le code de retrait du client et confirmez la remise finale en toute sécurité. Traçabilité complète.</p>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section class="how-it-works" id="how-it-works">
            <p class="section-label">Processus</p>
            <h2 class="section-title">Comment ça marche ?</h2>
            <div class="steps-grid">
                <div class="step">
                    <div class="step-number">01</div>
                    <h3>Inscrivez votre agence</h3>
                    <p>Créez un compte partenaire, soumettez les informations de votre établissement et recevez votre validation sous 48h.</p>
                </div>
                <div class="step">
                    <div class="step-number">02</div>
                    <h3>Recevez les colis</h3>
                    <p>Scannez les colis déposés par nos livreurs. Le système met à jour le statut automatiquement et notifie le client.</p>
                </div>
                <div class="step">
                    <div class="step-number">03</div>
                    <h3>Remettez et encaissez</h3>
                    <p>Le client se présente avec son code, vous confirmez la remise et recevez votre commission directement sur votre compte.</p>
                </div>
            </div>
        </section>

        <!-- CTA Band -->
        <div class="cta-band">
            <h2>Prêt à rejoindre le réseau Karnou ?</h2>
            <p>Inscrivez votre agence en 5 minutes et commencez à recevoir des colis dès aujourd'hui.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary">Accéder à mon espace →</a>
            @else
                <a href="{{ route('register') }}" class="btn-primary">Devenir Point Relais →</a>
            @endauth
        </div>

        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-top">
                <div>
                    <div class="footer-logo">KARNOU<span>.</span>AGENCE</div>
                    <p class="footer-desc">La solution officielle pour le réseau des points relais et agences partenaires Karnou.</p>
                </div>
                <div class="footer-col">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="/">Accueil</a></li>
                        <li><a href="#how-it-works">Comment ça marche</a></li>
                        <li><a href="{{ route('register') }}">S'inscrire</a></li>
                        <li><a href="{{ route('login') }}">Se connecter</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Contact</h4>
                    <ul>
                        <li><a href="#">agence@karnou.com</a></li>
                        <li><a href="#">+221 XX XXX XX XX</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} Karnou Group. Tous droits réservés.</span>
                <span>Powered by <a href="#">Karnou Marketplace</a></span>
            </div>
        </footer>

    </body>
</html>
