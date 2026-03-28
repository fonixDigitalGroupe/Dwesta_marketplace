@extends('layouts.admin')

@section('title', 'Modifier le service')

@push('styles')
<style>
    /* Remove increment/decrement arrows from number inputs */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.credits.services') }}" style="color:#333;text-decoration:none;">Services Annonces</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Modifier</span>
@endsection

@section('content')
    <div style="max-width: 1000px;">

        <header style="margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.5rem; color: #333; font-weight: 600; margin-bottom: 0.25rem;">
                Modifier le service — {{ $service->nom }}
            </h1>
            <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Ajustez la configuration, les tarifs et la durée de ce service.</p>
        </header>

        <form method="POST" action="{{ route('admin.credits.services.update', $service) }}">
            @csrf @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">

                <!-- Left Colonne -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Section 1: Identité -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Identité du Service
                        </h2>

                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Type de service (Clé technique)
                                </label>
                                <select disabled
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #666; background: #f9f9f9; outline: none; cursor: not-allowed; opacity: 1; -webkit-opacity: 1;">
                                    <option value="video" {{ $service->cle == 'video' ? 'selected' : '' }}>Vidéo sur l'annonce</option>
                                    <option value="mise_en_avant" {{ $service->cle == 'mise_en_avant' ? 'selected' : '' }}>Mise en avant</option>
                                    <option value="boost" {{ $service->cle == 'boost' ? 'selected' : '' }}>Boost urgent</option>
                                    <option value="republication" {{ $service->cle == 'republication' ? 'selected' : '' }}>Republication</option>
                                    <option value="insertion" {{ $service->cle == 'insertion' ? 'selected' : '' }}>Frais d'insertion de base</option>
                                </select>
                            </div>

                            <div>
                                <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Nom affiché <span style="color: red;">*</span>
                                </label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom', $service->nom) }}" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">
                                @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Description
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical;"
                                    onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">{{ old('description', $service->description) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Valeur et Durée -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Configuration
                        </h2>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; align-items: flex-end;">
                            <div>
                                <label for="credits_requis" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Crédits requis <span style="color: red;">*</span>
                                </label>
                                <input type="number" name="credits_requis" id="credits_requis" value="{{ old('credits_requis', $service->credits_requis) }}" min="1" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
                            </div>
                            <div>
                                <label for="duree_jours" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Durée en jours <br><small style="color: #999; font-weight: normal;">(laisser vide si permanent)</small>
                                </label>
                                <input type="number" name="duree_jours" id="duree_jours" value="{{ old('duree_jours', $service->duree_jours) }}" min="1"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Colonne -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Section Publish -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">
                            Disponibilité
                        </h2>

                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="actif" value="1" {{ old('actif', $service->actif) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                                <span style="font-size: 0.95rem; color: #333;">Service actif et proposé</span>
                            </label>
                            
                            <hr style="border: 0; border-top: 1px solid #eee; margin: 0.5rem 0;">

                            <label for="ordre" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Ordre d'affichage</label>
                            <input type="number" name="ordre" id="ordre" value="{{ old('ordre', $service->ordre) }}" min="0"
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
                            
                            <div style="display: flex; gap: 10px; margin-top: 1rem;">
                                <a href="{{ route('admin.credits.services') }}"
                                    style="flex: 1; text-align: center; background: #fff; border: 1px solid #e0e0e0; color: #333; padding: 10px; border-radius: 6px; font-size: 0.95rem; font-weight: 500; cursor: pointer; text-decoration: none;">
                                    Annuler
                                </a>
                                <button type="submit"
                                    style="flex: 1; background: #000; color: #fff; border: none; padding: 10px; border-radius: 6px; font-size: 0.95rem; font-weight: 500; cursor: pointer; transition: opacity 0.2s;"
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
