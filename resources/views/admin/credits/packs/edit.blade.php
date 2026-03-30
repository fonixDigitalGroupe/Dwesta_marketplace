@extends('layouts.admin')

@section('title', 'Modifier le pack')

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

    /* Hide Number Spinners */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">

        <!-- Titre en majuscules -->
        <h2 style="font-size: 0.85rem; color: #555; font-weight: 700; text-transform: uppercase; margin-bottom: 1.5rem; letter-spacing: 0.05em;">
            Modifier le pack : {{ $pack->nom }}
        </h2>

        <!-- Barre d'outils -->
        <div style="display: flex; gap: 8px; margin-bottom: 1.5rem;">
            <a href="{{ route('admin.credits.packs') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <i class="fas fa-arrow-left" style="font-size: 0.75rem; opacity: 0.6;"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('admin.credits.packs.update', $pack) }}">
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
                                <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Nom du pack <span style="color: red;">*</span>
                                </label>
                                <input type="text" name="nom" id="nom" value="{{ ucfirst(old('nom', $pack->nom)) }}" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'"
                                    oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                                @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Description
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical; font-family: inherit;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'"
                                    oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">{{ ucfirst(old('description', $pack->description)) }}</textarea>
                                @error('description') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Valeur et Prix -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Contenu & Tarification
                        </h2>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                            <div>
                                <label for="credits" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Crédits inclus <span style="color: red;">*</span>
                                </label>
                                <input type="number" name="credits" id="credits" value="{{ old('credits', $pack->credits) }}" min="1" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                @error('credits') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="bonus_credits" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Crédits bonus
                                </label>
                                <input type="number" name="bonus_credits" id="bonus_credits" value="{{ old('bonus_credits', $pack->bonus_credits) }}" min="0" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                @error('bonus_credits') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="prix" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                Prix en FCFA <span style="color: red;">*</span>
                            </label>
                            <input type="number" name="prix" id="prix" value="{{ old('prix', $pack->prix) }}" min="0" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;"
                                onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            @error('prix') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                    </div>

                </div>

                <!-- Right Colonne -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Section Disponibilité -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">
                            Disponibilité
                        </h2>

                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <label class="checkbox-container">
                                <input type="checkbox" name="actif" value="1" {{ old('actif', $pack->actif) ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <span style="font-size: 0.95rem; color: #333;">Pack actif et visible</span>
                            </label>

                            <hr style="border: 0; border-top: 1px solid #eee; margin: 0.5rem 0;">

                            <div>
                                <label for="ordre" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Ordre d'affichage
                                </label>
                                <input type="number" name="ordre" id="ordre" value="{{ old('ordre', $pack->ordre) }}" min="0"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            
                            <div style="display: flex; gap: 10px; margin-top: 1rem;">
                                <a href="{{ route('admin.credits.packs') }}"
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
