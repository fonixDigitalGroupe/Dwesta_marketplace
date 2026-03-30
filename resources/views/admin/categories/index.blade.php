@extends('layouts.admin')

@section('title', 'Gestion des Catégories')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">

        <!-- Titre en majuscules type image -->
        <h2 style="font-size: 0.85rem; color: #555; font-weight: 700; text-transform: uppercase; margin-bottom: 1.5rem; letter-spacing: 0.05em;">
            {{ $level == 1 ? 'Gestion des Catégories Principales' : ($level == 2 ? 'Gestion des Sous-Catégories' : 'Gestion des Éléments de Détail') }}
        </h2>

        <!-- Barre d'outils type image -->
        <div style="display: flex; gap: 8px; margin-bottom: 1.5rem;">
            <a href="{{ request()->url() }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                Liste des catégories <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i>
            </a>
            <a href="{{ route('admin.categories.create') }}" style="display: flex; align-items: center; gap: 8px; background: #e67e00; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                Nouvelle catégorie <i class="fas fa-plus-square"></i>
            </a>
            <a href="javascript:window.print()" style="display: flex; align-items: center; gap: 8px; background: #2563eb; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                Imprimer <i class="fas fa-print"></i>
            </a>
        </div>

        <!-- Main Conteneur -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1rem;">
            
            <!-- Barre d'outils secondaire type image -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 15px; font-size: 0.85rem; color: #333;">
                    <div>
                        Afficher 
                        <select onchange="window.location.href = '{{ request()->url() }}?per_page=' + this.value" 
                            style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; margin: 0 4px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                            <option value="8" {{ request('per_page', 8) == 8 ? 'selected' : '' }}>8</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        lignes
                    </div>
                </div>
            </div>
            
            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #eee;">
                <thead>
                    <tr style="background: #fff; border-bottom: 2px solid #eee;">
                        <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.82rem; font-weight: 700; color: #333; width: 60px;">Icône</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333;">Nom de la catégorie</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: right; font-size: 0.82rem; font-weight: 700; color: #333; width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr style="transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 1.25rem;">
                                {!! $category->icone ?? '📦' !!}
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">
                                <div style="font-weight: 600; color: #333; margin-bottom: 2px;">{{ $category->nom }}</div>
                                @if($level == 1 && $category->famille)
                                    <span style="background: #fff7ed; color: #c2410c; padding: 2px 8px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; border: 1px solid #fdba74; display: inline-block; margin-top: 4px;">
                                        {{ $category->famille }}
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: right;">
                                <div style="display: flex; gap: 4px; justify-content: flex-end;">
                                    <a href="{{ route('admin.categories.show', $category) }}" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #64748b; color: #fff; border-radius: 3px; font-size: 0.75rem; text-decoration: none;" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #004aad; color: #fff; border-radius: 3px; font-size: 0.75rem; text-decoration: none;" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $category->id }})" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #e74c3c; color: #fff; border-radius: 3px; font-size: 0.75rem; border: none; cursor: pointer;" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem;">Aucune catégorie trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination type image -->
            @if($categories->hasPages())
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                <div style="font-size: 0.85rem; color: #666;">
                    Affichage de {{ $categories->firstItem() ?? 0 }} à {{ $categories->lastItem() ?? 0 }} sur {{ $categories->total() }} éléments
                </div>
                <div style="display: flex; gap: 0; border: 1px solid #ddd; border-radius: 6px; overflow: hidden;">
                    @if($categories->onFirstPage())
                        <span style="padding: 8px 16px; background: #f8f9fa; color: #ccc; font-size: 0.85rem; border-right: 1px solid #ddd;">Prec</span>
                    @else
                        <a href="{{ $categories->previousPageUrl() }}" style="padding: 8px 16px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #ddd;">Prec</a>
                    @endif

                    @foreach(range(1, $categories->lastPage()) as $i)
                        @if($i == $categories->currentPage())
                            <span style="padding: 8px 16px; background: #e67e00; color: #fff; font-size: 0.85rem; border-right: 1px solid #ddd; font-weight: 600;">{{ $i }}</span>
                        @else
                            <a href="{{ $categories->url($i) }}" style="padding: 8px 16px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #ddd;">{{ $i }}</a>
                        @endif
                    @endforeach

                    @if($categories->hasMorePages())
                        <a href="{{ $categories->nextPageUrl() }}" style="padding: 8px 16px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none;">Suiv</a>
                    @else
                        <span style="padding: 8px 16px; background: #f8f9fa; color: #ccc; font-size: 0.85rem;">Suiv</span>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action est irréversible !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e67e00',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler',
                borderRadius: '8px'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
    @endpush
@endsection