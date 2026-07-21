@extends('layouts.admin')

@section('title', 'Gestion des Livreurs')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }

        select:focus, input:focus { border-color: #ff9900 !important; outline: none; }

        .btn-amazon-primary {
            background: linear-gradient(180deg, #007bff 0%, #0056b3 100%);
            border: 1px solid #1e40af; color: #fff; padding: 6px 14px; border-radius: 4px;
            font-size: 0.8rem; font-weight: 500; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s;
        }
        .btn-amazon-primary:hover { background: linear-gradient(180deg, #1d4ed8 0%, #1e3a8a 100%); box-shadow: 0 1px 3px rgba(0,0,0,0.1); color: #fff; }

        .btn-amazon-secondary {
            background: #fff; border: 1px solid #e2e8f0; color: #475569; padding: 6px 14px; border-radius: 4px;
            font-size: 0.8rem; font-weight: 500; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; cursor: pointer;
        }
        .btn-amazon-secondary:hover { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }

        .badge-amazon { font-size: 0.75rem; font-weight: 600; padding: 2px 8px; border-radius: 12px; }
        .badge-amazon-success { color: #569b00; background: #f7fff0; }
        .badge-amazon-danger { color: #c40000; background: #fff5f5; }
        .badge-amazon-warning { color: #c45500; background: #fff8e1; border: 1px solid #ffecb3; }

        @media print {
            .sidebar, .navbar, .settings-tabs, .filters-bar, .actions-column, .pagination-container, .btn-amazon-primary, .btn-amazon-secondary, header, footer { display: none !important; }
            .main-content { margin: 0 !important; padding: 0 !important; background: #fff !important; }
        }
    </style>
@endpush

@section('content')
    <div style="max-width: 1600px; margin: 0 auto; width: 100%; padding-top: 0;">
        <!-- Main Card -->
        <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px; margin-top: -20px;">

            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                    <i class="fas fa-motorcycle" style="font-size: 0.8rem;"></i>
                    <span style="line-height: 1;">Livreurs</span>
                </div>

            </div>

            @php
                $totalLivreurs = \App\Models\Livreur::count();
                $attenteLivreurs = \App\Models\Livreur::where('statut_verification', 'en_attente')->count();
                $verifieLivreurs = \App\Models\Livreur::where('statut_verification', 'verifie')->count();
                $rejeteLivreurs = \App\Models\Livreur::where('statut_verification', 'rejete')->count();
            @endphp
            <!-- Statistiques livreurs -->
            <div style="display: flex; gap: 14px; margin-bottom: 20px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #f5f3ff; border: 1px solid #e9e5ff; border-radius: 8px; padding: 14px 18px;">
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;"><i class="fas fa-motorcycle"></i></div>
                    <div>
                        <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $totalLivreurs }}</div>
                        <div style="font-size: 0.75rem; color: #6b21a8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Livreurs</div>
                    </div>
                </div>
                <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; padding: 14px 18px;">
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;"><i class="fas fa-clock"></i></div>
                    <div>
                        <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $attenteLivreurs }}</div>
                        <div style="font-size: 0.75rem; color: #b45309; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">En attente</div>
                    </div>
                </div>
                <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #ecfdf5; border: 1px solid #d1fae5; border-radius: 8px; padding: 14px 18px;">
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;"><i class="fas fa-circle-check"></i></div>
                    <div>
                        <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $verifieLivreurs }}</div>
                        <div style="font-size: 0.75rem; color: #047857; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Vérifiés</div>
                    </div>
                </div>
                <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #fff1f2; border: 1px solid #ffe4e6; border-radius: 8px; padding: 14px 18px;">
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #f43f5e; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;"><i class="fas fa-times-circle"></i></div>
                    <div>
                        <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $rejeteLivreurs }}</div>
                        <div style="font-size: 0.75rem; color: #be123c; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Rejetés</div>
                    </div>
                </div>
            </div>

            <!-- Barre de filtre -->
            <div class="filters-bar"
                style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; border-radius: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 15px;">
                <form action="{{ route('admin.livreurs.index') }}" method="GET" style="display: flex; align-items: center; flex: 1; gap: 12px;">
                    <select name="statut" onchange="this.form.submit()"
                        style="padding: 9px 12px; border: 1px solid #dee2e6; border-radius: 4px; background: #fff; font-size: 0.85rem; color: #111; cursor: pointer; min-width: 150px;">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="verifie" {{ request('statut') === 'verifie' ? 'selected' : '' }}>Vérifié</option>
                        <option value="rejete" {{ request('statut') === 'rejete' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                    <select name="pays" onchange="this.form.submit()"
                        style="padding: 9px 12px; border: 1px solid #dee2e6; border-radius: 4px; background: #fff; font-size: 0.85rem; color: #111; cursor: pointer; min-width: 150px;">
                        <option value="">Tous les pays</option>
                        @foreach($paysDisponibles as $pays)
                            <option value="{{ $pays }}" {{ request('pays') === $pays ? 'selected' : '' }}>{{ $pays }}</option>
                        @endforeach
                    </select>
                    <div style="display: flex; flex: 1; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff; transition: all 0.2s;" id="search-container">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un livreur par nom, email, véhicule..."
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
                    @if(request('search') || request('statut') || request('pays'))
                        <a href="{{ route('admin.livreurs.index') }}"
                           style="color: #0066c0; font-size: 0.85rem; text-decoration: none; white-space: nowrap;"
                           onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Effacer</a>
                    @endif
                </form>
            </div>

            <!-- Table Amazon Design -->
            <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Livreur</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Téléphone</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Véhicule</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 120px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 140px;" class="actions-column">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($livreurs as $livreur)
                        <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                                <div style="font-size: 0.85rem; color: #111; font-weight: 700;">{{ $livreur->user->prenom }} {{ $livreur->user->nom }}</div>
                                <div style="font-size: 0.75rem; color: #111;">{{ $livreur->user->email }}</div>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #111; border-right: 1px solid #eff3f6;">{{ $livreur->user->telephone ?? '-' }}</td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #111; border-right: 1px solid #eff3f6;">
                                <div style="font-weight: 600; color: #111;">{{ $livreur->type_vehicule ?? '-' }}</div>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                @php
                                    $cls = match($livreur->statut_verification) {
                                        'verifie' => 'badge-amazon-success',
                                        'rejete'  => 'badge-amazon-danger',
                                        default   => 'badge-amazon-warning',
                                    };
                                    $lbl = match($livreur->statut_verification) {
                                        'verifie' => 'Vérifié',
                                        'rejete'  => 'Rejeté',
                                        default   => 'En attente',
                                    };
                                @endphp
                                <span class="badge-amazon {{ $cls }}">{{ $lbl }}</span>
                            </td>
                            <td style="padding: 12px 15px; text-align: right;" class="actions-column">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <a href="{{ route('admin.livreurs.show', $livreur) }}" title="Examiner"
                                        style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 6px; color: #111; text-decoration: none; transition: background 0.2s;"
                                        onmouseover="this.style.background='#f3f4f6'"
                                        onmouseout="this.style.background='transparent'"><i class="fas fa-eye" style="font-size: 0.95rem;"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                                Aucun livreur trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>

            <!-- Pagination -->
            @if($livreurs->total() > 0)
                <div class="pagination-container"
                    style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #eff3f6; border-radius: 4px; margin-top: 20px;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        Affichage de {{ $livreurs->firstItem() ?? 0 }} à {{ $livreurs->lastItem() ?? 0 }} sur {{ $livreurs->total() }} résultats
                    </div>
                    <div style="display: flex; gap: 4px;">
                        @if($livreurs->onFirstPage())
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Précédent</span>
                        @else
                            <a href="{{ $livreurs->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;">Précédent</a>
                        @endif

                        @foreach(range(max(1, $livreurs->currentPage() - 2), min($livreurs->lastPage(), $livreurs->currentPage() + 2)) as $i)
                            @if($i == $livreurs->currentPage())
                                <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border: 1px solid #1e40af; border-radius: 4px;">{{ $i }}</span>
                            @else
                                <a href="{{ $livreurs->url($i) }}" style="padding: 6px 12px; background: #fff; color: #64748b; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;">{{ $i }}</a>
                            @endif
                        @endforeach

                        @if($livreurs->hasMorePages())
                            <a href="{{ $livreurs->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #475569; font-size: 0.8rem; text-decoration: none; border: 1px solid #eff3f6; border-radius: 4px;">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f8fafc; color: #94a3b8; font-size: 0.8rem; border: 1px solid #eff3f6; border-radius: 4px; cursor: not-allowed;">Suivant</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
