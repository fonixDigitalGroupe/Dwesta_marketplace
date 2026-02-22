@extends('layouts.app')

@section('title', 'Commande #{{ $order->reference }}')

@push('styles')
<style>
    .order-detail-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.5rem;
        align-items: start;
    }

    .detail-card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 0;
        overflow: hidden;
        margin-bottom: 1rem;
    }
    .detail-card-header {
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid #f0f0f0;
        background: #fafafa;
        font-weight: 700;
        font-size: 0.88rem;
        color: #333;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .detail-card-body {
        padding: 1.25rem;
    }

    /* Status badge */
    .status-badge {
        display: inline-block;
        padding: 0.3rem 0.9rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        border: 1px solid transparent;
    }
    .status-paye              { background: #e8f5e9; color: #2e7d32; border-color: #c8e6c9; }
    .status-en_attente        { background: #fff3e0; color: #e65c00; border-color: #ffe0b2; }
    .status-livre             { background: #e3f2fd; color: #1565c0; border-color: #bbdefb; }
    .status-pret_expedition   { background: #f3e5f5; color: #6a1b9a; border-color: #e1bee7; }
    .status-en_route          { background: #e8eaf6; color: #283593; border-color: #c5cae9; }
    .status-disponible        { background: #e0f2f1; color: #00695c; border-color: #b2dfdb; }
    .status-annule            { background: #fafafa; color: #999;     border-color: #ddd;    }
    .status-litige            { background: #fde8e8; color: #c62828; border-color: #ffcdd2; }

    /* Timeline */
    .timeline { display: flex; flex-direction: column; gap: 0; }
    .timeline-step {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        position: relative;
        padding-bottom: 1rem;
    }
    .timeline-step:last-child { padding-bottom: 0; }
    .timeline-dot {
        width: 12px; height: 12px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 4px;
        border: 2px solid #ddd;
        background: #fff;
        position: relative;
        z-index: 1;
    }
    .timeline-dot.done { background: #2e7d32; border-color: #2e7d32; }
    .timeline-dot.current { background: #ff750f; border-color: #ff750f; }
    .timeline-step:not(:last-child) .timeline-dot::after {
        content: '';
        position: absolute;
        top: 12px; left: 3px;
        width: 2px;
        height: calc(100% + 1rem - 12px);
        background: #eee;
        z-index: 0;
    }
    .timeline-label { font-size: 0.85rem; font-weight: 600; color: #555; }
    .timeline-label.done { color: #333; }
    .timeline-label.current { color: #ff750f; font-weight: 700; }

    /* Items table */
    .items-table { width: 100%; border-collapse: collapse; }
    .items-table th {
        font-size: 0.72rem; text-transform: uppercase; font-weight: 700;
        color: #aaa; letter-spacing: 0.04em;
        padding: 0 0 0.5rem 0; text-align: left;
        border-bottom: 1px solid #eee;
    }
    .items-table td {
        padding: 0.75rem 0; border-bottom: 1px solid #f5f5f5;
        vertical-align: middle;
        font-size: 0.875rem; color: #333;
    }
    .items-table tr:last-child td { border-bottom: none; }

    .item-img {
        width: 44px; height: 44px; border-radius: 5px;
        object-fit: cover; background: #f5f5f5;
        border: 1px solid #eee; flex-shrink: 0;
    }

    /* Meta rows */
    .meta-row {
        display: flex; justify-content: space-between;
        align-items: flex-start; padding: 0.55rem 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.875rem;
    }
    .meta-row:last-child { border-bottom: none; }
    .meta-key { color: #999; font-weight: 500; }
    .meta-val { color: #333; font-weight: 600; text-align: right; }

    /* Totals */
    .totals-row {
        display: flex; justify-content: space-between;
        padding: 0.5rem 0; font-size: 0.875rem;
    }
    .totals-final {
        display: flex; justify-content: space-between;
        padding: 0.75rem 0 0;
        border-top: 2px solid #222;
        font-size: 1rem; font-weight: 800; color: #222;
    }

    /* Back link */
    .back-link {
        display: inline-flex; align-items: center; gap: 6px;
        color: #666; text-decoration: none; font-size: 0.85rem;
        margin-bottom: 1.25rem;
        transition: color 0.2s;
    }
    .back-link:hover { color: #333; }
</style>
@endpush

@section('content')
<div class="breadcrumb">
    <a href="{{ route('home') }}">Accueil</a> > <a href="{{ route('vendeur.show') }}">Mon Compte Vendeur</a> > <a href="{{ route('vendeur.orders') }}">Mes ventes</a> > <span>#{{ $order->reference }}</span>
</div>

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">
        <a href="{{ route('vendeur.orders') }}" class="back-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Retour aux commandes
        </a>

        {{-- Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem;">
            <div>
                <h1 style="font-size: 1.4rem; font-weight: 800; margin: 0; color: #1a1a1a;">Commande <span style="color: #ff750f;">#{{ $order->reference }}</span></h1>
                <div style="font-size: 0.8rem; color: #aaa; margin-top: 3px;">Reçue le {{ $order->created_at->format('d/m/Y à H:i') }}</div>
            </div>
            <span class="status-badge status-{{ $order->statut }}">{{ $order->statut_label }}</span>
        </div>

        <div class="order-detail-grid">

            {{-- LEFT COLUMN --}}
            <div>
                {{-- Articles --}}
                <div class="detail-card">
                    <div class="detail-card-header">Articles commandés</div>
                    <div class="detail-card-body">
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th style="width: 52px;"></th>
                                    <th>Produit</th>
                                    <th style="text-align: center;">Qté</th>
                                    <th style="text-align: right;">Prix unit.</th>
                                    <th style="text-align: right;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            @php $photo = $item->annonce?->photos->first(); @endphp
                                            @if($photo)
                                                <img src="{{ asset('storage/' . $photo->path) }}" class="item-img" alt="">
                                            @else
                                                <div class="item-img"></div>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="font-weight: 600;">{{ $item->annonce ? $item->annonce->titre : 'Produit retiré' }}</div>
                                        </td>
                                        <td style="text-align: center; color: #666;">{{ $item->quantite }}</td>
                                        <td style="text-align: right; color: #666;">{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                        <td style="text-align: right; font-weight: 700;">{{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Totaux --}}
                        <div style="margin-top: 1.25rem; border-top: 1px solid #eee; padding-top: 1rem;">
                            <div class="totals-row">
                                <span style="color: #888;">Sous-total produits</span>
                                <span>{{ number_format($order->total_produits, 0, ',', ' ') }} FCFA</span>
                            </div>
                            @if($order->frais_port)
                                <div class="totals-row">
                                    <span style="color: #888;">Frais de port</span>
                                    <span>{{ number_format($order->frais_port, 0, ',', ' ') }} FCFA</span>
                                </div>
                            @endif
                            @if($order->commission_plateforme)
                                <div class="totals-row">
                                    <span style="color: #888;">Commission plateforme</span>
                                    <span style="color: #c62828;">− {{ number_format($order->commission_plateforme, 0, ',', ' ') }} FCFA</span>
                                </div>
                            @endif
                            <div class="totals-final">
                                <span>Total</span>
                                <span>{{ number_format($order->total_final ?? $order->total_produits, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Livraison --}}
                <div class="detail-card">
                    <div class="detail-card-header">Informations de livraison</div>
                    <div class="detail-card-body">
                        <div class="meta-row">
                            <span class="meta-key">Mode</span>
                            <span class="meta-val">{{ ucfirst(str_replace('_', ' ', $order->mode_livraison)) }}</span>
                        </div>
                        @if($order->adresse_livraison)
                            <div class="meta-row">
                                <span class="meta-key">Adresse</span>
                                <span class="meta-val" style="max-width: 220px;">{{ $order->adresse_livraison }}</span>
                            </div>
                        @endif
                        @if($order->notes_vendeur)
                            <div class="meta-row">
                                <span class="meta-key">Notes</span>
                                <span class="meta-val">{{ $order->notes_vendeur }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN --}}
            <div>
                {{-- Client --}}
                <div class="detail-card">
                    <div class="detail-card-header">Client</div>
                    <div class="detail-card-body">
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-weight: 800; color: #555; font-size: 1.1rem; flex-shrink: 0;">
                                {{ strtoupper(substr($order->buyer->prenom, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 700; color: #333;">{{ $order->buyer->prenom }} {{ $order->buyer->nom }}</div>
                                <div style="font-size: 0.8rem; color: #aaa;">{{ $order->buyer->email }}</div>
                            </div>
                        </div>
                        @if($order->buyer->telephone)
                            <div class="meta-row">
                                <span class="meta-key">Téléphone</span>
                                <span class="meta-val">{{ $order->buyer->telephone }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Suivi de statut --}}
                <div class="detail-card">
                    <div class="detail-card-header">Suivi de la commande</div>
                    <div class="detail-card-body">
                        @php
                            $steps = [
                                ['key' => 'en_attente',      'label' => 'En attente de paiement'],
                                ['key' => 'paye',            'label' => 'Payé — À préparer'],
                                ['key' => 'pret_expedition', 'label' => 'Prêt pour expédition'],
                                ['key' => 'en_route',        'label' => 'En cours de livraison'],
                                ['key' => 'disponible',      'label' => 'Disponible au point relais'],
                                ['key' => 'livre',           'label' => 'Livré'],
                            ];
                            $statuses  = array_column($steps, 'key');
                            $currentIdx = array_search($order->statut, $statuses);
                        @endphp
                        <div class="timeline">
                            @foreach($steps as $i => $step)
                                @php
                                    $isDone    = $currentIdx !== false && $i < $currentIdx;
                                    $isCurrent = $i === $currentIdx;
                                @endphp
                                <div class="timeline-step">
                                    <div class="timeline-dot {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}"></div>
                                    <span class="timeline-label {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}">{{ $step['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                        @if($order->statut === 'paye')
                            <div style="margin-top: 1.25rem; border-top: 1px solid #eee; padding-top: 1rem;">
                                <form method="POST" action="{{ route('logistique.vendeur.orders.ready', $order) }}">
                                    @csrf
                                    <button type="submit" style="width: 100%; background: #1a1a1a; color: #fff; border: none; padding: 0.6rem 1rem; border-radius: 6px; font-weight: 700; font-size: 0.85rem; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#333'" onmouseout="this.style.background='#1a1a1a'">
                                        ✓ Marquer comme prêt pour expédition
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
