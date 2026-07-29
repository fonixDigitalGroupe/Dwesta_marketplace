@extends('layouts.app')

@section('title', 'Mon compte - Karnou')

@push('styles')
    <style>
        /* Styles spécifiques à la page compte */

        .account-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .account-header h1 {
            font-family: 'Outfit', 'Inter', sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: #1a1a1a;
            letter-spacing: -0.01em;
            margin: 0;
        }

        /* Jumia Cards Styles */
        .jumia-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .jumia-card {
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .jumia-card-header {
            padding: 0.85rem 1.15rem;
            border-bottom: 1px solid #f2f2f2;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .jumia-card-header h2 {
            font-family: 'Outfit', 'Inter', sans-serif;
            font-size: 0.82rem;
            font-weight: 700;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            margin: 0;
        }

        .jumia-card-body {
            padding: 1.15rem;
            flex: 1;
        }

        .jumia-card-body p {
            margin: 0 0 0.5rem 0;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            color: #374151;
            line-height: 1.5;
        }

        .jumia-card-body .top-text {
            font-family: 'Outfit', 'Inter', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 0.35rem;
        }

        .jumia-card-body .sub-text {
            color: #9ca3af;
            font-size: 0.85rem;
        }

        .jumia-link {
            color: #f68b1e;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            margin-top: 1rem;
            display: inline-block;
        }

        .jumia-link:hover {
            text-decoration: underline;
        }

        .edit-icon {
            color: #004aad;
            font-size: 1.1rem;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .jumia-grid {
                grid-template-columns: 1fr;
            }
        }

        .logout-link {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #333;
            text-decoration: underline;
            font-size: 0.9rem;
        }

        .club-r-section {
            display: flex;
            border-top: 1px solid #eee;
            padding: 2rem 0;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .club-r-left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 200px;
        }

        .club-r-logo {
            font-size: 2.5rem;
            font-weight: 800;
        }

        .club-r-logo span {
            color: #bf0000;
        }

        .club-r-center {
            flex: 1;
        }

        .club-r-center h2 {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .club-r-benefits {
            list-style: none;
            margin-bottom: 1rem;
        }

        .club-r-benefits li {
            position: relative;
            padding-left: 1.2rem;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .club-r-benefits li::before {
            content: "•";
            position: absolute;
            left: 0;
            color: #bf0000;
            font-weight: bold;
        }

        .club-r-link {
            color: #0099ff;
            text-decoration: none;
            font-weight: 500;
        }

        .club-r-right {
            width: 320px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1rem;
            position: relative;
        }

        .club-r-right h3 {
            font-size: 1rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .club-r-right p {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 1rem;
        }

        .partner-logos {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .partner-logos img {
            height: 20px;
            opacity: 0.8;
        }

        .arrow-right {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .security-alert {
            background-color: #fff9f0;
            border: 1px solid #ffcc80;
            padding: 0.5rem 1rem;
            display: flex;
            gap: 10px;
            align-items: center;
            margin-bottom: 1.5rem;
            border-radius: 4px;
        }

        .security-alert svg {
            color: #ff9800;
            flex-shrink: 0;
        }

        .security-alert p {
            font-size: 0.9rem;
            color: #333;
            line-height: 1.4;
            margin: 0;
        }
        .security-alert a {
            color: #0099ff;
            text-decoration: underline;
        }

        .profile-completion-alert {
            background-color: #fff9f0;
            border: 1px solid #ffcc80;
            padding: 1rem;
            display: flex;
            gap: 15px;
            align-items: center;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            color: #333;
        }

        .profile-completion-alert i {
            font-size: 1.5rem;
            color: #f68b1e;
        }

        .profile-completion-alert .alert-content {
            flex: 1;
        }

        .profile-completion-alert h4 {
            margin: 0 0 5px 0;
            font-size: 1rem;
            font-weight: 700;
        }

        .profile-completion-alert p {
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .profile-completion-alert .btn-complete {
            background: #f68b1e;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            white-space: nowrap;
            transition: background 0.2s;
        }

        .profile-completion-alert .btn-complete:hover {
            background: #e07b10;
        }

        @media (max-width: 768px) {
            /* Sur mobile, la page Mon compte n'affiche que le menu (comme l'app)...
               sauf en mode aperçu (?vue=apercu) où l'on montre le contenu du compte. */
            .dashboard-container > .main-content {
                display: none !important;
            }
            .dashboard-container > .main-content.show-overview {
                display: block !important;
            }

            .account-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .profile-completion-alert {
                flex-direction: column;
                text-align: center;
                gap: 12px;
                padding: 1.25rem;
            }

            .profile-completion-alert i {
                font-size: 2rem;
            }

            .profile-completion-alert .btn-complete {
                width: 100%;
                text-align: center;
            }

            .club-r-section {
                flex-direction: column;
                padding: 1.5rem 0;
                gap: 1.5rem;
            }

            .club-r-left, .club-r-right {
                width: 100%;
            }

            .survey-section {
                padding: 1.5rem 1rem;
            }

            .score-buttons {
                flex-wrap: wrap;
                justify-content: center;
            }

            .dashboard-columns-grid {
                grid-template-columns: 1fr;
            }
        }

        .survey-section {
            background: #fcfcfc;
            padding: 2rem;
            margin: 0 -1rem;
        }

        .survey-section h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .survey-subtext {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 1.5rem;
        }

        .score-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 2rem;
        }

        .score-btn {
            width: 40px;
            height: 40px;
            border: 1px solid #ddd;
            background: #fff;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .score-btn:hover {
            border-color: #0099ff;
        }

        .score-btn.active {
            border-color: #0099ff;
            border-width: 2px;
            color: #0099ff;
            font-weight: bold;
        }

        .btn-send {
            background: #000;
            color: #fff;
            padding: 0.5rem 2.5rem;
            border-radius: 6px;
            border: none;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .referral-banner {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2rem 0;
        }

        .referral-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .referral-promo-badge {
            background: #bf0000;
            color: #fff;
            font-size: 0.75rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 2px;
            text-transform: uppercase;
        }

        .referral-text {
            font-size: 1rem;
            color: #333;
        }

        .referral-text b {
            color: #bf0000;
        }

        .referral-link {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        .dashboard-columns-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-top: 2rem;
            align-items: flex-start;
        }

        .column-stack {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .karnou-card {
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            background: #fff;
        }

        .karnou-card-header {
            background: #f8f8f8;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .karnou-card-header h2 {
            font-size: 1rem;
            font-weight: 800;
            color: #333;
            margin: 0;
        }

        .karnou-card-header svg, .karnou-card-header span.icon {
            font-size: 1.2rem;
        }

        .karnou-card-body {
            padding: 1.25rem;
        }

        .karnou-card-body p {
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .karnou-list {
            list-style: none;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .karnou-list li {
            position: relative;
            padding-left: 1.5rem;
            font-size: 0.85rem;
            color: #333;
            margin-bottom: 0.6rem;
            line-height: 1.3;
        }

        .karnou-list li::before {
            content: "»";
            position: absolute;
            left: 0;
            color: #0076ad;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .karnou-list li b {
            text-decoration: underline;
        }

        .karnou-card-btn {
            display: block;
            width: 100%;
            background: #000;
            color: #fff;
            text-align: center;
            padding: 0.5rem;
            border-radius: 4px;
            font-weight: 800;
            text-decoration: none;
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            border: none;
            cursor: pointer;
        }

        .karnou-card-links {
            border-top: 1px dotted #ccc;
            padding-top: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .karnou-card-links a {
            font-size: 0.85rem;
            color: #0076ad;
            text-decoration: underline;
        }

        .sub-card-links {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .sub-card-link-item {
            font-size: 0.9rem;
            color: #0076ad;
            text-decoration: underline;
        }

        .sub-card-text {
            font-size: 0.85rem;
            color: #666;
            margin-top: 0.2rem;
            line-height: 1.4;
        }

        .karnou-referral-mini {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            color: #333;
            margin-top: 1rem;
        }

        .karnou-referral-mini:hover {
            background: #fcfcfc;
        }

        .karnou-referral-mini img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .orange-icon { color: #ff9800; }
        .blue-icon { color: #0076ad; }
        .red-icon { color: #bf0000; }
        .yellow-icon { color: #ffc107; }
        .user-icon { color: #e91e63; }
        .finance-icon { color: #607d8b; }
        .comm-icon { color: #673ab7; }

    </style>
@endpush

@section('content')

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <main class="main-content {{ request()->filled('vue') ? 'show-overview' : '' }}">
            <div class="account-header">
                <h1>Votre compte</h1>
            </div>

            @php $u = auth()->user(); @endphp

            <div class="jumia-grid">
                <!-- Informations personnelles -->
                <div class="jumia-card">
                    <div class="jumia-card-header">
                        <h2>Informations personnelles</h2>
                    </div>
                    <div class="jumia-card-body">
                        <p class="top-text">{{ $u->prenom }} {{ $u->nom }}</p>
                        <p class="sub-text">{{ $u->email }}</p>
                    </div>
                </div>

                <!-- Adresses -->
                <div class="jumia-card">
                    <div class="jumia-card-header">
                        <h2>Adresses</h2>
                        <a href="{{ route('profile.show') }}" class="edit-icon" style="color: #f68b1e;">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    </div>
                    <div class="jumia-card-body">
                        <p class="top-text">Adresse par défaut :</p>
                        @if($u->adresse)
                            <p class="sub-text">{{ $u->prenom }} {{ $u->nom }}</p>
                            @if($u->ville)<p class="sub-text">{{ $u->ville }}</p>@endif
                            <p class="sub-text">{{ $u->adresse }}</p>
                            <p class="sub-text">{{ $u->ville }}{{ $u->region ? ', ' . $u->region : '' }}</p>
                            @if($u->telephone)<p class="sub-text">{{ $u->telephone }}</p>@endif
                        @else
                            <p class="sub-text">Aucune adresse enregistrée.</p>
                        @endif
                    </div>
                </div>

                <!-- Préférences de communication -->
                <div class="jumia-card">
                    <div class="jumia-card-header">
                        <h2>Préférences de communication</h2>
                    </div>
                    <div class="jumia-card-body">
                        <p class="sub-text">Gérez vos communications par e-mail pour rester informé des dernières nouvelles et offres.</p>
                        <a href="{{ route('profile.show') }}" class="jumia-link">Modifier les préférences de communication</a>
                    </div>
                </div>
            </div>

        </main>
    </div>
@endsection

