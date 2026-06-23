@extends('layouts.app')

@section('title', 'Modifier mon véhicule - Karnou')

@push('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: white;
        }

        /* Remove number input spinners */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .create-annonce-container {
            max-width: 1300px;
            margin: 3rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 240px 1fr 280px;
            gap: 2.5rem;
            align-items: flex-start;
        }

        /* Sidebar gauche - Indicateur de progression */
        .progress-sidebar {
            background: transparent;
            border: none;
            padding: 0;
            height: fit-content;
            position: sticky;
            top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 3.5rem;
        }

        .progress-step {
            display: flex;
            align-items: center;
            position: relative;
        }

        .progress-step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 16px;
            top: 32px;
            bottom: -3.5rem;
            width: 2px;
            background-color: #f0f0f0;
            z-index: 0;
        }

        .progress-step.completed:not(:last-child)::after {
            background-color: #00A400;
        }

        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.25rem;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .progress-step.active .step-circle {
            border-color: #00A400;
            background: white;
        }

        .progress-step.completed .step-circle {
            border-color: #00A400;
            background: #00A400;
        }

        .step-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #00A400;
            display: none;
        }

        .progress-step.active .step-dot {
            display: block;
        }

        .step-check {
            color: white;
            font-size: 14px;
            display: none;
        }

        .progress-step.completed .step-check {
            display: block;
        }

        .step-content {
            flex: 1;
            padding-top: 2px;
        }

        .step-number {
            font-size: 0.7rem;
            color: #888;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 2px;
            display: block;
        }

        .progress-step.active .step-number {
            color: #555;
        }

        .step-title {
            font-weight: 700;
            font-size: 0.9rem;
            color: #888;
            line-height: 1.2;
        }

        .progress-step.active .step-title {
            color: #222;
        }

        .progress-step.completed .step-title,
        .progress-step.completed .step-number {
            color: #00A400;
        }

        /* Contenu principal */
        .form-content {
            background: white;
            border-radius: 12px;
            padding: 2.25rem 2.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #eeeeee;
            max-width: 600px;
        }

        .form-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            line-height: 1.2;
        }

        .instruction-text {
            font-size: 0.9rem;
            color: #555;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }

        .instruction-text strong {
            color: #00A400;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.75rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.65rem;
            font-size: 0.875rem;
        }

        .form-input,
        select.form-input,
        textarea.form-input {
            width: 100%;
            max-width: 480px;
            padding: 0.65rem 1rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 6px;
            font-size: 0.95rem;
            font-family: inherit;
            outline: none;
            transition: all 0.2s ease;
            background: white;
        }

        .form-input:focus,
        select.form-input:focus,
        textarea.form-input:focus {
            border-color: black;
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }

        textarea.form-input {
            resize: vertical;
            min-height: 120px;
        }

        /* Image item for existing photos */
        .image-preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 110px));
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        .image-item {
            width: 110px;
            height: 110px;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }

        .image-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ccc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #333;
            font-size: 14px;
            z-index: 5;
            padding: 0;
            line-height: 1;
        }

        .remove-btn:hover {
            background: #fff;
            color: #ff0000;
            border-color: #ff0000;
        }

        /* Advisory Box */
        .advisory-container {
            position: sticky;
            top: 2rem;
            display: block;
        }

        .advisory-box {
            width: 280px;
            background-color: #f9f9f9;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .advisory-title {
            font-size: 1rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .advisory-text {
            font-size: 0.85rem;
            color: #666;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .advisory-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            color: #444;
            font-weight: 500;
        }

        .advisory-icon {
            width: 18px;
            height: 18px;
            background: #000;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 10px;
        }

        .form-step {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .form-step.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn {
            padding: 0.8rem 2rem;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
        }

        .btn-primary {
            background: #008400;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 132, 0, 0.15);
        }

        .btn-primary:hover {
            background: #007300;
            box-shadow: 0 4px 8px rgba(0, 115, 0, 0.2);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f5f5f5;
            color: #333;
            border: 1px solid #e0e0e0;
        }

        .btn-secondary:hover {
            background: #e5e5e5;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #f0f0f0;
        }

        /* Category Badges Styling */
        .category-badges-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .category-badge-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.6rem 1rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 50px;
            background: white;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            font-weight: 500;
            color: #444;
        }

        .category-badge-item:hover {
            border-color: #000;
            background: #fafafa;
        }

        .category-badge-item.selected {
            border-color: #000;
            background: #fff;
            color: #000;
            border-width: 1px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .category-badge-icon svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        /* Service Cards */
        .service-card {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        
        .service-card.already-active {
            background: #fafffa;
            border-color: #00A400;
            border-style: solid;
            cursor: default;
            opacity: 0.9;
        }

        /* Step 4: Booster styles */
        .service-card {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem;
            background: linear-gradient(135deg, #fff9db 0%, #fff3bf 100%);
            border: 2px dashed #fcc419;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            box-shadow: 0 4px 10px rgba(252, 196, 25, 0.05);
        }

        .service-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(252, 196, 25, 0.1);
            border-style: solid;
        }

        .service-checkbox {
            width: 22px;
            height: 22px;
            margin-top: 4px;
            accent-color: #f08c00;
        }

        #promo-section {
            animation: slideIn 0.4s ease-out;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 1024px) {
            .create-annonce-container {
                grid-template-columns: 1fr;
            }
            .advisory-container {
                display: none;
            }
            .progress-sidebar {
                display: none;
            }
            .form-content {
                max-width: 100%;
            }
        }
    </style>
@endpush

@section('content')
<div class="breadcrumb" style="max-width: 1300px; margin: 1rem auto; padding: 0 2rem;">
    <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('vendeur.mes-annonces') }}">Mes annonces</a> > <span>Modifier mon véhicule</span>
