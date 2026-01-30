@extends('layouts.admin')

@section('title', 'Vérification des Vendeurs')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
    <a href="{{ route('admin.dashboard') }}">Administration</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
    <span style="color: var(--mady-red); font-weight: 700;">Vérifications</span>
@endsection

@section('content')
<div class="card-pro" style="overflow: hidden;">
    
    <!-- Header -->
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--slate-100); background: #fff;">
        <h1 style="font-size: 1.25rem; font-weight: 800; color: var(--slate-900); letter-spacing: -0.02em; margin-bottom: 0.25rem;">Vérification des Vendeurs</h1>
        <p style="font-size: 0.875rem; color: var(--slate-500); font-weight: 500;">Validez l'identité et les documents des marchands en attente d'approbation.</p>
    </div>

    <!-- Table content -->
    <div style="padding: 0;">
        @if($vendeursEnAttente->count() > 0)
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: var(--slate-50); border-bottom: 1px solid var(--slate-100);">
                        <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500);">Vendeur / Utilisateur</th>
                        <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500);">Type de Compte</th>
                        <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500);">Date de Demande</th>
                        <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendeursEnAttente as $vendeur)
                    <tr style="border-bottom: 1px solid var(--slate-100); transition: background 0.2s;" onmouseover="this.style.background='var(--slate-50)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 1.25rem 2rem;">
                            <div style="font-weight: 700; color: var(--slate-900); font-size: 0.9375rem;">{{ $vendeur->user->prenom ?? 'Utilisateur' }} {{ $vendeur->user->nom ?? 'Inconnu' }}</div>
                            <div style="font-size: 0.75rem; color: var(--slate-400); font-weight: 500;">{{ $vendeur->user->email ?? 'Email non disponible' }}</div>
                            @if($vendeur->estProfessionnel() && $vendeur->professionnel)
                                <div style="font-size: 0.75rem; color: var(--mady-red); font-weight: 700; margin-top: 4px;">🏢 {{ $vendeur->professionnel->nom_entreprise }}</div>
                            @endif
                        </td>
                        <td style="padding: 1.25rem 2rem;">
                            @if($vendeur->estParticulier())
                                <span style="display: inline-flex; align-items: center; padding: 4px 12px; background: #e0f2fe; color: #0369a1; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">Particulier</span>
                            @else
                                <span style="display: inline-flex; align-items: center; padding: 4px 12px; background: #fef3c7; color: #b45309; border-radius: 20px; font-size: 0.75rem; font-weight: 800;">Professionnel</span>
                            @endif
                        </td>
                        <td style="padding: 1.25rem 2rem; color: var(--slate-500); font-size: 0.8125rem; font-weight: 600;">
                            {{ $vendeur->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td style="padding: 1.25rem 2rem; text-align: right;">
                            <a href="{{ route('admin.vendeurs.verification.show', $vendeur) }}" class="btn-pro-primary" style="padding: 8px 16px; font-size: 0.75rem;">
                                Examiner le dossier
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="padding: 4rem; text-align: center; color: var(--slate-400); font-weight: 500;">
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 1rem; opacity: 0.3;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p style="font-size: 1rem; font-weight: 700; color: var(--slate-900);">Aucun vendeur en attente</p>
                <p style="font-size: 0.875rem;">Tous les dossiers ont été traités avec succès.</p>
            </div>
        @endif
    </div>

    @if($vendeursEnAttente->hasPages())
    <div style="padding: 1.5rem 2rem; border-top: 1px solid var(--slate-100); background: var(--slate-50);">
        {{ $vendeursEnAttente->links() }}
    </div>
    @endif
</div>
@endsection
