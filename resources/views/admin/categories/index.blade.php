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
                style="background: #000; color: #fff; padding: 0.625rem 1.25rem; font-size: 0.85rem; text-decoration: none; font-weight: 600; border-radius: 4px; display: flex; align-items: center; gap: 8px; transition: all 0.2s;"
                onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Ajouter une catégorie
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
<td style="padding: 0.875rem 1.25rem; text-align: right; display: flex; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('admin.categories.show', $category) }}" style="color: #666; font-size: 0.75rem; text-decoration: none; padding: 4px 8px; background: #f1f5f9; border-radius: 4px;">Voir</a>

                                <a href="{{ route('admin.categories.edit', $category) }}" style="color: #333; font-size: 0.75rem; text-decoration: none; padding: 4px 8px; border: 1px solid #333; border-radius: 4px;">Modifier</a>

                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="color: #dc2626; font-size: 0.75rem; background: none; border: none; cursor: pointer; padding: 4px 8px; border: 1px solid #dc2626; border-radius: 4px;">Supprimer</button>
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