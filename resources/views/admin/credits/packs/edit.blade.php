@extends('layouts.admin')

@section('title', 'Modifier le pack')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
    /* Input Amazon Style Modernisé */
    input[type="text"], input[type="number"], textarea, select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        font-size: 0.82rem;
        outline: none;
        background: #fff;
        color: #475569;
        transition: all 0.2s;
    }

    input:focus, textarea:focus, select:focus {
        border-color: #ff9900 !important;
        box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15) !important;
    }

    .amazon-card {
        background: #fff;
        border: 1px solid #eff3f6;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 0.75rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 16px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f1f5f9;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .field-label {
        display: block;
        font-size: 0.72rem;
        font-weight: 600;
        color: #94a3b8;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    /* Buttons Alignés avec Index */
    .btn-amazon-primary {
        background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: #fff;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        cursor: pointer;
        width: 100%;
    }

    .btn-amazon-primary:hover {
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        color: #fff;
    }

    .btn-amazon-secondary {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 0.78rem;
        font-weight: 500;
        letter-spacing: 0.03em;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        cursor: pointer;
        width: 100%;
    }

    .btn-amazon-secondary:hover {
        background: #f8fafc;
        border-color: #dee2e6;
        color: #1e293b;
    }
</style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                    <i class="fas fa-edit" style="font-size: 0.8rem;"></i>
                    <span style="line-height:1;">Modifier le pack : {{ $pack->nom }}</span>
                </div>
            </div>
            <a href="{{ route('admin.credits.packs') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                <i class="fas fa-list" style="color: #ff9900;"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('admin.credits.packs.update', $pack) }}">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: stretch;">
                
                <!-- Section 1: Identité -->
                <div class="amazon-card" style="margin: 0;">
                    <h3 class="section-title">Identité du Pack</h3>
                    
                    <div style="margin-bottom: 20px;">
                        <label for="nom" class="field-label">
                            Nom du pack <small style="color: red;">*</small>
                        </label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $pack->nom) }}" required>
                        @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="description" class="field-label">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="5"
                            style="resize: vertical; font-family: inherit;">{{ old('description', $pack->description) }}</textarea>
                        @error('description') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Section 2: Contenu & Tarification -->
                <div class="amazon-card" style="margin: 0; display: flex; flex-direction: column;">
                    <h3 class="section-title">Contenu & Tarification</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
                        <div>
                            <label for="credits" class="field-label">
                                Crédits inclus <small style="color: red;">*</small>
                            </label>
                            <input type="number" name="credits" id="credits" value="{{ old('credits', $pack->credits) }}" min="1" required>
                            @error('credits') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="bonus_credits" class="field-label">
                                Crédits bonus
                            </label>
                            <input type="number" name="bonus_credits" id="bonus_credits" value="{{ old('bonus_credits', $pack->bonus_credits) }}" min="0" required>
                            @error('bonus_credits') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="prix" class="field-label">
                            Prix en FCFA <small style="color: red;">*</small>
                        </label>
                        <input type="number" name="prix" id="prix" value="{{ old('prix', $pack->prix) }}" min="0" required>
                        @error('prix') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div style="display: grid; grid-template-columns: 180px 150px; gap: 12px; justify-content: end; border-top: 1px solid #eff3f6; padding-top: 20px; margin-top: 20px;">
                <button type="submit" class="btn-amazon-primary">
                    METTRE À JOUR
                </button>
                <a href="{{ route('admin.credits.packs') }}" class="btn-amazon-secondary">
                    ANNULER
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
