@extends('layouts.admin')

@section('title', 'Gestion des Actualités')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Gestion des Actualités</span>
@endsection

@section('content')
<div style="max-width: 1200px;">
    <header style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600; margin-bottom: 0.25rem;">Les actualités Karnou</h1>
            <p style="font-size: 0.95rem; color: #666;">Vue d'ensemble de tous les éléments.</p>
        </div>
        <a href="{{ route('admin.highlights.create') }}" 
           style="display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; background-color: #000; color: #fff; border-radius: 8px; transition: all 0.2s; text-decoration: none;" 
           title="Ajouter un élément">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </a>
    </header>

    <div style="background: #fff; border: 1px solid #e5e5e5; border-radius: 2px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
        <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5; background: #fafafa;">
            <span style="font-size: 0.8rem; color: #666;">{{ $highlights->count() }} élément(s) configuré(s) au total</span>
        </div>
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left;">
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5; width: 80px;">Visuel</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Titre / Sous-titre</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Catégorie (Onglet)</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5; width: 100px;">Position</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5; width: 120px;">Statut</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5; text-align: right; width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($highlights as $highlight)
                    <tr style="border-bottom: 1px solid #e5e5e5;">
                        <td style="padding: 0.875rem 1.25rem;">
                            <img src="{{ $highlight->image_url }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #eee;">
                        </td>
                        <td style="padding: 0.875rem 1.25rem;">
                            <div style="font-size: 0.875rem; color: #333; font-weight: 600;">{{ $highlight->title }}</div>
                            <div style="font-size: 0.8rem; color: #666;">{{ $highlight->subtitle ?? '-' }}</div>
                        </td>
                        <td style="padding: 0.875rem 1.25rem;">
                            <span style="font-size: 0.75rem; color: #333; font-weight: 600; background: #f1f5f9; padding: 4px 10px; border-radius: 999px;">
                                {{ $highlight->highlightTab->name ?? 'N/A' }}
                            </span>
                        </td>
                        <td style="padding: 0.875rem 1.25rem;">
                            <span style="background: {{ match($highlight->position) { 1 => '#e0f2fe', 4 => '#fef3c7', default => '#f1f5f9' } }}; 
                                         color: {{ match($highlight->position) { 1 => '#0369a1', 4 => '#92400e', default => '#475569' } }}; 
                                         padding: 3px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                Pos {{ $highlight->position }}
                            </span>
                        </td>
                        <td style="padding: 0.875rem 1.25rem;">
                            <span style="font-size: 0.75rem; font-weight: 600; color: {{ $highlight->active ? '#16a34a' : '#ca8a04' }};">
                                {{ $highlight->active ? 'Actif' : 'Masqué' }}
                            </span>
                        </td>
                        <td style="padding: 0.875rem 1.25rem; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 4px;">
                                <a href="{{ route('admin.highlights.edit', $highlight) }}" 
                                   style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #004aad; background: #eef2ff; border-radius: 8px; transition: all 0.2s;" 
                                   title="Modifier"
                                   onmouseover="this.style.background='#e0e7ff'" onmouseout="this.style.background='#eef2ff'">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.highlights.destroy', $highlight) }}" method="POST" onsubmit="return confirm('Supprimer cet élément ?')" style="display: inline;">
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
                        <td colspan="6" style="padding: 3rem; text-align: center; color: #999; font-size: 0.875rem;">
                            Aucun élément trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function toggleHighlightStatus(id, btn) {
    fetch(`/admin/highlights/${id}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            const circle = btn.querySelector('span');
            const label = btn.nextElementSibling;
            
            if(data.active) {
                btn.style.background = '#10b981';
                circle.style.left = '16px';
                label.textContent = 'Actif';
                label.style.color = '#10b981';
            } else {
                btn.style.background = '#ccc';
                circle.style.left = '2px';
                label.textContent = 'Masqué';
                label.style.color = '#666';
            }
        }
    });
}
</script>
@endsection
