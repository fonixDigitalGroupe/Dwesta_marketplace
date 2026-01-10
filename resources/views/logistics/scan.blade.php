@extends('layouts.app')

@section('title', 'Scan Point Relais - Mady Market Logistics')

@push('styles')
<style>
    .scan-container { max-width: 600px; margin: 4rem auto; padding: 2rem; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1); text-align: center; }
    .scan-header { margin-bottom: 2rem; }
    .scan-icon { font-size: 3rem; color: #bf0000; margin-bottom: 1rem; }
    
    .input-group { margin-bottom: 2rem; }
    .scan-input { width: 100%; padding: 1.2rem; border: 2px solid #eee; border-radius: 8px; font-size: 1.2rem; text-align: center; letter-spacing: 1px; }
    .scan-input:focus { border-color: #bf0000; outline: none; background: #fffdfd; }
    
    .btn-scan { display: block; width: 100%; background: #bf0000; color: white; padding: 1.2rem; border-radius: 8px; font-weight: bold; font-size: 1.1rem; border: none; cursor: pointer; transition: transform 0.1s; }
    .btn-scan:active { transform: scale(0.98); }
    
    .alert { padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: left; }
    .alert-success { background: #e6fffa; color: #2c7a7b; border: 1px solid #b2f5ea; }
    .alert-error { background: #fff5f5; color: #c53030; border: 1px solid #fed7d7; }
    
    .helper-text { font-size: 0.9rem; color: #666; margin-top: 1.5rem; }
</style>
@endpush

@section('content')
<div class="scan-container">
    <div class="scan-header">
        <div class="scan-icon">📲</div>
        <h1 style="font-size: 1.5rem; font-weight: bold;">Interface Point Relais</h1>
        <p style="color: #666;">Scannez le QR Code ou saisissez le jeton de suivi</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    @if(session('info'))
        <div class="alert" style="background: #ebf8ff; color: #2b6cb0; border: 1px solid #bee3f8;">ℹ️ {{ session('info') }}</div>
    @endif

    <form action="{{ route('logistics.scan.process') }}" method="POST">
        @csrf
        <div class="input-group">
            <input type="text" name="token" class="scan-input" placeholder="Jetons : TRK-... ou QR-..." required autofocus>
        </div>
        
        <button type="submit" class="btn-scan">Valider l'opération</button>
    </form>

    <p class="helper-text">
        <strong>Aide :</strong><br>
        - Vendeur s'apprête à déposer -> Scan du QR/TRK -> Statut passe à "En point relais"<br>
        - Acheteur s'apprête à retirer -> Scan du QR/TRK -> Statut passe à "Réceptionné"
    </p>
</div>
@endsection
