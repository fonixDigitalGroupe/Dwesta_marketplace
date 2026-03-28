@extends('layouts.app')

@section('title', 'Modifier mon annonce')

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

        .create-annonce-container {
            max-width: 1300px;
            margin: 3rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 240px 1fr 280px;
            /* Sidebar, Form, Advisory */
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

        .form-instructions {
            margin-bottom: 2rem;
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

        .form-input-wrapper {
            position: relative;
        }

        .product-summary-box {
            background: #fafafa;
            padding: 0.85rem 1.25rem;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border: 1px solid #f0f0f0;
        }

        .product-summary-name {
            font-size: 1rem;
            font-weight: 500;
            color: #333;
        }

        .product-summary-edit {
            color: #666;
            cursor: pointer;
            transition: color 0.25s ease;
        }

        .product-summary-edit:hover {
            color: #008400;
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

        .suggestion-cards {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-top: 1rem;
        }

        .suggestion-card {
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.85rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
            text-align: left;
            width: 100%;
        }

        .suggestion-card:hover {
            border-color: #000;
            background: #fcfcfc;
        }

        .suggestion-card.selected {
            border-color: #000;
            background: #fff;
            border-width: 2px;
        }

        .radio-circle {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            position: relative;
        }

        .suggestion-card.selected .radio-circle::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: #000;
            border-radius: 50%;
            border: 1.5px solid white;
            box-shadow: 0 0 0 1.5px #000;
        }

        .suggestion-card-content {
            flex: 1;
        }

        .suggestion-card-title {
            display: block;
            font-size: 0.95rem;
            font-weight: 500;
            color: #333;
        }

        .selection-summary-box {
            background: #fdfdfd;
            border: 1px dashed #ccc;
            padding: 1rem 1.25rem;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            animation: fadeIn 0.3s ease;
        }

        .selection-summary-text {
            font-size: 0.9rem;
            color: #555;
        }

        .selection-summary-path {
            font-weight: 600;
            color: #000;
            display: block;
            margin-top: 2px;
        }

        /* Step 3 Styles */
        .status-cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 1rem;
        }

        .status-card {
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
            font-size: 0.9rem;
            color: #444;
            position: relative;
        }

        .status-card:hover {
            border-color: #000;
        }

        .status-card.selected {
            border-color: #000;
            border-width: 1px;
            background: #fff;
        }

        .status-card.selected .radio-circle::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: #00A400;
            border-radius: 50%;
            border: 1.5px solid white;
            box-shadow: 0 0 0 1.5px #00A400;
        }

        .photo-grid-system {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 110px));
            gap: 12px;
            margin-top: 0.5rem;
        }

        .photo-upload-box {
            width: 110px;
            height: 110px;
            border: 1.5px dashed #ccc;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: #fdfdfd;
            transition: all 0.2s ease;
        }

        .photo-upload-box:hover {
            border-color: #00A400;
            background: #fafffa;
        }

        .upload-box-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 6px;
            color: #555;
            font-size: 0.75rem;
            padding: 5px;
        }

        .upload-box-content svg {
            width: 24px;
            height: 24px;
            color: #888;
        }

        .image-preview-item {
            width: 110px;
            height: 110px;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-photo-btn {
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

        .remove-photo-btn:hover {
            background: #fff;
            color: #ff0000;
            border-color: #ff0000;
        }

        /* Advisory Box */
        .advisory-container {
            position: sticky;
            top: 2rem;
            display: none;
        }

        .advisory-container.active {
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

        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
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
            background: black;
            color: white;
        }

        .btn-primary:hover {
            background: #333;
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
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: white;
            width: 90%;
            max-width: 500px;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .modal-close {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #999;
        }

        .modal-title {
            font-size: 1.15rem;
            font-weight: 500;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f0f0f0;
            color: #222;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            position: relative;
        }

        .modal-back {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: #666;
            padding: 0.5rem;
            position: absolute;
            left: 0;
            border-radius: 50%;
        }

        .subcategory-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
            max-height: 350px;
            overflow-y: auto;
        }

        .subcategory-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.85rem 1.25rem;
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            background: white;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
            width: 100%;
            font-size: 0.95rem;
            color: #333;
        }

        .subcategory-item:hover {
            border-color: #000;
            background: #fafafa;
        }

        .file-input-hidden {
            display: none;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
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

        #prix, #quantite {
            height: 45px;
            padding: 0.6rem 1rem;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="create-annonce-container">
        <!-- Sidebar gauche - Indicateur de progression -->
        <aside class="progress-sidebar">
            <div class="progress-step active" data-step="1">
                <div class="step-circle">
                    <div class="step-dot"></div>
                    <div class="step-check">✓</div>
                </div>
                <div class="step-content">
                    <div class="step-number">ETAPE 1</div>
                    <div class="step-title">Votre annonce</div>
                </div>
            </div>
            <div class="progress-step" data-step="2">
                <div class="step-circle">
                    <div class="step-dot"></div>
                    <div class="step-check">✓</div>
                </div>
                <div class="step-content">
                    <div class="step-number">ETAPE 2</div>
                    <div class="step-title">Catégories</div>
                </div>
            </div>
            <div class="progress-step" data-step="3">
                <div class="step-circle">
                    <div class="step-dot"></div>
                    <div class="step-check">✓</div>
                </div>
                <div class="step-content">
                    <div class="step-number">ETAPE 3</div>
                    <div class="step-title">Description</div>
                </div>
            </div>
            <div class="progress-step" data-step="4">
                <div class="step-circle">
                    <div class="step-dot"></div>
                    <div class="step-check">✓</div>
                </div>
                <div class="step-content">
                    <div class="step-number">ETAPE 4</div>
                    <div class="step-title">Booster votre annonce</div>
                </div>
            </div>
        </aside>

        <!-- Contenu principal -->
        <main class="form-content">
            <form id="createAnnonceForm" method="POST" action="{{ route('annonces.update', $annonce) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="type" value="produit">
                <input type="hidden" id="current_step_input" name="current_step" value="{{ old('current_step', 1) }}">

                @if ($errors->any())
                    <div class="alert alert-danger" style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                        <h4 style="font-weight: 700; margin-bottom: 0.5rem;">Veuillez corriger les erreurs suivantes :</h4>
                        <ul style="list-style-position: inside;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Étape 1: Votre annonce -->
                <div class="form-step active" id="step1">
                    <h1 class="form-title">👋 Modifier votre annonce</h1>
                    <div class="form-instructions">
                        <p class="instruction-text">Mettez à jour le nom de votre produit.</p>
                    </div>
                    <div class="form-group">
                        <label for="product_name" class="form-label">Nom du produit</label>
                        <div class="form-input-wrapper">
                            <input type="text" id="product_name" name="titre" class="form-input"
                                placeholder="Nom ou code barre du produit" maxlength="200" required value="{{ old('titre', $annonce->titre) }}">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Continuer</button>
                    </div>
                </div>

                <!-- Étape 2: Catégories -->
                <div class="form-step" id="step2">
                    <h1 class="form-title">📦 Catégories</h1>

                    <div class="product-summary-box">
                        <span id="summary_product_name" class="product-summary-name">{{ $annonce->titre }}</span>
                        <div class="product-summary-edit" onclick="previousStep()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" style="font-size: 0.9rem; font-weight: 500; color: #666;">Catégorie de l'article</label>
                        <input type="hidden" id="categorie_id" name="categorie_id" value="{{ old('categorie_id', $annonce->categorie_id) }}" required>

                        <div class="category-badges-container">
                            @php
                                $rootCatId = null;
                                $curr = $annonce->category;
                                while($curr && $curr->parent_id) {
                                    $curr = $curr->parent;
                                }
                                $rootCatId = $curr ? $curr->id : null;

                                $icons = [
                                    'E-commerce' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>',
                                    'Services' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>',
                                    'Immobilier' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
                                    'Véhicules' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="13" width="22" height="8" rx="2"></rect><path d="M7 13V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v7"></path></svg>'
                                ];
                            @endphp
                            @foreach($categories->where('parent_id', null) as $categorie)
                                <div class="category-badge-item main-cat-badge {{ $rootCatId == $categorie->id ? 'selected' : '' }}" data-id="{{ $categorie->id }}"
                                    onclick="selectMainCategory(this, {{ $categorie->id }})">
                                    <span class="category-badge-icon">
                                        @if($categorie->icone)
                                            {!! $categorie->icone !!}
                                        @else
                                            {!! $icons[$categorie->nom] ?? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="16" y2="12"></line><line x1="12" x2="12.01" y1="8" y2="8"></line></svg>' !!}
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
                        <button type="button" class="btn btn-secondary" onclick="previousStep()">Précédent</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Continuer</button>
                    </div>
                </div>

                <!-- Étape 3: Description et Photos -->
                <div class="form-step" id="step3">
                    <h1 class="form-title">✍️ Précisions et Photos</h1>

                    <div class="product-summary-box">
                        <span class="product-summary-name-s3" id="summary_product_name_s3">{{ $annonce->titre }}</span>
                        <div class="product-summary-edit" onclick="previousStep()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>

                    <div id="productConditionGroup" class="form-group" style="margin-top: 1.5rem;">
                        <label class="form-label" style="font-size: 0.9rem; font-weight: 700; color: #000; margin-bottom: 0.5rem;">État</label>
                        <input type="hidden" id="etat_produit" name="etat" value="{{ old('etat', $annonce->produit->etat ?? 'Neuf') }}" required>
                        <div class="status-cards-grid">
                            @foreach(['Neuf', 'Occasion', 'Reconditionné'] as $st)
                                <div class="status-card {{ old('etat', $annonce->produit->etat ?? 'Neuf') == $st ? 'selected' : '' }}" onclick="selectStatus(this, '{{ $st }}')">
                                    <div class="radio-circle"></div>
                                    {{ $st }}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1.5rem;">
                        <label class="form-label" style="font-size: 0.95rem; font-weight: 700; color: #000; margin-bottom: 1rem; display: block;">
                            Photos du produit <span id="photoCountDisplay" style="color: #666; font-weight: 500; margin-left: 0.5rem;">0 sur 8</span>
                        </label>

                        <div class="photo-grid-system" id="photoGrid">
                            @if($annonce->photos->count() > 0)
                                @foreach($annonce->photos as $photo)
                                    <div class="image-preview-item existing-photo" data-media-id="{{ $photo->id }}" id="media-{{ $photo->id }}">
                                        <img src="{{ asset('storage/' . $photo->chemin) }}">
                                        <button type="button" class="remove-photo-btn" onclick="markExistingForDeletion({{ $photo->id }})">×</button>
                                    </div>
                                @endforeach
                            @endif

                            <div class="photo-upload-box" onclick="document.getElementById('photosInput').click()" id="uploadTrigger">
                                <div class="upload-box-content">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                    <span>Ajouter une image</span>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="delete_media_ids" id="deleteMediaIds" value="">

                        <input type="file" id="photosInput" name="photos[]" accept="image/jpeg,image/jpg,image/png,image/webp" multiple class="file-input-hidden" onchange="handleFiles(this.files)">
                    </div>

                    <div class="form-group" style="margin-top: 2rem;">
                        <label for="description" class="form-label" style="font-size: 0.9rem; font-weight: 700; color: #000; margin-bottom: 0.5rem;">Description de l'annonce</label>
                        <textarea id="description" name="description" class="form-input" rows="5" placeholder="Description" required>{{ old('description', $annonce->description) }}</textarea>
                    </div>

                    <div style="display: flex; gap: 1rem;">
                        <div class="form-group" style="flex: 1;">
                            <label for="prix" class="form-label" style="font-size: 0.9rem; font-weight: 700; color: #000; margin-bottom: 0.5rem;">Prix de vente (FCFA)</label>
                            <input type="number" id="prix" name="prix" class="form-input" placeholder="Ex: 5000" min="0" required value="{{ old('prix', $annonce->prix) }}">
                        </div>
                        <div id="quantity-container" class="form-group" style="flex: 1;">
                            <label for="quantite" class="form-label" style="font-size: 0.9rem; font-weight: 700; color: #000; margin-bottom: 0.5rem;">Quantité</label>
                            <input type="number" id="quantite" name="quantite" class="form-input" placeholder="Ex: 1" min="1" required value="{{ old('quantite', $annonce->produit->quantite ?? 1) }}">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="previousStep()">Précédent</button>
                        <button type="button" class="btn btn-primary" onclick="nextStep()">Continuer</button>
                    </div>
                </div>

                <!-- Étape 4: Booster votre annonce -->
                <div class="form-step" id="step4">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem;">
                        <div>
                            <h1 class="form-title" style="margin-bottom: 0.5rem;">🚀 Booster votre annonce</h1>
                            <p class="instruction-text" style="color: #666; font-size: 0.95rem;">Mettez votre annonce en avant pour vendre plus vite.</p>
                        </div>
                    </div>


                    <input type="hidden" id="type_livraison" name="type_livraison" value="{{ old('type_livraison', $annonce->type_livraison ?? 'livraison_domicile') }}" required>
                    <input type="hidden" id="user_phone" name="user_phone" value="{{ old('user_phone', $annonce->vendeur->user->telephone ?? auth()->user()->telephone ?? '00000000') }}">
                    <input type="hidden" id="code_postal" name="code_postal" value="{{ old('code_postal', $annonce->code_postal ?? '00000') }}">

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
                        <button type="button" class="btn btn-secondary" onclick="previousStep()">Précédent</button>
                        <button type="submit" class="btn btn-primary" id="submitButton">Enregistrer les modifications</button>
                    </div>
                </div>
            </form>
        </main>

        <div id="advisoryArea" class="advisory-container">
            <div id="advisoryContentStep2" class="advisory-box">
                <h3 class="advisory-title">Catégories détaillées</h3>
                <p class="advisory-text">Une catégorie précise aide les acheteurs à trouver votre produit plus facilement.</p>
            </div>
            <div id="advisoryContentStep3" class="advisory-box" style="display: none;">
                <h3 class="advisory-title">L'importance des photos</h3>
                <p class="advisory-text">Des photos claires et sous différents angles augmentent considérablement vos chances de vente.</p>
            </div>
        </div>
    </div>


    <script>
        var currentStep = parseInt("{{ old('current_step', 1) }}");
        var totalSteps = 4;
        var uploadedImages = [];
        var deletedMediaIds = [];
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
            toggleStockVisibility(id);
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
            toggleStockVisibility(id);
        }

        function onLevel3Change(id) {
            if (!id) return;
            document.getElementById('categorie_id').value = id;
            fetchFilters(id);
            toggleStockVisibility(id);
        }

        function fetchFilters(categoryId) {
            const container = document.getElementById('dynamic-filters-container');
            if (!container) return;
            container.innerHTML = '<div style="padding: 1rem; color: #666; font-size: 0.9rem;"><i class="fas fa-spinner fa-spin"></i> Chargement des critères spécifiques...</div>';

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
                            const commonStyle = 'width: 100%; padding: 0.75rem; border: 1.5px solid #e0e0e0; border-radius: 8px; font-size: 0.9rem; outline: none; transition: border-color 0.2s; background: white;';
                            
                            if (filter.type === 'select' || (filter.options && filter.options.length > 0)) {
                                inputHtml = `<select name="attributes[${filter.id}]" style="${commonStyle}" ${filter.is_required ? 'required' : ''}>
                                    <option value="">Sélectionner ${filter.nom}</option>
                                    ${filter.options.map(opt => `<option value="${opt}" ${opt == existingValue ? 'selected' : ''}>${opt}</option>`).join('')}
                                </select>`;
                            } else if (filter.type === 'number' || filter.type === 'price') {
                                inputHtml = `<div style="display: flex; align-items: center;">
                                    <input type="number" name="attributes[${filter.id}]" style="${commonStyle} ${filter.unit ? 'border-top-right-radius: 0; border-bottom-right-radius: 0;' : ''}" value="${existingValue}" placeholder="${filter.nom}" ${filter.is_required ? 'required' : ''}>
                                    ${filter.unit ? `<span style="padding: 0.75rem; background: #edf2f7; border: 1.5px solid #e0e0e0; border-left: none; border-top-right-radius: 8px; border-bottom-right-radius: 8px; font-size: 0.85rem; color: #4a5568; font-weight: 600;">${filter.unit}</span>` : ''}
                                </div>`;
                            } else {
                                inputHtml = `<input type="text" name="attributes[${filter.id}]" style="${commonStyle}" value="${existingValue}" placeholder="${filter.nom}" ${filter.is_required ? 'required' : ''}>`;
                            }

                            field.innerHTML = `
                                <label style="display: block; margin-bottom: 0.5rem; font-size: 0.85rem; font-weight: 600; color: #4a5568;">
                                    ${filter.nom} ${filter.is_required ? '<span style="color: #e74c3c;">*</span>' : ''}
                                </label>
                                ${inputHtml}
                            `;
                            container.appendChild(field);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching filters:', error);
                    container.innerHTML = '';
                });
        }

        function nextStep() {
            if (!validateCurrentStep()) return;
            if (currentStep >= totalSteps) { document.getElementById('createAnnonceForm').submit(); return; }
            if (currentStep === 1) {
                const val = document.getElementById('product_name').value;
                document.getElementById('summary_product_name').textContent = val;
                document.getElementById('summary_product_name_s3').textContent = val;
            }
            document.getElementById('step' + currentStep).classList.remove('active');
            document.querySelector(`.progress-sidebar [data-step="${currentStep}"]`).classList.replace('active', 'completed');
            currentStep++;
            document.getElementById('step' + currentStep).classList.add('active');
            document.querySelector(`.progress-sidebar [data-step="${currentStep}"]`).classList.add('active');
            document.getElementById('current_step_input').value = currentStep;
            toggleAdvisory(currentStep);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function previousStep() {
            if (currentStep <= 1) return;
            document.getElementById('step' + currentStep).classList.remove('active');
            document.querySelector(`.progress-sidebar [data-step="${currentStep}"]`).classList.remove('active');
            currentStep--;
            document.getElementById('step' + currentStep).classList.add('active');
            document.querySelector(`.progress-sidebar [data-step="${currentStep}"]`).classList.replace('completed', 'active');
            document.getElementById('current_step_input').value = currentStep;
            toggleAdvisory(currentStep);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function toggleAdvisory(step) {
            const area = document.getElementById('advisoryArea');
            if (step === 2 || step === 3) {
                area.classList.add('active');
                document.getElementById('advisoryContentStep2').style.display = step === 2 ? 'block' : 'none';
                document.getElementById('advisoryContentStep3').style.display = step === 3 ? 'block' : 'none';

                if (step === 3) {
                    // Hide État for Immobilier/Services
                    const catId = document.getElementById('categorie_id').value;
                    const condGroup = document.getElementById('productConditionGroup');
                    if (catId && condGroup) {
                        let curr = categoriesData[catId];
                        while (curr && curr.parent_id) curr = categoriesData[curr.parent_id];
                        const hide = curr && (curr.famille === 'Services' || curr.famille === 'Immobilier');
                        condGroup.style.display = hide ? 'none' : 'block';
                    }
                }
            } else area.classList.remove('active');
        }

        function validateCurrentStep() {
            if (currentStep === 1) {
                if (document.getElementById('product_name').value.trim().length < 3) {
                    alert('Le titre doit faire au moins 3 caractères.');
                    return false;
                }
                return true;
            }
            if (currentStep === 2) {
                if (document.getElementById('categorie_id').value == "") {
                    alert('Veuillez sélectionner une catégorie finale.');
                    return false;
                }
                return true;
            }
            if (currentStep === 3) {
                if (document.getElementById('description').value.trim().length < 10) {
                    alert('La description doit faire au moins 10 caractères.');
                    return false;
                }
                const existingPhotos = document.querySelectorAll('.existing-photo:not([style*="display: none"])').length;
                if ((uploadedImages.length + existingPhotos) < 1) {
                    alert('Veuillez ajouter au moins une photo.');
                    return false;
                }
                const prix = document.getElementById('prix').value;
                if (!prix || prix <= 0) {
                    alert('Veuillez saisir un prix valide.');
                    return false;
                }
                return true;
            }
            return true;
        }

        // Add validation to form submission to catch step 4 credit check before submitting
        document.getElementById('createAnnonceForm').addEventListener('submit', function (e) {
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

        // --- Credit Services Logic ---
        document.addEventListener('DOMContentLoaded', function() {
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
        });

        function handleFiles(files) {
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => { uploadedImages.push({ file, preview: e.target.result }); renderPhotoGrid(); };
                reader.readAsDataURL(file);
            });
        }

        function renderPhotoGrid() {
            const grid = document.getElementById('photoGrid');
            grid.querySelectorAll('.new-photo').forEach(p => p.remove());
            uploadedImages.forEach((img, i) => {
                const div = document.createElement('div');
                div.className = 'image-preview-item new-photo';
                div.innerHTML = `<img src="${img.preview}"><button type="button" class="remove-photo-btn" onclick="removeNewPhoto(${i})">×</button>`;
                grid.insertBefore(div, document.getElementById('uploadTrigger'));
            });
            updateFileInput();
        }

        function removeNewPhoto(i) { uploadedImages.splice(i, 1); renderPhotoGrid(); }

        function markExistingForDeletion(id) {
            deletedMediaIds.push(id);
            document.getElementById('media-' + id).style.display = 'none';
            document.getElementById('deleteMediaIds').value = deletedMediaIds.join(',');
            updatePhotoCount();
        }

        function updateFileInput() {
            const dt = new DataTransfer();
            uploadedImages.forEach(img => dt.items.add(img.file));
            document.getElementById('photosInput').files = dt.files;
            updatePhotoCount();
        }

        function updatePhotoCount() {
            const total = uploadedImages.length + document.querySelectorAll('.existing-photo:not([style*="display: none"])').length;
            document.getElementById('photoCountDisplay').textContent = total + ' sur 8';
        }

        function selectStatus(el, val) {
            document.getElementById('etat_produit').value = val;
            document.querySelectorAll('#step3 .status-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
        }

        function selectShipping(el, val) {
            document.getElementById('type_livraison').value = val;
            document.querySelectorAll('#step4 .status-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
        }

        function closeSubcategoryModal() { }
        function goBackInModal() { }

        document.addEventListener('DOMContentLoaded', function() {
            const catId = "{{ $annonce->categorie_id }}";
            if (catId) {
                // Determine path to pre-fill selectors
                let path = [];
                let curr = categoriesData[catId];
                while(curr) { path.unshift(curr.id); curr = categoriesData[curr.parent_id]; }
                
                if (path.length >= 1) {
                    const mainId = path[0];
                    const badge = document.querySelector(`.main-cat-badge[data-id="${mainId}"]`);
                    if(badge) selectMainCategory(badge, mainId);
                    
                    if (path.length >= 2) {
                        document.getElementById('level2Select').value = path[1];
                        onLevel2Change(path[1]);
                        
                        if (path.length >= 3) {
                            document.getElementById('level3Select').value = path[2];
                            onLevel3Change(path[2]);
                        }
                    }
                }
            }
            updatePhotoCount();
            
            // Restore step state on load
            if(currentStep > 1) {
                document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
                document.querySelectorAll('.progress-step').forEach(s => s.classList.remove('active'));
                
                document.getElementById('step' + currentStep).classList.add('active');
                
                for(let i=1; i<currentStep; i++) {
                    document.querySelector(`.progress-sidebar [data-step="${i}"]`).classList.add('completed');
                }
                document.querySelector(`.progress-sidebar [data-step="${currentStep}"]`).classList.add('active');
            }
            const initialCatId = document.getElementById('categorie_id').value;
            if (initialCatId) {
                toggleStockVisibility(initialCatId);
            }
        });

        function toggleStockVisibility(categoryId) {
            const container = document.getElementById('quantity-container');
            const input = document.getElementById('quantite');
            if (!container || !input) return;

            const cat = categoriesData[categoryId];
            if (cat && (cat.famille === 'Services' || cat.famille === 'Immobilier')) {
                container.style.display = 'none';
                input.value = '1';
                input.removeAttribute('required');
            } else {
                container.style.display = 'block';
                input.setAttribute('required', 'required');
            }
        }
    </script>
@endsection