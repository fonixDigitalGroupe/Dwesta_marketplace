@extends('layouts.admin')

@section('title', 'Modifier l\'utilisateur')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        /* Input Amazon Style Modernisé */
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 0.82rem;
            outline: none;
            background: #fff;
            color: #475569;
            transition: all 0.2s;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #ff9900 !important;
            box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15);
        }

        .amazon-card {
            background: #fff;
            border: 1px solid #eff3f6;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .field-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* Buttons Alignés avec Index */
        .btn-amazon-primary {
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #fff;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            cursor: pointer;
            width: 100%;
        }

        .btn-amazon-primary:hover {
            background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: #fff;
        }

        .btn-amazon-secondary {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.03em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            cursor: pointer;
            width: 100%;
        }

        .btn-amazon-secondary:hover {
            background: #f8fafc;
            border-color: #dee2e6;
            color: #1e293b;
        }

        .iti {
            width: 100%;
        }

        .iti__selected-flag {
            padding-right: 12px !important;
            position: relative;
            border-radius: 4px 0 0 4px !important;
        }

        .iti__selected-flag::after {
            content: "";
            position: absolute;
            right: 0;
            top: 20%;
            bottom: 20%;
            width: 1px;
            background-color: #dee2e6;
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

        <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                        <i class="fas fa-edit" style="font-size: 0.8rem;"></i>
                        <span style="line-height: 1;">Modifier l'utilisateur : {{ $user->prenom }} {{ $user->nom }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn-amazon-secondary"
                    style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
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

                        <div style="margin-top: 5px; padding-top: 15px; border-top: 1px solid #eff3f6;">
                            <p style="font-size: 0.8rem; color: #64748b; font-style: italic; margin-bottom: 15px;">Laissez vide pour conserver le mot de passe actuel.</p>
                            
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                                    <label for="password" class="field-label" style="margin-bottom: 0;">Nouveau mot de passe</label>
                                    <button type="button" onclick="generatePassword()" style="background: none; border: none; color: #3b82f6; font-size: 0.75rem; cursor: pointer; padding: 0; font-weight: 500;">Générer</button>
                                </div>
                                <div style="position: relative;">
                                    <input type="password" name="password" id="password" autocomplete="new-password">
                                    <button type="button" onclick="togglePasswordVisibility('password')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; padding: 5px;">
                                        <i class="fas fa-eye" id="password-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label for="password_confirmation" class="field-label">Confirmer mot de passe</label>
                                <div style="position: relative;">
                                    <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password">
                                    <button type="button" onclick="togglePasswordVisibility('password_confirmation')" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #94a3b8; cursor: pointer; padding: 5px;">
                                        <i class="fas fa-eye" id="password_confirmation-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Actions Row -->
                    <div style="grid-column: 1 / -1; display: grid; grid-template-columns: 200px 140px; gap: 12px; justify-content: end; border-top: 1px solid #eff3f6; padding-top: 20px;">
                        <button type="submit" class="btn-amazon-primary">
                            ENREGISTRER
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn-amazon-secondary">
                            ANNULER
                        </a>
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