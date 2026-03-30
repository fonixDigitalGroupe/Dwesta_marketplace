@extends('layouts.admin')

@php
    $isSellerView = in_array($role, ['vendeur', 'vendeur_pro', 'vendeur_particulier']);
    $currentTitle = $isSellerView ? 'Gestion des Vendeurs' : 'Gestion des Utilisateurs';
@endphp

@section('title', $currentTitle)

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
            {{ $currentTitle }}
        </h2>

        <!-- Barre d'outils type image -->
        <div style="display: flex; gap: 8px; margin-bottom: 1.5rem;">
            <a href="{{ route('admin.users.index') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                Liste des utilisateurs <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i>
            </a>
            <a href="{{ route('admin.users.create') }}" style="display: flex; align-items: center; gap: 8px; background: #e67e00; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                Nouveau <i class="fas fa-plus-square"></i>
            </a>
            <a href="javascript:window.print()" style="display: flex; align-items: center; gap: 8px; background: #2563eb; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; text-decoration: none; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                Imprimer <i class="fas fa-print"></i>
            </a>
        </div>


        <!-- Main Conteneur -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1rem;">
            
            <!-- Filtres type image -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 10px;">
                <div style="display: flex; align-items: center; gap: 15px; font-size: 0.85rem; color: #333;">
                    <div>
                        Afficher 
                        <select onchange="window.location.href = '{{ route('admin.users.index') }}?per_page=' + this.value + '&role={{ $role }}&nationalite={{ request('nationalite') }}&search={{ $search }}'" 
                            style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; margin: 0 4px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                            <option value="8" {{ $perPage == 8 ? 'selected' : '' }}>8</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        lignes
                    </div>

                    <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; align-items: center; gap: 10px;">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        <input type="hidden" name="search" value="{{ $search }}">
                        
                        <div>
                            Rôle: 
                            <select name="role" onchange="this.form.submit()" 
                                style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; background-color: #fff; outline: none; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                                @if($isSellerView)
                                    <option value="vendeur" {{ $role == 'vendeur' ? 'selected' : '' }}>Tous les Vendeurs</option>
                                    <option value="vendeur_pro" {{ $role == 'vendeur_pro' ? 'selected' : '' }}>Vendeur pro</option>
                                    <option value="vendeur_particulier" {{ $role == 'vendeur_particulier' ? 'selected' : '' }}>Vendeur part</option>
                                @else
                                    <option value="" {{ $role == '' ? 'selected' : '' }}>Tous</option>
                                    <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="acheteur" {{ $role == 'acheteur' ? 'selected' : '' }}>Simple</option>
                                    <option value="transporteur" {{ $role == 'transporteur' ? 'selected' : '' }}>Transporteur</option>
                                    <option value="livreur" {{ $role == 'livreur' ? 'selected' : '' }}>Livreur</option>
                                    <option value="point relais" {{ $role == 'point relais' ? 'selected' : '' }}>Relais</option>
                                @endif
                            </select>
                        </div>

                        <div>
                            Pays: 
                            <select name="nationalite" onchange="this.form.submit()" 
                                style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; background-color: #fff; outline: none; cursor: pointer; max-width: 150px; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                                <option value="">Tous les pays</option>
                                @php
                                    $countries = [
                                        'Sénégal' => '🇸🇳', 'Afrique du Sud' => '🇿🇦', 'Algérie' => '🇩🇿', 'Angola' => '🇦🇴', 'Bénin' => '🇧🇯', 
                                        'Burkina Faso' => '🇧🇫', 'Cameroun' => '🇨🇲', 'Congo' => '🇨🇬', "Côte d'Ivoire" => '🇨🇮', 'Égypte' => '🇪🇬',
                                        'Gabon' => '🇬🇦', 'Ghana' => '🇬🇭', 'Guinée' => '🇬🇳', 'Mali' => '🇲🇱', 'Maroc' => '🇲🇦', 
                                        'Mauritanie' => '🇲🇷', 'Niger' => '🇳🇪', 'Nigeria' => '🇳🇬', 'Tchad' => '🇹🇩', 'Togo' => '🇹🇬', 
                                        'Tunisie' => '🇹🇳', 'Française' => '🇫🇷'
                                    ];
                                @endphp
                                @foreach($countries as $name => $flag)
                                    <option value="{{ $name }}" {{ request('nationalite') == $name ? 'selected' : '' }}>
                                        {{ $flag }} {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <div style="font-size: 0.85rem; color: #333;">
                    <form action="{{ route('admin.users.index') }}" method="GET" style="display: flex; align-items: center;">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        <input type="hidden" name="role" value="{{ $role }}">
                        <input type="hidden" name="nationalite" value="{{ request('nationalite') }}">
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
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333; width: 200px;">Utilisateur</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333;">Coordonnées</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: left; font-size: 0.82rem; font-weight: 700; color: #333; width: 120px;">Pays</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.82rem; font-weight: 700; color: #333; width: 120px;">Rôle</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: center; font-size: 0.82rem; font-weight: 700; color: #333; width: 100px;">Statut</th>
                        <th style="padding: 10px; border: 1px solid #eee; text-align: right; font-size: 0.82rem; font-weight: 700; color: #333; width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">
                                <span style="background: #fff7ed; color: #c2410c; padding: 4px 10px; border-radius: 4px; font-weight: 600; font-size: 0.75rem; border: 1px solid #ffedd5;">
                                    {{ $user->prenom }} {{ $user->nom }}
                                </span>
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <span><i class="fas fa-envelope" style="width: 14px; opacity: 0.5;"></i> {{ $user->email }}</span>
                                    <span><i class="fas fa-phone" style="width: 14px; opacity: 0.5;"></i> {{ $user->telephone ?? '-' }}</span>
                                </div>
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; font-size: 0.85rem; color: #555; font-family: inherit;">
                                {{ $user->nationalite ?? '-' }}
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: center;">
                                @php
                                    $roleName = 'Acheteur';
                                    $bgColor = '#f8f9fa';
                                    $textColor = '#666';

                                    if($user->hasRole('admin')) {
                                        $roleName = 'Admin';
                                        $bgColor = '#fef3c7';
                                        $textColor = '#92400e';
                                    } elseif($user->vendeur) {
                                        if($user->vendeur->type === 'professionnel') {
                                            $roleName = 'Vendeur pro';
                                            $bgColor = '#e0e7ff';
                                            $textColor = '#3730a3';
                                        } else {
                                            $roleName = 'Vendeur part';
                                            $bgColor = '#e0f2fe';
                                            $textColor = '#075985';
                                        }
                                    } elseif($user->roles->first()) {
                                        $roleName = ucfirst($user->roles->first()->name);
                                    }
                                @endphp
                                <span style="background-color: {{ $bgColor }}; color: {{ $textColor }}; padding: 3px 10px; border-radius: 4px; font-size: 0.7rem; font-weight: 600; white-space: nowrap; text-transform: uppercase;">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: center;">
                                @if($user->is_active)
                                    <span style="background: #dcfce7; color: #166534; padding: 4px 12px; border-radius: 4px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; white-space: nowrap;">
                                        Actif
                                    </span>
                                @else
                                    <span style="background: #ffedd5; color: #9a3412; padding: 4px 12px; border-radius: 4px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; white-space: nowrap;">
                                        Suspendu
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 10px; border: 1px solid #eee; text-align: right;">
                                <div style="display: flex; gap: 4px; justify-content: flex-end;">

                                    <a href="{{ route('admin.users.edit', $user) }}" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #004aad; color: #fff; border-radius: 3px; font-size: 0.75rem; text-decoration: none;" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form id="suspend-form-{{ $user->id }}" action="{{ route('admin.users.suspend', $user) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="button" onclick="confirmSuspend({{ $user->id }}, {{ $user->is_active ? 'true' : 'false' }})" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: {{ $user->is_active ? '#ca8a04' : '#16a34a' }}; color: #fff; border-radius: 3px; font-size: 0.75rem; border: none; cursor: pointer;" title="{{ $user->is_active ? 'Suspendre' : 'Activer' }}">
                                            <i class="fas fa-{{ $user->is_active ? 'lock' : 'lock-open' }}"></i>
                                        </button>
                                    </form>
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $user->id }})" style="display: flex; align-items: center; justify-content: center; width: 30px; height: 30px; background: #e74c3c; color: #fff; border-radius: 3px; font-size: 0.75rem; border: none; cursor: pointer;" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem;">Aucun utilisateur trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination type image -->
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1rem;">
                <div style="font-size: 0.85rem; color: #666;">
                    Affichage de {{ $users->firstItem() ?? 0 }} à {{ $users->lastItem() ?? 0 }} sur {{ $users->total() }} éléments
                </div>
                <div style="display: flex; gap: 0; border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                    @if($users->onFirstPage())
                        <span style="padding: 6px 12px; background: #fff; color: #ccc; font-size: 0.85rem; border-right: 1px solid #ddd;">Prec</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #ddd;">Prec</a>
                    @endif

                    @foreach(range(1, $users->lastPage()) as $i)
                        @if($i == $users->currentPage())
                            <span style="padding: 6px 12px; background: #e67e00; color: #fff; font-size: 0.85rem; border-right: 1px solid #ddd;">{{ $i }}</span>
                        @else
                            <a href="{{ $users->url($i) }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #ddd;">{{ $i }}</a>
                        @endif
                    @endforeach

                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #333; font-size: 0.85rem; text-decoration: none;">Suiv</a>
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

        function confirmSuspend(id, isActive) {
            const actionText = isActive ? 'suspendre' : 'activer';
            const actionColor = isActive ? '#ea580c' : '#16a34a';
            
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                text: `Voulez-vous vraiment ${actionText} cet utilisateur ?`,
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
