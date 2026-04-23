@extends('layouts.admin')

@section('title', 'Nouveau pack d\'abonnement')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
    /* Custom Checkbox Style */
    .checkbox-container {
        display: flex;
        align-items: center;
        gap: 12px;
        cursor: pointer;
        padding: 4px 0;
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
        height: 20px;
        width: 20px;
        background-color: #fff;
        border: 2px solid #e0e0e0;
        border-radius: 4px;
        position: relative;
        transition: all 0.2s;
    }
    
    .checkbox-container:hover input ~ .checkmark {
        border-color: #6b7280;
    }
    
    .checkbox-container input:checked ~ .checkmark {
        background-color: #e67e00;
        border-color: #e67e00;
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
    
    /* Custom Select Style */
    .custom-select-container {
        position: relative;
        width: 100%;
    }
    
    .custom-select-trigger {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 0.95rem;
        color: #333;
        background-color: white;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .custom-select-options {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #e0e0e0;
        border-top: none;
        border-radius: 0 0 6px 6px;
        display: none;
        z-index: 1000;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    
    .custom-select-option {
        padding: 10px 14px;
        cursor: pointer;
        font-size: 0.95rem;
        color: #333;
        transition: background 0.2s;
    }
    
    .custom-select-option:hover {
        background-color: #f1f5f9;
    }
    
    .custom-select-container.open .custom-select-options {
        display: block;
    }
    
    .custom-select-container.open .custom-select-trigger {
        border-radius: 6px 6px 0 0;
        border-color: #e67e00;
    }
    
    /* Hide Number Spinners */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
    
    /* Attempt to style select highlights */
    select option:checked,
    select option:hover {
        background-color: #f1f5f9 !important;
        color: #333 !important;
    }
    
    select:focus {
        border-color: #e67e00 !important;
        box-shadow: 0 0 0 2px rgba(230, 126, 0, 0.1) !important;
    }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">
        <!-- Main Conteneur -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1.5rem;">
            
            <div style="margin-bottom: 0.5rem;">
                <h1 style="font-size: 1.25rem; font-weight: 700; color: #333; margin: 0;">Nouveau Pack d'Abonnement</h1>
            </div>
            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1rem;"></div>

            <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 1rem;">
                <a href="{{ route('admin.abonnements.index') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.borderColor='#e67e00'" onmouseout="this.style.borderColor='#ddd'">
                    Retour à la liste <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i>
                </a>
            </div>

            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1.5rem;"></div>

        <form method="POST" action="{{ route('admin.abonnements.store') }}">
            @csrf

            <!-- Grid Layout Side-by-Side (Equal Heights) -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: stretch;">

                <!-- Section 1: Identité (Left) -->
                <div style="background: #fdfdfd; border: 1px solid #f3f3f3; border-radius: 4px; padding: 1.5rem;">
                    <h3 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                        Identité du Pack
                    </h3>

                    <div style="display: grid; gap: 1.5rem;">
                        <div>
                            <label for="type" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">
                                Type de pack <small style="color: red;">*</small>
                            </label>
                            <select name="type" id="type" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: white; cursor: pointer;">
                                @foreach($availableTypes as $type)
                                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                                @endforeach
                            </select>
                            @if(empty($availableTypes))
                                <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">Tous les types de packs ont déjà été créés.</p>
                            @endif
                            @error('type') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">
                                Description <small style="color: red;">*</small>
                            </label>
                            <textarea name="description" id="description" rows="6" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical; font-family: inherit;"
                                onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'"
                                oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">{{ old('description') }}</textarea>
                            @error('description') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Configuration & Tarification (Right) -->
                <div style="background: #fdfdfd; border: 1px solid #f3f3f3; border-radius: 4px; padding: 1.5rem;">
                    <h3 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                        Configuration & Tarification
                    </h3>

                    <div style="display: grid; gap: 1.5rem;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div>
                                <label for="prix_mensuel" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">
                                    Prix mensuel (FCFA) <small style="color: red;">*</small>
                                </label>
                                <input type="number" name="prix_mensuel" id="prix_mensuel" value="{{ old('prix_mensuel', 0) }}" min="0" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                @error('prix_mensuel') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="commission" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">
                                    Commission (%) <small style="color: red;">*</small>
                                </label>
                                <input type="number" name="commission" id="commission" value="{{ old('commission', 0) }}" min="0" max="100" step="0.01" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                @error('commission') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="nombre_annonces" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">
                                Annonces autorisées (0 = illimité) <small style="color: red;">*</small>
                            </label>
                            <input type="number" name="nombre_annonces" id="nombre_annonces" value="{{ old('nombre_annonces', 0) }}" min="0" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            @error('nombre_annonces') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>

                        <div style="margin-top: 0.5rem; padding-top: 1rem; border-top: 1px solid #eee;">
                            <label class="checkbox-container">
                                <input type="checkbox" name="page_pro" value="1" {{ old('page_pro') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <span style="font-size: 0.95rem; color: #333; font-weight: 500;">Activer l'accès Boutique Page Pro</span>
                            </label>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer Actions -->
            <div style="display: flex; justify-content: flex-end; align-items: center; gap: 12px; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f3f3f3;">
                <a href="{{ route('admin.abonnements.index') }}"
                    style="background: #fff; border: 1px solid #ddd; color: #333; padding: 10px 24px; border-radius: 6px; font-size: 0.9rem; font-weight: 600; text-decoration: none; transition: all 0.2s;"
                    onmouseover="this.style.borderColor='#e67e00'" onmouseout="this.style.borderColor='#ddd'">
                    Annuler
                </a>
                <button type="submit"
                    style="background: #e67e00; color: #fff; border: none; padding: 10px 32px; border-radius: 6px; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: opacity 0.2s;"
                    onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    Enregistrer
                </button>
            </div>
        </form>
        </div>
    </div>
@endsection
