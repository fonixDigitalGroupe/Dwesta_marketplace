@extends('layouts.partenaire')

@section('title', 'Profil Livreur — Karnou Partenaire')

@section('content')
<div class="pt-screen" x-data="{ vehicule: '{{ old('type_vehicule', 'moto') }}', doc: '{{ old('type_document', 'cni') }}' }">
    <div class="pt-header">
        <a href="{{ route('partenaire.metier') }}" class="pt-back" aria-label="Retour">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <div class="pt-progress"><i style="width:100%"></i></div>
    </div>

    <form method="POST" action="{{ route('partenaire.inscription.livreur.store') }}" enctype="multipart/form-data" class="pt-screen" style="padding:0;">
        @csrf
        <div class="pt-body">
            <h1 class="pt-title">Finalisez votre profil</h1>
            <p class="pt-subtitle">Dernière étape avant vos premières livraisons sur Karnou.</p>

            @if ($errors->any())
                <div class="pt-alert" style="margin-top:18px;">{{ $errors->first() }}</div>
            @endif

            {{-- Identité --}}
            <div class="pt-section">
                <div class="pt-section-header">Identité</div>
                <div class="pt-card">
                    <div class="pt-field"><span class="ic">👤</span><input class="pt-input" name="prenom" placeholder="Prénom" value="{{ old('prenom', $user->prenom === 'Partenaire' ? '' : $user->prenom) }}" required></div>
                    <div class="pt-divider"></div>
                    <div class="pt-field"><span class="ic">👤</span><input class="pt-input" name="nom" placeholder="Nom" value="{{ old('nom', $user->nom === 'Karnou' ? '' : $user->nom) }}" required></div>
                    <div class="pt-divider"></div>
                    <div class="pt-field"><span class="ic">✉️</span><input class="pt-input" type="email" name="email" placeholder="Email (optionnel)" value="{{ old('email', $user->email) }}"></div>
                    <div class="pt-divider"></div>
                    <div class="pt-field"><span class="ic">🎂</span><input class="pt-input" type="date" name="date_de_naissance" value="{{ old('date_de_naissance') }}"></div>
                </div>
            </div>

            {{-- Véhicule --}}
            <div class="pt-section">
                <div class="pt-section-header">Véhicule</div>
                <input type="hidden" name="type_vehicule" :value="vehicule">
                <div class="pt-chips">
                    <button type="button" class="pt-chip" :class="{ 'is-active': vehicule === 'moto' }" @click="vehicule='moto'">🛵 Moto</button>
                    <button type="button" class="pt-chip" :class="{ 'is-active': vehicule === 'voiture' }" @click="vehicule='voiture'">🚗 Voiture</button>
                    <button type="button" class="pt-chip" :class="{ 'is-active': vehicule === 'velo' }" @click="vehicule='velo'">🚲 Vélo</button>
                </div>
            </div>

            {{-- Document d'identité --}}
            <div class="pt-section">
                <div class="pt-section-header">Pièce d'identité</div>
                <input type="hidden" name="type_document" :value="doc">
                <div class="pt-chips" style="margin-bottom:12px;">
                    <button type="button" class="pt-chip" :class="{ 'is-active': doc === 'cni' }" @click="doc='cni'">CNI</button>
                    <button type="button" class="pt-chip" :class="{ 'is-active': doc === 'passport' }" @click="doc='passport'">Passeport</button>
                    <button type="button" class="pt-chip" :class="{ 'is-active': doc === 'sejour' }" @click="doc='sejour'">Titre de séjour</button>
                </div>
                <div class="pt-card">
                    <div class="pt-field"><span class="ic">#️⃣</span><input class="pt-input" name="numero_document" placeholder="Numéro du document" value="{{ old('numero_document') }}"></div>
                </div>
                @include('partenaire.partials.upload', ['name' => 'document_recto', 'label' => 'Recto du document'])
                @include('partenaire.partials.upload', ['name' => 'document_verso', 'label' => 'Verso du document'])
            </div>
        </div>

        <div class="pt-footer">
            <button type="submit" class="pt-btn">Valider mon profil</button>
        </div>
    </form>
</div>
@endsection
