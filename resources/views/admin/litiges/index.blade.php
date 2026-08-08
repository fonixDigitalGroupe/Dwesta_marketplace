@extends('layouts.admin')

@section('title', 'Litiges')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        .lt-tabs-container {
            display: flex; gap: 20px; border-bottom: 1px solid #f0f0f0;
            margin-bottom: 20px; padding-bottom: 0; flex-wrap: wrap;
        }
        .lt-tab {
            padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: #555;
            font-weight: 400; border-bottom: 2px solid transparent; transition: all 0.2s;
        }
        .lt-tab:hover { color: #c45500; }
        .lt-tab.active { color: #c45500; font-weight: 700; border-bottom-color: #c45500; }
        .lt-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .lt-en_cours { background: #fef2f2; color: #991b1b; }
        .lt-resolu { background: #f0fdf4; color: #166534; }
        .lt-ferme { background: #f3f4f6; color: #374151; }
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px; margin-top: -50px;">

        <!-- Top Action Bar -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eff3f6;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-gavel" style="font-size: 0.8rem;"></i>
                <span style="line-height: 1;">Litiges</span>
            </div>
        </div>

        @if(session('success'))
            <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 0.85rem;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 0.85rem;">{{ session('error') }}</div>
        @endif

        <!-- Statistiques -->
        <div style="display: flex; gap: 14px; margin-bottom: 20px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #dc2626; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;"><i class="fas fa-triangle-exclamation"></i></div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $counts['en_cours'] }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">En cours</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $counts['resolu'] }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Résolus</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #6b7280; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;"><i class="fas fa-folder-closed"></i></div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $counts['ferme'] }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Fermés</div>
                </div>
            </div>
        </div>

        <!-- Filtres statut -->
        <div class="lt-tabs-container">
            <a href="{{ route('admin.litiges.index', ['statut' => 'en_cours']) }}" class="lt-tab {{ $statut === 'en_cours' ? 'active' : '' }}">En cours ({{ $counts['en_cours'] }})</a>
            <a href="{{ route('admin.litiges.index', ['statut' => 'resolu']) }}" class="lt-tab {{ $statut === 'resolu' ? 'active' : '' }}">Résolus ({{ $counts['resolu'] }})</a>
            <a href="{{ route('admin.litiges.index', ['statut' => 'ferme']) }}" class="lt-tab {{ $statut === 'ferme' ? 'active' : '' }}">Fermés ({{ $counts['ferme'] }})</a>
            <a href="{{ route('admin.litiges.index', ['statut' => 'tous']) }}" class="lt-tab {{ $statut === 'tous' ? 'active' : '' }}">Tous</a>
        </div>

        <!-- Tableau -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 900px; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Motif</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Commande</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Signaleur</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Vendeur</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Client</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 120px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 110px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($litiges as $litige)
                        <tr style="border-bottom: 1px solid #e7e7e7;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                                <div style="font-weight: 700; color: #111;">{{ ucfirst(str_replace('_',' ',$litige->motif)) }}</div>
                                <div style="font-size: 0.8rem; color: #666; max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $litige->description }}</div>
                                <div style="font-size: 0.72rem; color: #999; margin-top: 3px;">{{ $litige->created_at->format('d/m/Y à H:i') }}</div>
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6; color: #004aad; font-weight: 600;">
                                {{ $litige->order?->reference ?? '—' }}
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6; font-size: 0.82rem; color: #111;">
                                {{ $litige->reporter->prenom ?? '' }} {{ $litige->reporter->nom ?? '' }}
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6; font-size: 0.82rem; color: #111;">
                                {{ $litige->order?->seller?->user?->prenom ?? '' }} {{ $litige->order?->seller?->user?->nom ?? '—' }}
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6; font-size: 0.82rem; color: #111;">
                                {{ $litige->order?->buyer?->prenom ?? '' }} {{ $litige->order?->buyer?->nom ?? '—' }}
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                <span class="lt-badge lt-{{ $litige->statut }}">{{ ucfirst(str_replace('_',' ',$litige->statut)) }}</span>
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <a href="{{ route('admin.litiges.show', $litige) }}" style="background: #004aad; color: #fff; font-size: 0.75rem; font-weight: 600; padding: 6px 14px; border-radius: 4px; text-decoration: none;">Détail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" style="padding: 2.5rem; text-align: center; color: #999; border: 1px solid #eee;">Aucun litige.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">{{ $litiges->links() }}</div>
    </div>
</div>
@endsection