</div>

<div class="create-annonce-container">
    <aside class="progress-sidebar">
        <div class="progress-step active" data-step="1">
            <div class="step-circle">
                <div class="step-dot"></div>
                <div class="step-check">✓</div>
            </div>
            <div class="step-content">
                <span class="step-number">Étape 1</span>
                <div class="step-title">Véhicule & Catégorie</div>
            </div>
        </div>
        <div class="progress-step" data-step="2">
            <div class="step-circle">
                <div class="step-dot"></div>
                <div class="step-check">✓</div>
            </div>
            <div class="step-content">
                <span class="step-number">Étape 2</span>
                <div class="step-title">Modèle & Moteur</div>
            </div>
        </div>
        <div class="progress-step" data-step="3">
            <div class="step-circle">
                <div class="step-dot"></div>
                <div class="step-check">✓</div>
            </div>
            <div class="step-content">
                <span class="step-number">Étape 3</span>
                <div class="step-title">Détails & Photos</div>
            </div>
        </div>
        <div class="progress-step" data-step="4">
            <div class="step-circle">
                <div class="step-dot"></div>
                <div class="step-check">✓</div>
            </div>
            <div class="step-content">
                <span class="step-number">Étape 4</span>
                <div class="step-title">Options & Publication</div>
            </div>
        </div>
    </aside>

    <main class="form-content">
        <form id="editVehiculeForm" action="{{ route('annonces.update', $annonce) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="type" value="vehicule">
            <input type="hidden" id="type_livraison" name="type_livraison" value="{{ old('type_livraison', $annonce->type_livraison ?? 'retrait_point_relais') }}">
            <input type="hidden" id="user_phone" name="user_phone" value="{{ old('user_phone', $annonce->vendeur->user->telephone ?? auth()->user()->telephone ?? '00000000') }}">
            <input type="hidden" id="code_postal" name="code_postal" value="{{ old('code_postal', $annonce->code_postal ?? '00000') }}">

            <!-- Étape 1: Véhicule & Catégorie -->
            <div class="form-step active" id="step1">
                <h2 class="form-title">Modifier votre véhicule</h2>
                <div class="form-instructions">
                    <p class="instruction-text">Mettez à jour les informations essentielles de votre véhicule.</p>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Titre de l'annonce <span style="color: #bf0000;">*</span></label>
                    <input type="text" name="titre" value="{{ old('titre', $annonce->titre) }}" class="form-input" required maxlength="255" placeholder="Ex: Toyota Land Cruiser V8 2022">
                    @error('titre') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Catégorie <span style="color: #bf0000;">*</span></label>
                    <input type="hidden" id="categorie_id" name="categorie_id" value="{{ old('categorie_id', $annonce->categorie_id) }}" required>

                    <div class="category-badges-container">
                        @php
                            $rootCatId = null;
                            $curr = $annonce->category;
                            while($curr && $curr->parent_id) { $curr = $curr->parent; }
                            $rootCatId = $curr ? $curr->id : null;

                            $icons = [
                                'E-commerce' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>',
                                'Services' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>',
                                'Immobilier' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
                                'Véhicules' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="13" width="22" height="8" rx="2"></rect><path d="M7 13V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v7"></path></svg>'
                            ];
                        @endphp
                        @foreach($categories->where('parent_id', null) as $categorie)
                            <div class="category-badge-item main-cat-badge {{ $rootCatId == $categorie->id ? 'selected' : '' }}" data-id="{{ $categorie->id }}"
                                onclick="selectMainCategory(this, {{ $categorie->id }})">
                                <span class="category-badge-icon">
                                    @if($categorie->icone) {!! $categorie->icone !!}
                                    @else {!! $icons[$categorie->nom] ?? '...' !!}
                                    @endif
                                </span>
                                {{ $categorie->nom }}
                            </div>
                        @endforeach
                    </div>

                    <div id="level2Section" style="display:none; margin-top: 1.5rem;">
                        <label class="form-label">Sous-catégorie</label>
                        <select id="level2Select" class="form-input" onchange="onLevel2Change(this.value)">
                            <option value="">Choisir une option...</option>
                        </select>
                    </div>

                    <div id="level3Section" style="display:none; margin-top: 1.5rem;">
                        <label class="form-label">Précisition complémentaire</label>
                        <select id="level3Select" class="form-input" onchange="onLevel3Change(this.value)">
                            <option value="">Choisir une option...</option>
                        </select>
                    </div>

                    <div id="dynamic-filters-container" style="margin-top: 1.5rem;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Prix de vente (FCFA) <span style="color: #bf0000;">*</span></label>
                    <input type="number" name="prix" value="{{ old('prix', $annonce->prix) }}" class="form-input" required min="0" step="1">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(1)">Continuer</button>
                </div>
            </div>

            <!-- Étape 2: Modèle & Moteur -->
            <div class="form-step" id="step2">
                <ctrl94>h2 class="form-title">Spécifications techniques</h2>
                <div class="form-instructions">
                    <p class="instruction-text">Précisez les caractéristiques techniques du véhicule.</p>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Marque <span style="color: #bf0000;">*</span></label>
                        <input type="text" name="marque" value="{{ old('marque', $annonce->vehicule->marque ?? '') }}" class="form-input" required placeholder="Ex: Toyota">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Modèle <span style="color: #bf0000;">*</span></label>
                        <input type="text" name="modele" value="{{ old('modele', $annonce->vehicule->modele ?? '') }}" class="form-input" required placeholder="Ex: Prado">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Année</label>
                        <input type="number" name="annee" value="{{ old('annee', $annonce->vehicule->annee ?? '') }}" class="form-input" min="1900" max="{{ date('Y') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kilométrage (km)</label>
                        <input type="number" name="kilometrage" value="{{ old('kilometrage', $annonce->vehicule->kilometrage ?? '') }}" class="form-input" min="0">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label">Carburant</label>
                        <select name="carburant" class="form-input">
                            <option value="">Sélectionnez</option>
                            <option value="Essence" {{ (old('carburant', $annonce->vehicule->carburant ?? '') == 'Essence') ? 'selected' : '' }}>Essence</option>
                            <option value="Diesel" {{ (old('carburant', $annonce->vehicule->carburant ?? '') == 'Diesel') ? 'selected' : '' }}>Diesel</option>
                            <option value="Hybride" {{ (old('carburant', $annonce->vehicule->carburant ?? '') == 'Hybride') ? 'selected' : '' }}>Hybride</option>
                            <option value="Électrique" {{ (old('carburant', $annonce->vehicule->carburant ?? '') == 'Électrique') ? 'selected' : '' }}>Électrique</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Boîte de vitesse</label>
                        <select name="boite_vitesse" class="form-input">
                            <option value="">Sélectionnez</option>
                            <option value="Manuelle" {{ (old('boite_vitesse', $annonce->vehicule->boite_vitesse ?? '') == 'Manuelle') ? 'selected' : '' }}>Manuelle</option>
                            <option value="Automatique" {{ (old('boite_vitesse', $annonce->vehicule->boite_vitesse ?? '') == 'Automatique') ? 'selected' : '' }}>Automatique</option>
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Précédent</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(2)">Continuer</button>
                </div>
            </div>

            <!-- Étape 3: Détails & Photos -->
            <div class="form-step" id="step3">
                <h2 class="form-title">État & Photos</h2>
                <div class="form-instructions">
                    <p class="instruction-text">Donnez plus de détails sur l'état et montrez votre véhicule.</p>
                </div>

                <div class="form-group">
                    <label class="form-label">Description <span style="color: #bf0000;">*</span></label>
                    <textarea name="description" class="form-input" required minlength="20" placeholder="Décrivez l'historique d'entretien, les options installées, l'état général...">{{ old('description', $annonce->description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">État</label>
                        <select name="etat" class="form-input">
                            <option value="Neuf" {{ (old('etat', $annonce->vehicule->etat ?? '') == 'Neuf') ? 'selected' : '' }}>Neuf</option>
                            <option value="Occasion" {{ (old('etat', $annonce->vehicule->etat ?? '') == 'Occasion') ? 'selected' : '' }}>Occasion</option>
                            <option value="Reconditionné" {{ (old('etat', $annonce->vehicule->etat ?? '') == 'Reconditionné') ? 'selected' : '' }}>Reconditionné</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Couleur</label>
                        <input type="text" name="couleur" value="{{ old('couleur', $annonce->vehicule->couleur ?? '') }}" class="form-input" placeholder="Ex: Gris">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Portes</label>
                        <input type="number" name="portes" value="{{ old('portes', $annonce->vehicule->portes ?? '') }}" class="form-input" min="2" max="6">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Places</label>
                        <input type="number" name="places" value="{{ old('places', $annonce->vehicule->places ?? '') }}" class="form-input" min="1" max="60">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Photos du véhicule</label>
                    
                    @if($annonce->photos->count() > 0)
                        <div class="image-preview-container">
                            @foreach($annonce->photos as $photo)
                                <div class="image-item" id="media-{{ $photo->id }}">
                                    <img src="{{ asset('storage/' . $photo->chemin) }}" alt="Photo véhicule">
                                    <button type="button" class="remove-btn" onclick="markForDeletion({{ $photo->id }})">&times;</button>
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" name="delete_media_ids" id="delete_media_ids" value="">
                    @endif

                    <input type="file" name="photos[]" multiple class="form-input" accept="image/*">
                    <p style="font-size: 0.8rem; color: #666; margin-top: 0.5rem;">Formats JPG, PNG, WEBP. Max 5 Mo par photo.</p>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(3)">Précédent</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(3)">Continuer</button>
                </div>
            </div>

            <!-- Étape 4: Booster votre annonce -->
            <div class="form-step" id="step4">
                <span id="user-credit-balance" style="display: none;">{{ auth()->user()->credits }}</span>
                
                <div style="margin-bottom: 2rem;">
                    <h2 class="form-title" style="margin-bottom: 0.5rem;">🚀 Booster votre annonce</h2>
                    <p class="instruction-text" style="color: #666; font-size: 0.95rem;">Mettez votre véhicule en avant pour toucher plus d'acheteurs potentiels.</p>
                </div>

                {{-- === Section Code Promo (Etape 4) === --}}
                <div id="promo-section" style="display: none; margin-bottom: 2rem; padding: 1.25rem; background: linear-gradient(135deg, #fff9db 0%, #fff3bf 100%); border: 2px dashed #fcc419; border-radius: 12px; box-shadow: 0 4px 15px rgba(252, 196, 25, 0.1);">
                    <div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 0.75rem;">
                        <div style="flex: 1;">
                            <label style="font-size: 0.95rem; font-weight: 800; color: #856404; margin: 0; display: block;">
                                Boostez vos ventes gratuitement !
                            </label>
                            <p style="font-size: 0.8rem; color: #92700e; margin: 0.25rem 0 0.5rem 0; line-height: 1.4;">
                                Appliquez un code promo pour mettre en avant votre annonce. Un <strong>prix barré</strong> attire 3x plus d'acheteurs.
                            </p>
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.5rem; align-items: center; background: white; padding: 0.4rem; border-radius: 10px; border: 1.5px solid #ffec99;">
                        <input type="text" id="promo_code_input" placeholder="ENTREZ VOTRE CODE ICI"
                            style="flex: 1; padding: 0.6rem 0.75rem; border: none; border-radius: 6px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; outline: none; background: transparent;"
                            oninput="this.value = this.value.toUpperCase()">
                        <button type="button" onclick="applyPromoCode()"
                            style="padding: 0.6rem 1.25rem; background: #fcc419; color: #453b0c; border: none; border-radius: 8px; font-weight: 800; font-size: 0.85rem; cursor: pointer; transition: transform 0.2s;">
                            APPLIQUER
                        </button>
                    </div>
                    
                    <div id="promo-error" style="display: none; color: #e03131; font-size: 0.75rem; margin-top: 0.5rem; font-weight: 600; padding-left: 0.5rem;"></div>

                    {{-- Prévisualisation Premium --}}
                    <div id="promo-preview" style="display: none; margin-top: 1rem; padding: 1rem; background: white; border-radius: 10px; border: 1px solid #ffec99; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div>
                                    <span style="font-size: 0.7rem; color: #adb5bd; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 2px;">Prix Initial</span>
                                    <span id="promo-original-price" style="font-size: 0.95rem; color: #adb5bd; text-decoration: line-through; font-weight: 600;"></span>
                                </div>
                                <div style="font-size: 1.25rem; color: #fab005;">➜</div>
                                <div>
                                    <span style="font-size: 0.7rem; color: #fa5252; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 2px;">Prix Flash</span>
                                    <span id="promo-discounted-price" style="font-size: 1.15rem; color: #2b8a3e; font-weight: 900;"></span>
                                </div>
                            </div>
                            <div id="promo-badge" style="background: #fa5252; color: white; font-size: 0.85rem; font-weight: 900; padding: 4px 10px; border-radius: 6px; box-shadow: 0 2px 5px rgba(250, 82, 82, 0.3);"></div>
                        </div>
                        <div id="promo-success-text" style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #f1f3f5; font-size: 0.75rem; color: #495057; font-weight: 600;"></div>
                    </div>
                    <input type="hidden" id="promo_code" name="promo_code" value="">
                </div>

                <div style="margin-bottom: 2rem;">
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">Options de visibilité</h3>
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        @php
                            $activeServices = \App\Models\AnnonceCreditService::where('annonce_id', $annonce->id)
                                ->actif()
                                ->pluck('service')
                                ->toArray();
                        @endphp

                        @foreach($creditServices as $service)
                            @if($service->cle == 'urgent') @continue @endif
                            @php
                                $isAlreadyActive = in_array($service->cle, $activeServices);
                            @endphp
                            <label class="service-card {{ $isAlreadyActive ? 'already-active' : '' }}">
                                @if($isAlreadyActive)
                                    <div style="width: 22px; height: 22px; margin-top: 4px; display: flex; align-items: center; justify-content: center; background: #00A400; border-radius: 4px; color: white;">✓</div>
                                    <input type="hidden" name="services[]" value="{{ $service->cle }}">
                                @else
                                    <input type="checkbox" name="services[]" value="{{ $service->cle }}" class="service-checkbox" data-cost="{{ $service->credits_requis }}" {{ old('services') && in_array($service->cle, old('services')) ? 'checked' : '' }}>
                                @endif
                                
                                <div style="flex: 1;">
                                    <div style="font-weight: 800; font-size: 1.05rem; margin-bottom: 0.25rem; color: #856404; display: flex; align-items: center; gap: 0.5rem;">
                                        {{ $service->nom }}
                                        @if($isAlreadyActive)
                                            <span style="background: #00A400; color: white; font-size: 0.65rem; font-weight: 800; padding: 2px 8px; border-radius: 6px; text-transform: uppercase;">Déjà actif</span>
                                        @elseif($service->cle == 'mise_en_avant' || $service->cle == 'boost')
                                            <span style="background: #fcc419; color: #453b0c; font-size: 0.65rem; font-weight: 800; padding: 2px 8px; border-radius: 6px; text-transform: uppercase;">Recommandé</span>
                                        @endif
                                    </div>
                                    <div style="font-size: 0.85rem; color: #92700e; line-height: 1.4; font-weight: 600;">{{ $service->description }}</div>
                                    @if($service->duree_jours)
                                        <div style="font-size: 0.8rem; color: #b7791f; margin-top: 0.5rem; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                            <span>⏳</span> Valable {{ $service->duree_jours }} jours
                                        </div>
                                    @endif
                                </div>
                                <div style="font-weight: 900; font-size: 1.3rem; color: #e67e22; white-space: nowrap; text-shadow: 0 1px 0 rgba(255,255,255,0.5);">
                                    @if($isAlreadyActive)
                                        --
                                    @else
                                        +{{ $service->credits_requis }} <span style="color: #fcc419;">⭐</span>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div style="background: linear-gradient(135deg, #fff9db 0%, #fff3bf 100%); border: 2px dashed #fcc419; border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 4px 10px rgba(252, 196, 25, 0.05);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <span style="font-weight: 800; color: #856404; font-size: 1rem;">Statut de publication</span>
                        <div style="display: flex; gap: 1.5rem;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #92700e; font-weight: 700;">
                                <input type="radio" name="statut" value="brouillon" {{ $annonce->statut == 'brouillon' ? 'checked' : '' }} style="accent-color: #856404; width: 18px; height: 18px;">
                                <span style="font-size: 0.95rem;">Brouillon</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #856404; font-weight: 800;">
                                <input type="radio" name="statut" value="publiee" {{ $annonce->statut == 'publiee' ? 'checked' : '' }} style="accent-color: #f08c00; width: 18px; height: 18px;">
                                <span style="font-size: 0.95rem;">Publier maintenant</span>
                            </label>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1.5px solid #ffec99; padding-top: 1rem; margin-top: 0.5rem;">
                        <span style="font-weight: 900; font-size: 1.15rem; color: #453b0c; text-transform: uppercase;">Total à payer :</span>
                        <span style="font-weight: 950; font-size: 1.75rem; color: #111;">
                            <span id="total-cost-display" style="color: #e67e22;">0</span> <span style="font-size: 1.4rem; color: #fcc419;">⭐</span>
                        </span>
                    </div>
                    <div id="insufficient-credits-warning" style="display: none; background: #fde8e8; color: #c62828; padding: 0.75rem 1rem; border-radius: 6px; margin-top: 1rem; font-size: 0.9rem; border: 1px solid #ffcdd2;">
                        ⚠️ Votre solde de crédits est insuffisant pour ces options. <a href="{{ route('account.credits.index') }}" target="_blank" style="color: #c62828; font-weight: bold; text-decoration: underline;">Rechargez votre compte</a>.
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(4)">Précédent</button>
                    <button type="submit" class="btn btn-primary" id="submitButton">Enregistrer les modifications</button>
                </div>
            </div>
        </form>
    </main>

    <aside class="advisory-container">
        <div id="advisory-step-1" class="advisory-box">
            <h3 class="advisory-title">Modifier votre véhicule</h3>
            <p class="advisory-text">Le titre doit contenir la marque, le modèle et l'année pour être bien référencé.</p>
            <div class="advisory-item">
                <div class="advisory-icon">i</div>
                <span>Ex: Mercedes Classe C 220d (2018)</span>
            </div>
        </div>
        <div id="advisory-step-2" class="advisory-box" style="display: none;">
            <h3 class="advisory-title">Spécifications techniques</h3>
            <p class="advisory-text">Les acheteurs filtrent souvent par carburant et boîte de vitesse. Soyez précis.</p>
            <div class="advisory-item">
                <div class="advisory-icon">⚙️</div>
                <span>Vérifiez le kilométrage réel.</span>
            </div>
        </div>
        <div id="advisory-step-3" class="advisory-box" style="display: none;">
            <h3 class="advisory-title">Photos & État</h3>
            <p class="advisory-text">Prenez des photos de l'intérieur, de l'extérieur et du tableau de bord.</p>
            <div class="advisory-item">
                <div class="advisory-icon">📸</div>
                <span>Privilégiez un environnement propre.</span>
            </div>
        </div>
        <div id="advisory-step-4" class="advisory-box" style="display: none;">
            <h3 class="advisory-title">Vendez au meilleur prix</h3>
            <p class="advisory-text">Le boost véhicule est l'option la plus efficace pour vendre rapidement.</p>
            <div class="advisory-item">
                <div class="advisory-icon">🚀</div>
                <span>Apparaissez en tête de liste.</span>
            </div>
        </div>
    </aside>
</div>
@endsection

@push('scripts')
<script>
    const categoriesData = {
        @foreach($categories as $cat)
            {{ $cat->id }}: {
                id: {{ $cat->id }},
                nom: "{{ $cat->nom }}",
                parent_id: {{ $cat->parent_id ?? 'null' }},
                famille: "{{ $cat->famille }}",
                children: [
                    @if($cat->enfantsActifs)
                        @foreach($cat->enfantsActifs as $enfant)
                            { id: {{ $enfant->id }}, nom: "{{ $enfant->nom }}" },
                        @endforeach
                    @endif
                ]
            },
        @endforeach
    };

    const existingAttributes = {
        @foreach($annonce->filteredAttributes as $attr)
            {{ $attr->category_filter_id }}: "{{ $attr->value }}",
        @endforeach
    };

    function selectMainCategory(el, id) {
        document.querySelectorAll('.main-cat-badge').forEach(b => b.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('categorie_id').value = id;
        
        const hasChildren = populateSelect('level2Select', id);
        document.getElementById('level2Section').style.display = hasChildren ? 'block' : 'none';
        document.getElementById('level3Section').style.display = 'none';
        fetchFilters(id);
    }

    function populateSelect(selectId, parentId) {
        const select = document.getElementById(selectId);
        const cat = categoriesData[parentId];
        select.innerHTML = '<option value="">Choisir une option...</option>';
        if (cat && cat.children && cat.children.length > 0) {
            cat.children.forEach(child => {
                const option = document.createElement('option');
                option.value = child.id;
                option.textContent = child.nom;
                select.appendChild(option);
            });
            return true;
        }
        return false;
    }

    function onLevel2Change(id) {
        if (!id) {
            document.getElementById('level3Section').style.display = 'none';
            return;
        }
        document.getElementById('categorie_id').value = id;
        const hasChildren = populateSelect('level3Select', id);
        document.getElementById('level3Section').style.display = hasChildren ? 'block' : 'none';
        fetchFilters(id);
    }

    function onLevel3Change(id) {
        if (!id) return;
        document.getElementById('categorie_id').value = id;
        fetchFilters(id);
    }

    function fetchFilters(categoryId) {
        const container = document.getElementById('dynamic-filters-container');
        if (!container) return;
        container.innerHTML = '<div style="padding: 1rem; color: #666; font-size: 0.9rem;"><i class="fas fa-spinner fa-spin"></i> Chargement...</div>';

        fetch(`/api/categories/${categoryId}/filters`)
            .then(response => response.json())
            .then(filters => {
                container.innerHTML = '';
                if (filters.length > 0) {
                    filters.forEach(filter => {
                        const field = document.createElement('div');
                        field.className = 'form-group';
                        field.style = 'margin-top: 1.5rem;';
                        
                        const existingValue = existingAttributes[filter.id] || "";
                        let inputHtml = '';
                        const commonStyle = 'width: 100%; padding: 0.65rem 1rem; border: 1.5px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; outline: none; background: white;';
                        
                        if (filter.type === 'select' || (filter.options && filter.options.length > 0)) {
                            inputHtml = `<select name="attributes[${filter.id}]" style="${commonStyle}" ${filter.is_required ? 'required' : ''}>
                                <option value="">Sélectionner ${filter.nom}</option>
                                ${filter.options.map(opt => `<option value="${opt}" ${opt == existingValue ? 'selected' : ''}>${opt}</option>`).join('')}
                            </select>`;
                        } else if (filter.type === 'number' || filter.type === 'price') {
                            inputHtml = `<div style="display: flex; align-items: center;">
                                <input type="number" name="attributes[${filter.id}]" style="${commonStyle}" value="${existingValue}" placeholder="${filter.nom}" ${filter.is_required ? 'required' : ''}>
                                ${filter.unit ? `<span style="padding: 0.75rem; background: #f5f5f5; border: 2px solid #e0e0e0; border-left: none; border-top-right-radius: 4px; border-bottom-right-radius: 4px; font-size: 0.9rem;">${filter.unit}</span>` : ''}
                            </div>`;
                        } else {
                            inputHtml = `<input type="text" name="attributes[${filter.id}]" style="${commonStyle}" value="${existingValue}" placeholder="${filter.nom}" ${filter.is_required ? 'required' : ''}>`;
                        }

                        field.innerHTML = `<label class="form-label">${filter.nom} ${filter.is_required ? '*' : ''}</label>${inputHtml}`;
                        container.appendChild(field);
                    });
                }
            })
            .catch(() => { container.innerHTML = ''; });
    }

    function updateAdvisory(step) {
        document.querySelectorAll('.advisory-box').forEach(box => box.style.display = 'none');
        const activeBox = document.getElementById('advisory-step-' + step);
        if (activeBox) activeBox.style.display = 'block';
    }

    function nextStep(current) {
        if (current === 1) {
            if (!document.getElementById('categorie_id').value) { alert('Veuillez choisir une catégorie'); return; }
        }
        if (current === 3) {
            const photos = document.querySelectorAll('.image-item:not([style*="opacity: 0.3"])').length;
            const newPhotos = document.querySelector('input[name="photos[]"]').files.length;
            if (photos + newPhotos < 1) { alert('Veuillez ajouter au moins une photo'); return; }
            
            // Check promo when entering step 4
            const catId = document.getElementById('categorie_id').value;
            if (catId) checkCategoryPromo(catId);
        }

        document.getElementById('step' + current).classList.remove('active');
        document.getElementById('step' + (current + 1)).classList.add('active');
        
        document.querySelector(`.progress-step[data-step="${current}"]`).classList.remove('active');
        document.querySelector(`.progress-step[data-step="${current}"]`).classList.add('completed');
        document.querySelector(`.progress-step[data-step="${current + 1}"]`).classList.add('active');
        
        updateAdvisory(current + 1);
        window.scrollTo(0, 0);
    }

    // --- Promo Code Logic ---
    var activeCampaignData = null;

    function checkCategoryPromo(categoryId) {
        if (!categoryId) return;
        fetch(`/api/campaigns/check-category-promo?categorie_id=${categoryId}`)
            .then(r => r.json())
            .then(data => {
                const promoSection = document.getElementById('promo-section');
                if (data.has_campaign) {
                    promoSection.style.display = 'block';
                } else {
                    promoSection.style.display = 'none';
                    resetPromoState();
                }
            });
    }

    function resetPromoState() {
        activeCampaignData = null;
        document.getElementById('promo_code').value = '';
        document.getElementById('promo_code_input').value = '';
        document.getElementById('promo-preview').style.display = 'none';
    }

    function applyPromoCode() {
        const code = document.getElementById('promo_code_input').value.trim();
        const categorieId = document.getElementById('categorie_id').value;
        const error = document.getElementById('promo-error');
        const preview = document.getElementById('promo-preview');
        const hiddenInput = document.getElementById('promo_code');

        if (!code) { showPromoError('Veuillez entrer un code promo.'); return; }
        if (!categorieId) { showPromoError('Sélectionnez d\'abord une catégorie.'); return; }

        fetch(`/api/campaigns/check-promo?code=${encodeURIComponent(code)}&categorie_id=${categorieId}`)
            .then(r => r.json())
            .then(data => {
                if (!data.valid) {
                    showPromoError(data.message || 'Code invalide.');
                    preview.style.display = 'none';
                    hiddenInput.value = '';
                    activeCampaignData = null;
                    return;
                }

                activeCampaignData = data;
                hiddenInput.value = code;
                error.style.display = 'none';
                updatePromoPreview();
            })
            .catch(err => {
                console.error('Promo error:', err);
                showPromoError('Une erreur est survenue.');
            });
    }

    function updatePromoPreview() {
        if (!activeCampaignData) return;
        const prixInput = document.querySelector('input[name="prix"]');
        const prix = parseFloat(prixInput.value);
        const preview = document.getElementById('promo-preview');
        if (!prix || prix <= 0) { preview.style.display = 'none'; return; }

        let promoPrix;
        if (activeCampaignData.discount_type === 'percent') {
            promoPrix = prix * (1 - activeCampaignData.discount_value / 100);
        } else {
            promoPrix = Math.max(0, prix - activeCampaignData.discount_value);
        }

        const pct = Math.round(((prix - promoPrix) / prix) * 100);
        document.getElementById('promo-original-price').textContent = prix.toLocaleString() + ' FCFA';
        document.getElementById('promo-discounted-price').textContent = Math.round(promoPrix).toLocaleString() + ' FCFA';
        document.getElementById('promo-badge').textContent = '-' + pct + '%';
        document.getElementById('promo-success-text').innerHTML = "✨ Code appliqué avec succès ! Votre annonce bénéficiera d'un prix barré.";
        preview.style.display = 'block';
    }

    function showPromoError(msg) {
        const el = document.getElementById('promo-error');
        el.textContent = msg;
        el.style.display = 'block';
    }

    function revokePromoCode() {
        resetPromoState();
    }

    // Listen for price changes
    document.querySelector('input[name="prix"]').addEventListener('input', updatePromoPreview);

    function prevStep(current) {
        document.getElementById('step' + current).classList.remove('active');
        document.getElementById('step' + (current - 1)).classList.add('active');
        
        document.querySelector(`.progress-step[data-step="${current}"]`).classList.remove('active');
        document.querySelector(`.progress-step[data-step="${current - 1}"]`).classList.remove('completed');
        document.querySelector(`.progress-step[data-step="${current - 1}"]`).classList.add('active');
        
        updateAdvisory(current - 1);
        window.scrollTo(0, 0);
    }

    let deletedIds = [];
    function markForDeletion(id) {
        deletedIds.push(id);
        document.getElementById('media-' + id).style.opacity = '0.3';
        document.getElementById('delete_media_ids').value = deletedIds.join(',');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const step = parseInt(urlParams.get('step'));
        if (step && step > 1 && step <= 4) {
            for (let i = 1; i < step; i++) {
                nextStep(i);
            }
        }
        
        // --- Credit Services Logic ---
        const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
        const statutRadios = document.querySelectorAll('input[name="statut"]');
        const totalCostDisplay = document.getElementById('total-cost-display');
        const warningDisplay = document.getElementById('insufficient-credits-warning');
        const submitButton = document.getElementById('submitButton');
        const userBalance = parseInt(document.getElementById('user-credit-balance').textContent) || 0;

        function calculateTotal() {
            const statut = document.querySelector('input[name="statut"]:checked').value;
            let total = 0;

            if (statut === 'publiee') {
                serviceCheckboxes.forEach(cb => {
                    if (cb.checked) {
                        total += parseInt(cb.getAttribute('data-cost')) || 0;
                    }
                });
            }

            totalCostDisplay.textContent = total;

            if (total > userBalance && statut === 'publiee') {
                warningDisplay.style.display = 'block';
                submitButton.disabled = true;
                submitButton.style.opacity = '0.5';
            } else {
                warningDisplay.style.display = 'none';
                submitButton.disabled = false;
                submitButton.style.opacity = '1';
            }
        }

        serviceCheckboxes.forEach(cb => cb.addEventListener('change', calculateTotal));
        statutRadios.forEach(radio => radio.addEventListener('change', calculateTotal));
        calculateTotal();

        const catId = "{{ $annonce->categorie_id }}";
        if (catId) {
            checkCategoryPromo(catId);
            let path = [];
            let curr = categoriesData[catId];
            while(curr) { path.unshift(curr.id); curr = categoriesData[curr.parent_id]; }
            
            if (path.length >= 1) {
                const mainId = path[0];
                const badge = document.querySelector(`.main-cat-badge[data-id="${mainId}"]`);
                if(badge) selectMainCategory(badge, mainId);
                
                if (path.length >= 2) {
                    setTimeout(() => {
                        const l2 = document.getElementById('level2Select');
                        if (l2) { l2.value = path[1]; onLevel2Change(path[1]); }
                        if (path.length >= 3) {
                            setTimeout(() => {
                                const l3 = document.getElementById('level3Select');
                                if (l3) { l3.value = path[2]; onLevel3Change(path[2]); }
                            }, 100);
                        }
                    }, 100);
                }
            }
        }
    });

    document.getElementById('editVehiculeForm').addEventListener('submit', function (e) {
        const statut = document.querySelector('input[name="statut"]:checked').value;
        if (statut === 'publiee') {
            const totalCost = parseInt(document.getElementById('total-cost-display').textContent) || 0;
            const balance = parseInt(document.getElementById('user-credit-balance').textContent) || 0;
            if (totalCost > balance) {
                e.preventDefault();
                alert('Solde de crédits insuffisant pour les options choisies.');
            }
        }
    });
</script>
@endpush
