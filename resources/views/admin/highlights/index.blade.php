@extends('layouts.admin')

@section('title', 'Gestion des Actualités')

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
                <i class="fas fa-newspaper" style="font-size: 0.8rem;"></i>
                <span style="line-height: 1;">Gestion des Actualités</span>
            </div>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.highlights.create') }}" class="btn-amazon-primary">
                    <i class="fas fa-plus"></i> Créer une actualité
                </a>
                <a href="{{ route('admin.highlight-tabs.index') }}" class="btn-amazon-orange">
                    <i class="fas fa-layer-group"></i> Gérer les Onglets
                </a>
            </div>
        </div>

        {{-- Barre de filtre / recherche --}}
        <div style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; border-radius: 4px; margin-bottom: 20px; display: flex; justify-content: flex-end; align-items: center; gap: 16px;">
            {{-- Filtre onglet + recherche --}}
            <form id="filter-form" action="{{ route('admin.highlights.index') }}" method="GET"
                  style="display: flex; align-items: center; gap: 10px; font-size: 0.8rem;">

                {{-- Filtre par onglet --}}
                <span style="color: #555; flex-shrink: 0;">Onglet :</span>
                <select name="tab" onchange="this.form.submit()"
                    style="padding: 6px 10px; border: 1px solid #dee2e6; border-radius: 4px; background: #fff; font-size: 0.8rem; color: #475569; cursor: pointer; outline: none; min-width: 140px;">
                    <option value="">— Tous —</option>
                    @foreach($tabs as $tabId => $tabName)
                        <option value="{{ $tabId }}" {{ request('tab') == $tabId ? 'selected' : '' }}>
                            {{ $tabName }}
                        </option>
                    @endforeach
                </select>

                <div style="display: flex; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff;">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Titre, sous-titre..."
                           style="padding: 8px 12px; border: none; outline: none; width: 200px; font-size: 0.85rem; background: transparent;">
                    <button type="submit"
                        style="background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border: none; color: #fff; padding: 0 16px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                @php $firstTabId = array_key_first($tabs); @endphp
                @if(request('search') || (request('tab') && request('tab') != $firstTabId))
                    <a href="{{ route('admin.highlights.index') }}"
                       style="color: #0066c0; font-size: 0.85rem; text-decoration: none; white-space: nowrap;"
                       onmouseover="this.style.textDecoration='underline'"
                       onmouseout="this.style.textDecoration='none'">Effacer</a>
                @endif
            </form>
        </div>

        {{-- Table Amazon Design --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #eff3f6;">
            <thead>
                <tr style="background: #f6f6f6; border-bottom: 1px solid #eff3f6;">
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 60px;">Ordre</th>
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 65px;">Image</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Détails de l'actualité</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 150px;">Onglet parent</th>
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 90px;">Statut</th>
                    <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 175px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($highlights as $highlight)
                    <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                        onmouseover="this.style.background='#f9f9f9'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px 15px; text-align: center; font-size: 0.85rem; font-weight: 700; color: #555; border-right: 1px solid #eff3f6;">
                            {{ $highlight->position }}
                        </td>
                        <td style="padding: 8px; text-align: center; border-right: 1px solid #eff3f6;">
                            <img src="{{ $highlight->image_url }}"
                                 style="width: 42px; height: 42px; object-fit: cover; border: 1px solid #ddd; background: #fff;">
                        </td>
                        <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                            <div style="font-weight: 600; color: #111; font-size: 0.85rem;">{{ $highlight->title }}</div>
                            @if($highlight->subtitle)
                                <div style="font-size: 0.75rem; color: #777; margin-top: 2px;">{{ $highlight->subtitle }}</div>
                            @endif
                            @if($highlight->link_url)
                                <div style="font-size: 0.7rem; color: #0066c0; margin-top: 4px;">{{ Str::limit($highlight->link_url, 50) }}</div>
                            @endif
                        </td>
                        <td style="padding: 12px 15px; font-size: 0.8rem; color: #444; border-right: 1px solid #eff3f6;">
                            {{ $highlight->highlightTab->name ?? 'Aucun' }}
                        </td>
                        <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                            @if($highlight->active)
                                <span class="badge-amazon badge-amazon-success">Visible</span>
                            @else
                                <span class="badge-amazon badge-amazon-danger">Masquée</span>
                            @endif
                        </td>
                        <td style="padding: 12px 15px; text-align: right;">
                            <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                <a href="{{ route('admin.highlights.edit', $highlight) }}"
                                   style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                   onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'"
                                   onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                    Modifier
                                </a>
                                <span style="color: #ddd;">|</span>
                                <form id="toggle-form-{{ $highlight->id }}"
                                      action="{{ route('admin.highlights.toggle-status', $highlight) }}"
                                      method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="button"
                                            onclick="confirmToggle({{ $highlight->id }}, {{ $highlight->active ? 'true' : 'false' }})"
                                            style="background: none; border: none; color: #0066c0; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                            onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'"
                                            onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                        {{ $highlight->active ? 'Masquer' : 'Afficher' }}
                                    </button>
                                </form>
                                <span style="color: #ddd;">|</span>
                                <form id="delete-form-{{ $highlight->id }}"
                                      action="{{ route('admin.highlights.destroy', $highlight) }}"
                                      method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            onclick="confirmDelete({{ $highlight->id }})"
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
                        <td colspan="6" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                            Aucune actualité trouvée.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($highlights->hasPages())
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px; margin-top: 20px;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                    Affichage de {{ $highlights->firstItem() ?? 0 }} à {{ $highlights->lastItem() ?? 0 }} sur {{ $highlights->total() }} résultats
                </div>
                <div style="display: flex; gap: 6px; align-items: center;">
                    @if($highlights->onFirstPage())
                        <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                    @else
                        <a href="{{ $highlights->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;">Précédent</a>
                    @endif

                    @php
                        $pStart = max(1, $highlights->currentPage() - 2);
                        $pEnd   = min($highlights->lastPage(), $pStart + 4);
                    @endphp

                    @for($i = $pStart; $i <= $pEnd; $i++)
                        @if($i == $highlights->currentPage())
                            <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border: 1px solid #1e40af; border-radius: 4px;">{{ $i }}</span>
                        @else
                            <a href="{{ $highlights->url($i) }}" style="padding: 6px 12px; background: #fff; color: #64748b; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($highlights->hasMorePages())
                        <a href="{{ $highlights->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;">Suivant</a>
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
    function confirmToggle(id, isActive) {
        const actionText = isActive ? 'masquer' : 'afficher';
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: `Voulez-vous vraiment ${actionText} cette actualité ?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e67e00',
            cancelButtonColor: '#d33',
            confirmButtonText: `Oui, ${actionText} !`,
            cancelButtonText: 'Annuler',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('toggle-form-' + id).submit();
            }
        });
    }

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
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endpush
@endsection
