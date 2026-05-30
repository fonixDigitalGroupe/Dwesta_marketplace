<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Karnou Pro') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --primary: #004AAD;
                --orange: #FF6B00;
                --slate: #0F172A;
            }
            body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
            h1, h2, h3, .font-outfit { font-family: 'Outfit', sans-serif; }
            .auth-card {
                background: #FFFFFF;
                border: 1px solid rgba(0, 0, 0, 0.05);
                border-radius: 32px;
                box-shadow: 0 20px 50px rgba(15, 23, 42, 0.04);
                padding: 48px;
            }
            .logo-block {
                background: var(--primary);
                padding: 12px 24px;
                border-radius: 12px;
                display: inline-flex;
                align-items: center;
                gap: 8px;
                text-decoration: none;
                margin-bottom: 40px;
                transition: transform 0.2s;
            }
            .logo-block:hover { transform: translateY(-2px); }
            .logo-block span { color: #FFFFFF; font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.2rem; }
            .logo-block .pro { font-weight: 300; opacity: 0.8; }
        </style>
    </head>
    <body class="antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-10 sm:pt-0">
            <div class="w-full sm:max-w-md auth-card">
                <div class="flex justify-center">
                    <a href="/" class="logo-block">
                        <span>Karnou <span class="pro">Pro</span></span>
                    </a>
                </div>
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-slate-400 text-sm font-medium">
                &copy; {{ date('Y') }} Karnou Logistics Group
            </div>
        </div>
    </body>
</html>
