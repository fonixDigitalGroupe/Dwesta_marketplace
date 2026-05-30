@extends('layouts.admin')

@section('title', 'Gestion des Transporteurs')

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        select:focus,
        input:focus {
            border-color: #adb1b8 !important;
            outline: none;
        }

        .filter-label {
            font-size: 0.8rem;
            color: #555;
            font-weight: 500;
            margin-bottom: 4px;
            display: block;
        }

        .amazon-btn-secondary {
            background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
            border: 1px solid #adb1b8;
            color: #111;
            padding: 6px 14px;
            border-radius: 0;
            font-size: 0.8rem;
            font-weight: 400;
            text-decoration: none;
            box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .amazon-btn-secondary:hover {
            background: linear-gradient(to bottom, #e7e9ec, #d8dade);
            border-color: #a2a6ac;
        }
        
        .amazon-btn-primary {
            background: linear-gradient(to bottom, #f7dfa5, #f0c14b);
            border: 1px solid #a88734;
            color: #111;
            padding: 6px 14px;
            border-radius: 2px;
            font-size: 0.8rem;
            font-weight: 400;
            text-decoration: none;
            box-shadow: 0 1px 0 rgba(255,255,255,.4) inset;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .amazon-btn-primary:hover {
            background: linear-gradient(to bottom, #f5d381, #eeb933);
            border-color: #9c7e31;
        }

        .delete-btn {
            background: none;
            border: none;
            color: #c40000;
            font-size: 0.8rem;
            cursor: pointer;
            padding: 0;
            text-decoration: none;
        }

        .delete-btn:hover {
            text-decoration: underline;
            color: #af0000;
        }
    </style>
@endpush

@section('content')
    <div style="max-width: 1200px; margin: 0 auto;">

        <!-- Main Conteneur style Amazon Card -->
        <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); padding: 20px; margin-top: -50px;">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e7e7e7;">
                <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">
                    Gestion des Transporteurs
                </h1>

                <div style="display: flex; gap: 8px; align-items: center;">
                    @if($pendingCount > 0)
                        <div style="background: #fff8f3; border: 1px solid #fbd8b4; padding: 4px 12px; border-radius: 2px; display: flex; align-items: center; gap: 8px; margin-right: 10px;">
                            <span style="font-size: 0.75rem; font-weight: 700; color: #c45500;">{{ $pendingCount }} EN ATTENTE</span>
                        </div>
                    @endif

                    <button onclick="window.print()" class="amazon-btn-secondary">
                        <i class="fas fa-print"></i> Imprimer
                    </button>
                </div>
            </div>

            <!-- Barre de filtres grise Harmonisée -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px 20px; border-radius: 0; margin-bottom: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                    
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555;">
                        <span>Afficher</span>
                        <select onchange="window.location.href = '{{ request()->url() }}?per_page=' + this.value" 
                            style="padding: 3px 6px; border: 1px solid #ddd; border-radius: 4px; background: #fcfcfc; font-size: 0.8rem; color: #111; cursor: pointer; outline: none;">
                            <option value="8" {{ request('per_page', 8) == 8 ? 'selected' : '' }}>8</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        <span>résultats</span>
                    </div>

                    <form action="{{ request()->url() }}" method="GET" style="display: flex; gap: 8px; align-items: center;">
                        <span style="font-size: 0.8rem; color: #555; font-weight: 500;">Rechercher :</span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nom, email, véhicule..."
                            style="padding: 6px 12px; border: 1px solid #ddd; border-radius: 4px; outline: none; font-size: 0.85rem; width: 250px;">
                    </form>
                </div>
            </div>

            <!-- Table Amazon Design -->
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #e7e7e7;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">
                            Transporteur
                        </th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">
                            Téléphone
                        </th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">
                            Véhicule
                        </th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">
                            Immatriculation
                        </th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 120px;">
                            Statut
                        </th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 140px;">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transporteurs as $transporteur)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                                <div style="font-size: 0.85rem; color: #0066c0; font-weight: 500;">
                                    {{ $transporteur->user->prenom }} {{ $transporteur->user->nom }}
                                </div>
                                <div style="font-size: 0.75rem; color: #666;">
                                    {{ $transporteur->user->email }}
                                </div>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                {{ $transporteur->user->telephone ?? '-' }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                <div style="font-weight: 600; color: #111;">{{ $transporteur->type_vehicule }}</div>
                                <div style="font-size: 0.75rem; color: #888;">{{ $transporteur->marque_vehicule }}</div>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                <code style="font-family: monospace; background: #f8fafc; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; color: #475569; border: 1px solid #e2e8f0;">
                                    {{ $transporteur->immatriculation ?? 'N/A' }}
                                </code>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                @php
                                    $status = match($transporteur->statut_verification) {
                                        'verifie' => ['bg' => '#f0fdf4', 'text' => '#166534', 'label' => 'Vérifié'],
                                        'rejete' => ['bg' => '#fef2f2', 'text' => '#991b1b', 'label' => 'Rejeté'],
                                        default => ['bg' => '#fff8f3', 'text' => '#c45500', 'label' => 'Attente']
                                    };
                                @endphp
                                <span style="font-size: 0.7rem; color: {{ $status['text'] }}; background: {{ $status['bg'] }}; padding: 3px 8px; border-radius: 12px; font-weight: 700; text-transform: uppercase;">
                                    {{ $status['label'] }}
                                </span>
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.transporteurs.edit', $transporteur) }}"
                                        style="color: #0066c0; font-size: 0.8rem; text-decoration: none;"
                                        onmouseover="this.style.color='#c45500'; this.style.textDecoration='underline'"
                                        onmouseout="this.style.color='#0066c0'; this.style.textDecoration='none'">
                                        Modifier
                                    </a>
                                    <span style="color: #ddd;">|</span>
                                    <form action="{{ route('admin.transporteurs.destroy', $transporteur) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                            class="delete-btn"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce transporteur ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 3rem; text-align: center; color: #999; font-size: 0.85rem;">
                                Aucun transporteur trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Info & Links Harmonisée -->
            @if($transporteurs->total() > 0)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-top: 10px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        Affichage de {{ $transporteurs->firstItem() }} à {{ $transporteurs->lastItem() }} sur {{ $transporteurs->total() }} résultats
                    </div>
                    <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                        @if ($transporteurs->onFirstPage())
                            <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                        @else
                            <a href="{{ $transporteurs->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                        @endif

                        @php
                            $startPage = max(1, $transporteurs->currentPage() - 2);
                            $endPage = min($transporteurs->lastPage(), $startPage + 4);
                        @endphp

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            @if ($i == $transporteurs->currentPage())
                                <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #004aad;">{{ $i }}</span>
                            @else
                                <a href="{{ $transporteurs->url($i) }}" style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                            @endif
                        @endfor

                        @if ($transporteurs->hasMorePages())
                            <a href="{{ $transporteurs->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
