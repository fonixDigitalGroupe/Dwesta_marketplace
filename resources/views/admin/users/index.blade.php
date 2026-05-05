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
        border-color: #adb1b8 !important;
        box-shadow: 0 0 3px rgba(225,121,9,0.5) !important;
        outline: none;
    }
    .filter-label { font-size: 0.8rem; color: #555; font-weight: 500; margin-bottom: 4px; display: block; }
    .filter-select { padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; background: #fff; font-size: 0.85rem; color: #111; outline: none; cursor: pointer; }
</style>
@endpush

@section('content')
    <div style="max-width: 100%;">
        <!-- Main Conteneur style Amazon Card -->
        <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                    {{ $currentTitle }}
                </h1>
                
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.users.create') }}" 
                       style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.4) inset; display: flex; align-items: center; gap: 6px;">
                        Nouveau compte
                    </a>
                    <a href="javascript:window.print()" 
                       style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                        Imprimer
                    </a>
                </div>
            </div>

            <!-- Barre de filtres grise -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px 20px; border-radius: 0; margin-bottom: 20px;">
                <form action="{{ route('admin.users.index') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)) 250px; gap: 20px; align-items: end;">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                    
                    <div>
                        <label class="filter-label">Filtrer par Rôle</label>
                        <select name="role" onchange="this.form.submit()" class="filter-select" style="width: 100%;">
                            @if($isSellerView)
                                <option value="vendeur" {{ $role == 'vendeur' ? 'selected' : '' }}>Tous les Vendeurs</option>
                                <option value="vendeur_pro" {{ $role == 'vendeur_pro' ? 'selected' : '' }}>Vendeur pro</option>
                                <option value="vendeur_particulier" {{ $role == 'vendeur_particulier' ? 'selected' : '' }}>Vendeur part</option>
                            @else
                                <option value="" {{ $role == '' ? 'selected' : '' }}>Tous les utilisateurs</option>
                                <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Administrateurs</option>
                                <option value="acheteur" {{ $role == 'acheteur' ? 'selected' : '' }}>Acheteurs simples</option>
                                <option value="transporteur" {{ $role == 'transporteur' ? 'selected' : '' }}>Transporteurs</option>
                                <option value="livreur" {{ $role == 'livreur' ? 'selected' : '' }}>Livreurs</option>
                                <option value="point relais" {{ $role == 'point relais' ? 'selected' : '' }}>Points Relais</option>
                            @endif
                        </select>
                    </div>

                    <div>
                        <label class="filter-label">Nationalité / Pays</label>
                        <select name="nationalite" onchange="this.form.submit()" class="filter-select" style="width: 100%;">
                            <option value="">Tous les pays</option>
                            @php
                                $countriesList = [
                                    'Sénégal' => '🇸🇳', 'Afrique du Sud' => '🇿🇦', 'Algérie' => '🇩🇿', 'Angola' => '🇦🇴', 'Bénin' => '🇧🇯', 
                                    'Burkina Faso' => '🇧🇫', 'Cameroun' => '🇨🇲', 'Congo' => '🇨🇬', "Côte d'Ivoire" => '🇨🇮', 'Égypte' => '🇪🇬',
                                    'Gabon' => '🇬🇦', 'Ghana' => '🇬🇭', 'Guinée' => '🇬🇳', 'Mali' => '🇲🇱', 'Maroc' => '🇲🇦', 
                                    'Mauritanie' => '🇲🇷', 'Niger' => '🇳🇪', 'Nigeria' => '🇳🇬', 'Tchad' => '🇹🇩', 'Togo' => '🇹🇬', 
                                    'Tunisie' => '🇹🇳', 'Française' => '🇫🇷'
                                ];
                            @endphp
                            @foreach($countriesList as $name => $flag)
                                <option value="{{ $name }}" {{ request('nationalite') == $name ? 'selected' : '' }}>
                                    {{ $flag }} {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display: flex; flex-direction: column;">
                        <label class="filter-label">Recherche</label>
                        <input type="text" name="search" value="{{ $search }}" 
                            placeholder="Nom, email, téléphone..."
                            style="padding: 6px 12px; border: 1px solid #adb1b8; border-radius: 0; outline: none; font-size: 0.85rem;">
                    </div>
                </form>
            </div>

            <!-- Pagination density info -->
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555; margin-bottom: 15px;">
                <span>Afficher</span>
                <select onchange="window.location.href = '{{ route('admin.users.index') }}?per_page=' + this.value + '&role={{ $role }}&nationalite={{ request('nationalite') }}&search={{ $search }}'" 
                    style="padding: 3px 6px; border: 1px solid #adb1b8; border-radius: 0; background: #f0f2f2; font-size: 0.8rem; color: #111; cursor: pointer; outline: none;">
                    <option value="8" {{ $perPage == 8 ? 'selected' : '' }}>8</option>
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>résultats par page</span>
            </div>

            <!-- Table Amazon Design -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Prénom / Nom</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Email / Tel</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Pays</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 140px;">Rôle</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 100px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #0066c0; font-weight: 500; border-right: 1px solid #e7e7e7;">
                                {{ $user->prenom }} {{ $user->nom }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                <div style="display: flex; flex-direction: column; gap: 2px;">
                                    <span>{{ $user->email }}</span>
                                    <span style="font-size: 0.75rem; color: #888;">{{ $user->telephone ?? '-' }}</span>
                                </div>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                {{ $user->nationalite ?? '-' }}
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                @php
                                    $roleName = 'Acheteur';
                                    $textColor = '#555';

                                    if($user->hasRole('admin')) {
                                        $roleName = 'Admin';
                                        $textColor = '#c45500';
                                    } elseif($user->vendeur) {
                                        if($user->vendeur->type === 'professionnel') {
                                            $roleName = 'Vendeur Pro';
                                            $textColor = '#0066c0';
                                        } else {
                                            $roleName = 'Vendeur Part';
                                            $textColor = '#007185';
                                        }
                                    } elseif($user->roles->first()) {
                                        $roleName = ucfirst($user->roles->first()->name);
                                    }
                                @endphp
                                <span style="font-size: 0.75rem; color: {{ $textColor }}; font-weight: 700; text-transform: uppercase;">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                @if($user->is_active)
                                    <span style="font-size: 0.75rem; color: #569b00; font-weight: 600;">Actif</span>
                                @else
                                    <span style="font-size: 0.75rem; color: #c40000; font-weight: 600;">Suspendu</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                       onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'" 
                                       onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                       Modifier
                                    </a>
                                    <span style="color: #ddd;">|</span>
                                    <form action="{{ route('admin.users.suspend', $user) }}" method="POST" style="display:inline;">
                                        @csrf @method('PATCH')
                                        <button type="submit" 
                                                style="background: none; border: none; color: #0066c0; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                                onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'" 
                                                onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                            {{ $user->is_active ? 'Suspendre' : 'Activer' }}
                                        </button>
                                    </form>
                                    <span style="color: #ddd;">|</span>
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $user->id }})" 
                                                style="background: none; border: none; color: #c40000; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                                onmouseover="this.style.textDecoration='underline'" 
                                                onmouseout="this.style.color='#c40000'; this.style.textDecoration='none'">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem;">
                                Aucun utilisateur trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Info & Links Harmonisée -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-top: 10px;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                    Affichage de {{ $users->firstItem() ?? 0 }} à {{ $users->lastItem() ?? 0 }} sur {{ $users->total() }} résultats
                </div>
                <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                    @if($users->onFirstPage())
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                    @endif

                    @php
                        $startPage = max(1, $users->currentPage() - 2);
                        $endPage = min($users->lastPage(), $startPage + 4);
                    @endphp

                    @for($i = $startPage; $i <= $endPage; $i++)
                        @if($i == $users->currentPage())
                            <span style="padding: 6px 12px; background: linear-gradient(to bottom, #f7dfa5, #f0c14b); color: #111; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #a88734;">{{ $i }}</span>
                        @else
                            <a href="{{ $users->url($i) }}" style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
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
                borderRadius: '0'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
    @endpush
@endsection
