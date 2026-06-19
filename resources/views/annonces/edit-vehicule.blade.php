@extends('layouts.app')

@section('title', 'Modifier mon véhicule - Karnou')

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

        #prix, .form-input[type="number"] {
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
    <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('vendeur.mes-annonces') }}">Mes annonces</a> > <span>Modifier mon véhicule</span>
</div>

<div class="create-annonce-container">
    <aside class="progress-sidebar">
        <div class="progress-step active" data-step="1">
            <div class="step-circle"><div class="step-dot"></div></div>
            <div class="step-content">
                <div class="step-number">Étape 1</div>
                <div class="step-title">Véhicule & Catégorie</div>
            </div>
        </div>
        <div class="progress-step" data-step="2">
            <div class="step-circle"><div class="step-dot"></div></div>
            <div class="step-content">
                <div class="step-number">Étape 2</div>
                <div class="step-title">Modèle & Moteur</div>
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
                <div class="step-title">Booster votre annonce</div>
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
                                    @else {!! $icons[$categorie->nom] ?? '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>' !!}
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

                <div class="form-group">
                    <label class="form-label">Prix de vente (FCFA) <span style="color: #bf0000;">*</span></label>
                    <input type="number" id="prix" name="prix" value="{{ old('prix', $annonce->prix) }}" class="form-input" required min="0" step="1">
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="window.history.back()">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="nextStep(1)">Continuer</button>
                </div>
            </div>

            <!-- Étape 2: Modèle & Moteur -->
            <div class="form-step" id="step2">
                <h2 class="form-title">Spécifications techniques</h2>

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
                <h2 class="form-title">État & Apparence</h2>

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
                        <div class="image-preview-container" style="margin-bottom: 1.5rem;">
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
                <h2 class="form-title">🚀 Booster votre annonce</h2>
                <div class="form-instructions" style="margin-bottom: 2rem;">
                    <p class="instruction-text">Choisissez le statut de votre annonce.</p>
                </div>

                @if(count($optionsDisponibles) > 0)
                    <div class="form-group">
                        <label class="form-label">Mise en avant</label>
                        @foreach($optionsDisponibles as $key => $option)
                            <div class="option-card">
                                <input type="checkbox" name="options[{{ $key }}]" id="opt-{{ $key }}" value="1" 
                                    {{ ($annonce->options && $annonce->options->{$key}) ? 'checked' : '' }}>
                                <div>
                                    <label for="opt-{{ $key }}" style="font-weight: 700; cursor: pointer; display: block; margin-bottom: 0.25rem;">
                                        {{ $option['nom'] }} - {{ number_format($option['prix'], 0, ',', ' ') }} FCFA
                                    </label>
                                    <p style="font-size: 0.85rem; color: #666; margin: 0;">{{ $option['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="form-group" style="margin-top: 2rem;">
                    <label class="form-label">Statut de publication</label>
                    <select name="statut" class="form-input">
                        <option value="publiee" {{ $annonce->statut == 'publiee' ? 'selected' : '' }}>Publiée (En ligne)</option>
                        <option value="brouillon" {{ $annonce->statut == 'brouillon' ? 'selected' : '' }}>Brouillon (Hors ligne)</option>
                    </select>
                    <small style="color: #666; font-size: 0.875rem; margin-top: 0.5rem; display: block;">
                        Vous pourrez modifier le statut de votre annonce plus tard depuis votre tableau de bord.
                    </small>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="prevStep(4)">Précédent</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
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
