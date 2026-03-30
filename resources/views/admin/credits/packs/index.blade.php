@extends('layouts.admin')

@section('title', 'Gestion des Packs de Crédits')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    select:focus, input:focus {
        border-color: #aaa !important;
        box-shadow: 0 0 0 2px rgba(0,0,0,0.05) !important;
        outline: none;
    }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">

        <!-- Titre en majuscules type image -->
        <h2 style="font-size: 0.85rem; color: #555; font-weight: 700; text-transform: uppercase; margin-bottom: 1.5rem; letter-spacing: 0.05em;">
            GESTION DES PACKS DE CRÉDITS
        </h2>

        <!-- Barre d'outils type image -->
        <div style="display: flex; gap: 8px; margin-bottom: 1.5rem;">
            <a href="{{ route('admin.credits.packs') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                Liste des packs <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i>
            </a>
            <a href="{{ route('admin.credits.packs.create') }}" style="display: flex; align-items: center; gap: 8px; background: #e67e00; color: #fff; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; text-decoration: none; transition: opacity 0.2s;">
                Nouveau pack <i class="fas fa-plus-square"></i>
            </a>
        </div>

        <!-- Main Conteneur -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1rem;">
            
            <!-- Filtres type image -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <div style="font-size: 0.85rem; color: #333;">
                    Afficher 
                    <select onchange="window.location.href = '{{ route('admin.credits.packs') }}?per_page=' + this.value + '&search={{ $search }}'" 
                        style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; margin: 0 4px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                        <option value="8" {{ $perPage == 8 ? 'selected' : '' }}>8</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    lignes
                </div>
                <div style="font-size: 0.85rem; color: #333;">
                    <form action="{{ route('admin.credits.packs') }}" method="GET" style="display: flex; align-items: center;">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        Chercher: <input type="text" name="search" value="{{ $search }}" 
                            placeholder="Tapez et Entrée..."
                            style="padding: 6px 10px; border: 1px solid #ddd; border-radius: 3px; outline: none; margin-left: 5px; background-color: #fff;">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; border: 1px solid #eee;">
                    <thead>
                        <tr style="background: #fff; border-bottom: 2px solid #eee;">
                            <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.85rem; font-weight: 700; color: #333; width: 220px;">Nom du Pack</th>
                            <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.85rem; font-weight: 700; color: #333;">Description</th>
                            <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.85rem; font-weight: 700; color: #333; width: 140px;">Crédits</th>
                            <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.85rem; font-weight: 700; color: #333; width: 100px;">Statut</th>
                            <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.85rem; font-weight: 700; color: #333; width: 120px;">Prix</th>
                            <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.85rem; font-weight: 700; color: #333; width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($packs as $pack)
                            <tr style="transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                                <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">
                                    <span style="background: #fff3e0; color: #e67e00; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 0.75rem;">{{ ucfirst($pack->nom) }}</span>
                                </td>
                                <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">{{ ucfirst(Str::limit($pack->description, 50)) }}</td>
                                <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit; text-align: center;">
                                    {{ $pack->credits }}
                                    @if($pack->bonus_credits > 0)
                                        <span style="color: #27ae60; font-weight: 600;">+ {{ $pack->bonus_credits }} bonus</span>
                                    @endif
                                </td>
                                <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; font-family: inherit; text-align: center;">
                                    @if($pack->actif)
                                        <span style="color: #27ae60; background: #eafaf1; padding: 2px 8px; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">ACTIF</span>
                                    @else
                                        <span style="color: #e74c3c; background: #fdedec; padding: 2px 8px; border-radius: 20px; font-size: 0.7rem; font-weight: 600;">INACTIF</span>
                                    @endif
                                </td>
                                <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit; text-align: center;">{{ number_format($pack->prix, 0, ',', ' ') }} F</td>
                                <td style="padding: 10px; border: 1px solid #eee; text-align: center;">
                                    <div style="display: flex; gap: 4px; justify-content: center;">
                                        <a href="{{ route('admin.credits.packs.edit', $pack) }}" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #004aad; color: #fff; border-radius: 3px; font-size: 0.75rem; text-decoration: none; font-weight: 600;" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form id="delete-form-{{ $pack->id }}" action="{{ route('admin.credits.packs.destroy', $pack) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $pack->id }})" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #e74c3c; color: #fff; border-radius: 3px; font-size: 0.75rem; border: none; cursor: pointer;" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 40px; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                                    Aucun pack de crédits trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Info & Links type image -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                <div style="font-size: 0.85rem; color: #666;">
                    Affichage de {{ $packs->firstItem() ?? 0 }} à {{ $packs->lastItem() ?? 0 }} sur {{ $packs->total() }} éléments
                </div>
                <div style="display: flex; gap: 0; border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                    @if($packs->onFirstPage())
                        <span style="padding: 6px 12px; background: #fff; border: none; border-right: 1px solid #ddd; font-size: 0.85rem; color: #ccc; cursor: not-allowed;">Prec</span>
                    @else
                        <a href="{{ $packs->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; border: none; border-right: 1px solid #ddd; font-size: 0.85rem; color: #333; cursor: pointer; text-decoration: none;">Prec</a>
                    @endif

                    @for($i = 1; $i <= $packs->lastPage(); $i++)
                        @if($i == $packs->currentPage())
                            <span style="padding: 6px 12px; background: #e67e00; border: none; border-right: 1px solid #ddd; font-size: 0.85rem; color: #fff; cursor: default;">{{ $i }}</span>
                        @else
                            <a href="{{ $packs->url($i) }}" style="padding: 6px 12px; background: #fff; border: none; border-right: 1px solid #ddd; font-size: 0.85rem; color: #333; cursor: pointer; text-decoration: none;">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($packs->hasMorePages())
                        <a href="{{ $packs->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; border: none; font-size: 0.85rem; color: #333; cursor: pointer; text-decoration: none;">Suiv</a>
                    @else
                        <span style="padding: 6px 12px; background: #fff; border: none; font-size: 0.85rem; color: #ccc; cursor: not-allowed;">Suiv</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: "Cette action supprimera définitivement ce pack !",
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
    <style>
        .custom-pagination .pagination { display: flex; list-style: none; gap: 5px; padding: 0; margin: 0; }
        .custom-pagination .page-link { padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; color: #555; text-decoration: none; font-size: 0.8rem; transition: all 0.2s; }
        .custom-pagination .page-item.active .page-link { background: #e67e00; border-color: #e67e00; color: #fff; }
        .custom-pagination .page-link:hover:not(.active) { background: #f8f9fa; border-color: #ccc; }
        .custom-pagination .page-item.disabled .page-link { color: #ccc; pointer-events: none; background: #fff; }
    </style>
    @endpush
@endsection
