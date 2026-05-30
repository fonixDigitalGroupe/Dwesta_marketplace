@extends('layouts.app')

@section('title', 'Historique du colis #' . $order->reference)

@push('styles')
    <style>
        .tracking-container {
            background: #fff;
            min-height: 100vh;
        }

        .tracking-header {
            padding: 1rem 1.5rem;
            background: #fff;
        }

        .back-btn {
            color: #333;
            font-size: 1.5rem;
            margin-right: 1.5rem;
            text-decoration: none;
        }

        .tracking-header h1 {
            font-size: 1.15rem;
            font-weight: 600;
            margin: 0;
            color: #333;
        }

        .tracking-content {
            padding: 2rem 3rem;
        }

        .tracking-timeline {
            position: relative;
        }

        .tracking-item {
            display: flex;
            gap: 1.25rem;
            position: relative;
            padding-bottom: 1.5rem;
        }

        .tracking-item:last-child {
            padding-bottom: 0;
        }

        /* The vertical line */
        .tracking-item::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 12px;
            /* Center of the 24px dot */
            bottom: 0;
            width: 2px;
            background: #f68b1e;
            /* Jumia style line */
            z-index: 1;
        }

        .tracking-item:last-child::before {
            display: none;
        }

        .tracking-marker {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #f68b1e;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            z-index: 2;
            color: #fff;
        }

        .tracking-marker.completed {
            background: #f68b1e;
        }

        .tracking-marker.failed {
            background: #d32f2f;
            border-color: #d32f2f;
        }

        .tracking-marker i {
            font-size: 0.75rem;
        }

        .tracking-marker.pending {
            background: #fff;
            border-color: #75757a;
            color: #75757a;
        }

        .tracking-info {
            padding-top: 5px;
        }

        .tracking-label {
            display: inline-block;
            background: #fff3e0;
            color: #f68b1e;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 4px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .tracking-label.failed {
            background: #75757a;
        }

        .tracking-date {
            display: block;
            font-size: 0.8rem;
            color: #333;
            margin-bottom: 6px;
        }

        .tracking-desc {
            font-size: 0.85rem;
            color: #75757a;
            line-height: 1.5;
            max-width: 500px;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container" style="background: #f5f5f5; padding-top: 2rem; padding-bottom: 2rem;">
        @include('partials.profile-sidebar')

        <main class="main-content"
            style="padding: 0; background: #fff; border-radius: 4px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">

            <div class="tracking-header" style="padding: 1rem 1.5rem;">
                <a href="{{ route('account.orders.show', $order->id) }}" class="back-link-pro"
                    style="border-bottom: 1px solid #eee; padding-bottom: 0.5rem; margin-bottom: 1rem; display: flex; align-items: center; gap: 12px; text-decoration: none; color: #333; width: calc(100% + 3rem); margin-left: -1.5rem; margin-right: -1.5rem; padding-left: 1.5rem; padding-right: 1.5rem;">
                    <i class="fas fa-arrow-left"></i>
                    <h1 style="font-size: 1.15rem; font-weight: 600; margin: 0;">Historique du colis</h1>
                </a>
            </div>

            <div class="tracking-content">
                @php
                    $statut = $order->statut;
                    $isDoneAll = in_array($statut, ['livre', 'annule', 'litige']);

                    // Logic to build steps based on current status (6 steps)
                    $steps = [
                        [
                            'id' => 'placed',
                            'label' => 'COMMANDE EFFECTUÉE',
                            'done' => true,
                            'date' => $order->created_at->format('d-m'),
                            'active' => ($statut === 'en_attente')
                        ],
                        [
                            'id' => 'confirmed',
                            'label' => 'EN ATTENTE DE CONFIRMATION',
                            'done' => in_array($statut, ['paye', 'pret_expedition', 'en_route', 'disponible', 'livre', 'annule', 'litige']),
                            'date' => in_array($statut, ['paye', 'pret_expedition', 'en_route', 'disponible', 'livre', 'annule', 'litige']) ? $order->created_at->format('d-m') : null,
                            'active' => ($statut === 'paye')
                        ],
                        [
                            'id' => 'preparin',
                            'label' => 'EN ATTENTE D\'EXPÉDITION',
                            'done' => in_array($statut, ['pret_expedition', 'en_route', 'disponible', 'livre', 'annule', 'litige']),
                            'date' => in_array($statut, ['pret_expedition', 'en_route', 'disponible', 'livre', 'annule', 'litige']) ? $order->updated_at->format('d-m') : null,
                            'active' => ($statut === 'pret_expedition')
                        ],
                        [
                            'id' => 'shipping',
                            'label' => 'EN COURS D\'EXPÉDITION',
                            'done' => in_array($statut, ['en_route', 'disponible', 'livre', 'annule', 'litige']),
                            'date' => in_array($statut, ['en_route', 'disponible', 'livre', 'annule', 'litige']) ? $order->updated_at->format('d-m') : null,
                            'active' => ($statut === 'en_route')
                        ],
                        [
                            'id' => 'ready',
                            'label' => 'PRÊT À RÉCUPÉRER',
                            'done' => in_array($statut, ['disponible', 'livre', 'annule', 'litige']),
                            'date' => in_array($statut, ['disponible', 'livre', 'annule', 'litige']) ? $order->updated_at->format('d-m') : null,
                            'active' => ($statut === 'disponible')
                        ],
                    ];

                    if ($statut === 'livre') {
                        $steps[] = [
                            'id' => 'delivered',
                            'label' => 'LIVRÉE',
                            'done' => true,
                            'date' => $order->updated_at->format('d-m'),
                            'active' => true
                        ];
                    } elseif ($statut === 'annule' || $statut === 'litige') {
                        $steps[] = [
                            'id' => 'failed',
                            'label' => 'Échec de la livraison',
                            'done' => false,
                            'failed' => true,
                            'date' => $order->updated_at->format('d-m'),
                            'active' => true,
                            'desc' => $order->notes_vendeur ?? "Malgré nos rappels répétés, vous n'avez pas récupéré le colis à notre point relais. Nous annulons de ce fait cette commande et nous retournerons l'article au vendeur."
                        ];
                    } else {
                        $steps[] = [
                            'id' => 'final',
                            'label' => 'LIVRÉE',
                            'done' => false,
                            'date' => null,
                            'active' => false
                        ];
                    }
                @endphp

                <div class="tracking-timeline">
                    @foreach($steps as $step)
                        <div class="tracking-item">
                            <div
                                class="tracking-marker {{ $step['done'] ? 'completed' : (isset($step['failed']) ? 'failed' : 'pending') }}">
                                @if($step['done'])
                                    <i class="fas fa-check"></i>
                                @elseif(isset($step['failed']))
                                    <i class="fas fa-circle"></i>
                                @else
                                    <i class="fas fa-circle" style="font-size: 0.5rem; opacity: 0.5;"></i>
                                @endif
                            </div>
                            <div class="tracking-info">
                                <div class="tracking-label {{ isset($step['failed']) ? 'failed' : '' }}">
                                    {{ $step['label'] }}
                                </div>
                                @if($step['date'])
                                    <span class="tracking-date">{{ $step['date'] }}</span>
                                @endif
                                @if(isset($step['desc']))
                                    <p class="tracking-desc">{{ $step['desc'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </main>
    </div>
@endsection