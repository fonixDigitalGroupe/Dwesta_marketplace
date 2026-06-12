@extends('layouts.app')

@section('title', 'Suivi de Commande #' . $order->reference . ' - Karnou')

@push('styles')
<style>
    .track-container { max-width: 900px; margin: 2rem auto; padding: 0 1rem; }
    
    .status-card { background: white; border: 1px solid #e0e0e0; border-radius: 8px; padding: 2rem; margin-bottom: 2rem; }
    .track-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 1px solid #eee; padding-bottom: 1rem; }
    
    .timeline { position: relative; padding: 2rem 0; list-style: none; }
    .timeline::before { content: ''; position: absolute; top: 0; bottom: 0; left: 30px; width: 2px; background: #eee; }
    
    .timeline-item { position: relative; margin-bottom: 2.5rem; padding-left: 70px; }
    .timeline-dot { position: absolute; left: 21px; width: 20px; height: 20px; border-radius: 50%; background: #eee; border: 4px solid white; z-index: 2; transition: all 0.3s; }
    .timeline-item.active .timeline-dot { background: #bf0000; box-shadow: 0 0 0 4px #fdf2f2; }
    .timeline-item.completed .timeline-dot { background: #28a745; }
    
    .timeline-content { transition: all 0.3s; }
    .timeline-item.active .timeline-content { transform: translateX(5px); }
    .timeline-title { font-weight: bold; font-size: 1.1rem; margin-bottom: 0.25rem; }
    .timeline-date { font-size: 0.85rem; color: #999; }
    .timeline-desc { font-size: 0.95rem; color: #666; margin-top: 0.5rem; }

    .qr-box { background: #f9f9f9; border: 2px dashed #ddd; border-radius: 8px; padding: 2rem; text-align: center; margin-top: 2rem; }
    .qr-placeholder { width: 150px; height: 150px; background: white; margin: 0 auto 1.5rem; border: 1px solid #eee; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; color: #999; }
    
    .btn-action { display: inline-block; padding: 0.8rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: bold; transition: all 0.2s; }
    .btn-primary { background: #bf0000; color: white; }
</style>
@endpush

@section('content')
<div class="track-container">
    <div class="status-card">
        <div class="track-header">
            <div>
                <h1 style="font-size: 1.25rem; font-weight: bold;">Commande #{{ $order->reference }}</h1>
                <p style="color: #666; font-size: 0.9rem;">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <div style="text-align: right;">
                <span style="background: #fdf2f2; color: #bf0000; padding: 0.4rem 1rem; border-radius: 20px; font-weight: bold; font-size: 0.9rem;">
                    {{ strtoupper(str_replace('_', ' ', $order->statut)) }}
                </span>
            </div>
        </div>

        <ul class="timeline">
            @php
                $steps = [
                    'paye' => ['title' => 'Commande payée', 'desc' => 'Votre paiement a été validé. Le vendeur prépare votre colis.'],
                    'en_attente_depot' => ['title' => 'En attente de dépôt', 'desc' => 'Le colis est prêt et attend d\'être déposé en point relais.'],
                    'en_point_relais' => ['title' => 'Arrivé au point relais', 'desc' => 'Votre colis est disponible ! Présentez votre QR Code pour le retirer.'],
                    'receptionne' => ['title' => 'Commande réceptionnée', 'desc' => 'Merci d\'avoir fait confiance à Karnou !'],
                ];
                
                $currentStatus = $order->statut;
                $statusOrder = ['paye', 'en_attente_depot', 'en_point_relais', 'receptionne'];
                $currentIndex = array_search($currentStatus, $statusOrder);
            @endphp

            @foreach($statusOrder as $index => $statusKey)
                @if(isset($steps[$statusKey]))
                    <li class="timeline-item {{ $index < $currentIndex ? 'completed' : ($index == $currentIndex ? 'active' : '') }}">
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">{{ $steps[$statusKey]['title'] }}</div>
                            <div class="timeline-desc">{{ $steps[$statusKey]['desc'] }}</div>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>

        @if($order->statut == 'en_point_relais')
            <div class="qr-box">
                <h3 style="margin-bottom: 1rem; font-weight: bold;">Code de retrait</h3>
                <div class="qr-placeholder">
                    <!-- Simulation QR Code -->
                    <div style="text-align: center;">
                        <span style="font-size: 2rem;">🔳</span><br>
                        {{ $order->qr_code_token }}
                    </div>
                </div>
                <p style="font-size: 0.9rem; color: #666;">Présentez ce code à l'agent du point relais pour retirer votre commande.</p>
            </div>
        @endif
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        <div class="status-card">
            <h3 style="font-weight: bold; margin-bottom: 1rem;">Détails de livraison</h3>
            <p style="font-size: 0.95rem; line-height: 1.6;">
                <strong>Mode :</strong> {{ $order->mode_livraison == 'point_relais' ? 'Point Relais Mady' : 'Domicile' }}<br>
                <strong>Adresse :</strong><br>
                {{ $order->adresse_livraison }}
            </p>
        </div>
        <div class="status-card">
            <h3 style="font-weight: bold; margin-bottom: 1rem;">Vendeur</h3>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 40px; height: 40px; background: #eee; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                    {{ strtoupper(substr($order->seller->user->prenom, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight: bold;">{{ $order->seller->user->prenom }}</div>
                    <div style="font-size: 0.85rem; color: #999;">Délai de réponse : < 24h</div>
                </div>
            </div>
            <a href="#" class="btn-action" style="background: #f5f5f5; color: #333; margin-top: 1.5rem; display: block; text-align: center;">Contacter le vendeur</a>
        </div>
    </div>
</div>
@endsection
