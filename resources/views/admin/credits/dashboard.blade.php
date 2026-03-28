@extends('layouts.admin')

@section('content')
<div style="max-width: 900px; margin: 2rem auto; padding: 0 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 1.5rem; font-weight: 800;">Crédits — Tableau de bord</h1>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('admin.credits.packs') }}" style="background:#000;color:#fff;padding:0.5rem 1.2rem;border-radius:6px;text-decoration:none;font-weight:700;font-size:0.85rem;">Gérer les packs</a>
            <a href="{{ route('admin.credits.services') }}" style="background:#fff;color:#000;padding:0.5rem 1.2rem;border-radius:6px;text-decoration:none;font-weight:700;font-size:0.85rem;border:1.5px solid #000;">Tarifs services</a>
            <a href="{{ route('admin.credits.attribuer') }}" style="background:#ff6600;color:#fff;padding:0.5rem 1.2rem;border-radius:6px;text-decoration:none;font-weight:700;font-size:0.85rem;">Attribuer crédits</a>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#d4edda;color:#155724;padding:0.75rem 1rem;border-radius:6px;margin-bottom:1rem;">{{ session('success') }}</div>
    @endif

    {{-- Stats --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2rem;">
        <div style="background:#f7f7f7;border-radius:10px;padding:1.5rem;text-align:center;">
            <div style="font-size:2rem;font-weight:900;">{{ number_format($totalCreditsVendus) }}</div>
            <div style="color:#666;font-size:0.85rem;margin-top:0.3rem;">Crédits vendus (total)</div>
        </div>
        <div style="background:#f7f7f7;border-radius:10px;padding:1.5rem;text-align:center;">
            <div style="font-size:2rem;font-weight:900;">{{ number_format($totalCreditDepenses) }}</div>
            <div style="color:#666;font-size:0.85rem;margin-top:0.3rem;">Crédits dépensés (total)</div>
        </div>
        <div style="background:#f7f7f7;border-radius:10px;padding:1.5rem;text-align:center;">
            <div style="font-size:2rem;font-weight:900;">{{ $totalPacks }}</div>
            <div style="color:#666;font-size:0.85rem;margin-top:0.3rem;">Packs actifs</div>
        </div>
    </div>

    {{-- Dernières transactions --}}
    <h2 style="font-size:1rem;font-weight:800;margin-bottom:1rem;">Dernières transactions</h2>
    <table style="width:100%;border-collapse:collapse;font-size:0.85rem;">
        <thead>
            <tr style="border-bottom:2px solid #000;">
                <th style="text-align:left;padding:0.5rem;">Utilisateur</th>
                <th style="text-align:left;padding:0.5rem;">Type</th>
                <th style="text-align:right;padding:0.5rem;">Montant</th>
                <th style="text-align:left;padding:0.5rem;">Description</th>
                <th style="text-align:left;padding:0.5rem;">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentTransactions as $tx)
            <tr style="border-bottom:1px solid #f0f0f0;">
                <td style="padding:0.5rem;">{{ $tx->user?->prenom }} {{ $tx->user?->nom }}</td>
                <td style="padding:0.5rem;">
                    <span style="background:{{ $tx->type==='achat'?'#d4edda':($tx->type==='depense'?'#f8d7da':'#fff3cd') }};color:#333;padding:0.2rem 0.5rem;border-radius:4px;font-size:0.75rem;">
                        {{ ucfirst($tx->type) }}
                    </span>
                </td>
                <td style="padding:0.5rem;text-align:right;font-weight:700;color:{{ $tx->montant > 0 ? 'green' : 'red' }};">
                    {{ $tx->montant > 0 ? '+' : '' }}{{ $tx->montant }}
                </td>
                <td style="padding:0.5rem;color:#666;">{{ Str::limit($tx->description, 60) }}</td>
                <td style="padding:0.5rem;color:#666;">{{ $tx->created_at->format('d/m/y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
