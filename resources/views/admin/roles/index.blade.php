@extends('layouts.admin')

@section('title', 'Gestion des Rôles')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    select:focus, input:focus {
        border-color: #adb1b8 !important;
        box-shadow: 0 0 3px rgba(225,121,9,0.5) !important;
        outline: none;
    }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">
        <!-- Main Conteneur style Amazon Card -->
        <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                    Gestion des rôles
                </h1>
                
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.roles.create') }}" 
                       style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; color: #111; padding: 6px 14px; border-radius: 3px; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.4) inset; display: flex; align-items: center; gap: 6px;">
                        Créer un nouveau rôle
                    </a>
                    <a href="javascript:window.print()" 
                       style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 3px; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                        Imprimer
                    </a>
                </div>
            </div>

            <!-- Barre de filtre modernisée -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px 16px; border-radius: 0; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555;">
                    <span>Afficher</span>
                    <select onchange="window.location.href = '{{ route('admin.roles.index') }}?per_page=' + this.value + '&search={{ $search }}'" 
                        style="padding: 4px 6px; border: 1px solid #adb1b8; border-radius: 0; background: #f0f2f2; font-size: 0.8rem; color: #111; cursor: pointer; outline: none;">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span>résultats par page</span>
                </div>

                <div style="font-size: 0.8rem;">
                    <form action="{{ route('admin.roles.index') }}" method="GET" style="display: flex; align-items: center; gap: 8px;">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        <span style="color: #555;">Rechercher :</span>
                        <input type="text" name="search" value="{{ $search }}" 
                            placeholder="Nom du rôle..."
                            style="padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; outline: none; width: 220px; font-size: 0.8rem;">
                    </form>
                </div>
            </div>

            <!-- Table Amazon Design (With subtle vertical borders) -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Nom du rôle</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Permissions</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 100px; border-right: 1px solid #e7e7e7;">Type</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #0066c0; font-weight: 500; text-transform: capitalize; border-right: 1px solid #e7e7e7; cursor: pointer;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                {{ $role->name }}
                            </td>

                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                                <div style="display: flex; flex-wrap: wrap; gap: 4px; max-width: 450px;">
                                    @php
                                        $perms = $role->permissions->pluck('name')->toArray();
                                        $displayLimit = 3;
                                        $displayPerms = array_slice($perms, 0, $displayLimit);
                                        $remainingCount = count($perms) - $displayLimit;
                                    @endphp
                                    @foreach($displayPerms as $perm)
                                        <span style="font-size: 0.7rem; background: #fff; color: #555; padding: 2px 6px; border-radius: 2px; border: 1px solid #ddd; white-space: nowrap;">
                                            {{ $labels[$perm] ?? $perm }}
                                        </span>
                                    @endforeach
                                    @if($remainingCount > 0)
                                        <span style="font-size: 0.7rem; color: #ff8c00; font-weight: 600; cursor: help;" title="{{ implode(', ', array_slice($perms, $displayLimit)) }}">
                                            +{{ $remainingCount }} autres
                                        </span>
                                    @endif
                                    @if(count($perms) === 0)
                                        <span style="font-size: 0.75rem; color: #999;">Aucune permission associée</span>
                                    @endif
                                </div>
                            </td>
                            
                            <td style="padding: 12px 15px; text-align: center; font-size: 0.8rem; color: #555; border-right: 1px solid #e7e7e7;">
                                @if(in_array($role->name, ['admin', 'vendeur', 'client']))
                                    <span style="color: #555;">Système</span>
                                @else
                                    <span style="color: #777;">Personnel</span>
                                @endif
                            </td>

                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.roles.edit', $role) }}" 
                                       style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                       onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'" 
                                       onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                       Modifier
                                    </a>

                                    @if(!in_array($role->name, ['admin', 'vendeur', 'client']))
                                        <span style="color: #ddd;">|</span>
                                        <form id="delete-form-{{ $role->id }}" action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display:inline;">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmDelete({{ $role->id }})" 
                                                    style="background: none; border: none; color: #c40000; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                                    onmouseover="this.style.textDecoration='underline'" 
                                                    onmouseout="this.style.textDecoration='none'">
                                                Supprimer
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 40px; text-align: center; color: #555; font-size: 0.85rem;">Aucun rôle trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Amazon Style Harmonisée -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-top: 10px;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                    Affichage de {{ $roles->firstItem() ?? 0 }} à {{ $roles->lastItem() ?? 0 }} sur {{ $roles->total() }} résultats
                </div>
                <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                    @if($roles->onFirstPage())
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                    @else
                        <a href="{{ $roles->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                    @endif

                    @foreach(range(1, $roles->lastPage()) as $i)
                        @if($i == $roles->currentPage())
                            <span style="padding: 6px 12px; background: linear-gradient(to bottom, #f7dfa5, #f0c14b); color: #111; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #a88734;">{{ $i }}</span>
                        @else
                            <a href="{{ $roles->url($i) }}" style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                        @endif
                    @endforeach

                    @if($roles->hasMorePages())
                        <a href="{{ $roles->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                    @else
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
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
