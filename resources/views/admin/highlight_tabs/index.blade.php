@extends('layouts.admin')

@section('title', 'Gestion des Onglets - Actualités')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    .sub-header-slot { display: none !important; }

    .btn-amazon-primary {
        background: linear-gradient(180deg, #007bff 0%, #0056b3 100%);
        border: 1px solid #1e40af;
        color: #fff;
        padding: 6px 14px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .btn-amazon-primary:hover {
        background: linear-gradient(180deg, #1d4ed8 0%, #1e3a8a 100%);
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        color: #fff;
    }

    .btn-amazon-secondary {
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 6px 14px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .btn-amazon-secondary:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #1e293b;
    }

    .btn-amazon-orange {
        background: linear-gradient(180deg, #ff9900 0%, #e77600 100%);
        border: 1px solid #c05d00;
        color: #fff;
        padding: 6px 14px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .btn-amazon-orange:hover {
        background: linear-gradient(180deg, #f08804 0%, #d87300 100%);
        color: #fff;
    }

    .badge-amazon { font-size: 0.75rem; font-weight: 600; padding: 2px 8px; border-radius: 12px; }
    .badge-amazon-success { color: #569b00; background: #f7fff0; }
    .badge-amazon-danger { color: #c40000; background: #fff5f5; }

    select:focus, input:focus {
        border-color: #ff9900 !important;
        outline: none;
    }
</style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
<div style="max-width: 1600px; margin: 20px auto 0; width: 100%;">

    {{-- Main Card --}}
    <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

        {{-- Card Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-layer-group" style="font-size: 0.8rem;"></i>
                <span style="line-height: 1;">Gestion des Onglets</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.highlights.index') }}" class="btn-amazon-secondary">
                    <i class="fas fa-arrow-left"></i> Retour aux Actualités
                </a>
                <a href="{{ route('admin.highlight-tabs.create') }}" class="btn-amazon-orange">
                    <i class="fas fa-plus"></i> Nouveau groupe
                </a>
            </div>
        </div>

        {{-- Barre de filtre / recherche --}}
        <div style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; border-radius: 4px; margin-bottom: 20px; display: flex; align-items: center;">
            <form action="{{ route('admin.highlight-tabs.index') }}" method="GET" style="display: flex; align-items: center; gap: 10px; font-size: 0.8rem; width: 100%;">
                <span style="color: #555; flex-shrink: 0;">Rechercher :</span>
                <div style="display: flex; flex: 1; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff;">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nom de l'onglet..."
                           style="padding: 8px 12px; border: none; outline: none; flex: 1; width: auto; font-size: 0.85rem; background: transparent;">
                    <button type="submit"
                        style="background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border: none; color: #fff; padding: 0 18px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.highlight-tabs.index') }}"
                       style="color: #0066c0; font-size: 0.85rem; text-decoration: none; white-space: nowrap; flex-shrink: 0;"
                       onmouseover="this.style.textDecoration='underline'"
                       onmouseout="this.style.textDecoration='none'">Effacer</a>
                @endif
            </form>
        </div>

        {{-- Table --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #eff3f6;">
            <thead>
                <tr style="background: #f6f6f6; border-bottom: 1px solid #eff3f6;">
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 80px;">Ordre</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Nom de l'onglet</th>
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Statut</th>
                    <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tabs as $tab)
                    <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px 15px; text-align: center; font-size: 0.85rem; font-weight: 700; color: #555; border-right: 1px solid #eff3f6;">
                            {{ $tab->position }}
                        </td>
                        <td style="padding: 12px 15px; font-size: 0.85rem; color: #111; font-weight: 500; border-right: 1px solid #eff3f6;">
                            {{ $tab->name }}
                        </td>
                        <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                            @if($tab->active)
                                <span class="badge-amazon badge-amazon-success">Actif</span>
                            @else
                                <span class="badge-amazon badge-amazon-danger">Désactivé</span>
                            @endif
                        </td>
                        <td style="padding: 12px 15px; text-align: right;">
                            <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                <a href="{{ route('admin.highlight-tabs.edit', $tab) }}"
                                   style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                   onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'"
                                   onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                   Modifier
                                </a>
                                <span style="color: #ddd;">|</span>
                                <form id="delete-tab-{{ $tab->id }}" action="{{ route('admin.highlight-tabs.destroy', $tab) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDeleteTab({{ $tab->id }})"
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
                        <td colspan="4" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                            Aucun onglet configuré.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($tabs->hasPages())
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px; margin-top: 20px;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                    Affichage de {{ $tabs->firstItem() ?? 0 }} à {{ $tabs->lastItem() ?? 0 }} sur {{ $tabs->total() }} résultats
                </div>
                <div style="display: flex; gap: 6px; align-items: center;">
                    @if($tabs->onFirstPage())
                        <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                    @else
                        <a href="{{ $tabs->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;">Précédent</a>
                    @endif

                    @php
                        $pStart = max(1, $tabs->currentPage() - 2);
                        $pEnd = min($tabs->lastPage(), $pStart + 4);
                    @endphp

                    @for($i = $pStart; $i <= $pEnd; $i++)
                        @if($i == $tabs->currentPage())
                            <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border: 1px solid #1e40af; border-radius: 4px;">{{ $i }}</span>
                        @else
                            <a href="{{ $tabs->url($i) }}" style="padding: 6px 12px; background: #fff; color: #64748b; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($tabs->hasMorePages())
                        <a href="{{ $tabs->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;">Suivant</a>
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
    function confirmDeleteTab(id) {
        Swal.fire({
            title: 'Supprimer cet onglet ?',
            text: "Attention : si cet onglet contient des actualités, la suppression sera bloquée.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e67e00',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-tab-' + id).submit();
            }
        });
    }
</script>
@endpush
@endsection
