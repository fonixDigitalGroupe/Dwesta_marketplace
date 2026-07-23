@extends('layouts.app')

@section('title', 'Vérification du compte - Karnou')

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body, .page-wrapper, main {
            background-color: #ffffff !important;
            font-family: 'Inter', -apple-system, sans-serif !important;
        }

        .main-content {
            padding: 0;
        }

        .auth-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 1rem 1rem 1rem;
        }

        .otp-card {
            background: #fff;
            padding: 2.5rem;
            border: none;
            border-radius: 0;
            width: 100%;
            max-width: 450px;
            margin: 3rem auto;
            box-shadow: 8px 0 15px -10px rgba(0,0,0,0.05);
            text-align: center;
        }

        .otp-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            color: #000;
            text-align: center;
        }

        .otp-subtitle {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.5;
            text-align: center;
        }

        .otp-input-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .otp-digit {
            width: 56px;
            height: 50px;
            font-size: 1.75rem;
            font-weight: 700;
            text-align: center;
            border: 2px solid #e1e4e8;
            border-radius: 12px;
            outline: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            color: #1a1a1a;
            background-color: #ffffff;
        }

        .otp-digit:focus {
            border-color: #f68b1e;
            box-shadow: none;
            background-color: #fff;
            transform: translateY(-2px);
        }

        .btn-verify {
            width: 100%;
            background-color: #004aad;
            color: #fff;
            border: none;
            padding: 1rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            letter-spacing: 0.3px;
        }

        .btn-verify:hover {
            background-color: #003a8a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,74,173,0.15);
        }

        .breadcrumbs {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .breadcrumbs a {
            color: #666;
            text-decoration: none;
        }

        .breadcrumbs span {
            margin: 0 0.4rem;
        }

        .resend-container {
            font-size: 0.9rem;
            color: #666;
        }

        .resend-link {
            color: #f68b1e;
            text-decoration: none;
            font-weight: 600;
        }

        .resend-link:hover {
            text-decoration: underline;
        }

        .alert {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: #f0f9f1;
            color: #2b7a32;
            border: 1px solid #d4edda;
        }

        .alert-danger {
            background-color: #fff5f5;
            color: #bf0000;
            border: 1px solid #f8d7da;
        }

        @media (max-width: 768px) {
            html, body {
                overflow-x: hidden !important;
                position: relative;
                width: 100%;
                -webkit-text-size-adjust: 100%;
            }
            .auth-wrapper {
                padding: 1rem 0.5rem;
                width: 100%;
                overflow-x: hidden;
            }
            .otp-card {
                padding: 1.5rem 1rem !important;
                max-width: none !important;
                border-radius: 0;
                border-left: none;
                border-right: none;
                box-shadow: none;
                width: 100%;
                box-sizing: border-box;
            }
            .otp-title {
                font-size: 1.25rem;
            }
            .otp-input-container {
                gap: 0.5rem;
                margin-left: auto;
                margin-right: auto;
                width: fit-content;
            }
            .otp-digit {
                width: clamp(42px, 15vw, 55px);
                height: clamp(52px, 18vw, 65px);
                font-size: 1.25rem;
                /* Prevent zoom on focus for some browsers by keeping font-size >= 16px */
            }
        }
    </style>
@endpush

@section('content')
    <main class="main-content">
        <div class="auth-wrapper">
            <nav class="breadcrumbs">
                <a href="/">Accueil</a>
                <span>&gt;</span>
                <a href="{{ route('register') }}">Inscription</a>
                <span>&gt;</span>
                <span>Vérification</span>
            </nav>
            <div class="otp-card">
            <h1 class="otp-title">
                Vérifiez votre {{ $regInfo['email'] ? 'e-mail' : 'téléphone' }}
            </h1>
            <p class="otp-subtitle">
                Nous avons envoyé un code de vérification à 4 chiffres 
                {{ $regInfo['email'] ? 'à l\'adresse' : 'au numéro' }} 
                <strong>{{ $regInfo['email'] ?? $regInfo['telephone'] }}</strong>. 
                Veuillez le saisir ci-dessous pour activer votre compte.
            </p>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('otp.verify.post') }}" method="POST" id="otp-form">
                @csrf
                <div class="otp-input-container">
                    <input type="text" name="otp[]" class="otp-digit" maxlength="1" pattern="\d*" inputmode="numeric" required autofocus>
                    <input type="text" name="otp[]" class="otp-digit" maxlength="1" pattern="\d*" inputmode="numeric" required>
                    <input type="text" name="otp[]" class="otp-digit" maxlength="1" pattern="\d*" inputmode="numeric" required>
                    <input type="text" name="otp[]" class="otp-digit" maxlength="1" pattern="\d*" inputmode="numeric" required>
                </div>

                <button type="submit" class="btn-verify">Vérifier mon compte</button>
            </form>

            <div class="resend-container">
                Vous n'avez pas reçu le code ? 
                <form action="{{ route('otp.resend') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="resend-link" style="background: none; border: none; padding: 0; cursor: pointer; font: inherit;">
                        Renvoyer un code
                    </button>
                </form>
            </div>
            </div> <!-- end otp-card -->
        </div> <!-- end auth-wrapper -->
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-digit');
            const form = document.getElementById('otp-form');

            inputs.forEach((input, index) => {
                // Gestion de la saisie
                input.addEventListener('input', (e) => {
                    if (e.target.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                });

                // Gestion du retour arrière
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });

                // Gestion du coller
                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const pasteData = e.clipboardData.getData('text').slice(0, 4);
                    if (/^\d{4}$/.test(pasteData)) {
                        pasteData.split('').forEach((char, i) => {
                            if (inputs[i]) {
                                inputs[i].value = char;
                            }
                        });
                        inputs[3].focus();
                    }
                });
            });
        });
    </script>
@endpush
