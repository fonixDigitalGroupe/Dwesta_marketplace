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

        <!-- Main Conteneur -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1.5rem;">
            
            <div style="margin-bottom: 0.5rem;">
                <h1 style="font-size: 1.25rem; font-weight: 700; color: #333; margin: 0;">Gestion des Packs d'Abonnement</h1>
            </div>
            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1rem;"></div>

            <div style="display: flex; gap: 12px; align-items: center; margin-bottom: 1rem;">
                <a href="{{ route('admin.abonnements.create') }}" style="display: flex; align-items: center; gap: 8px; background: #e67e00; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Nouveau pack <i class="fas fa-plus-square"></i>
                </a>
                <a href="javascript:window.print()" style="display: flex; align-items: center; gap: 8px; background: #2563eb; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                    Imprimer <i class="fas fa-print"></i>
                </a>
            </div>

            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1.5rem;"></div>
            
            <!-- Filtres type image -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
                <div style="font-size: 0.85rem; color: #333;">
                    Afficher 
                    <select onchange="window.location.href = '{{ route('admin.abonnements.index') }}?per_page=' + this.value + '&search={{ $search }}'" 
                        style="padding: 8px; border: 1px solid #ddd; border-radius: 6px; margin: 0 4px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s; min-width: 60px;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
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
                            style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; outline: none; margin-left: 5px; background-color: #fff; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                    </form>
                </div>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #eee;">
                <thead>
                    <tr style="background: #fff; border-bottom: 2px solid #eee;">
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333; width: 180px;">Nom du Pack</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333;">Description</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.82rem; font-weight: 700; color: #333; width: 100px;">Commission</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.82rem; font-weight: 700; color: #333; width: 100px;">Annonces</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.82rem; font-weight: 700; color: #333; width: 100px;">Statut</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.82rem; font-weight: 700; color: #333; width: 130px;">Prix Mensuel</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: right; font-size: 0.82rem; font-weight: 700; color: #333; width: 100px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($abonnements as $abonnement)
                        <tr style="transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #333; font-weight: 500; font-family: inherit;">
                                <span style="background: #fff3e0; color: #e67e00; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 0.75rem;">{{ ucfirst($abonnement->nom) }}</span>
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">{{ ucfirst(Str::limit($abonnement->description, 50)) }}</td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit; text-align: center;">{{ $abonnement->commission }} %</td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit; text-align: center;">
                                @if($abonnement->nombre_annonces > 0)
                                    <span style="font-weight: 600;">{{ $abonnement->nombre_annonces }}</span>
                                @else
                                    <span style="font-style: italic; opacity: 0.7;">illimité</span>
                                @endif
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; font-family: inherit; text-align: center;">
                                @if($abonnement->actif)
                                    <span style="background: #dcfce7; color: #16a34a; padding: 4px 12px; border-radius: 4px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">ACTIF</span>
                                @else
                                    <span style="background: #ffedd5; color: #9a3412; padding: 4px 12px; border-radius: 4px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase;">INACTIF</span>
                                @endif
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #333; font-weight: 600; font-family: inherit; text-align: center;">{{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} F</td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: right;">
                                <div style="display: flex; gap: 4px; justify-content: flex-end;">
                                    <a href="{{ route('admin.abonnements.edit', $abonnement) }}" 
                                       style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #eff6ff; color: #2563eb; border-radius: 6px; font-size: 0.85rem; text-decoration: none; border: 1px solid #dbeafe; transition: all 0.2s;" 
                                       onmouseover="this.style.background='#dbeafe'" onmouseout="this.style.background='#eff6ff'"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form id="suspend-form-{{ $abonnement->id }}" action="{{ route('admin.abonnements.toggle-status', $abonnement) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="button" onclick="confirmSuspend({{ $abonnement->id }}, {{ $abonnement->actif ? 'true' : 'false' }})" 
                                                style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: {{ $abonnement->actif ? '#fff7ed' : '#f0fdf4' }}; color: {{ $abonnement->actif ? '#c2410c' : '#15803d' }}; border-radius: 6px; font-size: 0.8rem; border: 1px solid {{ $abonnement->actif ? '#ffedd5' : '#dcfce7' }}; cursor: pointer; transition: all 0.2s;" 
                                                onmouseover="this.style.background='{{ $abonnement->actif ? '#ffedd5' : '#dcfce7' }}'" onmouseout="this.style.background='{{ $abonnement->actif ? '#fff7ed' : '#f0fdf4' }}'"
                                                title="{{ $abonnement->actif ? 'Suspendre' : 'Activer' }}">
                                            <i class="fas fa-{{ $abonnement->actif ? 'lock' : 'lock-open' }}"></i>
                                        </button>
                                    </form>

                                    <form id="delete-form-{{ $abonnement->id }}" action="{{ route('admin.abonnements.destroy', $abonnement) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $abonnement->id }})" 
                                                style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #fef2f2; color: #dc2626; border-radius: 6px; font-size: 0.85rem; border: 1px solid #fee2e2; cursor: pointer; transition: all 0.2s;" 
                                                onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fef2f2'"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                                Aucun pack d'abonnement trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Info & Links type image -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                <div style="font-size: 0.85rem; color: #666;">
                    ligne {{ $abonnements->firstItem() ?? 0 }} sur {{ $abonnements->total() }}
                </div>
                <div style="display: flex; gap: 0; border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                    @if($abonnements->onFirstPage())
                        <span style="padding: 6px 12px; background: #fff; border: none; border-right: 1px solid #ddd; font-size: 0.85rem; color: #ccc; cursor: not-allowed;">Prec</span>
                    @else
                        <a href="{{ $abonnements->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; border: none; border-right: 1px solid #ddd; font-size: 0.85rem; color: #333; cursor: pointer; text-decoration: none;">Prec</a>
                    @endif

                    @for($i = 1; $i <= $abonnements->lastPage(); $i++)
                        @if($i == $abonnements->currentPage())
                            <span style="padding: 6px 12px; background: #eff6ff; border: none; border-right: 1px solid #ddd; font-size: 0.85rem; color: #2563eb; font-weight: 700; cursor: default;">{{ $i }}</span>
                        @else
                            <a href="{{ $abonnements->url($i) }}" style="padding: 6px 12px; background: #fff; border: none; border-right: 1px solid #ddd; font-size: 0.85rem; color: #333; cursor: pointer; text-decoration: none;">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($abonnements->hasMorePages())
                        <a href="{{ $abonnements->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; border: none; font-size: 0.85rem; color: #333; cursor: pointer; text-decoration: none;">Suiv</a>
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

        function confirmSuspend(id, isActive) {
            const actionText = isActive ? 'suspendre' : 'activer';
            const actionColor = isActive ? '#ea580c' : '#16a34a';
            
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: `Voulez-vous vraiment ${actionText} ce pack d'abonnement ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: actionColor,
                cancelButtonColor: '#64748b',
                confirmButtonText: `Oui, ${actionText} !`,
                cancelButtonText: 'Annuler',
                borderRadius: '8px'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('suspend-form-' + id).submit();
                }
            })
        }
    </script>
    @endpush
@endsection
