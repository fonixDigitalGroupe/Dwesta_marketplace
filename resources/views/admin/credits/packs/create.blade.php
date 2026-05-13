@extends('layouts.admin')

@section('title', 'Nouveau pack de crédits')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
    /* Input Amazon Style */
    input[type="text"]:focus, input[type="number"]:focus, textarea:focus, select:focus {
        border-color: #e77600 !important;
        
        outline: none;
    }

    .amazon-card {
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
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

    .btn-amazon-primary {
        background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); border: 1px solid #004aad; color: #fff;
        padding: 8px 24px;
        border-radius: 0;
        font-size: 0.85rem;
        font-weight: 400;
        text-decoration: none;
        box-shadow: 0 1px 0 rgba(255,255,255,.4) inset;
        cursor: pointer;
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
        padding: 8px 24px;
        border-radius: 0;
        font-size: 0.85rem;
        font-weight: 400;
        text-decoration: none;
        box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-amazon-secondary:hover {
        background: linear-gradient(to bottom, #e7eaf0, #d8dade);
        border-color: #a2a6ac;
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
        border-radius: 2px;
        position: relative;
        transition: all 0.1s;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) inset;
    }

    .checkbox-container:hover input~.checkmark {
        border-color: #e77600;
    }

    .checkbox-container input:checked~.checkmark {
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

    .checkbox-container input:checked~.checkmark:after {
        display: block;
    }
</style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
<div style="max-width: 100%;">
    
    <div style="background: #fff; border: 1px solid #e7e7e7; border-top: none; padding: 25px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">Nouveau pack de crédits</h1>
            <a href="{{ route('admin.credits.packs') }}" class="btn-amazon-secondary" style="gap: 8px;">
                <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('admin.credits.packs.store') }}">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 400px; gap: 20px; align-items: stretch;">
                
                <!-- Section 1: Identité -->
                <div class="amazon-card">
                    <h3 class="section-title">Identité du Pack</h3>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                            Nom du pack <small style="color: red;">*</small>
                        </label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                            placeholder="Premium"
                            oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                        @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="description" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="12"
                            oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc; resize: vertical; font-family: inherit;"
                            placeholder="Détails sur ce pack...">{{ old('description') }}</textarea>
                        @error('description') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Section 2: Contenu & Tarification -->
                <div class="amazon-card" style="display: flex; flex-direction: column;">
                    <h3 class="section-title">Contenu & Tarification</h3>
                    
                    <div style="flex: 1;">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                            <div>
                                <label for="credits" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                                    Crédits inclus <small style="color: red;">*</small>
                                </label>
                                <input type="number" name="credits" id="credits" value="{{ old('credits') }}" min="1" required
                                    style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                                @error('credits') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="bonus_credits" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                                    Crédits bonus
                                </label>
                                <input type="number" name="bonus_credits" id="bonus_credits" value="{{ old('bonus_credits', 0) }}" min="0" required
                                    style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                                @error('bonus_credits') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label for="prix" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                                Prix en FCFA <small style="color: red;">*</small>
                            </label>
                            <input type="number" name="prix" id="prix" value="{{ old('prix') }}" min="0" required
                                style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                            @error('prix') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Footer Actions (Stacked vertically inside the card like filters) -->
                    <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                        
                        <!-- Status Section -->
                        <div style="margin-bottom: 20px;">
                            <label class="checkbox-container">
                                <input type="checkbox" name="actif" value="1" checked>
                                <span class="checkmark"></span>
                                <span style="font-weight: 700;">Activer ce pack</span>
                            </label>
                            <p style="font-size: 0.75rem; color: #555; margin-left: 24px; margin-top: 4px;">
                                Si décoché, ce pack ne sera pas visible par les utilisateurs.
                            </p>
                        </div>

                        <button type="submit" class="btn-amazon-primary" style="padding: 12px; font-weight: 700;">
                            ENREGISTRER
                        </button>
                        <a href="{{ route('admin.credits.packs') }}" class="btn-amazon-secondary" style="padding: 12px;">
                            ANNULER
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
