@extends('layouts.admin')

@section('title', 'Modifier le pack : ' . $abonnement->nom)

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.abonnements.index') }}" style="color:#333;text-decoration:none;">Packs d'abonnement</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Modifier</span>
@endsection

@section('content')
    <div style="max-width: 1000px;">

        <header style="margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.5rem; color: #333; font-weight: 600; margin-bottom: 0.25rem;">
                Modifier le pack d'abonnement
            </h1>
            <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Mettez à jour les paramètres du pack <strong>{{ $abonnement->nom }}</strong>.</p>
        </header>

        <form method="POST" action="{{ route('admin.abonnements.update', $abonnement) }}">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">

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
                                <select name="type" id="type" required 
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background-color: white;">
                                    <option value="gratuit" {{ old('type', $abonnement->type) == 'gratuit' ? 'selected' : '' }}>Gratuit</option>
                                    <option value="basic" {{ old('type', $abonnement->type) == 'basic' ? 'selected' : '' }}>Basic</option>
                                    <option value="expert" {{ old('type', $abonnement->type) == 'expert' ? 'selected' : '' }}>Expert</option>
                                </select>
                                @error('type') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Description
                                </label>
                                <textarea name="description" id="description" rows="3" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical;"
                                    onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">{{ old('description', $abonnement->description) }}</textarea>
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
                                    Prix mensuel (FCFA) <span style="color: red;">*</span>
                                </label>
                                <input type="number" name="prix_mensuel" id="prix_mensuel" value="{{ old('prix_mensuel', $abonnement->prix_mensuel) }}" min="0" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
                                @error('prix_mensuel') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="commission" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                    Commission (%) <span style="color: red;">*</span>
                                </label>
                                <input type="number" name="commission" id="commission" value="{{ old('commission', $abonnement->commission) }}" min="0" max="100" step="0.01" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
                                @error('commission') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="nombre_annonces" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">
                                Nombre d'annonces autorisées <span style="color: red;">*</span>
                            </label>
                            <input type="number" name="nombre_annonces" id="nombre_annonces" value="{{ old('nombre_annonces', $abonnement->nombre_annonces) }}" min="0" required
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
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

                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="actif" value="1" {{ old('actif', $abonnement->actif) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                                <span style="font-size: 0.95rem; color: #333;">Pack actif et visible</span>
                            </label>

                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="page_pro" value="1" {{ old('page_pro', $abonnement->page_pro) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                                <span style="font-size: 0.95rem; color: #333;">Accès Boutique Page Pro</span>
                            </label>
                            
                            <hr style="border: 0; border-top: 1px solid #eee; margin: 0.5rem 0;">
                            
                            <div style="display: flex; gap: 10px; margin-top: 1rem;">
                                <a href="{{ route('admin.abonnements.index') }}"
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
