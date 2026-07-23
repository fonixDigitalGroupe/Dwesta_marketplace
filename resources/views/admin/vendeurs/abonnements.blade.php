@extends('layouts.admin')

@section('title', 'Abonnements des vendeurs')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        select:focus, input:focus { border-color: #adb1b8 !important; outline: none; }
        .va-tab {
            padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: #555;
            font-weight: 400; border-bottom: 2px solid transparent;
        }
        .va-tab.active { color: #c45500; font-weight: 700; border-bottom-color: #c45500; }
        .va-badge { font-size: 0.72rem; font-weight: 700; padding: 2px 9px; border-radius: 12px; display: inline-block; }
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px; margin-top: -50px;">

        <!-- Top bar -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eff3f6;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-id-card" style="font-size: 0.8rem;"></i>
                <span>Abonnements des vendeurs</span>
            </div>
        </div>

        <!-- Stat cards -->
        <div style="display: flex; gap: 14px; margin-bottom: 20px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #f5f3ff; border: 1px solid #e9e5ff; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #7c3aed; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;"><i class="fas fa-store"></i></div>
                <div><div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $totalVendeurs }}</div><div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; margin-top: 4px;">Vendeurs</div></div>
            </div>
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #ecfdf5; border: 1px solid #d1fae5; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;"><i class="fas fa-check-circle"></i></div>
                <div><div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $avecAbonnementActif }}</div><div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; margin-top: 4px;">Abonnement actif</div></div>
            </div>
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #fff1f2; border: 1px solid #ffe4e6; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #f43f5e; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;"><i class="fas fa-ban"></i></div>
                <div><div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $sansAbonnement }}</div><div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; margin-top: 4px;">Sans abonnement actif</div></div>
            </div>
        </div>

        <!-- Onglets -->
        <div style="display: flex; gap: 20px; border-bottom: 1px solid #f0f0f0; margin-bottom: 20px;">
            <a href="{{ route('admin.users.index', ['role' => 'vendeur']) }}" class="va-tab">Liste des vendeurs</a>
            <a href="{{ route('admin.vendeurs.abonnements') }}" class="va-tab active">Abonnements</a>
        </div>

        <!-- Recherche -->
        <div class="filters-bar" style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; margin-bottom: 20px;">
            <form action="{{ route('admin.vendeurs.abonnements') }}" method="GET" style="display: flex; align-items: center; width: 100%; gap: 12px;">
                <div style="display: flex; flex: 1; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff;">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher un vendeur (nom, email)..."
                        style="padding: 10px 16px; border: none; outline: none; flex: 1; font-size: 0.9rem; background: transparent;">
                    <button type="submit" style="background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border: none; color: #fff; padding: 0 22px; cursor: pointer;"><i class="fas fa-search" style="font-size: 1.1rem;"></i></button>
                </div>
                @if($search)
                    <a href="{{ route('admin.vendeurs.abonnements') }}" style="color: #0066c0; font-size: 0.85rem; text-decoration: none;">Effacer</a>
                @endif
            </form>
        </div>

        <!-- Tableau -->
        <div style="border: 1px solid #e7e7e7; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Vendeur</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 120px;">Type</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Abonnement(s)</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 110px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 130px;">Échéance</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vendeurs as $vendeur)
                        @php
                            $actifs = $vendeur->abonnements->filter(fn ($va) => $va->actif && $va->date_fin && $va->date_fin->gte(now()->startOfDay()));
                            $aEuDesAbos = $vendeur->abonnements->count() > 0;
                            $prochaineEcheance = $actifs->min('date_fin');
                        @endphp
                        <tr style="border-bottom: 1px solid #e7e7e7;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                                <div style="font-weight: 700; font-size: 0.85rem; color: #111;">{{ $vendeur->user->prenom ?? '' }} {{ $vendeur->user->nom ?? '' }}</div>
                                <div style="font-size: 0.78rem; color: #64748b;">{{ $vendeur->user->email ?? '—' }}</div>
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7; font-size: 0.82rem; color: #333;">{{ ucfirst($vendeur->type ?? '—') }}</td>
                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                                @if($actifs->count())
                                    <div style="display: flex; flex-direction: column; gap: 4px;">
                                        @foreach($actifs as $va)
                                            <span style="font-size: 0.8rem; color: #333;">
                                                <span class="va-badge" style="background:#eef2ff; color:#4338ca;">{{ $va->abonnement?->famille ?? '—' }}</span>
                                                {{ ucfirst($va->abonnement?->nom ?? $va->abonnement?->type ?? '—') }}
                                                <span style="color:#64748b;">— {{ number_format($va->abonnement?->prix_mensuel ?? 0, 0, ',', ' ') }} F</span>
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span style="color: #94a3b8; font-size: 0.82rem;">Aucun abonnement actif</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                                @if($actifs->count())
                                    <span class="va-badge" style="background:#dcfce7; color:#166534;">Actif</span>
                                @elseif($aEuDesAbos)
                                    <span class="va-badge" style="background:#fee2e2; color:#b91c1c;">Expiré</span>
                                @else
                                    <span class="va-badge" style="background:#f1f5f9; color:#475569;">Aucun</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.82rem; color: #555;">
                                {{ $prochaineEcheance ? $prochaineEcheance->format('d/m/Y') : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 60px; text-align: center; color: #888;">
                                <i class="fas fa-store" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.2;"></i>
                                <p>Aucun vendeur trouvé.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($vendeurs->total() > 0)
        <div style="margin-top: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                    Affichage de {{ $vendeurs->firstItem() ?? 0 }} à {{ $vendeurs->lastItem() ?? 0 }} sur {{ $vendeurs->total() }} vendeurs
                </div>
                <div style="display: flex; border: 1px solid #adb1b8; overflow: hidden; background: #fff;">
                    @if ($vendeurs->onFirstPage())
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                    @else
                        <a href="{{ $vendeurs->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                    @endif
                    @if ($vendeurs->hasMorePages())
                        <a href="{{ $vendeurs->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                    @else
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
