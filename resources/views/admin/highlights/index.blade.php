@extends('layouts.admin')

@section('title', 'Gestion des Actualités')

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

    {{-- Main Conteneur style Amazon Card --}}
    <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                Gestion des Actualités (Highlights)
            </h1>
            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.highlights.create') }}"
                   style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.4) inset; display: flex; align-items: center; gap: 6px;">
                    Créer une actualité
                </a>
                <a href="{{ route('admin.highlight-tabs.index') }}"
                   style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                    <i class="fas fa-layer-group" style="font-size: 0.75rem; opacity: 0.6;"></i> Gérer les Onglets
                </a>
            </div>
        </div>

        {{-- Barre de filtre --}}
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px 16px; border-radius: 0; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; gap: 16px;">
            {{-- Gauche : per_page --}}
            <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555; flex-shrink: 0;">
                <span>Afficher</span>
                <select onchange="document.getElementById('filter-form').submit()"
                        name="per_page" form="filter-form"
                    style="padding: 4px 6px; border: 1px solid #adb1b8; border-radius: 0; background: #f0f2f2; font-size: 0.8rem; color: #111; cursor: pointer; outline: none;">
                    <option value="10"  {{ request('per_page', 10) == 10  ? 'selected' : '' }}>10</option>
                    <option value="25"  {{ request('per_page') == 25  ? 'selected' : '' }}>25</option>
                    <option value="50"  {{ request('per_page') == 50  ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span>résultats par page</span>
            </div>

            {{-- Droite : filtre onglet + recherche --}}
            <form id="filter-form" action="{{ route('admin.highlights.index') }}" method="GET"
                  style="display: flex; align-items: center; gap: 10px; font-size: 0.8rem;">

                {{-- Filtre par onglet --}}
                <span style="color: #555; flex-shrink: 0;">Onglet :</span>
                <select name="tab" onchange="this.form.submit()"
                    style="padding: 6px 8px; border: 1px solid #adb1b8; border-radius: 0; background: #f0f2f2; font-size: 0.8rem; color: #111; cursor: pointer; outline: none; min-width: 140px;">
                    <option value="">— Tous —</option>
                    @foreach($tabs as $tabId => $tabName)
                        <option value="{{ $tabId }}" {{ request('tab') == $tabId ? 'selected' : '' }}>
                            {{ $tabName }}
                        </option>
                    @endforeach
                </select>

                <span style="color: #555; flex-shrink: 0;">Rechercher :</span>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Titre, sous-titre..."
                       style="padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; outline: none; width: 200px; font-size: 0.8rem;">

                @php $firstTabId = array_key_first($tabs); @endphp
                @if(request('search') || (request('tab') && request('tab') != $firstTabId))
                    <a href="{{ route('admin.highlights.index') }}"
                       style="color: #c40000; font-size: 0.78rem; text-decoration: none; white-space: nowrap;"
                       onmouseover="this.style.textDecoration='underline'"
                       onmouseout="this.style.textDecoration='none'">
                       ✕ Réinitialiser
                    </a>
                @endif
            </form>
        </div>

        {{-- Table Amazon Design --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
            <thead>
                <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 60px;">Pos.</th>
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 65px;">Image</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Détails de l'actualité</th>
                    <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 150px;">Onglet parent</th>
                    <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 90px;">Statut</th>
                    <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 175px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($highlights as $highlight)
                    <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;"
                        onmouseover="this.style.background='#f9f9f9'"
                        onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px 15px; text-align: center; font-size: 0.85rem; font-weight: 700; color: #555; border-right: 1px solid #e7e7e7;">
                            {{ $highlight->position }}
                        </td>
                        <td style="padding: 8px; text-align: center; border-right: 1px solid #e7e7e7;">
                            <img src="{{ $highlight->image_url }}"
                                 style="width: 42px; height: 42px; object-fit: cover; border: 1px solid #ddd; background: #fff;">
                        </td>
                        <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                            <div style="font-weight: 600; color: #111; font-size: 0.85rem;">{{ $highlight->title }}</div>
                            @if($highlight->subtitle)
                                <div style="font-size: 0.75rem; color: #777; margin-top: 2px;">{{ $highlight->subtitle }}</div>
                            @endif
                            @if($highlight->link_url)
                                <div style="font-size: 0.7rem; color: #0066c0; margin-top: 4px;">{{ Str::limit($highlight->link_url, 50) }}</div>
                            @endif
                        </td>
                        <td style="padding: 12px 15px; font-size: 0.8rem; color: #444; border-right: 1px solid #e7e7e7;">
                            {{ $highlight->highlightTab->name ?? 'Aucun' }}
                        </td>
                        <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                            @if($highlight->active)
                                <span style="font-size: 0.75rem; color: #569b00; font-weight: 600;">Visible</span>
                            @else
                                <span style="font-size: 0.75rem; color: #c40000; font-weight: 600;">Masquée</span>
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

        {{-- Pagination Info & Links Harmonisée --}}
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-top: 10px;">
            <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                Affichage de {{ $highlights->firstItem() ?? 0 }} à {{ $highlights->lastItem() ?? 0 }} sur {{ $highlights->total() }} résultats
            </div>
            <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                @if($highlights->onFirstPage())
                    <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                @else
                    <a href="{{ $highlights->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                @endif

                @php
                    $pStart = max(1, $highlights->currentPage() - 2);
                    $pEnd   = min($highlights->lastPage(), $pStart + 4);
                @endphp

                @for($i = $pStart; $i <= $pEnd; $i++)
                    @if($i == $highlights->currentPage())
                        <span style="padding: 6px 12px; background: linear-gradient(to bottom, #f7dfa5, #f0c14b); color: #111; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #a88734;">{{ $i }}</span>
                    @else
                        <a href="{{ $highlights->url($i) }}" style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                    @endif
                @endfor

                @if($highlights->hasMorePages())
                    <a href="{{ $highlights->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                @else
                    <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
                @endif
            </div>
        </div>

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
