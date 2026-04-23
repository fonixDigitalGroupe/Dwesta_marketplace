@extends('layouts.admin')

@section('title', 'Nouveau pack de crédits')

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
        <!-- Main Conteneur -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1.5rem;">
            
            <div style="margin-bottom: 0.5rem;">
                <h1 style="font-size: 1.25rem; font-weight: 700; color: #333; margin: 0;">Nouveau pack de crédits</h1>
            </div>
            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1rem;"></div>

            <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 1rem;">
                <a href="{{ route('admin.credits.packs') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.borderColor='#e67e00'" onmouseout="this.style.borderColor='#ddd'">
                    Retour à la liste <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i>
                </a>
            </div>

            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1.5rem;"></div>

            <form method="POST" action="{{ route('admin.credits.packs.store') }}">
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
                                <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">
                                    Nom du pack <small style="color: red;">*</small>
                                </label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'"
                                    oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                                @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">
                                    Description
                                </label>
                                <textarea name="description" id="description" rows="5"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical; font-family: inherit;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'"
                                    oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">{{ old('description') }}</textarea>
                                @error('description') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Contenu & Tarification (Right) -->
                    <div style="background: #fdfdfd; border: 1px solid #f3f3f3; border-radius: 4px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            Contenu & Tarification
                        </h3>

                        <div style="display: grid; gap: 1.5rem;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                <div>
                                    <label for="credits" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">
                                        Crédits inclus <small style="color: red;">*</small>
                                    </label>
                                    <input type="number" name="credits" id="credits" value="{{ old('credits') }}" min="1" required
                                        style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                        onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                    @error('credits') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="bonus_credits" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">
                                        Crédits bonus
                                    </label>
                                    <input type="number" name="bonus_credits" id="bonus_credits" value="{{ old('bonus_credits', 0) }}" min="0" required
                                        style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                        onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                    @error('bonus_credits') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="prix" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">
                                    Prix en FCFA <small style="color: red;">*</small>
                                </label>
                                <input type="number" name="prix" id="prix" value="{{ old('prix') }}" min="0" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                @error('prix') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer Actions -->
                <div style="display: flex; justify-content: flex-end; align-items: center; gap: 12px; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f3f3f3;">
                    <a href="{{ route('admin.credits.packs') }}"
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
