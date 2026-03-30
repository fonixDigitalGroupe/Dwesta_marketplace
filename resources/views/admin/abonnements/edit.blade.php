@extends('layouts.admin')

@section('title', 'Modifier le pack : ' . $abonnement->nom)

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
        background-color: #6b7280;
        border-color: #6b7280;
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

        <!-- Titre en majuscules -->
        <h2 style="font-size: 0.85rem; color: #555; font-weight: 700; text-transform: uppercase; margin-bottom: 1.5rem; letter-spacing: 0.05em;">
            Modifier le pack d'abonnement
        </h2>

        <!-- Barre d'outils -->
        <div style="display: flex; gap: 8px; margin-bottom: 1.5rem;">
            <a href="{{ route('admin.abonnements.index') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <i class="fas fa-arrow-left" style="font-size: 0.75rem; opacity: 0.6;"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('admin.abonnements.update', $abonnement) }}">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 300px; gap: 1.5rem; align-items: start;">

                <!-- Left Colonne -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Section 1: Identité -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Identité du Pack
                        </h2>

                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label for="type" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Type de pack <span style="color: red;">*</span>
                                </label>
                                <div class="custom-select-container" id="type-select">
                                    <input type="hidden" name="type" id="type-value" value="{{ old('type', $abonnement->type) }}">
                                    <div class="custom-select-trigger">
                                        <span id="type-label">{{ ucfirst(old('type', $abonnement->type)) }}</span>
                                        <i class="fas fa-chevron-down" style="font-size: 0.8rem; opacity: 0.5;"></i>
                                    </div>
                                    <div class="custom-select-options">
                                        @foreach($availableTypes as $type)
                                            <div class="custom-select-option" data-value="{{ $type }}">{{ ucfirst($type) }}</div>
                                        @endforeach
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const container = document.getElementById('type-select');
                                        const trigger = container.querySelector('.custom-select-trigger');
                                        const options = container.querySelector('.custom-select-options');
                                        const valueInput = document.getElementById('type-value');
                                        const labelSpan = document.getElementById('type-label');
                                        
                                        trigger.addEventListener('click', function() {
                                            container.classList.toggle('open');
                                        });
                                        
                                        container.querySelectorAll('.custom-select-option').forEach(option => {
                                            option.addEventListener('click', function() {
                                                const val = this.getAttribute('data-value');
                                                const text = this.textContent;
                                                valueInput.value = val;
                                                labelSpan.textContent = text;
                                                container.classList.remove('open');
                                            });
                                        });
                                        
                                        document.addEventListener('click', function(e) {
                                            if (!container.contains(e.target)) {
                                                container.classList.remove('open');
                                            }
                                        });
                                    });
                                </script>
                                @error('type') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Description
                                </label>
                                <textarea name="description" id="description" rows="3" required
                                    placeholder="Description"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical; font-family: inherit; text-transform: capitalize;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">{{ old('description', $abonnement->description) }}</textarea>
                                @error('description') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Tarification et Limites -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Tarification & Limites
                        </h2>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                            <div>
                                <label for="prix_mensuel" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Prix mensuel <span style="color: red;">*</span>
                                </label>
                                <input type="number" name="prix_mensuel" id="prix_mensuel" value="{{ old('prix_mensuel', $abonnement->prix_mensuel) }}" min="0" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                @error('prix_mensuel') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="commission" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Commission (%) <span style="color: red;">*</span>
                                </label>
                                <input type="number" name="commission" id="commission" value="{{ old('commission', $abonnement->commission) }}" min="0" max="100" step="0.01" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                @error('commission') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="nombre_annonces" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                Nombre d'annonces autorisées (0 si illimité) <span style="color: red;">*</span>
                            </label>
                            <input type="number" name="nombre_annonces" id="nombre_annonces" value="{{ old('nombre_annonces', $abonnement->nombre_annonces) }}" min="0" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;"
                                onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            @error('nombre_annonces') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                    </div>

                </div>

                <!-- Right Colonne -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Section Disponibilité -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">
                            Disponibilité & Options
                        </h2>

                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <label class="checkbox-container">
                                <input type="checkbox" name="actif" value="1" {{ old('actif', $abonnement->actif) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <span style="font-size: 0.95rem; color: #333;">Pack actif et visible</span>
                            </label>

                            <label class="checkbox-container">
                                <input type="checkbox" name="page_pro" value="1" {{ old('page_pro', $abonnement->page_pro) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <span style="font-size: 0.95rem; color: #333;">Accès Boutique Page Pro</span>
                            </label>
                            
                            <hr style="border: 0; border-top: 1px solid #eee; margin: 0.5rem 0;">
                            
                            <div style="display: flex; gap: 10px; margin-top: 1rem;">
                                <a href="{{ route('admin.abonnements.index') }}"
                                    style="flex: 1; text-align: center; background: #e74c3c; border: none; color: #fff; padding: 10px; border-radius: 6px; font-size: 0.95rem; font-weight: 500; cursor: pointer; text-decoration: none; transition: opacity 0.2s;"
                                    onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                    Annuler
                                </a>
                                <button type="submit"
                                    style="flex: 1; background: #e67e00; color: #fff; border: none; padding: 10px; border-radius: 6px; font-size: 0.95rem; font-weight: 500; cursor: pointer; transition: opacity 0.2s;"
                                    onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                    Enregistrer
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>
@endsection
