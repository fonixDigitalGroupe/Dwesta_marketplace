@extends('partenaire::layouts.partenaire')

@section('title', 'Choix du métier — Karnou Partenaire')

@section('content')
<div class="pt-screen">
    <div class="pt-header">
        <a href="{{ route('partenaire.permissions') }}" class="pt-back" aria-label="Retour">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <div class="pt-progress"><i style="width:80%"></i></div>
    </div>

    <div class="pt-body">
        <h1 class="pt-title">Choisissez votre métier</h1>
        <p class="pt-subtitle">Karnou s'adapte à votre logistique. Sélectionnez le profil qui vous correspond.</p>

        <div class="pt-section">
            <a href="{{ route('partenaire.inscription.livreur') }}" class="pt-option">
                <span class="ic-box">🛵</span>
                <span style="flex:1">
                    <h3>Livreur</h3>
                    <p>Coursier urbain, moto ou voiture légère</p>
                </span>
                <span style="color:#64748B">›</span>
            </a>

            <a href="{{ route('partenaire.inscription.transporteur') }}" class="pt-option">
                <span class="ic-box">🚚</span>
                <span style="flex:1">
                    <h3>Transporteur</h3>
                    <p>Fret lourd, camion, van et inter-urbain</p>
                </span>
                <span style="color:#64748B">›</span>
            </a>
        </div>
    </div>

    <div class="pt-footer">
        <p class="pt-muted" style="text-align:center;letter-spacing:2px;font-size:11px;">KARNOU LOGISTICS PLATFORM</p>
    </div>
</div>
@endsection
