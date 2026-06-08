@extends('layouts.app')

@section('title', 'Création de compte - Karnou')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        body {
            background-color: #ffffff !important;
            font-family: 'Inter', sans-serif;
            color: #333;
        }

        .auth-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2.5rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Auth Grid */
        .auth-grid {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 4rem;
            align-items: start;
        }

        .auth-centered-container {
            display: flex;
            justify-content: center;
            align-items: start;
            width: 100%;
        }

        .auth-centered-container .auth-card {
            max-width: 550px;
            width: 100%;
        }

        .auth-card {
            background: #fff;
            padding: 2.5rem;
            border: 1px solid #f5f5f5;
            border-radius: 8px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
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

        /* Titles */
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: #000;
            text-align: center;
        }

        .section-header {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 2rem 0 1.25rem 0;
            padding-bottom: 0.4rem;
            border-bottom: 1px solid #f0f0f0;
            color: #000;
        }

        .section-header:first-of-type {
            margin-top: 0;
        }

        /* Floating Labels */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
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

        /* Floating effect when focused or has value */
        .floating-input:focus ~ .floating-label,
        .floating-input:not(:placeholder-shown) ~ .floating-label {
            top: 0.6rem;
            font-size: 0.7rem;
            color: #000;
            font-weight: 600;
            transform: translateY(0);
        }

        /* Password Strength Checklist */
        .strength-checklist {
            margin-top: 0.75rem;
            padding: 0;
            list-style: none;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
        }

        .strength-item {
            font-size: 0.8rem;
            color: #999;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: color 0.2s ease;
        }

        .strength-item.valid {
            color: #28a745;
        }

        .strength-icon {
            width: 6px;
            height: 6px;
            background: #ccc;
            border-radius: 50%;
            transition: background 0.2s ease;
        }

        .strength-item.valid .strength-icon {
            background: #28a745;
        }

        /* Email Warning */
        .email-warning {
            display: none;
            background: #fdf2f2;
            border: 1px solid #fbd5d5;
            padding: 0.75rem;
            border-radius: 4px;
            font-size: 0.85rem;
            color: #9b1c1c;
            margin-top: 0.5rem;
        }

        .email-warning a {
            color: #1a56db;
            text-decoration: underline;
            font-weight: 600;
        }

        /* Radio Group */
        .radio-group {
            display: flex;
            gap: 2rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 1rem;
        }

        .radio-item input[type="radio"] {
            width: 20px;
            height: 20px;
            accent-color: #000;
            cursor: pointer;
        }

        /* Date Grid */

        .date-grid {
            display: grid;
            grid-template-columns: 80px 80px 120px;
            gap: 1rem;
        }

        /* Button */
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
            margin-top: 2rem;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #003a8a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,74,173,0.15);
        }

        .error-msg {
            color: #c53030;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            z-index: 5;
        }

        /* Email/Phone Toggle */
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
        }

        .icon-toggle:hover {
            color: #004aad;
            background: rgba(0,74,173,0.05);
        }

        .input-toggle-wrapper {
            position: relative;
        }

        .input-toggle-wrapper .floating-input {
            padding-right: 2.5rem;
        }

        /* Phone input group */
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
            box-shadow: 0 0 0 2px rgba(0,0,0,0.04);
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
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

        /* Footer */
        .terms-text {
            font-size: 0.85rem;
            color: #666;
            line-height: 1.5;
            margin-top: 2rem;
        }

        .terms-text a {
            color: #f68b1e;
            text-decoration: none;
        }

        /* Social & Help Section */
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

        .divider-container:not(:empty)::before {
            margin-right: 1rem;
        }

        .divider-container:not(:empty)::after {
            margin-left: 1rem;
        }

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
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .disclaimer-box {
            text-align: center;
            font-size: 0.9rem;
            color: #000;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .disclaimer-box a {
            color: #f68b1e;
            text-decoration: underline;
            display: block;
        }

        .help-box {
            text-align: center;
            font-size: 0.95rem;
            color: #000;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .help-box strong {
            display: block;
            margin-top: 5px;
            font-size: 1.1rem;
        }

        .footer-logo {
            text-align: center;
            margin-top: 1rem;
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: 1px;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .footer-logo .star {
            color: #f68b1e;
            font-size: 1.2rem;
        }

        @media (max-width: 992px) {
            .auth-wrapper {
                padding: 1rem 0.5rem;
            }
            .auth-card {
                padding: 1.5rem 1rem !important;
                max-width: none !important;
            }
            .auth-centered-container .auth-card {
                max-width: none !important;
            }
            .auth-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .date-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 0.5rem;
            }
            .strength-checklist {
                grid-template-columns: 1fr;
            }
        }

        /* Select styling for float */
        .floating-select {
            appearance: none;
            padding-top: 1.25rem;
        }
    </style>
@endpush

