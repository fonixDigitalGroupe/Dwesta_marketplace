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
    <span style="color: #bf0000; font-weight: 500;">{{ $category->nom }}</span>
@endsection

@section('content')
    <div style="max-width: 1200px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem;">

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div>
                <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">{{ strtoupper($category->chemin) }}</h1>
                <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Détails complets de la catégorie et ses sous-éléments.</p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('admin.categories.l1') }}" style="background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; padding: 0.6rem 1.2rem; font-size: 0.85rem; color: #666; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; transition: all 0.2s; font-weight: 500;" onmouseover="this.style.background='#f9f9f9'; this.style.color='#333'" onmouseout="this.style.background='#fff'; this.style.color='#666'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Retour
                </a>
            </div>
        </div>

        <!-- Section Sous-catégories Style Datatable -->
        <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
            <!-- Header Section -->
            <div style="padding: 1.25rem 1.5rem; border-bottom: 2px solid #f6f6f6;">
                <h3 style="font-size: 0.85rem; text-transform: uppercase; color: #666; font-weight: 600; letter-spacing: 0.05em;">
                    HIÉRARCHIE : {{ strtoupper($category->chemin) }}
                </h3>
            </div>

            <!-- Onglets / Filtres -->
            <div style="padding: 1rem 1.5rem; border-bottom: 1px solid #f6f6f6; display: flex; gap: 8px;">
                <button style="background: #333; border: 1px solid #333; border-radius: 4px; padding: 6px 12px; font-size: 0.8rem; color: #fff; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Liste des éléments
                </button>
                <button style="background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; padding: 6px 12px; font-size: 0.8rem; color: #666; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                    Actives
                    <span style="background: #bf0000; color: #fff; font-size: 10px; padding: 1px 6px; border-radius: 10px; font-weight: bold;">{{ $category->enfants->where('actif', true)->count() }}</span>
                </button>
                <div style="position: relative;">
                    <button style="background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; padding: 6px 12px; font-size: 0.8rem; color: #666; cursor: pointer; display: flex; align-items: center; gap: 6px;">
                        Masquées
                        <span style="background: #bf0000; color: #fff; font-size: 10px; padding: 1px 6px; border-radius: 10px; font-weight: bold;">{{ $category->enfants->where('actif', false)->count() }}</span>
                    </button>
                </div>
            </div>

            <!-- Contrôles de tableau -->
            <div style="padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; background: #fcfcfc;">
                <div style="font-size: 0.85rem; color: #666;">
                    Afficher 
                    <select style="border: 1px solid #e0e0e0; border-radius: 4px; padding: 4px 8px; margin: 0 4px; outline: none; background: #fff;">
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select> 
                    lignes
                </div>
                <div style="font-size: 0.85rem; color: #666; display: flex; align-items: center; gap: 8px;">
                    Chercher :
                    <input type="text" style="border: 1px solid #e0e0e0; border-radius: 4px; padding: 6px 12px; outline: none; width: 200px; transition: border 0.2s;" onfocus="this.style.borderColor='#bf0000'" onblur="this.style.borderColor='#e0e0e0'">
                </div>
            </div>

            @if($category->enfants->count() > 0)
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid #f6f6f6; background: white;">

                            <th style="padding: 1rem 1.5rem; font-size: 0.85rem; font-weight: 600; color: #333;">Nom</th>
                            <th style="padding: 1rem 1.5rem; font-size: 0.85rem; font-weight: 600; color: #333; width: 120px;">Statut</th>
                            <th style="padding: 1rem 1.5rem; font-size: 0.85rem; font-weight: 600; color: #333; text-align: right; width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($category->enfants as $enfant)
                            <tr style="border-bottom: 1px solid #f6f6f6; transition: all 0.2s ease-in-out;" onmouseover="this.style.background='#fbfbfb'" onmouseout="this.style.background='white'">

                                <td style="padding: 1rem 1.5rem;">
                                    <div style="font-weight: 500; color: #333; font-size: 0.95rem;">{{ $enfant->nom }}</div>
                                    <div style="font-size: 0.75rem; color: #999;">{{ $enfant->slug }}</div>
                                </td>

                                <td style="padding: 1rem 1.5rem;">
                                    @if($enfant->actif)
                                        <span style="display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 500; background-color: #d1fae5; color: #065f46;">Actif</span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 4px; font-size: 0.75rem; font-weight: 500; background-color: #fee2e2; color: #991b1b;">Masqué</span>
                                    @endif
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: right;">
                                    <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                        <a href="{{ route('admin.categories.show', $enfant) }}" style="background: #f1f3f5; border: 1px solid #e9ecef; border-radius: 4px; padding: 6px 10px; font-size: 0.75rem; color: #495057; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Voir
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $enfant) }}" style="background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; padding: 6px 10px; font-size: 0.75rem; color: #666; text-decoration: none; display: flex; align-items: center; gap: 4px; transition: all 0.2s;" onmouseover="this.style.background='#f9f9f9'; this.style.color='#333'" onmouseout="this.style.background='#fff'; this.style.color='#666'">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Modifier
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $enfant) }}" method="POST" onsubmit="return confirm('Attention : Toutes les sous-catégories seront également supprimées. Continuer ?')" style="display: inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="background: #fff5f5; border: 1px solid #ffe3e3; border-radius: 4px; padding: 6px 10px; font-size: 0.75rem; color: #e03131; cursor: pointer; display: flex; align-items: center; gap: 4px;">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pied de tableau / Pagination simplifié -->
                <div style="padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center; background: #fff; border-top: 2px solid #f6f6f6;">
                    <div style="font-size: 0.8rem; color: #666; font-weight: 500;">
                        Lignes 1 à {{ $category->enfants->count() }} sur {{ $category->enfants->count() }}
                    </div>
                    <div class="pagination-container">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item disabled"><span>Préc.</span></li>
                                <li class="page-item active"><span class="page-link">1</span></li>
                                <li class="page-item disabled"><span>Suiv.</span></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            @else
                <div style="padding: 4rem 2rem; text-align: center;">
                    <h3 style="font-size: 1rem; font-weight: 500; color: #333; margin-bottom: 0.5rem;">Pas de sous-catégories</h3>
                    <p style="color: #666; font-size: 0.9rem;">Cette catégorie n'a pas encore d'éléments enfants.</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        .pagination-container .pagination {
            display: flex;
            gap: 2px;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
        }
        .pagination-container .page-item .page-link, 
        .pagination-container .page-item span {
            display: inline-block;
            padding: 5px 12px;
            border: 1px solid #e0e0e0;
            background: #fff;
            color: #666;
            font-size: 0.8rem;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.2s;
        }
        .pagination-container .page-item.active span,
        .pagination-container .page-item.active .page-link {
            background: #bf0000;
            border-color: #bf0000;
            color: #fff;
            font-weight: 600;
        }
        .pagination-container .page-item.disabled span {
            color: #ccc;
            background: #fcfcfc;
            cursor: not-allowed;
            border-color: #eee;
        }
    </style>
@endsection