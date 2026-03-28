@extends('layouts.admin')

@section('title', 'Gestion des Packs de Crédits')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #666;">Paramètres</span>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Packs Crédits</span>
@endsection

@section('content')
    <div style="max-width: 900px;">

        <!-- Header avec bouton -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600;">
                Packs de Crédits
            </h1>
            <a href="{{ route('admin.credits.packs.create') }}"
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

        <!-- Table Container -->
        <div style="background: #fff; border: 1px solid #e5e5e5; border-radius: 8px; overflow: hidden;">

            <!-- Table Header -->
            <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5;">
                <span style="font-size: 0.8rem; color: #666;">{{ $packs->count() }} pack(s)</span>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    @forelse($packs as $pack)
                        <tr style="border-bottom: 1px solid #e5e5e5;">
                            <td style="padding: 0.875rem 0.5rem; padding-left: 1.25rem;">
                                <div style="font-size: 0.875rem; color: #333; font-weight: 500;">{{ $pack->nom }}</div>
                                <span style="font-size: 0.75rem; color: #666;">{{ $pack->credits }} crédits @if($pack->bonus_credits) + <span style="color:#ff6600;">{{ $pack->bonus_credits }} bonus</span> @endif</span>
                            </td>
                            <td style="padding: 0.875rem 0.5rem; text-align: center;">
                                <span style="font-size: 0.85rem; font-weight: 600;">{{ number_format($pack->prix, 0, ',', ' ') }} FCFA</span>
                            </td>
                            <td style="padding: 0.875rem 0.5rem; text-align: center;">
                                <span style="background:{{ $pack->actif ? '#d4edda' : '#f8d7da' }};color:#333;padding:0.2rem 0.6rem;border-radius:4px;font-size:0.7rem;">
                                    {{ $pack->actif ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td style="padding: 0.875rem 1.25rem; text-align: right; display: flex; justify-content: flex-end; gap: 4px;">
                                <a href="{{ route('admin.credits.packs.edit', $pack) }}" 
                                   style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #004aad; background: #eef2ff; border-radius: 8px; transition: all 0.2s;" 
                                   title="Modifier"
                                   onmouseover="this.style.background='#e0e7ff'; this.style.opacity='0.8'" 
                                   onmouseout="this.style.background='#eef2ff'; this.style.opacity='1'">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.credits.packs.destroy', $pack) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #ef4444; background: #fff1f2; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s;" 
                                            title="Supprimer"
                                            onmouseover="this.style.background='#ffe4e6'; this.style.transform='scale(1.05)'" 
                                            onmouseout="this.style.background='#fff1f2'; this.style.transform='scale(1)'">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                style="padding: 3rem 1.25rem; text-align: center; color: #999; font-size: 0.875rem;">
                                Aucun pack de crédits trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
