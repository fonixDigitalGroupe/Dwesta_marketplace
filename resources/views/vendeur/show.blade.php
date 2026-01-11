<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte vendeur - Mady Market</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f6f6f6;
            color: #333;
        }
        
        /* Banner style Rakuten */
        .top-banner {
            background-color: #bf0000;
            color: white;
            text-align: center;
            padding: 0.5rem;
            font-size: 0.9rem;
            position: relative;
        }

        .top-banner .close-btn {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        /* Header style Rakuten */
        .header {
            background-color: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 0.75rem 0;
        }
        
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
            color: #bf0000;
            flex-shrink: 0;
        }
        
        .logo img {
            height: 40px;
            margin-right: 0.5rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-left: auto;
        }

        .header-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #333;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .header-link:hover {
            color: #bf0000;
        }

        .header-link svg {
            width: 22px;
            height: 22px;
        }

        .club-r {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.4rem 0.8rem;
            background: #fdf2f2;
            border-radius: 20px;
            color: #bf0000;
            font-weight: bold;
            font-size: 0.85rem;
            text-decoration: none;
        }

        /* Layout */
        .dashboard-container {
            max-width: 1200px;
            margin: 2rem auto;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 2rem;
            padding: 0 1rem;
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .sidebar-section {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
        }

        .sidebar-title {
            padding: 1rem;
            font-weight: bold;
            font-size: 0.95rem;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #fafafa;
        }

        .sidebar-title svg {
            width: 18px;
            height: 18px;
            color: #666;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li a {
            display: block;
            padding: 0.75rem 1rem;
            text-decoration: none;
            color: #555;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .sidebar-menu li a:hover {
            background: #fdf2f2;
            color: #bf0000;
        }

        .sidebar-menu li a.active {
            background: #fdf2f2;
            color: #bf0000;
            font-weight: 600;
            border-left: 3px solid #bf0000;
        }

        /* Main Content */
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .card {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 2rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .card-title {
            font-size: 1.25rem;
            color: #333;
            font-weight: bold;
        }

        /* Status Badges */
        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-verified { background: #d4edda; color: #155724; }
        .badge-rejected { background: #f8d7da; color: #721c24; }

        /* Document info */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .info-item {
            margin-bottom: 1rem;
        }

        .info-label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1rem;
            color: #333;
            font-weight: 500;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            font-size: 0.95rem;
        }

        .btn-primary { background: #bf0000; color: white; }
        .btn-primary:hover { background: #a00000; }
        .btn-secondary { background: #f0f0f0; color: #333; }
        .btn-secondary:hover { background: #e0e0e0; }

        /* Alert Box */
        .alert-box {
            background: #fdf2f2;
            border: 1px solid #fad2d2;
            border-radius: 8px;
            padding: 1.5rem;
            color: #bf0000;
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
</head>
<body>
    <!-- Bannière (Top Banner) -->
    <div class="top-banner">
        Mady Market Vendeur : Gérez vos ventes en toute simplicité.
        <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo">
                <img src="https://laravel.com/img/logomark.min.svg" alt="Logo">
                Mady Market
            </a>
            
            <div class="header-actions">
                <a href="#" class="club-r">Club R Vendeur</a>
                <a href="{{ route('profile.show') }}" class="header-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>{{ auth()->user()->prenom }}</span>
                </a>
            </div>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Mon Compte Vendeur
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('vendeur.show') }}" class="active">État du compte</a></li>
                    <li><a href="{{ route('abonnements.mon-abonnement') }}">Mon abonnement</a></li>
                    <li><a href="{{ route('vendeur.wallet.index') }}">Mon Portefeuille (Revenus)</a></li>
                    <li><a href="{{ route('annonces.index') }}">Mes annonces</a></li>
                </ul>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Porte-monnaie
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('vendeur.wallet.index') }}">Solde : {{ number_format(auth()->user()->credit_balance, 0, ',', ' ') }} FCFA</a></li>
                    <li><a href="{{ route('vendeur.wallet.index') }}">Demander un retrait</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            
            <!-- Alertes d'expiration -->
            @if(isset($alertes) && count($alertes) > 0)
                @foreach($alertes as $alerte)
                    <div class="alert-box">
                        <div style="display: flex; align-items: flex-start; gap: 1rem;">
                            <svg style="width: 24px; height: 24px; flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <div>
                                <h3 style="margin-bottom: 0.5rem;">{{ $alerte['titre'] }}</h3>
                                <p style="font-size: 0.9rem; margin-bottom: 0.75rem;">
                                    @if($alerte['est_expire'])
                                        <strong style="color: #dc3545;">Document expiré !</strong> Veuillez le mettre à jour pour continuer à vendre.
                                    @else
                                        Votre document expire dans <strong>{{ $alerte['jours_restants'] }} jours</strong>.
                                    @endif
                                </p>
                                <a href="{{ route('vendeur.create') }}" class="btn btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Mettre à jour</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Statut de vérification -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Statut de vérification du compte</h2>
                    @if($vendeur->statut_verification === 'en_attente')
                        <span class="badge badge-pending">En attente de vérification</span>
                    @elseif($vendeur->statut_verification === 'verifie')
                        <span class="badge badge-verified">✓ Compte vérifié</span>
                    @elseif($vendeur->statut_verification === 'rejete')
                        <span class="badge badge-rejected">Rejeté</span>
                    @endif
                </div>

                @if($vendeur->statut_verification === 'rejete' && $vendeur->raison_rejet)
                    <div style="background: #fdf2f2; border: 1px solid #fad2d2; padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem;">
                        <strong style="color: #bf0000;">Motif du rejet :</strong> 
                        <span style="color: #333;">{{ $vendeur->raison_rejet }}</span>
                    </div>
                @endif

                <p style="color: #666; font-size: 0.9rem; line-height: 1.5;">
                    @if($vendeur->statut_verification === 'verifie')
                        Félicitations ! Votre identité a été confirmée. Vous pouvez désormais publier des annonces et effectuer des transactions en toute sécurité sur Mady Market.
                    @elseif($vendeur->statut_verification === 'en_attente')
                        Nos administrateurs examinent actuellement vos documents. Ce processus prend généralement moins de 48 heures ouvrables. Vous recevrez une notification dès que la vérification sera effectuée.
                    @else
                        Votre demande de vérification a été rejetée. Veuillez corriger les informations nécessaires et soumettre à nouveau vos documents.
                    @endif
                </p>
            </div>

            <!-- Identité KYC -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Identité & Documents KYC</h2>
                    <a href="{{ route('vendeur.create') }}" class="btn btn-secondary" style="font-size: 0.85rem; padding: 0.5rem 1rem;">Modifier</a>
                </div>

                @if($vendeur->estParticulier() && $vendeur->particulier)
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Type de document</div>
                            <div class="info-value">
                                @if($vendeur->particulier->type_document === 'cni') CNI (Identité)
                                @elseif($vendeur->particulier->type_document === 'passeport') Passeport
                                @elseif($vendeur->particulier->type_document === 'recepisse') Récépissé
                                @endif
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Numéro du document</div>
                            <div class="info-value">{{ $vendeur->particulier->numero_document }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Date d'émission</div>
                            <div class="info-value">{{ $vendeur->particulier->date_emission_document ? $vendeur->particulier->date_emission_document->format('d/m/Y') : '-' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Date d'expiration</div>
                            <div class="info-value" style="{{ $vendeur->particulier->estExpire() ? 'color: #bf0000; font-weight: bold;' : '' }}">
                                {{ $vendeur->particulier->date_expiration_document ? $vendeur->particulier->date_expiration_document->format('d/m/Y') : '-' }}
                                @if($vendeur->particulier->estExpire()) (Expiré) @endif
                            </div>
                        </div>
                    </div>
                @endif

                @if($vendeur->estProfessionnel() && $vendeur->professionnel)
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Nom de l'entreprise</div>
                            <div class="info-value">{{ $vendeur->professionnel->nom_entreprise }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Registre de commerce</div>
                            <div class="info-value">{{ $vendeur->professionnel->numero_registre_commerce ?? 'Non renseigné' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">NIF</div>
                            <div class="info-value">{{ $vendeur->professionnel->numero_identification_fiscale ?? 'Non renseigné' }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email entreprise</div>
                            <div class="info-value">{{ $vendeur->professionnel->email_entreprise ?? '-' }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Actions Pro -->
            @if($vendeur->estVerifie())
                <div class="card" style="background: #fafafa; border-style: dashed; border-width: 2px;">
                    <div class="card-header">
                        <h2 class="card-title">Mise en vente & Visibilité</h2>
                    </div>
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <a href="{{ route('annonces.create') }}" class="btn btn-primary" style="display: flex; align-items: center; gap: 0.5rem;">
                            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Mettre un produit en vente
                        </a>
                        @if($vendeur->aAccesPagePro())
                            <a href="{{ $vendeur->pagePro ? route('page-pro.edit') : route('page-pro.edit') }}" class="btn btn-secondary" style="display: flex; align-items: center; gap: 0.5rem;">
                                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m0 10V4m-4 6h4m-4 4h4m1 1H7"></path></svg>
                                {{ $vendeur->pagePro ? 'Gérer ma Page Pro' : 'Créer ma Page Pro' }}
                            </a>
                        @endif
                        <a href="{{ route('annonces.index') }}" class="btn btn-secondary">📋 Gérer mes annonces</a>
                    </div>
                </div>
            @endif

        </main>
    </div>
</body>
</html>
