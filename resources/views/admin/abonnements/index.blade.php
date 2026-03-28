@extends('layouts.admin')

@section('title', 'Gestion des Packs d\'Abonnement')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #666;">Paramètres</span>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Packs d'Abonnement</span>
@endsection

@section('content')
    <div style="max-width: 1000px;">

        <!-- Header avec bouton -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600;">
                Packs d'Abonnement
            </h1>
            <a href="{{ route('admin.abonnements.create') }}"
                style="display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; background-color: #000; color: #fff; border-radius: 8px; transition: all 0.2s;" 
                title="Ajouter un pack"
                onmouseover="this.style.opacity='0.8'" 
                onmouseout="this.style.opacity='1'">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
            </a>
        </div>

        @if(session('success'))
            <div style="background:#d4edda;color:#155724;padding:0.75rem 1rem;border-radius:6px;margin-bottom:1rem;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background:#f8d7da;color:#721c24;padding:0.75rem 1rem;border-radius:6px;margin-bottom:1rem;">{{ session('error') }}</div>
        @endif

        <!-- Table Container -->
        <div style="background: #fff; border: 1px solid #e5e5e5; border-radius: 8px; overflow: hidden;">

            <!-- Table Header -->
            <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5; background: #fcfcfc;">
                <span style="font-size: 0.8rem; color: #666;">{{ $abonnements->count() }} pack(s) configuré(s)</span>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    @forelse($abonnements as $abonnement)
                        <tr style="border-bottom: 1px solid #e5e5e5; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='transparent'">
                            <!-- Info Column -->
                            <td style="padding: 0.875rem 0.5rem; padding-left: 1.25rem;">
                                <div style="font-size: 0.875rem; color: #333; font-weight: 600;">{{ $abonnement->nom }}</div>
                                <div style="font-size: 0.75rem; color: #666;">{{ Str::limit($abonnement->description, 60) }}</div>
                            </td>

                            <!-- Details Column -->
                            <td style="padding: 0.875rem 0.5rem;">
                                <div style="font-size: 0.8rem; color: #333;">Com : <strong>{{ $abonnement->commission }}%</strong></div>
                                <div style="font-size: 0.75rem; color: #666;">{{ $abonnement->nombre_annonces > 0 ? $abonnement->nombre_annonces . ' annonces' : 'Annonces illimitées' }}</div>
                            </td>

                            <!-- Price Column -->
                            <td style="padding: 0.875rem 0.5rem; text-align: center;">
                                <span style="font-size: 0.875rem; font-weight: 700; color: #111827;">{{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} FCFA</span>
                                <div style="font-size: 0.7rem; color: #9ca3af;">/ mois</div>
                            </td>

                            <!-- Status Column -->
                            <td style="padding: 0.875rem 0.5rem; text-align: center;">
                                <span style="display: inline-block; background:{{ $abonnement->actif ? '#dcfce7' : '#fee2e2' }}; color:{{ $abonnement->actif ? '#166534' : '#991b1b' }}; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.025em;">
                                    {{ $abonnement->actif ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>

                            <!-- Actions Column -->
                            <td style="padding: 0.875rem 1.25rem; text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 6px;">
                                    <a href="{{ route('admin.abonnements.edit', $abonnement) }}" 
                                       style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #004aad; background: #eef2ff; border-radius: 8px; transition: all 0.2s;" 
                                       title="Modifier"
                                       onmouseover="this.style.background='#e0e7ff'" 
                                       onmouseout="this.style.background='#eef2ff'">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.abonnements.destroy', $abonnement) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce pack ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #ef4444; background: #fff1f2; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s;" 
                                                title="Supprimer"
                                                onmouseover="this.style.background='#ffe4e6'" 
                                                onmouseout="this.style.background='#fff1f2'">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 3rem 1.25rem; text-align: center; color: #9ca3af; font-size: 0.875rem;">
                                Aucun pack d'abonnement configuré.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
