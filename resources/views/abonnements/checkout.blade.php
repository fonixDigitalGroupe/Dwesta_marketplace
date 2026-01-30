@extends('layouts.app')

@section('title', 'Confirmation Abonnement - Mady Market')

@push('styles')
<style>
    .checkout-container { max-width: 800px; margin: 3rem auto; padding: 0 1rem; }
    
    .checkout-card { 
        background: white; 
        border: 1px solid #e0e0e0; 
        border-radius: 12px; 
        padding: 2rem; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .checkout-header {
        text-align: center;
        margin-bottom: 2rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 1.5rem;
    }

    .plan-summary {
        background: #f9fafb;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid #eee;
    }

    .plan-name { font-size: 1.5rem; font-weight: 700; color: #333; margin-bottom: 0.5rem; }
    .plan-price { font-size: 2rem; font-weight: 800; color: #bf0000; }
    
    .payment-methods {
        display: grid;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .payment-option {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.2s;
    }

    .payment-option:hover { border-color: #bf0000; background: #fff5f5; }
    .payment-option.active { border-color: #bf0000; background: #fff0f0; }

    .btn-confirm {
        background: #bf0000;
        color: white;
        width: 100%;
        padding: 1rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1.1rem;
        border: none;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-confirm:hover { background: #990000; }
</style>
@endpush

@section('content')
<div class="checkout-container">
    <div class="checkout-card">
        <div class="checkout-header">
            <h1>Confirmation de l'abonnement</h1>
            <p style="color: #666;">Vous êtes sur le point de souscrire au forfait :</p>
        </div>

        <div class="plan-summary">
            <div class="plan-name">{{ $abonnement->nom }}</div>
            <div class="plan-price">{{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA <span style="font-size: 1rem; color: #666;">/ mois</span></div>
            <ul style="margin-top: 1rem; color: #555; list-style: none; padding: 0;">
                <li>✓ {{ $abonnement->nombre_annonces == 0 ? 'Annonces illimitées' : $abonnement->nombre_annonces . ' annonces/mois' }}</li>
                <li>✓ Commission réduite à {{ $abonnement->commission }}%</li>
            </ul>
        </div>

        <form action="{{ route('abonnements.subscribe') }}" method="POST">
            @csrf
            <input type="hidden" name="abonnement_id" value="{{ $abonnement->id }}">
            
            <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Moyen de paiement</h3>
            <div class="payment-methods">
                <label class="payment-option active">
                    <input type="radio" name="payment_method" value="om" checked onchange="document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active')); this.parentElement.classList.add('active');">
                    <span style="font-weight: 600;">Orange Money</span>
                </label>
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="momo" onchange="document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active')); this.parentElement.classList.add('active');">
                    <span style="font-weight: 600;">MTN Mobile Money</span>
                </label>
                <label class="payment-option">
                    <input type="radio" name="payment_method" value="cb" onchange="document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active')); this.parentElement.classList.add('active');">
                    <span style="font-weight: 600;">Carte Bancaire</span>
                </label>
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: flex; gap: 0.5rem; align-items: flex-start; cursor: pointer;">
                    <input type="checkbox" name="auto_renew" value="1" checked style="margin-top: 4px;">
                    <span style="font-size: 0.9rem; color: #555;">Activer le renouvellement automatique pour éviter toute interruption de service.</span>
                </label>
            </div>

            <button type="submit" class="btn-confirm">
                Confirmer et Payer {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA
            </button>
            <div style="text-align: center; margin-top: 1rem;">
                <a href="{{ route('abonnements.index') }}" style="color: #666; font-size: 0.9rem; text-decoration: none;">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection
