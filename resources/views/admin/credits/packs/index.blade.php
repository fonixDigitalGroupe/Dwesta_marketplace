@extends('layouts.admin')

@section('title', 'Gestion des Packs de Crédits')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }

    /* Forms Select/Inputs */
    select, input[type="text"] {
        outline: none;
        transition: all 0.2s;
    }

    select:focus, input[type="text"]:focus {
        border-color: #ff9900 !important;
        box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15) !important;
    }

    /* Buttons Alignés avec Settings/Users */
    .btn-amazon-primary {
        background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: #fff !important;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 0.78rem;
        font-weight: 600;
        letter-spacing: 0.03em;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-amazon-primary:hover {
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        color: #fff !important;
    }

    .btn-amazon-secondary {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569 !important;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 0.78rem;
        font-weight: 500;
        letter-spacing: 0.03em;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-amazon-secondary:hover {
        background: #f8fafc;
        border-color: #dee2e6;
        color: #1e293b !important;
    }

    .btn-amazon-disabled {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #94a3b8;
        padding: 8px 16px;
        border-radius: 4px;
        font-size: 0.78rem;
        font-weight: 500;
        letter-spacing: 0.03em;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: not-allowed;
    }

    /* Badges alignés avec Categories */
    .badge-amazon {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
    }

    .badge-amazon-success {
        color: #569b00;
        background: #f7fff0;
    }

    .badge-amazon-danger {
        color: #c40000;
        background: #fff5f5;
    }

    /* Table Hover overrides */
    tbody tr:hover {
        background-color: #f8fafc !important;
    }
</style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
    <div style="max-width: 1600px; margin: 0 auto;">

        <!-- Main Conteneur style Amazon Card -->
        <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                        <i class="fas fa-boxes" style="font-size: 0.8rem;"></i>
                        <span>Gestion des Packs de Crédits</span>
                    </div>
                </div>
                
                <div style="display: flex; gap: 12px;">
                    @if(\App\Models\CreditPack::count() >= 3)
                        <span title="Limite de 3 packs atteinte" class="btn-amazon-disabled" style="height: 32px !important; padding: 0 16px !important;">
                            <i class="fas fa-plus"></i> Nouveau pack
                        </span>
                    @else
                        <a href="{{ route('admin.credits.packs.create') }}" class="btn-amazon-primary" style="height: 32px !important; padding: 0 16px !important;">
                            <i class="fas fa-plus"></i> Nouveau pack
                        </a>
                    @endif
                </div>
            </div>

            <!-- Barre de filtre modernisée -->
            <div class="filters-bar"
                style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; border-radius: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
                <form action="{{ route('admin.credits.packs') }}" method="GET" style="display: flex; align-items: center; flex: 1; position: relative;">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                    <div style="display: flex; width: 100%; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff; transition: all 0.2s;" id="search-container">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher un pack par nom..."
                            style="padding: 10px 16px; border: none; outline: none; flex: 1; font-size: 0.9rem; background: transparent;"
                            onfocus="document.getElementById('search-container').style.borderColor='#ff9900'; document.getElementById('search-container').style.boxShadow='0 0 0 3px rgba(255, 153, 0, 0.15)'"
                            onblur="document.getElementById('search-container').style.borderColor='#dee2e6'; document.getElementById('search-container').style.boxShadow='none'">
                        
                        <button type="submit" 
                            style="background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border: none; color: #fff; padding: 0 22px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;"
                            onmouseover="this.style.background='linear-gradient(180deg, #f08804 0%, #d87300 100%)'"
                            onmouseout="this.style.background='linear-gradient(180deg, #ff9900 0%, #e77600 100%)'">
                            <i class="fas fa-search" style="font-size: 1.1rem; text-shadow: 0 1px 1px rgba(0,0,0,0.1);"></i>
                        </button>
                    </div>
                    
                    @if(request('search'))
                        <a href="{{ route('admin.credits.packs') }}" 
                           style="margin-left: 15px; color: #0066c0; font-size: 0.85rem; text-decoration: none; white-space: nowrap;"
                           onmouseover="this.style.textDecoration='underline'"
                           onmouseout="this.style.textDecoration='none'">
                           Effacer
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table Amazon Design -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Nom du Pack</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Description</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 140px;">Crédits</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 120px;">Prix</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($packs as $pack)
                        <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.8rem; border-right: 1px solid #eff3f6;">
                                <span style="color: #0066c0; font-weight: 700;">{{ ucfirst($pack->nom) }}</span>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; color: #555; border-right: 1px solid #eff3f6;">{{ Str::limit($pack->description, 60) }}</td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; color: #111; text-align: center; border-right: 1px solid #eff3f6;">
                                <span style="font-weight: 700;">{{ $pack->credits }}</span>
                                @if($pack->bonus_credits > 0)
                                    <br><span style="color: #ed8936; font-size: 0.72rem; font-weight: 600;">+ {{ $pack->bonus_credits }} bonus</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                <span class="badge-amazon {{ $pack->actif ? 'badge-amazon-success' : 'badge-amazon-danger' }}">
                                    {{ $pack->actif ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; color: #111; font-weight: 700; text-align: center; border-right: 1px solid #eff3f6;">
                                {{ number_format($pack->prix, 0, ',', ' ') }} F
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.credits.packs.edit', $pack) }}" title="Modifier"
                                       style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 6px; color: #111; text-decoration: none; transition: background 0.2s;"
                                       onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='transparent'"><i class="fas fa-pen-to-square" style="font-size: 0.95rem;"></i></a>
                                    <form id="delete-form-{{ $pack->id }}" action="{{ route('admin.credits.packs.destroy', $pack) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer ce pack ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" title="Supprimer"
                                                style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 6px; background: none; border: none; color: #c40000; cursor: pointer; transition: background 0.2s;"
                                                onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='transparent'"><i class="fas fa-trash" style="font-size: 0.9rem;"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                                Aucune catégorie trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Info & Links -->
            @if($packs->total() > 0)
                <div class="pagination-container"
                    style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px; margin-top: 20px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        <strong>{{ $packs->total() }}</strong> lignes
                    </div>
                    <div style="display: flex; gap: 4px;">
                        @if($packs->onFirstPage())
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                        @else
                            <a href="{{ $packs->previousPageUrl() }}"
                                style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">Précédent</a>
                        @endif

                        @foreach(range(max(1, $packs->currentPage() - 2), min($packs->lastPage(), $packs->currentPage() + 2)) as $i)
                            @if($i == $packs->currentPage())
                                <span style="padding: 6px 12px; background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border: 1px solid #1d4ed8; border-radius: 4px;">{{ $i }}</span>
                            @else
                                <a href="{{ $packs->url($i) }}"
                                    style="padding: 6px 12px; background: #fff; color: #64748b; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                    onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                    onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">{{ $i }}</a>
                            @endif
                        @endforeach

                        @if($packs->hasMorePages())
                            <a href="{{ $packs->nextPageUrl() }}"
                                style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px; transition: all 0.2s;"
                                onmouseover="this.style.borderColor='#dee2e6'; this.style.background='#f8fafc'"
                                onmouseout="this.style.borderColor='#eff3f6'; this.style.background='#fff'">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Suivant</span>
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
                borderRadius: '4px'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
    @endpush
@endsection
