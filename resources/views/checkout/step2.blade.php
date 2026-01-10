@extends('layouts.app')

@section('title', 'Paiement - Étape 2 - Mady Market')

@push('styles')
<style>
    .checkout-container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; display: grid; grid-template-columns: 1fr 380px; gap: 2rem; }
    
    .checkout-main { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 2rem; }
    .checkout-title { font-size: 1.5rem; font-weight: bold; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; }
    .step-number { background: #bf0000; color: white; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }

    .payment-methods { display: flex; flex-direction: column; gap: 1rem; }
    .payment-method { border: 2px solid #eee; border-radius: 8px; padding: 1.5rem; cursor: pointer; transition: all 0.2s; position: relative; display: flex; align-items: center; gap: 1.5rem; }
    .payment-method:hover { border-color: #fdd; }
    .payment-method.active { border-color: #bf0000; background: #fdf2f2; }
    .payment-method input { position: absolute; opacity: 0; }
    
    .method-icon { width: 60px; height: 40px; background: #f5f5f5; border-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.75rem; color: #999; }
    .method-info { flex: 1; }
    .method-name { font-weight: bold; display: block; margin-bottom: 0.25rem; }
    .method-desc { font-size: 0.85rem; color: #666; }

    .sidebar-summary { background: #f9f9f9; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem; position: sticky; top: 2rem; }
    .summary-item { display: flex; justify-content: space-between; margin-bottom: 0.75rem; font-size: 0.95rem; color: #666; }
    .summary-total { border-top: 1px solid #ddd; margin-top: 1rem; padding-top: 1rem; display: flex; justify-content: space-between; font-weight: bold; font-size: 1.25rem; color: #333; }
    
    .btn-pay { display: block; width: 100%; background: #bf0000; color: white; text-align: center; padding: 1.2rem; border-radius: 6px; font-weight: bold; border: none; cursor: pointer; font-size: 1.1rem; margin-top: 2rem; }
    .btn-pay:hover { opacity: 0.9; }
    .btn-back { display: block; text-align: center; margin-top: 1rem; color: #666; font-size: 0.9rem; text-decoration: none; }
</style>
@endpush

@section('content')
<div class="checkout-container">
    <div class="checkout-main">
        <h1 class="checkout-title">
            <span class="step-number">2</span>
            Méthode de paiement
        </h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            <div class="payment-methods">
                <label class="payment-method active">
                    <input type="radio" name="moyen_paiement" value="om" checked onchange="this.parentElement.parentElement.querySelectorAll('.payment-method').forEach(el => el.classList.remove('active')); this.parentElement.classList.add('active');">
                    <div class="method-icon" style="background: #ffcc00; color: white;">OM</div>
                    <div class="method-info">
                        <span class="method-name">Orange Money RCA</span>
                        <span class="method-desc">Paiement instantané via votre compte Orange Money.</span>
                    </div>
                </label>

                <label class="payment-method">
                    <input type="radio" name="moyen_paiement" value="momo" onchange="this.parentElement.parentElement.querySelectorAll('.payment-method').forEach(el => el.classList.remove('active')); this.parentElement.classList.add('active');">
                    <div class="method-icon" style="background: #ffec00; color: #004f71;">MoMo</div>
                    <div class="method-info">
                        <span class="method-name">MTN Mobile Money</span>
                        <span class="method-desc">Simple, rapide et sécurisé.</span>
                    </div>
                </label>

                <label class="payment-method">
                    <input type="radio" name="moyen_paiement" value="cb" onchange="this.parentElement.parentElement.querySelectorAll('.payment-method').forEach(el => el.classList.remove('active')); this.parentElement.classList.add('active');">
                    <div class="method-icon">💳</div>
                    <div class="method-info">
                        <span class="method-name">Carte Bancaire</span>
                        <span class="method-desc">Visa, Mastercard (simulé).</span>
                    </div>
                </label>

                <label class="payment-method">
                    <input type="radio" name="moyen_paiement" value="paypal" onchange="this.parentElement.parentElement.querySelectorAll('.payment-method').forEach(el => el.classList.remove('active')); this.parentElement.classList.add('active');">
                    <div class="method-icon" style="background: #003087; color: white;">PP</div>
                    <div class="method-info">
                        <span class="method-name">PayPal</span>
                        <span class="method-desc">Paiement sécurisé via votre compte PayPal.</span>
                    </div>
                </label>
            </div>

            <button type="submit" class="btn-pay">Confirmer et Payer</button>
            <a href="{{ route('checkout.step1') }}" class="btn-back">← Revenir aux informations de livraison</a>
        </form>
    </div>

    <aside>
        <div class="sidebar-summary">
            <h2 style="font-size: 1.1rem; font-weight: bold; margin-bottom: 1.5rem;">Résumé de la commande</h2>
            
            <div class="summary-item">
                <span>Total articles</span>
                <span>{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
            </div>
            
            <div class="summary-item">
                <span>Livraison ({{ session('checkout_mode') == 'point_relais' ? 'Point Relais' : 'Domicile' }})</span>
                <span style="color: #28a745;">Gratuit</span>
            </div>

            <div class="summary-total">
                <span>Total à payer</span>
                <span>{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
            </div>

            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed #ddd; font-size: 0.85rem; color: #666;">
                <strong>Adresse de livraison :</strong><br>
                {{ session('checkout_adresse') }}
            </div>
        </div>
    </aside>
</div>
@endsection
