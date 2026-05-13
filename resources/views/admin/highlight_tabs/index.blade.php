@extends('layouts.admin')

@section('title', 'Gestion des Onglets - Actualités')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    .sub-header-slot { display: none !important; }
    select:focus, input:focus {
        border-color: #adb1b8 !important;
        
        outline: none;
    }
</style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
<div style="max-width: 100%; margin-top: -1px;">

    {{-- Main Conteneur style Amazon Card --}}
    <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                Gestion des Onglets
            </h1>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.highlights.index') }}"
                   style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-arrow-left" style="font-size: 0.75rem; opacity: 0.6;"></i> Retour aux Actualités
                </a>
                <a href="{{ route('admin.highlight-tabs.create') }}"
                   style="background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); border: 1px solid #004aad; color: #fff; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.4) inset; display: flex; align-items: center; gap: 6px;">
                    Nouveau groupe
                </a>
            </div>
        </div>

        {{-- Barre de filtre --}}
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px 16px; border-radius: 0; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555;">
                <span>Afficher</span>
                <select name="per_page" onchange="window.location.href = '{{ route('admin.highlight-tabs.index') }}?per_page=' + this.value + '&search={{ request('search') }}'"
                    style="padding: 4px 6px; border: 1px solid #adb1b8; border-radius: 0; background: #f0f2f2; font-size: 0.8rem; color: #111; cursor: pointer; outline: none;">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
                <span>résultats par page</span>
            </div>

            <div style="font-size: 0.8rem;">
                <form action="{{ route('admin.highlight-tabs.index') }}" method="GET" style="display: flex; align-items: center; gap: 8px;">
                    <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">
                    <span style="color: #555;">Rechercher :</span>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Nom de l'onglet..."
                           style="padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; outline: none; width: 220px; font-size: 0.8rem;">
                </form>
            </div>
        </div>

        {{-- Table Amazon Design --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
            <thead>
                <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 80px;">Ordre</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Nom de l'onglet</th>
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 100px;">Statut</th>
                    <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tabs as $tab)
                    <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px 15px; text-align: center; font-size: 0.85rem; font-weight: 700; color: #555; border-right: 1px solid #e7e7e7;">
                            {{ $tab->position }}
                        </td>
                        <td style="padding: 12px 15px; font-size: 0.85rem; color: #111; font-weight: 500; border-right: 1px solid #e7e7e7;">
                            {{ $tab->name }}
                        </td>
                        <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                            @if($tab->active)
                                <span style="font-size: 0.75rem; color: #569b00; font-weight: 600;">Actif</span>
                            @else
                                <span style="font-size: 0.75rem; color: #c40000; font-weight: 600;">Désactivé</span>
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
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                            Aucun onglet configuré.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination Info & Links Harmonisée --}}
        @if($tabs->total() > 0)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-top: 10px;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                    Affichage de {{ $tabs->firstItem() ?? 0 }} à {{ $tabs->lastItem() ?? 0 }} sur {{ $tabs->total() }} résultats
                </div>
                <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                    @if($tabs->onFirstPage())
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                    @else
                        <a href="{{ $tabs->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                    @endif

                    @php
                        $pStart = max(1, $tabs->currentPage() - 2);
                        $pEnd = min($tabs->lastPage(), $pStart + 4);
                    @endphp

                    @for($i = $pStart; $i <= $pEnd; $i++)
                        @if($i == $tabs->currentPage())
                            <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #004aad;">{{ $i }}</span>
                        @else
                            <a href="{{ $tabs->url($i) }}" style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($tabs->hasMorePages())
                        <a href="{{ $tabs->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                    @else
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
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
