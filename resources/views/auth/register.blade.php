@extends('layouts.app')

@section('title', 'Création de compte - Mady Market')

@push('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, .page-wrapper, main {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #ffffff !important;
            color: #333;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    <style>
        /* Banner */
        .top-banner {
            background-color: #004aad;
            color: white;
            text-align: center;
            padding: 0.5rem;
            font-size: 0.9rem;
            position: relative;
        }

        .top-banner .close-btn {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        /* Main Content */
        .main-content {
            max-width: 1000px;
            margin: 0.5rem auto;
            padding: 0 0.5rem;
        }

        .breadcrumb {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .breadcrumb a {
            color: #666;
            text-decoration: none;
        }

        .page-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 1.25rem;
            text-align: center;
        }

        /* Form Layout */
        .register-card {
            background: white;
            padding: 2rem;
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            max-width: 600px;
            margin: 0 auto 3rem auto;
        }

        .form-section-wrapper {
            padding: 0;
        }

        .section-title {
            font-size: 0.95rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            padding-bottom: 0.4rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-input-box {
            width: 100%;
            padding: 0.9rem 0.75rem 0.2rem 0.75rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.9rem;
            outline: none;
            background-color: #ffffff;
        }

        .form-input-box:focus {
            border-color: #ff4e00;
        }

        .form-input-box.valid {
            border-color: #28a745;
        }

        .form-input-box.invalid {
            border-color: #dc3545;
        }

        /* Floating label for register */
        .input-container,
        .password-container,
        .phone-container {
            position: relative;
            max-width: 100%;
        }

        .input-container .floating-label,
        .password-container .floating-label,
        .phone-container .floating-label {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 0.9rem;
            transition: all 0.2s ease-out;
            pointer-events: none;
            z-index: 10;
        }

        .input-container .form-input-box:focus + .floating-label,
        .input-container .form-input-box:not(:placeholder-shown) + .floating-label,
        .input-container select.form-input-box:focus + .floating-label,
        .input-container select.form-input-box:valid + .floating-label,
        .password-container .form-input-box:focus + .floating-label,
        .password-container .form-input-box:not(:placeholder-shown) + .floating-label,
        .phone-container .form-input-box:focus + .floating-label,
        .phone-container .form-input-box:not(:placeholder-shown) + .floating-label,
        .phone-container .iti:focus-within + .floating-label {
            top: 0.4rem;
            transform: translateY(0);
            font-size: 0.7rem;
            color: #888;
        }

        .password-requirements {
            margin-top: 0.5rem;
            font-size: 0.85rem;
            display: none;
        }

        .password-container:focus-within ~ .password-requirements,
        .password-requirements.show {
            display: block;
        }

        .password-requirements li {
            list-style: none;
            padding-left: 1.5rem;
            position: relative;
            color: #28a745;
            margin-bottom: 0.25rem;
        }

        .password-requirements li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #28a745;
        }

        .password-requirements li.invalid {
            color: #dc3545;
        }

        .password-requirements li.invalid::before {
            color: #dc3545;
        }

        .password-container {
            position: relative;
            max-width: 100%;
        }

        .toggle-password {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            z-index: 10;
        }

        .email-container {
            position: relative;
            max-width: 100%;
        }

        .email-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            display: none;
        }

        .email-icon.valid {
            color: #28a745;
            display: block;
        }

        .email-icon.invalid {
            color: #dc3545;
            display: block;
        }

        .phone-container {
            position: relative;
        }

        .phone-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            display: none;
            z-index: 10;
        }

        .phone-icon.valid {
            color: #28a745;
            display: block;
        }

        .phone-icon.invalid {
            color: #dc3545;
            display: block;
        }

        /* Civilité Radio Group */
        .radio-group {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .radio-item input {
            cursor: pointer;
        }

        /* Date de naissance selectors */
        .date-selectors {
            display: flex;
            gap: 1rem;
        }

        .date-selectors select {
            flex: 1;
            padding: 0.85rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            outline: none;
            background: white;
        }

        .date-selectors select:focus {
            border-color: #ff4e00;
        }

        .btn-black {
            display: block;
            width: 100%;
            max-width: 550px;
            margin: 0 auto;
            background: #004aad;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-black:hover {
            background: #003a8c;
        }

        .social-login-section {
            margin: 1.5rem 0;
            text-align: left;
        }

        .social-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
            color: #666;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            max-width: 550px;
        }

        .social-divider::before,
        .social-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ddd;
        }

        .social-divider::before {
            margin-right: 1.5rem;
        }

        .social-divider::after {
            margin-left: 1.5rem;
        }

        .social-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin: 0 0 1.5rem;
            max-width: 550px;
        }

        .btn-social {
            width: 100%;
            max-width: 550px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            padding: 0;
            height: 48px;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.2s;
            text-decoration: none;
            overflow: hidden;
        }

        .btn-social .icon-box {
            padding: 0;
            width: 46px;
            height: 100%;
            border-right: 1px solid rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-social .text-box {
            flex: 1;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-social:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-social:active {
            transform: translateY(0);
        }

        .btn-google {
            background: #df4930;
        }

        .btn-facebook {
            background: #507cc0;
        }

        .btn-social:hover {
            opacity: 0.9;
        }

        .btn-social svg {
            width: 20px;
            height: 20px;
            fill: white;
            transition: all 0.3s ease;
            display: block;
        }

        .error-message {
            color: #bf0000;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .login-link {
            display: block;
            margin-top: 2rem;
            font-size: 0.95rem;
            color: #333;
            text-align: center;
        }

        .login-link a {
            color: #28a745;
            font-weight: bold;
            text-decoration: none;
        }

        input[type="checkbox"] {
            accent-color: #ff4e00;
            width: 1.1rem;
            height: 1.1rem;
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .search-container {
                display: none;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        .iti {
            width: 100%;
            max-width: 100%;
        }
        .alert-error {
            background-color: #fff5f5;
            color: #bf0000;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            max-width: 550px;
        }

        .alert-error svg {
            flex-shrink: 0;
        }
    </style>
@endpush

@section('content')

    <div class="breadcrumb" style="padding: 1rem 4rem; margin-bottom: 0;">
        Accueil > Inscription
    </div>

    <main class="main-content">

        <h1 class="page-title">Création de compte</h1>

        @if(session('error'))
            <div class="alert-error" style="margin: 0 auto 1.5rem 0;">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="register-card">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-section-wrapper">
                    <!-- Section: Informations d'authentification -->
                    <h2 class="section-title">Informations d'authentification</h2>
    
                    <div class="form-group">
                        <div class="input-container email-container">
                            <input type="email" id="email" name="email" placeholder=" " class="form-input-box" value="{{ old('email') }}"
                                required>
                            <label class="floating-label">E-mail</label>
                            <span id="email-icon" class="email-icon"></span>
                        </div>
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="input-container email-container">
                            <input type="email" id="email_confirmation" name="email_confirmation" placeholder=" " class="form-input-box"
                                required>
                            <label class="floating-label">Confirmer votre e-mail</label>
                            <span id="email-confirm-icon" class="email-icon"></span>
                        </div>
                        <div id="email-error" class="error-message" style="display: none;">Veuillez entrer votre adresse e-mail.</div>
                    </div>

                    <div class="form-group">
                        <div class="password-container">
                            <input type="password" id="password" name="password" placeholder=" " class="form-input-box"
                                required>
                            <label class="floating-label">Mot de passe</label>
                            <span class="toggle-password" onclick="togglePassword()">
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <ul class="password-requirements">
                            <li id="req-length" class="invalid">Entre 8 et 18 caractères</li>
                            <li id="req-uppercase" class="invalid">Au moins une majuscule</li>
                            <li id="req-lowercase" class="invalid">Au moins une minuscule</li>
                            <li id="req-number" class="invalid">Au moins un chiffre</li>
                        </ul>
                    </div>
    
                    <!-- Section: Informations personnelles -->
                    <hr style="border: 0; border-top: 1px solid #f0f0f0; margin: 1.5rem 0 0.5rem 0; width: 100%;">
                    <h2 class="section-title">Informations personnelles</h2>
    
                    <div class="form-group">
                        <div class="input-container">
                            <input type="text" name="prenom" placeholder=" " class="form-input-box" value="{{ old('prenom') }}" style="text-transform: capitalize;"
                                required>
                            <label class="floating-label">Prénom</label>
                        </div>
                        @error('prenom')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="form-group">
                        <div class="input-container">
                            <input type="text" name="nom" placeholder=" " class="form-input-box" value="{{ old('nom') }}" style="text-transform: capitalize;"
                                required>
                            <label class="floating-label">Nom</label>
                        </div>
                        @error('nom')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="form-group">
                        <div class="input-container" style="max-width: 300px;">
                            <select id="nationalite" name="nationalite" class="form-input-box" required
                                style="padding-top: 1.2rem; padding-bottom: 0.1rem; appearance: none; cursor: pointer;">
                                <option value="" disabled selected></option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->name }}" data-code="{{ strtolower($country->code) }}" {{ old('nationalite') == $country->name ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="floating-label">Nationalité</label>
                            <!-- dropdown arrow -->
                            <svg style="position:absolute; right:0.75rem; top:50%; transform:translateY(-50%); pointer-events:none; color:#666;" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                        @error('nationalite')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="form-group">
                        <div class="phone-container">
                            <input type="tel" id="telephone" name="telephone" placeholder=" " class="form-input-box"
                                value="{{ old('telephone') }}" required>
                            <label id="phone-floating-label" class="floating-label" style="left: 3.5rem;">Téléphone</label>
                            <span id="phone-icon" class="phone-icon"></span>
                        </div>
                        <!-- Hidden input to store full number with country code -->
                        <input type="hidden" name="full_telephone" id="full_telephone">
                        <div id="phone-error" class="error-message" style="display: none;"></div>
                        @error('telephone')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="form-group">
                        <div class="input-container" style="max-width: 300px; position: relative;">
                            <textarea name="adresse" placeholder=" " class="form-input-box"
                                style="height: 80px; resize: vertical; padding-top: 1.5rem;"
                                required>{{ old('adresse') }}</textarea>
                            <label class="floating-label" style="top: 1rem; transform: none;">Adresse complète</label>
                        </div>
                        @error('adresse')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr style="border: 0; border-top: 1px solid #f0f0f0; margin: 1.5rem 0; width: 100%;">

                <div class="form-group" style="font-size: 0.8rem; line-height: 1.4; color: #555; margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: flex-start; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="terms_accepted" required style="margin-top: 3px;">
                        <span>En créant mon compte je déclare avoir lu et accepté les <a href="#" style="color: #0066c0; text-decoration: underline;">Conditions d'utilisation Karnou</a> et <br> la <a href="#" style="color: #0066c0; text-decoration: underline;">politique Vie privée et Cookies</a>.</span>
                    </label>
                </div>


                <div style="text-align: center;">
                    <button type="submit" class="btn-black">
                        Créer un compte
                    </button>
                </div>

                <!-- Social Login Section -->
                <div class="social-login-section">
                    <div class="social-divider">ou</div>
                    <div class="social-buttons">
                        <a href="{{ route('social.redirect', ['provider' => 'google', 'action' => 'register']) }}" class="btn-social btn-google">
                            <div class="icon-box">
                                <svg viewBox="0 0 24 24">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                </svg>
                            </div>
                            <div class="text-box">
                                <span>S'inscrire avec Google</span>
                            </div>
                        </a>
                        <a href="{{ route('social.redirect', ['provider' => 'facebook', 'action' => 'register']) }}" class="btn-social btn-facebook">
                            <div class="icon-box">
                                <svg viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </div>
                            <div class="text-box">
                                <span>S'inscrire avec Facebook</span>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="login-link">
                    Déjà inscrit ? <a href="{{ route('login') }}">Connectez-vous</a>
                </div>
            </form>
        </div>
    </main>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.querySelector("#telephone");
            var fullPhoneInput = document.querySelector("#full_telephone");
            var nationaliteSelect = document.querySelector("select[name='nationalite']");
            
            // Logic to update phone country based on selected nationality
            nationaliteSelect.addEventListener('change', function() {
                var selectedOption = this.options[this.selectedIndex];
                var countryCode = selectedOption.getAttribute('data-code');
                
                if (countryCode) {
                    iti.setCountry(countryCode);
                }
            });
            
            var iti = window.intlTelInput(input, {
                initialCountry: "cf", // Default to Central African Republic
                // List of African countries ISO codes + France
                onlyCountries: [
                    "fr", // France
                    "dz", "ao", "bj", "bw", "bf", "bi", "cm", "cv", "cf", "td", "km", "cg", "cd", "ci", 
                    "dj", "eg", "gq", "er", "sz", "et", "ga", "gm", "gh", "gn", "gw", "ke", "ls", "lr", 
                    "ly", "mg", "mw", "ml", "mr", "mu", "ma", "mz", "na", "ne", "ng", "rw", "st", "sn", 
                    "sc", "sl", "so", "za", "ss", "sd", "tz", "tg", "tn", "ug", "zm", "zw"
                ],
                preferredCountries: ['cf', 'fr', 'cm', 'td', 'cg', 'ga'], // Central Africa + France prioritized
                nationalMode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            // Floating label for phone field (intl-tel-input wraps input, so CSS sibling selectors don't work)
            const phoneLabel = document.getElementById('phone-floating-label');
            function floatPhoneLabel(up) {
                if (up) {
                    phoneLabel.style.top = '0.4rem';
                    phoneLabel.style.fontSize = '0.7rem';
                    phoneLabel.style.color = '#888';
                    phoneLabel.style.transform = 'none';
                } else {
                    phoneLabel.style.top = '50%';
                    phoneLabel.style.fontSize = '0.9rem';
                    phoneLabel.style.color = '#999';
                    phoneLabel.style.transform = 'translateY(-50%)';
                }
            }
            input.addEventListener('focus', function() { floatPhoneLabel(true); });
            input.addEventListener('blur', function() { if (!input.value.trim()) floatPhoneLabel(false); });
            input.addEventListener('input', function() { floatPhoneLabel(true); });
            // Keep floated if there's a value (e.g. on back navigation)
            if (input.value.trim()) floatPhoneLabel(true);

            // Sync nationality selection with phone country code
            nationaliteSelect.addEventListener('change', function() {
                const selectedCountry = this.value;
                const countryCode = countryMapping[selectedCountry];
                
                if (countryCode) {
                    iti.setCountry(countryCode);
                }
            });

            // Validate phone number
            const phoneError = document.getElementById('phone-error');
            const phoneIcon = document.getElementById('phone-icon');
            
            // Auto-format phone number with spaces
            function formatPhoneNumber() {
                // Just clean the input - intl-tel-input handles the rest with separateDialCode
                let value = input.value;
                
                // Remove any non-digit characters except spaces
                let cleaned = value.replace(/[^\d\s]/g, '');
                
                // Remove leading zeros
                cleaned = cleaned.replace(/^0+/, '');
                
                input.value = cleaned;
            }
            
            function validatePhoneNumber() {
                const phoneValue = input.value.trim();
                
                if (!phoneValue) {
                    input.classList.remove('valid', 'invalid');
                    phoneIcon.className = 'phone-icon';
                    phoneError.style.display = 'none';
                    return;
                }

                if (iti.isValidNumber()) {
                    input.classList.add('valid');
                    input.classList.remove('invalid');
                    phoneIcon.className = 'phone-icon valid';
                    phoneIcon.innerHTML = '✓';
                    phoneError.style.display = 'none';
                } else {
                    input.classList.add('invalid');
                    input.classList.remove('valid');
                    phoneIcon.className = 'phone-icon invalid';
                    phoneIcon.innerHTML = '✕';
                    phoneError.textContent = 'Numéro invalide';
                    phoneError.style.display = 'block';
                }
            }

            // Format on input
            input.addEventListener('input', function() {
                formatPhoneNumber();
                validatePhoneNumber();
            });
            
            input.addEventListener('blur', validatePhoneNumber);
            input.addEventListener('countrychange', function() {
                formatPhoneNumber();
                validatePhoneNumber();
            });

            // Update hidden input on submit
            var form = input.closest('form');
            form.addEventListener('submit', function() {
                fullPhoneInput.value = iti.getNumber();
            });
            
            // Or on change
             input.addEventListener('change', function() {
                fullPhoneInput.value = iti.getNumber();
            });
            
             input.addEventListener('keyup', function() {
                fullPhoneInput.value = iti.getNumber();
            });

            // Email confirmation validation
            const emailInput = document.getElementById('email');
            const emailConfirmInput = document.getElementById('email_confirmation');
            const emailError = document.getElementById('email-error');
            const emailIcon = document.getElementById('email-icon');
            const emailConfirmIcon = document.getElementById('email-confirm-icon');

            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            function validateEmailConfirmation() {
                const email = emailInput.value;
                const emailConfirm = emailConfirmInput.value;

                // Validate main email field
                if (email === '') {
                    emailInput.classList.remove('valid', 'invalid');
                    emailIcon.className = 'email-icon';
                } else if (isValidEmail(email)) {
                    emailInput.classList.add('valid');
                    emailInput.classList.remove('invalid');
                    emailIcon.className = 'email-icon valid';
                    emailIcon.innerHTML = '✓';
                } else {
                    emailInput.classList.add('invalid');
                    emailInput.classList.remove('valid');
                    emailIcon.className = 'email-icon invalid';
                    emailIcon.innerHTML = '✕';
                }

                // Validate confirmation email field
                if (emailConfirm === '') {
                    emailConfirmInput.classList.remove('valid', 'invalid');
                    emailConfirmIcon.className = 'email-icon';
                    emailError.style.display = 'none';
                    return;
                }

                if (email === emailConfirm && email !== '' && isValidEmail(email)) {
                    emailConfirmInput.classList.add('valid');
                    emailConfirmInput.classList.remove('invalid');
                    emailConfirmIcon.className = 'email-icon valid';
                    emailConfirmIcon.innerHTML = '✓';
                    emailError.style.display = 'none';
                    
                    // Also update main email if it matches
                    emailInput.classList.add('valid');
                    emailInput.classList.remove('invalid');
                } else {
                    emailConfirmInput.classList.add('invalid');
                    emailConfirmInput.classList.remove('valid');
                    emailConfirmIcon.className = 'email-icon invalid';
                    emailConfirmIcon.innerHTML = '✕';
                    emailError.textContent = 'Veuillez entrer votre adresse e-mail.';
                    emailError.style.display = 'block';
                    
                    // Also mark main email as invalid if they don't match
                    if (email !== emailConfirm && email !== '') {
                        emailInput.classList.add('invalid');
                        emailInput.classList.remove('valid');
                        emailIcon.className = 'email-icon invalid';
                        emailIcon.innerHTML = '✕';
                    }
                }
            }

            emailInput.addEventListener('input', validateEmailConfirmation);
            emailConfirmInput.addEventListener('input', validateEmailConfirmation);

            // Password validation
            const passwordInput = document.getElementById('password');
            const reqLength = document.getElementById('req-length');
            const reqUppercase = document.getElementById('req-uppercase');
            const reqLowercase = document.getElementById('req-lowercase');
            const reqNumber = document.getElementById('req-number');

            function validatePassword() {
                const password = passwordInput.value;

                // Check length (8-18 characters)
                if (password.length >= 8 && password.length <= 18) {
                    reqLength.classList.remove('invalid');
                } else {
                    reqLength.classList.add('invalid');
                }

                // Check uppercase
                if (/[A-Z]/.test(password)) {
                    reqUppercase.classList.remove('invalid');
                } else {
                    reqUppercase.classList.add('invalid');
                }

                // Check lowercase
                if (/[a-z]/.test(password)) {
                    reqLowercase.classList.remove('invalid');
                } else {
                    reqLowercase.classList.add('invalid');
                }

                // Check number
                if (/[0-9]/.test(password)) {
                    reqNumber.classList.remove('invalid');
                } else {
                    reqNumber.classList.add('invalid');
                }

                // Update border color
                const allValid = password.length >= 8 && password.length <= 18 &&
                                /[A-Z]/.test(password) &&
                                /[a-z]/.test(password) &&
                                /[0-9]/.test(password);

                if (password === '') {
                    passwordInput.classList.remove('valid', 'invalid');
                } else if (allValid) {
                    passwordInput.classList.add('valid');
                    passwordInput.classList.remove('invalid');
                } else {
                    passwordInput.classList.add('invalid');
                    passwordInput.classList.remove('valid');
                }
            }

            passwordInput.addEventListener('input', validatePassword);
        });

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
@endpush