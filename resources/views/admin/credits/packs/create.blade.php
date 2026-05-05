@extends('layouts.admin')

@section('title', 'Nouveau pack de crédits')

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
        <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">Nouveau pack de crédits</h1>
        <a href="{{ route('admin.credits.packs') }}" class="btn-amazon-secondary" style="gap: 8px;">
            <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i> Retour à la liste
        </a>
    </div>

    <form method="POST" action="{{ route('admin.credits.packs.store') }}">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: stretch;">
            
            <!-- Section 1: Identité -->
            <div class="amazon-card">
                <h3 class="section-title">Identité du Pack</h3>
                
                <div style="margin-bottom: 20px;">
                    <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                        Nom du pack <small style="color: red;">*</small>
                    </label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                        placeholder="Ex: Pack Bronze"
                        style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                    @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="description" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="5"
                        style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc; resize: vertical; font-family: inherit;"
                        placeholder="Détails sur ce pack...">{{ old('description') }}</textarea>
                    @error('description') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Section 2: Contenu & Tarification -->
            <div class="amazon-card">
                <h3 class="section-title">Contenu & Tarification</h3>
                
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
        </div>

        <!-- Footer Actions -->
        <div style="display: flex; justify-content: flex-end; gap: 15px; padding-top: 20px;">
            <a href="{{ route('admin.credits.packs') }}" class="btn-amazon-secondary">
                Annuler
            </a>
            <button type="submit" class="btn-amazon-primary">
                Créer le pack
            </button>
        </div>
    </form>
</div>
@endsection
