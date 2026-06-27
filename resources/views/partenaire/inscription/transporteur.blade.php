@extends('layouts.partenaire')

@section('title', 'Profil Transporteur — Karnou Partenaire')

@section('content')
<div class="pt-screen" x-data="{ vehicule: '{{ old('type_vehicule', 'camion') }}' }">
    <div class="pt-header">
        <a href="{{ route('partenaire.metier') }}" class="pt-back" aria-label="Retour">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <div class="pt-progress"><i style="width:100%"></i></div>
    </div>

    <form method="POST" action="{{ route('partenaire.inscription.transporteur.store') }}" enctype="multipart/form-data" class="pt-screen" style="padding:0;">
        @csrf
        <div class="pt-body">
            <h1 class="pt-title">Devenez Transporteur</h1>
            <p class="pt-subtitle">Rejoignez le réseau logistique Karnou et gérez vos trajets de fret.</p>

            @if ($errors->any())
                <div class="pt-alert" style="margin-top:18px;">{{ $errors->first() }}</div>
            @endif

            {{-- Responsable --}}
            <div class="pt-section">
                <div class="pt-section-header">Responsable</div>
                <div class="pt-card">
                    <div class="pt-field"><span class="ic">👤</span><input class="pt-input" name="prenom" placeholder="Prénom" value="{{ old('prenom', $user->prenom === 'Partenaire' ? '' : $user->prenom) }}" required></div>
                    <div class="pt-divider"></div>
                    <div class="pt-field"><span class="ic">👤</span><input class="pt-input" name="nom" placeholder="Nom" value="{{ old('nom', $user->nom === 'Karnou' ? '' : $user->nom) }}" required></div>
                    <div class="pt-divider"></div>
                    <div class="pt-field"><span class="ic">✉️</span><input class="pt-input" type="email" name="email" placeholder="Email pro (optionnel)" value="{{ old('email', $user->email) }}"></div>
                </div>
            </div>

            {{-- Véhicule --}}
            <div class="pt-section">
                <div class="pt-section-header">Type de véhicule</div>
                <input type="hidden" name="type_vehicule" :value="vehicule">
                <div class="pt-chips">
                    <button type="button" class="pt-chip" :class="{ 'is-active': vehicule === 'camion' }" @click="vehicule='camion'">🚚 Camion</button>
                    <button type="button" class="pt-chip" :class="{ 'is-active': vehicule === 'van' }" @click="vehicule='van'">🚐 Van</button>
                    <button type="button" class="pt-chip" :class="{ 'is-active': vehicule === 'voiture' }" @click="vehicule='voiture'">🚗 Voiture</button>
                    <button type="button" class="pt-chip" :class="{ 'is-active': vehicule === 'moto' }" @click="vehicule='moto'">🛵 Moto</button>
                </div>
                <div class="pt-card" style="margin-top:12px;">
                    <div class="pt-field"><span class="ic">🏷️</span><input class="pt-input" name="marque_vehicule" placeholder="Marque (optionnel)" value="{{ old('marque_vehicule') }}"></div>
                    <div class="pt-divider"></div>
                    <div class="pt-field"><span class="ic">🚙</span><input class="pt-input" name="modele_vehicule" placeholder="Modèle (optionnel)" value="{{ old('modele_vehicule') }}"></div>
                    <div class="pt-divider"></div>
                    <div class="pt-field"><span class="ic">🔢</span><input class="pt-input" name="immatriculation" placeholder="Immatriculation" value="{{ old('immatriculation') }}"></div>
                </div>
            </div>

            {{-- KYC --}}
            <div class="pt-section">
                <div class="pt-section-header">Documents</div>
                <div class="pt-card">
                    <div class="pt-field"><span class="ic">🪪</span><input class="pt-input" name="numero_permis" placeholder="N° de permis" value="{{ old('numero_permis') }}"></div>
                    <div class="pt-divider"></div>
                    <div class="pt-field"><span class="ic">#️⃣</span><input class="pt-input" name="numero_cni" placeholder="N° CNI" value="{{ old('numero_cni') }}"></div>
                </div>
                @include('partenaire.partials.upload', ['name' => 'permis_recto', 'label' => 'Photo du permis'])
                @include('partenaire.partials.upload', ['name' => 'carte_grise', 'label' => 'Carte grise'])
            </div>
        </div>

        <div class="pt-footer">
            <button type="submit" class="pt-btn">Valider mon profil</button>
        </div>
    </form>
</div>
@endsection
