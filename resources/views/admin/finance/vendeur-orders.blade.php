@extends('layouts.admin')

@section('title', 'Commandes du vendeur')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        .status-badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 0.72rem; font-weight: 600; text-transform: uppercase; }
        .st-paye { background:#e6f4ea; color:#1e7e34; }
        .st-pret_expedition { background:#fff4e5; color:#b7791f; }
        .st-en_route { background:#e7f3ff; color:#0056b3; }
        .st-disponible { background:#eef2ff; color:#4338ca; }
        .st-livre { background:#f0fdf4; color:#166534; }
        .st-en_attente { background:#fff7ed; color:#c2410c; }
        .st-annule { background:#f3f4f6; color:#374151; }
        .st-litige { background:#fef2f2; color:#991b1b; }
        .amazon-tabs-container { display: flex; gap: 20px; border-bottom: 1px solid #f0f0f0; margin-bottom: 20px; flex-wrap: wrap; }
        .fstab { padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: #555; font-weight: 400; border-bottom: 2px solid transparent; transition: all 0.2s; }
        .fstab:hover { color: #c45500; }
        .fstab.active { color: #c45500; font-weight: 700; border-bottom-color: #c45500; }
    </style>
@endpush

@section('content')
@php
    $labels = [
        'en_attente' => 'En attente', 'paye' => 'Payé', 'pret_expedition' => 'Prêt',
        'en_route' => 'En route', 'disponible' => 'Disponible', 'livre' => 'Livré',
        'annule' => 'Annulé', 'litige' => 'Litige',
    ];
@endphp
<div style="max-width: 1600px; margin: -30px auto 0; width: 100%;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eff3f6;">
            <div>
                <h1 style="font-size: 1.15rem; font-weight: 700; color: #111; margin: 0;">Commandes de {{ $user->prenom }} {{ $user->nom }}</h1>
                <p style="font-size: 0.82rem; color: #666; margin: 4px 0 0;">{{ $user->email }} · {{ $totalCommandes }} commande(s) au total</p>
            </div>
            <a href="{{ route('admin.finance.vendeurs') }}" style="color: #004aad; font-size: 0.8rem; text-decoration: none; font-weight: 600;">&larr; Retour</a>
        </div>

        <!-- Filtres par statut -->
        <div class="amazon-tabs-container">
            <a href="{{ route('admin.finance.vendeurs.orders', $user->id) }}" class="fstab {{ !$statutFiltre ? 'active' : '' }}">Tous ({{ $totalCommandes }})</a>
            @foreach($labels as $val => $lbl)
                @if(($countsParStatut[$val] ?? 0) > 0)
                    <a href="{{ route('admin.finance.vendeurs.orders', ['user' => $user->id, 'statut' => $val]) }}" class="fstab {{ $statutFiltre === $val ? 'active' : '' }}">{{ $lbl }} ({{ $countsParStatut[$val] }})</a>
                @endif
            @endforeach
        </div>

        <!-- Tableau -->
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; min-width: 850px; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Référence / Date</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Client</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Total</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase;">Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr style="border-bottom: 1px solid #eff3f6;">
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                                <div style="font-weight: 600; color: #0066c0;">{{ $order->reference }}</div>
                                <div style="font-size: 0.78rem; color: #888;">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #eff3f6;">
                                <div style="color: #111;">{{ $order->buyer->prenom ?? '' }} {{ $order->buyer->nom ?? '' }}</div>
                                <div style="font-size: 0.78rem; color: #888;">{{ $order->buyer->email ?? '-' }}</div>
                            </td>
                            <td style="padding: 12px 15px; text-align: right; border-right: 1px solid #eff3f6; font-weight: 700; color: #111;">{{ number_format($order->total_final ?? $order->total_produits, 0, ',', ' ') }} FCFA</td>
                            <td style="padding: 12px 15px; text-align: center;">
                                <span class="status-badge st-{{ $order->statut }}">{{ $labels[$order->statut] ?? $order->statut }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="padding: 2.5rem; text-align: center; color: #999; border: 1px solid #eee;">Aucune commande pour ce filtre.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">{{ $orders->links() }}</div>
    </div>
</div>
@endsection
