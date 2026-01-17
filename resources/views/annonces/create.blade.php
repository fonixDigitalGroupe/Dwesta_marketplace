@extends('layouts.app')

@section('title', 'Créer une annonce')

@push('styles')
    <style>
        <style>* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
        }

        /* Banner style Rakuten */
        .top-banner {
            background-color: #bf0000;
            color: white;
            text-align: center;
            padding: 0.5rem;
            font-size: 0.9rem;
            position: relative;
        }

        .top-banner .close-btn {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        /* Header style Rakuten */
        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 0.75rem 0;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .search-field {
            flex: 1;
            display: flex;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            font-size: 1rem;
            outline: none;
        }

        .search-button {
            background-color: #333;
            color: white;
            border: none;
            padding: 0 1.25rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-button:hover {
            background-color: #000;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-shrink: 0;
        }

        .header-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #333;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .header-link:hover {
            color: #bf0000;
        }

        .header-link svg {
            width: 22px;
            height: 22px;
        }

        .club-r {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.4rem 0.8rem;
            background: #fdf2f2;
            border-radius: 20px;
            color: #bf0000;
            font-weight: bold;
            font-size: 0.85rem;
            text-decoration: none;
        }

        /* Bouton Mettre en vente */
        .sell-button-container {
            position: relative;
        }

        .sell-button {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #333;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            background: white;
            border: none;
            padding: 0.5rem;
        }

        .sell-button:hover {
            color: #bf0000;
        }

        .sell-button .chevron {
            width: 12px;
            height: 12px;
            transition: transform 0.2s;
        }

        .sell-button.active .chevron {
            transform: rotate(180deg);
        }

        /* Dropdown Mettre en vente */
        .sell-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            margin-top: 0.5rem;
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 280px;
            z-index: 1000;
            display: none;
        }

        .sell-dropdown.show {
            display: block;
        }

        .sell-dropdown-item {
            display: block;
            padding: 1rem;
            text-decoration: none;
            color: #333;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
        }

        .sell-dropdown-item:last-child {
            border-bottom: none;
        }

        .sell-dropdown-item:hover {
            background-color: #f5f5f5;
        }

        .sell-dropdown-item-title {
            font-weight: 500;
            font-size: 0.95rem;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .sell-dropdown-item-subtitle {
            font-size: 0.85rem;
            color: #666;
        }

        .create-annonce-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 3rem;
        }

        /* Sidebar gauche - Indicateur de progression */
        .progress-sidebar {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 2rem 1.5rem;
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .progress-step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 2rem;
            position: relative;
        }

        .progress-step:last-child {
            margin-bottom: 0;
        }

        .progress-step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 12px;
            top: 32px;
            width: 2px;
            height: calc(100% + 0.5rem);
            background: #e0e0e0;
        }

        .progress-step.active:not(:last-child)::after {
            background: #bf0000;
        }

        .step-circle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .progress-step.active .step-circle {
            border-color: #bf0000;
            background: #bf0000;
        }

        .progress-step.completed .step-circle {
            border-color: #bf0000;
            background: #bf0000;
        }

        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
            display: none;
        }

        .progress-step.active .step-dot {
            display: block;
        }

        .step-content {
            flex: 1;
        }

        .step-title {
            font-weight: 600;
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .progress-step.active .step-title {
            color: #bf0000;
        }

        .step-number {
            font-size: 0.75rem;
            color: #666;
            font-weight: 500;
        }

        .progress-step.active .step-number {
            color: #bf0000;
        }

        /* Contenu principal */
        .form-content {
            background: white;
            border-radius: 8px;
            padding: 3rem;
        }

        .form-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-instructions {
            margin-bottom: 2rem;
        }

        .instruction-text {
            font-size: 0.95rem;
            color: #666;
            line-height: 1.6;
            margin-bottom: 0.5rem;
        }

        .instruction-text strong {
            color: #bf0000;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            font-size: 1rem;
            font-family: inherit;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            border-color: #bf0000;
        }

        .form-input-wrapper {
            position: relative;
        }

        .char-counter {
            position: absolute;
            bottom: 0.75rem;
            right: 1rem;
            font-size: 0.85rem;
            color: #999;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 3rem;
        }

        .btn {
            padding: 0.75rem 2rem;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #bf0000;
            color: white;
        }

        .btn-primary:hover {
            background: #0f2415;
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background: #d0d0d0;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Étapes du formulaire */
        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
        }

        .step-indicator {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            font-size: 0.85rem;
            color: #666;
        }

        /* Upload d'images */
        .image-upload-area {
            border: 2px dashed #e0e0e0;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            background: #f9f9f9;
            cursor: pointer;
            transition: all 0.2s;
        }

        .image-upload-area:hover {
            border-color: #bf0000;
            background: #f5f5f5;
        }

        .image-upload-area.dragover {
            border-color: #bf0000;
            background: #f0f0f0;
        }

        .image-upload-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 1rem;
            color: #999;
        }

        .image-upload-text {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .image-upload-hint {
            color: #999;
            font-size: 0.85rem;
        }

        .image-preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .image-preview-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e0e0e0;
        }

        .image-preview-item.main {
            border-color: #bf0000;
            border-width: 3px;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-actions {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            display: flex;
            gap: 0.5rem;
        }

        .image-preview-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: none;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            transition: background 0.2s;
        }

        .image-preview-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .image-preview-main-badge {
            position: absolute;
            bottom: 0.5rem;
            left: 0.5rem;
            background: #bf0000;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .file-input-hidden {
            display: none;
        }

