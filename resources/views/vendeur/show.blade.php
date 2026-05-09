@extends('layouts.app')

@section('title', 'Mon compte vendeur - Mady Market')

@push('styles')
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Rakuten Style Forms & Dashboard */
        .rakuten-content-container {
            max-width: 800px;
            padding: 1rem 0;
            text-align: left;
        }

        .rakuten-title {
            font-size: 1rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            margin-top: 2rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .rakuten-field-group {
            margin-bottom: 1rem;
            max-width: 450px;
        }

        .rakuten-field {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 0.4rem 0.75rem;
            background: #fff;
            transition: border-color 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .rakuten-label {
            display: block;
            font-size: 0.7rem;
            color: #888;
            margin-bottom: 0px;
            line-height: 1;
        }

        .rakuten-value {
            font-size: 0.95rem;
            color: #333;
            font-weight: 500;
            margin-top: 0.2rem;
        }

        .btn-rakuten {
            background: #000;
            color: #fff;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-weight: 700;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
            transition: opacity 0.2s;
        }

        .btn-rakuten:hover {
            opacity: 0.85;
            color: #fff;
        }

        .btn-rakuten-outline {
            background: #fff;
            color: #333;
            border: 1px solid #ccc;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .btn-rakuten-outline:hover {
            background: #f9f9f9;
            border-color: #999;
        }

        /* Status Badges matched to Rakuten colors */
        .badge {
            padding: 0.3rem 0.8rem;
            border-radius: 2px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-pending { background: #fff8e1; color: #f57f17; border: 1px solid #ffe082; }
        .badge-verified { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
        .badge-rejected { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .content-header h1 {
            font-size: 1.5rem;
            color: #333;
            font-weight: 700;
            margin: 0;
        }

        .alert-box {
            background: #fff6f6;
            border: 1px solid #ff0000;
            border-radius: 4px;
            padding: 1rem;
            color: #333;
            margin-bottom: 1.5rem;
            max-width: 800px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            max-width: 800px;
        }

        /* Redesign Rakuten Style (Vertical Sidebar) */
        .vertical-actions-card {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            max-width: 350px; /* Plus compact comme l'image */
            margin-top: 2rem;
        }

        .actions-card-header {
            padding: 1rem;
            border-bottom: 1px solid #eeeeee;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #ffffff;
        }

        .actions-card-header i, .actions-card-header svg {
            color: #f7931e; /* Orange Rakuten style */
        }

        .actions-card-header h2 {
            font-size: 1.15rem;
            font-weight: 800;
            margin: 0;
            color: #333;
        }

        .actions-card-body {
            padding: 1.25rem 1rem;
            background: #f9f9f9; /* Gris très léger de fond */
        }

        .actions-card-body p {
            font-size: 0.9rem;
            color: #444;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .rakuten-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .rakuten-list-item {
            display: flex;
            align-items: baseline;
            gap: 0.5rem;
            text-decoration: none;
            color: #333;
            font-size: 0.95rem;
            line-height: 1.4;
            transition: color 0.2s;
        }

        .rakuten-list-item::before {
            content: '»';
            color: #000000; /* Flèches en noir */
            font-weight: 800;
            font-size: 1.1rem;
        }

        .rakuten-list-item:hover {
            color: #333; /* Pas de rouge au survol */
            text-decoration: underline;
        }

        .rakuten-list-item strong {
            font-weight: 700;
        }

        @media (max-width: 900px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    <div class="dashboard-container">
        @include('partials.profile-sidebar')

        <!-- Main Content -->
        <main class="main-content">
            
            <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 0.5rem; margin-bottom: 1.5rem; border-bottom: 1px solid #eee;">
                <h1 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Mon compte vendeur</h1>
            </div>

            <div class="rakuten-content-container">
                <!-- Profil Incomplet (Auto-créé) -->
                @if(!auth()->user()->estVendeurOfficiel())
                    <div class="alert-box" style="background: #fff8e1; border-color: #ffe082;">
                        <div style="display: flex; align-items: flex-start; gap: 1rem;">
                            <svg style="width: 24px; height: 24px; flex-shrink: 0; color: #f57f17;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 style="margin-bottom: 0.5rem; font-size: 1rem; font-weight: 700; color: #f57f17;">Profil de vendeur incomplet</h3>
                                <p style="font-size: 0.9rem; margin-bottom: 0.75rem; color: #666;">
                                    Votre compte vendeur a été créé automatiquement lors de votre dépôt d'annonce. 
                                    Pour devenir un <strong>vendeur vérifié</strong>, accéder aux abonnements et assurer la sécurité de vos transactions, veuillez compléter vos informations officielles.
                                </p>
                                <a href="{{ route('vendeur.create') }}" class="btn-rakuten" style="background: #f57f17; border: none;">Compléter mes informations</a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Alertes d'expiration -->
                @if(isset($alertes) && count($alertes) > 0)
                    @foreach($alertes as $alerte)
                        <div class="alert-box">
                            <div style="display: flex; align-items: flex-start; gap: 1rem;">
                                <svg style="width: 20px; height: 20px; flex-shrink: 0; color: #ff0000;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <div>
                                    <h3 style="margin-bottom: 0.5rem; font-size: 1rem; font-weight: 700;">{{ $alerte['titre'] }}</h3>
                                    <p style="font-size: 0.9rem; margin-bottom: 0.75rem; color: #666;">
                                        @if($alerte['est_expire'])
                                            <strong style="color: #ff0000;">Document expiré !</strong> Veuillez le mettre à jour pour continuer à vendre.
                                        @else
                                            Votre document expire dans <strong>{{ $alerte['jours_restants'] }} jours</strong>.
                                        @endif
                                    </p>
                                    <a href="{{ route('vendeur.create') }}" class="btn-rakuten" style="padding: 0.4rem 1rem; font-size: 0.8rem;">Mettre à jour</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                <!-- Statut de vérification -->
                <h2 class="rakuten-title">Statut de vérification</h2>
                
                <div style="margin-bottom: 2rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                        <span style="font-weight: 600; color: #333;">État actuel :</span>
                        @if(!$vendeur->estOfficiel())
                            <span class="badge badge-pending" style="background: #fff3e0; color: #e65100; border-color: #ffcc80;">Profil incomplet</span>
                        @elseif($vendeur->statut_verification === 'en_attente')
                            <span class="badge badge-pending">En attente de vérification</span>
                        @elseif($vendeur->statut_verification === 'verifie')
                            <span class="badge badge-verified">✓ Compte vérifié</span>
                        @elseif($vendeur->statut_verification === 'rejete')
                            <span class="badge badge-rejected">Rejeté</span>
                        @endif
                    </div>

                    @if($vendeur->statut_verification === 'rejete' && $vendeur->raison_rejet)
                        <div style="background: #fff6f6; border: 1px solid #ff0000; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; color: #d32f2f; font-size: 0.9rem;">
                            <strong>Motif du rejet :</strong> {{ $vendeur->raison_rejet }}
                        </div>
                    @endif

                    <p style="color: #666; font-size: 0.9rem; line-height: 1.6; max-width: 600px;">
                        @if($vendeur->statut_verification === 'verifie')
                            Félicitations ! Votre identité a été confirmée. Vous pouvez désormais publier des annonces et effectuer des transactions en toute sécurité sur Mady Market.
                        @elseif($vendeur->statut_verification === 'en_attente')
                            Nos administrateurs examinent actuellement vos documents. Ce processus prend généralement moins de 48 heures ouvrables. Vous recevrez une notification dès que la vérification sera effectuée.
                        @else
                            Votre demande de vérification a été rejetée. Veuillez corriger les informations nécessaires et soumettre à nouveau vos documents.
                        @endif
                    </p>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 2.5rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem; margin-bottom: 1.5rem;">
                    <h2 style="font-size: 1.1rem; font-weight: 600; color: #333; margin: 0;">Identité & Documents KYC</h2>
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        @if($vendeur->estParticulier())
                            <a href="{{ route('vendeur.create') }}" style="color: #666; font-size: 0.8rem; text-decoration: underline;">Passer en compte Pro</a>
                        @endif
                        
                        <a href="{{ route('vendeur.create') }}" style="color: #004aad; font-size: 0.9rem; display: flex; align-items: center; gap: 5px; text-decoration: none; font-weight: 600;">
                            <i class="fas fa-edit"></i>
                            Modifier
                        </a>
                    </div>
                </div>

                @if($vendeur->estParticulier() && $vendeur->particulier)
                    <div class="info-grid">
                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Type de document</label>
                                <div class="rakuten-value" style="{{ $vendeur->particulier->numero_document === 'A_COMPLETER' ? 'color: #bf0000; font-style: italic;' : '' }}">
                                    @if($vendeur->particulier->numero_document === 'A_COMPLETER')
                                        À compléter
                                    @else
                                        @if($vendeur->particulier->type_document === 'cni') CNI (Identité)
                                        @elseif($vendeur->particulier->type_document === 'passeport') Passeport
                                        @elseif($vendeur->particulier->type_document === 'recepisse') Récépissé
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Numéro du document</label>
                                <div class="rakuten-value" style="{{ $vendeur->particulier->numero_document === 'A_COMPLETER' ? 'color: #bf0000; font-style: italic;' : '' }}">
                                    {{ $vendeur->particulier->numero_document === 'A_COMPLETER' ? 'À compléter' : $vendeur->particulier->numero_document }}
                                </div>
                            </div>
                        </div>
                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Date d'émission</label>
                                <div class="rakuten-value" style="{{ !$vendeur->particulier->date_emission_document ? 'color: #bf0000; font-style: italic;' : '' }}">
                                    {{ $vendeur->particulier->date_emission_document ? $vendeur->particulier->date_emission_document->format('d/m/Y') : 'À compléter' }}
                                </div>
                            </div>
                        </div>
                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Date d'expiration</label>
                                <div class="rakuten-value" style="{{ (!$vendeur->particulier->date_expiration_document || $vendeur->particulier->estExpire()) ? 'color: #bf0000;' : '' }}">
                                    @if(!$vendeur->particulier->date_expiration_document)
                                        <span style="font-style: italic;">À compléter</span>
                                    @else
                                        {{ $vendeur->particulier->date_expiration_document->format('d/m/Y') }}
                                        @if($vendeur->particulier->estExpire()) <strong>(Expiré)</strong> @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($vendeur->estProfessionnel() && $vendeur->professionnel)
                    <div style="color: #f68b1e; font-weight: 700; font-size: 0.95rem; margin-bottom: 1.5rem;">
                        Vous avez un compte vendeur professionnel
                    </div>
                    <div class="info-grid">
                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Nom de l'entreprise</label>
                                <div class="rakuten-value">{{ $vendeur->professionnel->nom_entreprise }}</div>
                            </div>
                        </div>
                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Registre de commerce</label>
                                <div class="rakuten-value">{{ $vendeur->professionnel->numero_registre_commerce ?? 'Non renseigné' }}</div>
                            </div>
                        </div>
                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">NIF</label>
                                <div class="rakuten-value">{{ $vendeur->professionnel->numero_identification_fiscale ?? 'Non renseigné' }}</div>
                            </div>
                        </div>
                        <div class="rakuten-field-group">
                            <div class="rakuten-field">
                                <label class="rakuten-label">Email entreprise</label>
                                <div class="rakuten-value">{{ $vendeur->professionnel->email_entreprise ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Centre d'Actions Vendeur (Version Rakuten Style) -->
                @if($vendeur->estVerifie())
                    <div class="vertical-actions-card">
                        <div class="actions-card-header">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 8L12 3L3 8V16L12 21L21 16V8Z" stroke="#f7931e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 8L12 13L21 8" stroke="#f7931e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 13V21" stroke="#f7931e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h2>Gérer mes ventes ?</h2>
                        </div>
                        <div class="actions-card-body">
                            <ul class="rakuten-list">
                                <li>
                                    <a href="{{ route('annonces.create') }}" class="rakuten-list-item">
                                        <strong>Vendre</strong> un produit
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('vendeur.mes-annonces') }}" class="rakuten-list-item">
                                        Gérer <strong>mes annonces</strong>
                                    </a>
                                </li>
                                @if($vendeur->aAccesPagePro())
                                <li>
                                    <a href="{{ route('page-pro.edit') }}" class="rakuten-list-item">
                                        Gérer ma <strong>Boutique PRO</strong>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
            </div>

        </main>
    </div>
@endsection
