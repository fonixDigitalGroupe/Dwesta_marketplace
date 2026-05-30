@extends('layouts.app')

@section('title', 'Détails Commande #{{ $order->reference }}')

@push('styles')
    <style>
        .page-header-pro {
            background: #fff;
            padding: 1rem 1.5rem;
            margin-bottom: 0.5rem;
        }

        .back-link-pro {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #333;
            margin-bottom: 1rem;
        }

        .back-link-pro h2 {
            font-size: 1.15rem;
            margin: 0;
            font-weight: 600;
        }

        .order-meta-pro {
            font-size: 0.85rem;
            color: #75757a;
            line-height: 1.4;
        }

        .order-ref-pro {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 2px;
            display: block;
        }

        .btn-cancel-pro {
            background: transparent;
            color: #d32f2f;
            border: 1px solid #d32f2f;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-block;
            text-transform: uppercase;
        }
        .btn-cancel-pro:hover {
            background: #fdf2f2;
        }

        .section-title-pro {
            font-size: 0.85rem;
            font-weight: 700;
            color: #333;
            text-transform: uppercase;
            margin: 1rem -1.5rem 1rem -1.5rem;
            padding: 0.75rem 1.5rem 0 2rem;
            border-top: 1px solid #eee;
        }

        /* Article Card Pro */
        .article-card-pro {
            background: #fff;
            border: 1px solid #ededed;
            border-radius: 4px;
            margin-bottom: 1rem;
            padding: 1.5rem;
            position: relative;
        }

        .status-badge-pro {
            background: #75757a;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 2px;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .delivery-date-pro {
            font-size: 0.9rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }

        .article-flex-pro {
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
        }

        .article-img-pro {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border: 1px solid #f0f0f0;
            padding: 4px;
        }

        .article-info-pro {
            flex: 1;
        }

        .article-info-pro h4 {
            font-size: 1rem;
            margin: 0 0 8px 0;
            color: #333;
            font-weight: 500;
        }

        .article-price-row {
            margin-top: 1rem;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .old-price {
            text-decoration: line-through;
            color: #75757a;
            font-size: 0.9rem;
            margin-left: 8px;
            font-weight: 400;
        }

        .article-actions-pro {
            display: flex;
            flex-direction: column;
            gap: 10px;
            min-width: 180px;
        }

        .btn-jumia-orange {
            background: #f68b1e;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-radius: 4px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.9rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-jumia-text {
            color: #f68b1e;
            text-align: center;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* Summary Grid */
        .summary-grid-pro {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-card-pro {
            background: #fff;
            border: 1px solid #ededed;
            border-radius: 4px;
        }

        .summary-card-header {
            padding: 12px 15px;
            border-bottom: 1px solid #ededed;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            background: #ffffff;
            color: #333;
        }

        .summary-card-body {
            padding: 20px 15px;
        }

        .summary-item-pro {
            margin-bottom: 1.5rem;
        }

        .summary-label-pro {
            font-size: 0.95rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 6px;
        }

        .summary-value-pro {
            font-size: 0.9rem;
            color: #75757a;
            line-height: 1.5;
        }

        .price-summary-pro {
            border-top: 1px solid #eee;
            padding-top: 10px;
            margin-top: 10px;
        }

        .price-row-pro {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 0.9rem;
            color: #75757a;
        }

        .price-row-total-pro {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            font-size: 1rem;
            color: #333;
            margin-top: 10px;
        }

        /* Re-using Vertical Timeline Styles */
        :root {
            --jumia-orange: #f68b1e;
            --jumia-green: #4caf50;
            --jumia-text-muted: #75757a;
        }

        .timeline-box {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin: 10px 0;
        }

        .timeline-step {
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
            position: relative;
            padding-bottom: 2rem;
        }

        .timeline-step:last-child { padding-bottom: 0; }
        .timeline-marker { display: flex; flex-direction: column; align-items: center; flex-shrink: 0; }
        .timeline-dot {
            width: 24px; height: 24px; background: white; border: 3px solid #e0e0e0; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; font-size: 11px; color: #999;
            z-index: 2; transition: all 0.3s;
        }
        .timeline-step.completed .timeline-dot { background: var(--jumia-orange); border-color: var(--jumia-orange); color: white; }
        .timeline-step.active .timeline-dot { border-color: var(--jumia-orange); color: var(--jumia-orange); font-weight: 700; transform: scale(1.1); }
        .timeline-line { position: absolute; top: 24px; left: 11px; bottom: 0; width: 2px; background: #e0e0e0; z-index: 1; }
        .timeline-step.completed .timeline-line { background: var(--jumia-orange); }
        .timeline-step:last-child .timeline-line { display: none; }
        .timeline-content { padding-top: 2px; }
        .timeline-label { font-size: 0.9rem; font-weight: 600; color: #999; }
        .timeline-step.completed .timeline-label { color: #333; }
        .timeline-step.active .timeline-label { color: var(--jumia-orange); font-weight: 700; }

        .btn-jumia-orange {
            background-color: #f68b1e;
            color: #fff !important;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
            transition: background 0.2s;
            border: none;
        }
        .btn-jumia-orange:hover {
            background-color: #e67e00;
            color: #fff !important;
        }
    </style>
@endpush

@section('content')

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content" style="padding: 0; background: #fff;">
            
            {{-- Pro Header --}}
            <div class="page-header-pro" style="padding: 1rem 1.5rem;">
                <a href="{{ route('account.orders') }}" class="back-link-pro" style="border-bottom: 1px solid #eee; padding-bottom: 0.5rem; margin-bottom: 1rem; margin-left: -1.5rem; margin-right: -1.5rem; padding-left: 1.5rem; padding-right: 1.5rem;">
                    <i class="fas fa-arrow-left"></i>
                    <h2>Détails de la commande</h2>
                </a>
                <div class="order-meta-pro" style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <span class="order-ref-pro">Commande n° {{ $order->reference }}</span>
                        {{ $order->items->count() }} @if($order->items->count() > 1) articles @else article @endif<br>
                        Effectuée le {{ $order->created_at->format('d-m-Y') }}<br>
                        Total : {{ number_format($order->total_final ?? $order->total_produits, 0, ',', ' ') }} FCFA
                    </div>
                    @if(in_array($order->statut, ['en_attente', 'paye', 'pret_expedition']))
                        <form action="{{ route('account.orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                            @csrf
                            <button type="submit" class="btn-cancel-pro">Annuler la commande</button>
                        </form>
                    @endif
                </div>
            </div>

            <div style="padding: 0 1.5rem 2rem 1.5rem; background: #fff;">
                <div style="background: #fff; padding: 0;">
                    
                    @if(session('success'))
                    <div x-data="{ show: true }" 
                         x-init="setTimeout(() => show = false, 5000)" 
                         x-show="show"
                         x-transition:leave="transition ease-in duration-500"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         style="background:#e8f5e9; border:1px solid #a5d6a7; border-radius:4px; padding:0.75rem 1rem; margin-bottom:1rem; color:#2e7d32; font-size:0.88rem;">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div x-data="{ show: true }" 
                         x-init="setTimeout(() => show = false, 5000)" 
                         x-show="show"
                         x-transition:leave="transition ease-in duration-500"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         style="background:#ffebee; border:1px solid #ffcdd2; border-radius:4px; padding:0.75rem 1rem; margin-bottom:1rem; color:#c62828; font-size:0.88rem;">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                    </div>
                    @endif

                <div class="section-title-pro">ARTICLES DANS VOTRE COMMANDE</div>

                @foreach($order->items as $item)
                    <div class="article-card-pro">
                        <div class="status-badge-pro">
                            @switch($order->statut)
                                @case('en_attente') En attente @break
                                @case('paye') Confirmée @break
                                @case('pret_expedition') En préparation @break
                                @case('en_route') En route @break
                                @case('livre') Livrée @break
                                @default {{ ucfirst(str_replace('_', ' ', $order->statut)) }}
                            @endswitch
                        </div>
                        <div class="delivery-date-pro">
                            @if($order->statut === 'livre')
                                Livré le {{ $order->updated_at->format('d-m-Y') }}
                            @else
                                Livraison prévue : {{ $order->created_at->addDays(3)->format('d-m-Y') }}
                            @endif
                        </div>

                        <div class="article-flex-pro">
                            @php $photo = $item->annonce?->photoPrincipale(); @endphp
                            <img src="{{ $photo ? Storage::url($photo->chemin) : 'https://via.placeholder.com/80' }}" class="article-img-pro">
                            
                            <div class="article-info-pro">
                                <h4>{{ $item->annonce ? $item->annonce->titre : 'Produit retiré' }}</h4>
                                <div class="summary-value-pro" style="margin-bottom: 10px;">Quantité : {{ $item->quantite }}</div>
                                
                                <div class="article-price-row">
                                    {{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA
                                    @if($item->annonce && $item->annonce->prix_barre)
                                        <span class="old-price">{{ number_format($item->annonce->prix_barre, 0, ',', ' ') }} FCFA</span>
                                    @endif
                                </div>

                                <div style="margin-top: 15px; font-size: 0.85rem; color: #75757a;">
                                    <i class="fas fa-undo-alt"></i> Politique de retour applicable.
                                </div>
                            </div>

                            <div class="article-actions-pro">
                                @if($item->annonce)
                                    <a href="{{ route('annonces.show', $item->annonce->slug) }}" class="btn-jumia-orange">Commander à nouveau</a>
                                @endif
                                <a href="{{ route('account.orders.tracking', $order->id) }}" class="btn-jumia-text">Historique du colis</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="summary-grid-pro">
                    {{-- Paiement --}}
                    <div class="summary-card-pro">
                        <div class="summary-card-header">PAIEMENT</div>
                        <div class="summary-card-body">
                            <div class="summary-item-pro">
                                <div class="summary-label-pro">Mode de paiement</div>
                                <div class="summary-value-pro" style="display: flex; align-items: center; gap: 8px;">
                                    @if($order->moyen_paiement === 'om')
                                        <img src="{{ asset('images/logoOM.png') }}" alt="Orange Money" style="height: 20px; object-fit: contain;">
                                        <span>Orange Money</span>
                                    @elseif($order->moyen_paiement === 'wave')
                                        <img src="{{ asset('images/logowave.png') }}" alt="Wave" style="height: 20px; object-fit: contain;">
                                        <span>Wave</span>
                                    @elseif($order->moyen_paiement === 'cb')
                                        <i class="fas fa-credit-card"></i>
                                        <span>Carte Bancaire</span>
                                    @elseif($order->moyen_paiement === 'gift_card')
                                        <i class="fas fa-gift" style="color: #2e7d32;"></i>
                                        <span style="color: #2e7d32; font-weight: 700;">Carte Cadeau</span>
                                    @elseif($order->moyen_paiement === 'livraison_buyer' || $order->moyen_paiement === 'livraison_receiver')
                                        <i class="fas fa-handshake"></i>
                                        <span>Paiement à la livraison</span>
                                    @elseif($order->moyen_paiement === 'wallet')
                                        <i class="fas fa-wallet"></i>
                                        <span>Portefeuille Dwesta</span>
                                    @else
                                        <span>{{ ucfirst(str_replace('_', ' ', $order->moyen_paiement ?? 'Non renseigné')) }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="summary-label-pro">Détails du paiement</div>
                            <div class="price-summary-pro">
                                <div class="price-row-pro">
                                    <span>Sous-total items</span>
                                    <span>{{ number_format($order->total_produits, 0, ',', ' ') }} FCFA</span>
                                </div>
                                <div class="price-row-pro">
                                    <span>Frais de livraison</span>
                                    <span>{{ number_format($order->frais_livraison ?? 0, 0, ',', ' ') }} FCFA</span>
                                </div>
                                <div class="price-row-total-pro">
                                    <span>Total</span>
                                    <span>{{ number_format($order->total_final ?? $order->total_produits, 0, ',', ' ') }} FCFA</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Livraison --}}
                    <div class="summary-card-pro">
                        <div class="summary-card-header">LIVRAISON</div>
                        <div class="summary-card-body">
                            <div class="summary-item-pro">
                                <div class="summary-label-pro">Méthode de livraison</div>
                                <div class="summary-value-pro">{{ ucfirst(str_replace('_', ' ', $order->mode_livraison ?? 'Non renseigné')) }}</div>
                            </div>

                            <div class="summary-item-pro">
                                <div class="summary-label-pro">@if($order->mode_livraison === 'point_relais') Adresse du point relais @else Adresse de livraison @endif</div>
                                <div class="summary-value-pro" style="line-height:1.5;">
                                    @if($order->adresse_livraison)
                                        {!! nl2br(e($order->adresse_livraison)) !!}
                                    @else
                                        Non renseignée
                                    @endif
                                </div>
                            </div>

                            <div class="summary-item-pro">
                                <div class="summary-label-pro">Détails d'expédition</div>
                                <div class="summary-value-pro">
                                    Expédié par {{ $order->seller?->user?->nom ?? 'Dwesta' }} {{ $order->seller?->user?->prenom ?? '' }}<br>
                                    Livraison prévue le {{ $order->created_at->addDays(4)->format('d-m-Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 </div>
            </div>
                </div>
            </div>
        </main>
    </div>
@endsection