@endpush
    @section('content')

            <div class="create-annonce-container">< !-- Sidebar gauche - Indicateur de progression --><aside class="progress-sidebar"><div class="progress-step active" data-step="1"><div class="step-circle"><div class="step-dot"></div></div><div class="step-content"><div class="step-number">ETAPE 1</div><div class="step-title">Votre annonce</div></div></div><div class="progress-step" data-step="2"><div class="step-circle"></div><div class="step-content"><div class="step-number">ETAPE 2</div><div class="step-title">Caractéristiques</div></div></div><div class="progress-step" data-step="3"><div class="step-circle"></div><div class="step-content"><div class="step-number">ETAPE 3</div><div class="step-title">Description</div></div></div><div class="progress-step" data-step="4"><div class="step-circle"></div><div class="step-content"><div class="step-number">ETAPE 4</div><div class="step-title">Caractéristiques</div></div></div><div class="progress-step" data-step="5"><div class="step-circle"></div><div class="step-content"><div class="step-number">ETAPE 5</div><div class="step-title">Livraison</div></div></div><div class="progress-step" data-step="6"><div class="step-circle"></div><div class="step-content"><div class="step-number">ETAPE 6</div><div class="step-title">Options & Publication</div></div></div></aside>< !-- Contenu principal --><main class="form-content"><form id="createAnnonceForm" method="POST" action="{{ route('annonces.store') }}" enctype="multipart/form-data">@csrf <input type="hidden" name="type" value="produit"><input type="hidden" id="currentStep" value="1">< !-- Étape 1: Votre annonce --><div class="form-step active" id="step1"><h1 class="form-title">Que vendez-vous aujourd'hui ? 👋
         </h1><div class="form-instructions"><p class="instruction-text">Indiquez quelques <strong>caractéristiques</strong>de votre produit pour faciliter sa recherche dans notre catalogue. </p><p class="instruction-text">Ne précisez pas l'état de votre produit, cette information vous sera demandée ultérieurement.
         </p></div><div class="form-group"><label for="product_name" class="form-label">Nom du produit</label><div class="form-input-wrapper"><input type="text"
            id="product_name"
            name="titre"
            class="form-input"
            placeholder="Nom ou code barre du produit"
            maxlength="200"
            required><span class="char-counter"><span id="charCount">0</span>/200 </span></div></div><div class="form-actions"><button type="button" class="btn btn-secondary" onclick="window.history.back()">Annuler </button><button type="button" class="btn btn-primary" onclick="nextStep()">Continuer </button></div></div>< !-- Étape 2: Caractéristiques --><div class="form-step" id="step2"><h1 class="form-title">Caractéristiques du produit </h1><div class="form-instructions"><p class="instruction-text">Décrivez les caractéristiques principales de votre produit. </p></div><div class="form-group"><label for="categorie_id" class="form-label">Catégorie <span style="color: #bf0000;">*</span></label><select id="categorie_id" name="categorie_id" class="form-input" required><option value="">Sélectionnez une catégorie</option>
            @foreach($categories as $categorie)
                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                @if($categorie->enfantsActifs && $categorie->enfantsActifs->count() > 0)
                    @foreach($categorie->enfantsActifs as $enfant)
                        <option value="{{ $enfant->id }}">&nbsp;
                        &nbsp;
                        →
                        {{ $enfant->nom }}
            </option>@endforeach @endif @endforeach </select></div><div class="form-group"><label for="prix" class="form-label">Prix (€) <span style="color: #bf0000;">*</span></label><input type="number"
            id="prix"
            name="prix"
            class="form-input"
            placeholder="0.00"
            step="0.01"
            min="0"
            required></div><div class="form-group"><label for="prix_moyen_marche" class="form-label">Prix moyen du marché (€)</label><input type="number"
            id="prix_moyen_marche"
            name="prix_moyen_marche"
            class="form-input"
            placeholder="Optionnel"
            step="0.01"
            min="0"
            ><small style="color: #666; font-size: 0.875rem; margin-top: 0.5rem; display: block;">Prix moyen du marché pour référence (optionnel) </small></div><div class="form-actions"><button type="button" class="btn btn-secondary" onclick="previousStep()">Précédent </button><button type="button" class="btn btn-primary" onclick="nextStep()">Continuer </button></div></div>< !-- Étape 3: Description et Photos --><div class="form-step" id="step3"><h1 class="form-title">Description du produit </h1><div class="form-instructions"><p class="instruction-text">Décrivez votre produit en détail pour attirer les acheteurs. </p></div><div class="form-group"><label for="description" class="form-label">Description</label><textarea id="description"
            name="description"
            class="form-input"
            rows="6"
            placeholder="Décrivez votre produit..."
            required></textarea></div><div class="form-group"><label class="form-label">Photos du produit <span style="color: #bf0000;">*</span></label><div class="image-upload-area" id="imageUploadArea" onclick="document.getElementById('photosInput').click()"><svg class="image-upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg><div class="image-upload-text">Cliquez pour ajouter des photos ou glissez-déposez</div><div class="image-upload-hint">4-8 photos obligatoires, formats JPG, PNG, WEBP (max 5 Mo chacune)</div></div><input type="file"
            id="photosInput"
            name="photos[]"
            accept="image/jpeg,image/jpg,image/png,image/webp"
            multiple class="file-input-hidden"
            ><div class="image-preview-container" id="imagePreviewContainer"></div></div><div class="form-actions"><button type="button" class="btn btn-secondary" onclick="previousStep()">Précédent </button><button type="button" class="btn btn-primary" onclick="nextStep()">Continuer </button></div></div>< !-- Étape 4: Caractéristiques détaillées --><div class="form-step" id="step4"><h1 class="form-title">Caractéristiques détaillées </h1><div class="form-instructions"><p class="instruction-text">Ajoutez des détails supplémentaires sur votre produit pour aider les acheteurs. </p></div><div class="form-group"><label for="marque" class="form-label">Marque</label><input type="text"
            id="marque"
            name="marque"
            class="form-input"
            placeholder="Ex: Apple"
            ></div><div class="form-group"><label for="modele" class="form-label">Modèle</label><input type="text"
            id="modele"
            name="modele"
            class="form-input"
            placeholder="Ex: iPhone 13 Pro Max"
            ></div><div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;"><div class="form-group"><label for="etat" class="form-label">État</label><select id="etat" name="etat" class="form-input"><option value="">Sélectionnez</option><option value="Neuf">Neuf</option><option value="Occasion">Occasion</option><option value="Reconditionné">Reconditionné</option></select></div><div class="form-group"><label for="quantite" class="form-label">Quantité</label><input type="number"
            id="quantite"
            name="quantite"
            class="form-input"
            placeholder="1"
            min="1"
            value="1"
            ></div></div><div class="form-group"><label class="form-label">Variantes de produit (Tailles, Couleurs, etc.)</label><p style="font-size: 0.85rem; color: #666; margin-bottom: 1rem;">Ajoutez des variantes si votre produit est disponible en différentes tailles, couleurs ou matières. </p><div id="variantsContainer" style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">< !-- Les variantes seront ajoutées ici --></div><button type="button" class="btn btn-secondary" style="width: 100%; border: 1px dashed #bf0000; background: #fff; color: #bf0000; font-weight: bold;" onclick="addVariant()">+Ajouter une variante (Taille, Couleur...) </button></div><div class="form-actions"><button type="button" class="btn btn-secondary" onclick="previousStep()">Précédent </button><button type="button" class="btn btn-primary" onclick="nextStep()">Continuer </button></div></div>< !-- Étape 5: Livraison et Disponibilité --><div class="form-step" id="step5"><h1 class="form-title">Livraison et Disponibilité </h1><div class="form-instructions"><p class="instruction-text">Indiquez comment vous souhaitez expédier votre produit et sa disponibilité. </p></div><div class="form-group"><label for="type_livraison" class="form-label">Moyens d'expédition</label>
         <select id="type_livraison" name="type_livraison" class="form-input" required><option value="">Sélectionnez une option <span style="color: #bf0000;">*</span></option><option value="retrait_boutique">Retrait en boutique</option><option value="livraison_domicile">Livraison à domicile</option><option value="livraison_point_relais">Livraison en point relais</option></select><small style="color: #666; font-size: 0.875rem; margin-top: 0.5rem; display: block;">Indiquez comment vous souhaitez expédier votre produit. </small></div><div class="form-group"><label for="disponibilite" class="form-label">Disponibilité <span style="color: #bf0000;">*</span></label><select id="disponibilite" name="disponibilite" class="form-input" required><option value="en_stock" selected>En stock</option><option value="rupture_stock">Rupture de stock</option><option value="sur_commande">Sur commande</option></select></div><div class="form-actions"><button type="button" class="btn btn-secondary" onclick="previousStep()">Précédent </button><button type="button" class="btn btn-primary" onclick="nextStep()">Continuer </button></div></div>< !-- Étape 6: Options payantes et Publication --><div class="form-step" id="step6"><h1 class="form-title">Options payantes et Publication </h1><div class="form-instructions"><p class="instruction-text">Choisissez des options pour mettre en avant votre annonce et décidez de sa publication. </p></div>
            @if(isset($optionsDisponibles) && count($optionsDisponibles) > 0)
                <div class="form-group" style="margin-bottom: 2rem;"><label class="form-label">Options payantes (optionnel)</label><div style="background: #f8f9fa; padding: 1.5rem; border-radius: 8px; margin-top: 0.5rem;">
                @foreach($optionsDisponibles as $key => $option)
                    <div style="margin-bottom: 1rem; display: flex; align-items: start; gap: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e0e0e0;"><input type="checkbox"
                    name="options[{{ $key }}]"
                    id="option_{{ $key }}"
                    value="1"
                    style="margin-top: 0.25rem; width: 20px; height: 20px; cursor: pointer;"
                    ><div style="flex: 1;"><label for="option_{{ $key }}" style="color: #333; font-weight: 500; cursor: pointer; display: block; margin-bottom: 0.25rem;">
                    {{ $option['nom'] }}
                    -
                    {{ number_format($option['prix'], 0, ',', ' ') }}
                    €
                    @if($option['duree'])
            ({{ $option['duree'] }} jours) @endif </label><p style="color: #666; font-size: 0.875rem; margin: 0;">{{ $option['description'] }}</p></div></div>@endforeach </div></div>@endif <div class="form-group"><label for="statut" class="form-label">Statut de publication</label><select id="statut" name="statut" class="form-input"><option value="brouillon" selected>Enregistrer en brouillon</option><option value="publiee">Publier immédiatement</option></select><small style="color: #666; font-size: 0.875rem; margin-top: 0.5rem; display: block;">Vous pourrez publier votre annonce plus tard depuis votre tableau de bord. </small></div><div class="form-actions"><button type="button" class="btn btn-secondary" onclick="previousStep()">Précédent </button><button type="submit" class="btn btn-primary" id="submitButton">Enregistrer l'annonce
         </button></div></div></form></main></div><script>let currentStep=1;
            const totalSteps=6;

            // Initialisation au chargement de la page
            document.addEventListener('DOMContentLoaded', function() {

                    // S'assurer que seule l'étape 1 est visible
                    document.querySelectorAll('.form-step').forEach((step, index)=> {
                            if (index===0) {
                                step.classList.add('active');
                            }

                            else {
                                step.classList.remove('active');
                            }
                        });

                    // Compteur de caractères
                    const productNameInput=document.getElementById('product_name');
                    const charCount=document.getElementById('charCount');

                    if (productNameInput && charCount) {
                        productNameInput.addEventListener('input', function() {
                                charCount.textContent=this.value.length;
                            });
                    }

                    // Initialiser les éléments d'upload d'images
                    photosInput=document.getElementById('photosInput');
                    imagePreviewContainer=document.getElementById('imagePreviewContainer');
                    imageUploadArea=document.getElementById('imageUploadArea');

                    if (photosInput && imagePreviewContainer && imageUploadArea) {
                        photosInput.addEventListener('change', function(e) {
                                handleFiles(Array.from(e.target.files));
                            });

                        // Drag and drop
                        imageUploadArea.addEventListener('dragover', function(e) {
                                e.preventDefault();
                                imageUploadArea.classList.add('dragover');
                            });

                        imageUploadArea.addEventListener('dragleave', function(e) {
                                e.preventDefault();
                                imageUploadArea.classList.remove('dragover');
                            });

                        imageUploadArea.addEventListener('drop', function(e) {
                                e.preventDefault();
                                imageUploadArea.classList.remove('dragover');
                                const files=Array.from(e.dataTransfer.files).filter(file=> file.type.startsWith ('image/'));
                                handleFiles(files);
                            });
                    }
                });

            // Navigation entre les étapes
            function nextStep() {
                console.log('nextStep called, currentStep:', currentStep, 'totalSteps:', totalSteps);

                // Valider l'étape actuelle
                if ( !validateCurrentStep()) {
                    console.log('Validation failed, stopping');
                    return false;
                }

                // Vérifier qu'on n'est pas à la dernière étape
                if (currentStep >=totalSteps) {
                    console.log('Already at last step, submitting form');
                    // Si on est à la dernière étape, soumettre le formulaire
                    document.getElementById('createAnnonceForm').submit();
                    return true;
                }

                // Masquer l'étape actuelle
                const currentStepElement=document.getElementById('step' + currentStep);
                const currentProgressStep=document.querySelector(`.progress-step[data-step="${currentStep}"]`);

                if ( !currentStepElement) {
                    console.error('Current step element not found:', 'step' + currentStep);
                    alert('Erreur: étape actuelle introuvable');
                    return false;
                }

                currentStepElement.classList.remove('active');
                console.log('Hidden step', currentStep);

                if (currentProgressStep) {
                    currentProgressStep.classList.remove('active');
                }

                // Passer à l'étape suivante
                currentStep++;
                const currentStepInput=document.getElementById('currentStep');

                if (currentStepInput) {
                    currentStepInput.value=currentStep;
                }

                // Afficher la nouvelle étape
                const nextStepElement=document.getElementById('step' + currentStep);
                const nextProgressStep=document.querySelector(`.progress-step[data-step="${currentStep}"]`);

                if ( !nextStepElement) {
                    console.error('Next step element not found:', 'step' + currentStep);
                    alert('Erreur: étape suivante introuvable');
                    // Revenir en arrière
                    currentStep--;
                    currentStepElement.classList.add('active');
                    return false;
                }

                nextStepElement.classList.add('active');
                console.log('Shown step', currentStep);

                if (nextProgressStep) {
                    nextProgressStep.classList.add('active');
                }

                // Marquer l'étape précédente comme complétée
                const prevProgressStep=document.querySelector(`.progress-step[data-step="${currentStep - 1}"]`);

                if (prevProgressStep) {
                    prevProgressStep.classList.add('completed');
                }

                return true;
            }

            function previousStep() {
                if (currentStep > 1) {
                    // Masquer l'étape actuelle
                    const currentStepElement=document.getElementById('step' + currentStep);
                    const currentProgressStep=document.querySelector(`.progress-step[data-step="${currentStep}"]`);

                    if (currentStepElement) currentStepElement.classList.remove('active');
                    if (currentProgressStep) currentProgressStep.classList.remove('active');

                    // Revenir à l'étape précédente
                    currentStep--;
                    const currentStepInput=document.getElementById('currentStep');
                    if (currentStepInput) currentStepInput.value=currentStep;

                    // Afficher l'étape précédente
                    const prevStepElement=document.getElementById('step' + currentStep);
                    const prevProgressStep=document.querySelector(`.progress-step[data-step="${currentStep}"]`);

                    if (prevStepElement) prevStepElement.classList.add('active');
                    if (prevProgressStep) prevProgressStep.classList.add('active');

                    // Retirer le statut complété de l'étape suivante
                    const nextProgressStep=document.querySelector(`.progress-step[data-step="${currentStep + 1}"]`);
                    if (nextProgressStep) nextProgressStep.classList.remove('completed');
                }
            }

            function validateCurrentStep() {
                console.log('Validating step:', currentStep);

                if (currentStep===1) {
                    const productNameInput=document.getElementById('product_name');

                    if ( !productNameInput) {
                        console.error('product_name input not found');
                        return false;
                    }

                    const productName=productNameInput.value.trim();

                    if ( !productName) {
                        alert('Veuillez saisir le nom du produit.');
                        productNameInput.focus();
                        return false;
                    }

                    if (productName.length < 3) {
                        alert('Le nom du produit doit contenir au moins 3 caractères.');
                        productNameInput.focus();
                        return false;
                    }

                    console.log('Step 1 validation passed');
                    return true;
                }

                else if (currentStep===2) {
                    const categorieInput=document.getElementById('categorie_id');
                    const prixInput=document.getElementById('prix');

                    if ( !categorieInput || !prixInput) {
                        console.error('Step 2 inputs not found');
                        return false;
                    }

                    const categorie=categorieInput.value;
                    const prix=prixInput.value;

                    if ( !categorie) {
                        alert('Veuillez sélectionner une catégorie.');
                        categorieInput.focus();
                        return false;
                    }

                    if ( !prix || parseFloat(prix) <=0) {
                        alert('Veuillez saisir un prix valide.');
                        prixInput.focus();
                        return false;
                    }

                    console.log('Step 2 validation passed');
                    return true;
                }

                else if (currentStep===3) {
                    const descriptionInput=document.getElementById('description');
                    const photosInput=document.getElementById('photosInput');

                    if ( !descriptionInput) {
                        console.error('description input not found');
                        return false;
                    }

                    const description=descriptionInput.value.trim();

                    if ( !description) {
                        alert('Veuillez saisir une description.');
                        descriptionInput.focus();
                        return false;
                    }

                    if (description.length < 10) {
                        alert('La description doit contenir au moins 10 caractères.');
                        descriptionInput.focus();
                        return false;
                    }

                    // Vérifier les fichiers uploadés
                    if (typeof uploadedImages==='undefined' || uploadedImages.length===0) {
                        if ( !photosInput || !photosInput.files || photosInput.files.length===0) {
                            alert('Veuillez ajouter au moins 4 photos du produit.');
                            return false;
                        }
                    }

                    const totalFiles=(typeof uploadedImages !=='undefined' ? uploadedImages.length : 0)+(photosInput && photosInput.files ? photosInput.files.length : 0);

                    if (totalFiles < 4) {
                        alert('Veuillez ajouter au moins 4 photos du produit.');
                        return false;
                    }

                    if (totalFiles > 8) {
                        alert('Vous ne pouvez pas ajouter plus de 8 photos.');
                        return false;
                    }

                    console.log('Step 3 validation passed');
                    return true;
                }

                else if (currentStep===4) {
                    // Validation de l'étape 4 (caractéristiques détaillées - optionnelles)
                    console.log('Step 4 validation passed');
                    return true;
                }

                else if (currentStep===5) {
                    // Validation de l'étape 5 (livraison et disponibilité - optionnelles)
                    console.log('Step 5 validation passed');
                    return true;
                }

                else if (currentStep===6) {
                    // Validation de l'étape 6 (options et statut - optionnelles)
                    console.log('Step 6 validation passed');
                    return true;
                }

                console.log('No validation for step:', currentStep);
                return true;
            }

            // Gestion de l'upload d'images (variables globales)
            let uploadedImages=[];
            let mainImageIndex=0;
            let photosInput,
            imagePreviewContainer,
            imageUploadArea;

            function handleFiles(files) {
                files.forEach(file=> {
                        if (file.size > 5 * 1024 * 1024) {
                            alert(`Le fichier $ {
                                    file.name
                                }

                                est trop volumineux (max 5 Mo)`);
                            return;
                        }

                        const reader=new FileReader();

                        reader.onload=function(e) {
                            const imageData= {
                                file: file,
                                preview: e.target.result,
                                index: uploadedImages.length
                            }

                            ;
                            uploadedImages.push(imageData);
                            renderImagePreview();
                        }

                        ;
                        reader.readAsDataURL(file);
                    });
            }

            function renderImagePreview() {
                if ( !imagePreviewContainer) return;
                imagePreviewContainer.innerHTML='';

                uploadedImages.forEach((imageData, index)=> {
                        const previewItem=document.createElement('div');

                        previewItem.className=`image-preview-item $ {
                            index===mainImageIndex ? 'main' : ''
                        }

                        `;

                        previewItem.innerHTML=` <img src="${imageData.preview}" alt="Preview" > <div class="image-preview-actions" > $ {
                            index !==mainImageIndex ? `<button type="button" class="image-preview-btn" onclick="setMainImage(${index})" title="Définir comme photo principale" >⭐</button>` : ''
                        }

                        <button type="button" class="image-preview-btn" onclick="removeImage(${index})" title="Supprimer" >×</button> </div> $ {
                            index===mainImageIndex ? '<div class="image-preview-main-badge">Principale</div>' : ''
                        }

                        `;
                        imagePreviewContainer.appendChild(previewItem);
                    });

                // Mettre à jour l'input file
                updateFileInput();
            }

            function setMainImage(index) {
                mainImageIndex=index;
                renderImagePreview();
            }

            function removeImage(index) {
                uploadedImages.splice(index, 1);

                if (mainImageIndex >=uploadedImages.length) {
                    mainImageIndex=0;
                }

                else if (mainImageIndex > index) {
                    mainImageIndex--;
                }

                renderImagePreview();
            }

            function updateFileInput() {
                if ( !photosInput) {
                    console.warn('photosInput not found');
                    return;
                }

                // Créer un nouveau FileList avec les fichiers uploadés
                // Note: DataTransfer n'est pas toujours disponible, on utilise une approche alternative
                if (typeof DataTransfer !=='undefined') {
                    try {
                        const dt=new DataTransfer();

                        uploadedImages.forEach(imageData=> {
                                if (imageData && imageData.file) {
                                    dt.items.add(imageData.file);
                                }
                            });
                        photosInput.files=dt.files;
                        console.log('File input updated with', dt.files.length, 'files');
                    }

                    catch (e) {
                        console.warn('DataTransfer not supported:', e);
                        // Si DataTransfer n'est pas supporté, les fichiers dans uploadedImages
                        // devront être gérés côté serveur différemment
                    }
                }

                else {
                    console.warn('DataTransfer not available');
                }
            }

            // Validation finale avant soumission
            const form=document.getElementById('createAnnonceForm');
            const submitButton=document.getElementById('submitButton');

            if (form) {
                form.addEventListener('submit', function(e) {
                        console.log('Form submit event triggered, currentStep:', currentStep, 'totalSteps:', totalSteps);

                        // Si on n'est pas à la dernière étape, empêcher la soumission et aller à la dernière étape
                        if (currentStep < totalSteps) {
                            console.log('Not at last step, preventing submit and going to last step');
                            e.preventDefault();
                            e.stopPropagation();

                            // Aller directement à la dernière étape
                            // Masquer toutes les étapes
                            document.querySelectorAll('.form-step').forEach(step=> step.classList.remove('active'));

                            // Afficher la dernière étape
                            const lastStepElement=document.getElementById('step' + totalSteps);

                            if (lastStepElement) {
                                lastStepElement.classList.add('active');
                                currentStep=totalSteps;
                                const currentStepInput=document.getElementById('currentStep');

                                if (currentStepInput) {
                                    currentStepInput.value=currentStep;
                                }
                            }

                            // Mettre à jour la sidebar
                            document.querySelectorAll('.progress-step').forEach((step, index)=> {
                                    step.classList.remove('active', 'completed');

                                    if (index + 1 <=totalSteps) {
                                        if (index + 1===totalSteps) {
                                            step.classList.add('active');
                                        }

                                        else {
                                            step.classList.add('completed');
                                        }
                                    }
                                });

                            // Scroll vers le haut
                            window.scrollTo({
                                top: 0, behavior: 'smooth'
                            });

                        return false;
                    }

                    // Si on est à la dernière étape, valider avant de soumettre
                    console.log('At last step, validating current step...');

                    // Valider seulement l'étape actuelle (la dernière étape n'a pas de champs requis)
                    // Les validations des étapes précédentes ont déjà été faites lors de la navigation
                    if ( !validateCurrentStep()) {
                        console.log('Validation failed at last step');
                        e.preventDefault();
                        e.stopPropagation();
                        alert('Veuillez remplir tous les champs requis.');
                        return false;
                    }

                    // S'assurer que les fichiers sont bien attachés
                    if (uploadedImages && uploadedImages.length > 0) {
                        console.log('Updating file input with', uploadedImages.length, 'images');
                        updateFileInput();
                    }

                    console.log('Form submission allowed, submitting...');

                    // Désactiver le bouton pour éviter les doubles soumissions
                    if (submitButton) {
                        submitButton.disabled=true;
                        submitButton.textContent='Enregistrement en cours...';
                    }

                    // Laisser le formulaire se soumettre normalement
                    return true;
                });
            }

    @endsection @push('scripts') <script>let variantCount=0;

        function addVariant() {
            const container=document.getElementById('variantsContainer');
            const variantId=variantCount++;

            const variantHtml=` <div class="variant-item" id="variant_${variantId}" style="background: #fdf2f2; padding: 1rem; border-radius: 8px; border: 1px solid #ffcccc; position: relative;"><button type="button" onclick="removeVariant(${variantId})" style="position: absolute; top: 0.5rem; right: 0.5rem; background: none; border: none; font-size: 1.25rem; color: #bf0000; cursor: pointer;">&times;
            </button><div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 0.5rem;"><div><label style="font-size: 0.8rem; font-weight: bold; display: block; margin-bottom: 2px;">Type</label><select name="variantes[${variantId}][type]" class="form-input" style="padding: 0.5rem;"><option value="taille">Taille</option><option value="couleur">Couleur</option><option value="matiere">Matière</option><option value="autre">Autre</option></select></div><div><label style="font-size: 0.8rem; font-weight: bold; display: block; margin-bottom: 2px;">Valeur</label><input type="text" name="variantes[${variantId}][valeur]" class="form-input" style="padding: 0.5rem;" placeholder="Ex: XL, Rouge..."></div></div><div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;"><div><label style="font-size: 0.8rem; font-weight: bold; display: block; margin-bottom: 2px;">Stock</label><input type="number" name="variantes[${variantId}][stock]" class="form-input" style="padding: 0.5rem;" value="1" min="0"></div><div><label style="font-size: 0.8rem; font-weight: bold; display: block; margin-bottom: 2px;">Prix sup. (€)</label><input type="number" name="variantes[${variantId}][prix_supplementaire]" class="form-input" style="padding: 0.5rem;" value="0" step="0.01" min="0"></div></div></div>`;

            container.insertAdjacentHTML('beforeend', variantHtml);
        }

        function removeVariant(id) {
            const el=document.getElementById('variant_' + id);
            if (el) el.remove();
        }

    </script>@endpush