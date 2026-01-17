@extends('layouts.app')

@section('title', 'Connexion - Mady Market')

@push('styles')
    <style>
        /* Banner - Boost livres style */
        .top-banner {
            background-color: #bf0000;
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
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .breadcrumb {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 2rem;
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
            padding: 0.85rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            outline: none;
        }

        .form-input-box:focus {
            border-color: #333;
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
            padding: 0.85rem 2rem;
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
            padding: 2.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
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

                    <div class="form-group">
                        <input type="text" name="login" placeholder="E-mail ou pseudo" class="form-input-box"
                            value="{{ old('login') }}" required autofocus>
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
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
@endpush