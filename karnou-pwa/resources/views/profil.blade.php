@extends('partenaire::layouts.partenaire')

@section('title', 'Mon profil — Karnou Partenaire')

@php
    $kyc = $profil->statut_verification;
    $kycMap = [
        'verifie'    => ['Vérifié', '#22C55E', '✓'],
        'en_attente' => ['En attente de vérification', '#FF6B00', '⏳'],
        'rejete'     => ['Rejeté — action requise', '#EF4444', '!'],
    ];
    $kycInfo = $kycMap[$kyc] ?? ['Non soumis', '#94A3B8', '—'];
    $nom = trim(($user->prenom ?? '') . ' ' . ($user->nom ?? '')) ?: 'Mon profil';
    $initiale = mb_strtoupper(mb_substr($user->prenom ?: $user->nom ?: 'K', 0, 1));
@endphp

@push('styles')
<style>
    .pf-head { display: flex; align-items: center; justify-content: space-between; padding: calc(14px + var(--sat)) 20px 0; }
    .pf-body { flex: 1; overflow-y: auto; padding: 10px 20px calc(24px + var(--sab)); }
    .pf-hero { text-align: center; padding: 20px 0 26px; }
    .pf-avatar { position: relative; width: 96px; height: 96px; border-radius: 50%; background: linear-gradient(135deg,#004AAD,#0066ff); display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; font-size: 40px; font-weight: 900; color: #fff; }
    .pf-badge { position: absolute; bottom: -6px; left: 50%; transform: translateX(-50%); background: var(--karnou-orange); color: #fff; font-size: 10px; font-weight: 900; letter-spacing: 1px; padding: 3px 10px; border-radius: 999px; white-space: nowrap; }
    .pf-name { font-size: 22px; font-weight: 800; color: #fff; }
    .pf-phone { color: #94A3B8; font-size: 14px; margin-top: 2px; }
    .pf-row { display: flex; align-items: center; gap: 14px; padding: 16px; }
    .pf-row .ic { width: 40px; height: 40px; border-radius: 12px; background: rgba(0,74,173,.16); display: flex; align-items: center; justify-content: center; font-size: 18px; flex: none; }
    .pf-row .lbl { flex: 1; }
    .pf-row .lbl small { display: block; color: #64748B; font-size: 12px; }
    .pf-row .lbl b { color: #fff; font-size: 15px; font-weight: 600; text-transform: capitalize; }
    .pf-logout { width: 100%; margin-top: 24px; padding: 16px; border: 0; border-radius: 16px; background: rgba(239,68,68,.12); color: #fca5a5; font-size: 16px; font-weight: 700; cursor: pointer; font-family: inherit; }
</style>
@endpush

@section('content')
<div class="pt-screen">
    <div class="pf-head">
        <a href="{{ route('partenaire.home') }}" class="pt-back" aria-label="Fermer">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </a>
        <span style="color:#fff;font-weight:700">Mon profil</span>
        <div style="width:44px"></div>
    </div>

    <div class="pf-body">
        <div class="pf-hero">
            <div class="pf-avatar">
                {{ $initiale }}
                <span class="pf-badge">{{ mb_strtoupper($type) }}</span>
            </div>
            <div class="pf-name">{{ $nom }}</div>
            <div class="pf-phone">{{ $user->telephone ?? '—' }}</div>
        </div>

        <div class="pt-card">
            <div class="pf-row">
                <span class="ic">{{ $type === 'livreur' ? '🛵' : '🚚' }}</span>
                <span class="lbl"><small>Véhicule</small><b>{{ $profil->type_vehicule ?: '—' }}</b></span>
            </div>
            <div class="pt-divider"></div>
            <div class="pf-row">
                <span class="ic">🛡️</span>
                <span class="lbl"><small>Statut du dossier</small><b style="color:{{ $kycInfo[1] }}">{{ $kycInfo[0] }} {{ $kycInfo[2] }}</b></span>
            </div>
            <div class="pt-divider"></div>
            <div class="pf-row">
                <span class="ic">📅</span>
                <span class="lbl"><small>Membre depuis</small><b>{{ optional($user->created_at)->translatedFormat('F Y') ?: '—' }}</b></span>
            </div>
        </div>

        <div class="pt-section" style="margin-top:18px;">
            <a href="{{ route('partenaire.gains') }}" class="pt-card" style="display:flex;align-items:center;gap:14px;padding:16px;text-decoration:none;">
                <span class="ic" style="width:40px;height:40px;border-radius:12px;background:rgba(255,107,0,.16);display:flex;align-items:center;justify-content:center;font-size:18px;">💰</span>
                <span style="flex:1;color:#fff;font-weight:600;">Mes gains</span>
                <span style="color:#64748B">›</span>
            </a>
        </div>

        <form method="POST" action="{{ route('partenaire.logout') }}" onsubmit="return confirm('Voulez-vous vraiment vous déconnecter ?')">
            @csrf
            <button type="submit" class="pf-logout">Se déconnecter</button>
        </form>
    </div>
</div>
@endsection
