@extends('layouts.admin')

@section('title', 'Modifier le service')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
    /* Input Amazon Style */
    input[type="text"]:focus, input[type="number"]:focus, textarea:focus, select:focus {
        border-color: #e77600 !important;
        box-shadow: 0 0 3px 2px rgba(228,121,17,0.5) !important;
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
        background: linear-gradient(to bottom, #f7dfa5, #f0c14b);
        border: 1px solid #a88734;
        color: #111;
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
        background: linear-gradient(to bottom, #f5d78e, #eeb933);
        border-color: #9c7e31;
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
</style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">Modifier le service : {{ $service->nom }}</h1>
        <a href="{{ route('admin.credits.services') }}" class="btn-amazon-secondary" style="gap: 8px;">
            <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i> Retour aux services
        </a>
    </div>

    <form method="POST" action="{{ route('admin.credits.services.update', $service) }}">
        @csrf @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: stretch;">

            <!-- Left Colonne -->
            <div style="display: flex; flex-direction: column; gap: 20px;">

                <!-- Section 1: Identité -->
                <div class="amazon-card" style="margin-bottom: 0;">
                    <h3 class="section-title">Identité du Service</h3>

                    <div style="display: grid; gap: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                                Type de service (Clé technique)
                            </label>
                            <select disabled
                                style="width: 100%; padding: 8px 12px; border: 1px solid #e7e7e7; border-radius: 0; font-size: 0.85rem; color: #555; background: #f9f9f9; outline: none; cursor: not-allowed; opacity: 1;">
                                <option value="video" {{ $service->cle == 'video' ? 'selected' : '' }}>Vidéo sur l'annonce</option>
                                <option value="mise_en_avant" {{ $service->cle == 'mise_en_avant' ? 'selected' : '' }}>Mise en avant</option>
                                <option value="boost" {{ $service->cle == 'boost' ? 'selected' : '' }}>Boost urgent</option>
                                <option value="republication" {{ $service->cle == 'republication' ? 'selected' : '' }}>Republication</option>
                                <option value="insertion" {{ $service->cle == 'insertion' ? 'selected' : '' }}>Frais d'insertion de base</option>
                            </select>
                        </div>

                        <div>
                            <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                                Nom affiché <small style="color: red;">*</small>
                            </label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $service->nom) }}" required
                                style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; color: #111; outline: none; background: #fcfcfc;">
                            @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; color: #111; outline: none; background: #fcfcfc; resize: vertical;">{{ old('description', $service->description) }}</textarea>
                            @error('description') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Valeur et Durée -->
                <div class="amazon-card" style="margin-bottom: 0;">
                    <h3 class="section-title">Configuration</h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label for="credits_requis" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                                Crédits requis <small style="color: red;">*</small>
                            </label>
                            <input type="number" name="credits_requis" id="credits_requis" value="{{ old('credits_requis', $service->credits_requis) }}" min="1" required
                                style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; color: #111; outline: none; background: #fcfcfc;">
                            @error('credits_requis') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="duree_jours" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                                Durée en jours <br><small style="color: #555; font-weight: normal;">(laisser vide si permanent)</small>
                            </label>
                            <input type="number" name="duree_jours" id="duree_jours" value="{{ old('duree_jours', $service->duree_jours) }}" min="1"
                                style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; color: #111; outline: none; background: #fcfcfc;">
                            @error('duree_jours') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Colonne -->
            <div style="display: flex; flex-direction: column;">

                <!-- Section Publish -->
                <div class="amazon-card">
                    <h3 class="section-title">Disponibilité</h3>

                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                            <input type="checkbox" name="actif" value="1" {{ old('actif', $service->actif) ? 'checked' : '' }}>
                            <span style="font-size: 0.85rem; color: #111; font-weight: 500;">Service actif et proposé</span>
                        </label>
                        
                        <hr style="border: 0; border-top: 1px solid #e7e7e7; margin: 5px 0;">

                        <div>
                            <label for="ordre" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Ordre d'affichage</label>
                            <input type="number" name="ordre" id="ordre" value="{{ old('ordre', $service->ordre) }}" min="0"
                                style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; color: #111; outline: none; background: #fcfcfc;">
                            @error('ordre') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                        
                        <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 10px;">
                            <button type="submit" class="btn-amazon-primary" style="padding: 10px; width: 100%;">
                                Enregistrer les modifications
                            </button>
                            <a href="{{ route('admin.credits.services') }}" class="btn-amazon-secondary" style="padding: 10px; width: 100%;">
                                Annuler
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection
