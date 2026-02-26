@extends('layouts.admin')

@section('title', 'Gestion des Dépôts Relais')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Dépôts Relais</span>
@endsection

@section('content')
    <div style="max-width: 1200px;">

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600;">
                Dépôts Relais
            </h1>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.point-relais.create') }}" 
                   style="display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; background-color: #000; color: #fff; border-radius: 8px; transition: all 0.2s;" 
                   title="Nouveau Dépôt Relais"
                   onmouseover="this.style.opacity='0.8'" 
                   onmouseout="this.style.opacity='1'">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </a>
                <a href="#" 
                   style="display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; background-color: #e11d48; color: #fff; border-radius: 8px; transition: all 0.2s;" 
                   title="Télécharger PDF"
                   onmouseover="this.style.opacity='0.8'" 
                   onmouseout="this.style.opacity='1'">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </a>
            </div>
        </div>



        <!-- Table Container -->
        <div style="background: #fff; border: 1px solid #e5e5e5;">

            <!-- Table Header -->
            <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5;">
                <span style="font-size: 0.8rem; color: #666;">{{ $points->total() }} dépôt(s) relais</span>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left;">
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Dépôt Relais</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Localisation</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Responsable</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Statut</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($points as $point)
                        <tr style="border-bottom: 1px solid #e5e5e5;">
                            <td style="padding: 0.875rem 1.25rem;">
                                <div style="display: flex; align-items: center; gap: 10px;">

                                    <div>
                                        <div style="font-size: 0.875rem; color: #333; font-weight: 500;">{{ $point->nom }}</div>
                                        <div style="font-size: 0.75rem; color: #999;">Créé le {{ $point->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 0.875rem 1.25rem;">
                                <div style="font-size: 0.85rem; color: #333; font-weight: 500;">{{ $point->region }}, {{ $point->pays }}</div>
                                <div style="font-size: 0.75rem; color: #666; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $point->adresse }}">
                                    {{ $point->adresse }}
                                </div>
                            </td>
                            <td style="padding: 0.875rem 1.25rem;">
                                @forelse($point->users as $manager)
                                    <div style="font-size: 0.85rem; color: #666;">{{ $manager->prenom }} {{ $manager->nom }}</div>
                                @empty
                                    <span style="font-size: 0.8rem; color: #999; font-style: italic;">Aucun</span>
                                @endforelse
                            </td>
                            <td style="padding: 0.875rem 1.25rem;">
                                @if($point->is_active)
                                    <span style="color: #16a34a; font-size: 0.75rem; font-weight: 600;">
                                        Actif
                                    </span>
                                @else
                                    <span style="color: #dc2626; font-size: 0.75rem; font-weight: 600;">
                                        Inactif
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 0.875rem 1.25rem; text-align: right; display: flex; justify-content: flex-end; gap: 4px;">
                                <a href="{{ route('admin.point-relais.edit', $point) }}" 
                                   style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #64748b; background: #f8fafc; border-radius: 8px; transition: all 0.2s;" 
                                   title="Modifier"
                                   onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a'" 
                                   onmouseout="this.style.background='#f8fafc'; this.style.color='#64748b'">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.point-relais.destroy', $point) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #ef4444; background: #fff1f2; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s;" 
                                            title="Supprimer"
                                            onmouseover="this.style.background='#ffe4e6'; this.style.transform='scale(1.05)'" 
                                            onmouseout="this.style.background='#fff1f2'; this.style.transform='scale(1)'"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce dépôt relais ?')">
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
                                Aucun dépôt relais trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            @if($points->hasPages())
                <div style="padding: 1rem; border-top: 1px solid #e5e5e5;">
                    {{ $points->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
