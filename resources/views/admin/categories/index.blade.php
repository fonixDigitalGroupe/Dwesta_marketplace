@extends('layouts.admin')

@php
    $levelTitle = $level == 1 ? 'Catégories Principales' : ($level == 2 ? 'Sous-Catégories' : 'Éléments de Détail');
    $currentTitle = 'Gestion des ' . $levelTitle;
@endphp

@section('title', $currentTitle)

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    select:focus, input:focus {
        border-color: #adb1b8 !important;
        box-shadow: 0 0 3px rgba(225,121,9,0.5) !important;
        outline: none;
    }
    .filter-label { font-size: 0.8rem; color: #555; font-weight: 500; margin-bottom: 4px; display: block; }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">
        @include('admin.partials.settings-tabs')
        
        <!-- Main Conteneur style Amazon Card -->
        <div style="background: #fff; border: 1px solid #e7e7e7; border-top: none; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                    {{ $level == 1 ? 'Gestion des Catégories' : ($level == 2 ? 'Gestion des Sous-Catégories' : 'Gestion des Types de Produits') }}
                </h1>
                
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.categories.create') }}" 
                       style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.4) inset; display: flex; align-items: center; gap: 6px;">
                        Ajouter une catégorie
                    </a>
                    <a href="javascript:window.print()" 
                       style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                        Imprimer
                    </a>
                </div>
            </div>

            <!-- Barre de filtres grise -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px 20px; border-radius: 0; margin-bottom: 20px;">
                <form action="{{ route('admin.categories.l'.$level) }}" method="GET" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                    <input type="hidden" name="per_page" value="{{ request('per_page', 8) }}">
                    
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555;">
                        <span>Afficher</span>
                        <select onchange="window.location.href = '{{ request()->fullUrlWithQuery(['per_page' => '']) }}'.replace('per_page=', 'per_page=' + this.value)" 
                            style="padding: 3px 6px; border: 1px solid #adb1b8; border-radius: 0; background: #fcfcfc; font-size: 0.8rem; color: #111; cursor: pointer; outline: none;">
                            <option value="8" {{ request('per_page', 8) == 8 ? 'selected' : '' }}>8</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <span>résultats</span>
                    </div>

                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span style="font-size: 0.8rem; color: #555; font-weight: 500;">Rechercher :</span>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Nom de la catégorie..."
                            style="padding: 6px 12px; border: 1px solid #adb1b8; border-radius: 0; outline: none; font-size: 0.85rem; width: 250px;">
                    </div>
                </form>
            </div>

            <!-- Table Amazon Design -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                        @if($level == 1)
                            <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 60px;">Icône</th>
                        @endif
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Désignation</th>
                        @if($level > 1)
                            <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 220px;">Parent</th>
                        @endif
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 120px;">Statut</th>
                        @if($level == 1)
                            <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 140px;">Famille</th>
                        @endif
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            @if($level == 1)
                                <td style="padding: 12px 15px; text-align: center; font-size: 1.2rem; border-right: 1px solid #e7e7e7;">
                                    {!! $category->icone ?? '📦' !!}
                                </td>
                            @endif
                            <td style="padding: 12px 15px; font-size: 0.85rem; border-right: 1px solid #e7e7e7;">
                                <div style="font-weight: 600; color: #0066c0;">{{ $category->nom }}</div>
                                @if($category->description)
                                    <div style="font-size: 0.75rem; color: #777; margin-top: 2px;">{{ Str::limit($category->description, 60) }}</div>
                                @endif
                            </td>
                            @if($level > 1)
                                <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                    @if($level == 2)
                                        {{ $category->parent->nom ?? 'N/A' }}
                                    @else
                                        <div style="display: flex; flex-direction: column;">
                                            <span>{{ $category->parent->nom ?? 'N/A' }}</span>
                                            <span style="font-size: 0.7rem; color: #999;">({{ $category->parent->parent->nom ?? '' }})</span>
                                        </div>
                                    @endif
                                </td>
                            @endif
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                @if($category->actif)
                                    <span style="font-size: 0.75rem; color: #569b00; font-weight: 600;">Active</span>
                                @else
                                    <span style="font-size: 0.75rem; color: #c40000; font-weight: 600;">Suspendue</span>
                                @endif
                            </td>
                            @if($level == 1)
                                <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                    @if($category->famille)
                                        <span style="font-weight: 700; color: #c45500; font-size: 0.75rem; text-transform: uppercase;">{{ $category->famille }}</span>
                                    @else
                                        <span style="color: #999;">-</span>
                                    @endif
                                </td>
                            @endif
                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.categories.show', $category) }}" 
                                       style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                       onmouseover="this.style.textDecoration='underline'" 
                                       onmouseout="this.style.textDecoration='none'">
                                       Détails
                                    </a>
                                    <span style="color: #ddd;">|</span>
                                    <a href="{{ route('admin.categories.edit', $category) }}" 
                                       style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                       onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'" 
                                       onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                       Modifier
                                    </a>
                                    <span style="color: #ddd;">|</span>
                                    <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $category->id }})" 
                                                style="background: none; border: none; color: #c40000; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                                onmouseover="this.style.textDecoration='underline'" 
                                                onmouseout="this.style.textDecoration='none'">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $level == 1 ? 5 : ($level == 2 ? 4 : 5) }}" style="padding: 3rem; text-align: center; color: #999; font-size: 0.85rem;">
                                Aucune catégorie trouvée dans ce niveau.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Info & Links Harmonisée -->
            @if($categories->total() > 0)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-top: 10px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        Affichage de {{ $categories->firstItem() ?? 0 }} à {{ $categories->lastItem() ?? 0 }} sur {{ $categories->total() }} résultats
                    </div>
                    <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                        @if($categories->onFirstPage())
                            <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                        @else
                            <a href="{{ $categories->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                        @endif

                        @php
                            $cStart = max(1, $categories->currentPage() - 2);
                            $cEnd = min($categories->lastPage(), $cStart + 4);
                        @endphp

                        @for($i = $cStart; $i <= $cEnd; $i++)
                            @if($i == $categories->currentPage())
                                <span style="padding: 6px 12px; background: linear-gradient(to bottom, #f7dfa5, #f0c14b); color: #111; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #a88734;">{{ $i }}</span>
                            @else
                                <a href="{{ $categories->url($i) }}" style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($categories->hasMorePages())
                            <a href="{{ $categories->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection