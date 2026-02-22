@extends('layouts.admin')

@section('title', 'Vérification des Vendeurs')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Vérifications Vendeurs</span>
@endsection

@section('content')
<div style="max-width: 1000px;">
    
    <!-- Header -->
    <div style="margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.375rem; color: #333; font-weight: 600; margin-bottom: 0.25rem;">Vérification des Vendeurs</h1>
        <p style="font-size: 0.85rem; color: #666;">Validez l'identité et les documents des marchands en attente d'approbation.</p>
    </div>

    <!-- Table Container -->
    <div style="background: #fff; border: 1px solid #e5e5e5; border-radius: 2px;">
        
        <!-- Table Header Info -->
        <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5; background: #fff;">
            <span style="font-size: 0.8rem; color: #666; font-weight: 600;">
                {{ $vendeursEnAttente->total() }} dossier(s) en attente
            </span>
        </div>

        <!-- Table -->
        <div style="overflow-x: auto;">
            @if($vendeursEnAttente->count() > 0)
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 1px solid #e5e5e5; background: #fff;">
                            <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #991b1b; letter-spacing: 0.025em;">Vendeur / Utilisateur</th>
                            <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #666; letter-spacing: 0.025em;">Type</th>
                            <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #666; letter-spacing: 0.025em;">Date</th>
                            <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #666; letter-spacing: 0.025em; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vendeursEnAttente as $vendeur)
                        <tr style="border-bottom: 1px solid #e5e5e5; transition: background 0.1s;" onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 1rem 1.25rem;">
                                <div style="font-weight: 600; color: #111; font-size: 0.875rem;">{{ $vendeur->user->prenom ?? 'Utilisateur' }} {{ $vendeur->user->nom ?? 'Inconnu' }}</div>
                                <div style="font-size: 0.75rem; color: #888;">{{ $vendeur->user->email ?? '-' }}</div>
                                @if($vendeur->estProfessionnel() && $vendeur->professionnel)
                                    <div style="font-size: 0.75rem; color: #991b1b; font-weight: 700; margin-top: 2px;">{{ $vendeur->professionnel->nom_entreprise }}</div>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.25rem;">
                                @if($vendeur->estParticulier())
                                    <span style="display: inline-block; padding: 2px 8px; background: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">Vendeur part</span>
                                @else
                                    <span style="display: inline-block; padding: 2px 8px; background: #fffbeb; color: #b45309; border: 1px solid #fef3c7; border-radius: 4px; font-size: 0.7rem; font-weight: 700;">Vendeur pro</span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.25rem; color: #666; font-size: 0.8rem;">
                                {{ $vendeur->created_at->format('d/m/Y') }}
                                <div style="font-size: 0.7rem; color: #999;">{{ $vendeur->created_at->format('H:i') }}</div>
                            </td>
                            <td style="padding: 1rem 1.25rem; text-align: right;">
                                <a href="{{ route('admin.vendeurs.verification.show', $vendeur) }}" 
                                   style="display: inline-block; color: #333; font-size: 0.75rem; text-decoration: none; padding: 5px 12px; border: 1px solid #333; border-radius: 4px; font-weight: 600; transition: all 0.2s;"
                                   onmouseover="this.style.background='#333'; this.style.color='#fff'"
                                   onmouseout="this.style.background='transparent'; this.style.color='#333'">
                                    Examiner
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div style="padding: 4rem 1.25rem; text-align: center; color: #999;">
                    <p style="font-size: 0.9rem; font-weight: 600; color: #333; margin-bottom: 0.25rem;">Aucun vendeur en attente</p>
                    <p style="font-size: 0.8rem;">Tous les dossiers ont été traités avec succès.</p>
                </div>
            @endif
        </div>

        @if($vendeursEnAttente->hasPages())
        <div style="padding: 1rem 1.25rem; border-top: 1px solid #e5e5e5; background: #fafafa;">
            {{ $vendeursEnAttente->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
