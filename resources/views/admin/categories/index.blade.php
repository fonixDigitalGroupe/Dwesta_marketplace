@extends('layouts.admin')

@section('title', 'Gestion des Catégories - Niveau ' . $level)

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
    <a href="{{ route('admin.categories.l1') }}">Catalogue</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
    <span style="color: var(--mady-red); font-weight: 700;">Niveau {{ $level }}</span>
@endsection

@section('content')
<div class="card-pro" style="overflow: hidden;">
    
    <!-- Table Header with Actions -->
    <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--slate-100); background: #fff;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-size: 1.25rem; font-weight: 800; color: var(--slate-900); letter-spacing: -0.02em; margin-bottom: 0.25rem;">
                    {{ $level == 1 ? 'Catégories Principales' : ($level == 2 ? 'Sous-Catégories' : 'Éléments de Détail') }}
                </h1>
                <p style="font-size: 0.875rem; color: var(--slate-500); font-weight: 500;">Gérez l'organisation hiérarchique du catalogue Niveau {{ $level }}.</p>
            </div>
            
            <a href="{{ route('admin.categories.create') }}" style="font-size: 0.875rem; font-weight: 700; color: var(--mady-red); text-decoration: none; border-bottom: 2px solid transparent; transition: all 0.2s;" onmouseover="this.style.borderBottomColor='var(--mady-red)'" onmouseout="this.style.borderBottomColor='transparent'">
                Ajouter
            </a>
        </div>
    </div>

    <!-- Table content -->
    <div style="padding: 0;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: var(--slate-50); border-bottom: 1px solid var(--slate-100);">
                    <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500);">ID</th>
                    <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500);">Catégorie</th>
                    @if($level > 1)
                    <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500);">Parent</th>
                    @endif
                    <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500);">Ordre</th>
                    <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500);">Statut</th>
                    <th style="padding: 1rem 2rem; font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-500); text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr style="border-bottom: 1px solid var(--slate-100); transition: background 0.2s;" onmouseover="this.style.background='var(--slate-50)'" onmouseout="this.style.background='transparent'">
                    <td style="padding: 1.25rem 2rem; font-size: 0.8125rem; font-weight: 700; color: var(--slate-400);">#{{ $category->id }}</td>
                    <td style="padding: 1.25rem 2rem;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 36px; height: 36px; background: var(--slate-100); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.125rem;">
                                {{ $category->icone ?? '📁' }}
                            </div>
                            <div>
                                <div style="font-weight: 700; color: var(--slate-900); font-size: 0.9375rem;">{{ $category->nom }}</div>
                                @if($category->slug)
                                <div style="font-size: 0.75rem; color: var(--slate-400); font-weight: 500;">/{{ $category->slug }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    @if($level > 1)
                    <td style="padding: 1.25rem 2rem;">
                        <span style="display: inline-flex; align-items: center; padding: 4px 10px; background: var(--slate-100); border-radius: 6px; font-size: 0.75rem; font-weight: 700; color: var(--slate-700);">
                            {{ $category->parent->nom ?? 'Aucun' }}
                        </span>
                    </td>
                    @endif
                    <td style="padding: 1.25rem 2rem; font-weight: 600; color: var(--slate-600); font-size: 0.875rem;">{{ $category->ordre }}</td>
                    <td style="padding: 1.25rem 2rem;">
                        @if($category->actif)
                            <span style="display: inline-flex; align-items: center; gap: 6px; color: #059669; font-size: 0.8125rem; font-weight: 700;">
                                <div style="width: 6px; height: 6px; background: #10b981; border-radius: 50%;"></div>
                                Actif
                            </span>
                        @else
                            <span style="display: inline-flex; align-items: center; gap: 6px; color: var(--slate-400); font-size: 0.8125rem; font-weight: 700;">
                                <div style="width: 6px; height: 6px; background: var(--slate-300); border-radius: 50%;"></div>
                                Masqué
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1.25rem 2rem; text-align: right;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            <a href="{{ route('admin.categories.edit', $category) }}" style="padding: 8px; color: var(--slate-500); hover:color: var(--slate-900); transition: all 0.2s; border-radius: 6px;" onmouseover="this.style.background='var(--slate-200)'; this.style.color='var(--slate-900)'" onmouseout="this.style.background='transparent'; this.style.color='var(--slate-500)'">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')" style="display: inline;">
                                @csrf @method('DELETE')
                                <button type="submit" style="padding: 8px; border: none; background: none; color: var(--slate-400); cursor: pointer; transition: all 0.2s; border-radius: 6px;" onmouseover="this.style.background='#fee2e2'; this.style.color='#ef4444'" onmouseout="this.style.background='transparent'; this.style.color='var(--slate-400)'">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 4rem; text-align: center; color: var(--slate-400); font-weight: 500;">
                        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 1rem; opacity: 0.3;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p>Aucune catégorie trouvée à ce niveau.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div style="padding: 1.5rem 2rem; border-top: 1px solid var(--slate-100); background: var(--slate-50);">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
