@extends('layouts.admin')

@php
    $isSellerView = in_array($role, ['vendeur', 'vendeur_pro', 'vendeur_particulier']);
    $currentTitle = $isSellerView ? 'Vendeurs' : 'Gestion des Utilisateurs';
@endphp

@section('title', $currentTitle)

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">{{ $currentTitle }}</span>
@endsection

@section('content')
    <div style="max-width: 1200px;">

        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600;">
                {{ $currentTitle }}
            </h1>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.users.create') }}" 
                   style="display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; background-color: #000; color: #fff; border-radius: 8px; transition: all 0.2s;" 
                   title="Nouveau Utilisateur"
                   onmouseover="this.style.opacity='0.8'" 
                   onmouseout="this.style.opacity='1'">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </a>
                <a href="#" 
                   style="display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; background-color: #e11d48; color: #fff; border-radius: 8px; transition: all 0.2s;" 
                   title="Télécharger PDF"
                   onmouseover="this.style.opacity='0.8'" 
                   onmouseout="this.style.opacity='1'">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </a>
            </div>
        </div>



        <!-- Filters Form -->
        <form action="{{ route('admin.users.index') }}" method="GET" style="background: #fff; padding: 1rem; border: 1px solid #e5e5e5; margin-bottom: 1.5rem; display: flex; gap: 1rem; align-items: flex-end; border-radius: 2px;">
            <div style="display: flex; flex-direction: column; gap: 0.5rem; flex: 1;">
                <label for="role" style="font-size: 0.85rem; font-weight: 600; color: #333;">Rôle</label>
                <select name="role" id="role" onchange="this.form.submit()" style="padding: 0.5rem 0.75rem; border: 1px solid #e2e8f0; background-color: #fff; border-radius: 6px; font-size: 0.85rem; color: #334155; font-weight: 500; cursor: pointer; transition: all 0.2s; outline: none;" onfocus="this.style.borderColor='#ff750f'; this.style.boxShadow='0 0 0 3px rgba(255, 117, 15, 0.1)'" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                    @if(in_array($role, ['vendeur', 'vendeur_pro', 'vendeur_particulier']))
                        <option value="vendeur" {{ $role == 'vendeur' ? 'selected' : '' }}>Tous les Vendeurs</option>
                        <option value="vendeur_pro" {{ $role == 'vendeur_pro' ? 'selected' : '' }}>Vendeur pro</option>
                        <option value="vendeur_particulier" {{ $role == 'vendeur_particulier' ? 'selected' : '' }}>Vendeur part</option>
                    @else
                        <option value="" {{ $role == '' ? 'selected' : '' }}>Tous les utilisateurs</option>
                        <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="acheteur" {{ $role == 'acheteur' ? 'selected' : '' }}>Utilisateur Simple</option>
                        <option value="transporteur" {{ $role == 'transporteur' ? 'selected' : '' }}>Transporteur</option>
                        <option value="livreur" {{ $role == 'livreur' ? 'selected' : '' }}>Livreur</option>
                        <option value="point relais" {{ $role == 'point relais' ? 'selected' : '' }}>Point Relais</option>
                    @endif
                </select>
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.5rem; flex: 1;">
                <label for="nationalite" style="font-size: 0.85rem; font-weight: 600; color: #333;">Nationalité</label>
                <select name="nationalite" id="nationalite" onchange="this.form.submit()" style="padding: 0.5rem 0.75rem; border: 1px solid #e2e8f0; background-color: #fff; border-radius: 6px; font-size: 0.85rem; color: #334155; font-weight: 500; cursor: pointer; transition: all 0.2s; outline: none;" onfocus="this.style.borderColor='#ff750f'; this.style.boxShadow='0 0 0 3px rgba(255, 117, 15, 0.1)'" onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                    <option value="">Toutes les nationalités</option>
                    @php
                        $countries = [
                            'Afrique du Sud' => '🇿🇦', 'Algérie' => '🇩🇿', 'Angola' => '🇦🇴', 'Bénin' => '🇧🇯', 'Botswana' => '🇧🇼',
                            'Burkina Faso' => '🇧🇫', 'Burundi' => '🇧🇮', 'Cameroun' => '🇨🇲', 'Cap-Vert' => '🇨🇻', 'Centrafrique' => '🇨🇫',
                            'Comores' => '🇰🇲', 'Congo' => '🇨🇬', "Côte d'Ivoire" => '🇨🇮', 'Djibouti' => '🇩🇯', 'Égypte' => '🇪🇬',
                            'Érythrée' => '🇪🇷', 'Eswatini' => '🇸🇿', 'Éthiopie' => '🇪🇹', 'Gabon' => '🇬🇦', 'Gambie' => '🇬🇲',
                            'Ghana' => '🇬🇭', 'Guinée' => '🇬🇳', 'Guinée-Bissau' => '🇬🇼', 'Guinée équatoriale' => '🇬🇶', 'Kenya' => '🇰🇪',
                            'Lesotho' => '🇱🇸', 'Liberia' => '🇱🇷', 'Libye' => '🇱🇾', 'Madagascar' => '🇲🇬', 'Malawi' => '🇲🇼',
                            'Mali' => '🇲🇱', 'Maroc' => '🇲🇦', 'Maurice' => '🇲🇺', 'Mauritanie' => '🇲🇷', 'Mozambique' => '🇲🇿',
                            'Namibie' => '🇳🇦', 'Niger' => '🇳🇪', 'Nigeria' => '🇳🇬', 'Ouganda' => '🇺🇬', 'République Démocratique du Congo' => '🇨🇩',
                            'Rwanda' => '🇷🇼', 'Sao Tomé-et-Principe' => '🇸🇹', 'Sénégal' => '🇸🇳', 'Seychelles' => '🇸🇨', 'Sierra Leone' => '🇸🇱',
                            'Somalie' => '🇸🇴', 'Soudan' => '🇸🇩', 'Soudan du Sud' => '🇸🇸', 'Tanzanie' => '🇹🇿', 'Tchad' => '🇹🇩',
                            'Togo' => '🇹🇬', 'Tunisie' => '🇹🇳', 'Zambie' => '🇿🇲', 'Zimbabwe' => '🇿🇼', 'Française' => '🇫🇷'
                        ];
                    @endphp
                    @foreach($countries as $name => $flag)
                        <option value="{{ $name }}" {{ request('nationalite') == $name ? 'selected' : '' }}>
                            {{ $flag }} {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>



            @if(request()->anyFilled(['role', 'nationalite']))
                <a href="{{ route('admin.users.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.8rem; padding: 0.5rem 0.5rem; transition: all 0.2s; display: inline-flex; height: 38px; align-items: center; justify-content: center; font-weight: 500;" onmouseover="this.style.color='#1e293b'; this.style.textDecoration='underline'" onmouseout="this.style.color='#64748b'; this.style.textDecoration='none'">
                    Effacer les filtres
                </a>
            @endif
        </form>

        <!-- Table Container -->
        <div style="background: #fff; border: 1px solid #e5e5e5;">

            <!-- Table Header -->
            <div style="padding: 0.875rem 1.25rem; border-bottom: 1px solid #e5e5e5;">
                <span style="font-size: 0.8rem; color: #666;">{{ $users->total() }} utilisateur(s)</span>
            </div>

            <!-- Table -->
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left;">
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Infos</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Téléphone</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Email</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Nationalité</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Rôle</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5;">Statut</th>
                        <th style="padding: 0.75rem 1.25rem; font-size: 0.75rem; font-weight: 600; color: #64748b; border-bottom: 1px solid #e5e5e5; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="border-bottom: 1px solid #e5e5e5;">
                            <td style="padding: 0.875rem 1.25rem;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div>
                                        <div style="font-size: 0.875rem; color: #333; font-weight: 500;">
                                            {{ $user->prenom }} {{ $user->nom }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: #666;">
                                {{ $user->telephone ?? '-' }}
                            </td>
                            <td style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: #666;">
                                {{ $user->email }}
                            </td>
                            <td style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: #666;">
                                {{ $user->nationalite ?? '-' }}
                            </td>
                            <td style="padding: 0.875rem 1.25rem; font-size: 0.85rem; color: #666;">
                                @php
                                    $roleName = 'Utilisateur';
                                    $bgColor = '#fee2e2';
                                    $textColor = '#991b1b';

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
                                <span style="background-color: {{ $bgColor }}; color: {{ $textColor }}; padding: 3px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; white-space: nowrap;">
                                    {{ $roleName }}
                                </span>
                            </td>
                            <td style="padding: 0.875rem 1.25rem; font-size: 0.85rem;">
                                @if($user->is_active)
                                    <span style="color: #16a34a; font-weight: 600; font-size: 0.75rem;">
                                        Actif
                                    </span>
                                @else
                                    <span style="color: #ca8a04; font-weight: 600; font-size: 0.75rem;">
                                        Suspendu
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 0.875rem 1.25rem; text-align: right; display: flex; justify-content: flex-end; gap: 4px;">
                                @if($user->vendeur)
                                    <a href="{{ route('admin.vendeurs.verification.show', $user->vendeur) }}" 
                                       style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #1e293b; background: #f1f5f9; border-radius: 8px; transition: all 0.2s;" 
                                       title="Afficher les informations vendeur"
                                       onmouseover="this.style.background='#e2e8f0'; this.style.opacity='0.8'" 
                                       onmouseout="this.style.background='#f1f5f9'; this.style.opacity='1'">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </a>
                                @endif

                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #004aad; background: #eef2ff; border-radius: 8px; transition: all 0.2s;" 
                                   title="Modifier"
                                   onmouseover="this.style.background='#e0e7ff'; this.style.opacity='0.8'" 
                                   onmouseout="this.style.background='#eef2ff'; this.style.opacity='1'">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                
                                <form action="{{ route('admin.users.suspend', $user) }}" method="POST" style="display:inline;" class="suspend-form" data-confirm-title="Voulez-vous {{ $user->is_active ? 'suspendre' : 'activer' }} cet utilisateur ?">
                                    @csrf @method('PATCH')
                                    <button type="submit" 
                                            style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: {{ $user->is_active ? '#ca8a04' : '#16a34a' }}; background: {{ $user->is_active ? '#fefce8' : '#f0fdf4' }}; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s;" 
                                            title="{{ $user->is_active ? 'Suspendre' : 'Activer' }}"
                                            onmouseover="this.style.opacity='0.8'" 
                                            onmouseout="this.style.opacity='1'">
                                        @if($user->is_active)
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-width="2"></rect>
                                                <path d="M7 11V7a5 5 0 0110 0v4" stroke-width="2"></path>
                                            </svg>
                                        @else
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke-width="2"></rect>
                                                <path d="M7 11V7a5 5 0 019.9-1" stroke-width="2"></path>
                                            </svg>
                                        @endif
                                    </button>
                                </form>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; color: #ef4444; background: #fff1f2; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s;" 
                                            title="Supprimer"
                                            onmouseover="this.style.background='#ffe4e6'; this.style.transform='scale(1.05)'" 
                                            onmouseout="this.style.background='#fff1f2'; this.style.transform='scale(1)'">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7"
                                style="padding: 3rem 1.25rem; text-align: center; color: #999; font-size: 0.875rem;">
                                Aucun utilisateur trouvé
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div style="padding: 1rem; border-top: 1px solid #e5e5e5;">
                {{ $users->links('admin.pagination') }}
            </div>
        </div>
    </div>
@endsection
