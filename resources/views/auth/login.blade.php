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
            padding: 1.5rem 1rem 1rem 1rem;
        }

        /* Breadcrumbs */
        .breadcrumbs {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.75rem;
        }

        .breadcrumbs a {
            color: #666;
            text-decoration: none;
        }

        .breadcrumbs span {
            margin: 0 0.5rem;
        }

        /* Auth Grid */
        .auth-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        @media (max-width: 768px) {
            .auth-wrapper {
                padding: 1rem 0.5rem;
            }
            .auth-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            .auth-card {
                padding: 1.5rem 1rem !important;
                max-width: none !important;
            }
            .btn-primary {
                width: auto !important;
                min-width: 160px;
                margin-left: auto;
                display: flex;
            }
        }

        /* Card Styles */
        .auth-card {
            background: #fff;
            padding: 2.5rem;
            border: 1px solid #f5f5f5;
            border-radius: 8px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
        }

        .auth-section-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 1.75rem;
            color: #000;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .input-wrapper {
            position: relative;
            width: 100%;
        }

        .icon-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            padding: 8px;
            /* Increased hit area */
            border-radius: 4px;
            z-index: 999;
            /* Much higher z-index */
            pointer-events: auto;
        }

        .icon-toggle:hover {
            color: #004aad;
            background: rgba(0, 74, 173, 0.05);
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 0.9rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.95rem;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            border-color: #000;
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            padding: 8px;
            /* Increased hit area */
            border-radius: 4px;
            z-index: 999;
            /* Much higher z-index */
            pointer-events: auto;
        }

        .password-toggle:hover {
            color: #004aad;
            background: rgba(0, 74, 173, 0.05);
        }

        /* Links & Buttons */
        .forgot-link {
            display: inline-block;
            margin-top: 0.75rem;
            color: #f68b1e;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .btn-primary {
            background-color: #004aad;
            color: #fff;
            border: none;
            padding: 0.75rem 3rem;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 1.5rem;
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary:hover {
            background-color: #003a8a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 74, 173, 0.15);
        }

        .right-section {
            border-left: 1px solid #f0f0f0;
            padding-left: 2rem;
        }

        @media (max-width: 768px) {
            .right-section {
                border-left: none;
                padding-left: 0;
                border-top: 1px solid #f0f0f0;
                padding-top: 2rem;
            }
        }

        .iti {
            width: 100%;
            display: block;
        }

        /* Phone input group with dial code selector */
        .phone-input-group {
            display: flex;
            align-items: stretch;
            border: 1px solid #ccc;
            border-radius: 4px;
            position: relative;
            transition: border-color 0.2s;
        }

        .phone-input-group:focus-within {
            border-color: #000;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
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
            padding: 0.75rem 2.5rem 0.75rem 0.6rem;
            font-size: 0.95rem;
            outline: none;
            background: transparent;
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

        <div class="auth-grid">
            <!-- Left Column: Login -->
            <div class="auth-card">
                <h2 class="auth-section-title">Déjà client Karnou ?</h2>

                @if(session('error'))
                    <div
                        style="background: #fff5f5; color: #c53030; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.9rem; border: 1px solid #feb2b2;">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="login-form">
                    @csrf

                    <!-- Email Mode -->
                    <div class="form-group" id="email-group">
                        <div class="input-wrapper">
                            <input type="text" name="login" id="login-email" placeholder="E-mail ou pseudo"
                                class="form-input" required autofocus value="{{ old('login') }}">
                            <button type="button" class="icon-toggle" onclick="toggleLoginMode('phone')"
                                title="Utiliser mon téléphone"
                                style="border:none; background:none; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 10; padding: 10px;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    style="pointer-events: none;">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                    </path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Phone Mode -->
                    <div class="form-group" id="phone-group" style="display: none; position: relative;">
                        <input type="hidden" id="login-phone-value">
                        <div class="phone-input-group">
                            @php $defaultDial = $countries->firstWhere('code', 'CF') ?? $countries->first(); @endphp
                            <div class="custom-dial" id="dial-code-wrapper">
                                <input type="hidden" id="dial-code-select" value="{{ $defaultDial->phone_code ?? '' }}">
                                <div class="custom-dial-btn" onclick="toggleDialDropdown('dial-code-wrapper')">
                                    <span id="dial-code-display">{{ $defaultDial->flag ?? '' }}
                                        {{ $defaultDial->phone_code ?? '' }}</span>
                                    <svg width="10" height="10" viewBox="0 0 10 6" fill="none"
                                        style="margin-left:4px;flex-shrink:0;">
                                        <path d="M1 1l4 4 4-4" stroke="#666" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <ul class="custom-dial-list" id="dial-code-wrapper-list" style="display:none;">
                                    @foreach($countries as $country)
                                        <li
                                            onclick="selectDial('dial-code-wrapper', '{{ $country->phone_code }}', '{{ $country->flag }} {{ $country->phone_code }}')">
                                            {{ $country->flag }} {{ $country->phone_code }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <input type="tel" id="login-phone-number" class="phone-number-input"
                                placeholder="Numéro de téléphone">
                        </div>
                        <button type="button" class="icon-toggle" onclick="toggleLoginMode('email')"
                            title="Utiliser mon e-mail"
                            style="border:none; background:none; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 10; padding: 10px;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                style="pointer-events: none;">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="form-group">
                        <div class="input-wrapper">
                            <input type="password" name="password" id="password" placeholder="Mot de passe"
                                class="form-input" required>
                            <span class="password-toggle" onclick="togglePassword()">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
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
                </form>
            </div>

            <!-- Right Column: Registration -->
            <div class="auth-card right-section">
                <h2 class="auth-section-title">Nouveau client ?</h2>

                <div style="margin-top: 1rem;">
                    <a href="{{ route('register') }}" style="text-decoration: none;">
                        <button type="button" class="btn-primary">Créer un compte Karnou</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let phoneInput, emailInput, form;

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