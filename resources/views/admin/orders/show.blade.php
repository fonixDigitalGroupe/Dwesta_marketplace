@extends('layouts.admin')

@section('title', 'Commande ' . $order->reference . ' - Administration')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
    .amazon-card {
        background: #fff;
        border: 1px solid #f0f0f0;
        border-radius: 4px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        padding: 15px 25px 25px 25px;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        display: flex;
        align-items: center;
    }
    .section-title i { color: #f68b1e; font-size: 0.9rem; }

    .btn-amazon-secondary {
        background: #fff;
        border: 1px solid #ddd;
        color: #565959;
        padding: 6px 15px;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .btn-amazon-secondary:hover { background: #f7f7f7; border-color: #ccc; color: #111; }

    .info-row {
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 15px;
        margin-bottom: 12px;
        font-size: 0.85rem;
    }
    .info-label { color: #555; font-weight: 500; }
    .info-value { color: #111; font-weight: 600; }

    .status-badge-premium {
        padding: 3px 12px;
        border-radius: 12px;
        font-size: 0.72rem;
        font-weight: 800;
        display: inline-block;
        text-transform: uppercase;
    }

    /* Article List Table - Inspired by Amazon Table */
    .table-articles {
        width: 100%; border-collapse: collapse; border: 1px solid #e7e7e7; margin-top: 10px;
    }
    .table-articles th {
        background: #d1d5db; padding: 10px 15px; text-align: left; font-size: 0.72rem; font-weight: 800; color: #111; text-transform: uppercase; border-bottom: 1px solid #e7e7e7; border-right: 1px solid #e7e7e7;
    }
    .table-articles td {
        padding: 12px 15px; font-size: 0.85rem; border-bottom: 1px solid #e7e7e7; border-right: 1px solid #e7e7e7; vertical-align: middle;
    }

    .article-img-mini {
        width: 50px; height: 50px; object-fit: contain; border: 1px solid #eee; padding: 2px; background: #fff;
    }

    /* Timeline Section */
    .timeline-premium { display: flex; flex-direction: column; gap: 0; }
    .timeline-item {
        display: flex; gap: 1rem; align-items: flex-start; position: relative; padding-bottom: 1.25rem;
    }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-dot {
        width: 12px; height: 12px; border-radius: 50%; border: 2px solid #ddd; background: #fff; margin-top: 4px; z-index: 1;
    }
    .timeline-dot.done { background: #569b00; border-color: #569b00; }
    .timeline-dot.current { background: #f68b1e; border-color: #f68b1e; }
    .timeline-item:not(:last-child)::after {
        content: ''; position: absolute; left: 5px; top: 16px; width: 2px; height: calc(100% - 12px); background: #eee;
    }
    .timeline-text { font-size: 0.82rem; font-weight: 500; color: #888; }
    .timeline-text.done { color: #111; font-weight: 600; }
    .timeline-text.current { color: #f68b1e; font-weight: 700; }

    /* Financials */
    .bill-summary { margin-top: 15px; border-top: 1px solid #f0f0f0; padding-top: 15px; }
    .bill-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.85rem; }
    .bill-total { color: #111; font-weight: 800; font-size: 1rem; margin-top: 5px; border-top: 2px solid #333; padding-top: 8px; }
</style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto; margin-top: -50px;">
    <div style="background: #fff; border: 1px solid #e7e7e7; padding: 25px;">
        
        <!-- Action Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid #f0f0f0;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <a href="{{ route('admin.orders.index') }}" class="btn-amazon-secondary" style="padding: 6px 12px;">
                    <i class="fas fa-chevron-left"></i> Retour
                </a>
                <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">
                    Détails de la Commande : {{ $order->reference }}
                </h1>
            </div>

            <div>
                @php
                    $badgeStyle = match($order->statut) {
                        'livre', 'paye' => 'background:#f7fff0; color:#569b00; border:1px solid #c7e5a1;',
                        'pret_expedition', 'disponible' => 'background:#fff8f3; color:#f68b1e; border:1px solid #fbd8b4;',
                        'en_route' => 'background:#f0f7ff; color:#004aad; border:1px solid #c2e0ff;',
                        'annule', 'litige' => 'background:#fff5f5; color:#c40000; border:1px solid #f9c2c2;',
                        default => 'background:#f6f6f6; color:#555; border:1px solid #ddd;',
                    };
                @endphp
                <span class="status-badge-premium" style="{{ $badgeStyle }}">
                    {{ $order->statut_label }}
                </span>
            </div>
        </div>

        <!-- Row 1: Summary & Main Info -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            
            <!-- Informations de base -->
            <div class="amazon-card" style="margin-bottom: 0;">
                <h2 class="section-title">Informations Générales</h2>
                <div class="info-row"><span class="info-label">Référence</span> <span class="info-value">{{ $order->reference }}</span></div>
                <div class="info-row"><span class="info-label">Date de création</span> <span class="info-value">{{ $order->created_at->format('d/m/Y à H:i') }}</span></div>
                <div class="info-row"><span class="info-label">Mode d'expédition</span> <span class="info-value">{{ ucfirst(str_replace('_', ' ', $order->mode_livraison)) }}</span></div>
                <div class="info-row"><span class="info-label">Mode de paiement</span> <span class="info-value">{{ $order->mode_paiement }}</span></div>
                <div class="info-row"><span class="info-label">Dernière mise à jour</span> <span class="info-value">{{ $order->updated_at->format('d/m/Y à H:i') }}</span></div>
            </div>

            <!-- Suivi Logistique -->
            <div class="amazon-card" style="margin-bottom: 0;">
                <h2 class="section-title">Suivi de Commande</h2>
                @php
                    $steps = [
                        'en_attente' => 'En attente de paiement',
                        'paye' => 'Payé — À préparer',
                        'pret_expedition' => 'Prêt pour expédition',
                        'en_route' => 'En cours de livraison',
                        'disponible' => 'Disponible au point relais',
                        'livre' => 'Livré'
                    ];
                    $statuses = array_keys($steps);
                    $currentIdx = array_search($order->statut, $statuses);
                @endphp
                <div class="timeline-premium">
                    @foreach($steps as $key => $label)
                        @php 
                            $isDone = $currentIdx !== false && array_search($key, $statuses) < $currentIdx;
                            $isCurrent = $order->statut === $key;
                        @endphp
                        <div class="timeline-item">
                            <div class="timeline-dot {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}"></div>
                            <span class="timeline-text {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Row 2: Stakeholders -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            
            <!-- Acheteur -->
            <div class="amazon-card" style="margin-bottom: 0;">
                <h2 class="section-title">Acheteur (Client)</h2>
                <div class="info-row"><span class="info-label">Nom Complet</span> <span class="info-value" style="color: #004aad;">{{ $order->buyer->prenom }} {{ $order->buyer->nom }}</span></div>
                <div class="info-row"><span class="info-label">Email</span> <span class="info-value">{{ $order->buyer->email }}</span></div>
                <div class="info-row"><span class="info-label">Téléphone</span> <span class="info-value">{{ $order->buyer->telephone ?? 'Non renseigné' }}</span></div>
                <div class="info-row" style="margin-top: 15px;"><span class="info-label">Adresse de livraison</span> <span class="info-value" style="font-weight: 500; font-style: italic;">{{ $order->adresse_livraison }}</span></div>
            </div>

            <!-- Vendeur -->
            <div class="amazon-card" style="margin-bottom: 0;">
                <h2 class="section-title">Vendeur</h2>
                <div class="info-row"><span class="info-label">Boutique</span> <span class="info-value" style="color: #004aad;">{{ $order->seller->nom_boutique ?? $order->seller->user->full_name }}</span></div>
                <div class="info-row"><span class="info-label">Propriétaire</span> <span class="info-value">{{ $order->seller->user->prenom }} {{ $order->seller->user->nom }}</span></div>
                <div class="info-row"><span class="info-label">Type</span> <span class="info-value">{{ strtoupper($order->seller->type) }}</span></div>
                <div style="margin-top: 20px; border-top: 1px solid #f0f0f0; padding-top: 12px;">
                    <a href="{{ route('admin.vendeurs.verification.show', $order->seller) }}" class="btn-amazon-secondary" style="font-size: 0.75rem; padding: 4px 10px;">
                        Voir fiche vendeur <i class="fas fa-external-link-alt" style="font-size: 0.7rem;"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Row 3: Articles & Bill -->
        <div class="amazon-card">
            <h2 class="section-title">Articles commandés</h2>
            <table class="table-articles">
                <thead>
                    <tr>
                        <th style="width: 60px;">Image</th>
                        <th>Désignation du produit</th>
                        <th style="text-align: center;">Quantité</th>
                        <th style="text-align: right;">Prix Unitaire</th>
                        <th style="text-align: right;">Total Ligne</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>
                                @php $photo = $item->annonce?->photoPrincipale(); @endphp
                                <img src="{{ $photo ? $photo->url : 'https://via.placeholder.com/100' }}" class="article-img-mini">
                            </td>
                            <td>
                                <div style="font-weight: 700; color: #111;">{{ $item->annonce ? $item->annonce->titre : 'Produit retiré' }}</div>
                                <div style="font-size: 0.75rem; color: #888;">Condition: {{ $item->annonce->condition ?? '-' }}</div>
                            </td>
                            <td style="text-align: center; font-weight: 600;">{{ $item->quantite }}</td>
                            <td style="text-align: right;">{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                            <td style="text-align: right; font-weight: 800;">{{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="display: flex; justify-content: flex-end;">
                <div style="width: 350px;" class="bill-summary">
                    <div class="bill-row"><span>Sous-total produits:</span> <span style="font-weight: 600;">{{ number_format($order->total_produits, 0, ',', ' ') }} FCFA</span></div>
                    <div class="bill-row"><span>Frais d'expédition:</span> <span style="font-weight: 600;">0 FCFA</span></div>
                    <div class="bill-row" style="color: #c40000;"><span>Commission Plateforme:</span> <span style="font-weight: 600;">−{{ number_format($order->commission_plateforme, 0, ',', ' ') }} FCFA</span></div>
                    <div class="bill-total"><span>Total Final:</span> <span>{{ number_format($order->total_final, 0, ',', ' ') }} FCFA</span></div>
                </div>
            </div>
        </div>

        <!-- Danger Zone (Action Bar) -->
        <div style="display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #f0f0f0; margin-top: 25px; padding-top: 20px;">
            <button onclick="window.print()" class="btn-amazon-secondary">
                <i class="fas fa-print"></i> Imprimer
            </button>
            <a href="{{ route('vendeur.orders.invoice', $order) }}" class="btn-amazon-secondary" style="background: #f6f6f6;">
                <i class="fas fa-file-invoice"></i> Télécharger Facture
            </a>
        </div>

    </div>
</div>
@endsection
