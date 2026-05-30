@extends('layouts.admin')

@section('title', 'Nouvelle Carte Cadeau')

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        /* Input Amazon Style Modernisé */
        input[type="text"],
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

        /* Enlever les flèches du champ nombre */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
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

        /* Custom Checkbox Amazon Style */
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 0;
            user-select: none;
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        .checkmark {
            height: 18px;
            width: 18px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            position: relative;
            transition: all 0.2s;
        }

        .checkbox-container:hover input ~ .checkmark {
            border-color: #ff9900;
        }

        .checkbox-container input:checked ~ .checkmark {
            background-color: #ff9900;
            border-color: #ff9900;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .checkbox-container input:checked ~ .checkmark:after {
            display: block;
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
                        <i class="fas fa-plus" style="font-size: 0.8rem;"></i>
                        <span>Nouvelle Option de Carte Cadeau</span>
                    </div>
                </div>

                <a href="{{ route('admin.gift_cards.index') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                    <i class="fas fa-list" style="color: #ff9900;"></i> Voir les cartes
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
                            <p style="font-size: 0.75rem; color: #64748b; margin-top: 5px;">Le montant facial de la carte cadeau.
                            </p>
                            @error('amount')
                                <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="field-label">
                                Description
                            </label>
                            <input type="text" name="description" id="description" value="{{ old('description') ? ucfirst(old('description')) : '' }}"
                                placeholder="Description (Ex: Idéal pour un petit cadeau)">
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
                                    <span style="font-weight: 600; color: #1e293b; font-size: 0.85rem;">Option Populaire</span>
                                    <span style="font-size: 0.75rem; color: #64748b; font-weight: 400;">Affiche un badge
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
                                    <span style="font-weight: 600; color: #1e293b; font-size: 0.85rem;">Statut Actif</span>
                                    <span style="font-size: 0.75rem; color: #64748b; font-weight: 400;">Rendre cette carte
                                        disponible à l'achat immédiatement.</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div style="display: grid; grid-template-columns: 140px 140px; gap: 12px; justify-content: end; border-top: 1px solid #eff3f6; padding-top: 20px; margin-top: 20px;">
                    <a href="{{ route('admin.gift_cards.index') }}" class="btn-amazon-secondary" style="grid-column: 1; grid-row: 1;">
                        ANNULER
                    </a>
                    <button type="submit" class="btn-amazon-primary" style="grid-column: 2; grid-row: 1;">
                        ENREGISTRER
                    </button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script>
            document.getElementById('description')?.addEventListener('input', function() {
                if (this.value.length > 0) {
                    this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
                }
            });
        </script>
    @endpush
@endsection
