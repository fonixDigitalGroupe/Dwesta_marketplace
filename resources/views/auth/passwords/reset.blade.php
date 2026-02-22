@extends('layouts.app')

@section('title', 'Nouveau mot de passe - Mady Market')

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
            padding: 1rem 2.5rem 0.25rem 0.6rem;
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

        .toggle-password {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #999;
            display: flex;
            align-items: center;
            padding: 0;
            z-index: 20;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #ff4e00;
        }

        .toggle-password svg {
            width: 18px;
            height: 18px;
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

        .error-message {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }
    </style>
@endpush

@section('content')
    <div class="breadcrumb" style="padding: 1rem 4rem; margin-bottom: 0;">
        Accueil > Réinitialisation du mot de passe
    </div>

    <main class="main-content">
        <div style="margin-left: 1rem;">
            <div class="auth-card">
                <h2 class="auth-title">Nouveau mot de passe</h2>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <div class="input-container">
                        <input type="email" name="email" id="email" 
                            placeholder=" " class="form-input-box"
                            value="{{ $email ?? old('email') }}" required autofocus>
                        <label class="floating-label">E-mail</label>
                    </div>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-container">
                        <input type="password" name="password" id="password" 
                            placeholder=" " class="form-input-box" required>
                        <label class="floating-label">Nouveau mot de passe</label>
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)" tabindex="-1" aria-label="Afficher le mot de passe">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="input-container">
                        <input type="password" name="password_confirmation" id="password-confirm" 
                            placeholder=" " class="form-input-box" required>
                        <label class="floating-label">Confirmez le mot de passe</label>
                        <button type="button" class="toggle-password" onclick="togglePassword('password-confirm', this)" tabindex="-1" aria-label="Afficher le mot de passe">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-black">
                    Enregistrer le nouveau mot de passe
                </button>
            </form>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        btn.innerHTML = isPassword
            ? `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88L6.59 6.59m7.532 7.532l3.29 3.29M3 3l18 18" />
               </svg>`
            : `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
               </svg>`;
    }
</script>
@endpush
