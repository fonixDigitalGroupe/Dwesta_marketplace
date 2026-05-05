@extends('layouts.admin')

@section('title', 'Modifier le Code Promo')

@push('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    .form-control {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.95rem;
        color: #111827;
        background-color: #fff;
        transition: all 0.2s;
    }
    .form-control:focus {
        outline: none;
        border-color: #004aad;
        box-shadow: 0 0 0 3px rgba(0, 74, 173, 0.1);
    }
    .form-text {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
</style>
@endpush

@section('breadcrumbs')
    <a href="{{ route('admin.coupons.index') }}">Codes Promo</a> <span style="margin: 0 0.5rem; opacity: 0.4;">/</span>
    <span style="color: #111827; font-weight: 600;">Modifier</span>
@endsection

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin: 0 0 0.5rem 0;">Modifier le Code Promo</h1>
            <p style="color: #6b7280; margin: 0; font-size: 0.95rem;">Mettez à jour les informations du coupon <strong style="color: #004aad;">{{ $coupon->code }}</strong>.</p>
        </div>
        <a href="{{ route('admin.coupons.index') }}" style="background-color: #fff; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; font-size: 0.9rem;">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" style="background: white; border: 1px solid #e5e7eb; border-radius: 12px; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label" for="code">Code Promotionnel <span style="color: #ef4444;">*</span></label>
                <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $coupon->code) }}" required style="text-transform: uppercase;">
            </div>

            <div class="form-group">
                <label class="form-label" for="is_active">Statut d'activation</label>
                <div style="padding-top: 0.5rem;">
                    <label style="display: inline-flex; align-items: center; cursor: pointer; gap: 8px; font-weight: 500; color: #374151;">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #004aad;">
                        Mettre en ligne (actif)
                    </label>
                </div>
            </div>
        </div>

        <div style="border-top: 1px solid #e5e7eb; margin: 1.5rem 0;"></div>
        <h3 style="font-size: 1.1rem; color: #111827; font-weight: 600; margin-bottom: 1.5rem;">Règles de Réduction</h3>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label" for="type">Type de réduction <span style="color: #ef4444;">*</span></label>
                <select name="type" id="type" class="form-control" required>
                    <option value="percent" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>Pourcentage (%)</option>
                    <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Montant Fixe (FCFA)</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label" for="value">Valeur <span style="color: #ef4444;">*</span></label>
                <input type="number" step="0.01" min="0" name="value" id="value" class="form-control" value="{{ old('value', str_replace('.00', '', $coupon->value)) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="min_purchase">Montant Minimum d'Achat (FCFA)</label>
            <input type="number" step="0.01" min="0" name="min_purchase" id="min_purchase" class="form-control" value="{{ old('min_purchase', $coupon->min_purchase ? str_replace('.00', '', $coupon->min_purchase) : '') }}">
        </div>

        <div class="form-group">
            <label class="form-label" for="category_id">Restreindre à une catégorie</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">-- Applicable sur tout le site --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $coupon->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->chemin ?? $category->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="border-top: 1px solid #e5e7eb; margin: 1.5rem 0;"></div>
        <h3 style="font-size: 1.1rem; color: #111827; font-weight: 600; margin-bottom: 1.5rem;">Validité et Limites</h3>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label" for="start_date">Date de début</label>
                <input type="datetime-local" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $coupon->start_date ? $coupon->start_date->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="end_date">Date de fin</label>
                <input type="datetime-local" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $coupon->end_date ? $coupon->end_date->format('Y-m-d\TH:i') : '') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="usage_limit">Limite totale d'utilisation</label>
            <input type="number" min="1" name="usage_limit" id="usage_limit" class="form-control" value="{{ old('usage_limit', $coupon->usage_limit) }}">
            <div class="form-text">Ce code a déjà été utilisé <strong>{{ $coupon->used_count }}</strong> fois.</div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
            <a href="{{ route('admin.coupons.index') }}" style="background-color: #fff; border: 1px solid #d1d5db; color: #374151; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='#fff'">
                Annuler
            </a>
            <button type="submit" style="background-color: #004aad; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background-color 0.2s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);" onmouseover="this.style.backgroundColor='#003580'" onmouseout="this.style.backgroundColor='#004aad'">
                <i class="fas fa-save" style="margin-right: 8px;"></i> Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection
