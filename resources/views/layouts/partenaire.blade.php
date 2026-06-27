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
