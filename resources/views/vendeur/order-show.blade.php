@extends('layouts.app')

@section('title', 'Commande #{{ $order->reference }}')

@push('styles')
<style>
    .back-link {
        display: inline-flex; align-items: center; gap: 6px;
        color: #666; text-decoration: none; font-size: 0.85rem;
        margin-bottom: 1.25rem;
        transition: color 0.2s;
    }
    .back-link:hover { color: #333; }

    .order-summary-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .order-summary-header h1 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #222;
        margin: 0 0 6px 0;
    }

    .order-meta-row {
        font-size: 0.85rem;
        color: #555;
        line-height: 1.8;
    }

    .section-title {
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #333;
        margin-bottom: 0;
    }

    /* Articles block */
    .articles-block {
        border: 1px solid #e0e0e0;
        border-radius: 2px;
        margin-bottom: 1.5rem;
    }
    .articles-block-header {
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid #e8e8e8;
    }
    .article-row {
        padding: 1.25rem;
        border-bottom: 1px solid #f0f0f0;
    }
    .article-row:last-child { border-bottom: none; }

    /* Status badges */
    .badge-status {
        display: inline-block;
        padding: 3px 10px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        border-radius: 2px;
        margin-right: 6px;
    }
    .badge-livre   { background: #009966; color: #fff; }
    .badge-orange  { background: #f68b1e; color: #fff; }
    .badge-blue    { background: #004aad; color: #fff; }
    .badge-grey    { background: #888; color: #fff; }

    /* Two-col info grid */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .info-card {
        border: 1px solid #e0e0e0;
        border-radius: 2px;
        overflow: hidden;
    }
    .info-card-header {
        padding: 0.65rem 1rem;
        border-bottom: 1px solid #e8e8e8;
        font-size: 0.78rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #333;
    }
    .info-card-body {
        padding: 1rem;
    }
    .info-label {
        font-size: 0.9rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 3px;
    }
    .info-value {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 0.75rem;
    }
    .info-value:last-child { margin-bottom: 0; }

    /* Timeline card */
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
    .timeline-dot.done { background: #009966; border-color: #009966; }
    .timeline-dot.current { background: #f68b1e; border-color: #f68b1e; }
    .timeline-step:not(:last-child) .timeline-dot::after {
        content: '';
        position: absolute;
        top: 12px; left: 3px;
        width: 2px;
        height: calc(100% + 1rem - 12px);
        background: #e8e8e8;
        z-index: 0;
    }
    .timeline-label { font-size: 0.85rem; font-weight: 500; color: #aaa; }
    .timeline-label.done { color: #333; font-weight: 600; }
    .timeline-label.current { color: #f68b1e; font-weight: 700; }
</style>
@endpush

@section('content')

<div class="dashboard-container">
    @include('partials.profile-sidebar')

    <main class="main-content">
        <a href="{{ route('vendeur.orders') }}" class="back-link">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            Retour aux ventes
        </a>

        @if(session('success'))
            <div style="background:#e8f5e9; border:1px solid #a5d6a7; border-radius:4px; padding:0.75rem 1rem; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem; font-size:0.88rem; color:#2e7d32;">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background:#fde8e8; border:1px solid #ef9a9a; border-radius:4px; padding:0.75rem 1rem; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem; font-size:0.88rem; color:#c62828;">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Header résumé --}}
        <div class="order-summary-header" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1>Commande n° {{ $order->reference }}</h1>
                <div class="order-meta-row">
                    {{ $order->items->count() }} article(s)<br>
                    Effectuée le {{ $order->created_at->format('d-m-Y') }}<br>
                    Total : <strong>{{ number_format($order->total_final ?? $order->total_produits, 0, ',', ' ') }} FCFA</strong>
                </div>
            </div>

            <a href="{{ route('vendeur.orders.invoice', $order) }}" class="btn-download-invoice" style="display: inline-flex; align-items: center; gap: 8px; background-color: #f68b1e; color: white; padding: 0.6rem 1.2rem; border-radius: 4px; text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: background-color 0.2s;">
                <i class="fa-solid fa-file-pdf"></i>
                Bordereau PDF
            </a>
        </div>

        {{-- Articles --}}
        <div class="articles-block">
            <div class="articles-block-header">
                <span class="section-title">Articles dans votre commande</span>
            </div>

            @foreach($order->items as $item)
                <div class="article-row">

                    {{-- Badge statut commande + date --}}
                    <div style="margin-bottom: 12px;">
                        @php
                            $badgeColor = match($order->statut) {
                                'livre'           => '#009966',
                                'paye'            => '#009966',
                                'pret_expedition' => '#eab308', /* jaune */
                                'en_route'        => '#004aad',
                                'disponible'      => '#f68b1e',
                                'annule'          => '#888',
                                default           => '#f68b1e',
                            };
                        @endphp
                        <span style="display:inline-block; background:{{ $badgeColor }}; color:#fff; padding:3px 10px; font-size:0.7rem; font-weight:700; text-transform:uppercase; border-radius:2px;">
                            {{ $order->statut_label ?? Str::upper(str_replace('_', ' ', $order->statut)) }}
                        </span>
                        <div style="font-weight: 700; color: #222; font-size: 0.9rem; margin-top: 6px;">
                            Le {{ $order->updated_at->format('d-m-Y') }}
                        </div>
                    </div>

                    {{-- Produit --}}
                    <div style="display: flex; gap: 1.25rem; align-items: flex-start; padding-left: 0.5rem;">
                        @php $photo = $item->annonce?->photoPrincipale(); @endphp
                        <div style="width: 90px; height: 90px; flex-shrink: 0; border: 1px solid #eee; padding: 4px;">
                            @if($photo)
                                <img src="{{ Storage::url($photo->chemin) }}" style="width:100%; height:100%; object-fit:contain;">
                            @else
                                <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#ddd; font-size:1.5rem;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div style="font-size: 1rem; color: #333; margin-bottom: 6px;">
                                {{ $item->annonce ? $item->annonce->titre : 'Produit retiré' }}
                            </div>
                            <div style="font-size: 0.85rem; color: #555; margin-bottom: 8px;">
                                Quantité : <strong>{{ $item->quantite }}</strong>
                            </div>
                            <div style="font-size: 1.1rem; font-weight: 800; color: #222;">
                                {{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Grille Paiement + Livraison --}}
        <div class="info-grid">
            <div class="info-card">
                <div class="info-card-header">Paiement</div>
                <div class="info-card-body">
                    <div class="info-label">Mode de paiement</div>
                    <div class="info-value">{{ $order->mode_paiement ?? 'Non renseigné' }}</div>

                    <div class="info-label">Sous-total produits</div>
                    <div class="info-value">{{ number_format($order->total_produits, 0, ',', ' ') }} FCFA</div>


                    @php
                        $vendeur = Auth::user()->vendeur;
                        $abonnement = $vendeur ? $vendeur->abonnementActuel : null;
                        $tauxCommission = $abonnement ? $abonnement->commission : 15; // default 15
                        $commissionDynamique = $order->total_produits * ($tauxCommission / 100);
                    @endphp

                    @if($commissionDynamique > 0)
                        <div class="info-label">Commission plateforme ({{ $tauxCommission }}%)</div>
                        <div class="info-value" style="color: #c62828;">− {{ number_format($commissionDynamique, 0, ',', ' ') }} FCFA</div>
                    @elseif($order->commission_plateforme)
                        <div class="info-label">Commission plateforme</div>
                        <div class="info-value" style="color: #c62828;">− {{ number_format($order->commission_plateforme, 0, ',', ' ') }} FCFA</div>
                    @endif

                    <div style="border-top: 2px solid #333; margin-top: 0.75rem; padding-top: 0.75rem; display: flex; justify-content: space-between; font-weight: 800; font-size: 0.95rem;">
                        <span>Total</span>
                        <span>{{ number_format($order->total_final ?? $order->total_produits, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="info-card-header">Livraison</div>
                <div class="info-card-body">
                    <div class="info-label">Méthode de livraison</div>
                    <div class="info-value">{{ ucfirst(str_replace('_', ' ', $order->mode_livraison ?? 'Non renseigné')) }}</div>

                    @if($order->adresse_livraison)
                        <div class="info-label">Adresse de livraison</div>
                        <div class="info-value">{{ $order->adresse_livraison }}</div>
                    @endif

                    <div class="info-label">Client</div>
                    <div class="info-value">
                        {{ $order->buyer->prenom }} {{ $order->buyer->nom }}<br>
                        <span style="color: #aaa;">{{ $order->buyer->email }}</span>
                        @if($order->buyer->telephone)
                            <br><span style="color: #aaa;">{{ $order->buyer->telephone }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Suivi de la commande --}}
        <div class="info-card" style="margin-bottom: 1.5rem;">
            <div class="info-card-header">Suivi de la commande</div>
            <div class="info-card-body">
                @php
                    $steps = [
                        ['key' => 'en_attente',      'label' => 'En attente de paiement'],
                        ['key' => 'paye',            'label' => 'Payé — À préparer'],
                        ['key' => 'pret_expedition', 'label' => 'Prêt pour expédition'],
                        ['key' => 'en_route',        'label' => 'En cours de livraison'],
                        ['key' => 'disponible',      'label' => 'Disponible au point relais'],
                        ['key' => 'livre',           'label' => 'Livré'],
                    ];
                    $statuses   = array_column($steps, 'key');
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
                    <div style="margin-top: 1.25rem; border-top: 1px solid #eee; padding-top: 1rem; background: #fffbf5; border: 1px solid #f68b1e; border-radius: 4px; padding: 1rem;">
                        <form method="POST" action="{{ route('logistics.markAsReady', $order) }}">
                            @csrf
                            <button type="submit" style="width: 100%; background: #f68b1e; color: #fff; border: none; padding: 0.75rem 1rem; border-radius: 4px; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                                ✓ Mettre en préparation
                            </button>
                        </form>
                    </div>
                @elseif($order->statut === 'pret_expedition')
                    <div style="margin-top: 1.25rem; border-top: 1px solid #eee; padding-top: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; color: #009966; font-weight: 700; font-size: 0.9rem;">
                            <i class="fa-solid fa-circle-check"></i>
                            Commande acceptée — en attente de ramassage
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </main>
</div>
@endsection
