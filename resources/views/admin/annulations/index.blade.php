@extends('layouts.admin')

@section('title', 'Annulations de course')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        .an-tab { padding: 8px 14px; text-decoration: none; font-size: 0.82rem; color: #555; font-weight: 600; border-radius: 999px; border: 1px solid #e0e2e6; background: #fff; }
        .an-tab.active { color: #fff; background: #c45500; border-color: #c45500; }
        .an-badge { display: inline-block; padding: 3px 9px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .an-nouveau { background: #fef2f2; color: #991b1b; }
        .an-traite { background: #f0fdf4; color: #166534; }
        .an-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        .an-table th { text-align: left; padding: 10px 12px; color: #64748b; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.04em; border-bottom: 1px solid #eff3f6; }
        .an-table td { padding: 12px; border-bottom: 1px solid #f2f4f7; color: #111; vertical-align: top; }
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px; margin-top: -50px;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eff3f6;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                <i class="fas fa-ban" style="font-size: 0.8rem;"></i>
                <span>Annulations de course</span>
            </div>
        </div>

        @if(session('success'))
            <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 0.85rem;">{{ session('success') }}</div>
        @endif

        <div style="display: flex; gap: 10px; margin-bottom: 20px;">
            <a href="{{ route('admin.annulations.index', ['statut' => 'nouveau']) }}" class="an-tab {{ $statut === 'nouveau' ? 'active' : '' }}">Nouveaux ({{ $counts['nouveau'] }})</a>
            <a href="{{ route('admin.annulations.index', ['statut' => 'traite']) }}" class="an-tab {{ $statut === 'traite' ? 'active' : '' }}">Traités ({{ $counts['traite'] }})</a>
        </div>

        @if($annulations->count() === 0)
            <div style="text-align: center; color: #94a3b8; padding: 40px 0; font-size: 0.9rem;">Aucune annulation.</div>
        @else
        <div style="overflow-x: auto;">
            <table class="an-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Référence</th>
                        <th>Partenaire</th>
                        <th>Type</th>
                        <th>Motif</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($annulations as $a)
                    <tr>
                        <td>{{ $a->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $a->reference ?? '—' }}</td>
                        <td>{{ $a->partenaire ? trim($a->partenaire->prenom . ' ' . $a->partenaire->nom) : '—' }}<br><span style="color:#94a3b8;font-size:0.78rem;">{{ $a->partenaire->telephone ?? '' }}</span></td>
                        <td style="text-transform: capitalize;">{{ $a->type }}</td>
                        <td>
                            <strong>{{ $a->motif }}</strong>
                            @if($a->commentaire)<div style="color:#64748b;font-size:0.8rem;margin-top:3px;">{{ $a->commentaire }}</div>@endif
                        </td>
                        <td><span class="an-badge an-{{ $a->statut }}">{{ $a->statut === 'traite' ? 'Traité' : 'Nouveau' }}</span></td>
                        <td>
                            <form method="POST" action="{{ route('admin.annulations.traiter', $a) }}">
                                @csrf
                                <button type="submit" style="border:1px solid #e0e2e6;background:#fff;color:#c45500;padding:6px 12px;border-radius:6px;font-size:0.78rem;font-weight:600;cursor:pointer;">
                                    {{ $a->statut === 'traite' ? 'Rouvrir' : 'Marquer traité' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top: 18px;">{{ $annulations->links() }}</div>
        @endif
    </div>
</div>
@endsection
