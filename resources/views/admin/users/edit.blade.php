@extends('layouts.admin')

@section('title', 'Modifier l\'utilisateur')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        /* Input Amazon Style */
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #adb1b8;
            border-radius: 0;
            font-size: 0.85rem;
            outline: none;
            background: #fcfcfc;
            color: #111;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #e77600 !important;
        }

        .amazon-card {
            background: #fff;
            border: 1px solid #e7e7e7;
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 500;
            color: #111;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e7e7e7;
        }

        .field-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: #111;
            margin-bottom: 8px;
        }

        .btn-amazon-primary {
            background: linear-gradient(180deg, #007bff 0%, #0056b3 100%);
            border: 1px solid #004aad;
            color: #fff;
            padding: 10px 24px;
            border-radius: 0;
            font-size: 0.85rem;
            font-weight: 400;
            text-decoration: none;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .4) inset;
            cursor: pointer;
            text-align: center;
        }

        .btn-amazon-primary:hover {
            background: linear-gradient(180deg, #0069d9 0%, #004494 100%);
            border-color: #003d82;
        }

        .btn-amazon-secondary {
            background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
            border: 1px solid #adb1b8;
            color: #111;
            padding: 10px 24px;
            border-radius: 0;
            font-size: 0.85rem;
            font-weight: 400;
            text-decoration: none;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .6) inset;
            cursor: pointer;
            text-align: center;
        }

        .iti {
            width: 100%;
        }

        .iti__selected-flag {
            padding-right: 12px !important;
            position: relative;
            border-radius: 0 !important;
        }

        .iti__selected-flag::after {
            content: "";
            position: absolute;
            right: 0;
            top: 20%;
            bottom: 20%;
            width: 1px;
            background-color: #adb1b8;
            pointer-events: none;
        }

        #telephone {
            padding-left: 55px !important;
        }
    </style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
    <div style="max-width: 1200px; margin: 0 auto;">

        <div style="background: #fff; border: 1px solid #e7e7e7; border-top: none; padding: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">Modifier l'utilisateur : {{ $user->prenom }} {{ $user->nom }}</h1>
                <a href="{{ route('admin.users.index') }}" class="btn-amazon-secondary"
                    style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i> Retour à la liste
                </a>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')

                <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">

                    <!-- Left Column: Personnel -->
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div class="amazon-card" style="margin: 0;">
                            <h3 class="section-title">Informations Personnelles</h3>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                                <div>
                                    <label for="prenom" class="field-label">Prénom <small
                                            style="color: red;">*</small></label>
                                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $user->prenom) }}" required
                                        oninput="if(this.value) this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                                    @error('prenom')
                                        <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="nom" class="field-label">Nom <small
                                            style="color: red;">*</small></label>
                                    <input type="text" name="nom" id="nom" value="{{ old('nom', $user->nom) }}" required
                                        oninput="if(this.value) this.value = this.value.toUpperCase()">
                                    @error('nom')
                                        <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label for="email" class="field-label">Adresse Email <small
                                        style="color: red;">*</small></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    placeholder="exemple@email.com">
                                @error('email')
                                    <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                                <div>
                                    <label for="telephone" class="field-label">Téléphone</label>
                                    <input type="tel" id="telephone" value="{{ old('telephone', $user->telephone) }}">
                                    <input type="hidden" name="telephone" id="full_telephone"
                                        value="{{ old('telephone', $user->telephone) }}">
                                </div>
                                <div>
                                    <label for="nationalite" class="field-label">Nationalité</label>
                                    <select name="nationalite" id="nationalite">
                                        <option value="">Sélectionner...</option>
                                        @php
                                            $countries = ['Sénégal', 'Afrique du Sud', 'Algérie', 'Angola', 'Bénin', 'Burkina Faso', 'Cameroun', 'Centrafrique', 'Congo', 'Côte d\'Ivoire', 'Égypte', 'Gabon', 'Guinée', 'Mali', 'Maroc', 'Mauritanie', 'Niger', 'Nigeria', 'Tchad', 'Togo', 'Tunisie', 'Française'];
                                        @endphp
                                        @foreach ($countries as $country)
                                            <option value="{{ $country }}"
                                                {{ old('nationalite', $user->nationalite) == $country ? 'selected' : '' }}>
                                                {{ $country }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="adresse" class="field-label">Adresse complète</label>
                                <textarea name="adresse" id="adresse" rows="4" placeholder="Quartier, Rue, Ville..."
                                    style="resize: vertical; font-family: inherit;">{{ old('adresse', $user->adresse) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Config -->
                    <div class="amazon-card" style="margin: 0; display: flex; flex-direction: column;">
                        <h3 class="section-title">Accès & Rôle</h3>

                        <div style="margin-bottom: 20px;">
                            <label for="role" class="field-label">Rôle système <small
                                    style="color: red;">*</small></label>
                            <select name="role" id="role" required>
                                <option value="">Choisir un rôle...</option>
                                @foreach($roles as $value => $label)
                                    <option value="{{ $value }}" {{ old('role', $user->roles->first()?->name) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div style="margin-top: 5px; padding-top: 15px; border-top: 1px solid #eee;">
                            <p style="font-size: 0.8rem; color: #777; font-style: italic; margin-bottom: 15px;">Laissez vide pour conserver le mot de passe actuel.</p>
                            
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                    <label for="password" class="field-label" style="margin-bottom: 0;">Nouveau mot de passe</label>
                                    <button type="button" onclick="generatePassword()" style="background: none; border: none; color: #007185; font-size: 0.75rem; cursor: pointer; padding: 0; font-weight: 500;">Générer un mot de passe</button>
                                </div>
                                <div style="position: relative;">
                                    <input type="password" name="password" id="password" autocomplete="new-password">
                                    <button type="button" onclick="togglePasswordVisibility('password')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #555; cursor: pointer; padding: 5px;">
                                        <i class="fas fa-eye" id="password-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label for="password_confirmation" class="field-label">Confirmer nouveau mot de passe</label>
                                <div style="position: relative;">
                                    <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
                                    <button type="button" onclick="togglePasswordVisibility('password_confirmation')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #555; cursor: pointer; padding: 5px;">
                                        <i class="fas fa-eye" id="password_confirmation-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Actions Row (Inside Container) -->
                        <div
                            style="border-top: 1px solid #e7e7e7; padding-top: 20px; display: flex; flex-direction: column; gap: 10px; margin-top: auto;">
                            <button type="submit" class="btn-amazon-primary"
                                style="width: 100%; font-weight: 700; margin: 0; padding: 12px 0;">
                                ENREGISTRER LES MODIFICATIONS
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn-amazon-secondary"
                                style="width: 100%; margin: 0; padding: 12px 0;">
                                ANNULER
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var input = document.querySelector("#telephone");
                var fullPhoneInput = document.querySelector("#full_telephone");
                var nationaliteSelect = document.querySelector("select[name='nationalite']");

                const countryMapping = {
                    'Sénégal': 'sn',
                    'Afrique du Sud': 'za',
                    'Algérie': 'dz',
                    'Angola': 'ao',
                    'Bénin': 'bj',
                    'Burkina Faso': 'bf',
                    'Cameroun': 'cm',
                    'Centrafrique': 'cf',
                    'Congo': 'cg',
                    "Côte d'Ivoire": 'ci',
                    'Égypte': 'eg',
                    'Gabon': 'ga',
                    'Guinée': 'gn',
                    'Mali': 'ml',
                    'Maroc': 'ma',
                    'Mauritanie': 'mr',
                    'Niger': 'ne',
                    'Nigeria': 'ng',
                    'Tchad': 'td',
                    'Togo': 'tg',
                    'Tunisie': 'tn',
                    'Française': 'fr'
                };

                var iti = window.intlTelInput(input, {
                    initialCountry: "auto",
                    geoIpLookup: function (success, failure) {
                        const countryCode = countryMapping[nationaliteSelect.value] || 'sn';
                        success(countryCode);
                    },
                    autoPlaceholder: "off",
                    onlyCountries: Object.values(countryMapping),
                    preferredCountries: ['sn', 'fr', 'cf'],
                    nationalMode: true,
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                });

                nationaliteSelect.addEventListener('change', function () {
                    const countryCode = countryMapping[this.value];
                    if (countryCode) iti.setCountry(countryCode);
                });

                const updateFullPhone = () => {
                    fullPhoneInput.value = iti.getNumber();
                };
                input.addEventListener('input', updateFullPhone);
                input.addEventListener('countrychange', updateFullPhone);
                input.closest('form').addEventListener('submit', updateFullPhone);

                if (nationaliteSelect.value) {
                    const initialCountryCode = countryMapping[nationaliteSelect.value];
                    if (initialCountryCode) iti.setCountry(initialCountryCode);
                }
            });

            function generatePassword() {
                const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
                let password = "";
                for (let i = 0; i < 12; i++) {
                    password += charset.charAt(Math.floor(Math.random() * charset.length));
                }
                
                document.getElementById('password').value = password;
                document.getElementById('password_confirmation').value = password;
                
                // Show the password so the user can see it
                document.getElementById('password').type = 'text';
                document.getElementById('password_confirmation').type = 'text';
                document.getElementById('password-eye').classList.replace('fa-eye', 'fa-eye-slash');
                document.getElementById('password_confirmation-eye').classList.replace('fa-eye', 'fa-eye-slash');
                
                alert("Nouveau mot de passe généré : " + password);
            }

            function togglePasswordVisibility(id) {
                const input = document.getElementById(id);
                const eye = document.getElementById(id + '-eye');
                if (input.type === 'password') {
                    input.type = 'text';
                    eye.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    input.type = 'password';
                    eye.classList.replace('fa-eye-slash', 'fa-eye');
                }
            }
        </script>
    @endpush
@endsection