@extends('layouts.app')

@section('title', 'S\'inscrire comme vendeur - Karnou')

@section('content')
    <style>
        html, body, .dashboard-container, .main-content {
            background-color: #fff !important;
        }

        .account-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .account-header h1 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #333;
            margin: 0;
        }

        /* Type Selector */
        .type-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .type-card {
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 8px;
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            box-shadow: none;
        }

        .type-card:hover {
            border-color: #004aad;
            box-shadow: none;
        }

        .type-card.selected {
            border-color: #f68b1e;
            border-width: 1.5px;
            background-color: #fffaf5;
        }

        .type-card.selected::after {
            content: '✓';
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #f68b1e;
            color: white;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .type-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        .type-name {
            font-size: 0.95rem;
            font-weight: 800;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .type-desc {
            font-size: 0.85rem;
            color: #666;
            line-height: 1.5;
        }

        /* Form Container */
        .form-container {
            background: #fff;
            border: 1px solid #eeeeee;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: none;
            box-shadow: none;
            overflow: hidden;
            animation: fadeIn 0.2s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .form-header {
            padding: 1rem 1.75rem;
            border-bottom: 1px solid #f0f0f0;
            background: #fcfcfc;
        }

        .form-header h2 {
            font-size: 0.9rem;
            font-weight: 700;
            color: #333;
            text-transform: uppercase;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-header h2 i {
            color: #004aad;
        }

        .form-body {
            padding: 2rem 1.75rem;
        }

        .form-section {
            margin-bottom: 2.5rem;
        }

        .section-subtitle {
            font-size: 0.7rem;
            color: #999;
            text-transform: uppercase;
            font-weight: 800;
            margin-bottom: 1.25rem;
            display: block;
            letter-spacing: 1px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .label span { color: #f68b1e; }

        .input-field {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.2s;
            background: #fafafa;
        }

        .input-field:focus {
            border-color: #004aad;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.05);
        }

        .input-field.is-invalid {
            border-color: #e53e3e !important;
            background-color: #fff5f5 !important;
        }

        .error-message {
            color: #e53e3e;
            font-size: 0.75rem;
            margin-top: 4px;
            font-weight: 500;
        }

        .file-upload {
            border: 2px dashed #ddd;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            background: #fafafa;
            cursor: pointer;
            transition: all 0.2s;
        }

        .file-upload.is-invalid {
            border-color: #e53e3e !important;
            background-color: #fff5f5 !important;
        }

        .file-upload:hover {
            background: #fff;
            border-color: #004aad;
        }

        .file-upload i {
            font-size: 1.8rem;
            color: #f68b1e;
            margin-bottom: 0.75rem;
            display: block;
        }

        .file-upload p {
            font-size: 0.9rem;
            color: #333;
            margin: 0;
            font-weight: 600;
        }

        .file-upload .hint {
            font-size: 0.75rem;
            color: #888;
            margin-top: 5px;
            font-weight: 400;
        }

        .btn-submit {
            background: #004aad;
            color: white;
            border: none;
            padding: 0.85rem 2rem;
            border-radius: 4px;
            font-size: 0.95rem;
            font-weight: 700;
            text-transform: uppercase;
            cursor: pointer;
            width: 100%;
            transition: background 0.2s;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover {
            background: #003680;
        }

        .btn-back {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 1.25rem;
            color: #666;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
        }

        .btn-back:hover {
            color: #004aad;
        }

        .error-banner-alert {
            background-color: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
            padding: 0.75rem 1.25rem;
            border-radius: 6px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.95rem;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .type-selector, .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>


    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            @php
                $vendeur = auth()->user()->vendeur;
                $isRejected = $vendeur && $vendeur->statut_verification === 'rejete';
                $raisonRejet = $isRejected ? $vendeur->raison_rejet : null;
            @endphp

            @if(session('error_banner'))
                <div class="error-banner-alert">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('error_banner') }}</span>
                </div>
            @endif

            @php
                $shouldClearField = function($fieldName, $raisonRejet) {
                    if (!$raisonRejet) return false;
                    $reason = strtolower($raisonRejet);
                    $keywords = [
                        'numero_document' => ['numéro', 'document', 'pièce', 'cni', 'passeport', 'identite'],
                        'nom_entreprise' => ['raison sociale', 'nom', 'entreprise', 'enseigne'],
                        'numero_registre_commerce' => ['registre', 'commerce', 'rccm'],
                        'registre_commerce' => ['document', 'registre', 'rccm', 'justificatif', 'illisible', 'commerce'],
                        'numero_identification_fiscale' => ['nif', 'fiscale', 'identification'],
                        'document' => ['document', 'piece', 'identite', 'cni', 'illisible', 'recto', 'verso'],
                        'date_emission_document' => ['date', 'emission', 'expiration'],
                        'date_expiration_document' => ['date', 'expiration'],
                        'adresse_entreprise' => ['adresse', 'siege', 'domiciliation'],
                        'telephone_entreprise' => ['telephone', 'contact', 'mobile'],
                        'email_entreprise' => ['email', 'courriel'],
                        'description_entreprise' => ['description', 'activite'],
                        'site_web' => ['site', 'web', 'url', 'internet'],
                    ];
                    
                    if (!isset($keywords[$fieldName])) return false;
                    
                    foreach ($keywords[$fieldName] as $kw) {
                        if (str_contains($reason, $kw)) return true;
                    }
                    return false;
                };
            @endphp

            <div class="account-header">
                @if(auth()->user()->estVendeurOfficiel())
                    <h1>Mettre à jour mes documents</h1>
                @elseif(auth()->user()->vendeur)
                    <h1>Devenez un Vendeur Officiel</h1>
                @else
                    <h1>Devenez Vendeur</h1>
                @endif
            </div>

            <div style="margin-bottom: 1.5rem;">
                <p style="font-size: 0.9rem; color: #666; margin: 0;">
                    @if(auth()->user()->estVendeurOfficiel())
                        Gérez vos informations de vendeur et vos documents officiels.
                    @elseif(auth()->user()->vendeur)
                        Complétez votre profil pour débloquer les abonnements et publier plus d'annonces.
                    @else
                        Rejoignez les vendeurs Karnou et vendez vos produits à travers toute la Centrafrique.
                    @endif
                </p>
            </div>

            @if(!auth()->user()->estVendeur() || !auth()->user()->vendeur->estProfessionnel())
                <div class="type-selector">
                    <div class="type-card" id="particulier-card" onclick="selectType('particulier')" @if(auth()->user()->vendeur && auth()->user()->vendeur->estParticulier()) style="opacity: 0.5; pointer-events: none;" @endif>
                        <div class="type-icon" style="background: #f0f7ff; color: #004aad;">
                            <i class="fa-solid fa-user"></i>
                        </div>
                        <div class="type-name">Vendeur Particulier</div>
                        <div class="type-desc">Idéal pour vendre des objets d'occasion ou occasionnels. Inscription simple avec votre CNI.</div>
                    </div>

                    <div class="type-card" id="professionnel-card" onclick="selectType('professionnel')">
                        <div class="type-icon" style="background: #f0f7ff; color: #004aad;">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <div class="type-name">Vendeur Professionnel</div>
                        <div class="type-desc">Pour les entreprises, boutiques et artisans. Avantages pro, Page Pro exclusive et commissions réduites.</div>
                    </div>
                </div>

                @if(auth()->user()->vendeur && !auth()->user()->estVendeurOfficiel())
                    <div style="text-align: center; margin-bottom: 2rem; color: #666; font-style: italic;">
                        <p>Vous avez déjà commencé à vendre. Choisissez votre type de compte pour continuer et profiter de tous les services.</p>
                    </div>
                @endif
            @endif

            <div id="form-particulier" class="form-container">
                <div class="form-header">
                    <h2><i class="fa-solid fa-user-check"></i> Informations Vendeur Particulier</h2>
                </div>
                
                <div class="form-body">
                    <form action="{{ route('vendeur.store.particulier', request()->has('update') ? ['update' => 1] : []) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-section">
                        <span class="section-subtitle">Pièce d'identité</span>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="label">Type de document <span>*</span></label>
                                <select name="type_document" class="input-field" required>
                                    <option value="cni" {{ (auth()->user()->vendeur && auth()->user()->vendeur->particulier && auth()->user()->vendeur->particulier->type_document === 'cni') ? 'selected' : '' }}>CNI (Identité)</option>
                                    <option value="passeport" {{ (auth()->user()->vendeur && auth()->user()->vendeur->particulier && auth()->user()->vendeur->particulier->type_document === 'passeport') ? 'selected' : '' }}>Passeport</option>
                                    <option value="recepisse" {{ (auth()->user()->vendeur && auth()->user()->vendeur->particulier && auth()->user()->vendeur->particulier->type_document === 'recepisse') ? 'selected' : '' }}>Récépissé officiel</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="label">Numéro du document <span>*</span></label>
                                <input type="text" name="numero_document" class="input-field @if($errors->has('numero_document') || $shouldClearField('numero_document', $raisonRejet)) is-invalid @endif" placeholder="12345678" 
                                    value="{{ ($errors->has('numero_document') || $shouldClearField('numero_document', $raisonRejet)) ? '' : (old('numero_document') ?? ((auth()->user()->vendeur && auth()->user()->vendeur->particulier && auth()->user()->vendeur->particulier->numero_document !== 'A_COMPLETER') ? auth()->user()->vendeur->particulier->numero_document : '')) }}" required>
                                @error('numero_document') <div class="error-message">{{ $message }}</div> @enderror
                                @if($shouldClearField('numero_document', $raisonRejet)) <div class="error-message">veuillez corriger ce champ</div> @endif
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="label">Date d'émission <span>*</span></label>
                                <input type="date" name="date_emission_document" class="input-field @if($errors->has('date_emission_document') || $shouldClearField('date_emission_document', $raisonRejet)) is-invalid @endif" 
                                    value="{{ ($errors->has('date_emission_document') || $shouldClearField('date_emission_document', $raisonRejet)) ? '' : (old('date_emission_document') ?? ((auth()->user()->vendeur && auth()->user()->vendeur->particulier && auth()->user()->vendeur->particulier->date_emission_document) ? auth()->user()->vendeur->particulier->date_emission_document->format('Y-m-d') : '')) }}" required>
                                @error('date_emission_document') <div class="error-message">{{ $message }}</div> @enderror
                                @if($shouldClearField('date_emission_document', $raisonRejet)) <div class="error-message">veuillez corriger ce champ</div> @endif
                            </div>
                            <div class="form-group">
                                <label class="label">Date d'expiration (si applicable)</label>
                                <input type="date" name="date_expiration_document" class="input-field @if($errors->has('date_expiration_document') || $shouldClearField('date_expiration_document', $raisonRejet)) is-invalid @endif"
                                    value="{{ ($errors->has('date_expiration_document') || $shouldClearField('date_expiration_document', $raisonRejet)) ? '' : (old('date_expiration_document') ?? ((auth()->user()->vendeur && auth()->user()->vendeur->particulier && auth()->user()->vendeur->particulier->date_expiration_document) ? auth()->user()->vendeur->particulier->date_expiration_document->format('Y-m-d') : '')) }}">
                                @error('date_expiration_document') <div class="error-message">{{ $message }}</div> @enderror
                                @if($shouldClearField('date_expiration_document', $raisonRejet)) <div class="error-message">veuillez corriger ce champ</div> @endif
                            </div>
                        </div>
                    </div>

                        <div class="form-section">
                            <span class="section-subtitle">Justificatif officiel</span>
                            <div class="form-group">
                                <label class="label">Passeport, CNI ou Récépissé (Recto/Verso) <span>*</span></label>
                                <div class="file-upload @if($errors->has('document') || $shouldClearField('document', $raisonRejet)) is-invalid @endif" onclick="document.getElementById('doc-particulier').click()">
                                    <i class="fa-solid fa-id-card"></i>
                                    <p>Cliquez pour choisir un fichier</p>
                                    <p class="hint">PDF, JPG ou PNG • Max 5 Mo</p>
                                    <input type="file" id="doc-particulier" name="document" style="display: none;" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                                @error('document') <div class="error-message" style="text-align: center;">{{ $message }}</div> @enderror
                                @if($shouldClearField('document', $raisonRejet)) <div class="error-message" style="text-align: center;">veuillez corriger ce champ</div> @endif
                            </div>
                            <div id="file-name-particulier" style="font-size: 0.85rem; color: #004aad; font-weight: 700; text-align: center; margin-top: 10px;"></div>
                        </div>

                        <button type="submit" class="btn-submit">Soumettre mon dossier</button>
                        <a href="{{ route('vendeur.show') }}" class="btn-back">
                            <i class="fa-solid fa-arrow-left"></i> Accéder à ma page vendeur
                        </a>
                    </form>
                </div>
            </div>

            <div id="form-professionnel" class="form-container">
                <div class="form-header">
                    <h2><i class="fa-solid fa-building-circle-check"></i> Informations Professionnelles</h2>
                </div>
                
                <div class="form-body">
                    <form action="{{ route('vendeur.store.professionnel', request()->has('update') ? ['update' => 1] : []) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-section">
                        <span class="section-subtitle">Identité de l'entreprise</span>
                        <div class="form-group">
                            <label class="label">Nom de l'entreprise ou enseigne commerciale <span>*</span></label>
                            <input type="text" name="nom_entreprise" class="input-field @if($errors->has('nom_entreprise') || $shouldClearField('nom_entreprise', $raisonRejet)) is-invalid @endif" placeholder="Ma boutique"
                                value="{{ ($errors->has('nom_entreprise') || $shouldClearField('nom_entreprise', $raisonRejet)) ? '' : (old('nom_entreprise') ?? ((auth()->user()->vendeur && auth()->user()->vendeur->professionnel) ? auth()->user()->vendeur->professionnel->nom_entreprise : '')) }}" required>
                            @error('nom_entreprise') <div class="error-message">{{ $message }}</div> @enderror
                            @if($shouldClearField('nom_entreprise', $raisonRejet)) <div class="error-message">veuillez corriger ce champ</div> @endif
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="label">Registre de Commerce (RCCM) <span>*</span></label>
                                <input type="text" name="numero_registre_commerce" class="input-field @if($errors->has('numero_registre_commerce') || $shouldClearField('numero_registre_commerce', $raisonRejet)) is-invalid @endif" placeholder="RCA-BG-2024-B-001"
                                    value="{{ ($errors->has('numero_registre_commerce') || $shouldClearField('numero_registre_commerce', $raisonRejet)) ? '' : (old('numero_registre_commerce') ?? ((auth()->user()->vendeur && auth()->user()->vendeur->professionnel) ? auth()->user()->vendeur->professionnel->numero_registre_commerce : '')) }}">
                                @error('numero_registre_commerce') <div class="error-message">{{ $message }}</div> @enderror
                                @if($shouldClearField('numero_registre_commerce', $raisonRejet)) <div class="error-message">veuillez corriger ce champ</div> @endif
                            </div>
                            <div class="form-group">
                                <label class="label">Identification Fiscale (NIF) <span>*</span></label>
                                <input type="text" name="numero_identification_fiscale" class="input-field @if($errors->has('numero_identification_fiscale') || $shouldClearField('numero_identification_fiscale', $raisonRejet)) is-invalid @endif" placeholder="123456 A"
                                    value="{{ ($errors->has('numero_identification_fiscale') || $shouldClearField('numero_identification_fiscale', $raisonRejet)) ? '' : (old('numero_identification_fiscale') ?? ((auth()->user()->vendeur && auth()->user()->vendeur->professionnel) ? auth()->user()->vendeur->professionnel->numero_identification_fiscale : '')) }}">
                                @error('numero_identification_fiscale') <div class="error-message">{{ $message }}</div> @enderror
                                @if($shouldClearField('numero_identification_fiscale', $raisonRejet)) <div class="error-message">veuillez corriger ce champ</div> @endif
                            </div>
                        </div>

                         <div class="form-group">
                            <label class="label">Justificatif (RCCM, NIF ou Statuts) <span>*</span></label>
                            <div class="file-upload @if($errors->has('registre_commerce') || $shouldClearField('registre_commerce', $raisonRejet)) is-invalid @endif" onclick="document.getElementById('doc-pro').click()">
                                <i class="fa-solid fa-file-invoice"></i>
                                <p>Cliquez pour charger le document</p>
                                <p class="hint">PDF, JPG ou PNG • Max 5 Mo</p>
                                <input type="file" id="doc-pro" name="registre_commerce" style="display: none;" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                            @error('registre_commerce') <div class="error-message" style="text-align: center;">{{ $message }}</div> @enderror
                            @if($shouldClearField('registre_commerce', $raisonRejet)) <div class="error-message" style="text-align: center;">veuillez corriger ce champ</div> @endif
                        </div>
                        <div id="file-name-pro" style="font-size: 0.85rem; color: #004aad; font-weight: 700; text-align: center; margin-top: 10px;"></div>
                    </div>

                    <button type="submit" class="btn-submit">Finaliser mon dossier Pro</button>
                    <a href="{{ route('vendeur.show') }}" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i> Accéder à ma page vendeur
                    </a>
                </form>
            </div>
        </div>
    </div>

            <div style="text-align: center; margin-top: 0.5rem; margin-bottom: 2rem;">
                <a href="{{ route('account.index') }}" style="color: #8e8e93; text-decoration: none; font-size: 0.85rem;">
                    <i class="fa-solid fa-chevron-left"></i> Annuler et retourner au compte
                </a>
            </div>
        </main>
    </div>

    <script>
        function selectType(type, force = false) {
            // Effets visuels
            document.querySelectorAll('.type-card').forEach(card => card.classList.remove('selected'));
            const card = document.getElementById(type + '-card');
            if (card) card.classList.add('selected');

            // Affichage formulaires
            document.querySelectorAll('.form-container').forEach(form => form.style.display = 'none');
            document.getElementById('form-' + type).style.display = 'block';

            if (!force) {
                document.getElementById('form-' + type).scrollIntoView({ behavior: 'smooth' });
            }
        }

        function cancelSelection() {
            document.querySelectorAll('.type-card').forEach(card => card.classList.remove('selected'));
            document.querySelectorAll('.form-container').forEach(form => form.style.display = 'none');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Affichage des noms de fichiers après sélection
        document.getElementById('doc-particulier').addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                document.getElementById('file-name-particulier').innerText = "Fichier sélectionné : " + e.target.files[0].name;
            }
        });

        document.getElementById('doc-pro').addEventListener('change', function (e) {
            if (e.target.files.length > 0) {
                document.getElementById('file-name-pro').innerText = "Fichier sélectionné : " + e.target.files[0].name;
            }
        });

        @php
            $initialType = request('type') ?? (auth()->user()->estVendeur() ? auth()->user()->vendeur->type : 'particulier');
        @endphp

        window.onload = function () {
            selectType('{{ $initialType }}', true);
        }
    </script>
@endsection