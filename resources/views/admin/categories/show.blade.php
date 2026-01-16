@extends('layouts.admin')

@section('title', 'Détails - ' . $category->nom)

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.categories.l1') }}">Catégories & Architecture</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">{{ $category->nom }}</span>
@endsection

@section('content')
    <div style="max-width: 900px;">

        <!-- Header avec bouton -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600;">
                {{ $category->nom }}
            </h1>
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('admin.categories.l1') }}"
                    style="background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; padding: 0.625rem 1.25rem; font-size: 0.85rem; color: #333; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s; font-weight: 500;"
                    onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='#fff'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour
                </a>
            </div>
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
                    Gérez les sous-catégories et éléments de détail pour : <strong>{{ $category->nom }}</strong>.
                </div>
            </div>
        </div>

        <!-- Table Container -->
        <div style="background: #fff; border: 1px solid #e5e5e5;">

            <!-- Table Header -->
            <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5;">
                <span style="font-size: 0.8rem; color: #666;">{{ $category->enfants->count() }} sous-catégorie(s)</span>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse;">
                <tbody>
                    @forelse($category->enfants as $enfant)
                        <tr style="border-bottom: 1px solid #e5e5e5; transition: all 0.2s;"
                            onmouseover="this.style.background='#fcfcfc'" onmouseout="this.style.background='white'">
                            <td style="padding: 0.875rem 1.25rem;">
                                <div style="font-size: 0.875rem; color: #333; font-weight: 500;">{{ $enfant->nom }}</div>
                                <div style="font-size: 0.7rem; color: #999;">{{ $enfant->slug }}</div>
                            </td>
                            <td style="padding: 0.875rem 1.25rem; text-align: right;">
                                <a href="{{ route('admin.categories.show', $enfant) }}"
                                    style="color: #666; font-size: 0.75rem; text-decoration: none; margin-right: 0.75rem;">Voir</a>
                                <a href="{{ route('admin.categories.edit', $enfant) }}"
                                    style="color: #666; font-size: 0.75rem; text-decoration: none; margin-right: 0.75rem;">Modifier</a>
                                <form action="{{ route('admin.categories.destroy', $enfant) }}" method="POST"
                                    style="display: inline;" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        style="background: none; border: none; color: #666; font-size: 0.75rem; cursor: pointer; padding: 0;">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3"
                                style="padding: 3rem 1.25rem; text-align: center; color: #999; font-size: 0.875rem;">
                                Aucune sous-catégorie
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection