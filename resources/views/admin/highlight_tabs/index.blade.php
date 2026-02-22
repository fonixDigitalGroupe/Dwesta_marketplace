@extends('layouts.admin')

@section('title', 'Gestion des Onglets - Actualités')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.highlights.index') }}" style="color: #666; text-decoration: none;">Actualités</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Gestion des Onglets</span>
@endsection

@section('content')
<div style="max-width: 1200px;">
    <header style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600; margin-bottom: 0.25rem;">Onglets de la Grille</h1>
        </div>
        <a href="{{ route('admin.highlight-tabs.create') }}" 
           style="display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; background-color: #000; color: #fff; border-radius: 8px; transition: all 0.2s; text-decoration: none;" 
           title="Nouvel onglet">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </a>
    </header>

    <div style="background: #fff; border: 1px solid #e5e5e5; border-radius: 2px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5; background: #fafafa;">
            <span style="font-size: 0.8rem; color: #666;">{{ $tabs->count() }} onglet(s) configuré(s)</span>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left;">
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Nom</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5; width: 80px;">Ordre</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5; width: 120px;">Statut</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5; text-align: right; width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tabs as $tab)
                    <tr style="border-bottom: 1px solid #e5e5e5;">
                        <td style="padding: 0.875rem 1.25rem;">
                            <div style="font-size: 0.875rem; color: #333; font-weight: 500;">{{ $tab->name }}</div>
                        </td>

                        <td style="padding: 0.875rem 1.25rem;">
                            <span style="font-size: 0.875rem; color: #666;">{{ $tab->position }}</span>
                        </td>
                        <td style="padding: 0.875rem 1.25rem;">
                            <span style="font-size: 0.75rem; font-weight: 600; color: {{ $tab->active ? '#16a34a' : '#ca8a04' }};">
                                {{ $tab->active ? 'Actif' : 'Désactivé' }}
                            </span>
                        </td>
                        <td style="padding: 0.875rem 1.25rem; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 4px;">
                                <a href="{{ route('admin.highlight-tabs.edit', $tab) }}" 
                                   style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #004aad; background: #eef2ff; border-radius: 8px; transition: all 0.2s; text-decoration: none;" 
                                   title="Modifier"
                                   onmouseover="this.style.background='#e0e7ff'" onmouseout="this.style.background='#eef2ff'">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.highlight-tabs.destroy', $tab) }}" method="POST" onsubmit="return confirm('Supprimer cet onglet ? (Les actualités associées bloqueront la suppression)')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #ef4444; background: #fff1f2; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s;" 
                                            title="Supprimer"
                                            onmouseover="this.style.background='#ffe4e6'" onmouseout="this.style.background='#fff1f2'">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 3rem; text-align: center; color: #999; font-size: 0.875rem;">
                            Aucun onglet trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


@endsection
