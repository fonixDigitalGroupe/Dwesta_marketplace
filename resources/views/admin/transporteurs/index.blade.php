@extends('layouts.admin')

@section('title', 'Gestion des Transporteurs')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Transporteurs</span>
@endsection

@section('content')
    <div style="max-width: 1200px;">

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 0.85rem; color: #555; font-weight: 700; text-transform: uppercase; margin: 0; letter-spacing: 0.05em;">
                Gestion des Transporteurs
            </h2>
            <div style="display: flex; gap: 8px; align-items: center;">
                @if($pendingCount > 0)
                    <div style="background: #fff7ed; border: 1px solid #fdba74; padding: 6px 12px; border-radius: 6px; display: flex; align-items: center; gap: 8px;">
                        <span style="display: block; width: 6px; height: 6px; background: #e67e00; border-radius: 50%; box-shadow: 0 0 0 2px rgba(230, 126, 0, 0.2);"></span>
                        <span style="font-size: 0.75rem; font-weight: 600; color: #c2410c;">{{ $pendingCount }} en attente</span>
                    </div>
                @endif
                <a href="{{ route('admin.transporteurs.create') }}" style="display: flex; align-items: center; gap: 8px; background: #e67e00; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Nouveau Transporteur <i class="fas fa-plus-square"></i>
                </a>
                <a href="javascript:window.print()" style="display: flex; align-items: center; gap: 8px; background: #2563eb; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Imprimer <i class="fas fa-print"></i>
                </a>
            </div>
        </div>



        <!-- Table Container -->
        <div style="background: #fff; border: 1px solid #e5e5e5; padding: 1rem;">

            <!-- Barre d'outils secondaire -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 15px; font-size: 0.85rem; color: #333;">
                    <div>
                        Afficher 
                        <select onchange="window.location.href = '{{ request()->url() }}?per_page=' + this.value" 
                            style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; margin: 0 4px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                            <option value="8" {{ request('per_page', 8) == 8 ? 'selected' : '' }}>8</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        lignes
                    </div>
                </div>
                <div style="font-size: 0.8rem; color: #666;">
                    {{ $transporteurs->total() }} transporteur(s) au total
                </div>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #fff; border-bottom: 2px solid #eee;">
                        <th style="padding: 12px 1.25rem; font-size: 0.82rem; font-weight: 700; color: #333; border: 1px solid #eee;">Transporteur</th>
                        <th style="padding: 12px 1.25rem; font-size: 0.82rem; font-weight: 700; color: #333; border: 1px solid #eee;">Téléphone</th>
                        <th style="padding: 12px 1.25rem; font-size: 0.82rem; font-weight: 700; color: #333; border: 1px solid #eee;">Véhicule</th>
                        <th style="padding: 12px 1.25rem; font-size: 0.82rem; font-weight: 700; color: #333; border: 1px solid #eee;">Immatriculation</th>
                        <th style="padding: 12px 1.25rem; font-size: 0.82rem; font-weight: 700; color: #333; border: 1px solid #eee;">Permis</th>
                        <th style="padding: 12px 1.25rem; font-size: 0.82rem; font-weight: 700; color: #333; border: 1px solid #eee; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transporteurs as $transporteur)
                        <tr style="border-bottom: 1px solid #e5e5e5;">
                            <td style="padding: 0.875rem 1.25rem;">
                                <div style="display: flex; align-items: center; gap: 10px;">

                                    <div>
                                        <div style="font-size: 0.875rem; color: #333; font-weight: 500;">{{ $transporteur->user->prenom }} {{ $transporteur->user->nom }}</div>
                                        <div style="font-size: 0.75rem; color: #666;">{{ $transporteur->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 0.875rem 1.25rem;">
                                <div style="font-size: 0.85rem; color: #333; font-weight: 500;">{{ $transporteur->user->telephone ?? '-' }}</div>
                            </td>
                            <td style="padding: 0.875rem 1.25rem;">
                                <div style="font-size: 0.85rem; color: #333; font-weight: 500;">{{ $transporteur->type_vehicule }}</div>
                                <div style="font-size: 0.75rem; color: #999;">{{ $transporteur->marque_vehicule }}</div>
                            </td>
                            <td style="padding: 0.875rem 1.25rem;">
                                <code style="font-family: monospace; background: #f8fafc; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; color: #475569; border: 1px solid #e2e8f0;">
                                    {{ $transporteur->immatriculation ?? 'N/A' }}
                                </code>
                            </td>
                            <td style="padding: 0.875rem 1.25rem; border: 1px solid #eee;">
                                @if($transporteur->statut_verification === 'verifie')
                                    <span style="background: #f8fafc; color: #475569; padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: 400; border: 1px solid #e2e8f0;">
                                        {{ $transporteur->numero_permis ?? 'Vérifié' }}
                                    </span>
                                @elseif($transporteur->statut_verification === 'rejete')
                                    <span style="background: #fef2f2; color: #dc2626; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; border: 1px solid #fecaca;">Rejeté</span>
                                @else
                                    <span style="background: #fff7ed; color: #c2410c; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; border: 1px solid #fdba74;">En attente</span>
                                @endif
                            </td>
                            <td style="padding: 0.875rem 1.25rem; text-align: right; display: flex; justify-content: flex-end; gap: 4px;">


                                <a href="{{ route('admin.transporteurs.edit', $transporteur) }}" 
                                   style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #64748b; background: #f8fafc; border-radius: 8px; transition: all 0.2s;" 
                                   title="Modifier"
                                   onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a'" 
                                   onmouseout="this.style.background='#f8fafc'; this.style.color='#64748b'">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.transporteurs.destroy', $transporteur) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #ef4444; background: #fff1f2; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s;" 
                                            title="Supprimer"
                                            onmouseover="this.style.background='#ffe4e6'; this.style.transform='scale(1.05)'" 
                                            onmouseout="this.style.background='#fff1f2'; this.style.transform='scale(1)'"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce transporteur ?')">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 3rem 1.25rem; text-align: center; color: #999; font-size: 0.875rem;">
                                Aucun transporteur trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            @if($transporteurs->hasPages())
                <div style="padding: 1rem; border-top: 1px solid #e5e5e5;">
                    {{ $transporteurs->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
