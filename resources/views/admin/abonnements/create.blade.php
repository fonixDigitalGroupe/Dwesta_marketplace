@extends('layouts.admin')

@section('title', 'Nouveau pack d\'abonnement')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
    /* Input Amazon Style Modernisé */
    input[type="text"], input[type="number"], textarea, select {
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

    input:focus, textarea:focus, select:focus {
        border-color: #ff9900 !important;
        box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15) !important;
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

    /* Buttons Amazon Style */
    .btn-amazon-primary {
        background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: #fff !important;
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
    }

    .btn-amazon-primary:hover {
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        color: #fff !important;
    }

    .btn-amazon-secondary {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569 !important;
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
    }

    .btn-amazon-secondary:hover {
        background: #f8fafc;
        border-color: #dee2e6;
        color: #1e293b !important;
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
                    <span>Nouveau pack d'abonnement</span>
                </div>
            </div>
            <a href="{{ route('admin.abonnements.index') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                <i class="fas fa-list" style="color: #ff9900;"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('admin.abonnements.store') }}">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 400px; gap: 20px; align-items: stretch;">
                
                <!-- Section 1: Identité -->
                <div class="amazon-card" style="margin: 0;">
                    <h3 class="section-title">Identité du Pack</h3>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="famille" class="field-label">
                            Famille <small style="color: red;">*</small>
                        </label>
                        <select name="famille" id="famille" required onchange="toggleTypeField()">
                            @foreach(\App\Models\Abonnement::familles() as $f)
                                <option value="{{ $f }}" {{ old('famille', $famille) === $f ? 'selected' : '' }}>{{ $f }}</option>
                            @endforeach
                        </select>
                        @error('famille') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="nom" class="field-label">
                            Nom du pack <small style="color: red;">*</small>
                        </label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required placeholder="Ex. Starter, Pro, Premium...">
                        @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>

                    <div id="type-field" style="margin-bottom: 20px;">
                        <label for="type" class="field-label">
                            Type (E-commerce) <small style="color: red;">*</small>
                        </label>
                        <select name="type" id="type">
                            <option value="">— Choisir —</option>
                            @foreach($availableTypes as $type)
                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        <p style="font-size: 0.72rem; color: #94a3b8; margin-top: 6px;">Réservé à l'E-commerce (gratuit/basic/expert). Ignoré pour les autres familles.</p>
                        @error('type') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="description" class="field-label">
                            Description <small style="color: red;">*</small>
                        </label>
                        <textarea name="description" id="description" rows="10" required
                            placeholder="Quels sont les avantages de ce pack ?"
                            oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"
                            style="resize: vertical; font-family: inherit;">{{ old('description') }}</textarea>
                        @error('description') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Section 2: Configuration & Tarification -->
                <div class="amazon-card" style="margin: 0; display: flex; flex-direction: column;">
                    <h3 class="section-title">Configuration & Tarification</h3>
                    
                    <div style="flex: 1;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                            <div>
                                <label for="prix_mensuel" class="field-label">
                                    Prix (FCFA) <small style="color: red;">*</small>
                                </label>
                                <input type="number" name="prix_mensuel" id="prix_mensuel" value="{{ old('prix_mensuel', 0) }}" min="0" required>
                                @error('prix_mensuel') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="duree_jours" class="field-label">
                                    Durée (jours) <small style="color: red;">*</small>
                                </label>
                                <input type="number" name="duree_jours" id="duree_jours" value="{{ old('duree_jours', 30) }}" min="1" required>
                                @error('duree_jours') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                            <div>
                                <label for="commission" class="field-label">
                                    Commission (%) <small style="color: red;">*</small>
                                </label>
                                <input type="number" name="commission" id="commission" value="{{ old('commission', 0) }}" min="0" max="100" step="0.01" required>
                                @error('commission') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="nombre_annonces" class="field-label">
                                    Annonces autorisées <small style="color: red;">*</small>
                                </label>
                                <input type="number" name="nombre_annonces" id="nombre_annonces" value="{{ old('nombre_annonces', 0) }}" min="0" required>
                                @error('nombre_annonces') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label for="limite_chiffre_affaires" class="field-label">
                                Limite chiffre d'affaires annuel (FCFA)
                            </label>
                            <input type="number" name="limite_chiffre_affaires" id="limite_chiffre_affaires"
                                   value="{{ old('limite_chiffre_affaires') }}"
                                   min="0" placeholder="Laisser vide = illimité">
                            <p style="font-size: 0.72rem; color: #94a3b8; margin-top: 6px;">
                                Si aucune valeur n'est saisie, aucune limite ne s'applique.
                            </p>
                            @error('limite_chiffre_affaires') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #f1f5f9; display: flex; flex-direction: column; gap: 15px;">
                            <label class="checkbox-container">
                                <input type="checkbox" name="actif" value="1" {{ old('actif', true) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <span style="font-weight: 600; color: #1e293b; font-size: 0.85rem;">Pack Actif</span>
                            </label>

                            <label class="checkbox-container">
                                <input type="checkbox" name="page_pro" value="1" {{ old('page_pro') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <span style="font-weight: 600; color: #1e293b; font-size: 0.85rem;">Activer l'accès Boutique Page Pro</span>
                            </label>
                            <p style="font-size: 0.75rem; color: #64748b; margin-left: 30px; margin-top: -8px;">
                                Permet au vendeur d'avoir une page personnalisée pour sa boutique.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Row (Sorti du cadre) -->
            <div style="display: grid; grid-template-columns: 240px 160px; gap: 12px; justify-content: end; margin-top: 30px; padding-top: 24px; border-top: 1px solid #eff3f6;">
                <button type="submit" class="btn-amazon-primary">
                    ENREGISTRER LE PACK
                </button>
                <a href="{{ route('admin.abonnements.index') }}" class="btn-amazon-secondary">
                    ANNULER
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function toggleTypeField() {
        var famille = document.getElementById('famille').value;
        var typeField = document.getElementById('type-field');
        var typeSelect = document.getElementById('type');
        if (famille === 'E-commerce') {
            typeField.style.display = 'block';
            typeSelect.setAttribute('required', 'required');
        } else {
            typeField.style.display = 'none';
            typeSelect.removeAttribute('required');
            typeSelect.value = '';
        }
    }
    document.addEventListener('DOMContentLoaded', toggleTypeField);
</script>
@endpush
@endsection
