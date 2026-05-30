<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#FF6B00">
        <title>Karnou Agence - Réseau de Points Relais</title>
        <!-- Fonts — same as Karnou Marketplace -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                background-color: #f9fafb;
                color: #1a1a1a;
                overflow-x: hidden;
            }

            /* ——— TOP BANNER ——— */
            .top-banner {
                background-color: #FF6B00;
                height: 38px; width: 100%;
                display: flex; align-items: center; justify-content: center;
                position: relative; z-index: 1001;
            }
            .top-banner p { color: #fff; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; }

            /* ——— HEADER ——— */
            .site-header {
                background-color: rgba(255, 255, 255, 0);
                backdrop-filter: blur(0px);
                -webkit-backdrop-filter: blur(0px);
                border-top: 3px solid #FF6B00;
                position: fixed;
                top: 0;
                width: 100%;
                z-index: 1000;
                transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .site-header.scrolled {
                background-color: rgba(255, 255, 255, 0.97);
                backdrop-filter: blur(20px) saturate(180%);
                -webkit-backdrop-filter: blur(20px) saturate(180%);
                box-shadow: 0 1px 0 rgba(241, 245, 249, 0.9), 0 8px 32px rgba(0,0,0,0.05);
            }
            .header-inner {
                max-width: 1400px;
                margin: 0 auto;
                padding: 18px 2rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .header-nav { display: flex; align-items: center; gap: 2rem; }
            .nav-link {
                color: #475569;
                text-decoration: none;
                font-size: 0.9rem;
                font-weight: 550;
                transition: color 0.3s;
            }
            .nav-link:hover { color: #FF6B00; }
            .btn-cta {
                background: #FF6B00;
                color: #fff !important;
                border-radius: 8px;
                font-weight: 650;
                padding: 10px 24px;
                font-size: 0.875rem;
                text-decoration: none;
                transition: all 0.3s;
            }
            .btn-cta:hover { background: #e66000; transform: translateY(-1px); }
            .btn-outline {
                padding: 10px 20px;
                border-radius: 8px;
                font-size: 0.9rem;
                font-weight: 600;
                color: #334155 !important;
                text-decoration: none;
                transition: all 0.3s;
            }
            .btn-outline:hover { background: #f8fafc; }

            /* ——— HERO ——— */
            .hero {
                background: #f9fafb; padding: 180px 2rem 120px; text-align: center;
                position: relative; overflow: hidden;
            }
            .hero-content { position: relative; z-index: 2; max-width: 900px; margin: 0 auto; }
            .hero-eyebrow {
                display: inline-flex; align-items: center; gap: 8px;
                background: rgba(255, 107, 0, 0.08); color: #FF6B00; font-size: 0.7rem; font-weight: 800;
                padding: 6px 16px; border-radius: 4px; margin-bottom: 32px; letter-spacing: 1px;
                text-transform: uppercase;
            }
            .hero h1 {
                font-size: clamp(3rem, 7vw, 5.2rem); font-weight: 950; color: #1a1a1a;
                line-height: 0.95; margin-bottom: 28px; letter-spacing: -3px;
            }
            .hero h1 span.accent { color: #FF6B00; }
            .hero p { font-size: 1.15rem; color: #4b5563; max-width: 600px; margin: 0 auto 48px; line-height: 1.6; font-weight: 500; }
            .hero-actions { display: flex; gap: 16px; justify-content: center; }
            
            .btn-primary {
                background: #111827; color: #fff; font-weight: 800; font-size: 0.95rem;
                padding: 18px 40px; border-radius: 6px; text-decoration: none;
                border: 1px solid #FF6B00; cursor: pointer; transition: all 0.2s;
            }
            .btn-primary:hover { background: #e66000; }
            .btn-secondary {
                background: #fff; color: #1a1a1a; font-weight: 800; font-size: 0.95rem;
                padding: 18px 40px; border-radius: 6px; text-decoration: none;
                border: 1px solid rgba(0, 0, 0, 0.1); transition: all 0.2s;
            }
            .btn-secondary:hover { background: #f9fafb; border-color: rgba(0, 0, 0, 0.2); }

            /* ——— STATS BAND ——— */
            .stats-band { background: #f9fafb; padding: 40px 2rem; border-top: 1px solid #f3f4f6; border-bottom: 1px solid #f3f4f6; }
            .stats-inner { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(4, 1fr); gap: 40px; }
            .stat-item { text-align: left; }
            .stat-item .num { font-size: 1.8rem; font-weight: 950; color: #1a1a1a; letter-spacing: -1px; margin-bottom: 4px; }
            .stat-item .lbl { font-size: 0.65rem; font-weight: 800; color: #6b7280; text-transform: uppercase; letter-spacing: 1.5px; }

            /* ——— FEATURES ——— */
            .features { padding: 120px 2rem; background: #111827; color: #fff; }
            .section-label { font-size: 0.7rem; font-weight: 800; color: rgba(255, 255, 255, 0.6); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 16px; text-align: center; }
            .section-title { font-size: 2.8rem; font-weight: 950; color: #fff; letter-spacing: -1.5px; margin-bottom: 80px; text-align: center; }
            .features-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(3, 1fr); gap: 32px; }
            .feature-card { 
                background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); 
                border-radius: 4px; padding: 48px 40px; 
            }
            .feature-icon { 
                width: 48px; height: 48px; background: rgba(255, 255, 255, 0.1); 
                border-radius: 4px; display: flex; align-items: center; justify-content: center; margin-bottom: 32px; 
            }
            .feature-card h3 { font-size: 1.2rem; font-weight: 800; color: #fff; margin-bottom: 16px; letter-spacing: -0.5px; }
            .feature-card p { font-size: 0.95rem; color: rgba(255, 255, 255, 0.6); line-height: 1.7; }

            /* ——— PROCESS ——— */
            .process { padding: 120px 2rem; background: #fff; }
            .process-grid { max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(3, 1fr); gap: 60px; }
            .step { position: relative; }
            .step-number { font-size: 4rem; font-weight: 950; color: #f3f4f6; line-height: 1; margin-bottom: 16px; }
            .step h3 { font-size: 1.25rem; font-weight: 900; color: #1a1a1a; margin-bottom: 12px; letter-spacing: -0.5px; }
            .step p { font-size: 1rem; color: #4b5563; line-height: 1.7; }

            /* ——— FAQ ——— */
            .faq { padding: 120px 2rem; background: #f9fafb; border-top: 1px solid #f3f4f6; }
            .faq-container { max-width: 800px; margin: 0 auto; }
            .faq-item { background: #fff; border: 1px solid #f3f4f6; margin-bottom: 12px; border-radius: 4px; overflow: hidden; }
            .faq-question { 
                padding: 24px 32px; font-weight: 800; font-size: 1rem; cursor: pointer; 
                display: flex; justify-content: space-between; align-items: center;
            }
            .faq-answer { padding: 0 32px 24px; color: #4b5563; font-size: 0.95rem; line-height: 1.7; display: none; }
            .faq-item.active .faq-answer { display: block; }
            .faq-item.active .faq-question { color: #FF6B00; }

            /* ——— FOOTER ——— */
            .site-footer { background: #ffffff; color: #1a1a1a; padding: 100px 2rem 50px; border-top: 1px solid #f3f4f6; }
            .footer-inner { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 80px; }
            .footer-logo { font-size: 1.6rem; font-weight: 950; letter-spacing: -1px; margin-bottom: 24px; }
            .footer-desc { font-size: 0.95rem; color: #6b7280; line-height: 1.7; max-width: 320px; }
            .footer-col h4 { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 24px; color: #1a1a1a; }
            .footer-col ul { list-style: none; }
            .footer-col ul li { margin-bottom: 14px; }
            .footer-col ul li a { color: #6b7280; text-decoration: none; font-size: 0.95rem; transition: color 0.2s; font-weight: 500; }
            .footer-col ul li a:hover { color: #FF6B00; }
            .footer-bottom { 
                max-width: 1200px; margin: 80px auto 0; padding-top: 40px; 
                border-top: 1px solid #f3f4f6; display: flex; justify-content: space-between; 
                font-size: 0.85rem; color: #9ca3af; font-weight: 500;
            }

            .form-input-box {
                width: 100%;
                padding: 1rem 0.6rem 0.25rem 0.6rem;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 1rem;
                outline: none;
                transition: border-color 0.2s;
                background-color: #ffffff;
            }
            .form-input-box:focus { border-color: #ff4e00; outline: none; box-shadow: none !important; border-radius: 4px; }
            .input-container { position: relative; margin-bottom: 1.25rem; }
            .floating-label {
                position: absolute;
                left: 0.6rem;
                top: 50%;
                transform: translateY(-50%);
                color: #999;
                font-size: 1rem;
                transition: all 0.2s ease-out;
                pointer-events: none;
                z-index: 10;
            }
            .form-input-box:focus + .floating-label,
            .form-input-box:not(:placeholder-shown) + .floating-label {
                top: 0.35rem;
                transform: translateY(0);
                font-size: 0.75rem;
                color: #888;
            }
            .toggle-password {
                position: absolute;
                right: 1rem;
                top: 50%;
                transform: translateY(-50%);
                cursor: pointer;
                color: #666;
            }
            .btn-black {
                width: 100%;
                background: #004aad;
                color: white;
                border: none;
                padding: 0.5rem 2rem;
                border-radius: 4px;
                font-size: 1rem;
                font-weight: bold;
                cursor: pointer;
                margin-top: 1rem;
                transition: background 0.2s;
            }
            .btn-black:hover { background: #003a8a; }
            .auth-card {
                background: white;
                padding: 1.5rem 2.5rem 2.5rem 2.5rem;
                border: 1px solid #f0f0f0;
                border-radius: 4px;
                box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.02);
                max-width: 450px;
                margin: 0 auto;
                text-align: left;
            }
            .auth-title {
                font-size: 1.25rem;
                font-weight: bold;
                margin-bottom: 1.5rem;
                color: #1a1a1a;
            }
            .forgot-password {
                display: block;
                font-size: 0.9rem;
                color: #0066cc;
                text-decoration: none;
                margin-top: -0.5rem;
                margin-bottom: 1rem;
            }
            @media (max-width: 1024px) {
                .features-grid, .process-grid, .footer-inner { grid-template-columns: 1fr; gap: 40px; }
                .stats-inner { grid-template-columns: repeat(2, 1fr); }
            }
        </style>
    </head>
    <body>
        <!-- Header Removed -->

        <!-- Hero / Access Point -->
        <section class="hero" style="min-height: 80vh; display: flex; align-items: center; justify-content: center;">
            <div class="hero-content">
                @auth
                    <div class="hero-eyebrow">Terminal Opérationnel Actif</div>
                    <h1>
                        Bienvenue,<br>
                        <span class="accent">{{ Auth::user()->name }}</span>
                    </h1>
                    <p>Votre terminal de gestion est prêt pour les opérations de flux.</p>
                    <div class="hero-actions">
                        <a href="{{ route('dashboard') }}" class="btn-primary">Entrer dans le Dashboard →</a>
                    </div>
                @else
                    <!-- Professional Enterprise Login Form matching Marketplace -->
                    <div class="auth-card">
                        <h2 class="auth-title">Accès Agence</h2>
                        
                        @if(session('error'))
                            <div style="background-color: #fff5f5; color: #bf0000; padding: 1rem; margin-bottom: 1.5rem; border-radius: 4px; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="login-form">
                            @csrf
                            <div class="input-container">
                                <input type="email" id="email" name="email" placeholder=" " class="form-input-box" required autofocus>
                                <label class="floating-label">E-mail (Identifiant Agence)</label>
                            </div>
                            
                            <div class="input-container">
                                <input type="password" id="password" name="password" placeholder=" " class="form-input-box" required>
                                <label class="floating-label">Mot de passe secret</label>
                                <span class="toggle-password" onclick="document.getElementById('password').type = document.getElementById('password').type === 'password' ? 'text' : 'password'">
                                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                            
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-password">J'ai oublié mon mot de passe</a>
                            @endif
                            
                            <div style="margin-bottom: 1rem; display: flex; align-items: center; gap: 8px;">
                                <input type="checkbox" name="remember" id="remember" style="cursor: pointer;">
                                <label for="remember" style="font-size: 0.85rem; color: #4b5563; cursor: pointer;">Mémoriser ce terminal</label>
                            </div>
                            
                            <button type="submit" class="btn-black">
                                Me connecter
                            </button>
                        </form>
                    </div>
                @endauth
            </div>
        </section>

        <!-- Footer Removed -->

        <script>
            // Ghost-to-Glass Header
            window.addEventListener('scroll', function() {
                const header = document.getElementById('header');
                if (window.scrollY > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });
        </script>
    </body>
</html>
