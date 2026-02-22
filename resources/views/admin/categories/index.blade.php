@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Catégories & Architecture</span>
@endsection

@section('content')
    <div style="max-width: 900px;">

        <!-- Header avec bouton -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600;">
                {{ $level == 1 ? 'Catégories Principales' : ($level == 2 ? 'Sous-Catégories' : 'Éléments de Détail') }}
            </h1>
            <a href="{{ route('admin.categories.create') }}"
                style="display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; background-color: #000; color: #fff; border-radius: 8px; transition: all 0.2s;" 
                title="Ajouter une catégorie"
                onmouseover="this.style.opacity='0.8'" 
                onmouseout="this.style.opacity='1'">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
            </a>
        </div>

        <!-- Description Box -->
        <div
            style="background: #fffaf0; border: 1px solid #ff9d00; padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: flex-start; gap: 12px; border-radius: 2px;">
            <div style="flex-shrink: 0; margin-top: 2px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" fill="#ff9d00" />
                    <path d="M12 7v6M12 17h.01" stroke="white" stroke-width="2.5" stroke-linecap="round" />
                </svg>
            </div>
            <div>
                <div style="font-size: 0.875rem; color: #333; font-weight: 600; margin-bottom: 0.15rem;">
                    Gestion de l'organisation hiérarchique
                </div>
                <div style="font-size: 0.8rem; color: #444; line-height: 1.4;">
                    Gérez l'organisation hiérarchique du catalogue, les catégories et sous catégories.
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div style="background: #fff; border: 1px solid #e5e5e5;">

            <!-- Table Header -->
            <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5;">
                <span style="font-size: 0.8rem; color: #666;">{{ $categories->total() }} catégorie(s)</span>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    @forelse($categories as $category)
                        <tr style="border-bottom: 1px solid #e5e5e5;">
                            <td style="padding: 0.875rem 1.25rem; width: 40px;">
                                <span style="font-size: 1.1rem;">{!! $category->icone ?? '📦' !!}</span>
                            </td>
                            <td style="padding: 0.875rem 0.5rem;">
                                <div style="font-size: 0.875rem; color: #333;">{{ $category->nom }}</div>
                                @if($level == 1 && $category->famille)
                                    <span style="font-size: 0.7rem; color: #999;">{{ $category->famille }}</span>
                                @endif
                            </td>
                            <td style="padding: 0.875rem 1.25rem; text-align: right; display: flex; justify-content: flex-end; gap: 4px;">
                                <a href="{{ route('admin.categories.show', $category) }}" 
                                   style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #64748b; background: #f8fafc; border-radius: 8px; transition: all 0.2s;" 
                                   title="Voir"
                                   onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a'" 
                                   onmouseout="this.style.background='#f8fafc'; this.style.color='#64748b'">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #64748b; background: #f8fafc; border-radius: 8px; transition: all 0.2s;" 
                                   title="Modifier"
                                   onmouseover="this.style.background='#f1f5f9'; this.style.color='#0f172a'" 
                                   onmouseout="this.style.background='#f8fafc'; this.style.color='#64748b'">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;" class="delete-form">
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
                            <td colspan="3"
                                style="padding: 3rem 1.25rem; text-align: center; color: #999; font-size: 0.875rem;">
                                Aucune catégorie
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div style="padding: 1rem; border-top: 1px solid #e5e5e5;">
                {{ $categories->links('admin.pagination') }}
            </div>
        </div>
    </div>
@endsection