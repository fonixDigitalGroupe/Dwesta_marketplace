@extends('layouts.app')

@section('title', 'Connexion - Mady Market')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        .iti { width: 100%; }
        .form-input-box { background-color: #ffffff; }



        /* Main Content */
        .main-content {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .breadcrumb {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 2rem;
            margin-left: 1rem;
            margin-top: 1rem;
        }

        .breadcrumb a {
            color: #666;
            text-decoration: none;
        }

        /* Two Column Layout */
        .login-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
            margin-left: 1rem;
        }

        @media (max-width: 1024px) {
            .header-container {
                gap: 1rem;
            }

            .search-container {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .login-grid {
                grid-template-columns: 1fr;
            }
        }

        .auth-card {
            background: white;
            padding: 2.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
        }

        .auth-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-input-box {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            outline: none;
        }

        .form-input-box:focus {
            border-color: #ff4e00;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }

        .forgot-password {
            display: block;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #0066cc;
            text-decoration: none;
        }

        .btn-black {
            width: auto;
            min-width: 150px;
            background: #000;
            color: white;
            border: none;
            padding: 0.5rem 2rem;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 1.5rem;
            transition: background 0.2s;
        }

        .btn-black:hover {
            background: #333;
        }

        /* New Client Section */
        .new-client-card {
            background: white;
            padding: 1.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            height: auto;
            max-width: 350px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .new-client-card .btn-black {
            margin-top: 0.5rem;
        }

        .error-message {
            color: #bf0000;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        /* Footer info style Rakuten */
        .footer-benefits {
            margin-top: 4rem;
            display: flex;
            justify-content: space-around;
            border-top: 1px solid #e0e0e0;
            padding-top: 2rem;
            text-align: center;
        }

        .benefit-item {
            flex: 1;
            padding: 0 1rem;
        }

        .benefit-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .benefit-title {
            font-weight: bold;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .benefit-desc {
            font-size: 0.8rem;
            color: #666;
        }
        /* Social Login Buttons */
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
            max-width: 100%;
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
            max-width: 100%;
        }

        .btn-social {
            width: 100%;
            display: flex;
            align-items: center;
            padding: 0;
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
            padding: 0.6rem 0.8rem;
            border-right: 1px solid rgba(255,255,255,0.2);
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

        .btn-social svg {
            width: 18px;
            height: 18px;
            fill: white;
        }
    </style>
@endpush

@section('content')

    <main class="main-content">
        <div class="breadcrumb">
            Accueil > Identification
        </div>

        <div class="login-grid">
            <!-- Left Column: Existing Customer -->
            <div class="auth-card">

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group" x-data="{ loginType: 'email' }">
                        <div class="input-container" style="position: relative;">
                            <!-- Email Input -->
                            <input x-show="loginType === 'email'" type="text" name="login_email" id="login_email" 
                                placeholder="E-mail ou pseudo" class="form-input-box"
                                value="{{ old('login') }}" 
                                style="padding-right: 50px;"
                                :required="loginType === 'email'"
                                :name="loginType === 'email' ? 'login' : ''">
                            
                            <!-- Phone Input -->
                            <div x-show="loginType === 'phone'" style="display: none;" x-effect="if(loginType === 'phone') $el.style.display = 'block'">
                                <input type="tel" id="login_phone" class="form-input-box" 
                                    style="width: 100%; padding-right: 50px;"
                                    :required="loginType === 'phone'">
                                <input type="hidden" name="login" id="full_login_phone" :disabled="loginType !== 'phone'">
                            </div>

                            <!-- Toggle Icon -->
                            <div class="toggle-icon" @click="loginType = (loginType === 'email' ? 'phone' : 'email'); $nextTick(() => { if(loginType === 'phone') initPhone(); })" 
                                style="position: absolute; right: 0; top: 0; bottom: 0; width: 45px; display: flex; align-items: center; justify-content: center; border-left: 1px solid #ccc; cursor: pointer; color: #666; border-radius: 0 4px 4px 0;"
                                :title="loginType === 'email' ? 'Se connecter avec un numéro' : 'Se connecter avec un email'">
                                
                                <!-- Show Phone icon when in Email mode -->
                                <svg x-show="loginType === 'email'" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>

                                <!-- Show Email icon when in Phone mode -->
                                <svg x-show="loginType === 'phone'" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('login')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group password-container">
                        <input type="password" id="password" name="password" placeholder="Mot de passe"
                            class="form-input-box" required>
                        <span class="toggle-password" onclick="togglePassword()">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd"
                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <a href="#" class="forgot-password">J'ai oublié mon mot de passe</a>

                    <button type="submit" class="btn-black">
                        Me connecter
                    </button>

                    <!-- Social Login Section -->
                    <div class="social-login-section">
                        <div class="social-divider">ou</div>
                        <div class="social-buttons">
                            <a href="#" class="btn-social btn-google">
                                <div class="icon-box">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                                    </svg>
                                </div>
                                <div class="text-box">
                                    <span>Se connecter avec Google</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Column: New Customer -->
            <div class="new-client-card">
                <h2 class="auth-title">Nouveau client ?</h2>
                <a href="{{ route('register') }}" style="text-decoration: none;">
                    <button type="button" class="btn-black">
                        Continuer
                    </button>
                </a>
            </div>
        </div>

        </div>
    </main>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }

        let iti = null;

        function initPhone() {
            if (iti) return;
            
            const input = document.querySelector("#login_phone");
            const fullPhoneInput = document.querySelector("#full_login_phone");
            
            iti = window.intlTelInput(input, {
                initialCountry: "cf",
                onlyCountries: [
                    "fr", "dz", "ao", "bj", "bw", "bf", "bi", "cm", "cv", "cf", "td", "km", "cg", "cd", "ci", 
                    "dj", "eg", "gq", "er", "sz", "et", "ga", "gm", "gh", "gn", "gw", "ke", "ls", "lr", 
                    "ly", "mg", "mw", "ml", "mr", "mu", "ma", "mz", "na", "ne", "ng", "rw", "st", "sn", 
                    "sc", "sl", "so", "za", "ss", "sd", "tz", "tg", "tn", "ug", "zm", "zw"
                ],
                preferredCountries: ['cf', 'fr', 'cm', 'td', 'cg', 'ga'],
                nationalMode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            input.addEventListener('input', function() {
                // Formatting basic cleaning
                let value = input.value.replace(/[^\d\s]/g, '').replace(/^0+/, '');
                input.value = value;
                fullPhoneInput.value = iti.getNumber();
            });

            input.addEventListener('countrychange', function() {
                fullPhoneInput.value = iti.getNumber();
            });
        }
    </script>
@endpush