@extends('layouts.admin')

@section('title', 'Gestion des Packs d\'Abonnement')

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
        @include('admin.partials.settings-tabs')

        <!-- Main Conteneur style Amazon Card -->
        <div style="background: #fff; border: 1px solid #e7e7e7; border-top: none; border-radius: 0; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                    Gestion des Abonnements
                </h1>
                
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.abonnements.create') }}" 
                       style="background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.4) inset; display: flex; align-items: center; gap: 6px;">
                        Nouveau pack d'abonnement
                    </a>
                    <a href="javascript:window.print()" 
                       style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px;">
                        Imprimer
                    </a>
                </div>
            </div>
            
            <!-- Barre de filtre modernisée -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px 16px; border-radius: 0; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555;">
                    <span>Afficher</span>
                    <select onchange="window.location.href = '{{ route('admin.abonnements.index') }}?per_page=' + this.value + '&search={{ $search }}'" 
                        style="padding: 4px 6px; border: 1px solid #adb1b8; border-radius: 0; background: #f0f2f2; font-size: 0.8rem; color: #111; cursor: pointer; outline: none;">
                        <option value="8" {{ $perPage == 8 ? 'selected' : '' }}>8</option>
                        <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span>résultats par page</span>
                </div>

                <div style="font-size: 0.8rem;">
                    <form action="{{ route('admin.abonnements.index') }}" method="GET" style="display: flex; align-items: center; gap: 8px;">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        <span style="color: #555;">Rechercher :</span>
                        <input type="text" name="search" value="{{ $search }}" 
                            placeholder="Nom du pack..."
                            style="padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; outline: none; width: 220px; font-size: 0.8rem;">
                    </form>
                </div>
            </div>

            <!-- Table Amazon Design -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Nom du Pack</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Description</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 100px;">Com.</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 80px;">Annonces</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 100px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 120px;">Prix</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($abonnements as $abonnement)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #0066c0; font-weight: 500; border-right: 1px solid #e7e7e7;">
                                {{ ucfirst($abonnement->nom) }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">{{ Str::limit($abonnement->description, 60) }}</td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; text-align: center; border-right: 1px solid #e7e7e7;">{{ $abonnement->commission }}%</td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; text-align: center; border-right: 1px solid #e7e7e7;">
                                @if($abonnement->nombre_annonces > 0)
                                    <span style="font-weight: 600;">{{ $abonnement->nombre_annonces }}</span>
                                @else
                                    <span style="font-style: italic; color: #999;">∞</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                @if($abonnement->actif)
                                    <span style="font-size: 0.75rem; color: #569b00; font-weight: 600;">Actif</span>
                                @else
                                    <span style="font-size: 0.75rem; color: #c40000; font-weight: 600;">Inactif</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #111; font-weight: 600; text-align: center; border-right: 1px solid #e7e7e7;">
                                {{ number_format($abonnement->prix_mensuel, 0, ',', ' ') }} F
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.abonnements.edit', $abonnement) }}" 
                                       style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                       onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'" 
                                       onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                       Modifier
                                    </a>
                                    <span style="color: #ddd;">|</span>
                                    <form id="delete-form-{{ $abonnement->id }}" action="{{ route('admin.abonnements.destroy', $abonnement) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete({{ $abonnement->id }})" 
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
                            <td colspan="7" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                                Aucun pack d'abonnement trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Info & Links Harmonisée -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-top: 10px;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                    Affichage de {{ $abonnements->firstItem() ?? 0 }} à {{ $abonnements->lastItem() ?? 0 }} sur {{ $abonnements->total() }} résultats
                </div>
                <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                    @if($abonnements->onFirstPage())
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                    @else
                        <a href="{{ $abonnements->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                    @endif

                    @foreach(range(1, $abonnements->lastPage()) as $i)
                        @if($i == $abonnements->currentPage())
                            <span style="padding: 6px 12px; background: linear-gradient(to bottom, #f7dfa5, #f0c14b); color: #111; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #a88734;">{{ $i }}</span>
                        @else
                            <a href="{{ $abonnements->url($i) }}" style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                        @endif
                    @endforeach

                    @if($abonnements->hasMorePages())
                        <a href="{{ $abonnements->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                    @else
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
@endsection
