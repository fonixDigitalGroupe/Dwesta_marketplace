<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire comme vendeur - Mady Market</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f6f6f6;
            color: #333;
        }
        
        /* Layout simplifiée pour l'inscription */
        .header {
            background-color: #ffffff;
            border-bottom: 2px solid #bf0000;
            padding: 1rem 0;
            text-align: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 1.8rem;
            font-weight: bold;
            color: #bf0000;
        }
        
        .logo img {
            height: 48px;
            margin-right: 0.75rem;
        }

        .container {
            max-width: 900px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .step-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .step-header h1 {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .step-header p {
            color: #666;
            font-size: 1.1rem;
        }

        /* Type Selector */
        .type-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .type-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 2.5rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .type-card:hover {
            border-color: #bf0000;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(191, 0, 0, 0.05);
        }

        .type-card.selected {
            border-color: #bf0000;
            background-color: #fdf2f2;
        }

        .type-card.selected::after {
            content: '✓';
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: #bf0000;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .type-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 1.5rem;
            color: #bf0000;
            background: #fdf2f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .type-icon svg {
            width: 32px;
            height: 32px;
        }

        .type-name {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.75rem;
            color: #333;
        }

        .type-desc {
            font-size: 0.95rem;
            color: #666;
            line-height: 1.4;
        }

        /* Form sections */
        .form-container {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 2.5rem;
            display: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f0f0f0;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: #444;
            margin-bottom: 0.5rem;
        }

        .label span {
            color: #bf0000;
        }

        .input-field {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            outline: none;
            transition: all 0.2s;
        }

        .input-field:focus {
            border-color: #bf0000;
            box-shadow: 0 0 0 3px rgba(191, 0, 0, 0.1);
        }

        /* File input custom */
        .file-upload {
            border: 2px dashed #ccc;
            padding: 2rem;
            border-radius: 8px;
            text-align: center;
            background: #fafafa;
            cursor: pointer;
            transition: all 0.2s;
        }

        .file-upload:hover {
            border-color: #bf0000;
            background: #fdf2f2;
        }

        .file-upload svg {
            width: 40px;
            height: 40px;
            color: #999;
            margin-bottom: 1rem;
        }

        .file-upload p {
            font-size: 0.9rem;
            color: #666;
        }

        .file-upload strong {
            color: #bf0000;
        }

        .btn-submit {
            background: #bf0000;
            color: white;
            border: none;
            width: 100%;
            padding: 1rem;
            border-radius: 6px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 1rem;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: #a00000;
        }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 1.5rem;
            color: #666;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .btn-back:hover {
            text-decoration: underline;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .type-selector { grid-template-columns: 1fr; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('home') }}" class="logo">
            <img src="https://laravel.com/img/logomark.min.svg" alt="Logo">
            Mady Market
        </a>
    </header>

    <div class="container">
        <div class="step-header">
            @if(auth()->user()->estVendeur())
                <h1>Mettre à jour mes documents KYC</h1>
                <p>Besoin de renouveler un document ou de modifier vos informations ?</p>
            @else
                <h1>Rejoignez les vendeurs Mady Market</h1>
                <p>Vendez vos produits en quelques clics à travers toute la Centrafrique.</p>
            @endif
        </div>

        @if(!auth()->user()->estVendeur())
            <div class="type-selector">
                <div class="type-card" id="particulier-card" onclick="selectType('particulier')">
                    <div class="type-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div class="type-name">Vendeur Particulier</div>
                    <div class="type-desc">Idéal pour vendre des objets d'occasion ou occasionnels. Inscription simple avec votre CNI.</div>
                </div>

                <div class="type-card" id="professionnel-card" onclick="selectType('professionnel')">
                    <div class="type-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m-4 6h4m-4 4h4m1 1H7"></path></svg>
                    </div>
                    <div class="type-name">Vendeur Professionnel</div>
                    <div class="type-desc">Pour les entreprises, boutiques et artisans. Avantages pro, Page Pro exclusive et commissions réduites.</div>
                </div>
            </div>
        @else
            <!-- Si déjà vendeur, on force le formulaire correspondant -->
            <script>
                window.onload = function() {
                    selectType('{{ auth()->user()->vendeur->type }}', true);
                }
            </script>
        @endif

        <!-- Formulaire Particulier -->
        <div id="form-particulier" class="form-container">
            <h2 class="form-title">Informations Vendeur Particulier</h2>
            <form action="{{ route('vendeur.store.particulier') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="label">Type de pièce d'identité <span>*</span></label>
                        <select name="type_document" class="input-field" required>
                            <option value="cni">Carte Nationale d'Identité (CNI)</option>
                            <option value="passeport">Passeport</option>
                            <option value="recepisse">Récépissé officiel</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="label">Numéro du document <span>*</span></label>
                        <input type="text" name="numero_document" class="input-field" placeholder="Ex: 12345678" required>
                    </div>
                    <div class="form-group">
                        <label class="label">Date d'émission <span>*</span></label>
                        <input type="date" name="date_emission_document" class="input-field" required>
                    </div>
                    <div class="form-group">
                        <label class="label">Date d'expiration</label>
                        <input type="date" name="date_expiration_document" class="input-field">
                    </div>
                </div>

                <div class="form-group">
                    <label class="label">Scan / Photo du document (Recto/Verso ou Page Photo) <span>*</span></label>
                    <div class="file-upload" onclick="document.getElementById('doc-particulier').click()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        <p><strong>Cliquez ici</strong> pour sélectionner votre fichier</p>
                        <p style="font-size: 0.8rem; margin-top: 0.5rem;">PDF, JPG, PNG (Max 5 Mo)</p>
                        <input type="file" id="doc-particulier" name="document" style="display: none;" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>

                <div id="file-name-particulier" style="margin-top: -1rem; margin-bottom: 1.5rem; font-size: 0.85rem; color: #bf0000; font-weight: bold;"></div>

                <button type="submit" class="btn-submit">Valider et soumettre mon dossier</button>
                <a href="#" onclick="cancelSelection()" class="btn-back">Changer de type de compte</a>
            </form>
        </div>

        <!-- Formulaire Professionnel -->
        <div id="form-professionnel" class="form-container">
            <h2 class="form-title">Informations Entreprise / Professionnel</h2>
            <form action="{{ route('vendeur.store.professionnel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="label">Nom de l'entreprise ou enseigne commerciale <span>*</span></label>
                    <input type="text" name="nom_entreprise" class="input-field" placeholder="Ex: Boutique Mady Market Bangui" required>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="label">N° Registre de Commerce (RCCM)</label>
                        <input type="text" name="numero_registre_commerce" class="input-field" placeholder="Ex: RCA/BGUI/...">
                    </div>
                    <div class="form-group">
                        <label class="label">N° Identification Fiscale (NIF)</label>
                        <input type="text" name="numero_identification_fiscale" class="input-field" placeholder="Numéro NIF">
                    </div>
                </div>

                <div class="form-group">
                    <label class="label">Scan du Registre de Commerce ou NIF <span>*</span></label>
                    <div class="file-upload" onclick="document.getElementById('doc-pro').click()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p><strong>Cliquez ici</strong> pour uploader votre document officiel</p>
                        <p style="font-size: 0.8rem; margin-top: 0.5rem;">PDF, JPG, PNG (Max 5 Mo)</p>
                        <input type="file" id="doc-pro" name="registre_commerce" style="display: none;" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                </div>

                <div id="file-name-pro" style="margin-top: -1rem; margin-bottom: 1.5rem; font-size: 0.85rem; color: #bf0000; font-weight: bold;"></div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="label">Téléphone Entreprise <span>*</span></label>
                        <input type="tel" name="telephone_entreprise" class="input-field" placeholder="Ex: +236 ...">
                    </div>
                    <div class="form-group">
                        <label class="label">Email Entreprise <span>*</span></label>
                        <input type="email" name="email_entreprise" class="input-field" placeholder="contact@entreprise.com">
                    </div>
                </div>

                <div class="form-group">
                    <label class="label">Adresse physique du siège / boutique <span>*</span></label>
                    <input type="text" name="adresse_entreprise" class="input-field" placeholder="Ex: Avenue Barthélémy Boganda, Bangui">
                </div>

                <button type="submit" class="btn-submit">Finaliser mon inscription Pro</button>
                <a href="#" onclick="cancelSelection()" class="btn-back">Changer de type de compte</a>
            </form>
        </div>
        
        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('dashboard') }}" style="color: #666; text-decoration: none;">Retour au tableau de bord</a>
        </div>
    </div>

    <script>
        function selectType(type, force = false) {
            // Effets visuels
            document.querySelectorAll('.type-card').forEach(card => card.classList.remove('selected'));
            document.getElementById(type + '-card').classList.add('selected');
            
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
        document.getElementById('doc-particulier').addEventListener('change', function(e) {
            document.getElementById('file-name-particulier').innerText = "Fichier sélectionné : " + e.target.files[0].name;
        });
        document.getElementById('doc-pro').addEventListener('change', function(e) {
            document.getElementById('file-name-pro').innerText = "Fichier sélectionné : " + e.target.files[0].name;
        });
    </script>
</body>
</html>
