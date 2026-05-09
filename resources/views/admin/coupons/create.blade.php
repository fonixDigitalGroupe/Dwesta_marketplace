@extends('layouts.admin')

@section('title', 'Créer un Code Promo')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
    .amazon-card {
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 4px;
        padding: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 8px;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #adb1b8;
        border-radius: 3px;
        font-size: 0.9rem;
        transition: all 0.1s;
        outline: none;
        background: #fff;
    }

    .form-input:focus, .form-select:focus {
        border-color: #e77600 !important;
        box-shadow: 0 0 3px 2px rgba(228, 121, 17, 0.5) !important;
    }

    .btn-amazon-primary {
        background: linear-gradient(to bottom, #f7dfa5, #f0c14b);
        border: 1px solid #a88734;
        border-radius: 3px;
        color: #111;
        padding: 8px 15px;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-amazon-secondary {
        background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
        border: 1px solid #adb1b8;
        border-radius: 3px;
        color: #111;
        padding: 8px 15px;
        font-size: 0.85rem;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    
    {{-- Header --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1 style="font-size: 1.5rem; font-weight: 500; color: #111; margin: 0;">Nouveau Code Promo</h1>
        <a href="{{ route('admin.coupons.index') }}" class="btn-amazon-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <form action="{{ route('admin.coupons.store') }}" method="POST">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 25px;">
            
            {{-- Colonne Gauche --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                
                {{-- Informations du Code --}}
                <div class="amazon-card">
                    <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                        Général
                    </h2>

                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div>
                            <label for="code" class="form-label">Code Promotionnel <span style="color: #c40000;">*</span></label>
                            <input type="text" name="code" id="code" value="{{ old('code') }}" class="form-input" style="text-transform: uppercase;" placeholder="Ex: ETE2025" required>
                            <p style="font-size: 0.75rem; color: #555; margin-top: 5px;">Le code que vos clients saisiront au moment du paiement.</p>
                        </div>

                        <div>
                            <label for="category_id" class="form-label">Restriction par catégorie</label>
                            <select name="category_id" id="category_id" class="form-select">
                                <option value="">-- Appliquer sur tout le site --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->chemin ?? $category->nom }}
                                    </option>
                                @endforeach
                            </select>
                            <p style="font-size: 0.75rem; color: #555; margin-top: 5px;">Si défini, le coupon ne sera valide que pour les articles de cette catégorie.</p>
                        </div>
                    </div>
                </div>

                {{-- Règles de Réduction --}}
                <div class="amazon-card">
                    <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                        Règles de Réduction
                    </h2>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label for="type" class="form-label">Type <span style="color: #c40000;">*</span></label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Pourcentage (%)</option>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Montant Fixe (FCFA)</option>
                            </select>
                        </div>

                        <div>
                            <label for="value" class="form-label">Valeur <span style="color: #c40000;">*</span></label>
                            <input type="number" step="0.01" min="0" name="value" id="value" value="{{ old('value') }}" class="form-input" placeholder="Ex: 10 ou 5000" required>
                        </div>
                    </div>

                    <div style="margin-top: 20px;">
                        <label for="min_purchase" class="form-label">Montant minimum d'achat</label>
                        <input type="number" step="0.01" min="0" name="min_purchase" id="min_purchase" value="{{ old('min_purchase') }}" class="form-input" placeholder="Ex: 50000">
                        <p style="font-size: 0.75rem; color: #555; margin-top: 5px;">Laissez vide ou mettez 0 pour ignorer ce critère.</p>
                    </div>
                </div>

            </div>

            {{-- Colonne Droite --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                
                {{-- Limites & Dates --}}
                <div class="amazon-card">
                    <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 15px; color: #111;">Validité & Utilisation</h2>
                    
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div>
                            <label for="start_date" class="form-label">Date de début</label>
                            <input type="datetime-local" name="start_date" id="start_date" value="{{ old('start_date') }}" class="form-input">
                        </div>

                        <div>
                            <label for="end_date" class="form-label">Date de fin</label>
                            <input type="datetime-local" name="end_date" id="end_date" value="{{ old('end_date') }}" class="form-input">
                        </div>

                        <div style="border-top: 1px solid #eee; padding-top: 15px;">
                            <label for="usage_limit" class="form-label">Limite d'utilisation globale</label>
                            <input type="number" min="1" name="usage_limit" id="usage_limit" value="{{ old('usage_limit') }}" class="form-input" placeholder="Ex: 100">
                            <p style="font-size: 0.75rem; color: #555; margin-top: 5px;">Nombre max d'utilisation de ce coupon. Vide = illimité.</p>
                        </div>

                        <div style="background: #fcfcfc; border: 1px solid #eee; padding: 15px; border-radius: 4px; margin-top: 5px;">
                            <div style="display: flex; align-items: start; gap: 10px;">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} 
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #e47911; margin-top: 2px;">
                                <label for="is_active" style="cursor: pointer;">
                                    <div style="font-size: 0.85rem; font-weight: 700; color: #111;">Code actif</div>
                                    <div style="font-size: 0.75rem; color: #555;">Le code pourra être utilisé par les clients.</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 25px; display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit" class="btn-amazon-primary" style="width: 100%; height: 40px;">
                            Sauvegarder le code
                        </button>
                        <a href="{{ route('admin.coupons.index') }}" class="btn-amazon-secondary" style="width: 100%; height: 40px;">
                            Annuler
                        </a>
                    </div>
                </div>

                {{-- Aide --}}
                <div style="background: #fff; border-left: 4px solid #e47911; padding: 15px; font-size: 0.8rem; color: #555; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                    <div style="font-weight: 700; color: #111; margin-bottom: 5px;">Astuce Amazon :</div>
                    Limitez la durée de validité pour créer un sentiment d'urgence et augmenter votre taux de conversion.
                </div>

            </div>

        </div>
    </form>
</div>
@endsection
