@extends('layouts.admin')

@section('title', 'Bannières Publicitaires')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Gestion des Bannières</span>
@endsection

@section('content')
<div style="max-width: 1200px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h1 style="font-size: 1.375rem; color: #333; font-weight: 600;">Gestion des Bannières</h1>
        <a href="{{ route('admin.banners.create') }}" 
           style="display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; background-color: #000; color: #fff; border-radius: 8px; transition: all 0.2s;" 
           title="Nouvelle Bannière"
           onmouseover="this.style.opacity='0.8'" 
           onmouseout="this.style.opacity='1'">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
        </a>
    </div>

    <!-- Table Container -->
    <div style="background: #fff; border: 1px solid #e5e5e5; border-radius: 2px;">
        <!-- Table Header -->
        <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 0.8rem; color: #666;">{{ $banners->total() }} bannière(s) configurée(s)</span>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; background: #fafafa;">
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Ordre</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Visuel</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Titre / Lien</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Période</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Statut</th>
                    <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                <tr style="border-bottom: 1px solid #e5e5e5;">
                    <td style="padding: 0.875rem 1.25rem; font-size: 0.875rem; font-weight: 600; color: #333;">
                        #{{ $banner->order }}
                    </td>
                    <td style="padding: 0.875rem 1.25rem;">
                        <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" style="width: 100px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #eee;">
                    </td>
                    <td style="padding: 0.875rem 1.25rem;">
                        <div style="font-size: 0.875rem; color: #333; font-weight: 500;">{{ $banner->title }}</div>
                        <div style="font-size: 0.75rem; color: #64748b; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $banner->link_url ?? 'Sans lien' }}</div>
                    </td>
                    <td style="padding: 0.875rem 1.25rem; font-size: 0.8rem; color: #666;">
                        @if($banner->start_date || $banner->end_date)
                            {{ $banner->start_date ? $banner->start_date->format('d/m/Y') : '∞' }} - {{ $banner->end_date ? $banner->end_date->format('d/m/Y') : '∞' }}
                        @else
                            Permanent
                        @endif
                    </td>
                    <td style="padding: 0.875rem 1.25rem;">
                        <div onclick="toggleBannerStatus({{ $banner->id }})" id="status-badge-{{ $banner->id }}" style="cursor: pointer;">
                            @if($banner->active)
                                <span style="background-color: #dcfce7; color: #166534; padding: 3px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Actif</span>
                            @else
                                <span style="background-color: #f1f5f9; color: #64748b; padding: 3px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Inactif</span>
                            @endif
                        </div>
                    </td>
                    <td style="padding: 0.875rem 1.25rem; text-align: right; display: flex; justify-content: flex-end; gap: 4px;">
                        <a href="{{ route('admin.banners.edit', $banner) }}" 
                           style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #004aad; background: #eef2ff; border-radius: 8px; transition: all 0.2s;" 
                           title="Modifier"
                           onmouseover="this.style.background='#e0e7ff'" 
                           onmouseout="this.style.background='#eef2ff'">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        
                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cette bannière ?');">
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
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 3rem; text-align: center; color: #94a3b8; font-size: 0.875rem;">
                        Aucune bannière configurée.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($banners->hasPages())
        <div style="padding: 1rem; border-top: 1px solid #e5e5e5;">
            {{ $banners->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function toggleBannerStatus(bannerId) {
    const badge = document.getElementById(`status-badge-${bannerId}`);
    
    fetch(`/admin/banners/${bannerId}/toggle-status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.active) {
                badge.innerHTML = '<span style="background-color: #dcfce7; color: #166534; padding: 3px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Actif</span>';
            } else {
                badge.innerHTML = '<span style="background-color: #f1f5f9; color: #64748b; padding: 3px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">Inactif</span>';
            }
        }
    });
}
</script>
@endsection