@section('content')
    <div class="auth-wrapper">
        <nav class="breadcrumbs">
            <a href="/">Accueil</a>
            <span>&gt;</span>
            <a href="/register">Inscription</a>
        </nav>

        <div class="auth-centered-container">
            <!-- Registration Form -->
            <div class="auth-card">
                <h1 class="page-title">Bienvenue chez Karnou</h1>
                <p style="text-align: center; color: #666; font-size: 0.95rem; margin-bottom: 2rem; line-height: 1.5;">
                    Utilisez votre e-mail ou votre téléphone pour vous connecter ou créer un compte.
                </p>

                <form method="POST" action="{{ route('register') }}" id="register-form">
                    @csrf

                    <!-- Section 1: Authentication -->
                    <div class="auth-section">
                        {{-- Titre de section masqué car redondant avec le nouveau header --}}

                        <!-- Email Mode -->
                        <div class="form-group" id="reg-email-group">
                            <div class="input-toggle-wrapper">
                                <input type="email" name="email" id="email" class="floating-input" placeholder=" " value="{{ old('email') }}">
                                <label for="email" class="floating-label">E-mail</label>
                                <button type="button" class="icon-toggle" onclick="toggleRegisterMode('phone')" title="Utiliser mon téléphone" style="border: none; background: none; cursor: pointer; z-index: 10; padding: 10px; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="pointer-events: none;">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div id="email-exists-warning" class="email-warning">
                                Un compte est déjà associé à cette adresse e-mail. <br>
                                <a href="{{ route('login') }}">Je me connecte</a> ou <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                            </div>
                            @error('email') <div class="error-msg">{{ $message }}</div> @enderror
                        </div>

                        <!-- Phone Mode (login via phone) -->
                        <div class="form-group" id="reg-phone-group" style="display: none;">
                            <input type="hidden" name="reg_login_phone" id="reg-phone-value">
                            <div style="position: relative;">
                                <div class="phone-input-group">
                                    @php $defaultDial = $countries->firstWhere('code', 'CF') ?? $countries->first(); @endphp
                                    <div class="custom-dial" id="reg-dial-code-wrapper">
                                        <input type="hidden" id="reg-dial-code-select" value="{{ $defaultDial->phone_code }}">
                                        <div class="custom-dial-btn" onclick="toggleDialDropdown('reg-dial-code-wrapper')">
                                            <span id="reg-dial-code-display">{{ $defaultDial->flag }} {{ $defaultDial->phone_code }}</span>
                                            <svg width="10" height="10" viewBox="0 0 10 6" fill="none" style="margin-left:4px;flex-shrink:0;"><path d="M1 1l4 4 4-4" stroke="#666" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                        <ul class="custom-dial-list" id="reg-dial-code-wrapper-list" style="display:none;">
                                            @foreach($countries as $country)
                                                <li onclick="selectRegDial('{{ $country->phone_code }}', '{{ $country->flag }} {{ $country->phone_code }}')">
                                                    {{ $country->flag }} {{ $country->phone_code }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <input type="tel" id="reg-phone-number" class="phone-number-input" placeholder="Numéro de téléphone">
                                </div>
                                <button type="button" class="icon-toggle" onclick="toggleRegisterMode('email')" title="Utiliser mon e-mail" style="border:none; background:none; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 10; padding: 10px;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="pointer-events: none;">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                </button>
                            </div>
                            @error('reg_login_phone') <div class="error-msg">{{ $message }}</div> @enderror
                        </div>


                        {{-- TEMPORAIREMENT MASQUÉ --
                        <div class="form-group">
                            ... password, personal info, terms, submit ...
                        </div>
                        --}}
                    </div>

                    {{-- TEMPORAIREMENT MASQUÉ: Section 2 Informations personnelles + terms + submit
                    <!-- Section 2: Personal Info -->
                    <div class="auth-section">
                        (civilité, prénom, nom, date de naissance, nationalité, téléphone, adresse)
                    </div>
                    <div class="terms-text">...</div>
                    <div style="text-align: center;"><button type="submit">Créer mon compte</button></div>
                    --}}

                    <div style="text-align: center; margin-top: 1.5rem;">
                        <button type="submit" id="register-submit-btn" class="btn-primary">
                            <span class="btn-text">Créer un compte Karnou</span>
                            <span class="btn-spinner" style="display:none;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="animation:spin 1s linear infinite; vertical-align:middle;">
                                    <circle cx="12" cy="12" r="10" stroke="rgba(255,255,255,0.3)" stroke-width="3"/>
                                    <path d="M12 2a10 10 0 0 1 10 10" stroke="white" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                                Envoi en cours…
                            </span>
                        </button>
                    </div>

                    {{-- Loader overlay --}}
                    <div id="register-loader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.92); backdrop-filter:blur(6px); z-index:9999; flex-direction:column; align-items:center; justify-content:center;">
                        <div style="display:flex; flex-direction:column; align-items:center; gap:1.5rem;">
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="28" cy="28" r="24" stroke="#f0f0f0" stroke-width="5"/>
                                <path d="M28 4a24 24 0 0 1 24 24" stroke="#f68b1e" stroke-width="5" stroke-linecap="round" style="animation:spin 1s linear infinite; transform-origin:center;"/>
                            </svg>
                            <div style="font-family:'Inter',sans-serif; text-align:center;">
                                <p style="font-size:1.1rem; font-weight:700; color:#111; margin:0 0 0.3rem;">Envoi du code de vérification…</p>
                                <p style="font-size:0.85rem; color:#888; margin:0;">Veuillez patienter, cela prend quelques secondes.</p>
                            </div>
                            <div style="display:flex; gap:6px;">
                                <span style="width:8px;height:8px;border-radius:50%;background:#f68b1e;animation:bounce 1.2s ease-in-out 0s infinite;"></span>
                                <span style="width:8px;height:8px;border-radius:50%;background:#f68b1e;animation:bounce 1.2s ease-in-out 0.2s infinite;"></span>
                                <span style="width:8px;height:8px;border-radius:50%;background:#f68b1e;animation:bounce 1.2s ease-in-out 0.4s infinite;"></span>
                            </div>
                        </div>
                    </div>

                    <div class="divider-container">Ou inscrivez-vous avec</div>

                    <div class="social-btns">
                        <a href="#" class="social-btn" title="Facebook">
                            <svg width="40" height="40" viewBox="0 0 24 24">
                                <path fill="#1877F2" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-btn" title="Google">
                            <svg width="40" height="40" viewBox="0 0 48 48">
                                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                <path fill="none" d="M0 0h48v48H0z"/>
                            </svg>
                        </a>
                    </div>

                    <div class="disclaimer-box">
                        En continuant, vous acceptez les conditions d'utilisation de Karnou
                        <a href="#">Termes et conditions</a>
                    </div>

                    <div class="help-box">
                        Besoin d'aide ? Visitez notre Centre d'aide ou contactez-nous au
                        <strong>221301022122</strong>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const emailInput = document.querySelector('#email');
            const form = document.querySelector('#register-form');

            // Email existence check (debounced)
            if (emailInput) {
                let debounceTimer;
                emailInput.addEventListener('input', function () {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(function () {
                        const email = emailInput.value.trim();
                        if (!email) {
                            document.getElementById('email-exists-warning').style.display = 'none';
                            return;
                        }
                        fetch('/check-email?email=' + encodeURIComponent(email))
                            .then(r => r.json())
                            .then(data => {
                                document.getElementById('email-exists-warning').style.display = data.exists ? 'block' : 'none';
                            })
                            .catch(() => {});
                    }, 500);
                });
            }

            // Set phone value from dial code + number on submit
            if (form) {
                form.addEventListener('submit', function () {
                    const phoneGroup = document.getElementById('reg-phone-group');
                    if (phoneGroup && phoneGroup.style.display !== 'none') {
                        const dialCode = document.getElementById('reg-dial-code-select').value;
                        const number = document.getElementById('reg-phone-number').value.trim();
                        document.getElementById('reg-phone-value').value = dialCode + number;
                    }
                });
            }
        });

        function toggleRegisterMode(mode) {
            const emailGroup = document.getElementById('reg-email-group');
            const phoneGroup = document.getElementById('reg-phone-group');
            const emailInput = document.getElementById('email');

            if (mode === 'phone') {
                emailGroup.style.display = 'none';
                phoneGroup.style.display = 'block';
                if (emailInput) {
                    emailInput.removeAttribute('required');
                    emailInput.name = '_email_disabled';
                }
                document.getElementById('reg-phone-number').focus();
            } else {
                emailGroup.style.display = 'block';
                phoneGroup.style.display = 'none';
                if (emailInput) {
                    emailInput.required = true;
                    emailInput.name = 'email';
                    emailInput.focus();
                }
            }
        }

        function toggleDialDropdown(wrapperId) {
            const list = document.getElementById(wrapperId + '-list');
            list.style.display = list.style.display === 'none' ? 'block' : 'none';
        }

        function selectRegDial(value, label) {
            document.getElementById('reg-dial-code-select').value = value;
            document.getElementById('reg-dial-code-display').textContent = label;
            document.getElementById('reg-dial-code-wrapper-list').style.display = 'none';
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('reg-dial-code-wrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                const list = document.getElementById('reg-dial-code-wrapper-list');
                if (list) list.style.display = 'none';
            }
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
        // === REGISTER LOADER ===
        const registerForm = document.querySelector('form#register-form, form[action*="register"], .auth-card form');
        if (registerForm) {
            registerForm.addEventListener('submit', function() {
                const btn = document.getElementById('register-submit-btn');
                const loader = document.getElementById('register-loader');
                if (btn) {
                    btn.querySelector('.btn-text').style.display = 'none';
                    btn.querySelector('.btn-spinner').style.display = 'inline';
                    btn.disabled = true;
                }
                if (loader) loader.style.display = 'flex';
            });
        }
    </script>
    <style>
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); opacity:1; }
            50% { transform: translateY(-8px); opacity:0.5; }
        }
        #register-submit-btn .btn-spinner svg { display:inline-block; }
    </style>
@endpush