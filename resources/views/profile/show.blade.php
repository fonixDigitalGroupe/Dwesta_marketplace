@extends('layouts.app')

@section('title', 'Mon Profil - Mady Market')

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Rakuten Style Forms */
        .rakuten-form-container {
            max-width: 600px;
            padding: 1rem 0;
            text-align: left;
        }

        .rakuten-title {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }

        .rakuten-radio-group {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .rakuten-radio-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .rakuten-radio-item input[type="radio"] {
            width: 18px;
            height: 18px;
            accent-color: #0076ad;
        }

        .rakuten-field-group {
            margin-bottom: 1rem;
            max-width: 320px;
        }

        .rakuten-field {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0.1rem 0.75rem;
            background: #fff;
            transition: border-color 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .rakuten-field:focus-within {
            border-color: #ff4e00;
        }

        .rakuten-label {
            display: block;
            font-size: 0.7rem;
            color: #888;
            margin-bottom: 0px;
            line-height: 1;
        }

        .rakuten-error-alert {
            background-color: #fff6f6;
            border: 1px solid #ff0000;
            color: #333;
            padding: 0.5rem 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.88rem;
            max-width: 100%;
            border-radius: 2px;
        }

        .rakuten-error-alert .error-icon {
            background-color: #ff0000;
            color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 12px;
            font-weight: bold;
        }

        .rakuten-success-alert {
            background-color: #f6fff6;
            border: 1px solid #00a650;
            color: #333;
            padding: 0.5rem 0.75rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.88rem;
            max-width: 100%;
            border-radius: 2px;
        }

        .rakuten-success-alert .success-icon {
            background-color: #00a650;
            color: #fff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 10px;
            font-weight: bold;
        }

        .rakuten-input {
            width: 100%;
            border: none;
            outline: none;
            font-size: 0.9rem;
            color: #333;
            padding: 0;
            background: transparent;
        }

        .btn-rakuten {
            background: #000;
            color: #fff;
            padding: 0.5rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-weight: 700;
            cursor: pointer;
            font-size: 1rem;
            margin: 1.25rem 0 2rem;
            width: 220px;
            transition: opacity 0.2s;
        }

        .btn-rakuten:hover {
            opacity: 0.85;
        }

        .password-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .eye-toggle {
            background: none;
            border: none;
            padding: 0;
            margin-left: 0.5rem;
            cursor: pointer;
            color: #888;
            display: flex;
            align-items: center;
            height: 100%;
        }

        .eye-toggle svg {
            width: 20px;
            height: 20px;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .content-header h1 {
            font-size: 1.5rem;
            color: #333;
            font-weight: 700;
        }
    </style>
@endpush

@section('content')
    <!-- Breadcrumb (Above sidebar) -->
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('profile.show') }}">Mon Compte</a> > <span>Mon Profil</span>
    </div>

    <div class="dashboard-container">
        @include('partials.profile-sidebar')
        <main class="main-content">

            <div class="content-header">
                <h1>Mes informations</h1>
            </div>

            <div class="rakuten-form-container">
                <h2 class="rakuten-title">Informations personnelles</h2>

                @if(session('success'))
                    <div class="rakuten-success-alert">
                        <div class="success-icon">✓</div>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="rakuten-error-alert">
                        <div class="error-icon">✕</div>
                        <span>
                            @if($errors->has('current_password_info'))
                                {{ $errors->first('current_password_info') }}
                            @else
                                {{ $errors->first() }}
                            @endif
                        </span>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="rakuten-radio-group">
                        <span style="color: #333;">Civilité :</span>
                        <label class="rakuten-radio-item">
                            <input type="radio" name="civilite" value="Madame" {{ old('civilite', $user->civilite) == 'Madame' ? 'checked' : '' }}>
                            Madame
                        </label>
                        <label class="rakuten-radio-item">
                            <input type="radio" name="civilite" value="Monsieur" {{ old('civilite', $user->civilite) == 'Monsieur' ? 'checked' : '' }}>
                            Monsieur
                        </label>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Prénom</label>
                            <input type="text" name="prenom" class="rakuten-input"
                                value="{{ old('prenom', $user->prenom) }}" required>
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Nom</label>
                            <input type="text" name="nom" class="rakuten-input" value="{{ old('nom', $user->nom) }}">
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Nationalité</label>
                            <input type="text" name="nationalite" class="rakuten-input"
                                value="{{ old('nationalite', $user->nationalite) }}">
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Tel</label>
                            <input type="tel" name="telephone" class="rakuten-input"
                                value="{{ old('telephone', $user->telephone) }}">
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">E-mail actuel</label>
                            <input type="email" name="email" class="rakuten-input" value="{{ old('email', $user->email) }}"
                                required>
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Mot de passe actuel</label>
                            <div class="password-container">
                                <input type="password" name="current_password_info"
                                    class="rakuten-input password-toggle-input">
                                <button type="button" class="eye-toggle" @click="togglePassword($event)">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-rakuten">Valider</button>
                </form>

                <h2 id="changement-mot-de-passe" class="rakuten-title">Changement de mot de passe</h2>
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Ancien mot de passe</label>
                            <div class="password-container">
                                <input type="password" name="current_password" class="rakuten-input password-toggle-input"
                                    required>
                                <button type="button" class="eye-toggle" @click="togglePassword($event)">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Nouveau mot de passe</label>
                            <div class="password-container">
                                <input type="password" name="password" class="rakuten-input password-toggle-input" required>
                                <button type="button" class="eye-toggle" @click="togglePassword($event)">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="rakuten-field-group">
                        <div class="rakuten-field">
                            <label class="rakuten-label">Confirmez votre nouveau mot de passe</label>
                            <div class="password-container">
                                <input type="password" name="password_confirmation"
                                    class="rakuten-input password-toggle-input" required>
                                <button type="button" class="eye-toggle" @click="togglePassword($event)">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-rakuten">Valider</button>
                </form>
            </div>
        </main>
    </div>

@endsection

@push('scripts')
    <script>
        function togglePassword(event) {
            const button = event.currentTarget;
            const container = button.closest('.password-container');
            const input = container.querySelector('.password-toggle-input');

            if (input.type === 'password') {
                input.type = 'text';
            } else {
                input.type = 'password';
            }
        }
    </script>
@endpush