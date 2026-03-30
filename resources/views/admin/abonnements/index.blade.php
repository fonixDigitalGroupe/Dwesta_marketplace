@extends('layouts.admin')

@section('title', 'Gestion des Packs d\'Abonnement')

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
            Gestion des Packs d'Abonnement
        </h2>

        <!-- Barre d'outils type image -->
        <div style="display: flex; gap: 8px; margin-bottom: 1.5rem;">
            <a href="{{ route('admin.abonnements.index') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                Liste des packs <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i>
            </a>
            <a href="{{ route('admin.abonnements.create') }}" style="display: flex; align-items: center; gap: 8px; background: #e67e00; color: #fff; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; text-decoration: none; transition: opacity 0.2s;">
                Nouveau pack <i class="fas fa-plus-square"></i>
            </a>
        </div>


        <!-- Main Conteneur -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1rem;">
            
            <!-- Filtres type image -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                <div style="font-size: 0.85rem; color: #333;">
                    Afficher 
                    <select onchange="window.location.href = '{{ route('admin.abonnements.index') }}?per_page=' + this.value + '&search={{ $search }}'" 
                        style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; margin: 0 4px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                        <option value="8" {{ $perPage == 8 ? 'selected' : '' }}>8</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    lignes
                </div>
                <div style="font-size: 0.85rem; color: #333;">
                    <form action="{{ route('admin.abonnements.index') }}" method="GET" style="display: flex; align-items: center;">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        Chercher: <input type="text" name="search" value="{{ $search }}" 
                            placeholder="Tapez et Entrée..."
                            style="padding: 6px 10px; border: 1px solid #ddd; border-radius: 3px; outline: none; margin-left: 5px; background-color: #fff;">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #eee;">
                <thead>
                    <tr style="background: #fff; border-bottom: 2px solid #eee;">
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.85rem; font-weight: 700; color: #333; width: 220px;">Nom du Pack</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.85rem; font-weight: 700; color: #333;">Description</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.85rem; font-weight: 700; color: #333;">Commission</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.85rem; font-weight: 700; color: #333;">Annonces</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.85rem; font-weight: 700; color: #333; width: 140px;">Prix Mensuel</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: right; font-size: 0.85rem; font-weight: 700; color: #333; width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($abonnements as $abonnement)
                        <tr style="transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">
                                <span style="background: #fff3e0; color: #e67e00; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 0.75rem;">{{ $abonnement->nom }}</span>
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">{{ ucfirst(Str::limit($abonnement->description, 50)) }}</td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">{{ $abonnement->commission }} %</td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">{{ $abonnement->nombre_annonces > 0 ? $abonnement->nombre_annonces : 'ıllımıté' }}</td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">{{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} F</td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: right;">
                                <div style="display: flex; gap: 4px; justify-content: flex-end;">
                                    <a href="{{ route('admin.abonnements.edit', $abonnement) }}" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #004aad; color: #fff; border-radius: 3px; font-size: 0.75rem; text-decoration: none; font-weight: 600;" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="delete-form-{{ $abonnement->id }}" action="{{ route('admin.abonnements.destroy', $abonnement) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $abonnement->id }})" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #e74c3c; color: #fff; border-radius: 3px; font-size: 0.75rem; border: none; cursor: pointer;" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem;">Aucun pack trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination type image -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                <div style="font-size: 0.85rem; color: #666;">
                    Affichage de {{ $abonnements->firstItem() ?? 0 }} à {{ $abonnements->lastItem() ?? 0 }} sur {{ $abonnements->total() }} éléments
                </div>
                <div style="display: flex; gap: 0; border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                    @if($abonnements->onFirstPage())
                        <span style="padding: 6px 12px; background: #fff; color: #ccc; font-size: 0.85rem; border-right: 1px solid #ddd;">Prec</span>
                    @else
                        <a href="{{ $abonnements->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #ddd;">Prec</a>
                    @endif

                    @foreach(range(1, $abonnements->lastPage()) as $i)
                        @if($i == $abonnements->currentPage())
                            <span style="padding: 6px 12px; background: #e67e00; color: #fff; font-size: 0.85rem; border-right: 1px solid #ddd;">{{ $i }}</span>
                        @else
                            <a href="{{ $abonnements->url($i) }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #ddd;">{{ $i }}</a>
                        @endif
                    @endforeach

                    @if($abonnements->hasMorePages())
                        <a href="{{ $abonnements->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none;">Suiv</a>
                    @else
                        <span style="padding: 6px 12px; background: #fff; color: #ccc; font-size: 0.85rem;">Suiv</span>
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
