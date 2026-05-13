<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#004aad">
        <title>Karnou Logistique - Livraison Marketplace</title>
        <link rel="manifest" href="/manifest.json">
        <!-- Fonts — same as Karnou Marketplace -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                background-color: #ffffff;
                color: #0f172a;
                overflow-x: hidden;
                line-height: 1.5;
                -webkit-font-smoothing: antialiased;
                font-feature-settings: 'cv11', 'ss01';
            }

            /* ——— TOP BANNER ——— */
            .top-banner {
                background-color: #004aad;
                height: 32px;
                width: 100%;
                position: relative;
                z-index: 1001;
            }
            .top-banner p {
                color: #fff;
                font-size: 0.78rem;
                font-weight: 600;
                letter-spacing: 0.3px;
            }

            /* ——— HEADER ——— */
            .site-header {
                background-color: rgba(255, 255, 255, 0);
                backdrop-filter: blur(0px);
                -webkit-backdrop-filter: blur(0px);
                border-top: 3px solid #004aad;
                box-shadow: 0 0 0 rgba(0,0,0,0), inset 0 -1px 0 rgba(241, 245, 249, 0);
                position: sticky;
                top: 0;
                z-index: 1000;
                transition:
                    background-color 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                    backdrop-filter 0.4s cubic-bezier(0.16, 1, 0.3, 1),
                    box-shadow 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .site-header.scrolled {
                background-color: rgba(255, 255, 255, 0.97);
                backdrop-filter: blur(20px) saturate(180%);
                -webkit-backdrop-filter: blur(20px) saturate(180%);
                box-shadow:
                    0 1px 0 rgba(241, 245, 249, 0.9),
                    0 8px 32px rgba(0,0,0,0.05),
                    0 0 0 1px rgba(0, 74, 173, 0.04);
            }
            .header-inner {
                max-width: 1400px;
                margin: 0 auto;
                padding: 18px 5rem;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .header-nav-center {
                display: flex;
                align-items: center;
                gap: 2.5rem;
            }
            /* Staggered entrance animation */
            @keyframes navFadeIn {
                from { opacity: 0; transform: translateY(-6px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            .header-nav-center .nav-link {
                animation: navFadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
            }
            .header-nav-center .nav-link:nth-child(1) { animation-delay: 0.05s; }
            .header-nav-center .nav-link:nth-child(2) { animation-delay: 0.10s; }
            .header-nav-center .nav-link:nth-child(3) { animation-delay: 0.15s; }
            .header-nav-center .nav-link:nth-child(4) { animation-delay: 0.20s; }
            .nav-link {
                color: #475569;
                text-decoration: none;
                font-size: 0.9rem;
                font-weight: 550;
                letter-spacing: -0.02em;
                transition: color 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                position: relative;
                padding: 4px 0;
            }
            .nav-link::after {
                content: "";
                position: absolute;
                bottom: -1px;
                left: 50%;
                transform: translateX(-50%);
                width: 0;
                height: 2px;
                background: linear-gradient(90deg, #004aad, #0066cc);
                transition: width 0.45s cubic-bezier(0.8, 0, 0.2, 1);
                border-radius: 2px;
            }
            .nav-link:hover { color: #004aad; }
            .nav-link:hover::after { width: 100%; }
            .sub-header-inner {
                max-width: 1400px;
                margin: 0 auto;
                padding: 8px 2rem;
                display: flex;
                align-items: center;
                gap: 1.5rem;
            }
            .cat-trigger {
                display: flex;
                align-items: center;
                gap: 10px;
                font-weight: 700;
                color: #0f172a;
                font-size: 0.85rem;
                cursor: pointer;
                padding-right: 20px;
                border-right: 1px solid #eee;
            }
            .cat-pills {
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .cat-pill {
                padding: 6px 12px;
                border: none;
                border-radius: 8px;
                font-size: 0.75rem;
                font-weight: 700;
                color: #64748b;
                text-decoration: none;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                transition: all 0.2s;
                position: relative;
            }
            .header-nav { display: flex; align-items: center; gap: 10px; }
            .header-nav .btn-cta {
                background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
                color: #fff !important;
                border: none;
                border-radius: 8px;
                font-weight: 650;
                padding: 10px 24px;
                text-transform: none;
                letter-spacing: -0.015em;
                font-size: 0.875rem;
                transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
                margin-left: 12px;
            }
            .header-nav .btn-cta:hover { 
                background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%); 
                transform: translateY(-1px) scale(1.02);
                box-shadow: 0 10px 20px rgba(234, 88, 12, 0.12);
            }
            .header-nav .btn-outline {
                padding: 10px 20px;
                border-radius: 8px;
                font-size: 0.9rem;
                font-weight: 600;
                color: #334155 !important;
                text-decoration: none;
                border: 1px solid transparent;
                background: transparent;
                transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .header-nav .btn-outline:hover { 
                background: #f8fafc; 
                color: #020617 !important;
            }

            /* ——— RICH HERO ——— */
            .hero-rich {
                background: #ffffff;
                background-image: radial-gradient(circle at 75% 50%, rgba(0, 74, 173, 0.03) 0%, transparent 60%);
                padding: 20px 0 32px 0;
                overflow: hidden;
                position: relative;
            }
            .hero-rich::before {
                content: "";
                position: absolute;
                inset: 0;
                background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
                opacity: 0.012;
                pointer-events: none;
                z-index: 1;
            }
            .hero-rich-inner {
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 2rem;
                display: flex;
                align-items: center;
                gap: 120px;
                position: relative;
                z-index: 2;
            }
            .hero-content {
                flex: 1.4;
                text-align: left;
            }
            .hero-title {
                font-family: 'Inter', sans-serif;
                font-size: 4rem;
                font-weight: 900;
                color: #020617;
                line-height: 1.05;
                margin-bottom: 24px;
                letter-spacing: -0.055em;
                font-feature-settings: 'cv11', 'ss01', 'ss03';
            }
            .title-accent { 
                color: #004aad;
            }
            .hero-desc {
                font-size: 1.2rem;
                color: #475569;
                line-height: 1.6;
                margin-bottom: 40px;
                max-width: 580px;
                font-weight: 400;
                letter-spacing: -0.015em;
            }
            .hero-store-buttons {
                display: flex;
                gap: 16px;
                align-items: center;
                margin-top: 24px;
            }
            .store-btn-premium {
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
                position: relative;
                overflow: hidden;
                border-radius: 14px;
            }
            .store-btn-premium img {
                height: 44px;
                width: auto;
                display: block;
                border-radius: 8px; /* Slight rounding for the SVG itself if needed */
            }
            .store-btn-premium:hover {
                transform: translateY(-2px) scale(1.01);
                border-color: rgba(255,255,255,0.2);
                background: linear-gradient(135deg, #2a2a2a 0%, #050505 100%);
                box-shadow: 
                    0 4px 6px rgba(0,0,0,0.1),
                    0 10px 25px rgba(0,0,0,0.2);
            }
            .store-icon svg {
                width: 28px;
                height: 28px;
                fill: #fff;
                filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
            }
            .store-text {
                display: flex;
                flex-direction: column;
                line-height: 1.1;
                text-align: left;
            }
            .store-text .small-text {
                font-size: 0.65rem;
                font-weight: 600;
                color: rgba(255,255,255,0.7);
                letter-spacing: 0.1em;
                text-transform: uppercase;
                margin-bottom: 2px;
            }
            .store-text .large-text {
                font-size: 1.25rem;
                font-weight: 800;
                letter-spacing: -0.015em;
            }

            .hero-mockup {
                flex: 1;
                display: flex;
                justify-content: flex-end;
                position: relative;
                transform: translateX(-40px);
            }
            .hero-mockup::after {
                content: "";
                position: absolute;
                bottom: -40px;
                left: 20%;
                right: -10%;
                height: 80px;
                background: radial-gradient(ellipse at center, rgba(0,0,0,0.06) 0%, transparent 70%);
                filter: blur(20px);
                z-index: 0;
            }
            .hero-mockup img {
                max-width: 520px;
                height: auto;
                position: relative;
                z-index: 2;
                filter: drop-shadow(0 30px 60px rgba(0,0,0,0.12));
            }

            /* ——— FLOATING BADGES ——— */
            .hero-badge {
                position: absolute;
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(24px) saturate(180%);
                -webkit-backdrop-filter: blur(24px) saturate(180%);
                border: 0.5px solid rgba(255, 255, 255, 0.4);
                border-radius: 24px;
                padding: 16px 28px;
                display: flex;
                align-items: center;
                gap: 20px;
                min-width: 240px;
                color: #0f172a;
                box-shadow: 
                    0 1px 2px rgba(0,0,0,0.02),
                    0 12px 24px rgba(0,0,0,0.03),
                    0 30px 60px rgba(0,0,0,0.05);
                z-index: 10;
                transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
                pointer-events: auto;
            }
            .hero-badge:hover { 
                transform: translateY(-8px) scale(1.02); 
                box-shadow: 
                    0 1px 3px rgba(0,0,0,0.05),
                    0 20px 40px rgba(0,0,0,0.08),
                    0 40px 80px rgba(0,0,0,0.1);
            }
            
            .badge-icon {
                width: 44px;
                height: 44px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .badge-icon svg { width: 22px; height: 22px; }
            
            /* Badge Themes (Intelligent Brand Integration) */
            .badge-blue { background: rgba(0, 74, 173, 0.15); }
            .badge-blue svg { fill: #004aad; }
            
            .badge-orange { background: rgba(255, 140, 0, 0.15); }
            .badge-orange svg { fill: #ff8c00; }
            
            .badge-blue-glow { background: rgba(0, 74, 173, 0.15); border: 1px solid rgba(0, 74, 173, 0.3); }
            .badge-blue-glow svg { fill: #004aad; }

            .badge-content { display: flex; flex-direction: column; text-align: left; }
            .badge-label { font-size: 0.7rem; opacity: 0.6; font-weight: 500; text-transform: none; margin-bottom: 2px; }
            .badge-value { font-size: 1.05rem; font-weight: 800; letter-spacing: -0.2px; }

            /* Positioning */
            .b-delivery { top: 10%; right: 340px; }
            .b-tracking { top: 45%; right: -60px; }
            .b-rating { bottom: 15%; right: 320px; }

            @media (max-width: 1400px) {
                .b-delivery { right: 300px; }
                .b-rating { right: 280px; }
            }
            @media (max-width: 1200px) {
                .hero-badge { transform: scale(0.9); }
                .b-delivery { right: 320px; top: 5%; }
                .b-tracking { right: -20px; }
                .b-rating { right: 300px; bottom: 10%; }
            }
            @media (max-width: 1024px) {
                .hero-badge { display: none; }
            }
            @media (max-width: 1100px) {
                .hero-rich-inner { flex-direction: column; text-align: center; gap: 40px; padding: 40px 1.5rem; }
                .hero-content { text-align: center; }
                .hero-desc { margin-left: auto; margin-right: auto; }
                .hero-store-buttons { justify-content: center; }
                .hero-mockup { justify-content: center; }
                .hero-title { font-size: 2.5rem; }
            }

            /* ——— FEATURES ——— */
            .features {
                padding: 60px 2rem;
                background: #004aad;
                position: relative;
                overflow: hidden;
            }
            .features::before {
                content: "";
                position: absolute;
                top: -150px;
                left: 50%;
                transform: translateX(-50%);
                width: 1000px;
                height: 500px;
                background: radial-gradient(ellipse at center, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
                pointer-events: none;
                z-index: 1;
            }
            .section-label {
                text-align: center;
                font-size: 0.7rem;
                font-weight: 700;
                color: rgba(255, 255, 255, 0.8);
                text-transform: uppercase;
                letter-spacing: 0.15em;
                margin-bottom: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }
            .section-label::before, .section-label::after {
                content: "";
                display: block;
                width: 28px;
                height: 1px;
                background: rgba(255, 255, 255, 0.3);
            }
            .section-title {
                font-family: 'Inter', sans-serif;
                font-size: 2rem;
                font-weight: 900;
                color: #ffffff;
                margin-bottom: 40px;
                letter-spacing: -0.04em;
                font-feature-settings: 'cv11', 'ss01';
                text-align: center;
            }
            .features-grid {
                max-width: 1100px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 24px;
            }
            .feature-card {
                background: rgba(255, 255, 255, 0.08);
                backdrop-filter: blur(18px);
                -webkit-backdrop-filter: blur(18px);
                border: 1px solid rgba(255, 255, 255, 0.12);
                border-radius: 24px;
                padding: 32px 30px;
                position: relative;
                overflow: hidden;
                box-shadow: none;
                z-index: 2;
                transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .feature-card:hover {
                background: rgba(255, 255, 255, 0.12);
                border-color: rgba(255, 255, 255, 0.25);
            }
            .feature-card::after {
                content: "";
                position: absolute;
                top: 0;
                left: 20px;
                right: 20px;
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
                z-index: 3;
            }
            .feature-icon {
                width: 48px;
                height: 48px;
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 20px;
                position: relative;
                z-index: 4;
            }
            .feature-icon.blue, .feature-icon.orange, .feature-icon.green {
                background: rgba(255, 255, 255, 0.1);
                color: #ffffff;
                box-shadow: none;
            }
            .feature-card h3 {
                font-size: 1.1rem;
                font-weight: 850;
                color: #ffffff;
                margin-bottom: 10px;
                letter-spacing: -0.025em;
            }
            .feature-card p {
                font-size: 0.85rem;
                color: rgba(255, 255, 255, 0.8);
                line-height: 1.6;
            }
            /* Stats strip */
            .features-stats {
                display: flex;
                justify-content: center;
                gap: 60px;
                margin-top: 64px;
                padding-top: 48px;
                border-top: 1px solid rgba(255,255,255,0.06);
            }
            .stat-item { text-align: center; }
            .stat-number {
                font-size: 2.2rem;
                font-weight: 900;
                color: #ffffff;
                letter-spacing: -0.04em;
                line-height: 1;
                font-feature-settings: 'cv11';
            }
            .stat-label {
                font-size: 0.8rem;
                color: rgba(148, 163, 184, 0.7);
                margin-top: 6px;
                letter-spacing: 0.02em;
            }

            /* ——— HOW IT WORKS ——— */
            /* ——— HOW IT WORKS ——— */
            .how-it-works {
                padding: 96px 2rem;
                background: #f8fafc;
                position: relative;
            }
            .steps-grid {
                max-width: 1000px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 0;
                position: relative;
            }
            /* Connector line between steps */
            .steps-grid::before {
                content: "";
                position: absolute;
                top: 48px;
                left: calc(16.67% + 32px);
                right: calc(16.67% + 32px);
                height: 2px;
                background: linear-gradient(90deg, transparent 0%, rgba(0, 74, 173, 0.1) 20%, rgba(0, 74, 173, 0.1) 80%, transparent 100%);
                z-index: 1;
            }
            .step {
                text-align: center;
                padding: 48px 32px;
                position: relative;
                background: #ffffff;
                border: 1px solid #f1f5f9;
                border-radius: 32px;
                box-shadow: none;
                z-index: 2;
                margin: 0 12px;
            }
            .step:hover {
                background: #fbfcfe;
            }
            .step-number-bg {
                position: absolute;
                top: 20px;
                right: 20px;
                font-size: 6rem;
                font-weight: 900;
                color: rgba(0, 74, 173, 0.03);
                line-height: 1;
                pointer-events: none;
                user-select: none;
                font-feature-settings: 'cv11';
                z-index: 0;
            }
            .step-badge {
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 28px;
                position: relative;
                z-index: 3;
            }
            .step-number {
                width: 56px;
                height: 56px;
                background: #ffffff;
                border: 1.5px solid rgba(0, 74, 173, 0.15);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.8rem;
                font-weight: 800;
                color: #004aad;
                letter-spacing: 0.02em;
                box-shadow: 0 4px 16px rgba(0,74,173,0.08);
            }
            .step-icon {
                width: 56px;
                height: 56px;
                background: linear-gradient(135deg, rgba(0,74,173,0.1), rgba(0,74,173,0.04));
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #004aad;
                margin: 0 auto 20px;
            }
            .step h3 {
                font-size: 1.15rem;
                font-weight: 800;
                color: #0f172a;
                margin-bottom: 14px;
                letter-spacing: -0.025em;
                position: relative;
                z-index: 3;
            }
            .step p {
                font-size: 0.9rem;
                color: #475569;
                line-height: 1.7;
                position: relative;
                z-index: 3;
            }
            .step-counter {
                font-size: 0.7rem;
                font-weight: 700;
                color: #004aad;
                letter-spacing: 0.1em;
                text-transform: uppercase;
                margin-bottom: 16px;
                opacity: 0.6;
            }

            /* ——— FOOTER ——— */
            .site-footer {
                background: #1a1a1a;
                color: #fff;
                padding: 56px 2rem 28px;
            }
            .footer-top {
                max-width: 1100px; margin: 0 auto;
                display: grid; grid-template-columns: 2fr 1fr 1fr;
                gap: 48px; padding-bottom: 40px;
                border-bottom: 1px solid rgba(255,255,255,0.08);
            }
            .footer-logo { font-size: 1.4rem; font-weight: 900; letter-spacing: -0.5px; margin-bottom: 12px; }
            .footer-logo span { color: #ff8c00; }
            .footer-desc { font-size: 0.85rem; color: rgba(255,255,255,0.5); line-height: 1.6; }
            .footer-col h4 { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 16px; color: rgba(255,255,255,0.5); }
            .footer-col ul { list-style: none; }
            .footer-col ul li { margin-bottom: 10px; }
            /* ——— FAQ ——— */
            .faq {
                padding: 96px 2rem;
                background: #ffffff;
            }
            .faq-container {
                max-width: 800px;
                margin: 0 auto;
            }
            .faq-item {
                background: #ffffff;
                border-radius: 20px;
                margin-bottom: 16px;
                border: 1px solid #f1f5f9;
                overflow: hidden;
            }
            .faq-question {
                width: 100%;
                padding: 24px 32px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                cursor: pointer;
                background: none;
                border: none;
                text-align: left;
                font-size: 1.05rem;
                font-weight: 700;
                color: #0f172a;
            }
            .faq-answer {
                padding: 0 32px 24px;
                color: #64748b;
                font-size: 0.95rem;
                line-height: 1.6;
                display: none;
            }
            .faq-item.active .faq-answer { display: block; }
            .faq-item.active .faq-question { padding-bottom: 16px; }

            /* ——— CONTACT ——— */
            .contact {
                padding: 100px 2rem;
                background: #ffffff;
            }
            .contact-grid {
                max-width: 1200px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: 1fr 1.2fr;
                gap: 80px;
                align-items: start;
            }
            .contact-info h2 { font-size: 2.5rem; font-weight: 900; margin-bottom: 24px; letter-spacing: -0.04em; }
            .contact-methods { margin-top: 48px; display: grid; gap: 32px; }
            .method-card { display: flex; align-items: flex-start; gap: 20px; }
            .method-icon {
                width: 48px; height: 48px; background: rgba(0,74,173,0.08);
                border-radius: 12px; display: flex; align-items: center; justify-content: center;
                color: #004aad; flex-shrink: 0;
            }
            .contact-form {
                background: #ffffff;
                padding: 48px;
                border-radius: 32px;
                border: 1px solid #f1f5f9;
                box-shadow: none;
            }
            .form-group { margin-bottom: 24px; }
            .form-group label { display: block; font-size: 0.85rem; font-weight: 700; color: #0f172a; margin-bottom: 8px; }
            .form-control {
                width: 100%; padding: 14px 20px; border-radius: 12px;
                border: 1px solid #e2e8f0; background: #f8fafc;
                font-family: inherit; font-size: 0.95rem; color: #0f172a;
                transition: all 0.3s;
            }
            .form-control:focus { outline: none; border-color: #004aad; background: #fff; box-shadow: 0 0 0 4px rgba(0,74,173,0.06); }
            
            .btn-submit {
                width: 100%; background: #004aad; color: #fff; border: none;
                padding: 16px; border-radius: 12px; font-weight: 700; cursor: pointer;
                transition: all 0.3s;
            }
            .btn-submit:hover { background: #003780; transform: translateY(-1px); }

            .footer-bottom {
                max-width: 1400px; margin: 32px auto 0;
                display: flex; align-items: center; justify-content: space-between;
                font-size: 0.78rem; color: rgba(255,255,255,0.35);
            }
            .footer-bottom a { color: rgba(255,255,255,0.4); text-decoration: none; }
            .footer-bottom a:hover { color: rgba(255,255,255,0.7); }

            /* Animations Disabled */
        </style>
    </head>
    <body>
        <!-- Header -->
        <header class="site-header">
            <div class="header-inner">
                <a href="/" class="logo-text">
                    <img src="{{ asset('images/logo.png') }}" alt="KARNOU" style="height: 30px; width: auto;">
                </a>
                
                <div class="header-nav-center">
                    <a href="/" class="nav-link">Accueil</a>
                    <a href="#how-it-works" class="nav-link">Processus</a>
                    <a href="#faq" class="nav-link">FAQ</a>
                    <a href="#contact" class="nav-link">Contact</a>
                </div>

                <nav class="header-nav">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-outline">Mon espace</a>
                        @else
                            <a href="{{ route('login') }}" class="btn-outline">Connexion</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-cta">Devenir Livreur</a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </header>


        <!-- Rich Hero Section -->
        <section class="hero-rich">
            <div class="hero-rich-inner reveal">
                <div class="hero-content">
                    <h1 class="hero-title">
                        Devenez livreur ou <span class="title-accent">transporteur de colis</span>
                    </h1>
                    <p class="hero-desc">
                        Karnou Logistique vous permet de rejoindre le réseau officiel de livraison de la Marketplace Karnou. 
                        Choisissez vos missions, livrez à votre rythme et soyez payé directement via l'application.
                    </p>
                    <div class="hero-store-buttons">
                        <a href="#" class="store-btn-premium">
                            <img src="{{ asset('images/app-store-badge.svg') }}" alt="Download on the App Store">
                        </a>
                        <a href="#" class="store-btn-premium">
                            <img src="{{ asset('images/google-play-badge.svg') }}" alt="Get it on Google Play" style="height: 44px;">
                        </a>
                    </div>
                </div>
                <div class="hero-mockup">
                    <img src="{{ asset('images/hero-app-mockup.png') }}" alt="Karnou App Mockup">
                    
                    <!-- Badge 1: Livraison rapide -->
                    <div class="hero-badge b-delivery">
                        <div class="badge-icon badge-blue">
                            <svg viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div class="badge-content">
                            <span class="badge-label">Livraison rapide</span>
                            <span class="badge-value">30 min</span>
                        </div>
                    </div>

                    <!-- Badge 2: Suivi en direct -->
                    <div class="hero-badge b-tracking">
                        <div class="badge-icon badge-blue-glow">
                            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <div class="badge-content">
                            <span class="badge-label">Suivi en direct</span>
                            <span class="badge-value">En route</span>
                        </div>
                    </div>

                    <!-- Badge 3: Avis clients -->
                    <div class="hero-badge b-rating">
                        <div class="badge-icon badge-orange">
                            <svg viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        </div>
                        <div class="badge-content">
                            <span class="badge-label">Avis clients</span>
                            <span class="badge-value">4.7 / 5</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section class="features">
            <h2 class="section-title reveal">Tout ce dont vous avez besoin</h2>
            <div class="features-grid reveal-stagger">

                <div class="feature-card">
                    <div class="feature-icon blue">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h3>Liberté totale</h3>
                    <p>Travaillez quand vous voulez. Choisissez vos créneaux et vos missions en fonction de votre emploi du temps.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon orange">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
                    </div>
                    <h3>Revenus garantis</h3>
                    <p>Tarification transparente. Vous savez exactement combien vous gagnez pour chaque livraison effectuée.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon green">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                    </div>
                    <h3>Application sur mesure</h3>
                    <p>Installez l'application directement sur votre smartphone et gérez toutes vos missions, notifications et paiements en temps réel.</p>
                </div>
            </div>
        </section>

        <!-- How it works -->
        <section class="how-it-works" id="how-it-works">
            <h2 class="section-title reveal" style="color:#0f172a; margin-bottom: 80px;">Comment ça marche ?</h2>
            <div class="steps-grid reveal-stagger">
                <div class="step">
                    <div class="step-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <h3>Inscrivez-vous</h3>
                    <p>Créez votre compte livreur, validez votre profil avec un code OTP et commencez à recevoir des missions.</p>
                </div>
                <div class="step">
                    <div class="step-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/><path d="M16.5 9.4 7.55 4.24"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" y1="22" x2="12" y2="12"/><circle cx="18.5" cy="15.5" r="2.5"/><path d="M20.27 17.27 22 19"/></svg>
                    </div>
                    <h3>Acceptez des missions</h3>
                    <p>Consultez les colis disponibles sur votre tableau de bord et acceptez les missions correspondant à votre zone.</p>
                </div>
                <div class="step">
                    <div class="step-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
                    </div>
                    <h3>Livrez et gagnez</h3>
                    <p>Récupérez le colis, livrez-le au client ou au point relais, et recevez votre paiement directement sur votre compte.</p>
                </div>
            </div>
        </section>


        <!-- FAQ -->
        <section class="faq" id="faq">
            <h2 class="section-title reveal" style="color:#0f172a; margin-bottom: 60px;">Questions fréquentes</h2>
            <div class="faq-container reveal-stagger">
                <div class="faq-item">
                    <button class="faq-question">Comment suis-je payé ? <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg></button>
                    <div class="faq-answer">Les paiements sont effectués directement sur votre compte bancaire ou via mobile money. Selon votre niveau (Standard ou Pro), les fonds sont libérés entre 48h et 7 jours après la validation de la livraison.</div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">Quels documents sont nécessaires ? <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg></button>
                    <div class="faq-answer">Une pièce d'identité valide, un permis de conduire (pour les véhicules motorisés) et une preuve d'immatriculation de votre entreprise (si applicable).</div>
                </div>
                <div class="faq-item">
                    <button class="faq-question">Puis-je choisir mes horaires ? <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg></button>
                    <div class="faq-answer">Oui, vous êtes totalement libre. Vous activez votre disponibilité sur l'application quand vous souhaitez travailler et vous choisissez les missions qui vous conviennent.</div>
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section class="contact" id="contact">
            <div class="contact-grid">
                <div class="contact-info reveal">
                    <h2>Parlons de votre prochain trajet.</h2>
                    <p style="color:#64748b; font-size: 1.1rem; line-height: 1.6;">Notre équipe d'experts logistique est là pour vous accompagner. Que vous ayez une question technique ou besoin de conseils pour optimiser vos livraisons.</p>
                    
                    <div class="contact-methods">
                        <div class="method-card">
                            <div class="method-icon"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg></div>
                            <div>
                                <h4 style="font-weight: 800; color: #0f172a;">Email Support</h4>
                                <p style="color:#64748b; font-size: 0.9rem;">support@karnou.com</p>
                            </div>
                        </div>
                        <div class="method-card">
                            <div class="method-icon" style="background: rgba(34,197,94,0.08); color: #22c55e;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
                            <div>
                                <h4 style="font-weight: 800; color: #0f172a;">Assistance WhatsApp</h4>
                                <p style="color:#64748b; font-size: 0.9rem;">+221 77 000 00 00</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form reveal">
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label>Nom complet</label>
                            <input type="text" class="form-control" placeholder="Jean Dupont">
                        </div>
                        <div class="form-group">
                            <label>Email professionnel</label>
                            <input type="email" class="form-control" placeholder="jean@exemple.com">
                        </div>
                        <div class="form-group">
                            <label>Sujet</label>
                            <select class="form-control">
                                <option>Devenir livreur</option>
                                <option>Flotte entreprise</option>
                                <option>Aide technique</option>
                                <option>Autre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" rows="4" placeholder="Comment pouvons-nous vous aider ?"></textarea>
                        </div>
                        <button type="button" class="btn-submit">Envoyer le message</button>
                    </form>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="site-footer" style="background: #04080f; border-top: 1px solid rgba(255,255,255,0.05); padding: 80px 2rem 40px;">
            <div class="footer-top" style="max-width: 1400px; padding-bottom: 60px;">
                <div style="position: relative;">
                    <div class="footer-logo" style="margin-bottom: 20px; font-weight: 850; letter-spacing: -0.04em;">KARNOU<span style="color:#60a5fa">.</span>LOGISTIQUE</div>
                    <p class="footer-desc" style="max-width: 320px; font-size: 0.9rem; color: #94a3b8; line-height: 1.7;">La plateforme logistique d'élite pour l'écosystème Karnou. Performance, transparence et fiabilité institutionnelle.</p>
                </div>
                <div class="footer-col" style="padding-left: 40px;">
                    <h4 style="color: #60a5fa; margin-bottom: 24px;">L'Ecosystème</h4>
                    <ul style="opacity: 0.9;">
                        <li><a href="/" style="font-size: 0.9rem;">Marketplace</a></li>
                        <li><a href="#" style="font-size: 0.9rem;">Agence Immo</a></li>
                        <li><a href="#" style="font-size: 0.9rem;">Devenir Livreur</a></li>
                        <li><a href="#" style="font-size: 0.9rem;">Centre d'aide</a></li>
                    </ul>
                </div>
                <div class="footer-col" style="padding-left: 40px;">
                    <h4 style="color: #60a5fa; margin-bottom: 24px;">Légal</h4>
                    <ul style="opacity: 0.9;">
                        <li><a href="#" style="font-size: 0.9rem;">Conditions d'utilisation</a></li>
                        <li><a href="#" style="font-size: 0.9rem;">Confidentialité</a></li>
                        <li><a href="#" style="font-size: 0.9rem;">Cookies</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom" style="max-width: 1400px; border-top: 1px solid rgba(255,255,255,0.04); padding-top: 32px;">
                <span style="color: #64748b;">&copy; {{ date('Y') }} Karnou Group. Prototype Apex Executive v1.0.</span>
                <span style="color: #64748b;">Design & Engineering by <span style="color: #94a3b8; font-weight: 600;">Antigravity AI</span></span>
            </div>
        </footer>

    </body>

    <script>
        // Scroll logic
        (function() {
            // Header transition
            const header = document.querySelector('.site-header');
            const onScroll = () => {
                if (window.scrollY > 20) header.classList.add('scrolled');
                else header.classList.remove('scrolled');
            };
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();

            // Animations removed
        })();
    </script>
</html>
