@extends('layouts.app')

@section('title', 'Créer une annonce')

@push('styles')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: white;
        }

        /* Remove number input spinners */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .create-annonce-container {
            max-width: 1300px;
            /* Increased to accommodate right advisory */
            margin: 3rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 240px 1fr 280px;
            /* Sidebar, Form, Advisory */
            gap: 2.5rem;
            align-items: flex-start;
        }

        /* Sidebar gauche - Indicateur de progression */
        .progress-sidebar {
            background: transparent;
            border: none;
            padding: 0;
            height: fit-content;
            position: sticky;
            top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 3.5rem;
            /* Increased spacing */
        }

        .progress-step {
            display: flex;
            align-items: center;
            position: relative;
        }

        .progress-step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 16px;
            /* Half of 32px */
            top: 32px;
            /* Height of circle */
            bottom: -3.5rem;
            /* Matches progress-sidebar gap */
            width: 2px;
            background-color: #f0f0f0;
            z-index: 0;
        }

        .progress-step.completed:not(:last-child)::after {
            background-color: #00A400;
        }

        .step-circle {
            width: 32px;
            /* Increased from 26px */
            height: 32px;
            /* Increased from 26px */
            border-radius: 50%;
            border: 2px solid #e0e0e0;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1.25rem;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .progress-step.active .step-circle {
            border-color: #00A400;
            background: white;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .progress-step.completed .step-circle {
            border-color: #00A400;
            background: #00A400;
        }

        .step-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #00A400;
            display: none;
        }

        .progress-step.active .step-dot {
            display: block;
        }

        .step-check {
            color: white;
            font-size: 14px;
            display: none;
        }

        .progress-step.completed .step-check {
            display: block;
        }

        .step-content {
            flex: 1;
            padding-top: 2px;
        }

        .step-number {
            font-size: 0.7rem;
            color: #888;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 2px;
            display: block;
        }

        .progress-step.active .step-number {
            color: #555;
        }

        .step-title {
            font-weight: 700;
            font-size: 0.9rem;
            color: #888;
            line-height: 1.2;
        }

        .progress-step.active .step-title {
            color: #222;
        }

        .progress-step.completed .step-title,
        .progress-step.completed .step-number {
            color: #00A400;
        }

        /* Contenu principal */
        .form-content {
            background: white;
            border-radius: 12px;
            padding: 2.25rem 2.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #eeeeee;
            max-width: 600px;
        }

        .form-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: #222;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            line-height: 1.2;
        }

        .form-instructions {
            margin-bottom: 2rem;
        }

        .instruction-text {
            font-size: 0.9rem;
            color: #555;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }

        .instruction-text strong {
            color: #00A400;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 1.75rem;
        }

        .form-label {
            display: block;
            font-weight: 500;
            color: #333;
            margin-bottom: 0.65rem;
            font-size: 0.875rem;
        }

        .form-input,
        select.form-input,
        textarea.form-input {
            width: 100%;
            max-width: 480px;
            padding: 0.65rem 1rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 6px;
            font-size: 0.95rem;
            font-family: inherit;
            outline: none;
            transition: all 0.2s ease;
            background: white;
        }

        .form-input:focus,
        select.form-input:focus,
        textarea.form-input:focus {
            border-color: black;
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }

        .form-input::placeholder {
            color: #aaa;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 120px;
        }

        .form-input-wrapper {
            position: relative;
        }

        .char-counter {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            font-size: 0.8rem;
            color: #aaa;
            background: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }

        .category-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .category-badge {
            padding: 0.5rem 1.25rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #555;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
        }

        .category-badge:hover {
            border-color: #008400;
            color: #008400;
            background: #f0fff0;
        }

        .category-badge.active {
            background: #008400;
            color: white;
            border-color: #008400;
            box-shadow: 0 2px 6px rgba(0, 132, 0, 0.2);
        }

        .change-category-btn {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.6rem 0;
            border: none;
            background: transparent;
            color: #008400;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }

        .change-category-btn:hover {
            opacity: 0.8;
            background: transparent;
            color: #008400;
        }

        .change-category-btn svg {
            width: 16px;
            height: 16px;
        }

        .product-summary-box {
            background: #fafafa;
            padding: 0.85rem 1.25rem;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border: 1px solid #f0f0f0;
        }

        .product-summary-name {
            font-size: 1rem;
            font-weight: 500;
            color: #333;
        }

        .product-summary-edit {
            color: #666;
            cursor: pointer;
            transition: color 0.25s ease;
        }

        .product-summary-edit:hover {
            color: #008400;
        }

        .suggestion-cards {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-top: 1rem;
        }

        /* Category Badges Styling */
        .category-badges-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .category-badge-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.6rem 1rem;
            border: 1.5px solid #e0e0e0;
            border-radius: 50px;
            background: white;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.9rem;
            font-weight: 500;
            color: #444;
        }

        .category-badge-item:hover {
            border-color: #000;
            background: #fafafa;
        }

        .category-badge-item.selected {
            border-color: #000;
            background: #fff;
            color: #000;
            border-width: 1px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .category-badge-icon svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .selection-summary-box {
            background: #fdfdfd;
            border: 1px dashed #ccc;
            padding: 1rem 1.25rem;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
            animation: fadeIn 0.3s ease;
        }

        .selection-summary-text {
            font-size: 0.9rem;
            color: #555;
        }

        .selection-summary-path {
            font-weight: 600;
            color: #000;
            display: block;
            margin-top: 2px;
        }

        .selection-summary-edit {
            color: #008400;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Step 3 Styles */
        .status-cards-grid {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 1rem;
            width: 100%;
        }

        .status-card {
            flex: 1;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            flex-direction: row;
            align-items: center;
            text-align: left;
            gap: 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
            background: white;
            font-size: 0.85rem;
            color: #444;
            position: relative;
            min-width: 0;
        }

        .status-card:hover {
            border-color: #000;
        }

        .status-card.selected {
            border-color: #000;
            border-width: 1px;
            background: #fff;
        }

        .status-card.disabled {
            background-color: #f9f9f9;
            color: #ccc;
            cursor: not-allowed;
            border-style: solid;
        }

        .radio-circle {
            width: 20px;
            height: 20px;
            border: 2px solid #e0e0e0;
            border-radius: 50%;
            position: relative;
            background: white;
            flex-shrink: 0;
            margin-bottom: 4px;
        }

        .status-card.disabled .radio-circle {
            background-color: #f0f0f0;
            border-color: #ddd;
        }

        .status-card.selected .radio-circle::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: #00A400;
            border-radius: 50%;
            border: 1.5px solid white;
            box-shadow: 0 0 0 1.5px #00A400;
        }

        .photo-grid-system {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 110px));
            gap: 12px;
            margin-top: 0.5rem;
        }

        .photo-upload-box {
            width: 110px;
            height: 110px;
            border: 1.5px dashed #ccc;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: #fdfdfd;
            transition: all 0.2s ease;
        }

        .photo-upload-box:hover {
            border-color: #00A400;
            background: #fafffa;
        }

        .upload-box-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 6px;
            color: #555;
            font-size: 0.75rem;
            padding: 5px;
        }

        .upload-box-content svg {
            width: 24px;
            height: 24px;
            color: #888;
        }

        .image-preview-item {
            width: 110px;
            height: 110px;
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-photo-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ccc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #333;
            font-size: 14px;
            z-index: 5;
            padding: 0;
            line-height: 1;
        }

        .remove-photo-btn:hover {
            background: #fff;
            color: #ff0000;
            border-color: #ff0000;
        }

        /* Advisory Box Step 2 (Outside Frame) */
        .advisory-container {
            position: sticky;
            top: 2rem;
            display: none;
            /* Initially hidden */
        }

        .advisory-container.active {
            display: block;
        }

        .advisory-box {
            width: 280px;
            background-color: #f9f9f9;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #f0f0f0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .advisory-title {
            font-size: 1rem;
            font-weight: 700;
            color: #222;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .advisory-text {
            font-size: 0.85rem;
            color: #666;
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .advisory-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            color: #444;
            font-weight: 500;
        }

        .advisory-icon {
            width: 18px;
            height: 18px;
            background: #000;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 10px;
        }

        .change-category-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 1.5rem;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #f0f0f0;
        }

        .btn {
            padding: 0.6rem 1.8rem;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #008400;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 132, 0, 0.15);
        }

        .btn-primary:hover {
            background: #007300;
            box-shadow: 0 4px 8px rgba(0, 115, 0, 0.2);
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: transparent;
            color: #666;
            border: 1.5px solid #d0d0d0;
        }

        .btn-secondary:hover {
            background: #f5f5f5;
            border-color: #b0b0b0;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Étapes du formulaire */
        .form-step {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .form-step.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Upload d'images */
        .image-upload-area {
            border: 2px dashed #d0d0d0;
            border-radius: 8px;
            padding: 2.5rem;
            text-align: center;
            background: #fafafa;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .image-upload-area:hover {
            border-color: #00A400;
            background: #f5fef5;
        }

        .image-upload-area.dragover {
            border-color: #00A400;
            background: #f0fdf0;
            transform: scale(1.01);
        }

        .image-upload-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 1rem;
            color: #aaa;
        }

        .image-upload-text {
            color: #555;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .image-upload-hint {
            color: #999;
            font-size: 0.8rem;
        }

        .image-preview-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .image-preview-item {
            position: relative;
            aspect-ratio: 1;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #e5e5e5;
            transition: all 0.2s ease;
        }

        .image-preview-item:hover {
            border-color: #ccc;
            transform: scale(1.03);
        }

        .image-preview-item.main {
            border-color: #00A400;
            border-width: 3px;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview-actions {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            display: flex;
            gap: 0.4rem;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .image-preview-item:hover .image-preview-actions {
            opacity: 1;
        }

        .image-preview-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .image-preview-btn:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: scale(1.1);
        }

        .image-preview-main-badge {
            position: absolute;
            bottom: 0.5rem;
            left: 0.5rem;
            background: #00A400;
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .file-input-hidden {
            display: none;
        }

        /* Responsive */
        @media (max-width: 968px) {
            /* Prevent any accidental horizontal scroll on mobile */
            html, body {
                overflow-x: hidden;
            }

            .create-annonce-container {
                grid-template-columns: 1fr;
                gap: 1rem;
                margin: 0;
                padding: 0;
                width: 100%;
            }

            .progress-sidebar {
                position: sticky;
                top: 0;
                z-index: 100;
                background: white;
                padding: 1.1rem 1.5rem 2.75rem;
                border-bottom: 1px solid #eee;
                flex-direction: row;
                justify-content: space-between;
                align-items: flex-start;
                gap: 0;
                overflow: visible; /* allow active-step label to show below dots */
            }

            .progress-step {
                flex: 1;
                flex-direction: row;
                justify-content: center;
                align-items: flex-start;
                gap: 0;
                padding: 0;
            }

            .progress-step .step-content {
                display: none; /* Hide text on mobile nodes */
            }

            .progress-step.active .step-content {
                display: block;
                position: absolute;
                left: 50%;
                top: 2rem;
                transform: translateX(-50%);
                white-space: nowrap;
                max-width: 90vw;
                overflow: hidden;
                text-overflow: ellipsis;
                text-align: center;
                background: white;
                padding: 0.3rem 0.85rem;
                border-radius: 20px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                border: 1px solid #eee;
            }

            .step-circle {
                width: 20px;
                height: 20px;
                margin: 0;
                border-width: 2px;
            }

            .progress-step.active .step-circle {
                width: 20px;
                height: 20px;
                border-color: #00A400;
                background: white;
            }

            .step-check {
                font-size: 11px;
            }

            /* Ligne horizontale reliant les pastilles d'étapes */
            .progress-step:not(:last-child)::after {
                display: block;
                content: '';
                position: absolute;
                top: 9px;
                left: calc(50% + 13px);
                right: calc(-50% + 13px);
                bottom: auto;
                width: auto;
                height: 2px;
                background-color: #e8e8e8;
                z-index: 0;
            }

            .progress-step.completed:not(:last-child)::after {
                background-color: #00A400;
            }

            .form-content {
                padding: 1.5rem 1rem;
                border-radius: 0;
                border: none;
                box-shadow: none;
                margin-top: 0.5rem;
                max-width: 100%;
            }

            /* Inputs must never exceed the viewport width on mobile */
            .form-input,
            select.form-input,
            textarea.form-input {
                max-width: 100%;
            }

            .form-title {
                font-size: 1.25rem;
                margin-bottom: 0.75rem;
            }

            .advisory-container {
                display: none !important;
            }

            .form-actions {
                display: flex;
                justify-content: space-between;
                gap: 0.75rem;
                margin-top: 2rem;
                padding-top: 1.5rem;
            }

            .btn {
                flex: 1;
                padding: 0.8rem;
                font-size: 1rem;
            }

            .status-cards-grid {
                display: grid;
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .status-card {
                padding: 1.25rem;
            }

            .category-badge-item {
                width: 100%;
                justify-content: flex-start;
            }

            .photo-grid-system {
                grid-template-columns: repeat(3, 1fr);
            }

            .photo-upload-box, .image-preview-item {
                width: 100%;
                height: auto;
                aspect-ratio: 1;
            }

            .service-card {
                padding: 1rem !important;
                gap: 0.75rem !important;
            }

            .service-card input[type="checkbox"] {
                width: 24px !important;
                height: 24px !important;
            }

            .service-card div[style*="font-size: 1.25rem"] {
                font-size: 1.1rem !important;
            }

            .status-card span[style*="font-weight: 600"] {
                font-size: 0.95rem;
            }

            .status-card small {
                font-size: 0.7rem !important;
            }

            /* Step 4: publication status — stack title above the radio options */
            .publish-status-row {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 0.85rem;
            }

            .publish-status-options {
                width: 100%;
                justify-content: space-between;
                gap: 0.75rem !important;
            }
        }

        /* Phones */
        @media (max-width: 480px) {
            .form-content {
                padding: 1.25rem 0.85rem;
            }

            .form-title {
                font-size: 1.15rem;
            }

            .instruction-text {
                font-size: 0.85rem;
            }

            /* Two columns of photos read better on narrow phones */
            .photo-grid-system {
                grid-template-columns: repeat(2, 1fr);
            }

            /* Promo preview: stack the price comparison vertically */
            #promo-preview > div {
                flex-direction: column;
                align-items: flex-start !important;
            }

            /* Total to pay: let the big amount wrap under its label */
            .payment-total-row {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .payment-total-row span:first-child {
                font-size: 1rem !important;
            }

            /* Service card price chip shrinks so the row never overflows */
            .service-card > div:last-child {
                font-size: 1.1rem !important;
            }

            .btn {
                padding: 0.75rem 0.5rem;
                font-size: 0.95rem;
            }
        }
    </style>
@endpush

@section('content')

    <div class="create-annonce-container">
        <!-- Sidebar gauche - Indicateur de progression -->
        <aside class="progress-sidebar">
            <div class="progress-step active" data-step="1">
                <div class="step-circle">
                    <div class="step-dot"></div>
                    <div class="step-check">✓</div>
                </div>
                <div class="step-content">
                    <div class="step-number">ETAPE 1</div>
                    <div class="step-title">Votre annonce</div>
                </div>
            </div>
            <div class="progress-step" data-step="2">
                <div class="step-circle">
                    <div class="step-dot"></div>
                    <div class="step-check">✓</div>
                </div>
                <div class="step-content">
                    <div class="step-number">ETAPE 2</div>
                    <div class="step-title">Catégories</div>
                </div>
            </div>
            <div class="progress-step" data-step="3">
                <div class="step-circle">
                    <div class="step-dot"></div>
                    <div class="step-check">✓</div>
                </div>
                <div class="step-content">
                    <div class="step-number">ETAPE 3</div>
                    <div class="step-title">Description</div>
                </div>
            </div>
            <div class="progress-step" data-step="4">
                <div class="step-circle">
                    <div class="step-dot"></div>
                    <div class="step-check">✓</div>
                </div>
                <div class="step-content">
                    <div class="step-number">ETAPE 4</div>
                    <div class="step-title">Booster votre annonce</div>
                </div>
            </div>
        </aside>
        <!-- Contenu principal -->
        <main class="form-content">
            @if(session('success'))
                <div class="alert alert-success mt-3" style="background-color: #d4edda; border-color: #c3e6cb; color: #155724; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                    <strong>Succès !</strong> Votre annonce a été enregistrée avec succès.
                </div>
            @endif

            @if(session('limit_error'))
                <div class="alert alert-danger mt-3" style="background-color: #f8d7da; border-color: #f5c6cb; color: #721c24; padding: 1rem; border-radius: 8px; margin-bottom: 2.5rem;">
                    <strong>Erreur !</strong> {{ session('limit_error') }}
                    
                    <div style="margin-top: 1rem; border-top: 1px solid rgba(196, 0, 0, 0.1); padding-top: 0.75rem;">
                        <a href="{{ route('vendeur.create', ['type' => 'professionnel']) }}" style="color: #721c24; font-weight: 700; text-decoration: underline; font-size: 0.95rem;">
                            Passer à un compte PRO maintenant → pour Accéder aux outils professionnels et vendre sans limites !
                        </a>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error" style="background: #fff5f5; border: 1px solid #fccece; color: #c40000; padding: 1.25rem; border-radius: 8px; margin-bottom: 2rem; box-shadow: 0 2px 4px rgba(196, 0, 0, 0.05);">
                    <div style="display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 0.75rem;">
                        <i class="fas fa-exclamation-circle" style="font-size: 1.25rem; margin-top: 2px;"></i>
                        <strong style="font-size: 1.1rem;">Veuillez corriger les erreurs suivantes :</strong>
                    </div>
                    <ul style="margin: 0; padding-left: 2.25rem; font-size: 0.95rem; line-height: 1.6;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="createAnnonceForm" method="POST" action="{{ route('annonces.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="produit">
                <input type="hidden" id="currentStep" value="1">
                <input type="hidden" id="type_livraison" name="type_livraison" value="retrait_point_relais">
                <input type="hidden" id="user_phone" name="user_phone" value="{{ auth()->user()->telephone ?? '' }}">
                <input type="hidden" id="code_postal" name="code_postal" value="{{ auth()->user()->code_postal ?? '00000' }}">
                <!-- Étape 1: Votre annonce -->
                <div class="form-step active" id="step1">
                    <h1 class="form-title">👋 Que vendez-vous aujourd'hui ?</h1>
                    <div class="form-instructions">
                        <p class="instruction-text">Indiquez quelques <strong
                                style="color: #00A400;">caractéristiques</strong> de votre produit pour faciliter sa
                            recherche dans notre catalogue.</p>
                    </div>
                    <div class="form-group"><label for="product_name" class="form-label">Nom du produit</label>
                        <div class="form-input-wrapper"><input type="text" id="product_name" name="titre" class="form-input"
                                placeholder="Nom ou code barre du produit" maxlength="200" required
                                oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                        </div>
                    </div>
                    <div class="form-actions"><button type="button" class="btn btn-primary" onclick="nextStep()">Continuer
                        </button></div>
                </div>
                <!-- Étape 2: Catégories -->
                <div class="form-step" id="step2">
                    <h1 class="form-title">📦 Dites-nous en plus</h1>

                    <div class="product-summary-box">
                        <span id="summary_product_name" class="product-summary-name">Nom du produit</span>
                        <div class="product-summary-edit" onclick="previousStep()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" style="font-size: 0.9rem; font-weight: 500; color: #666;">Catégorie de
                            l'article</label>
                        <input type="hidden" id="categorie_id" name="categorie_id" required>

                        <div class="category-badges-container">
                            @php
                                $icons = [
                                    'E-commerce' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>',
                                    'Services' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>',
                                    'Immobilier' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>',
                                    'Véhicules' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="13" width="22" height="8" rx="2"></rect><path d="M7 13V6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v7"></path></svg>'
                                ];
                            @endphp
                            @foreach($categories->where('parent_id', null) as $categorie)
                                <div class="category-badge-item main-cat-badge" data-id="{{ $categorie->id }}"
                                    onclick="selectMainCategory(this, {{ $categorie->id }})">
                                    <span class="category-badge-icon">
                                        @if($categorie->icone)
                                            {!! $categorie->icone !!}
                                        @else
                                            {!! $icons[$categorie->nom] ?? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>' !!}
                                        @endif
                                    </span>
                                    {{ $categorie->nom }}
                                </div>
                            @endforeach
                        </div>

                        <div id="level2Section" style="display:none; margin-top: 1.5rem;">
                            <label class="form-label" style="font-size: 0.9rem; font-weight: 600; color: #333; margin-bottom: 0.75rem; display: block;">Choisissez une sous-catégorie</label>
                            <select id="level2Select" class="form-input" onchange="onLevel2Change(this.value)" style="width: 100%; border-radius: 8px;">
                                <option value="">Choisir une option...</option>
                            </select>
                        </div>

                        <div id="level3Section" style="display:none; margin-top: 1.5rem;">
                            <label class="form-label" style="font-size: 0.9rem; font-weight: 600; color: #333; margin-bottom: 0.75rem; display: block;">Précisez votre choix (champ détaillé)</label>
                            <select id="level3Select" class="form-input" onchange="onLevel3Change(this.value)" style="width: 100%; border-radius: 8px;">
                                <option value="">Choisir une option...</option>
                            </select>
                        </div>

                        <div id="dynamic-filters-container" style="margin-top: 1.5rem;"></div>
                    </div>

                    <div class="form-actions"><button type="button" class="btn btn-secondary"
                            onclick="previousStep()">Précédent </button><button type="button" class="btn btn-primary"
                            onclick="nextStep()">Continuer </button></div>
                </div>
                <!-- Étape 3: Description et Photos -->
                <div class="form-step" id="step3">
                    <h1 class="form-title">✍️ Donnez nous plus de précisions !</h1>

                    <div class="product-summary-box">
                        <span class="product-summary-name-s3" id="summary_product_name_s3">Nom du produit</span>
                        <div class="product-summary-edit" onclick="previousStep()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                        </div>
                    </div>

                    <div id="productConditionGroup" class="form-group" style="margin-top: 1.5rem;">
                        <label class="form-label"
                            style="font-size: 0.9rem; font-weight: 700; color: #000; margin-bottom: 0.5rem;">État</label>
                        <input type="hidden" id="etat_produit" name="etat" value="Neuf" required>
                        <div class="status-cards-grid">
                            <div class="status-card selected" onclick="selectStatus(this, 'Neuf')">
                                <div class="radio-circle"></div>
                                Neuf
                            </div>
                            <div class="status-card" onclick="selectStatus(this, 'Occasion')">
                                <div class="radio-circle"></div>
                                Occasion
                            </div>
                            <div class="status-card" onclick="selectStatus(this, 'Reconditionné')">
                                <div class="radio-circle"></div>
                                Reconditionné
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 1.5rem;">
                        <label class="form-label"
                            style="font-size: 0.95rem; font-weight: 700; color: #000; margin-bottom: 1rem; display: block;">
                            Ajouter des photos <span id="photoCountDisplay"
                                style="color: #666; font-weight: 500; margin-left: 0.5rem;">0 sur 8</span>
                        </label>

                        <div class="photo-grid-system" id="photoGrid">
                            <!-- Previews will go here -->
                            <div class="photo-upload-box" onclick="document.getElementById('photosInput').click()"
                                id="uploadTrigger">
                                <div class="upload-box-content">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                    <span>Ajouter une image</span>
                                </div>
                            </div>
                        </div>

                        <p style="font-size: 0.85rem; color: #666; margin-top: 1rem;">
                            Augmentez vos chances de vendre en ajoutant des photos de votre produit.
                        </p>

                        <input type="file" id="photosInput" name="photos[]"
                            accept="image/jpeg,image/jpg,image/png,image/webp" multiple class="file-input-hidden"
                            onclick="this.value=null" onchange="handleFiles(this.files)">
                    </div>

                    <div class="form-group" style="margin-top: 2rem;">
                        <label for="description" class="form-label"
                            style="font-size: 0.9rem; font-weight: 700; color: #000; margin-bottom: 0.5rem;">Informations de
                            l'annonce</label>
                        <textarea id="description" name="description" class="form-input" rows="5" placeholder="Description"
                            required style="border-radius: 8px; border: 1.5px solid #e0e0e0; padding: 1rem;"></textarea>
                    </div>


                    <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-top: 2rem;">
                        <div class="form-group">
                            <label for="prix" class="form-label"
                                style="font-size: 0.9rem; font-weight: 700; color: #000; margin-bottom: 0.5rem;">Prix actuel</label>
                            <input type="number" id="prix" name="prix" class="form-input" placeholder="Ex: 5000" min="0"
                                required style="border-radius: 8px; border: 1.5px solid #e0e0e0; padding: 0.6rem 1rem; width: 100%; height: 45px;"
                                oninput="updatePromoPreview()">
                        </div>





                        <div id="quantity-container" class="form-group">
                            <label for="quantite" class="form-label"
                                style="font-size: 0.9rem; font-weight: 700; color: #000; margin-bottom: 0.5rem;">Quantité</label>
                            <input type="number" id="quantite" name="quantite" class="form-input" placeholder="Ex: 1" min="1"
                                value="1" required
                                style="border-radius: 8px; border: 1.5px solid #e0e0e0; padding: 0.6rem 1rem; width: 100%; height: 45px;">
                        </div>
                    </div>

                    <div class="form-actions"><button type="button" class="btn btn-secondary"
                            onclick="previousStep()">Précédent </button><button type="button" class="btn btn-primary"
                            onclick="nextStep()">Continuer </button></div>
                </div>
                <!-- Étape 4: Booster votre annonce -->
                <div class="form-step" id="step4">
                    <span id="user-credit-balance" style="display: none;">{{ $creditBalance }}</span>

                    <div style="margin-bottom: 2rem;">
                        <h2 class="form-title" style="margin-bottom: 0.5rem;">🚀 Booster votre annonce</h2>
                        <p class="instruction-text" style="color: #666; font-size: 0.95rem;">Mettez votre annonce en avant pour vendre d'autant plus vite.</p>
                    </div>

                    {{-- === Section Code Promo (Etape 4) === --}}
                    <div id="promo-section" style="display: none; margin-bottom: 2rem; padding: 1.25rem; background: linear-gradient(135deg, #fff9db 0%, #fff3bf 100%); border: 2px dashed #fcc419; border-radius: 12px; animation: slideIn 0.4s ease-out; box-shadow: 0 4px 15px rgba(252, 196, 25, 0.1);">
                        <div style="display: flex; align-items: flex-start; gap: 0.75rem; margin-bottom: 0.75rem;">
                            <div style="flex: 1;">
                                <label style="font-size: 0.95rem; font-weight: 800; color: #856404; margin: 0; display: block;">
                                    Boostez vos ventes gratuitement !
                                </label>
                                <p style="font-size: 0.8rem; color: #92700e; margin: 0.25rem 0 0.5rem 0; line-height: 1.4;">
                                    Appliquez un code promo pour mettre en avant votre annonce. Un <strong>prix barré</strong> attire 3x plus d'acheteurs et accélère la vente.
                                </p>
                            </div>
                        </div>

                        <div style="display: flex; gap: 0.5rem; align-items: center; background: white; padding: 0.4rem; border-radius: 10px; border: 1.5px solid #ffec99;">
                            <input type="text" id="promo_code_input" placeholder="ENTREZ VOTRE CODE ICI"
                                style="flex: 1; padding: 0.6rem 0.75rem; border: none; border-radius: 6px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; outline: none; background: transparent;"
                                oninput="this.value = this.value.toUpperCase()">
                            <button type="button" onclick="applyPromoCode()"
                                style="padding: 0.6rem 1.25rem; background: #fcc419; color: #453b0c; border: none; border-radius: 8px; font-weight: 800; font-size: 0.85rem; cursor: pointer; transition: transform 0.2s;"
                                onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                APPLIQUER
                            </button>
                        </div>
                        
                        <div id="promo-error" style="display: none; color: #e03131; font-size: 0.75rem; margin-top: 0.5rem; font-weight: 600; padding-left: 0.5rem;"></div>

                        {{-- Prévisualisation Premium --}}
                        <div id="promo-preview" style="display: none; margin-top: 1rem; padding: 1rem; background: white; border-radius: 10px; border: 1px solid #ffec99; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem;">
                                <div style="display: flex; align-items: center; gap: 1rem;">
                                    <div>
                                        <span style="font-size: 0.7rem; color: #adb5bd; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 2px;">Prix Initial</span>
                                        <span id="promo-original-price" style="font-size: 0.95rem; color: #adb5bd; text-decoration: line-through; font-weight: 600;"></span>
                                    </div>
                                    <div style="font-size: 1.25rem; color: #fab005;">➜</div>
                                    <div>
                                        <span style="font-size: 0.7rem; color: #fa5252; font-weight: 700; text-transform: uppercase; display: block; margin-bottom: 2px;">Prix Flash</span>
                                        <span id="promo-discounted-price" style="font-size: 1.15rem; color: #2b8a3e; font-weight: 900;"></span>
                                    </div>
                                </div>
                                <div id="promo-badge" style="background: #fa5252; color: white; font-size: 0.85rem; font-weight: 900; padding: 4px 10px; border-radius: 6px; box-shadow: 0 2px 5px rgba(250, 82, 82, 0.3);"></div>
                            </div>
                            <div style="margin-top: 0.75rem; padding-top: 0.75rem; border-top: 1px solid #f1f3f5; display: flex; align-items: center; gap: 0.5rem;">
                                <span style="font-size: 1rem;">✨</span>
                                <span id="promo-success-text" style="font-size: 0.75rem; color: #495057; font-weight: 600;">Félicitations ! Votre annonce sera mise en avant avec ce prix barré pour attirer plus de clients.</span>
                            </div>
                        </div>
                        <input type="hidden" id="promo_code" name="promo_code" value="">
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">Options de visibilité</h3>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            @foreach($creditServices as $service)
                                @if($service->cle == 'urgent') @continue @endif
                                <label class="service-card" style="display: flex; align-items: flex-start; gap: 1rem; padding: 1.25rem; background: linear-gradient(135deg, #fff9db 0%, #fff3bf 100%); border: 2px dashed #fcc419; border-radius: 12px; cursor: pointer; transition: all 0.2s; position: relative; box-shadow: 0 4px 10px rgba(252, 196, 25, 0.05); animation: fadeIn 0.4s ease-out;">
                                    <input type="checkbox" name="services[]" value="{{ $service->cle }}" class="service-checkbox" data-cost="{{ $service->credits_requis }}" style="width: 22px; height: 22px; margin-top: 4px; accent-color: #f08c00;">
                                    <div style="flex: 1;">
                                        <div style="font-weight: 800; font-size: 1.05rem; margin-bottom: 0.25rem; color: #856404; display: flex; align-items: center; gap: 0.5rem;">
                                            {{ $service->nom }}
                                            @if($service->cle == 'mise_en_avant' || $service->cle == 'boost')
                                                <span style="background: #fcc419; color: #453b0c; font-size: 0.65rem; font-weight: 800; padding: 2px 8px; border-radius: 6px; text-transform: uppercase;">Recommandé</span>
                                            @endif
                                        </div>
                                        <div style="font-size: 0.85rem; color: #92700e; line-height: 1.4; font-weight: 600;">{{ $service->description }}</div>
                                        @if($service->duree_jours)
                                            <div style="font-size: 0.8rem; color: #b7791f; margin-top: 0.5rem; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                                                <span>⏳</span> Valable {{ $service->duree_jours }} jours
                                            </div>
                                        @endif
                                    </div>
                                    <div style="font-weight: 900; font-size: 1.3rem; color: #e67e22; white-space: nowrap; text-shadow: 0 1px 0 rgba(255,255,255,0.5);">
                                        +{{ $service->credits_requis }} <span style="color: #fcc419;">⭐</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div style="background: linear-gradient(135deg, #fff9db 0%, #fff3bf 100%); border: 2px dashed #fcc419; border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 4px 10px rgba(252, 196, 25, 0.05);">
                        <div class="publish-status-row" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <span style="font-weight: 800; color: #856404; font-size: 1rem;">Statut de publication</span>
                            <div class="publish-status-options" style="display: flex; gap: 1.5rem;">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #92700e; font-weight: 700;">
                                    <input type="radio" name="statut" value="brouillon" checked style="accent-color: #856404; width: 18px; height: 18px;">
                                    <span style="font-size: 0.95rem;">Brouillon</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #856404; font-weight: 800;">
                                    <input type="radio" name="statut" value="publiee" style="accent-color: #f08c00; width: 18px; height: 18px;">
                                    <span style="font-size: 0.95rem;">Publier maintenant</span>
                                </label>
                            </div>
                        </div>
                        <div class="payment-total-row" style="display: flex; justify-content: space-between; align-items: center; border-top: 1.5px solid #ffec99; padding-top: 1rem; margin-top: 0.5rem;">
                            <span style="font-weight: 900; font-size: 1.15rem; color: #453b0c; text-transform: uppercase;">Total à payer :</span>
                            <span style="font-weight: 950; font-size: 1.75rem; color: #111;">
                                <span id="total-cost-display" style="color: #e67e22;">0</span> <span style="font-size: 1.4rem; color: #fcc419;">⭐</span>
                            </span>
                        </div>
                        <div id="insufficient-credits-warning" style="display: none; background: #fde8e8; color: #c62828; padding: 0.75rem 1rem; border-radius: 6px; margin-top: 1rem; font-size: 0.9rem; border: 1px solid #ffcdd2;">
                            ⚠️ Votre solde de crédits est insuffisant pour ces options. <a href="{{ route('account.credits.index') }}" target="_blank" style="color: #c62828; font-weight: bold; text-decoration: underline;">Rechargez votre compte</a>.
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="previousStep()">Précédent</button>
                        <button type="submit" class="btn btn-primary" id="submitButton">Enregistrer l'annonce</button>
                    </div>
                </div>
            </form>
        </main>

        <!-- Advisory Area (Outside Frame) -->
        <div id="advisoryArea" class="advisory-container">
            <!-- Content for Step 2 -->
            <div id="advisoryContentStep2" class="advisory-box">
                <h3 class="advisory-title">Votre annonce sera trouvée plus facilement</h3>
                <p class="advisory-text">Un article avec des catégories détaillées sera mieux référencé et aura donc
                    plus de chances d'être présent dans les premiers résultats de recherche d'un futur acheteur.</p>

                <div class="advisory-item">
                    <div class="advisory-icon">✓</div>
                    Vérifier la catégorie de l'article
                </div>
                <div class="advisory-item">
                    <div class="advisory-icon">✓</div>
                    Définir au moins 3 niveaux de catégories
                </div>
            </div>
            <!-- Content for Step 3 -->
            <div id="advisoryContentStep3" class="advisory-box" style="display: none;">
                <h3 class="advisory-title">Précisez l'état de votre produit</h3>
                <p class="advisory-text" style="margin-bottom: 1rem;">Mettez en valeur votre produit en restant transparent
                    sur son état réel.</p>
                <p class="advisory-text" style="margin-bottom: 1rem;">Avoir 3 photos ou plus permettra d'augmenter vos
                    chances de vente de 50%.</p>
                <p class="advisory-text" style="font-size: 0.85rem; line-height: 1.5; color: #444;">Dans la description,
                    spécifiez le cas
                    échéant : si votre appareil est sous garantie, si vous disposez de la boîte d'origine, de la notice, de
                    la facture d'achat, si des accessoires sont inclus, etc.</p>
            </div>
        </div>
    </div> <!-- Close create-annonce-container -->

    <!-- Overlay d'enregistrement (évite l'impression de blocage pendant l'upload) -->
    <div id="savingOverlay" style="display:none; position:fixed; inset:0; z-index:99999; background:rgba(255,255,255,0.97); flex-direction:column; align-items:center; justify-content:center; gap:1.25rem; text-align:center; padding:2rem;">
        <div style="width:54px; height:54px; border:5px solid #e6f4e6; border-top-color:#00A400; border-radius:50%; animation:savingSpin 0.9s linear infinite;"></div>
        <div style="width:100%; max-width:320px;">
            <p id="savingTitle" style="font-size:1.05rem; font-weight:700; color:#222; margin:0 0 0.75rem;">Envoi de votre annonce…</p>
            <div style="height:8px; background:#eee; border-radius:8px; overflow:hidden; margin-bottom:0.5rem;">
                <div id="savingProgressBar" style="height:100%; width:0%; background:#00A400; border-radius:8px; transition:width 0.2s ease;"></div>
            </div>
            <p style="font-size:0.85rem; color:#666; margin:0;">
                <span id="savingProgressPct">0%</span> — ne fermez pas cette page.
            </p>
        </div>
    </div>
    <style>
        @keyframes savingSpin { to { transform: rotate(360deg); } }
        #savingOverlay.active { display: flex; }
    </style>

    <script>      // Global variabl       es
        var currentStep = 1;
        var totalSteps = 4;
        var uploadedImages = [];
        var mainImageIndex = 0;

        // Categories structure including all levels
        const categoriesData = {
            @foreach($categories as $cat)
                                                                                                                                                                                                                                                                                                            {{ $cat->id }}: {
                    id: {{ $cat->id }},
                    nom: "{{ $cat->nom }}",
                    parent_id: {{ $cat->parent_id ?? 'null' }},
                    famille: "{{ $cat->famille }}",
                    children: [
                        @if($cat->enfantsActifs)
                            @foreach($cat->enfantsActifs as $enfant)
                                { id: {{ $enfant->id }}, nom: "{{ $enfant->nom }}" },
                            @endforeach
                        @endif
                                                                                                                                    ]
                },
            @endforeach
                                                                                                                                                                                    };

        function selectMainCategory(el, id) {
            document.querySelectorAll('.main-cat-badge').forEach(b => b.classList.remove('selected'));
            el.classList.add('selected');

            document.getElementById('categorie_id').value = id;
            
            const hasChildren = populateSelect('level2Select', id);
            if (hasChildren) {
                document.getElementById('level2Section').style.display = 'block';
            } else {
                document.getElementById('level2Section').style.display = 'none';
            }
            document.getElementById('level3Section').style.display = 'none';

            fetchFilters(id);
            toggleStockVisibility(id);
            checkCategoryPromo(id);
        }

        function populateSelect(selectId, parentId) {
            const select = document.getElementById(selectId);
            const cat = categoriesData[parentId];
            
            // Clear current options
            select.innerHTML = '<option value="">Choisir une option...</option>';
            
            if (cat && cat.children && cat.children.length > 0) {
                cat.children.forEach(child => {
                    const option = document.createElement('option');
                    option.value = child.id;
                    option.textContent = child.nom;
                    select.appendChild(option);
                });
                return true;
            }
            return false;
        }

        function onLevel2Change(id) {
            if (!id) {
                document.getElementById('level3Section').style.display = 'none';
                return;
            }

            document.getElementById('categorie_id').value = id;
            const hasChildren = populateSelect('level3Select', id);
            
            if (hasChildren) {
                document.getElementById('level3Section').style.display = 'block';
            } else {
                document.getElementById('level3Section').style.display = 'none';
            }
            
            fetchFilters(id);
            toggleStockVisibility(id);
            checkCategoryPromo(id);
        }

        function onLevel3Change(id) {
            if (!id) return;
            document.getElementById('categorie_id').value = id;
            fetchFilters(id);
            toggleStockVisibility(id);
            checkCategoryPromo(id);
        }

        function resetCategorySelection() {
            document.querySelectorAll('.main-cat-badge').forEach(c => c.classList.remove('selected'));
            document.getElementById('level2Section').style.display = 'none';
            document.getElementById('level3Section').style.display = 'none';
            document.getElementById('categorie_id').value = '';
            const container = document.getElementById('dynamic-filters-container');
            if (container) container.innerHTML = '';
        }

        var currentFilters = [];

        function fetchFilters(categoryId) {
            const container = document.getElementById('dynamic-filters-container');
            if (!container) return;
            
            container.innerHTML = '<div style="padding: 1rem; color: #666; font-size: 0.9rem;"><i class="fas fa-spinner fa-spin"></i> Chargement des critères spécifiques...</div>';

            fetch(`/api/categories/${categoryId}/filters`)
                .then(response => response.json())
                .then(filters => {
                    container.innerHTML = '';
                    if (filters.length > 0) {
                        filters.forEach(filter => {
                            const field = document.createElement('div');
                            field.className = 'form-group';
                            field.style = 'margin-top: 1.5rem;';
                            
                            let inputHtml = '';
                            const commonStyle = 'width: 100%; padding: 0.75rem; border: 1.5px solid #e0e0e0; border-radius: 8px; font-size: 0.9rem; outline: none; transition: border-color 0.2s; background: white;';
                            
                            if (filter.type === 'select' || (filter.options && filter.options.length > 0)) {
                                inputHtml = `<select name="attributes[${filter.id}]" style="${commonStyle}" ${filter.is_required ? 'required' : ''}>
                                    <option value="">Sélectionner ${filter.nom}</option>
                                    ${filter.options.map(opt => `<option value="${opt}">${opt}</option>`).join('')}
                                </select>`;
                            } else if (filter.type === 'number' || filter.type === 'price') {
                                inputHtml = `<div style="display: flex; align-items: center;">
                                    <input type="number" name="attributes[${filter.id}]" style="${commonStyle} ${filter.unit ? 'border-top-right-radius: 0; border-bottom-right-radius: 0;' : ''}" placeholder="${filter.nom}" ${filter.is_required ? 'required' : ''}>
                                    ${filter.unit ? `<span style="padding: 0.75rem; background: #edf2f7; border: 1.5px solid #e0e0e0; border-left: none; border-top-right-radius: 8px; border-bottom-right-radius: 8px; font-size: 0.85rem; color: #4a5568; font-weight: 600;">${filter.unit}</span>` : ''}
                                </div>`;
                            } else {
                                inputHtml = `<input type="text" name="attributes[${filter.id}]" style="${commonStyle}" placeholder="${filter.nom}" ${filter.is_required ? 'required' : ''}>`;
                            }

                            field.innerHTML = `
                                <label style="display: block; margin-bottom: 0.5rem; font-size: 0.85rem; font-weight: 600; color: #4a5568;">
                                    ${filter.nom} ${filter.is_required ? '<span style="color: #e74c3c;">*</span>' : ''}
                                </label>
                                ${inputHtml}
                            `;
                            container.appendChild(field);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching filters:', error);
                    container.innerHTML = '';
                });
        }

        function toggleStockVisibility(categoryId) {
            const container = document.getElementById('quantity-container');
            const input = document.getElementById('quantite');
            if (!container || !input) return;

            const cat = categoriesData[categoryId];
            if (cat && (cat.famille === 'Services' || cat.famille === 'Immobilier' || cat.famille === 'Véhicules')) {
                container.style.display = 'none';
                input.value = '1'; // Default for non-stock items (services, immobilier, véhicules)
                input.removeAttribute('required');
            } else {
                container.style.display = 'block';
                input.setAttribute('required', 'required');
            }
        }

        // ====== PROMO CODE LOGIC ======
        var activeCampaignData = null; // Stores fetched campaign data

        function checkCategoryPromo(categoryId) {
            const promoSection = document.getElementById('promo-section');
            if (!promoSection) return;

            // Reset state when switching categories
            resetPromoState();

            if (!categoryId) { promoSection.style.display = 'none'; return; }

            // Call a lightweight endpoint to detect if an active campaign exists for this category + user type
            fetch(`/api/campaigns/has-active?categorie_id=${categoryId}`)
                .then(r => r.json())
                .then(res => {
                    if (res.has_campaign) {
                        promoSection.style.display = 'block';
                    } else {
                        promoSection.style.display = 'none';
                    }
                })
                .catch(() => {
                    promoSection.style.display = 'none';
                });
        }

        function resetPromoState() {
            activeCampaignData = null;
            const promoCode = document.getElementById('promo_code');
            const promoInput = document.getElementById('promo_code_input');
            const preview = document.getElementById('promo-preview');
            const error = document.getElementById('promo-error');
            if (promoCode) promoCode.value = '';
            if (promoInput) promoInput.value = '';
            if (preview) preview.style.display = 'none';
            if (error) error.style.display = 'none';
        }

        function revokePromoCode() {
            resetPromoState();
            const error = document.getElementById('promo-error');
            if (error) {
                error.textContent = "Le code promo a été révoqué.";
                error.style.color = "#495057";
                error.style.display = "block";
                setTimeout(() => { 
                    error.style.display = "none"; 
                    error.style.color = "#e03131"; 
                }, 3000);
            }
        }

        function applyPromoCode() {
            const code = document.getElementById('promo_code_input').value.trim();
            const categorieId = document.getElementById('categorie_id').value;
            const error = document.getElementById('promo-error');
            const preview = document.getElementById('promo-preview');
            const hiddenInput = document.getElementById('promo_code');

            if (!code) { showPromoError('Veuillez entrer un code promo.'); return; }
            if (!categorieId) { showPromoError('Sélectionnez d\'abord une catégorie.'); return; }

            fetch(`/api/campaigns/check-promo?code=${encodeURIComponent(code)}&categorie_id=${categorieId}`)
                .then(r => {
                    if (!r.ok) throw new Error('Server error');
                    return r.json();
                })
                .then(data => {
                    if (!data.valid) {
                        showPromoError(data.message || 'Code invalide.');
                        preview.style.display = 'none';
                        hiddenInput.value = '';
                        activeCampaignData = null;
                        return;
                    }

                    // Code valid!
                    activeCampaignData = data;
                    hiddenInput.value = code;
                    error.style.display = 'none';
                    updatePromoPreview();
                })
                .catch(err => {
                    console.error('Promo error:', err);
                    showPromoError('Une erreur est survenue lors de la vérification. Réessayez.');
                });
        }

        function updatePromoPreview() {
            if (!activeCampaignData) return;

            const prixInput = document.getElementById('prix');
            const vendeurPrix = parseFloat(prixInput.value);
            const preview = document.getElementById('promo-preview');

            if (!vendeurPrix || vendeurPrix <= 0) {
                preview.style.display = 'none';
                return;
            }

            let promoPrix;
            if (activeCampaignData.discount_type === 'percent') {
                promoPrix = vendeurPrix * (1 - activeCampaignData.discount_value / 100);
            } else {
                promoPrix = Math.max(0, vendeurPrix - activeCampaignData.discount_value);
            }

            const pct = Math.round(((vendeurPrix - promoPrix) / vendeurPrix) * 100);

            document.getElementById('promo-original-price').textContent = vendeurPrix.toLocaleString('fr-FR') + ' FCFA';
            document.getElementById('promo-discounted-price').textContent = Math.round(promoPrix).toLocaleString('fr-FR') + ' FCFA';
            document.getElementById('promo-badge').textContent = '-' + pct + '%';

            // Add duration to success message (v3 - including start date)
            const successEl = document.getElementById('promo-success-text');
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            let successMsg = "Félicitations ! Votre annonce sera mise en avant avec ce prix barré pour attirer plus de clients.";
            
            let periodStr = "";
            if (activeCampaignData.campaign_starts_at && activeCampaignData.campaign_ends_at) {
                const startDate = new Date(activeCampaignData.campaign_starts_at);
                const endDate = new Date(activeCampaignData.campaign_ends_at);
                periodStr = `Du ${startDate.toLocaleDateString('fr-FR', options)} au ${endDate.toLocaleDateString('fr-FR', options)}`;
            } else if (activeCampaignData.campaign_ends_at) {
                const endDate = new Date(activeCampaignData.campaign_ends_at);
                periodStr = `Valable jusqu'au ${endDate.toLocaleDateString('fr-FR', options)}`;
            }
            
            if (periodStr) {
                successMsg += `<br><span style="color: #fa5252; font-weight: 800; display: block; margin-top: 6px; padding: 4px 8px; background: #fff5f5; border-radius: 4px; border: 1px solid #ffe3e3;">Période : ${periodStr}</span>`;
            } else {
                successMsg += `<br><span style="color: #b7791f; font-weight: 800; display: block; margin-top: 4px;">Offre à durée limitée</span>`;
            }
            
            successMsg += `<div style="margin-top: 10px; text-align: right;"><button type="button" onclick="revokePromoCode()" style="background: none; border: none; color: #fa5252; text-decoration: underline; font-size: 0.75rem; font-weight: 700; cursor: pointer; padding: 0;">ANNULER / RÉVOQUER LE CODE</button></div>`;
            
            successEl.innerHTML = successMsg;

            preview.style.display = 'block';
        }

        function showPromoError(msg) {
            const el = document.getElementById('promo-error');
            el.textContent = msg;
            el.style.display = 'block';
        }

        function toggleAdvisoryContent(step) {
            const advisory = document.getElementById('advisoryArea');
            const content2 = document.getElementById('advisoryContentStep2');
            const content3 = document.getElementById('advisoryContentStep3');
            const condGroup = document.getElementById('productConditionGroup');

            // Find root category to check family
            let rootCat = null;
            const catId = document.getElementById('categorie_id').value;
            if (catId && categoriesData[catId]) {
                let curr = categoriesData[catId];
                while (curr && curr.parent_id) {
                    curr = categoriesData[curr.parent_id];
                }
                rootCat = curr;
            }

            const isServiceOrImmo = rootCat && (rootCat.famille === 'Services' || rootCat.famille === 'Immobilier');

            if (advisory) {
                if (step === 2) {
                    advisory.classList.add('active');
                    if (content2) content2.style.display = 'block';
                    if (content3) content3.style.display = 'none';
                } else if (step === 3) {
                    advisory.classList.add('active');
                    if (content2) content2.style.display = 'none';
                    if (content3) content3.style.display = 'block';

                    // Specific Rule: Hide condition if Services or Immobilier
                    if (condGroup) condGroup.style.display = isServiceOrImmo ? 'none' : 'block';
                }
                else {
                    advisory.classList.remove('active');
                }
            }
        }

        function selectStatus(el, val) {
            if (el.classList.contains('disabled')) return;
            document.getElementById('etat_produit').value = val;
            document.querySelectorAll('#step3 .status-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
        }



        var photosInput, imagePreviewContainer, imageUploadArea;

        // Navigation functions
        function nextStep() {
            console.log('nextStep called, currentStep:', currentStep);

            if (!validateCurrentStep()) return false;

            if (currentStep >= totalSteps) {
                document.getElementById('createAnnonceForm').submit();
                return true;
            }

            // Special logic for Step 1 -> 2
            if (currentStep === 1) {
                const name = document.getElementById('product_name').value;
                document.getElementById('summary_product_name').textContent = name;
                const s3Name = document.getElementById('summary_product_name_s3');
                if (s3Name) s3Name.textContent = name;
            }

            // Hide current
            const curEl = document.getElementById('step' + currentStep);
            if (curEl) curEl.classList.remove('active');

            const curProg = document.querySelector(`.progress-step[data-step="${currentStep}"]`);
            if (curProg) {
                curProg.classList.remove('active');
                curProg.classList.add('completed');
            }

            currentStep++;
            document.getElementById('currentStep').value = currentStep;

            // Toggle advisory content
            toggleAdvisoryContent(currentStep);

            // Show next
            const nextEl = document.getElementById('step' + currentStep);
            if (nextEl) nextEl.classList.add('active');

            // Force promo check when reaching step 4
            if (currentStep === 4) {
                const catId = document.getElementById('categorie_id').value;
                if (typeof checkCategoryPromo === 'function') checkCategoryPromo(catId);
            }

            const nextProg = document.querySelector(`.progress-step[data-step="${currentStep}"]`);
            if (nextProg) nextProg.classList.add('active');

            window.scrollTo({ top: 0, behavior: 'smooth' });
            return true;
        }

        function previousStep() {
            if (currentStep <= 1) return;

            document.getElementById('step' + currentStep).classList.remove('active');
            const curProg = document.querySelector(`.progress-step[data-step="${currentStep}"]`);
            if (curProg) curProg.classList.remove('active');

            currentStep--;
            document.getElementById('currentStep').value = currentStep;

            document.getElementById('step' + currentStep).classList.add('active');
            const prevProg = document.querySelector(`.progress-step[data-step="${currentStep}"]`);
            if (prevProg) {
                prevProg.classList.add('active');
                prevProg.classList.remove('completed');
            }

            // Toggle advisory content
            toggleAdvisoryContent(currentStep);

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function validateCurrentStep() {
            if (currentStep === 1) {
                const name = document.getElementById('product_name');
                if (!name.value.trim() || name.value.trim().length < 3) {
                    alert('Veuillez saisir un nom de produit (min 3 caractères).');
                    name.focus();
                    return false;
                }
            } else if (currentStep === 2) {
                const cat = document.getElementById('categorie_id').value;
                if (!cat) { alert('Sélectionnez une catégorie.'); return false; }
            } else if (currentStep === 3) {
                const desc = document.getElementById('description').value.trim();
                const price = document.getElementById('prix').value;
                const qty = document.getElementById('quantite').value;
                if (desc.length < 10) { alert('La description est trop courte.'); return false; }
                if (uploadedImages.length < 1) { alert('Minimum 1 photo requise.'); return false; }
                if (uploadedImages.length > 8) { alert('Maximum 8 photos autorisées.'); return false; }
                if (!price || price <= 0) { alert('Veuillez saisir un prix valide.'); return false; }
                if (!qty || qty < 1) { alert('Veuillez saisir une quantité valide.'); return false; }
            }
            return true;
        }

                // Compression côté navigateur : redimensionne et ré-encode l'image
                // avant l'envoi pour accélérer fortement l'upload (surtout en mobile).
                function compressImage(file) {
                    return new Promise((resolve) => {
                        if (!file.type.startsWith('image/')) { resolve(file); return; }

                        const MAX_DIM = 1280;   // dimension max (px) du plus grand côté
                        const QUALITY = 0.78;   // qualité JPEG

                        const finalize = (source, width, height) => {
                            try {
                                let w = width, h = height;
                                if (w > MAX_DIM || h > MAX_DIM) {
                                    if (w >= h) { h = Math.round(h * MAX_DIM / w); w = MAX_DIM; }
                                    else { w = Math.round(w * MAX_DIM / h); h = MAX_DIM; }
                                }
                                const canvas = document.createElement('canvas');
                                canvas.width = w; canvas.height = h;
                                const ctx = canvas.getContext('2d');
                                // Fond blanc (évite un fond noir pour les PNG transparents)
                                ctx.fillStyle = '#ffffff';
                                ctx.fillRect(0, 0, w, h);
                                ctx.drawImage(source, 0, 0, w, h);
                                canvas.toBlob((blob) => {
                                    // Si la compression n'apporte rien, on garde l'original
                                    if (!blob || blob.size >= file.size) { resolve(file); return; }
                                    const newName = file.name.replace(/\.[^.]+$/, '') + '.jpg';
                                    resolve(new File([blob], newName, { type: 'image/jpeg', lastModified: Date.now() }));
                                }, 'image/jpeg', QUALITY);
                            } catch (e) {
                                resolve(file);
                            }
                        };

                        const fallback = () => {
                            const img = new Image();
                            const url = URL.createObjectURL(file);
                            img.onload = () => { URL.revokeObjectURL(url); finalize(img, img.naturalWidth, img.naturalHeight); };
                            img.onerror = () => { URL.revokeObjectURL(url); resolve(file); };
                            img.src = url;
                        };

                        // createImageBitmap gère l'orientation EXIF (photos prises au téléphone)
                        if (window.createImageBitmap) {
                            createImageBitmap(file, { imageOrientation: 'from-image' })
                                .then(bitmap => finalize(bitmap, bitmap.width, bitmap.height))
                                .catch(fallback);
                        } else {
                            fallback();
                        }
                    });
                }

                // Image Handling
                async function handleFiles(files) {
                    if (uploadedImages.length + files.length > 8) {
                        alert('Vous ne pouvez pas ajouter plus de 8 photos.');
                        return;
                    }
                    for (const file of Array.from(files)) {
                        if (!file.type.startsWith('image/')) continue;

                        let toUpload = file;
                        try { toUpload = await compressImage(file); } catch (e) { toUpload = file; }

                        if (toUpload.size > 5 * 1024 * 1024) {
                            alert('Image trop lourde (max 5Mo) : ' + file.name);
                            continue;
                        }

                        await new Promise((res) => {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                uploadedImages.push({ file: toUpload, preview: e.target.result });
                                renderPhotoGrid();
                                res();
                            };
                            reader.onerror = () => res();
                            reader.readAsDataURL(toUpload);
                        });
                    }
                }

                function renderPhotoGrid() {
                    const grid = document.getElementById('photoGrid');
                    if (!grid) return;

                    // Clear existing previews but keep the trigger
                    const previews = grid.querySelectorAll('.image-preview-item');
                    previews.forEach(p => p.remove());

                    const trigger = document.getElementById('uploadTrigger');

                    uploadedImages.forEach((img, i) => {
                        const div = document.createElement('div');
                        div.className = 'image-preview-item';
                        div.innerHTML = `
                                                    <img src="${img.preview}">
                                                    <button type="button" class="remove-photo-btn" onclick="removeImage(${i})">×</button>
                                                `;
                        grid.insertBefore(div, trigger);
                    });

                    // Keep trigger visible at all times as requested
                    trigger.style.display = 'flex';

                    updateFileInput();
                }

                function setMainImage(i) { renderPhotoGrid(); }
                function removeImage(i) {
                    uploadedImages.splice(i, 1);
                    renderPhotoGrid();
                }


                function updateFileInput() {
                    const photosInput = document.getElementById('photosInput');
                    if (!photosInput || typeof DataTransfer === 'undefined') return;
                    const dt = new DataTransfer();
                    uploadedImages.forEach(img => dt.items.add(img.file));
                    photosInput.files = dt.files;

                    // Update photo counter
                    const countEl = document.getElementById('photoCountDisplay');
                    if (countEl) countEl.textContent = uploadedImages.length + ' sur 8';
                }

                // Initialization
                document.addEventListener('DOMContentLoaded', function () {
                    photosInput = document.getElementById('photosInput');
                    imagePreviewContainer = document.getElementById('imagePreviewContainer');
                    imageUploadArea = document.getElementById('imageUploadArea');

                    if (imageUploadArea) {
                        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eName => {
                            imageUploadArea.addEventListener(eName, e => { e.preventDefault(); e.stopPropagation(); });
                        });
                        imageUploadArea.addEventListener('drop', e => handleFiles(e.dataTransfer.files));
                        imageUploadArea.addEventListener('click', () => photosInput.click());
                    }

                    const nameInput = document.getElementById('product_name');
                    if (nameInput) {
                        nameInput.addEventListener('input', function () {
                            const charCount = document.getElementById('charCount');
                            if (charCount) charCount.textContent = this.value.length;
                        });
                    }

                    const annonceForm = document.getElementById('createAnnonceForm');
                    annonceForm.addEventListener('submit', function (e) {
                        if (currentStep < totalSteps) {
                            e.preventDefault();
                            nextStep();
                            return;
                        }

                        // Validation de l'étape 4 avant l'envoi final
                        const statut = document.querySelector('input[name="statut"]:checked').value;
                        if (statut === 'publiee') {
                            const totalCost = parseInt(document.getElementById('total-cost-display').textContent) || 0;
                            const balance = parseInt(document.getElementById('user-credit-balance').textContent) || 0;
                            if (totalCost > balance) {
                                e.preventDefault();
                                alert('Solde de crédits insuffisant pour les options choisies.');
                                return;
                            }
                        }

                        // Verrouiller le bouton (anti double-envoi) + overlay
                        const btn = document.getElementById('submitButton');
                        if (btn) {
                            btn.disabled = true;
                            btn.style.opacity = '0.7';
                            btn.style.cursor = 'wait';
                            btn.textContent = 'Enregistrement en cours…';
                        }
                        const overlay = document.getElementById('savingOverlay');
                        if (overlay) overlay.classList.add('active');

                        // Envoi en AJAX avec barre de progression (sinon envoi classique en repli)
                        if (window.FormData && window.XMLHttpRequest && 'upload' in new XMLHttpRequest()) {
                            e.preventDefault();
                            submitWithProgress(annonceForm);
                        }
                    });

                    function submitWithProgress(form) {
                        const bar = document.getElementById('savingProgressBar');
                        const pctEl = document.getElementById('savingProgressPct');
                        const titleEl = document.getElementById('savingTitle');

                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', form.action, true);
                        // Pas d'en-tête X-Requested-With : on veut que le serveur réponde
                        // en HTML (redirection succès / page avec erreurs), pas en JSON.

                        xhr.upload.addEventListener('progress', function (ev) {
                            if (!ev.lengthComputable) return;
                            const pct = Math.round((ev.loaded / ev.total) * 100);
                            if (bar) bar.style.width = pct + '%';
                            if (pctEl) pctEl.textContent = pct + '%';
                            if (pct >= 100) {
                                if (titleEl) titleEl.textContent = 'Finalisation en cours…';
                                if (pctEl) pctEl.textContent = 'Traitement de vos photos';
                            }
                        });

                        xhr.onload = function () {
                            const url = xhr.responseURL || form.action;
                            // Succès -> page "mes annonces" : navigation propre
                            if (/mes-annonces/.test(url)) {
                                window.location.href = url;
                                return;
                            }
                            // Sinon (erreurs de validation) : réafficher la page renvoyée
                            try {
                                document.open();
                                document.write(xhr.responseText);
                                document.close();
                                history.replaceState(null, '', url);
                            } catch (err) {
                                // En dernier recours, on renvoie le formulaire normalement
                                form.submit();
                            }
                        };

                        xhr.onerror = function () {
                            const overlay = document.getElementById('savingOverlay');
                            if (overlay) overlay.classList.remove('active');
                            const btn = document.getElementById('submitButton');
                            if (btn) {
                                btn.disabled = false;
                                btn.style.opacity = '1';
                                btn.style.cursor = 'pointer';
                                btn.textContent = "Enregistrer l'annonce";
                            }
                            alert('Une erreur réseau est survenue. Vérifiez votre connexion et réessayez.');
                        };

                        xhr.send(new FormData(form));
                    }

                    // --- Credit Services Logic ---
                    const serviceCheckboxes = document.querySelectorAll('.service-checkbox');
                    const statutRadios = document.querySelectorAll('input[name="statut"]');
                    const totalCostDisplay = document.getElementById('total-cost-display');
                    const warningDisplay = document.getElementById('insufficient-credits-warning');
                    const submitButton = document.getElementById('submitButton');
                    const userBalance = parseInt(document.getElementById('user-credit-balance').textContent) || 0;
                    
                    // Add video upload container dynamically if 'video' service is selected
                    const videoServiceCheckbox = document.querySelector('.service-checkbox[value="video"]');
                    if (videoServiceCheckbox) {
                        const videoUploadHtml = `
                            <div id="video-upload-container" style="display: none; padding: 1rem; border: 1px dashed #ef6c00; border-radius: 8px; background: #fff5e6; margin-top: 10px;">
                                <label style="font-weight: 700; display: block; margin-bottom: 0.5rem; color: #ef6c00;">🎥 Télécharger votre vidéo</label>
                                <input type="file" name="video" accept="video/mp4,video/quicktime,video/webm" class="form-input" style="background: white;">
                                <small style="color: #666; display: block; margin-top: 5px;">Format MP4, MOV. Max 50Mo. La vidéo doit être cochée lors de la publication pour être validée.</small>
                            </div>
                        `;
                        videoServiceCheckbox.closest('.service-card').insertAdjacentHTML('afterend', videoUploadHtml);
                        
                        videoServiceCheckbox.addEventListener('change', function() {
                            document.getElementById('video-upload-container').style.display = this.checked ? 'block' : 'none';
                        });
                    }

                    function calculateTotal() {
                        const statut = document.querySelector('input[name="statut"]:checked').value;
                        let total = 0;

                        if (statut === 'publiee') {
                            serviceCheckboxes.forEach(cb => {
                                if (cb.checked) {
                                    total += parseInt(cb.getAttribute('data-cost')) || 0;
                                }
                            });
                        }

                        totalCostDisplay.textContent = total;

                        if (total > userBalance && statut === 'publiee') {
                            warningDisplay.style.display = 'block';
                            submitButton.disabled = true;
                            submitButton.style.opacity = '0.5';
                        } else {
                            warningDisplay.style.display = 'none';
                            submitButton.disabled = false;
                            submitButton.style.opacity = '1';
                        }
                    }

                    serviceCheckboxes.forEach(cb => cb.addEventListener('change', calculateTotal));
                    statutRadios.forEach(radio => radio.addEventListener('change', calculateTotal));
                    
                    // Initial calculation
                    calculateTotal();
                });
            </script>

@endsection @push('scripts')
    <script>let variantCount = 0;

        function addVariant() {
            const container = document.getElementById('variantsContainer');
            const variantId = variantCount++;

            const variantHtml = ` <div class="variant-item" id="variant_${variantId}" style="background: #fdf2f2; padding: 1rem; border-radius: 8px; border: 1px solid #ffcccc; position: relative;"><button type="button" onclick="removeVariant(${variantId})" style="position: absolute; top: 0.5rem; right: 0.5rem; background: none; border: none; font-size: 1.25rem; color: #bf0000; cursor: pointer;">&times;
                                                                                                    </button><div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 0.5rem;"><div><label style="font-size: 0.8rem; font-weight: bold; display: block; margin-bottom: 2px;">Type</label><select name="variantes[${variantId}][type]" class="form-input" style="padding: 0.5rem;"><option value="taille">Taille</option><option value="couleur">Couleur</option><option value="matiere">Matière</option><option value="autre">Autre</option></select></div><div><label style="font-size: 0.8rem; font-weight: bold; display: block; margin-bottom: 2px;">Valeur</label><input type="text" name="variantes[${variantId}][valeur]" class="form-input" style="padding: 0.5rem;" placeholder="Ex: XL, Rouge..."></div></div><div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;"><div><label style="font-size: 0.8rem; font-weight: bold; display: block; margin-bottom: 2px;">Stock</label><input type="number" name="variantes[${variantId}][stock]" class="form-input" style="padding: 0.5rem;" value="1" min="0"></div><div><label style="font-size: 0.8rem; font-weight: bold; display: block; margin-bottom: 2px;">Prix sup. (€)</label><input type="number" name="variantes[${variantId}][prix_supplementaire]" class="form-input" style="padding: 0.5rem;" value="0" step="0.01" min="0"></div></div></div>`;

            container.insertAdjacentHTML('beforeend', variantHtml);
        }

        function removeVariant(id) {
            const el = document.getElementById('variant_' + id);
            if (el) el.remove();
        }

</script>@endpush