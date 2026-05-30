@extends('layouts.app')

@section('title', 'Compte vendeur - Karnou')

@push('styles')
    <style>
        /* Styles adaptés du tableau de bord Mon Compte */
        .account-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .account-header h1 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
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
            border-radius: 4px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .jumia-card-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .jumia-card-header h2 {
            font-size: 0.85rem;
            font-weight: 600;
            color: #333;
            text-transform: uppercase;
            margin: 0;
        }

        .jumia-card-body {
            padding: 1rem;
            flex: 1;
        }

        .jumia-card-body p {
            margin: 0 0 0.5rem 0;
            font-size: 0.9rem;
            color: #333;
            line-height: 1.4;
        }

        .jumia-card-body .top-text {
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .jumia-card-body .sub-text {
            color: #8e8e93;
            font-size: 0.85rem;
        }

        .edit-icon {
            color: #004aad;
            font-size: 1.1rem;
            text-decoration: none;
        }

        /* Status Badges */
        .badge {
            padding: 0.3rem 0.8rem;
            border-radius: 2px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-block;
        }

        .badge-verified {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .badge-pending {
            background: #fff3e0;
            color: #e65100;
            border: 1px solid #ffe0b2;
        }

        .badge-rejected {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        /* Progress Bar Styles */
        .usage-container {
            margin-top: 1rem;
        }

        .progress-bar-bg {
            height: 12px;
            background: #f0f0f0;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid #eee;
            margin: 0.5rem 0;
        }

        .progress-bar-fill {
            height: 100%;
            transition: width 0.5s ease;
        }

        .alert-box {
            background: #fff;
            border: 1px solid #e0e0e0;
            padding: 1.25rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            display: flex;
            gap: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        @media (max-width: 768px) {
            .jumia-grid {
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
            
            @if($vendeur->estVerifie() && $vendeur->estProfessionnel() && !$vendeur->aForfaitPayantActif())
                <div class="alert-box" style="border: 1px solid rgba(46, 125, 50, 0.2); background-color: #fcfdfc; color: #2e7d32; display: block; padding: 1.25rem; margin-bottom: 2rem;">
                    <div style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fas fa-circle-info" style="font-size: 1.25rem; margin-top: 3px; color: #2e7d32;"></i>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; font-size: 1rem; margin-bottom: 0.5rem;">Dernière étape : Choisissez votre forfait pour commencer</div>
                            <p style="color: #444; font-size: 0.95rem; margin-bottom: 1.25rem;">
                                Pour commencer à bénéficier de vos avantages Pro (annonces illimitées, page pro, statistiques détaillées), veuillez activer un forfait Basic ou Expert.
                            </p>
                            <a href="{{ route('abonnements.index') }}" style="display: inline-block; background: #2e7d32; color: #fff; padding: 0.6rem 1.5rem; border-radius: 4px; text-decoration: none; font-weight: 700; font-size: 0.85rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">Choisir mon forfait maintenant</a>
                        </div>
                    </div>
                </div>
            @endif

            <div class="account-header">
                <h1>État du compte vendeur</h1>
            </div>

            @if(session('success'))
                <div class="alert-box" style="border: 1px solid #c8e6c9; background-color: #f1fcf1; color: #2e7d32; position: relative;">
                    <i class="fas fa-circle-check" style="font-size: 1.25rem;"></i>
                    <div style="font-weight: 500; padding-right: 25px;">
                        {{ session('success') }}
                    </div>
                    <button type="button" onclick="this.parentElement.style.display='none'" style="position: absolute; right: 10px; top: 10px; background: none; border: none; color: #2e7d32; cursor: pointer; font-size: 1.1rem; opacity: 0.7;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error_banner'))
                <div class="alert-box" style="background-color: #fff5f5; border: 1px solid #ffcdd2; position: relative;">
                    <i class="fas fa-circle-exclamation" style="color: #bf0000; font-size: 1.25rem;"></i>
                    <div style="color: #c53030; font-weight: 500; padding-right: 25px;">
                        {{ session('error_banner') }}
                    </div>
                    <button type="button" onclick="this.parentElement.style.display='none'" style="position: absolute; right: 10px; top: 10px; background: none; border: none; color: #c53030; cursor: pointer; font-size: 1.1rem; opacity: 0.7;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if($vendeur->statut_verification === 'rejete' && $vendeur->raison_rejet)
                <div class="alert-box" style="border: 1px solid #ffcdd2; background-color: #fff5f5; color: #c53030; display: block;">
                    <div style="display: flex; gap: 1rem; align-items: flex-start; margin-bottom: 0.5rem;">
                        <i class="fas fa-circle-xmark" style="font-size: 1.25rem; margin-top: 3px;"></i>
                        <div style="font-weight: 700; font-size: 1rem;">Votre demande de compte vendeur n'a pas pu être approuvée</div>
                    </div>
                    <div style="margin-left: 2.25rem; font-size: 0.95rem; line-height: 1.5;">
                        <p style="margin-bottom: 0.75rem;">Motif : {{ $vendeur->raison_rejet }}</p>
                        <p style="font-style: italic;">Veuillez vérifier que les informations fournies sont correctes, puis soumettez à nouveau votre dossier.</p>
                        <a href="{{ route('vendeur.create', ['update' => 1]) }}" style="display: inline-block; background: #c53030; color: #fff; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-weight: 700; font-size: 0.85rem; margin-top: 10px;">Réessayer et corriger mes documents</a>
                    </div>
                </div>
            @endif

            <!-- Profil Incomplet (Auto-créé) -->
            @if(!auth()->user()->estVendeurOfficiel())
                <div class="alert-box">
                    <i class="fas fa-exclamation-triangle" style="color: #f68b1e; font-size: 1.25rem;"></i>
                    <div>
                        <h3 style="margin-bottom: 0.5rem; font-size: 1rem; font-weight: 700; color: #333;">Profil de vendeur incomplet</h3>
                        <p style="font-size: 0.9rem; margin-bottom: 0.75rem; color: #666;">
                            Votre compte vendeur a été créé automatiquement. Pour devenir un <strong>vendeur vérifié</strong>, accéder aux abonnements et assurer la sécurité de vos transactions, veuillez compléter vos informations.
                        </p>
                        <a href="{{ route('vendeur.create', ['update' => 1]) }}" style="display: inline-block; background: #f68b1e; color: #fff; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; font-weight: 700; font-size: 0.85rem;">Compléter mon profil</a>
                    </div>
                </div>
            @endif

            <!-- Alertes d'expiration -->
            @if(isset($alertes) && count($alertes) > 0)
                @foreach($alertes as $alerte)
                    <div class="alert-box">
                        <i class="fas fa-calendar-times" style="color: #bf0000; font-size: 1.25rem;"></i>
                        <div>
                            <h3 style="margin-bottom: 0.5rem; font-size: 1rem; font-weight: 700;">{{ $alerte['titre'] }}</h3>
                            <p style="font-size: 0.9rem; margin-bottom: 0.75rem; color: #666;">
                                @if($alerte['est_expire'])
                                    <strong style="color: #ff0000;">Document expiré !</strong> Veuillez le mettre à jour pour continuer à vendre.
                                @else
                                    Votre document expire dans <strong>{{ $alerte['jours_restants'] }} jours</strong>.
                                @endif
                            </p>
                            <a href="{{ route('vendeur.create', ['update' => 1]) }}" style="color: #004aad; font-weight: 700; font-size: 0.85rem; text-decoration: underline;">Mettre à jour maintenant</a>
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="jumia-grid">
                <!-- État de vérification -->
                <div class="jumia-card">
                    <div class="jumia-card-header">
                        <h2>Vérification du compte</h2>
                        <a href="{{ route('vendeur.create', ['update' => 1]) }}" class="edit-icon">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                    <div class="jumia-card-body">
                        <p class="top-text">Statut actuel :</p>
                        <div style="margin-bottom: 0.75rem;">
                            @if(!$vendeur->estOfficiel())
                                <span class="badge badge-pending">Profil incomplet</span>
                            @elseif($vendeur->statut_verification === 'en_attente')
                                <span class="badge badge-pending">En attente de validation</span>
                            @elseif($vendeur->statut_verification === 'verifie')
                                <span class="badge badge-verified">✓ Identité vérifiée</span>
                            @elseif($vendeur->statut_verification === 'rejete')
                                <span class="badge badge-rejected">Validation rejetée</span>
                            @endif
                        </div>

                        <p class="sub-text" style="line-height: 1.5; margin-top: 0.5rem;">
                            @if($vendeur->statut_verification === 'verifie')
                                Félicitations ! Votre identité a été confirmée. Vous profitez de tous les avantages vendeurs.
                            @elseif($vendeur->statut_verification === 'en_attente')
                                Nos administrateurs examinent vos documents. Délai moyen : 48h ouvrables.
                            @else
                                Veuillez soumettre des documents valides pour activer toutes les fonctionnalités.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Type de vendeur -->
                <div class="jumia-card">
                    <div class="jumia-card-header">
                        <h2>Profil de vente</h2>
                    </div>
                    <div class="jumia-card-body">
                        <p class="top-text">Catégorie :</p>
                        <p class="sub-text" style="font-weight: 700; color: #333; margin-bottom: 1rem;">
                            {{ $vendeur->estProfessionnel() ? 'Vendeur Professionnel' : 'Vendeur Particulier' }}
                        </p>
                        
                        <p class="top-text">Boutique :</p>
                        @if($vendeur->aAccesPagePro())
                            <a href="{{ route('page-pro.edit') }}" class="sub-text" style="color: #004aad; text-decoration: underline;">Gérer ma Boutique PRO</a>
                        @else
                            <p class="sub-text">Non applicable (réservé aux pros)</p>
                        @endif

                        <div style="margin-top: auto; padding-top: 1rem;">
                            @if($vendeur->estParticulier())
                                <a href="{{ route('vendeur.create', ['type' => 'professionnel']) }}" style="font-size: 0.85rem; color: #f68b1e; font-weight: 700; text-decoration: underline;">Devenir Vendeur Professionnel</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consommation d'annonces -->
            <div class="jumia-card" style="margin-bottom: 1rem;">
                <div class="jumia-card-header">
                    <h2>Consommation de votre forfait</h2>
                    <a href="{{ route('abonnements.index') }}" style="font-size: 0.75rem; color: #004aad; font-weight: 700; text-decoration: underline;">Voir les forfaits</a>
                </div>
                <div class="jumia-card-body">
                    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 0.5rem;">
                        <div>
                            <p class="top-text">Forfait actif : {{ $abonnementActuel->nom ?? 'Gratuit' }}</p>
                            <p class="sub-text">
                                @if($annoncesRestantes === 'illimité')
                                    Illimité
                                @else
                                    {{ $annoncesRestantes }} annonce(s) restante(s)
                                @endif
                            </p>
                        </div>
                        <p style="font-size: 0.85rem; font-weight: 700; color: #333;">
                            {{ $nombreAnnoncesPubliees }} / {{ ($abonnementActuel && ($abonnementActuel->nombre_annonces === 0 || $abonnementActuel->nombre_annonces === null)) ? '∞' : ($abonnementActuel->nombre_annonces ?? 5) }}
                        </p>
                    </div>

                    @php
                        $limit = ($abonnementActuel && $abonnementActuel->nombre_annonces > 0) ? $abonnementActuel->nombre_annonces : 5;
                        $percentage = ($limit == 0 || !$limit) ? 0 : min(100, ($nombreAnnoncesPubliees / $limit) * 100);
                        if ($abonnementActuel && ($abonnementActuel->nombre_annonces === 0 || $abonnementActuel->nombre_annonces === null)) $percentage = 0;
                        $barColor = $percentage > 90 ? '#c62828' : ($percentage > 75 ? '#f68b1e' : '#2e7d32');
                    @endphp

                    <div class="progress-bar-bg">
                        <div class="progress-bar-fill" style="width: {{ $percentage }}%; background: {{ $barColor }};"></div>
                    </div>

                    <p class="sub-text" style="font-style: italic; margin-top: 0.5rem;">
                        Optimisez vos ventes en choisissant un forfait adapté à vos besoins.
                    </p>
                </div>
            </div>

            @if($vendeur->estProfessionnel() && $vendeur->professionnel)
                <div class="jumia-card">
                    <div class="jumia-card-header">
                        <h2>Informations Professionnelles</h2>
                    </div>
                    <div class="jumia-card-body">
                        <div class="jumia-grid">
                            <div>
                                <p class="top-text">Entreprise</p>
                                <p class="sub-text">{{ $vendeur->professionnel->nom_entreprise }}</p>
                            </div>
                            <div>
                                <p class="top-text">RC / NIF</p>
                                <p class="sub-text">
                                    {{ $vendeur->professionnel->numero_registre_commerce ?? 'RC non renseigné' }} 
                                    <span style="margin: 0 5px;">|</span>
                                    {{ $vendeur->professionnel->numero_identification_fiscale ?? 'NIF non renseigné' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </main>
    </div>
@endsection
