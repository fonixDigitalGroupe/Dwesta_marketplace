@extends('layouts.admin')

@section('title', isset($pack) ? 'Modifier un pack' : 'Créer un pack')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.credits.packs') }}" style="color:#333;text-decoration:none;">Packs Crédits</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">{{ isset($pack) ? 'Modifier' : 'Nouveau' }}</span>
@endsection

@section('content')
    <div style="max-width: 1000px;">

        <header style="margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.5rem; color: #333; font-weight: 600; margin-bottom: 0.25rem;">
                {{ isset($pack) ? 'Modifier le pack' : 'Nouveau pack de crédits' }}
            </h1>
            <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Configurez les paramètres du pack que les vendeurs pourront acheter.</p>
        </header>

        <form method="POST" action="{{ isset($pack) ? route('admin.credits.packs.update', $pack) : route('admin.credits.packs.store') }}">
            @csrf
            @if(isset($pack)) @method('PUT') @endif

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">

                <!-- Left Colonne -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Section 1: Identité -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Identité Commerciale
                        </h2>

                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Nom du pack <span style="color: red;">*</span>
                                </label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom', $pack->nom ?? '') }}" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">
                                @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Description (Optionnel)
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical;"
                                    onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">{{ old('description', $pack->description ?? '') }}</textarea>
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
                                <input type="number" name="credits" id="credits" value="{{ old('credits', $pack->credits ?? '') }}" min="1" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
                            </div>
                            <div>
                                <label for="bonus_credits" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Crédits bonus
                                </label>
                                <input type="number" name="bonus_credits" id="bonus_credits" value="{{ old('bonus_credits', $pack->bonus_credits ?? 0) }}" min="0" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
                            </div>
                        </div>
                        
                        <div>
                            <label for="prix" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                Prix en FCFA <span style="color: red;">*</span>
                            </label>
                            <input type="number" name="prix" id="prix" value="{{ old('prix', $pack->prix ?? '') }}" min="0" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
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
                                <input type="checkbox" name="actif" value="1" {{ old('actif', $pack->actif ?? true) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                                <span style="font-size: 0.95rem; color: #333;">Pack actif et visible</span>
                            </label>
                            
                            <hr style="border: 0; border-top: 1px solid #eee; margin: 0.5rem 0;">

                            <label for="ordre" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Ordre d'affichage</label>
                            <input type="number" name="ordre" id="ordre" value="{{ old('ordre', $pack->ordre ?? 0) }}" min="0"
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
                            
                            <div style="display: flex; gap: 10px; margin-top: 1rem;">
                                <a href="{{ route('admin.credits.packs') }}"
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
