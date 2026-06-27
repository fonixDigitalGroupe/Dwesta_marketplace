<!DOCTYPE html>
<html lang="fr" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>@yield('title', 'Karnou Partenaire')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- PWA --}}
    <link rel="manifest" href="/pwa/manifest.webmanifest">
    <meta name="theme-color" content="@yield('theme-color', '#004AAD')">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Karnou Pro">
    <link rel="apple-touch-icon" href="/pwa/icons/icon-192.png">
    <link rel="icon" type="image/png" href="/pwa/icons/favicon.png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --karnou-blue: #004AAD;
            --karnou-orange: #FF6B00;
            --sat: env(safe-area-inset-top, 0px);
            --sab: env(safe-area-inset-bottom, 0px);
        }
        * { -webkit-tap-highlight-color: transparent; }
        html, body { height: 100%; overscroll-behavior-y: none; }
        body {
            margin: 0;
            background: #0b1220;
            font-family: 'Outfit', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        /* Coquille mobile : plein écran sur téléphone, cadre centré sur desktop pour aperçu. */
        .partner-shell {
            position: relative;
            width: 100%;
            min-height: 100dvh;
            margin: 0 auto;
            background: #000;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding-top: var(--sat);
            padding-bottom: var(--sab);
        }
        @media (min-width: 560px) {
            body { display: flex; align-items: center; justify-content: center; padding: 24px; }
            .partner-shell {
                max-width: 420px;
                min-height: min(880px, calc(100dvh - 48px));
                border-radius: 36px;
                overflow: hidden;
                box-shadow: 0 30px 80px rgba(0, 0, 0, .55);
            }
        }
        [x-cloak] { display: none !important; }

        /* ============================================================
           Composants d'écran partenaire (réutilisables)
           ============================================================ */
        .pt-screen { flex: 1; display: flex; flex-direction: column; background: #000; min-height: 0; }
        .pt-header { display: flex; align-items: center; gap: 14px; padding: 14px 20px 4px; }
        .pt-back {
            width: 44px; height: 44px; border-radius: 14px; border: 0;
            background: rgba(255,255,255,.06); color: #fff; cursor: pointer;
            display: flex; align-items: center; justify-content: center; text-decoration: none; flex: none;
        }
        .pt-back:active { background: rgba(255,255,255,.12); }
        .pt-progress { flex: 1; height: 5px; border-radius: 999px; background: rgba(255,255,255,.10); overflow: hidden; }
        .pt-progress > i { display: block; height: 100%; background: var(--karnou-blue); border-radius: 999px; transition: width .3s; }

        .pt-body { flex: 1; overflow-y: auto; -webkit-overflow-scrolling: touch; padding: 24px 24px 16px; }
        .pt-title { font-size: 26px; font-weight: 800; color: #fff; letter-spacing: -.5px; }
        .pt-subtitle { margin-top: 8px; font-size: 15px; line-height: 1.5; color: #94A3B8; }
        .pt-section { margin-top: 26px; }
        .pt-section-header { font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: #64748B; margin-bottom: 10px; }

        .pt-card { background: #121212; border: 1px solid rgba(255,255,255,.06); border-radius: 20px; overflow: hidden; }
        .pt-field { display: flex; align-items: center; gap: 12px; padding: 16px; }
        .pt-field .ic { color: #64748B; flex: none; width: 20px; text-align: center; }
        .pt-input {
            flex: 1; min-width: 0; background: transparent; border: 0; outline: none;
            color: #fff; font-size: 16px; font-family: inherit;
        }
        .pt-input::placeholder { color: #475569; }
        .pt-divider { height: 1px; background: rgba(255,255,255,.06); margin-left: 48px; }

        /* Sélecteur indicatif pays */
        .pt-phone-row { display: flex; align-items: stretch; gap: 10px; }
        .pt-country {
            display: flex; align-items: center; gap: 6px; padding: 0 14px; min-height: 56px;
            background: #121212; border: 1px solid rgba(255,255,255,.06); border-radius: 16px;
            color: #fff; font-size: 16px; font-weight: 600;
        }
        .pt-country select { background: transparent; border: 0; color: #fff; font-size: 16px; outline: none; font-family: inherit; }
        .pt-country select option { color: #000; }

        /* Boîtes OTP */
        .pt-otp { display: flex; gap: 12px; justify-content: center; margin-top: 28px; }
        .pt-otp input {
            width: 60px; height: 70px; text-align: center; font-size: 28px; font-weight: 800;
            color: #fff; background: #121212; border: 2px solid rgba(255,255,255,.08);
            border-radius: 18px; outline: none; font-family: inherit;
        }
        .pt-otp input:focus { border-color: var(--karnou-blue); }

        /* Options sélectionnables (véhicule, document, métier) */
        .pt-option {
            display: flex; align-items: center; gap: 14px; width: 100%; text-align: left;
            padding: 18px; background: #121212; border: 1.5px solid rgba(255,255,255,.07);
            border-radius: 20px; color: #fff; cursor: pointer; margin-bottom: 12px; font-family: inherit;
        }
        .pt-option .ic-box {
            width: 48px; height: 48px; border-radius: 14px; flex: none;
            background: rgba(0,74,173,.16); display: flex; align-items: center; justify-content: center;
            font-size: 22px; color: var(--karnou-blue);
        }
        .pt-option h3 { font-size: 16px; font-weight: 700; }
        .pt-option p { font-size: 13px; color: #94A3B8; margin-top: 2px; }
        .pt-option.is-active { border-color: var(--karnou-orange); background: rgba(255,107,0,.08); }

        .pt-chips { display: flex; gap: 10px; flex-wrap: wrap; }
        .pt-chip {
            padding: 12px 18px; border-radius: 14px; background: #121212;
            border: 1.5px solid rgba(255,255,255,.07); color: #cbd5e1; font-size: 14px;
            font-weight: 600; cursor: pointer; font-family: inherit;
        }
        .pt-chip.is-active { border-color: var(--karnou-orange); background: rgba(255,107,0,.10); color: #fff; }

        /* Pied + bouton principal */
        .pt-footer { padding: 14px 24px calc(20px + var(--sab)); }
        .pt-btn {
            width: 100%; border: 0; border-radius: 999px; padding: 17px; font-size: 16px;
            font-weight: 700; cursor: pointer; font-family: inherit; color: #fff;
            background: var(--karnou-orange); display: flex; align-items: center; justify-content: center; gap: 8px;
            text-decoration: none;
        }
        .pt-btn:disabled { opacity: .4; cursor: not-allowed; }
        .pt-btn--ghost { background: rgba(255,255,255,.06); }

        .pt-alert { background: rgba(239,68,68,.12); border: 1px solid rgba(239,68,68,.3); color: #fca5a5; padding: 12px 14px; border-radius: 14px; font-size: 14px; margin-bottom: 16px; }
        .pt-note { background: rgba(16,185,129,.10); border: 1px solid rgba(16,185,129,.3); color: #6ee7b7; padding: 12px 14px; border-radius: 14px; font-size: 14px; margin-bottom: 16px; }
        .pt-muted { color: #64748B; font-size: 14px; }
        .pt-link { color: var(--karnou-orange); font-weight: 600; text-decoration: none; background: none; border: 0; cursor: pointer; font-family: inherit; font-size: inherit; }
    </style>

    @stack('styles')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
</head>

<body>
    <div class="partner-shell">
        @yield('content')
    </div>

    {{-- Enregistrement du Service Worker (scope /partenaire) --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker
                    .register('/sw.js', { scope: '/partenaire' })
                    .catch(function (e) { console.warn('SW non enregistré :', e); });
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
