@extends('layouts.app')

@section('title', 'Livraison - Étape 1 - Mady Market')

@push('styles')
<style>
    .checkout-container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; display: grid; grid-template-columns: 1fr 380px; gap: 2rem; }
    
    .checkout-main { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 2rem; }
    .checkout-title { font-size: 1.5rem; font-weight: bold; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; }
    .step-number { background: #bf0000; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }

    .form-group { margin-bottom: 1.5rem; }
    .form-label { display: block; font-weight: bold; margin-bottom: 0.5rem; color: #333; }
    .form-control { width: 100%; padding: 0.8rem; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem; }
    
    .delivery-options { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 2rem; }
    .delivery-option { border: 2px solid #eee; border-radius: 8px; padding: 1.5rem; cursor: pointer; transition: all 0.2s; position: relative; }
    .delivery-option:hover { border-color: #fdd; }
    .delivery-option.active { border-color: #bf0000; background: #fdf2f2; }
    .delivery-option input { position: absolute; opacity: 0; }
    .delivery-name { font-weight: bold; display: block; margin-bottom: 0.25rem; }
    .delivery-desc { font-size: 0.85rem; color: #666; }

    .sidebar-summary { background: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem; position: sticky; top: 2rem; }
    .summary-item { display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.95rem; color: #666; }
    .summary-total { border-top: 1px solid #ddd; margin-top: 1rem; padding-top: 1rem; display: flex; justify-content: space-between; font-weight: bold; font-size: 1.25rem; color: #333; }
    
    .btn-next { display: block; width: 100%; background: #bf0000; color: white; text-align: center; padding: 1rem; border-radius: 6px; font-weight: bold; border: none; cursor: pointer; font-size: 1.1rem; margin-top: 2rem; }
    .btn-next:hover { opacity: 0.9; }
</style>
@endpush

@section('content')
<div class="checkout-container">
    <div class="checkout-main">
        <h1 class="checkout-title">
            <span class="step-number">1</span>
            Informations de livraison
        </h1>

        <form action="{{ route('checkout.postStep1') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label">Adresse complète de livraison</label>
                <textarea name="adresse_livraison" class="form-control" rows="4" placeholder="Numéro, rue, quartier, ville..." required>{{ old('adresse_livraison', $user->adresse) }}</textarea>
                @error('adresse_livraison') <span style="color: #bf0000; font-size: 0.85rem;">{{ $message }}</span> @enderror
            </div>

            <h3 style="margin-top: 2.5rem; font-size: 1.1rem;">Mode de livraison</h3>
            <div class="delivery-options">
                <label class="delivery-option active">
                    <input type="radio" name="mode_livraison" value="domicile" checked onchange="this.parentElement.parentElement.querySelectorAll('.delivery-option').forEach(el => el.classList.remove('active')); this.parentElement.classList.add('active');">
                    <span class="delivery-name">🚚 À domicile</span>
                    <span class="delivery-desc">Livraison sécurisée à votre porte.</span>
                </label>
                <label class="delivery-option">
                    <input type="radio" name="mode_livraison" value="point_relais" onchange="this.parentElement.parentElement.querySelectorAll('.delivery-option').forEach(el => el.classList.remove('active')); this.parentElement.classList.add('active');">
                    <span class="delivery-name">📦 Point Relais Mady</span>
                    <span class="delivery-desc">Retrait gratuit dans l'un de nos points partenaires.</span>
                </label>
            </div>

            <button type="submit" class="btn-next">Continuer vers le paiement</button>
        </form>
    </div>

    <aside>
        <div class="sidebar-summary">
            <h2 style="font-size: 1.1rem; font-weight: bold; margin-bottom: 1.5rem;">Résumé de la commande</h2>
            
            @foreach($cartGrouped as $vendeurId => $items)
                <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px dashed #ddd;">
                    <div style="font-size: 0.8rem; color: #999; margin-bottom: 0.5rem;">Expédié par : 
                        <strong>{{ $items->first()->annonce->vendeur->user->prenom }}</strong>
                    </div>
                    @foreach($items as $item)
                        <div class="summary-item">
                            <span>{{ $item->quantite }}x {{ Str::limit($item->annonce->titre, 25) }}</span>
                            <span>{{ number_format(($item->annonce->prix + ($item->variante ? $item->variante->prix_supplementaire : 0)) * $item->quantite, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="summary-item" style="margin-top: 1rem;">
                <span>Sous-total</span>
                <span>{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
            </div>
            
            <div class="summary-item">
                <span>Frais de livraison</span>
                <span style="color: #28a745;">Gratuit</span>
            </div>

            <div class="summary-total">
                <span>Total</span>
                <span>{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>
    </aside>
</div>
@endsection
