@extends('layouts.admin')

@section('title', 'Modifier le Livreur')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.livreurs.index') }}" style="color: #666; text-decoration: none;">Livreurs</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Modifier</span>
@endsection

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">

    <header style="margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">Modifier Livreur</h1>
        <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Mettre à jour les informations de {{ $livreur->user->prenom }} {{ $livreur->user->nom }}.</p>
    </header>

    <form action="{{ route('admin.livreurs.update', $livreur) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
            
            <!-- Colonne Gauche -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Section 1: Utilisateur (Lecture Seule) -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1rem;">Utilisateur</h2>
                    <div style="padding: 10px 14px; background: #f9fafb; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #666;">
                        {{ $livreur->user->prenom }} {{ $livreur->user->nom }} ({{ $livreur->user->email }})
                    </div>
                </div>

                <!-- Section 2: Informations Véhicule -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                    <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">Informations Véhicule</h2>
                    
                    <div style="display: grid; gap: 1.25rem;">
                        <div>
                            <label for="type_vehicule" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Type de véhicule <span style="color: red;">*</span></label>
                            <select name="type_vehicule" id="type_vehicule" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
                                <option value="Moto" {{ old('type_vehicule', $livreur->type_vehicule) == 'Moto' ? 'selected' : '' }}>Moto</option>
                                <option value="Voiture" {{ old('type_vehicule', $livreur->type_vehicule) == 'Voiture' ? 'selected' : '' }}>Voiture</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne Droite -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Section 3: Pièce d'identité -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.25rem;">
                    <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1rem;">Pièce d'identité</h3>
                    
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div>
                            <label for="type_document" style="display: block; font-size: 0.8rem; font-weight: 500; color: #666; margin-bottom: 6px;">Type de document <span style="color: red;">*</span></label>
                            <select name="type_document" id="type_document" required
                                    style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;">
                                <option value="CNI" {{ old('type_document', $livreur->type_document) == 'CNI' ? 'selected' : '' }}>CNI</option>
                                <option value="Passport" {{ old('type_document', $livreur->type_document) == 'Passport' ? 'selected' : '' }}>Passport</option>
                                <option value="Titre de séjour" {{ old('type_document', $livreur->type_document) == 'Titre de séjour' ? 'selected' : '' }}>Titre de séjour</option>
                            </select>
                        </div>
                        <div>
                            <label for="numero_document" style="display: block; font-size: 0.8rem; font-weight: 500; color: #666; margin-bottom: 6px;">N° du document</label>
                            <input type="text" name="numero_document" id="numero_document" value="{{ old('numero_document', $livreur->numero_document) }}"
                                   style="width: 100%; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;">
                        </div>
                        <div>
                            <label for="document_recto" style="display: block; font-size: 0.8rem; font-weight: 500; color: #666; margin-bottom: 6px;">Document (Recto)</label>
                            <input type="file" name="document_recto" id="document_recto" accept="image/*,application/pdf"
                                   style="width: 100%; padding: 6px 10px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.85rem; color: #333; outline: none;">
                        </div>
                        <div>
                            <label for="document_verso" style="display: block; font-size: 0.8rem; font-weight: 500; color: #666; margin-bottom: 6px;">Document (Verso)</label>
                            <input type="file" name="document_verso" id="document_verso" accept="image/*,application/pdf"
                                   style="width: 100%; padding: 6px 10px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.85rem; color: #333; outline: none;">
                        </div>
                    </div>
                </div>

                <!-- Section 4: État -->
                <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.25rem;">
                    <label for="actif" style="display: flex; align-items: center; gap: 12px; cursor: pointer; user-select: none;">
                        <input type="checkbox" name="actif" id="actif" value="1" {{ old('actif', $livreur->actif) ? 'checked' : '' }}>
                        <span style="font-size: 0.9rem; font-weight: 550; color: #333;">Livreur Actif</span>
                    </label>
                </div>

                <!-- Boutons d'action -->
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <button type="submit" style="background: #000; color: #fff; border: none; padding: 0.85rem; border-radius: 4px; font-weight: 600; cursor: pointer; font-size: 0.9rem;">
                        Mettre à jour
                    </button>
                    <a href="{{ route('admin.livreurs.index') }}" style="display: flex; justify-content: center; padding: 0.85rem; background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; color: #666; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
