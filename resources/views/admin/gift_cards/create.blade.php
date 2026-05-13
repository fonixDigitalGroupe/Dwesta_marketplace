@extends('layouts.admin')

@section('title', 'Nouvelle Carte Cadeau')

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        /* Input Amazon Style */
        input[type="text"],
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

        /* Custom Checkbox Amazon Style */
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 4px 0;
            user-select: none;
            font-size: 0.85rem;
            color: #111;
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            height: 16px;
            width: 16px;
            background-color: #fff;
            border: 1px solid #adb1b8;
            border-radius: 0;
            position: relative;
            transition: all 0.1s;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) inset;
        }

        .checkbox-container:hover input ~ .checkmark {
            border-color: #e77600;
        }

        .checkbox-container input:checked ~ .checkmark {
            background-color: #fff;
            border-color: #e77600;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            left: 5px;
            top: 1px;
            width: 4px;
            height: 8px;
            border: solid #e77600;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .checkbox-container input:checked ~ .checkmark:after {
            display: block;
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-amazon-secondary:hover {
            background: linear-gradient(to bottom, #e7eaf0, #d8dade);
            border-color: #a2a6ac;
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
                <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">Ajouter une option de Carte Cadeau
                </h1>
                <a href="{{ route('admin.gift_cards.index') }}" class="btn-amazon-secondary"
                    style="display: flex; align-items: center; gap: 8px;">
                    <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i> Retour à la liste
                </a>
            </div>

            <form action="{{ route('admin.gift_cards.store') }}" method="POST">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: stretch;">

                    <!-- Section 1: Détails de la carte -->
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Informations Générales</h3>

                        <div style="margin-bottom: 20px;">
                            <label for="amount" class="field-label">
                                Montant (FCFA) <small style="color: red;">*</small>
                            </label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount') }}" min="1"
                                placeholder="Ex: 5000" required>
                            <p style="font-size: 0.75rem; color: #555; margin-top: 5px;">Le montant facial de la carte cadeau.
                            </p>
                            @error('amount')
                                <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="field-label">
                                Description
                            </label>
                            <input type="text" name="description" id="description" value="{{ old('description') }}"
                                placeholder="Ex: Idéal pour un petit cadeau">
                            @error('description')
                                <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Section 2: Visibilité & Statut -->
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Visibilité & Statut</h3>

                        <div style="margin-bottom: 25px;">
                            <label class="checkbox-container">
                                <input type="checkbox" name="is_popular" id="is_popular" value="1"
                                    {{ old('is_popular') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <span style="font-weight: 700;">Option Populaire</span>
                                    <span style="font-size: 0.75rem; color: #555; font-weight: 400;">Affiche un badge
                                        "POPULAIRE" sur cette option.</span>
                                </div>
                            </label>
                        </div>

                        <div>
                            <label class="checkbox-container">
                                <input type="checkbox" name="is_active" id="is_active" value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <span style="font-weight: 700;">Statut Actif</span>
                                    <span style="font-size: 0.75rem; color: #555; font-weight: 400;">Rendre cette carte
                                        disponible à l'achat immédiatement.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div style="display: flex; justify-content: flex-end; gap: 15px; padding-top: 25px; margin-top: 20px; border-top: 1px solid #e7e7e7;">
                    <a href="{{ route('admin.gift_cards.index') }}" class="btn-amazon-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn-amazon-primary">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
