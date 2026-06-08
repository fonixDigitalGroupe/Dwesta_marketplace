@extends('layouts.app')

@section('title', 'Vérification du compte - Karnou')

@push('styles')
    <style>
        body, .page-wrapper, main {
            background-color: #ffffff !important;
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
            border: 1px solid #f5f5f5;
            border-radius: 8px;
            width: 100%;
            max-width: 450px;
            margin: 0 auto;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
            text-align: center;
        }

        .otp-title {
            font-size: 1.35rem;
            font-weight: 700;
            margin-bottom: 1.25rem;
            color: #000;
        }

        .otp-subtitle {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        .otp-input-container {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .otp-digit {
            width: 50px;
            height: 60px;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .otp-digit:focus {
            border-color: #000;
            box-shadow: 0 0 0 2px rgba(0,0,0,0.04);
        }

        .btn-verify {
            width: 100%;
            background-color: #004aad;
            color: #fff;
            border: none;
            padding: 0.75rem;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 1.5rem;
        }

        .btn-verify:hover {
            background-color: #003a8a;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,74,173,0.15);
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
