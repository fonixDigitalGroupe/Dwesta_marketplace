@extends('layouts.app')

@section('title', 'Connexion - Mady Market')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        body,
        .page-wrapper,
        main {
            background-color: #f8f9fa !important;
        }

        .iti {
            width: 100%;
        }

        /* Main Content */
        .main-content {
            min-height: calc(100vh - 150px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .auth-container {
            width: 100%;
            max-width: 450px;
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-logo img {
            max-height: 50px;
        }

        .auth-card {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #eaeaea;
        }

        .auth-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-align: center;
            color: #333;
        }

        .auth-subtitle {
            font-size: 0.95rem;
            color: #666;
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .input-container {
            position: relative;
        }

        .form-input-box {
            width: 100%;
            padding: 1.25rem 1rem 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: all 0.2s;
            background: #fff;
        }

        .form-input-box:focus {
            border-color: #004aad;
            box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.1);
        }

        .floating-label {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1rem;
            transition: all 0.2s ease-out;
            pointer-events: none;
            z-index: 10;
        }

        .form-input-box:focus+.floating-label,
        .form-input-box:not(:placeholder-shown)+.floating-label,
        .iti:focus-within+.floating-label {
            top: 0.6rem;
            transform: translateY(0);
            font-size: 0.75rem;
            color: #004aad;
            font-weight: 600;
        }

        /* Specific for intl-tel-input */
        .iti+.floating-label {
            left: 3.5rem;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            z-index: 11;
        }

        .forgot-password {
            display: block;
            text-align: right;
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: #004aad;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-primary-karnou {
            width: 100%;
            background: #004aad;
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 1.5rem;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(0, 74, 173, 0.2);
        }

        .btn-primary-karnou:hover {
            background: #003a8c;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(0, 74, 173, 0.3);
        }

        .btn-primary-karnou:active {
            transform: translateY(0);
        }

        /* Social Login */
        .social-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 2rem 0;
            color: #999;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .social-divider::before,
        .social-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #eee;
        }

        .social-divider::before {
            margin-right: 1rem;
        }

        .social-divider::after {
            margin-left: 1rem;
        }

        .social-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn-social {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.85rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            color: #333;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            gap: 0.75rem;
        }

        .btn-social:hover {
            background: #fcfcfc;
            border-color: #bbb;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .btn-social svg {
            width: 20px;
            height: 20px;
        }

        .auth-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.95rem;
            color: #666;
        }

        .auth-footer a {
            color: #004aad;
            font-weight: 700;
            text-decoration: none;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .alert-error {
            background-color: #fff5f5;
            color: #bf0000;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border: 1px solid #ffcccc;
        }
    </style>
@endpush

@section('content')
    <main class="main-content">
        <div class="auth-container">
            <div class="auth-logo">
                <a href="/">
                    <img src="{{ asset('storage/logo-karnou.png') }}" alt="Karnou" onerror="this.src='/images/logo.png'">
                </a>
            </div>

            <div class="auth-card">
                <h1 class="auth-title">Bon retour !</h1>
                <p class="auth-subtitle">Connectez-vous à votre compte Karnou</p>

                @if(session('error'))
                    <div class="alert-error">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="social-buttons" style="margin-bottom: 0;">
                        <a href="{{ route('social.redirect', ['provider' => 'google', 'action' => 'login']) }}"
                            class="btn-social">
                            <svg viewBox="0 0 24 24">
                                <path fill="#4285F4"
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="#34A853"
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="#FBBC05"
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                <path fill="#EA4335"
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                            </svg>
                            <span>Continuer avec Google</span>
                        </a>

                        <a href="{{ route('social.redirect', ['provider' => 'facebook', 'action' => 'login']) }}"
                            class="btn-social">
                            <svg viewBox="0 0 24 24" fill="#1877F2">
                                <path
                                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                            <span>Continuer avec Facebook</span>
                        </a>
                    </div>

                    <div class="social-divider">ou</div>

                    <div class="form-group" x-data="{ loginType: 'email' }">
                        <div class="input-container">
                            <!-- Email Input -->
                            <input x-show="loginType === 'email'" type="text" name="login_email" id="login_email"
                                placeholder=" " class="form-input-box" value="{{ old('login') }}"
                                :required="loginType === 'email'" :name="loginType === 'email' ? 'login' : ''">
                            <label class="floating-label" x-show="loginType === 'email'">E-mail ou pseudo</label>

                            <!-- Phone Input -->
                            <div x-show="loginType === 'phone'" style="display: none;"
                                x-effect="if(loginType === 'phone') $el.style.display = 'block'">
                                <div class="input-container">
                                    <input type="tel" id="login_phone" class="form-input-box" placeholder=" ">
                                    <label class="floating-label">Téléphone</label>
                                    <input type="hidden" name="login" id="full_login_phone"
                                        :disabled="loginType !== 'phone'">
                                </div>
                            </div>

                            <!-- Toggle Icon -->
                            <div class="toggle-icon"
                                @click="loginType = (loginType === 'email' ? 'phone' : 'email'); $nextTick(() => { if(loginType === 'phone') initPhone(); })"
                                style="position: absolute; right: 1rem; top: 0.8rem; cursor: pointer; color: #004aad; font-weight: bold; font-size: 0.8rem; text-decoration: underline;"
                                :title="loginType === 'email' ? 'Utiliser téléphone' : 'Utiliser email'">
                                <span x-text="loginType === 'email' ? 'Utiliser téléphone' : 'Utiliser email'"></span>
                            </div>
                        </div>
                        @error('login')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="input-container">
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
                        <a href="{{ route('password.request') }}" class="forgot-password">Mot de passe oublié ?</a>
                    </div>

                    <button type="submit" class="btn-primary-karnou">
                        Continuer
                    </button>
                </form>
            </div>

            <div class="auth-footer">
                Nouveau sur Karnou ? <a href="{{ route('register') }}">Créer un compte</a>
            </div>
        </div>
    </main>

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
                initialCountry: "{{ $countries->first()->code ?? 'cf' }}",
                onlyCountries: @json($countries->pluck('code')->map(fn($c) => strtolower($c))),
                preferredCountries: [],
                nationalMode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            });

            input.addEventListener('input', function () {
                // Formatting basic cleaning
                let value = input.value.replace(/[^\d\s]/g, '').replace(/^0+/, '');
                input.value = value;
                fullPhoneInput.value = iti.getNumber();
            });

            input.addEventListener('countrychange', function () {
                fullPhoneInput.value = iti.getNumber();
            });
        }
    </script>
@endpush