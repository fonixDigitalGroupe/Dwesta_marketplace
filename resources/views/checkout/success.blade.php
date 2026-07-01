@extends('layouts.app')

@section('title', 'Confirmation de Commande - Dwesta')

@push('styles')
    <style>
        :root {
            --jumia-orange: #f68b1e;
            --jumia-orange-hover: #e07b1a;
            --jumia-green: #4caf50;
            --jumia-text: #313133;
            --jumia-text-muted: #75757a;
            --jumia-bg: #f5f5f5;
            --jumia-border: #ededed;
            --amazon-gold: #FF9900;
            --amazon-blue: #232F3E;
        }

        body {
            background-color: #f0f2f2;
            font-family: 'Inter', sans-serif;
        }

        .checkout-success-container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 15px;
        }

        /* Hero Header */
        .hero-success {
            background: white;
            border: 1px solid var(--jumia-border);
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .hero-icon {
            width: 64px;
            height: 64px;
            background: #e8f5e9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--jumia-green);
            font-size: 32px;
        }

        .hero-text h1 {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 4px 0;
            color: var(--jumia-text);
        }

        .hero-text p {
            margin: 0;
            font-size: 14px;
            color: var(--jumia-text-muted);
        }

        .hero-text p strong {
            color: var(--jumia-text);
        }

        /* Layout Grid */
        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
        }

        .main-column {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Section Cards */
        .card-pro {
            background: white;
            border: 1px solid var(--jumia-border);
            border-radius: 8px;
            overflow: hidden;
        }

        .card-pro-header {
            background: #f8f8f8;
            padding: 12px 20px;
            border-bottom: 1px solid var(--jumia-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-pro-header h3 {
            font-size: 14px;
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
            color: var(--jumia-text);
        }

        .card-pro-content {
            padding: 20px;
        }

        /* Order Item Table */
        .order-summary-item {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-summary-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .item-img-mini {
            width: 60px;
            height: 60px;
            background: #fdfdfd;
            border-radius: 4px;
            padding: 4px;
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .item-img-mini img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .item-info-mini {
            flex: 1;
        }

        .item-info-mini .title {
            font-size: 14px;
            font-weight: 400;
            color: #007185;
            text-decoration: none;
            display: block;
            margin-bottom: 4px;
        }

        .item-info-mini .details {
            font-size: 12px;
            color: var(--jumia-text-muted);
        }

        .item-qty-price {
            text-align: right;
            min-width: 120px;
        }

        .item-qty-price .price {
            font-weight: 700;
            color: var(--jumia-text);
            font-size: 14px;
        }

        .item-qty-price .qty {
            font-size: 12px;
            color: var(--jumia-text-muted);
        }

        /* Progress Tracker (Amazon Style) */
        .tracker-box {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            position: relative;
            padding: 0 40px;
        }

        .tracker-box::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 60px;
            right: 60px;
            height: 4px;
            background: #e0e0e0;
            z-index: 1;
        }

        .tracker-box.active-1::before {
            background: #e0e0e0;
        }

        .tracker-box.active-2::before {
            background: linear-gradient(to right, var(--jumia-orange) 20%, #e0e0e0 20%);
        }

        .tracker-box.active-3::before {
            background: linear-gradient(to right, var(--jumia-orange) 40%, #e0e0e0 40%);
        }

        .tracker-box.active-4::before {
            background: linear-gradient(to right, var(--jumia-orange) 60%, #e0e0e0 60%);
        }

        .tracker-box.active-5::before {
            background: linear-gradient(to right, var(--jumia-orange) 80%, #e0e0e0 80%);
        }

        .tracker-box.active-6::before {
            background: var(--jumia-orange);
        }

        .tracker-step {
            position: relative;
            z-index: 2;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .step-dot {
            width: 34px;
            height: 34px;
            background: white;
            border: 4px solid #e0e0e0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: #999;
            margin-bottom: 8px;
        }

        .tracker-step.completed .step-dot {
            background: var(--jumia-orange);
            border-color: var(--jumia-orange);
            color: white;
        }

        .tracker-step.active .step-dot {
            border-color: var(--jumia-orange);
            color: var(--jumia-orange);
            font-weight: 700;
        }

        .step-label {
            font-size: 11px;
            font-weight: 700;
            color: var(--jumia-text-muted);
            text-transform: uppercase;
        }

        .tracker-step.active .step-label {
            color: var(--jumia-orange);
        }

        /* Info Grids */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .info-item {
            font-size: 14px;
        }

        .info-item h4 {
            font-size: 13px;
            margin: 0 0 8px 0;
            color: var(--jumia-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item p {
            margin: 0;
        }

        /* Sidebar Actions */
        .sidebar-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-pro {
            display: block;
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .btn-pro-primary {
            background: #004aad;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 74, 173, 0.3);
        }

        .btn-pro-primary:hover {
            background: #003a8c;
            transform: translateY(-1px);
        }

        .btn-pro-outline {
            background: white;
            color: var(--jumia-text);
            border: 1px solid #d5d9d9;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .btn-pro-outline:hover {
            background: #f7fafa;
        }

        /* Amazon Inspired Success Alert */
        .success-alert-amazon {
            background: white;
            border: 1px solid var(--jumia-green);
            padding: 16px;
            border-radius: 8px;
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }

        @media (max-width: 900px) {
            .checkout-layout {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767px) {
            .tracker-box {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
                padding: 10px 10px 10px 20px;
                margin: 15px 0;
            }

            .tracker-box::before {
                top: 27px;
                bottom: 27px;
                left: 35px;
                right: auto;
                width: 4px;
                height: auto;
            }

            .tracker-box.active-2::before {
                background: linear-gradient(to bottom, var(--jumia-orange) 20%, #e0e0e0 20%);
            }

            .tracker-box.active-3::before {
                background: linear-gradient(to bottom, var(--jumia-orange) 40%, #e0e0e0 40%);
            }

            .tracker-box.active-4::before {
                background: linear-gradient(to bottom, var(--jumia-orange) 60%, #e0e0e0 60%);
            }

            .tracker-box.active-5::before {
                background: linear-gradient(to bottom, var(--jumia-orange) 80%, #e0e0e0 80%);
            }

            .tracker-step {
                flex-direction: row;
                gap: 16px;
                text-align: left;
                align-items: center;
                width: 100%;
            }

            .step-dot {
                margin-bottom: 0;
                flex-shrink: 0;
            }

            .step-label {
                font-size: 12px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="checkout-success-container">

        <!-- Status Hero -->
        <div class="hero-success">
            <div class="hero-text">
                @if(request('info') || session('info'))
                    <div class="success-alert-amazon"
                        style="border-color: var(--jumia-orange); background: #fff3e0; margin-bottom: 24px;">
                        <div class="hero-icon" style="color: var(--jumia-orange); background: #fff;">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div>
                            <h2 style="font-size: 18px; font-weight: 700; margin: 0 0 8px 0; color: var(--jumia-orange);">Action
                                requise sur votre téléphone</h2>
                            <p style="color: #333; font-size: 15px; line-height: 1.5;">
                                {{ request('info') ?? session('info') }}
                            </p>
                        </div>
                    </div>
                @endif
                @if(!empty($paymentPending))
                    <div class="success-alert-amazon"
                        style="border-color: var(--jumia-orange); background: #fff3e0; margin-bottom: 24px;">
                        <div class="hero-icon" style="color: var(--jumia-orange); background: #fff;">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <h2 style="font-size: 18px; font-weight: 700; margin: 0 0 8px 0; color: var(--jumia-orange);">
                                Paiement en cours de confirmation</h2>
                            <p style="color: #333; font-size: 15px; line-height: 1.5;">
                                Votre commande a bien été enregistrée. La confirmation du paiement peut prendre quelques
                                instants — vous serez notifié dès sa validation.
                            </p>
                        </div>
                    </div>
                @endif
                <h1>Merci {{ Auth::user()->prenom ?? 'Client' }} ! Votre commande
                    {{ !empty($paymentPending) ? 'a bien été enregistrée' : 'est confirmée' }}.</h1>
                <p>
                    @if(count($orders) > 1)
                        Nous avons créé <strong>{{ count($orders) }} commandes</strong> distinctes car vos articles proviennent
                        de vendeurs différents.
                    @else
                        Nous avons bien reçu votre commande et nous vous tiendrons informé de son évolution.
                    @endif
                </p>
            </div>
        </div>

        <div class="checkout-layout">
            <!-- Main Content -->
            <div class="main-column">

                <!-- Overall Status / Next Step Tracker -->
                <div class="card-pro">
                    <div class="card-pro-header">
                        <h3>État de la commande</h3>
                    </div>
                    <div class="card-pro-content">
                        @php
                            $order = $orders->first();
                            $statut = $order?->statut ?? 'en_attente';
                            $failed = in_array($statut, ['annule', 'litige']);

                            $isStep1Done = true;
                            $isStep1Active = ($statut === 'en_attente');

                            $isStep2Done = in_array($statut, ['paye', 'pret_expedition', 'en_route', 'disponible', 'livre', 'annule', 'litige']);
                            $isStep2Active = ($statut === 'paye');

                            $isStep3Done = in_array($statut, ['pret_expedition', 'en_route', 'disponible', 'livre', 'annule', 'litige']);
                            $isStep3Active = ($statut === 'pret_expedition');

                            $isStep4Done = in_array($statut, ['en_route', 'disponible', 'livre', 'annule', 'litige']);
                            $isStep4Active = ($statut === 'en_route');

                            $isStep5Done = in_array($statut, ['disponible', 'livre', 'annule', 'litige']);
                            $isStep5Active = ($statut === 'disponible');

                            $isStep6Done = ($statut === 'livre');
                            $isStep6Active = in_array($statut, ['livre', 'annule', 'litige']);

                            $currentIdx = 1;
                            if ($isStep6Active)
                                $currentIdx = 6;
                            elseif ($isStep5Active)
                                $currentIdx = 5;
                            elseif ($isStep4Active)
                                $currentIdx = 4;
                            elseif ($isStep3Active)
                                $currentIdx = 3;
                            elseif ($isStep2Active)
                                $currentIdx = 2;
                        @endphp

                        <div class="tracker-box active-{{ $currentIdx }}">
                            <div
                                class="tracker-step {{ $isStep1Done && !$isStep1Active ? 'completed' : ($isStep1Active ? 'active' : '') }}">
                                <div class="step-dot">
                                    @if($isStep1Done && !$isStep1Active) <i class="fas fa-check"></i> @else 1 @endif
                                </div>
                                <span class="step-label">Passée</span>
                            </div>

                            <div
                                class="tracker-step {{ $isStep2Done && !$isStep2Active ? 'completed' : ($isStep2Active ? 'active' : '') }}">
                                <div class="step-dot">
                                    @if($isStep2Done && !$isStep2Active) <i class="fas fa-check"></i> @else 2 @endif
                                </div>
                                <span class="step-label">Confirmée</span>
                            </div>

                            <div
                                class="tracker-step {{ $isStep3Done && !$isStep3Active ? 'completed' : ($isStep3Active ? 'active' : '') }}">
                                <div class="step-dot">
                                    @if($isStep3Done && !$isStep3Active) <i class="fas fa-check"></i> @else 3 @endif
                                </div>
                                <span class="step-label">En préparation</span>
                            </div>

                            <div
                                class="tracker-step {{ $isStep4Done && !$isStep4Active ? 'completed' : ($isStep4Active ? 'active' : '') }}">
                                <div class="step-dot">
                                    @if($isStep4Done && !$isStep4Active) <i class="fas fa-check"></i> @else 4 @endif
                                </div>
                                <span class="step-label">Expédiée</span>
                            </div>

                            <div
                                class="tracker-step {{ $isStep5Done && !$isStep5Active ? 'completed' : ($isStep5Active ? 'active' : '') }}">
                                <div class="step-dot">
                                    @if($isStep5Done && !$isStep5Active) <i class="fas fa-check"></i> @else 5 @endif
                                </div>
                                <span class="step-label">Prêt à récupérer</span>
                            </div>

                            <div class="tracker-step {{ $isStep6Done ? 'completed' : ($isStep6Active ? ($failed ? 'failed' : 'active') : '') }}"
                                {!! $failed ? 'style="--jumia-orange: #d32f2f;"' : '' !!}>
                                <div class="step-dot">
                                    @if($isStep6Done) <i class="fas fa-check"></i>
                                    @elseif($failed) <i class="fas fa-times"></i>
                                    @else 6 @endif
                                </div>
                                <span class="step-label">@if($failed) Échec @else Livrée @endif</span>
                            </div>
                        </div>
                    </div>

                    <p style="font-size: 13px; color: var(--jumia-text-muted); text-align: center; margin-top: 10px;">
                        Estimation de livraison : <strong>{{ now()->addDays(2)->translatedFormat('d F') }} -
                            {{ now()->addDays(5)->translatedFormat('d F') }}</strong>
                    </p>
                </div>
            </div>

            <!-- Detailed Orders per Seller -->
            @foreach($orders as $order)
                <div class="card-pro">
                    <div class="card-pro-header">
                        <h3 style="text-transform: none;">Vendeur :
                            <strong>{{ $order->seller?->identite ?? 'N/A' }}</strong>
                        </h3>
                        <span style="font-size: 13px; color: var(--jumia-text-muted);">Réf :
                            <strong>#{{ $order->reference }}</strong></span>
                    </div>
                    <div class="card-pro-content">
                        @foreach($order->items as $item)
                            <div class="order-summary-item">
                                <div class="item-img-mini">
                                    @php $photo = $item->annonce->photoPrincipale(); @endphp
                                    @if($photo)
                                        <img src="{{ Storage::url($photo->chemin) }}" alt="{{ $item->annonce->titre }}">
                                    @else
                                        <i class="fas fa-image text-muted"></i>
                                    @endif
                                </div>
                                <div class="item-info-mini">
                                    <a href="{{ route('annonces.show', $item->annonce->slug) }}" class="title">
                                        {{ $item->annonce->titre }}
                                    </a>
                                    @if($item->variante)
                                        <div class="details">Type : {{ $item->variante->valeur }}</div>
                                    @endif
                                    <div class="details">Vendu par : {{ $order->seller?->identite ?? 'N/A' }}</div>
                                </div>
                                <div class="item-qty-price">
                                    <div class="price">{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA</div>
                                    <div class="qty">Quantité : {{ $item->quantite }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>

        <!-- Sidebar Details -->
        <div class="sidebar">

            <div class="card-pro" style="margin-bottom: 20px;">
                <div class="card-pro-header">
                    <h3>Résumé</h3>
                </div>
                <div class="card-pro-content">
                    <div class="info-item" style="margin-bottom: 16px;">
                        <h4>Adresse de livraison</h4>
                        <p style="font-weight: 500;">{{ $orders->first()?->adresse_livraison ?? 'N/A' }}</p>
                    </div>

                    <div class="info-item" style="margin-bottom: 16px;">
                        <h4>Mode de paiement</h4>
                        <p>
                            @if($gestionPaiement === 'commande')
                                <i class="fas fa-credit-card"></i> Payé par
                                {{ $orders->first()?->moyen_paiement === 'cb' ? 'Carte / Mobile' : ($orders->first()?->moyen_paiement ?? 'N/A') }}
                            @else
                                <i class="fas fa-hand-holding-usd"></i> Paiement à la livraison
                            @endif
                        </p>
                    </div>

                    <div class="info-item" style="border-top: 1px solid #eee; padding-top: 12px; margin-top: 12px;">
                        <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 16px;">
                            <span>Total Payé</span>
                            <span
                                style="color: var(--jumia-orange);">{{ number_format($orders->sum('total_final'), 0, ',', ' ') }}
                                FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sidebar-actions">
                <a href="{{ route('account.orders') }}" class="btn-pro btn-pro-primary">
                    <i class="fas fa-list-ul"></i> Suivre mes commandes
                </a>
                <a href="{{ route('home') }}" class="btn-pro btn-pro-outline">
                    Continuer mes achats
                </a>
                <p style="font-size: 12px; color: var(--jumia-text-muted); text-align: center; margin-top: 10px;">
                    Un problème ? <a href="#" style="color: #007185; text-decoration: none;">Contactez le support</a>
                </p>
            </div>

        </div>
    </div>
    </div>
@endsection