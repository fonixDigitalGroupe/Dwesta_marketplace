@extends('layouts.admin')

@section('title', 'À payer aux vendeurs')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
    </style>
@endpush

@section('content')
<div style="max-width: 1600px; margin: -30px auto 0; width: 100%;">

    <!-- Main Card -->
    <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

        <!-- Card Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eff3f6;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-wallet" style="font-size: 0.8rem;"></i>
                <span style="line-height: 1;">À payer aux vendeurs</span>
            </div>
            <a href="{{ route('admin.finance.index') }}" style="color: #004aad; font-size: 0.8rem; text-decoration: none; font-weight: 600;">&larr; Retour à la finance</a>
        </div>

        <!-- Statistiques -->
        <div style="display: flex; gap: 14px; margin-bottom: 20px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px; display: flex; align-items: center; gap: 12px; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-hand-holding-dollar"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ number_format($totalGlobal, 0, ',', ' ') }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Total à payer (FCFA)</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 200px; display: flex; align-items: center; gap: 12px; background: #f0fdf4; border: 1px solid #dcfce7; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #16a34a; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $rows->count() }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Vendeurs concernés</div>
                </div>
            </div>
        </div>

        <!-- Tableau -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 900px; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Vendeur</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">En séquestre</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Disponible</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Total dû</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase;">Déjà retiré</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rows as $r)
                        <tr style="border-bottom: 1px solid #eff3f6;">
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                                <div style="font-weight: 600; color: #111;">{{ $r->user->prenom }} {{ $r->user->nom }}</div>
                                <div style="font-size: 0.78rem; color: #888;">{{ $r->user->email }}</div>
                            </td>
                            <td style="padding: 12px 15px; text-align: right; border-right: 1px solid #eff3f6; color: #b7791f; font-weight: 600;">{{ number_format($r->en_sequestre, 0, ',', ' ') }}</td>
                            <td style="padding: 12px 15px; text-align: right; border-right: 1px solid #eff3f6; color: #16a34a; font-weight: 600;">{{ number_format($r->disponible, 0, ',', ' ') }}</td>
                            <td style="padding: 12px 15px; text-align: right; border-right: 1px solid #eff3f6; font-weight: 800; color: #2563eb;">{{ number_format($r->total_du, 0, ',', ' ') }}</td>
                            <td style="padding: 12px 15px; text-align: right; color: #888;">{{ number_format($r->deja_retire, 0, ',', ' ') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="padding: 2.5rem; text-align: center; color: #999; border: 1px solid #eee;">Aucun montant en portefeuille.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
