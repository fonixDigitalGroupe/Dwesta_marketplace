@extends('layouts.admin')

@section('title', 'Annulations de course')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        .an-tabs-container {
            display: flex; gap: 20px; border-bottom: 1px solid #f0f0f0;
            margin-bottom: 20px; padding-bottom: 0;
        }
        .an-tab {
            padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: #555;
            font-weight: 400; border-bottom: 2px solid transparent; transition: all 0.2s;
        }
        .an-tab:hover { color: #c45500; }
        .an-tab.active { color: #c45500; font-weight: 700; border-bottom-color: #c45500; }
        .an-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .an-nouveau { background: #fef2f2; color: #991b1b; }
        .an-traite  { background: #f0fdf4; color: #166534; }
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px; margin-top: -50px;">

        <!-- Top Action Bar -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eff3f6;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-ban" style="font-size: 0.8rem;"></i>
                <span style="line-height: 1;">Annulations de course</span>
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
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $counts['nouveau'] }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Nouveaux</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $counts['traite'] }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Traités</div>
                </div>
            </div>
        </div>

        <!-- Filtres statut -->
        <div class="an-tabs-container">
            <a href="{{ route('admin.annulations.index', ['statut' => 'nouveau']) }}" class="an-tab {{ $statut === 'nouveau' ? 'active' : '' }}">Nouveaux ({{ $counts['nouveau'] }})</a>
            <a href="{{ route('admin.annulations.index', ['statut' => 'traite']) }}" class="an-tab {{ $statut === 'traite' ? 'active' : '' }}">Traités ({{ $counts['traite'] }})</a>
        </div>

        <!-- Tableau -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 900px; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Motif</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Référence</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Partenaire</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Type</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 120px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($annulations as $a)
                        <tr style="border-bottom: 1px solid #e7e7e7;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                                <div style="font-weight: 700; color: #111;">{{ ucfirst(str_replace('_',' ',$a->motif)) }}</div>
                                @if($a->commentaire)
                                    <div style="font-size: 0.8rem; color: #666; max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $a->commentaire }}</div>
                                @endif
                                <div style="font-size: 0.72rem; color: #999; margin-top: 3px;">{{ $a->created_at->format('d/m/Y à H:i') }}</div>
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6; color: #004aad; font-weight: 600;">
                                {{ $a->reference ?? '—' }}
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6; font-size: 0.82rem; color: #111;">
                                {{ $a->partenaire ? trim($a->partenaire->prenom . ' ' . $a->partenaire->nom) : '—' }}
                                @if($a->partenaire?->telephone)
                                    <div style="color:#94a3b8;font-size:0.78rem;">{{ $a->partenaire->telephone }}</div>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6; font-size: 0.82rem; color: #111; text-transform: capitalize;">
                                {{ $a->type }}
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                <span class="an-badge an-{{ $a->statut }}">{{ $a->statut === 'traite' ? 'Traité' : 'Nouveau' }}</span>
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <form method="POST" action="{{ route('admin.annulations.traiter', $a) }}" style="margin: 0;">
                                    @csrf
                                    <button type="submit" style="background: #004aad; color: #fff; font-size: 0.75rem; font-weight: 600; padding: 6px 14px; border-radius: 4px; text-decoration: none; border: none; cursor: pointer;">
                                        {{ $a->statut === 'traite' ? 'Rouvrir' : 'Marquer traité' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="padding: 2.5rem; text-align: center; color: #999; border: 1px solid #eee;">Aucune annulation.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">{{ $annulations->links() }}</div>
    </div>
</div>
@endsection
