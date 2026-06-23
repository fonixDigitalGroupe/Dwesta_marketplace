@extends('layouts.app')

@section('title', 'Modifier mon bien immobilier - Karnou')

@push('styles')
    <style>
        :root {
            --primary-black: #1a1a1a;
            --secondary-grey: #4a4a4a;
            --light-grey: #f5f5f5;
            --border-color: #e0e0e0;
            --accent-color: #000000;
        }

        .create-annonce-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 3rem;
        }

        /* Sidebar - Progress Indicator */
        .progress-sidebar {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem 1.5rem;
            height: fit-content;
            position: sticky;
            top: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
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
            background: var(--border-color);
        }

        .progress-step.active:not(:last-child)::after,
        .progress-step.completed:not(:last-child)::after {
            background: var(--primary-black);
        }

        .step-circle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid var(--border-color);
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
            border-color: var(--primary-black);
            background: var(--primary-black);
        }

        .progress-step.completed .step-circle {
            border-color: var(--primary-black);
            background: var(--primary-black);
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
            color: var(--secondary-grey);
            margin-bottom: 0.25rem;
        }

        .progress-step.active .step-title {
            color: var(--primary-black);
        }

        .step-number {
            font-size: 0.75rem;
            color: #888;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Form Content */
        .form-content {
            background: white;
            border-radius: 12px;
            padding: 3rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        .form-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--primary-black);
            margin-bottom: 1.5rem;
            letter-spacing: -0.025em;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            display: block;
            font-weight: 700;
            color: var(--primary-black);
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--primary-black);
            box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.05);
        }

        textarea.form-input {
            min-height: 150px;
            resize: vertical;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }

        .btn {
            padding: 0.8rem 2rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
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
            background: var(--light-grey);
            color: var(--primary-black);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: #e5e5e5;
        }

        /* Steps display */
        .form-step {
            display: none;
            animation: fadeIn 0.3s ease-in-out;
        }

        .form-step.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Input price/quantity refinements */
        input[type=number] {
            -moz-appearance: textfield;
        }
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .form-input[type="number"] {
            height: 45px;
            padding: 0.6rem 1rem;
            border-radius: 8px;
        }

        /* Image preview */
        .image-preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .image-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid var(--border-color);
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
            background: rgba(0,0,0,0.6);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .remove-btn:hover {
            background: rgba(0,0,0,0.8);
        }

        .option-card {
            background: #fdfdfd;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            transition: all 0.2s;
        }

        .option-card:hover {
            border-color: var(--primary-black);
            background: #fff;
        }

        .option-card input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-top: 0.25rem;
            cursor: pointer;
            accent-color: var(--primary-black);
        }
    </style>
@endpush

@section('content')
<div class="breadcrumb" style="max-width: 1200px; margin: 1rem auto; padding: 0 1rem;">
    <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('vendeur.mes-annonces') }}">Mes annonces</a> > <span>Modifier mon bien immobilier</span>
</div>

