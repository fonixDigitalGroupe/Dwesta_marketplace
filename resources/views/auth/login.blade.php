@extends('layouts.app')

@section('title', 'Identification - Karnou')

@push('styles')
    <style>
        body {
            background-color: #ffffff !important;
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        .auth-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        /* Breadcrumbs */
        .breadcrumbs {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .breadcrumbs a {
            color: #666;
            text-decoration: none;
        }

        .breadcrumbs span {
            margin: 0 0.4rem;
        }

        /* Page title */
        .page-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #000;
            text-align: left;
            margin-top: 0.25rem;
            margin-left: 7.5rem;
        }

        /* Auth Layout */
        .auth-layout {
            display: flex;
            justify-content: flex-start;
            align-items: start;
            width: 100%;
            padding-left: 7rem;
        }

        /* Auth Grid */
        .auth-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            align-items: start;
            width: 100%;
            max-width: 900px;
        }

        /* Card Styles */
        .auth-card {
            background: #fff;
            padding: 1.25rem 2.5rem 2.5rem 2.5rem;
            border: none;
            border-radius: 0;
            width: 100%;
        }

        .auth-section-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0 0 1.5rem 0;
            padding-bottom: 0.4rem;
            border-bottom: 1px solid #f0f0f0;
            color: #000;
        }

        /* Floating Label Inputs */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
            width: 85%;
        }

        .floating-input {
            width: 100%;
            padding: 1.15rem 0.85rem 0.45rem 0.85rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.95rem;
            background: #fff;
            box-sizing: border-box;
            transition: all 0.2s ease;
            outline: none;
        }

        .floating-input:focus {
            border-color: #000;
            box-shadow: 0 0 0 2px rgba(0,0,0,0.04);
        }

        .floating-label {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.95rem;
            color: #666;
            pointer-events: none;
            transition: all 0.2s ease;
            background: transparent;
        }

        .floating-input:focus ~ .floating-label,
        .floating-input:not(:placeholder-shown) ~ .floating-label {
            top: 0.6rem;
            font-size: 0.7rem;
            color: #000;
            font-weight: 600;
            transform: translateY(0);
        }

        /* Input with icon toggle — add right padding */
        .input-toggle-wrapper {
            position: relative;
            width: 100%;
        }

        .input-toggle-wrapper .floating-input {
            padding-right: 2.5rem;
        }

        /* Icon toggle button */
        .icon-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            display: flex;
            align-items: center;
            padding: 6px;
            border-radius: 4px;
            z-index: 10;
            transition: all 0.2s;
            border: none;
            background: none;
        }

        .icon-toggle:hover {
            color: #004aad;
            background: rgba(0, 74, 173, 0.05);
        }

        /* Password toggle */
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            display: flex;
            align-items: center;
            padding: 6px;
            border-radius: 4px;
            z-index: 10;
            transition: all 0.2s;
        }

        .password-toggle:hover {
            color: #004aad;
            background: rgba(0, 74, 173, 0.05);
        }

        /* Phone input group */
        .phone-input-group {
            display: flex;
            align-items: stretch;
            border: 1px solid #ccc;
            border-radius: 4px;
            position: relative;
            transition: border-color 0.2s;
            width: 100%;
        }

        .phone-input-group:focus-within {
            border-color: #000;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.04);
        }

        /* Custom Dial Code Dropdown */
        .custom-dial {
            position: relative;
            flex-shrink: 0;
            border-right: 1px solid #eee;
        }

        .custom-dial-btn {
            display: flex;
            align-items: center;
            padding: 0 0.6rem;
            height: 100%;
            min-width: 90px;
            cursor: pointer;
            font-size: 0.88rem;
            color: #333;
            user-select: none;
            white-space: nowrap;
            gap: 4px;
        }

        .custom-dial-list {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            list-style: none;
            padding: 0.25rem 0;
            margin: 0;
            max-height: 200px;
            overflow-y: auto;
            z-index: 100;
            min-width: 110px;
        }

        .custom-dial-list li {
            padding: 0.45rem 0.75rem;
            cursor: pointer;
            font-size: 0.88rem;
            color: #333;
            white-space: nowrap;
        }

        .custom-dial-list li:hover {
            background: #f5f5f5;
        }

        .phone-number-input {
            flex: 1;
            border: none;
            padding: 0.85rem 2.5rem 0.85rem 0.6rem;
            font-size: 0.95rem;
            outline: none;
            background: transparent;
        }

        /* Links & Buttons */
        .forgot-link {
            display: inline-block;
            margin-top: 0.5rem;
            color: #f68b1e;
            text-decoration: none;
            font-size: 0.88rem;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-primary {
            background-color: #004aad;
            color: #fff;
            border: none;
            padding: 0.5rem 2.5rem;
            border-radius: 4px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 1.5rem;
            width: auto;
            min-width: 150px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary:hover {
            background-color: #003a8a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 74, 173, 0.15);
        }

        /* Right column — new account */
        .right-section {
            border-left: 1px solid #f0f0f0;
            padding-left: 2rem;
        }

        /* Divider */
        .divider-container {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
            color: #666;
            font-size: 0.95rem;
        }

        .divider-container::before,
        .divider-container::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #eee;
        }

        .divider-container:not(:empty)::before { margin-right: 1rem; }
        .divider-container:not(:empty)::after  { margin-left: 1rem; }

        /* Social buttons */
        .social-btns {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .social-btn {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* ─── Desktop-only shadow separator ─── */
        @media (min-width: 769px) {
            .auth-card.login-card {
                box-shadow: 8px 0 15px -10px rgba(0,0,0,0.08);
            }
        }

        /* ─── Mobile ─── */
        @media (max-width: 768px) {
            .auth-layout {
                padding-left: 0 !important;
            }
            .auth-wrapper {
                padding: 0.75rem 1rem;
            }
            .page-title {
                margin-left: 0 !important;
                text-align: center !important;
                font-size: 1.15rem !important;
            }
            .auth-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .auth-card {
                padding: 1.5rem 1.25rem !important;
                box-shadow: none !important;
            }
            .form-group {
                width: 100% !important;
                margin-bottom: 0.75rem !important;
            }
            .btn-primary {
                width: 100% !important;
                margin: 0.75rem 0 0 0 !important;
                min-width: unset !important;
            }
            .right-section {
                border-left: none;
                padding-left: 0;
                border-top: 1px solid #f0f0f0;
                padding-top: 2rem;
            }
            .social-btns {
                justify-content: center;
            }
            .auth-section-title {
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="auth-wrapper">
        <nav class="breadcrumbs">
            <a href="/">Accueil</a>
            <span>&gt;</span>
            <strong>Identification</strong>
        </nav>

        <h1 class="page-title">Identification</h1>

        <div class="auth-layout">
            <div class="auth-grid">
                <!-- ── Left: Login Form ── -->
                <div class="auth-card login-card">
                    <h2 class="auth-section-title">Déjà client Karnou ?</h2>

                    @if(session('error') || session('social_error'))
                        <div style="background: #fff5f5; color: #c53030; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem; border: 1px solid #feb2b2;">
                            {{ session('error') ?? session('social_error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" id="login-form">
                        @csrf

                        <!-- Email Mode -->
                        <div class="form-group" id="email-group">
                            <div class="input-toggle-wrapper">
                                <input type="text" name="login" id="login-email" class="floating-input" placeholder=" "
                                    required autofocus value="{{ old('login') }}">
                                <label for="login-email" class="floating-label">E-mail ou pseudo</label>
                                <button type="button" class="icon-toggle" onclick="toggleLoginMode('phone')"
                                    title="Utiliser mon téléphone" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="pointer-events:none;">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Phone Mode -->
                        <div class="form-group" id="phone-group" style="display: none; position: relative;">
                            <input type="hidden" id="login-phone-value">
                            <div style="position: relative; overflow: hidden;">
                                <div class="phone-input-group" style="padding-right: 48px;">
                                    @php $defaultDial = $countries->firstWhere('code', 'CF') ?? $countries->first(); @endphp
                                    <div class="custom-dial" id="dial-code-wrapper">
                                        <input type="hidden" id="dial-code-select" value="{{ $defaultDial->phone_code ?? '' }}">
                                        <div class="custom-dial-btn" onclick="toggleDialDropdown('dial-code-wrapper')">
                                            <span id="dial-code-display">{{ $defaultDial->flag ?? '' }} {{ $defaultDial->phone_code ?? '' }}</span>
                                            <svg width="10" height="10" viewBox="0 0 10 6" fill="none" style="margin-left:4px;flex-shrink:0;">
                                                <path d="M1 1l4 4 4-4" stroke="#666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <ul class="custom-dial-list" id="dial-code-wrapper-list" style="display:none;">
                                            @foreach($countries as $country)
                                                <li onclick="selectDial('dial-code-wrapper', '{{ $country->phone_code }}', '{{ $country->flag }} {{ $country->phone_code }}')">
                                                    {{ $country->flag }} {{ $country->phone_code }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="tel" id="login-phone-number" class="phone-number-input" placeholder="Numéro de téléphone">
                                </div>
                                <button type="button" class="icon-toggle" onclick="toggleLoginMode('email')"
                                    title="Utiliser mon e-mail" style="cursor: pointer; position: absolute; right: 8px; top: 50%; transform: translateY(-50%);">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="pointer-events:none;">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <div class="input-toggle-wrapper">
                                <input type="password" name="password" id="password" class="floating-input" placeholder=" " required>
                                <label for="password" class="floating-label">Mot de passe</label>
                                <span class="password-toggle" onclick="togglePassword()">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('password.request') }}" class="forgot-link">J'ai oublié mon mot de passe</a>

                        <div>
                            <button type="submit" class="btn-primary">Me connecter</button>
                        </div>

                        <div class="divider-container" style="margin-top: 2rem;">Ou connectez-vous avec</div>

                        <div class="social-btns">
                            <a href="{{ route('social.redirect', 'facebook') }}" class="social-btn" title="Se connecter avec Facebook">
                                <svg width="40" height="40" viewBox="0 0 24 24">
                                    <path fill="#1877F2" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="{{ route('social.redirect', 'google') }}" class="social-btn" title="Se connecter avec Google">
                                <svg width="40" height="40" viewBox="0 0 48 48">
                                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                    <path fill="none" d="M0 0h48v48H0z"/>
                                </svg>
                            </a>
                        </div>

                        <p style="text-align: center; color: #888; font-size: 0.78rem; line-height: 1.5; margin-top: 1.25rem;">
                            En continuant, vous acceptez les conditions d'utilisation de Karnou<br>
                            <a href="{{ route('terms') }}" style="color: #004aad; text-decoration: underline;">Termes et conditions</a>
                        </p>
                    </form>
                </div>

                <!-- ── Right: New Account ── -->
                <div class="auth-card right-section">
                    <h2 class="auth-section-title">Nouveau client ?</h2>

                    <p style="color: #666; font-size: 0.9rem; line-height: 1.6; margin-bottom: 1.5rem;">
                        Créez votre compte Karnou pour profiter de toutes nos fonctionnalités.
                    </p>

                    <a href="{{ route('register') }}" style="text-decoration: none;">
                        <button type="button" class="btn-primary" style="margin-top: 0;">Créer un compte Karnou</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let emailInput, form;

        document.addEventListener('DOMContentLoaded', function () {
            emailInput = document.querySelector('#login-email');
            form = document.querySelector('#login-form');

            form.addEventListener('submit', function () {
                if (document.getElementById('phone-group').style.display !== 'none') {
                    const dialCode = document.getElementById('dial-code-select').value;
                    const number = document.getElementById('login-phone-number').value.trim();
                    document.getElementById('login-phone-value').value = dialCode + number;
                }
            });
        });

        function toggleLoginMode(mode) {
            const emailGroup = document.getElementById('email-group');
            const phoneGroup = document.getElementById('phone-group');
            const hiddenPhoneInput = document.getElementById('login-phone-value');

            if (mode === 'phone') {
                emailGroup.style.display = 'none';
                phoneGroup.style.display = 'block';
                emailInput.name = '';
                emailInput.required = false;
                hiddenPhoneInput.name = 'login';
                document.getElementById('login-phone-number').focus();
            } else {
                emailGroup.style.display = 'block';
                phoneGroup.style.display = 'none';
                emailInput.name = 'login';
                emailInput.required = true;
                hiddenPhoneInput.name = '';
                emailInput.focus();
            }
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }

        function toggleDialDropdown(wrapperId) {
            const list = document.getElementById(wrapperId + '-list');
            list.style.display = list.style.display === 'none' ? 'block' : 'none';
        }

        function selectDial(wrapperId, value, label) {
            document.getElementById('dial-code-select').value = value;
            document.getElementById('dial-code-display').textContent = label;
            document.getElementById(wrapperId + '-list').style.display = 'none';
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            const wrapper = document.getElementById('dial-code-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                const list = document.getElementById('dial-code-wrapper-list');
                if (list) list.style.display = 'none';
            }
        });
    </script>
@endpush