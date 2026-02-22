@extends('layouts.app')

@section('title', 'Réinitialisation du mot de passe - Mady Market')

@push('styles')
    <style>
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

        .auth-card {
            background: white;
            padding: 1.5rem 2.5rem 2.5rem 2.5rem;
            border: 1px solid #f0f0f0;
            border-left: none !important;
            border-top: none !important;
            border-radius: 0 0 8px 0 !important;
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.02);
            max-width: 450px;
        }

        .auth-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .input-container {
            position: relative;
        }

        .form-input-box {
            width: 100%;
            padding: 1rem 0.6rem 0.25rem 0.6rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-input-box:focus {
            border-color: #ff4e00;
        }

        .floating-label {
            position: absolute;
            left: 0.6rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1rem;
            transition: all 0.2s ease-out;
            pointer-events: none;
            z-index: 10;
        }

        .form-input-box:focus + .floating-label,
        .form-input-box:not(:placeholder-shown) + .floating-label {
            top: 0.35rem;
            transform: translateY(0);
            font-size: 0.75rem;
            color: #888;
        }

        .btn-black {
            width: 100%;
            background: #000;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            transition: opacity 0.2s;
            margin-top: 1rem;
        }

        .btn-black:hover {
            opacity: 0.8;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .back-to-login {
            display: block;
            margin-top: 1.5rem;
            text-align: left;
            font-size: 0.9rem;
            color: #0066cc;
            text-decoration: none;
        }
    </style>
@endpush

@section('content')
    <div class="breadcrumb" style="padding: 1rem 4rem; margin-bottom: 0;">
        Accueil > Mot de passe oublié
    </div>

    <main class="main-content">
        <div style="margin-left: 1rem;">
            <div class="auth-card">
                <h2 class="auth-title">Réinitialiser le mot de passe</h2>

            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @endif

            <p style="font-size: 0.9rem; color: #666; margin-bottom: 1.5rem;">
                Entrez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.
            </p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <div class="input-container">
                        <input type="email" name="email" id="email" 
                            placeholder=" " class="form-input-box"
                            value="{{ old('email') }}" required autofocus>
                        <label class="floating-label">E-mail</label>
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-black">
                    Envoyer le lien de réinitialisation
                </button>
            </form>

            <a href="{{ route('login') }}" class="back-to-login">Retour à la connexion</a>
            </div>
        </div>
    </main>
@endsection
