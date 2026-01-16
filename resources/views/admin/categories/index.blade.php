@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #bf0000; font-weight: 500;">Catégories & Architecture</span>
@endsection

@section('content')
    <div style="max-width: 900px;">

        <!-- Header avec bouton -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600;">
                {{ $level == 1 ? 'Catégories Principales' : ($level == 2 ? 'Sous-Catégories' : 'Éléments de Détail') }}
            </h1>
            <a href="{{ route('admin.categories.create') }}"
                style="background: #bf0000; color: #fff; padding: 0.5rem 1rem; font-size: 0.8rem; text-decoration: none; font-weight: 500;">
                + Ajouter une catégorie
            </a>
        </div>

        <!-- Description Box -->
        <div style="background: #fff; border: 1px solid #e5e5e5; padding: 1rem 1.25rem; margin-bottom: 1.5rem;">
            <div style="font-size: 0.875rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">Gestion de
                l'organisation hiérarchique</div>
            <div style="font-size: 0.8rem; color: #666;">Gérez l'organisation hiérarchique du catalogue, les catégories et
                sous catégories.</div>
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
                            <td style="padding: 0.875rem 1.25rem; text-align: right;">
                                <a href="{{ route('admin.categories.show', $category) }}"
                                    style="color: #666; font-size: 0.75rem; text-decoration: none; margin-right: 0.75rem;">Voir</a>
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                    style="color: #666; font-size: 0.75rem; text-decoration: none; margin-right: 0.75rem;">Modifier</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                    style="display: inline;" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        style="background: none; border: none; color: #bf0000; font-size: 0.75rem; cursor: pointer; padding: 0;">Supprimer</button>
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
        </div>
    </div>
@endsection