<div class="create-annonce-container">
    <aside class="progress-sidebar">
        <div class="progress-step active" data-step="1">
            <div class="step-circle"><div class="step-dot"></div></div>
            <div class="step-content">
                <div class="step-number">Étape 1</div>
                <div class="step-title">Bien & Catégorie</div>
            </div>
        </div>
        <div class="progress-step" data-step="2">
            <div class="step-circle"><div class="step-dot"></div></div>
            <div class="step-content">
                <div class="step-number">Étape 2</div>
                <div class="step-title">Transaction & Prix</div>
            </div>
        </div>
        <div class="progress-step" data-step="3">
            <div class="step-circle"><div class="step-dot"></div></div>
            <div class="step-content">
                <div class="step-number">Étape 3</div>
                <div class="step-title">Détails & Photos</div>
            </div>
        </div>
        <div class="progress-step" data-step="4">
            <div class="step-circle"><div class="step-dot"></div></div>
            <div class="step-content">
                <div class="step-number">Étape 4</div>
                <div class="step-title">Options & Publication</div>
            </div>
        </div>
    </aside>

    <main class="form-content">
        <form id="editImmobilierForm" action="{{ route('annonces.update', $annonce) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="type" value="immobilier">
            <input type="hidden" id="type_livraison" name="type_livraison" value="{{ old('type_livraison', $annonce->type_livraison ?? 'retrait_point_relais') }}">
            <input type="hidden" id="user_phone" name="user_phone" value="{{ old('user_phone', $annonce->vendeur->user->telephone ?? auth()->user()->telephone ?? '00000000') }}">
            <input type="hidden" id="code_postal" name="code_postal" value="{{ old('code_postal', $annonce->code_postal ?? '00000') }}">

            <!-- Étape 1: Bien & Catégorie -->
            <div class="form-step active" id="step1">
                <h2 class="form-title">Modifier votre bien</h2>
                
                <div class="form-group">
                    <label class="form-label">Titre de l'annonce <span style="color: #bf0000;">*</span></label>
                    <input type="text" name="titre" value="{{ old('titre', $annonce->titre) }}" class="form-input" required maxlength="255" placeholder="Ex: Appartement F3 standing à Bamako">
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
                        <label class="form-label" style="font-size: 0.9rem; font-weight: 600; color: #333; margin-bottom: 0.75rem; display: block;">Choisissez une sous-catégorie</label>
                        <select id="level2Select" class="form-input" onchange="onLevel2Change(this.value)" style="width: 100%; border-radius: 8px;">
                            <option value="">Choisir une option...</option>
                        </select>
                    </div>

                    <div id="level3Section" style="display:none; margin-top: 1.5rem;">
                        <label class="form-label" style="font-size: 0.9rem; font-weight: 600; color: #333; margin-bottom: 0.75rem; display: block;">Précisez votre choix (champ détaillé)</label>
                        <select id="level3Select" class="form-input" onchange="onLevel3Change(this.value)" style="width: 100%; border-radius: 8px;">
                            <option value="">Choisir une option...</option>
                        </select>
                    </div>

                    <div id="dynamic-filters-container" style="margin-top: 1.5rem;"></div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(1)">Continuer</button>
                </div>
            </div>

            <!-- Étape 2: Transaction & Prix -->
            <div class="form-step" id="step2">
                <h2 class="form-title">Transaction immobilière</h2>

                <div class="form-group">
                    <label class="form-label">Type de transaction <span style="color: #bf0000;">*</span></label>
                    <select name="type_transaction" id="type_transaction" class="form-input" required>
                        <option value="vente" {{ old('type_transaction', $annonce->immobilier->type_transaction ?? '') == 'vente' ? 'selected' : '' }}>Vente</option>
                        <option value="location" {{ old('type_transaction', $annonce->immobilier->type_transaction ?? '') == 'location' ? 'selected' : '' }}>Location</option>
                    </select>
                </div>

                <div id="prix_vente_container" class="form-group" style="display: {{ (old('type_transaction', $annonce->immobilier->type_transaction ?? '') == 'vente') ? 'block' : 'none' }};">
                    <label class="form-label">Prix de vente (FCFA)</label>
                    <input type="number" name="prix_vente" value="{{ old('prix_vente', $annonce->immobilier->prix_vente ?? '') }}" class="form-input" min="0" step="1">
                </div>

                <div id="loyer_container" class="form-group" style="display: {{ (old('type_transaction', $annonce->immobilier->type_transaction ?? '') == 'location') ? 'block' : 'none' }};">
                    <label class="form-label">Loyer mensuel (FCFA)</label>
                    <input type="number" name="loyer_mensuel" value="{{ old('loyer_mensuel', $annonce->immobilier->loyer_mensuel ?? '') }}" class="form-input" min="0" step="1">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(2)">Précédent</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(2)">Continuer</button>
                </div>
            </div>

            <!-- Étape 3: Détails & Photos -->
            <div class="form-step" id="step3">
                <h2 class="form-title">Caractéristiques du bien</h2>

                <div class="form-group">
                    <label class="form-label">Description <span style="color: #bf0000;">*</span></label>
                    <textarea name="description" class="form-input" required minlength="20" placeholder="Décrivez le bien : pièces, environnement, atouts...">{{ old('description', $annonce->description) }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Surface (m²)</label>
                        <input type="number" name="surface" value="{{ old('surface', $annonce->immobilier->surface ?? '') }}" class="form-input" min="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Pièces</label>
                        <input type="number" name="pieces" value="{{ old('pieces', $annonce->immobilier->pieces ?? '') }}" class="form-input" min="1">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Chambres</label>
                        <input type="number" name="chambres" value="{{ old('chambres', $annonce->immobilier->chambres ?? '') }}" class="form-input" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Photos du bien</label>
                    
                    @if($annonce->photos->count() > 0)
                        <div class="image-preview-container" style="margin-bottom: 1.5rem;">
                            @foreach($annonce->photos as $photo)
                                <div class="image-item" id="media-{{ $photo->id }}">
                                    <img src="{{ asset('storage/' . $photo->chemin) }}" alt="Photo bien">
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
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
                    <div>
                        <h2 class="form-title" style="margin-bottom: 0.5rem;">🚀 Booster votre annonce</h2>
                        <p class="instruction-text" style="color: #666; font-size: 0.95rem;">Mettez votre annonce en avant pour vendre d'autant plus vite.</p>
                    </div>
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
                            <label class="service-card {{ $isAlreadyActive ? 'already-active' : '' }}" style="display: flex; align-items: flex-start; gap: 1rem; padding: 1.25rem; border: 2px solid {{ $isAlreadyActive ? '#4caf50' : '#e0e0e0' }}; border-radius: 12px; cursor: {{ $isAlreadyActive ? 'default' : 'pointer' }}; transition: all 0.2s; position: relative; {{ $isAlreadyActive ? 'background: #f1f8e9; opacity: 0.9;' : '' }}">
                                @if($isAlreadyActive)
                                    <div style="width: 20px; height: 20px; margin-top: 4px; display: flex; align-items: center; justify-content: center; background: #4caf50; border-radius: 4px; color: white;">✓</div>
                                    <input type="hidden" name="services[]" value="{{ $service->cle }}">
                                @else
                                    <input type="checkbox" name="services[]" value="{{ $service->cle }}" class="service-checkbox" data-cost="{{ $service->credits_requis }}" {{ old('services') && in_array($service->cle, old('services')) ? 'checked' : '' }} style="width: 20px; height: 20px; margin-top: 4px; accent-color: #ef6c00;">
                                @endif
                                
                                <div style="flex: 1;">
                                    <div style="font-weight: 800; font-size: 1.05rem; margin-bottom: 0.25rem; color: #333;">
                                        {{ $service->nom }}
                                        @if($isAlreadyActive)
                                            <span style="background: #4caf50; color: white; font-size: 0.7rem; font-weight: 700; padding: 2px 6px; border-radius: 4px; margin-left: 8px; vertical-align: text-bottom;">Déjà actif</span>
                                        @elseif($service->cle == 'mise_en_avant' || $service->cle == 'boost')
                                            <span style="background: #eef2ff; color: #004aad; font-size: 0.7rem; font-weight: 700; padding: 2px 6px; border-radius: 4px; margin-left: 8px; vertical-align: text-bottom;">Recommandé</span>
                                        @endif
                                    </div>
                                    <div style="font-size: 0.9rem; color: #666; line-height: 1.4;">{{ $service->description }}</div>
                                    @if($service->duree_jours)
                                        <div style="font-size: 0.8rem; color: #888; margin-top: 0.5rem; font-weight: 600;">⏳ Valable {{ $service->duree_jours }} jours</div>
                                    @endif
                                </div>
                                <div style="font-weight: 800; font-size: 1.25rem; color: {{ $isAlreadyActive ? '#4caf50' : '#ef6c00' }}; white-space: nowrap;">
                                    @if($isAlreadyActive)
                                        --
                                    @else
                                        +{{ $service->credits_requis }} ⭐
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div style="background: white; border-radius: 8px; padding: 1.5rem; margin-bottom: 2rem; border: 1px solid #eee;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <span style="font-weight: 600; color: #333;">Statut de publication</span>
                        <div style="display: flex; gap: 1rem;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="radio" name="statut" value="brouillon" {{ $annonce->statut == 'brouillon' ? 'checked' : '' }} style="accent-color: #333;">
                                <span style="font-size: 0.95rem;">Brouillon</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="radio" name="statut" value="publiee" {{ $annonce->statut == 'publiee' ? 'checked' : '' }} style="accent-color: #ef6c00;">
                                <span style="font-size: 0.95rem; font-weight: 600;">Publier maintenant</span>
                            </label>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #ddd; padding-top: 1rem;">
                        <span style="font-weight: 700; font-size: 1.1rem; color: #000;">NOUVEAU Total à payer :</span>
                        <span style="font-weight: 800; font-size: 1.5rem; color: #111;">
                            <span id="total-cost-display">0</span> <span style="font-size: 1.2rem; color: #ffbe00;">⭐</span>
                        </span>
                    </div>
                    <div id="insufficient-credits-warning" style="display: none; background: #fde8e8; color: #c62828; padding: 0.75rem 1rem; border-radius: 6px; margin-top: 1rem; font-size: 0.9rem; border: 1px solid #ffcdd2;">
                        ⚠️ Votre solde de crédits est insuffisant pour ces NOUVELLES options. <a href="{{ route('account.credits.index') }}" target="_blank" style="color: #c62828; font-weight: bold; text-decoration: underline;">Rechargez votre compte</a>.
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(4)">Précédent</button>
                    <button type="submit" class="btn btn-primary" id="submitButton">Enregistrer les modifications</button>
                </div>
            </div>
        </form>
    </main>
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
                        const commonStyle = 'width: 100%; padding: 0.75rem; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; background: white;';
                        
                        if (filter.type === 'select' || (filter.options && filter.options.length > 0)) {
                            inputHtml = `<select name="attributes[${filter.id}]" style="${commonStyle}" ${filter.is_required ? 'required' : ''}>
                                <option value="">Sélectionner ${filter.nom}</option>
                                ${filter.options.map(opt => `<option value="${opt}" ${opt == existingValue ? 'selected' : ''}>${opt}</option>`).join('')}
                            </select>`;
                        } else if (filter.type === 'number' || filter.type === 'price') {
                            inputHtml = `<div style="display: flex; align-items: center;">
                                <input type="number" name="attributes[${filter.id}]" style="${commonStyle}" value="${existingValue}" placeholder="${filter.nom}" ${filter.is_required ? 'required' : ''}>
                                ${filter.unit ? `<span style="padding: 0.75rem; background: #f5f5f5; border: 2px solid #e0e0e0; border-left: none; border-top-right-radius: 8px; border-bottom-right-radius: 8px; font-size: 0.9rem;">${filter.unit}</span>` : ''}
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

    function nextStep(current) {
        if (current === 1) {
            if (!document.getElementById('categorie_id').value) { alert('Veuillez choisir une catégorie'); return; }
        }
        if (current === 3) {
            const photos = document.querySelectorAll('.image-item:not([style*="opacity: 0.3"])').length;
            const newPhotos = document.querySelector('input[name="photos[]"]').files.length;
            if (photos + newPhotos < 1) { alert('Veuillez ajouter au moins une photo'); return; }
        }

        document.getElementById('step' + current).classList.remove('active');
        document.getElementById('step' + (current + 1)).classList.add('active');
        
        document.querySelector(`.progress-step[data-step="${current}"]`).classList.remove('active');
        document.querySelector(`.progress-step[data-step="${current}"]`).classList.add('completed');
        document.querySelector(`.progress-step[data-step="${current + 1}"]`).classList.add('active');
        
        window.scrollTo(0, 0);
    }

    function prevStep(current) {
        document.getElementById('step' + current).classList.remove('active');
        document.getElementById('step' + (current - 1)).classList.add('active');
        
        document.querySelector(`.progress-step[data-step="${current}"]`).classList.remove('active');
        document.querySelector(`.progress-step[data-step="${current - 1}"]`).classList.remove('completed');
        document.querySelector(`.progress-step[data-step="${current - 1}"]`).classList.add('active');
        
        window.scrollTo(0, 0);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const step = parseInt(urlParams.get('step'));
        if (step && step > 1 && step <= 4) {
            for (let i = 1; i < step; i++) {
                nextStep(i);
            }
        }
    });

    document.getElementById('type_transaction').addEventListener('change', function() {
        const prixVenteCont = document.getElementById('prix_vente_container');
        const loyerCont = document.getElementById('loyer_container');
        
        if(this.value === 'vente') {
            prixVenteCont.style.display = 'block';
            loyerCont.style.display = 'none';
        } else if(this.value === 'location') {
            prixVenteCont.style.display = 'none';
            loyerCont.style.display = 'block';
        }
    });

    let deletedIds = [];
    function markForDeletion(id) {
        deletedIds.push(id);
        document.getElementById('media-' + id).style.opacity = '0.3';
        document.getElementById('delete_media_ids').value = deletedIds.join(',');
    }

    // Add validation to form submission to catch step 4 credit check before submitting
    document.querySelector('form').addEventListener('submit', function (e) {
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

    document.addEventListener('DOMContentLoaded', function() {
        // --- Credit Services Logic ---
        const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
        const statutRadios = document.querySelectorAll('input[name="statut"]');
        const totalCostDisplay = document.getElementById('total-cost-display');
        const warningDisplay = document.getElementById('insufficient-credits-warning');
        const submitButton = document.getElementById('submitButton');
        const userBalance = parseInt(document.getElementById('user-credit-balance').textContent) || 0;
        
        // Add video upload container dynamically if 'video' service is selected
        const videoServiceCheckbox = document.querySelector('.service-checkbox[value="video"]');
        const isVideoAlreadyActive = document.querySelector('.already-active input[value="video"]');
        
        if (videoServiceCheckbox && !isVideoAlreadyActive) {
            const videoUploadHtml = `
                <div id="video-upload-container" style="display: none; padding: 1rem; border: 1px dashed #ef6c00; border-radius: 8px; background: #fff5e6; margin-top: 10px;">
                    <label style="font-weight: 700; display: block; margin-bottom: 0.5rem; color: #ef6c00;">🎥 Télécharger votre vidéo</label>
                    <input type="file" name="video" accept="video/mp4,video/quicktime,video/webm" class="form-input" style="background: white;">
                    <small style="color: #666; display: block; margin-top: 5px;">Format MP4, MOV. Max 50Mo. La vidéo doit être cochée lors de la publication pour être validée.</small>
                </div>
            `;
            videoServiceCheckbox.closest('.service-card').insertAdjacentHTML('afterend', videoUploadHtml);
            
            videoServiceCheckbox.addEventListener('change', function() {
                document.getElementById('video-upload-container').style.display = this.checked ? 'block' : 'none';
            });
        }

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
        
        // Initial calculation
        calculateTotal();

        // Path logic (existing)
        const catId = "{{ $annonce->categorie_id }}";
        if (catId) {
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
</script>
@endpush
