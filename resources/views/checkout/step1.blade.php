@extends('layouts.app')

@section('title', 'Détails de Livraison - Karnou')

@push('styles')
    <style>
        :root {
            --jumia-orange: #f68b1e;
            --jumia-blue: #004aad;
            --jumia-bg: #f5f5f5;
            --jumia-border: #ededed;
            --jumia-text: #313133;
            --jumia-success: #4caf50;
        }

        body {
            background-color: var(--jumia-bg);
            font-family: 'Roboto', sans-serif;
            color: var(--jumia-text);
        }

        .checkout-wrapper {
            max-width: 1200px;
            margin: 20px auto;
            display: grid;
            grid-template-columns: minmax(0, 840px) 340px;
            gap: 16px;
            padding: 0 15px;
            justify-content: center;
        }

        .box {
            background: white;
            border-radius: 4px;
            margin-bottom: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .box-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--jumia-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            color: #313133;
            font-family: 'Roboto', sans-serif;
        }

        .box-header.completed {
            color: var(--jumia-success);
        }

        .box-body {
            padding: 16px;
        }

        .modifier-link {
            color: var(--jumia-blue);
            text-decoration: none;
            font-size: 14px;
            text-transform: none;
        }

        /* Step Styles */
        .step-active {
            color: var(--jumia-text);
        }

        .step-number {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #ccc;
            color: white;
            text-align: center;
            line-height: 20px;
            font-size: 11px;
            font-weight: 700;
            margin-right: 10px;
        }

        .box-header.completed .step-number {
            background: var(--jumia-success);
        }

        /* Address Summary */
        .address-info {
            font-size: 14px;
            line-height: 1.6;
        }

        .user-name {
            font-weight: 700;
            display: block;
            margin-bottom: 4px;
        }

        /* Delivery Options */
        .delivery-option {
            margin-bottom: 24px;
        }

        .option-label {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 0;
        }

        .option-radio {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #ccc;
            border-radius: 50%;
            outline: none;
            cursor: pointer;
            position: relative;
        }

        .option-radio:checked {
            border-color: var(--jumia-orange);
        }

        .option-radio:checked::after {
            content: '';
            width: 10px;
            height: 10px;
            background: var(--jumia-orange);
            border-radius: 50%;
            position: absolute;
            top: 3px;
            left: 3px;
        }

        .option-title {
            font-weight: 700;
            font-size: 15px;
        }

        .shipment-products-row {
            display: flex;
            gap: 15px;
            overflow-x: auto;
            padding-bottom: 10px;
            scrollbar-width: thin;
        }

        .shipment-product-item {
            flex: 0 0 200px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .shipment-product-item .product-thumb {
            width: 100%;
            height: 150px;
            background: #f8f8f8;
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .shipment-product-item .product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .shipment-product-item .product-info {
            font-size: 12px;
            color: #313133;
        }

        .option-price {
            background: #fff3e0;
            color: #f68b1e;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 700;
            margin-left: 8px;
            text-transform: uppercase;
        }

        .option-date {
            margin-left: 32px;
            font-size: 13px;
            color: var(--jumia-text);
            margin-top: -4px;
            display: block;
        }

        .summary-shipment-meta {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            margin-bottom: 8px;
            align-items: center;
        }

        .summary-shipment-meta span:first-child {
            font-weight: 700;
            color: #313133;
        }

        .summary-shipment-meta span:last-child {
            color: #999;
        }

        .summary-shipment-card {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 12px;
            background: #fff;
        }

        .summary-shipment-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .summary-mode-title {
            font-weight: 700;
            font-size: 14px;
            color: #313133;
        }

        .summary-date-text {
            font-size: 12px;
            color: #666;
            margin-top: 2px;
        }

        .summary-product-item {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 1px solid #f5f5f5;
        }

        /* Sub-selection Box (Restored) */
        .sub-box {
            margin-left: 32px;
            margin-top: 12px;
            border: 1px solid var(--jumia-border);
            border-radius: 4px;
        }

        .sub-box-header {
            padding: 8px 12px;
            border-bottom: 1px solid var(--jumia-border);
            font-weight: 700;
            font-size: 13px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-product-img {
            width: 50px;
            height: 50px;
            border: 1px solid #eee;
            border-radius: 4px;
            object-fit: contain;
        }

        .modify-cart-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            color: #f68b1e;
            font-weight: 700;
            text-decoration: none;
            font-size: 14px;
        }

        .sub-box-body {
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Shipment Grid */
        .shipments-grid {
            display: flex;
            gap: 16px;
            margin-top: 16px;
            overflow-x: auto;
            padding-bottom: 10px;
            align-items: flex-start;
        }

        .shipment-card {
            flex: 0 0 280px;
            border: 1px solid var(--jumia-border);
            border-radius: 4px;
            padding: 16px;
            background: #fff;
        }

        .shipment-header-top {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .shipment-seller-top {
            color: #999;
            font-weight: 400;
            font-size: 12px;
        }

        .shipment-type-box {
            border-top: 1px solid #f5f5f5;
            padding-top: 10px;
        }

        .shipment-type-name {
            font-size: 15px;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .jumia-express-badge {
            color: #f68b1e;
            font-style: italic;
            font-weight: 900;
            font-size: 12px;
        }

        .shipment-date-text {
            font-size: 12px;
            color: #313133;
            margin: 4px 0 12px 0;
        }

        .shipment-items-list {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding-top: 12px;
            border-top: 1px solid #f5f5f5;
        }

        .shipment-item-mini {
            flex: 0 0 150px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
            text-align: center;
        }

        .shipment-item-mini .thumb-wrapper {
            position: relative;
            width: 60px;
            height: 60px;
            border: 1px solid #eee;
            border-radius: 4px;
        }

        .shipment-item-mini .qty-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #f1f1f1;
            border: 1px solid #ddd;
            border-radius: 2px;
            font-size: 10px;
            padding: 0 4px;
            font-weight: 700;
        }

        .shipment-item-mini .info {
            flex: 1;
        }

        .shipment-header {
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
        }

        .shipment-seller {
            color: #999;
            font-weight: 400;
        }

        .shipment-body {
            display: flex;
            gap: 12px;
            margin-top: 8px;
        }

        .product-thumb {
            width: 60px;
            height: 60px;
            border-radius: 4px;
            overflow: hidden;
            border: 1px solid #eee;
        }

        .product-thumb img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .product-info {
            font-size: 13px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .express-text {
            font-size: 11px;
            font-weight: 900;
            font-style: italic;
        }

        .express-text span {
            color: var(--jumia-orange);
        }

        /* Sidebar Summary */
        .summary-card {
            background: white;
            border-radius: 4px;
            padding: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .summary-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--jumia-border);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 15px;
        }

        .summary-row.total {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid var(--jumia-border);
            font-weight: 800;
            font-size: 20px;
        }

        .btn-confirm {
            width: 100%;
            background: #004aad;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 14px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            text-transform: uppercase;
            margin-top: 12px;
            box-shadow: 0 4px 8px rgba(0, 74, 173, 0.25);
            transition: background 0.2s;
        }

        .btn-confirm:hover:not(:disabled) {
            background: #003a8f;
        }

        .btn-confirm:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .voucher-text {
            font-size: 12px;
            color: #666;
            margin-top: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 900px) {
            .checkout-wrapper {
                grid-template-columns: 1fr;
            }

            .shipments-grid {
                grid-template-columns: 1fr;
                margin-left: 0;
            }
        }

        .modify-cart-link {
            display: block;
            text-align: center;
            color: var(--jumia-orange);
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            margin-top: 20px;
        }

        /* Payment Modernization Styles */
        .payment-section-title {
            font-size: 15px;
            font-weight: 700;
            color: #313133;
            margin: 25px 0 12px;
            font-family: inherit;
        }

        .payment-option-modern {
            border-bottom: 1px solid #f1f1f1;
            padding: 18px 0;
            cursor: pointer;
            display: flex;
            align-items: flex-start;
            gap: 15px;
            position: relative;
        }

        .payment-option-modern:last-child {
            border-bottom: none;
        }

        /* HIGH SPECIFICITY HIDE */
        .checkout-wrapper .payment-option-modern input[type="radio"] {
            position: absolute !important;
            opacity: 0 !important;
            width: 0 !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            pointer-events: none !important;
        }

        .radio-custom {
            width: 22px;
            height: 22px;
            border: 2px solid #ddd;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            flex-shrink: 0;
            margin-top: 2px;
            background: white !important;
            transition: all 0.2s ease;
        }

        /* HIGH SPECIFICITY CHECKED STATE */
        .checkout-wrapper .payment-option-modern input[type="radio"]:checked+.radio-custom {
            border-color: #f68b1e !important;
            border-width: 2px !important;
        }

        .checkout-wrapper .payment-option-modern input[type="radio"]:checked+.radio-custom::after {
            content: '';
            position: absolute;
            width: 12px;
            height: 12px;
            background: #f68b1e;
            border-radius: 50%;
            top: 3px;
            left: 3px;
        }

        .payment-info-wrapper {
            flex: 1;
            min-width: 0;
        }

        .payment-title-row {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 4px;
            width: 100%;
        }

        .payment-name {
            font-weight: 700;
            font-size: 14.5px;
            color: #111;
            line-height: normal;
        }

        .promo-badge {
            background: #fff0e0;
            color: #f68b1e;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 3px;
            text-transform: uppercase;
            border: 1px solid #ffcc99;
            white-space: nowrap;
        }

        .payment-desc {
            font-size: 13px;
            color: #666;
            line-height: 1.4;
        }

        .payment-details-box {
            margin-top: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            padding: 15px;
            background: #fff;
            display: none;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .payment-details-box.active {
            display: block;
        }

        .details-link {
            color: #004aad;
            text-decoration: underline;
            font-size: 13px;
            font-weight: 600;
            display: block;
            margin-top: 8px;
        }

        .accept-row {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #f5f5f5;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            font-weight: 600;
            color: #333;
        }

        .method-logo-wrapper {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 800;
            font-size: 11px;
        }

        .method-logo {
            height: 24px;
            object-fit: contain;
            display: block;
        }

        .btn-confirm-final {
            background: #004aad;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 22px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-block;
            box-shadow: 0 2px 4px rgba(0, 74, 173, 0.2);
        }

        .btn-confirm-final:hover {
            background: #003a8f;
        }

        /* Header State for Step 3 */
        #payment-header-text.active {
            color: #313133 !important;
            font-size: 14px !important;
            font-weight: bold !important;
        }

        #payment-step-num.active {
            background: #fff !important;
            color: #313133 !important;
            border: 2px solid #ddd !important;
        }
    </style>
@endpush

@section('content')
    <div class="checkout-wrapper">
        <div class="checkout-left">
            <!-- 1. ADRESSE CLIENT -->
            <div class="box">
                <div class="box-header" style="background: #fff; padding: 12px 16px; border-bottom: 1px solid #eee;">
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span
                            style="display: flex; align-items: center; gap: 10px; color: #313133; font-size: 13px; font-weight: 700; text-transform: uppercase;">
                            <span
                                style="width: 20px; height: 20px; border-radius: 50%; background: #4caf50; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">
                                <i class="fas fa-check"></i>
                            </span>
                            1. ADRESSE CLIENT
                        </span>
                        <a href="{{ route('profile.show') }}" class="modifier-link"
                            style="color: #004aad; font-size: 13px; font-weight: 700; text-decoration: none;">Modifier
                            &gt;</a>
                    </div>
                </div>
                <div class="box-body" style="padding: 16px;">
                    <div class="summary-section-header" style="font-weight: 700; font-size: 16px; color: #313133;">Adresse
                        de livraison</div>
                    <div class="summary-section-subtitle" style="font-size: 13px; color: #666; margin-bottom: 12px;">Votre
                        colis sera expédié à cette adresse</div>

                    <div style="border: 1px solid #ddd; border-radius: 4px; padding: 12px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                            <strong style="font-size: 13px; color: #313133;">{{ $user->prenom }} {{ $user->nom }}</strong>
                        </div>
                        <div style="font-size: 12px; color: #666; line-height: 1.4;">
                            {{ $user->adresse ?? 'Adresse non renseignée' }}<br>
                            {{ $user->ville ?? 'Ville' }}, {{ $user->telephone }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. DETAILS DE LIVRAISON -->
            <div class="box" id="box-delivery">
                <div class="box-header" id="delivery-header">
                    <span class="step-active">
                        <span class="step-number">2</span>
                        2. DÉTAILS DE LIVRAISON
                    </span>
                </div>
                <div class="box-header" id="delivery-header-done"
                    style="display: none; background: #fff; padding: 12px 16px; cursor: pointer; border-bottom: 1px solid #eee;"
                    onclick="editDelivery()">
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span
                            style="display: flex; align-items: center; gap: 10px; color: #313133; font-size: 13px; font-weight: 700; text-transform: uppercase;">
                            <span
                                style="width: 20px; height: 20px; border-radius: 50%; background: #4caf50; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">
                                <i class="fas fa-check"></i>
                            </span>
                            2. DÉTAILS DE LIVRAISON
                        </span>
                        <a href="#" class="modifier-link"
                            style="color: #004aad; font-size: 13px; font-weight: 700; text-decoration: none;">Modifier
                            &gt;</a>
                    </div>
                </div>
                <div class="box-body">
                    <form action="{{ route('checkout.process') }}" method="POST" id="deliveryForm">
                        @csrf

                        <!-- Option Point Relais -->
                        <div class="delivery-option">
                            <label class="option-label" style="display: flex; align-items: center; cursor: pointer;">
                                <input type="radio" name="mode_livraison" value="retrait_point_relais" class="option-radio"
                                    id="radio-pr" {{ $requiresPointRelais ? 'checked' : '' }}
                                    onchange="toggleDeliveryOptions()">
                                <span class="option-title"
                                    style="margin-left: 10px; font-size: 16px; display: flex; align-items: center;">
                                    Point Relais
                                    <span class="option-price" id="price-pr-badge" style="display: none;">À PARTIR DE <span
                                            id="price-pr"></span></span>
                                </span>
                            </label>
                            <div class="option-date" id="date-pr"
                                style="margin-left: 32px; color: #313133; font-size: 14px; margin-top: 4px;">Calcul en
                                cours...</div>

                            <div id="pr-selection-area" style="display: {{ $requiresPointRelais ? 'block' : 'none' }};">
                                <div class="sub-box">
                                    <div class="sub-box-header">
                                        Point Relais
                                        <a href="#" class="modifier-link" id="btn-choose-pr">Choisissez un point relais
                                            ></a>
                                    </div>
                                    <div class="sub-box-body" id="pr-status-box">
                                        <div
                                            style="width: 40px; height: 40px; background: #fff3e0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--jumia-orange);">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div style="font-size: 13px;">
                                            <strong id="pr-selected-name"
                                                style="display: block; color: var(--jumia-text);">Point relais non
                                                sélectionné</strong>
                                            <span id="pr-selected-addr" style="color: #999;">Veuillez choisir un point
                                                relais proche de votre emplacement...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Option Livraison Domicile -->
                        <div class="delivery-option">
                            <label class="option-label" style="display: flex; align-items: center; cursor: pointer;">
                                <input type="radio" name="mode_livraison" value="livraison_domicile" class="option-radio"
                                    id="radio-domicile" {{ !$requiresPointRelais ? 'checked' : '' }}
                                    onchange="toggleDeliveryOptions()">
                                <span class="option-title"
                                    style="margin-left: 10px; font-size: 16px; display: flex; align-items: center;">
                                    Livraison à domicile
                                    <span class="option-price" id="price-domicile-badge" style="display: inline-block;">À
                                        PARTIR DE <span id="price-domicile"></span></span>
                                </span>
                                <i class="fas fa-truck" style="margin-left: auto; color: #f68b1e;"></i>
                            </label>
                            <div class="option-date" id="date-domicile"
                                style="margin-left: 32px; color: #313133; font-size: 14px; margin-top: 4px;">Calcul en
                                cours...</div>

                            <div id="domicile-details-area"
                                style="display: {{ !$requiresPointRelais ? 'block' : 'none' }}; margin-top: 16px;">
                                <!-- Products removed from selection phase per user request -->
                            </div>
                        </div>

                        <input type="hidden" name="point_relais_id" id="input_point_relais_id">
                        <input type="hidden" name="adresse_livraison" value="{{ $user->adresse }}">
                        <input type="hidden" name="gestion_paiement" id="gestion_paiement" value="livraison_buyer">
                        <input type="hidden" name="moyen_paiement" id="moyen_paiement" value="">
                        <input type="hidden" name="applied_gift_card_code" id="applied_gift_card_code" value="">

                        <!-- Bouton Confirmer le mode de livraison -->
                        <div style="padding: 16px 0 4px; text-align: right;">
                            <button type="button" onclick="confirmDelivery()" id="btn-confirm-delivery"
                                class="btn-confirm-delivery"
                                style="background: #004aad; color: #fff; border: none; padding: 10px 22px; border-radius: 4px; font-weight: 700; font-size: 14px; cursor: pointer; transition: background 0.2s; box-shadow: 0 2px 4px rgba(0,74,173,0.2);">
                                Confirmer le mode de livraison
                            </button>
                        </div>
                        {{-- Form stays OPEN - closes after the final Confirm button in sidebar --}}

                    <!-- Résumé livraison (caché par défaut, visible après confirmation) -->
                    <div id="delivery-summary" style="display: none;">
                        <!-- Domicile Block -->
                        <div id="summary-domicile-block" class="summary-shipment-card"
                            style="display: none; margin-bottom: 8px;">
                            <div class="summary-shipment-header-row">
                                <strong class="summary-mode-title">Livraison à domicile</strong>
                            </div>
                            <div id="summary-date-dom" class="summary-date-text"></div>
                        </div>

                        <!-- Point Relais Block -->
                        <div id="summary-pr-block" class="summary-shipment-card" style="display: none; margin-bottom: 8px;">
                            <div class="summary-shipment-header-row">
                                <strong class="summary-mode-title">Point Relais</strong>
                            </div>
                            <div id="summary-pr-name"
                                style="font-size: 13px; font-weight: 700; color: #313133; margin-bottom: 2px;"></div>
                            <div id="summary-pr-addr"
                                style="font-size: 12px; color: #666; line-height: 1.4; margin-bottom: 6px;"></div>
                            <div id="summary-date-pr" class="summary-date-text"></div>
                        </div>
                        <a href="{{ route('cart.index') }}" class="modify-cart-link">Modifier le panier</a>
                    </div>
                </div>
            </div>

            <!-- 3. MODE DE PAIEMENT -->
            <div class="box" id="box-payment"
                style="opacity: 0.5; pointer-events: none; border: 1px solid #eee; border-radius: 4px; overflow: hidden; background: #fff;">
                <!-- Inactive/Active Header -->
                <div class="box-header" id="payment-header"
                    style="background: #fff; padding: 12px 16px; border-bottom: 1px solid #eee;">
                    <span id="payment-header-text"
                        style="display: flex; align-items: center; gap: 10px; color: #313133; font-size: 13px; font-weight: 700; text-transform: uppercase;">
                        <span id="payment-step-num"
                            style="width: 20px; height: 20px; border-radius: 50%; background: #ccc; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0;">
                            3
                        </span>
                        3. MODE DE PAIEMENT
                    </span>
                </div>

                <!-- Done Header (White, was Green) -->
                <div class="box-header" id="payment-header-done"
                    style="display: none; background: #fff; padding: 12px 16px; cursor: pointer; border-bottom: 1px solid #eee;"
                    onclick="editPayment()">
                    <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span
                            style="display: flex; align-items: center; gap: 10px; color: #313133; font-size: 13px; font-weight: 700; text-transform: uppercase;">
                            <span
                                style="width: 20px; height: 20px; border-radius: 50%; background: #4caf50; color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700;">
                                <i class="fas fa-check"></i>
                            </span>
                            3. MODE DE PAIEMENT
                        </span>
                        <a href="#" class="modifier-link"
                            style="color: #004aad; font-size: 13px; font-weight: 600; text-decoration: none;">Modifier
                            &gt;</a>
                    </div>
                </div>

                <div class="box-body" id="payment-body" style="display: none; padding: 15px 20px;">
                    <!-- Payment Summary (Shown after confirmation) - Matches Image 2 -->
                    <div id="payment-summary" style="display: none; padding-top: 10px;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: flex-start; background: #fff; padding: 5px 0;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div id="summary-payment-name" style="font-weight: 700; color: #313133; font-size: 14px;">
                                    Mode de paiement</div>
                            </div>
                            <div id="summary-payment-icon" style="margin-left: 15px;">
                                <i class="fas fa-wallet" style="font-size: 1.4rem; color: #333;"></i>
                            </div>
                        </div>
                        <!-- Retourner à vos achats (Inside the card as requested) -->
                        <div id="back-to-shop-link"
                            style="display: none; margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px;">
                            <a href="{{ route('home') }}"
                                style="color: #004aad; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-chevron-left"></i> Retourner à vos achats
                            </a>
                        </div>
                    </div>

                    <!-- Payment Selection Form -->
                    <div id="payment-options-list">
                        <div class="payment-section-title">Mobile Money</div>

                        <!-- Orange Money -->
                        <label class="payment-option-modern" onclick="selectModernPayment(this, 'commande', 'om')">
                            <input type="radio" name="ui_payment" value="om">
                            <span class="radio-custom"></span>
                            <div class="payment-info-wrapper">
                                <div class="payment-title-row">
                                    <span class="payment-name">Avec Orange Money</span>
                                    <div style="margin-left: auto;">
                                        <img src="{{ asset('images/logoOM.png') }}" alt="Orange Money" class="method-logo"
                                            style="height: 30px;">
                                    </div>
                                </div>
                                <!-- Description en dessous du titre -->
                                <div style="font-size: 13px; color: #666; margin-top: 4px;">Paiement rapide et sécurisé via
                                    votre compte Orange Money.</div>
                            </div>
                        </label>

                        <!-- Wave -->
                        <label class="payment-option-modern" onclick="selectModernPayment(this, 'commande', 'wave')">
                            <input type="radio" name="ui_payment" value="wave">
                            <span class="radio-custom"></span>
                            <div class="payment-info-wrapper">
                                <div class="payment-title-row">
                                    <span class="payment-name">Avec Wave</span>
                                    <div style="margin-left: auto;">
                                        <img src="{{ asset('images/logowave.png') }}" alt="Wave" class="method-logo">
                                    </div>
                                </div>
                                <div style="font-size: 13px; color: #666; margin-top: 4px;">Payez instantanément avec
                                    l'application Wave mobile.</div>
                            </div>
                        </label>

                        <!-- Free Money -->
                        <div class="payment-section-title">Carte Bancaire / International</div>

                        <!-- Card -->
                        <label class="payment-option-modern" onclick="selectModernPayment(this, 'commande', 'cb')">
                            <input type="radio" name="ui_payment" value="cb">
                            <span class="radio-custom"></span>
                            <div class="payment-info-wrapper">
                                <div class="payment-title-row">
                                    <span class="payment-name">Visa, Mastercard, etc.</span>
                                    <div style="margin-left: auto; display: flex; gap: 4px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" class="method-logo" style="height: 12px;">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard" class="method-logo" style="height: 18px;">
                                    </div>
                                </div>
                                <div style="font-size: 13px; color: #666; margin-top: 4px;">Paiement sécurisé par carte bancaire.</div>
                            </div>
                        </label>



                        <div class="payment-section-title">Paiement à la livraison</div>

                        <!-- COD -->
                        <label class="payment-option-modern" onclick="selectModernPayment(this, 'livraison_buyer', 'cod')">
                            <input type="radio" name="ui_payment" value="cod">
                            <span class="radio-custom"></span>
                            <div class="payment-info-wrapper">
                                <div class="payment-title-row">
                                    <span class="payment-name">Paiement à la livraison</span>
                                    <div style="margin-left: auto;">
                                        <i class="fas fa-handshake" style="font-size: 1.4rem; color: #f68b1e;"></i>
                                    </div>
                                </div>
                                <!-- Description en dessous du titre -->
                                <div style="font-size: 13px; color: #666; margin-top: 6px;">Payez dès réception de votre
                                    commande à domicile.</div>
                            </div>
                        </label>

                        <div style="margin-top: 40px; display: flex; justify-content: flex-end;">
                            <button type="button" onclick="confirmPayment()" id="btn-confirm-payment"
                                class="btn-confirm-final" style="padding: 10px 22px; font-size: 14px;">
                                Confirmer le mode de paiement
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="checkout-right">
            <div class="summary-card">
                <div class="summary-title">Résumé de commande</div>

                <div class="summary-row">
                    <span>Total articles ({{ $cartGrouped->flatten()->sum('quantite') }})</span>
                    <span>{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                </div>

                <div class="summary-row">
                    <span>Frais de Livraison</span>
                    <span id="shipping-fee">- FCFA</span>
                </div>

                <div class="summary-row" id="gift-card-row" style="display: none; color: #2e7d32; font-weight: 700;">
                    <span>Remise (Carte Cadeau)</span>
                    <span id="gift-card-deduction">- 0 FCFA</span>
                </div>

                <div class="summary-row total">
                    <span>Total</span>
                    <span id="final-total">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                </div>

                <div id="voucher-container"
                    style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 15px; display: none;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="position: relative; flex: 1;">
                            <i class="fas fa-ticket-alt"
                                style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #999;"></i>
                            <input type="text" id="voucher_code" placeholder="Entrer le code"
                                style="width: 100%; padding: 10px 12px 10px 38px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; outline: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#f68b1e'" onblur="this.style.borderColor='#ccc'">
                        </div>
                        <button type="button" onclick="applyVoucher()"
                            style="background: none; border: none; color: #004aad; font-weight: 700; font-size: 13px; cursor: pointer; text-transform: uppercase;">APPLIQUER</button>
                    </div>
                </div>

                <p id="voucher-placeholder-text" class="voucher-text"
                    style="font-size: 12px; color: #666; margin-top: 12px; padding-top: 12px; border-top: 1px solid #eee;">
                    <i class="fas fa-ticket-alt" style="color: var(--jumia-orange);"></i>
                    Vous pourrez ajouter un bon d'achat lors de la sélection de votre mode de paiement.
                </p>

                <button type="submit" class="btn-confirm" id="btn-submit"
                    style="opacity: 1; pointer-events: auto;">
                    Confirmer la commande
                </button>
                </form> {{-- Entire form ends here, includes all hidden fields --}}
                <div style="text-align: center; color: #999; font-size: 11px; margin-top: 8px;">
                    (Complétez les étapes pour continuer)
                </div>

                <div
                    style="margin-top: 16px; font-size: 11px; color: #666; border-top: 1px solid #eee; padding-top: 12px; line-height: 1.4;">
                    En validant votre choix, vous acceptez automatiquement les <a href="#"
                        style="color: var(--jumia-blue); text-decoration: none;">Conditions générales d'utilisation</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal / Overlay for Point Relais Selection -->
    <div id="pr-modal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div
            style="background: white; width: 90%; max-width: 600px; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; max-height: 80vh;">
            <div
                style="padding: 16px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <strong style="font-size: 18px;">Choisir un point relais</strong>
                <button onclick="closePRModal()"
                    style="background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
            </div>
            <div style="overflow-y: auto; padding: 16px;">
                @foreach($pointRelais as $pr)
                    <div onclick="selectPoint({{ $pr->id }}, '{{ addslashes($pr->nom) }}', '{{ addslashes($pr->adresse) }}', '{{ $pr->region }}')"
                        style="padding: 12px; border: 1px solid #eee; border-radius: 4px; margin-bottom: 8px; cursor: pointer; transition: background 0.2s;"
                        onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='white'">
                        <div style="font-weight: 700; font-size: 15px;">{{ $pr->nom }}</div>
                        <div style="font-size: 13px; color: #666;">{{ $pr->adresse }}</div>
                        <div style="font-size: 12px; color: var(--jumia-orange); margin-top: 4px; font-weight: 700;"
                            class="pr-fee-display" data-region="{{ $pr->region }}">
                            Calcul en cours...
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- PayDunya PSR SDK REMOVED - Reverting to Standard Redirection --}}
    {{-- <script src="https://paydunya.com/assets/psr/js/psr.paydunya.min.js"></script> --}}

    <script>
    const PAYDUNYA_TOKEN_URL = "{{ route('checkout.paydunya.token') }}";

    /* 
       REMOVED REDUNDANT SETUP AT START (Line 1128-1152) 
       Logic moved to a single DOMContentLoaded block at the end of the file.
    */
        const subtotal = {{ $subtotal }};
        const sellerOrigins = @json($sellerOrigins);
        const userCountryId = {{ $userCountryId ?? 'null' }};
        const rules = @json($shippingRules);
        const userRegion = "{{ $user->ville ?? 'Dakar' }}";
        let selectedPRRegion = null;
        const CHECKOUT_STATE_KEY = 'dwesta_checkout_state';

        function saveCheckoutState() {
            const state = {
                deliveryMode: document.getElementById('radio-domicile').checked ? 'domicile' : 'pr',
                pointRelaisId: document.getElementById('input_point_relais_id').value,
                paymentMode: document.getElementById('moyen_paiement').value,
                paymentGestion: document.getElementById('gestion_paiement').value,
                voucherCode: document.getElementById('voucher_code').value,
                step: 1
            };

            if (document.getElementById('delivery-summary').style.display === 'block') state.step = 2;
            if (document.getElementById('payment-summary').style.display === 'block') state.step = 3;

            localStorage.setItem(CHECKOUT_STATE_KEY, JSON.stringify(state));
        }

        function loadCheckoutState() {
            const saved = localStorage.getItem(CHECKOUT_STATE_KEY);
            if (!saved) return;
            try {
                const state = JSON.parse(saved);

                // Restore Domicile/PR toggle
                if (state.deliveryMode === 'pr') {
                    document.getElementById('radio-pr').checked = true;
                    toggleDeliveryOptions();
                    if (state.pointRelaisId) {
                        // Try to find the radio in modal or use the hidden ID
                        document.getElementById('input_point_relais_id').value = state.pointRelaisId;
                    }
                } else {
                    document.getElementById('radio-domicile').checked = true;
                    toggleDeliveryOptions();
                }

                if (state.voucherCode) document.getElementById('voucher_code').value = state.voucherCode;

                if (state.step >= 2) confirmDelivery(true);
                if (state.step >= 3 && state.paymentMode) {
                    const radio = document.querySelector(`input[name="ui_payment"][value="${state.paymentMode}"]`);
                    if (radio) {
                        radio.checked = true;
                        selectModernPayment(radio.closest('.payment-option-modern'), state.paymentGestion, state.paymentMode, true);
                    }
                    confirmPayment(true);
                }
            } catch (e) { console.error(e); }
        }

        document.addEventListener('DOMContentLoaded', loadCheckoutState);

        function getRule(type, sellerId, region = null) {
            const sellerCountryId = sellerOrigins[sellerId];

            // On cherche la règle exacte (Pays Source -> Pays Destination -> Type -> Région)
            let rule = rules.find(r =>
                r.delivery_type === type &&
                r.source_country_id == sellerCountryId &&
                r.destination_country_id == userCountryId &&
                r.is_active &&
                (region ? r.zone_name && r.zone_name.toLowerCase() === region.toLowerCase() : r.zone_name && r.zone_name.toLowerCase() === userRegion.toLowerCase())
            );

            // Sinon sans région (National)
            if (!rule) {
                rule = rules.find(r =>
                    r.delivery_type === type &&
                    r.source_country_id == sellerCountryId &&
                    r.destination_country_id == userCountryId &&
                    r.is_active &&
                    (!r.zone_name || r.zone_name.toLowerCase() === 'national' || r.zone_name.toLowerCase() === 'sénégal')
                );
            }

            return rule;
        }

        function formatDelay(delay) {
            if (!delay) return null;
            const now = new Date();
            const months = ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'];

            // Handle range like "3-5"
            if (delay.includes('-')) {
                const parts = delay.split('-');
                const dMin = new Date(); dMin.setDate(now.getDate() + parseInt(parts[0]));
                const dMax = new Date(); dMax.setDate(now.getDate() + parseInt(parts[1]));

                const minStr = dMin.getDate() + (dMin.getMonth() !== dMax.getMonth() ? ' ' + months[dMin.getMonth()] : '');
                const maxStr = dMax.getDate() + ' ' + months[dMax.getMonth()];

                return `le ${minStr} - ${maxStr}`;
            }

            // Handle single number like "3"
            const n = parseInt(delay);
            if (!isNaN(n)) {
                const d = new Date(); d.setDate(now.getDate() + n);
                return `le ${d.getDate()} ${months[d.getMonth()]}`;
            }

            return `le ${delay}`;
        }

        function calculateTotalShipping(type, prRegion = null) {
            let total = 0;
            let commonDelay = null;
            const sellers = Object.keys(sellerOrigins);
            const feeDisplays = document.querySelectorAll('.shipmet-fee-value');
            const delayDisplays = document.querySelectorAll('.shipment-delay-value');

            sellers.forEach(sellerId => {
                const rule = getRule(type, sellerId, prRegion);
                const fee = rule ? parseFloat(rule.price) : 0;
                const delayRaw = rule && rule.delivery_delay ? rule.delivery_delay : (type === 'domicile' ? '2-4' : '3-5');
                const delay = formatDelay(delayRaw) || (type === 'domicile' ? '2 à 4 jours' : '3 à 5 jours');

                if (!commonDelay) commonDelay = delay;

                total += fee;

                feeDisplays.forEach(el => {
                    if (el.getAttribute('data-seller-id') == sellerId) {
                        el.innerText = fee.toLocaleString() + ' F';
                    }
                });

                delayDisplays.forEach(el => {
                    if (el.getAttribute('data-seller-id') == sellerId) {
                        el.innerText = 'Livraison ' + delay;
                    }
                });
            });
            return { total, delay: commonDelay };
        }

        function toggleDeliveryOptions() {
            const isPR = document.getElementById('radio-pr').checked;

            // Calculer les deux pour mettre à jour les labels d'options
            const resPR = calculateTotalShipping('retrait_point_relais', selectedPRRegion);
            const resDomicile = calculateTotalShipping('livraison_domicile');

            // Update labels
            document.getElementById('price-pr').innerText = `${resPR.total.toLocaleString()} FCFA`;
            document.getElementById('price-domicile').innerText = `${resDomicile.total.toLocaleString()} FCFA`;

            // Show/hide badges
            document.getElementById('price-pr-badge').style.display = 'inline-block';
            document.getElementById('price-domicile-badge').style.display = 'inline-block';

            const textPr = 'Livraison ' + resPR.delay;
            const textDom = 'Livraison ' + resDomicile.delay;

            document.getElementById('date-pr').innerText = textPr;
            document.getElementById('date-domicile').innerText = textDom;

            // Update summary date placeholders
            if (document.getElementById('summary-date-pr')) document.getElementById('summary-date-pr').innerText = textPr;
            if (document.getElementById('summary-date-dom')) document.getElementById('summary-date-dom').innerText = textDom;

            const isModePR = isPR;
            const currentRes = isModePR ? resPR : resDomicile;

            document.getElementById('pr-selection-area').style.display = isPR ? 'block' : 'none';
            document.getElementById('domicile-details-area').style.display = isPR ? 'none' : 'block';

            document.getElementById('shipping-fee').innerText = currentRes.total.toLocaleString() + ' FCFA';

            updateTotal(currentRes.total);
            checkValidity();
        }

        function updateTotal(fee) {
            const total = subtotal + fee;
            const formatted = total.toLocaleString();
            document.getElementById('final-total').innerText = formatted + ' FCFA';

            // Update payment badges
            document.querySelectorAll('.payment-total-value').forEach(el => {
                el.innerText = formatted;
            });
        }

        function checkValidity() {
            // Simplified: button is always active to avoid production blockers
            const btn = document.getElementById('btn-submit');
            if (btn) {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.pointerEvents = 'auto';
            }
        }

        document.getElementById('btn-choose-pr').onclick = function (e) {
            e.preventDefault();

            // Calculer et afficher les frais pour chaque point relais
            document.querySelectorAll('.pr-fee-display').forEach(el => {
                const region = el.getAttribute('data-region');
                let totalFee = 0;
                Object.keys(sellerOrigins).forEach(sellerId => {
                    const rule = getRule('retrait_point_relais', sellerId, region);
                    totalFee += rule ? parseFloat(rule.price) : 0;
                });
                el.innerText = totalFee.toLocaleString() + ' FCFA';
            });

            document.getElementById('pr-modal').style.display = 'flex';
        };

        function closePRModal() {
            document.getElementById('pr-modal').style.display = 'none';
        }

        function selectPoint(id, name, addr, region) {
            document.getElementById('input_point_relais_id').value = id;
            document.getElementById('pr-selected-name').innerText = name;
            document.getElementById('pr-selected-name').style.color = '#388e3c';
            document.getElementById('pr-selected-addr').innerText = addr;
            document.getElementById('pr-status-box').style.background = '#e8f5e9';

            // Sync with summary
            document.getElementById('summary-pr-name').innerText = name;
            document.getElementById('summary-pr-addr').innerText = addr;

            selectedPRRegion = region;

            closePRModal();
            toggleDeliveryOptions();
            saveCheckoutState();
        }

        function confirmDelivery(silent = false) {
            const isPR = document.getElementById('radio-pr').checked;
            const prId = document.getElementById('input_point_relais_id').value;

            if (isPR && !prId) {
                if (!silent) {
                    alert('Veuillez sélectionner un point relais.');
                    document.getElementById('btn-choose-pr').click();
                }
                return;
            }

            // Update Summary Blocks visibility
            document.getElementById('summary-pr-block').style.display = isPR ? 'block' : 'none';
            document.getElementById('summary-domicile-block').style.display = isPR ? 'none' : 'block';

            const res = isPR ? calculateTotalShipping('retrait_point_relais', selectedPRRegion) : calculateTotalShipping('livraison_domicile');

            // Update each shipment card in summary
            let modeLabel = isPR ? "Livraison en Point Relais" : "Livraison à domicile";
            document.querySelectorAll('[id^="summary-mode-"]').forEach(el => {
                el.innerText = modeLabel;
            });

            // UI Transitions
            document.getElementById('deliveryForm').style.display = 'none';
            document.getElementById('delivery-summary').style.display = 'block';

            document.getElementById('delivery-header').style.display = 'none';
            document.getElementById('delivery-header-done').style.display = 'flex';

            // Unlock Payment
            const paymentBox = document.getElementById('box-payment');
            paymentBox.style.opacity = '1';
            paymentBox.style.pointerEvents = 'auto';
            document.getElementById('payment-body').style.display = 'block';

            saveCheckoutState();
            if (!silent) {
                const box = document.getElementById('box-payment');
                window.scrollTo({ top: box.offsetTop - 20, behavior: 'smooth' });
            }
        }

        function confirmPayment(silent = false) {
            const selected = document.querySelector('input[name="ui_payment"]:checked');
            if (!selected) {
                if (!silent) alert('Veuillez sélectionner un mode de paiement.');
                return;
            }

            const label = selected.closest('.payment-option-modern');
            const baseName = label.querySelector('.payment-name').innerText;

            // Safely extract icon/logo HTML
            const iconContainer = label.querySelector('div[style*="margin-left: auto"]');
            const iconHtml = iconContainer ? iconContainer.innerHTML : '<i class="fas fa-wallet"></i>';

            document.getElementById('summary-payment-name').innerText = baseName;
            document.getElementById('summary-payment-icon').innerHTML = iconHtml;

            document.getElementById('payment-options-list').style.display = 'none';
            document.getElementById('payment-summary').style.display = 'block';
            document.getElementById('back-to-shop-link').style.display = 'block';

            // Toggle Headers
            document.getElementById('payment-header').style.display = 'none';
            document.getElementById('payment-header-done').style.display = 'block';

            // Final button in sidebar can be truly enabled now
            document.getElementById('btn-submit').style.opacity = '1';
            document.getElementById('btn-submit').style.pointerEvents = 'auto';

            saveCheckoutState();
        }

        function editPayment() {
            document.getElementById('payment-options-list').style.display = 'block';
            document.getElementById('payment-summary').style.display = 'none';
            document.getElementById('back-to-shop-link').style.display = 'none';

            // Toggle Headers
            document.getElementById('payment-header').style.display = 'block';
            document.getElementById('payment-header-done').style.display = 'none';

            // Optionally lock final button
            document.getElementById('btn-submit').style.opacity = '0.5';
            document.getElementById('btn-submit').style.pointerEvents = 'none';
            saveCheckoutState();
        }

        function editDelivery() {
            document.getElementById('deliveryForm').style.display = 'block';
            document.getElementById('delivery-summary').style.display = 'none';

            document.getElementById('delivery-header').style.display = 'flex';
            document.getElementById('delivery-header-done').style.display = 'none';

            document.getElementById('payment-body').style.display = 'none';

            // Reset Payment Header
            const paymentHeader = document.getElementById('payment-header');
            paymentHeader.style.display = 'block';
            paymentHeader.style.background = '#fff';
            document.getElementById('payment-header-done').style.display = 'none';

            // Optionally lock final button
            document.getElementById('btn-submit').style.opacity = '0.5';
            document.getElementById('btn-submit').style.pointerEvents = 'none';
            saveCheckoutState();
        }

        function selectModernPayment(el, gestion, moyen, silent = false) {
            // Deselect all
            document.querySelectorAll('.payment-option-modern').forEach(opt => opt.classList.remove('selected'));
            el.classList.add('selected');
            el.querySelector('input[type="radio"]').checked = true;

            // Update hidden inputs
            document.getElementById('gestion_paiement').value = gestion;
            document.getElementById('moyen_paiement').value = moyen;



            // Show Voucher Input
            document.getElementById('voucher-container').style.display = 'block';
            document.getElementById('voucher-placeholder-text').style.display = 'none';

            if (!silent) saveCheckoutState();
        }

        // submitFinal() removed for standard HTML form submission (Fail-safe)

        let appliedDeduction = 0;

        async function applyVoucher() {
            const codeInput = document.getElementById('voucher_code');
            const code = codeInput.value.trim();
            const finalTotalSpan = document.getElementById('final-total');
            const subtotal = {{ $subtotal }};
            const shippingFee = parseInt(document.getElementById('shipping-fee').innerText.replace(/[^0-9]/g, '') || 0);
            const currentTotal = subtotal + shippingFee;

            if (!code) {
                alert('Veuillez entrer un code.');
                return;
            }

            try {
                const response = await fetch("{{ route('gift-cards.apply-checkout') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ code: code, total: currentTotal })
                });

                const data = await response.json();

                if (data.success) {
                    appliedDeduction = data.deduction;

                    // CRITICAL: set hidden fields so controller can process gift card from POST data (not session)
                    document.getElementById('applied_gift_card_code').value = code;
                    document.getElementById('gestion_paiement').value = 'commande';
                    document.getElementById('moyen_paiement').value = 'gift_card';

                    // Update UI
                    document.getElementById('gift-card-row').style.display = 'flex';
                    document.getElementById('gift-card-deduction').innerText = '- ' + data.deduction.toLocaleString('fr-FR') + ' FCFA';
                    finalTotalSpan.innerText = data.newTotal.toLocaleString('fr-FR') + ' FCFA';

                    codeInput.disabled = true;
                    codeInput.style.background = '#f9f9f9';
                    document.querySelector('button[onclick="applyVoucher()"]').disabled = true;
                    document.querySelector('button[onclick="applyVoucher()"]').style.opacity = '0.5';

                    if (data.newTotal === 0) {
                        // Fully paid by gift card
                        document.getElementById('btn-submit').style.opacity = '1';
                        document.getElementById('btn-submit').style.pointerEvents = 'auto';
                        document.getElementById('btn-submit').innerText = 'Confirmer la commande (Payé par Carte Cadeau)';
                        alert('Carte cadeau appliquée ! Votre commande est entièrement couverte, aucun paiement mobile requis.');
                    } else {
                        // Partial: remaining must be paid by OM/Wave
                        alert('Carte cadeau appliquée !\nReliquat à payer : ' + data.newTotal.toLocaleString('fr-FR') + ' FCFA\nVeuillez sélectionner Orange Money ou Wave pour le reste.');
                    }

                    saveCheckoutState();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error applying gift card:', error);
                alert('Une erreur est survenue.');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadCheckoutState();
            toggleDeliveryOptions();

            /* 
               PayDunya Global Init REMOVED - Reverting to Standard Redirection 
            */
        });
    </script>
@endsection