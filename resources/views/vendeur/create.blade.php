@extends('layouts.app')

@section('title', 'S\'inscrire comme vendeur - Mady Market')

@section('content')
    <style>
        :root {
            --primary-color: #111827; /* Darker near-black */
            --accent-color: #374151;  /* Slate 700 */
            --bg-light: #f9fafb;     /* Gray 50 */
            --border-color: #e5e7eb;  /* Gray 200 */
            --text-main: #374151;    /* Gray 700 */
            --text-muted: #6b7280;   /* Gray 500 */
        }

        .step-header {
            text-align: left;
            margin-bottom: 2rem;
            margin-top: 0.5rem;
            max-width: 800px;
        }

        .step-header h1 {
            font-size: 1.6rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .step-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Type Selector */
        .type-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .type-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.5rem;
            text-align: left;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .type-card:hover {
            border-color: #9ca3af;
            background: #fdfdfd;
        }

        .type-card.selected {
            border-color: #0076ad;
            border-width: 2px;
            background-color: #f0f7ff;
        }

        .type-card.selected::after {
            content: '✓';
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #0076ad;
            color: white;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }

        .type-icon {
            width: 40px;
            height: 40px;
            color: #333;
            background: #f3f4f6;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .type-icon svg {
            width: 20px;
            height: 20px;
        }

        .type-name {
            font-size: 1rem;
            font-weight: 700;
            color: var(--primary-color);
        }

        .type-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        /* Form sections */
        .form-container {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1.75rem;
            display: none;
            box-shadow: none;
            animation: slideUp 0.3s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-title {
            font-size: 1.15rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-subtitle {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1.25rem;
            font-weight: 700;
            display: block;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.4rem;
        }

        .label span {
            color: #dc2626;
        }

        .input-field {
            width: 100%;
            padding: 0.65rem 0.85rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.9rem;
            outline: none;
            transition: all 0.2s;
            background: #fff;
        }

        .input-field:focus {
            border-color: #000;
            background: white;
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
        }

        /* File upload custom - Compacted */
        .file-upload {
            border: 1px dashed #d1d5db;
            padding: 1.5rem;
            border-radius: 6px;
            text-align: center;
            background: #f9fafb;
            cursor: pointer;
            transition: all 0.2s;
        }

        .file-upload:hover {
            border-color: #000;
            background: #f3f4f6;
        }

        .file-upload svg {
            width: 24px;
            height: 24px;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .file-upload p {
            font-size: 0.85rem;
            color: #4b5563;
        }

        .file-upload strong {
            color: #111827;
        }

        .btn-submit {
            background: #111827;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            width: auto;
            min-width: 220px;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: #000;
            transform: translateY(-1px);
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            width: 100%;
            justify-content: center;
        }

        .btn-back:hover {
            color: var(--primary-color);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1rem;
        }

        .form-section {
            padding: 1.5rem;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 2rem;
        }

        /* Error Banner Alert */
        .error-banner-alert {
            background-color: #fff5f5;
            border: 1px solid #feb2b2;
            color: #c53030;
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .error-banner-alert svg {
            flex-shrink: 0;
            width: 20px;
            height: 20px;
        }
    </style>

    <div class="breadcrumb">
        <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('profile.show') }}">Mon Compte</a> > <span>Devenir Vendeur</span>
    </div>

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content">
            @if(session('error_banner'))
                <div class="error-banner-alert">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{ session('error_banner') }}</span>
                </div>
            @endif

            <div class="step-header" style="margin-top: 0;">
                @if(auth()->user()->estVendeurOfficiel())
                    <h1>Mettre à jour mes documents</h1>
                    <p>Gérez vos informations de vendeur et vos documents officiels.</p>
                @elseif(auth()->user()->vendeur)
                    <h1>Devenez un Vendeur Officiel</h1>
                    <p>Complétez votre profil pour débloquer les abonnements et publier plus d'annonces.</p>
                @else
                    <h1>Rejoignez les vendeurs Mady Market</h1>
                    <p>Vendez vos produits en quelques clics à travers toute la Centrafrique.</p>
                @endif
            </div>

            @if(!auth()->user()->estVendeur() || !auth()->user()->vendeur->estProfessionnel())
                <div class="type-selector">
                    <div class="type-card" id="particulier-card" onclick="selectType('particulier')" @if(auth()->user()->vendeur && auth()->user()->vendeur->estParticulier()) style="opacity: 0.5; pointer-events: none;" @endif>
                        <div class="type-icon" style="background: #fdf0f5; color: #e91e63;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div class="type-name">Vendeur Particulier</div>
                        <div class="type-desc">Idéal pour vendre des objets d'occasion ou occasionnels. Inscription simple avec
                            votre CNI.</div>
                    </div>

                    <div class="type-card" id="professionnel-card" onclick="selectType('professionnel')">
                        <div class="type-icon" style="background: #f0f7ff; color: #0076ad;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m-4 6h4m-4 4h4m1 1H7"></path>
                            </svg>
                        </div>
                        <div class="type-name">Vendeur Professionnel</div>
                        <div class="type-desc">Pour les entreprises, boutiques et artisans. Avantages pro, Page Pro exclusive et
                            commissions réduites.</div>
                    </div>
                </div>

                @if(auth()->user()->vendeur && !auth()->user()->estVendeurOfficiel())
                    <div style="text-align: center; margin-bottom: 2rem; color: #666; font-style: italic;">
                        <p>Vous avez déjà commencé à vendre. Choisissez votre type de compte pour continuer et profiter de tous les services.</p>
                    </div>
                @endif
            @endif

            <!-- Formulaire Particulier -->
            <div id="form-particulier" class="form-container">
                <h2 class="form-title">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Informations Vendeur Particulier
                </h2>
                
                <form action="{{ route('vendeur.store.particulier') }}" method="POST" enctype="multipart/form-data" class="professional-form">
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
                                <input type="text" name="numero_document" class="input-field" placeholder="Ex: 12345678" 
                                    value="{{ (auth()->user()->vendeur && auth()->user()->vendeur->particulier && auth()->user()->vendeur->particulier->numero_document !== 'A_COMPLETER') ? auth()->user()->vendeur->particulier->numero_document : '' }}" required>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="label">Date d'émission <span>*</span></label>
                                <input type="date" name="date_emission_document" class="input-field" 
                                    value="{{ (auth()->user()->vendeur && auth()->user()->vendeur->particulier && auth()->user()->vendeur->particulier->date_emission_document) ? auth()->user()->vendeur->particulier->date_emission_document->format('Y-m-d') : '' }}" required>
                            </div>
                            <div class="form-group">
                                <label class="label">Date d'expiration (si applicable)</label>
                                <input type="date" name="date_expiration_document" class="input-field"
                                    value="{{ (auth()->user()->vendeur && auth()->user()->vendeur->particulier && auth()->user()->vendeur->particulier->date_expiration_document) ? auth()->user()->vendeur->particulier->date_expiration_document->format('Y-m-d') : '' }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <span class="section-subtitle">Justificatif officiel</span>
                        <div class="form-group">
                            <label class="label">Scan ou Photo du document (Recto/Verso) <span>*</span></label>
                            <div class="file-upload" onclick="document.getElementById('doc-particulier').click()">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <p><strong>Glissez votre fichier ici</strong> ou cliquez pour parcourir</p>
                                <p style="font-size: 0.8rem; margin-top: 0.5rem;">PDF, JPG, PNG (Max 5 Mo)</p>
                                <input type="file" id="doc-particulier" name="document" style="display: none;" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                        </div>
                        <div id="file-name-particulier" style="font-size: 0.85rem; color: var(--accent-color); font-weight: 700; text-align: center;"></div>
                    </div>

                    <button type="submit" class="btn-submit">Valider et soumettre mon dossier</button>
                    <a href="#" onclick="cancelSelection()" class="btn-back">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Retour au choix du type de compte
                    </a>
                </form>
            </div>

            <!-- Formulaire Professionnel -->
            <div id="form-professionnel" class="form-container">
                <h2 class="form-title">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m-4 6h4m-4 4h4m1 1H7"></path></svg>
                    Informations Professionnelles
                </h2>
                
                <form action="{{ route('vendeur.store.professionnel') }}" method="POST" enctype="multipart/form-data" class="professional-form">
                    @csrf
                    
                    <div class="form-section">
                        <span class="section-subtitle">Identité de l'entreprise</span>
                        <div class="form-group">
                            <label class="label">Nom de l'entreprise ou enseigne commerciale <span>*</span></label>
                            <input type="text" name="nom_entreprise" class="input-field" 
                                value="{{ (auth()->user()->vendeur && auth()->user()->vendeur->professionnel) ? auth()->user()->vendeur->professionnel->nom_entreprise : '' }}" required>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="label">Registre de Commerce (RCCM)</label>
                                <input type="text" name="numero_registre_commerce" class="input-field" 
                                    value="{{ (auth()->user()->vendeur && auth()->user()->vendeur->professionnel) ? auth()->user()->vendeur->professionnel->numero_registre_commerce : '' }}">
                            </div>
                            <div class="form-group">
                                <label class="label">Identification Fiscale (NIF)</label>
                                <input type="text" name="numero_identification_fiscale" class="input-field" 
                                    value="{{ (auth()->user()->vendeur && auth()->user()->vendeur->professionnel) ? auth()->user()->vendeur->professionnel->numero_identification_fiscale : '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label">Document officiel (RCCM ou NIF) <span>*</span></label>
                            <div class="file-upload" onclick="document.getElementById('doc-pro').click()">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p><strong>Glissez votre justificatif ici</strong> ou cliquez pour parcourir</p>
                                <p style="font-size: 0.8rem; margin-top: 0.5rem;">PDF, JPG, PNG (Max 5 Mo)</p>
                                <input type="file" id="doc-pro" name="registre_commerce" style="display: none;" accept=".pdf,.jpg,.jpeg,.png">
                            </div>
                        </div>
                        <div id="file-name-pro" style="font-size: 0.85rem; color: var(--accent-color); font-weight: 700; text-align: center;"></div>
                    </div>

                    <div class="form-section">
                        <span class="section-subtitle">Coordonnées & Siège</span>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="label">Téléphone Entreprise <span>*</span></label>
                                <input type="tel" name="telephone_entreprise" class="input-field" 
                                    value="{{ (auth()->user()->vendeur && auth()->user()->vendeur->professionnel) ? auth()->user()->vendeur->professionnel->telephone_entreprise : '' }}">
                            </div>
                            <div class="form-group">
                                <label class="label">Email Entreprise <span>*</span></label>
                                <input type="email" name="email_entreprise" class="input-field" 
                                    value="{{ (auth()->user()->vendeur && auth()->user()->vendeur->professionnel) ? auth()->user()->vendeur->professionnel->email_entreprise : '' }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="label">Adresse physique du siège / boutique <span>*</span></label>
                            <input type="text" name="adresse_entreprise" class="input-field" 
                                value="{{ (auth()->user()->vendeur && auth()->user()->vendeur->professionnel) ? auth()->user()->vendeur->professionnel->adresse_entreprise : '' }}">
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Finaliser mon inscription Pro</button>
                    <a href="#" onclick="cancelSelection()" class="btn-back">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Retour au choix du type de compte
                    </a>
                </form>
            </div>

            <div style="text-align: center; margin-top: 2rem; margin-bottom: 2rem;">
                <a href="{{ route('profile.show') }}" style="color: #666; text-decoration: none;">Retour au tableau de bord</a>
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

        @if(auth()->user()->estVendeur())
            window.onload = function () {
                selectType('{{ auth()->user()->vendeur->type }}', true);
            }
        @else
            window.onload = function () {
                selectType('particulier', true);
            }
        @endif
    </script>
@endsection