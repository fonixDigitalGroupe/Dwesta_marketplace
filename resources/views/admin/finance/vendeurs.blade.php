@extends('layouts.admin')

@section('title', 'Détail des paiements vendeurs')

@section('content')
<div style="padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div>
            <h1 style="font-size: 1.2rem; font-weight: 600; color: #111; margin: 0;">À payer aux vendeurs — détail</h1>
            <p style="font-size: 0.85rem; color: #666; margin: 4px 0 0;">Montants en portefeuille (en séquestre + disponible) par vendeur.</p>
        </div>
        <a href="{{ route('admin.finance.index') }}" style="color: #004aad; font-size: 0.85rem; text-decoration: none; font-weight: 600;">&larr; Retour à la finance</a>
    </div>

    <div style="background: #eaf1fd; border: 1px solid #bcd4f6; border-radius: 6px; padding: 14px 20px; margin-bottom: 20px; display: inline-block;">
        <div style="font-size: 0.7rem; font-weight: 700; color: #1e3a8a; text-transform: uppercase;">Total à payer aux vendeurs</div>
        <div style="font-size: 1.6rem; font-weight: 800; color: #2563eb;">{{ number_format($totalGlobal, 0, ',', ' ') }} FCFA</div>
    </div>

    <div style="background: #fff; border: 1px solid #e7e7e7; border-radius: 6px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
            <thead>
                <tr style="background: #f0f2f2;">
                    <th style="text-align: left; padding: 12px 16px; font-size: 0.72rem; text-transform: uppercase; color: #555; border-bottom: 1px solid #e0e0e0;">Vendeur</th>
                    <th style="text-align: right; padding: 12px 16px; font-size: 0.72rem; text-transform: uppercase; color: #555; border-bottom: 1px solid #e0e0e0;">En séquestre</th>
                    <th style="text-align: right; padding: 12px 16px; font-size: 0.72rem; text-transform: uppercase; color: #555; border-bottom: 1px solid #e0e0e0;">Disponible</th>
                    <th style="text-align: right; padding: 12px 16px; font-size: 0.72rem; text-transform: uppercase; color: #555; border-bottom: 1px solid #e0e0e0;">Total dû</th>
                    <th style="text-align: right; padding: 12px 16px; font-size: 0.72rem; text-transform: uppercase; color: #555; border-bottom: 1px solid #e0e0e0;">Déjà retiré</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rows as $r)
                    <tr>
                        <td style="padding: 12px 16px; border-bottom: 1px solid #f2f2f2;">
                            <div style="font-weight: 600; color: #111;">{{ $r->user->prenom }} {{ $r->user->nom }}</div>
                            <div style="font-size: 0.78rem; color: #888;">{{ $r->user->email }}</div>
                        </td>
                        <td style="padding: 12px 16px; text-align: right; border-bottom: 1px solid #f2f2f2; color: #b45309;">{{ number_format($r->en_sequestre, 0, ',', ' ') }}</td>
                        <td style="padding: 12px 16px; text-align: right; border-bottom: 1px solid #f2f2f2; color: #16a34a;">{{ number_format($r->disponible, 0, ',', ' ') }}</td>
                        <td style="padding: 12px 16px; text-align: right; border-bottom: 1px solid #f2f2f2; font-weight: 800; color: #2563eb;">{{ number_format($r->total_du, 0, ',', ' ') }}</td>
                        <td style="padding: 12px 16px; text-align: right; border-bottom: 1px solid #f2f2f2; color: #888;">{{ number_format($r->deja_retire, 0, ',', ' ') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="padding: 2rem; text-align: center; color: #999;">Aucun montant en portefeuille.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
