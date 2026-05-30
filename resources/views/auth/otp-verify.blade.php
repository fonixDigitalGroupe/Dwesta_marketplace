@extends('layouts.app')

@section('title', 'Vérification du compte - Karnou')

@push('styles')
    <style>
        body, .page-wrapper, main {
            background-color: #ffffff !important;
        }

        .main-content {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .otp-card {
            background: white;
            padding: 2.5rem;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
        }

        .otp-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #111;
        }

        .otp-subtitle {
            font-size: 0.95rem;
            color: #555;
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
            font-weight: bold;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .otp-digit:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .btn-verify {
            width: 100%;
            background: #0066c0;
            color: white;
            border: none;
            padding: 0.8rem;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            margin-bottom: 1.5rem;
        }

        .btn-verify:hover {
            background: #004aad;
        }

        .resend-container {
            font-size: 0.9rem;
            color: #666;
        }

        .resend-link {
            color: #0066c0;
            text-decoration: none;
            font-weight: 500;
        }

        .resend-link:hover {
            text-decoration: underline;
            color: #c45500;
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
    </style>
@endpush

@section('content')
    <main class="main-content">
        <div class="otp-card">
            <h1 class="otp-title">Vérifiez votre e-mail</h1>
            <p class="otp-subtitle">
                Nous avons envoyé un code de vérification à 4 chiffres à l'adresse <strong>{{ Auth::user()->email }}</strong>. 
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
        </div>
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
