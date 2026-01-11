<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Mady Market</title>
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

        .search-container {
            flex: 1;
            display: flex;
            align-items: center;
            max-width: 600px;
        }
        
        .search-field {
            flex: 1;
            display: flex;
            border: 1px solid #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
        }

        .search-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            font-size: 1rem;
            outline: none;
        }
        
        .search-button {
            background-color: #333;
            color: white;
            border: none;
            padding: 0 1.25rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .search-button:hover {
            background-color: #000;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-shrink: 0;
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
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 2rem;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .content-header h1 {
            font-size: 1.5rem;
            color: #333;
        }

        /* Form styles */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 0.5rem;
        }

        .input-field {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .input-field:focus {
            border-color: #bf0000;
            box-shadow: 0 0 0 2px rgba(191, 0, 0, 0.1);
        }

        .btn-save {
            background: #bf0000;
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
        }

        .btn-save:hover {
            background: #a00000;
        }

        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 900px) {
            .dashboard-container {
                grid-template-columns: 1fr;
            }
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-group.full-width {
                grid-column: span 1;
            }
        }
    </style>
</head>
<body>
    <!-- Bannière (Top Banner) -->
    <div class="top-banner">
        Mady Market : Profitez de nos meilleures offres sur tous les produits !
        <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="logo">
                <img src="https://laravel.com/img/logomark.min.svg" alt="Logo">
                Mady Market
            </a>
            
            <!-- Barre de recherche -->
            <div class="search-container">
                <form action="{{ route('annonces.index') }}" method="GET" style="width: 100%;">
                    <div class="search-field">
                        <input 
                            type="text" 
                            name="search" 
                            class="search-input" 
                            placeholder="Rechercher un produit, une marque..."
                            value="{{ request('search') }}"
                        >
                        <button type="submit" class="search-button">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Actions du header -->
            <div class="header-actions">
                <a href="#" class="club-r">Club R</a>
                
                @auth
                    @if(auth()->user()->hasRole('Administrateur'))
                        <a href="{{ route('admin.dashboard') }}" class="header-link" style="color: #bf0000; font-weight: 800; border: 1px solid #bf0000; padding: 4px 10px; border-radius: 6px; background: #fff;">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 2px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Back Office</span>
                        </a>
                    @endif
                    <!-- Mon Compte -->
                    <a href="{{ route('profile.show') }}" class="header-link">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>{{ auth()->user()->prenom ?? auth()->user()->name }}</span>
                    </a>

                    <!-- Favoris -->
                    <a href="{{ route('dashboard') }}" class="header-link" title="Favoris">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </a>
                    
                    <!-- Panier -->
                    <a href="{{ route('dashboard') }}" class="header-link" title="Panier">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            @if(auth()->user()->hasRole('Administrateur'))
            <div class="sidebar-section" style="border: 2px solid #bf0000; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(191,0,0,0.1);">
                <div class="sidebar-title" style="background: #bf0000; color: #fff; border-bottom: none;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #fff;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Administration
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('admin.dashboard') }}" style="color: #bf0000; font-weight: 800; font-size: 1rem; text-align: center; padding: 1rem;">ACCÉDER AU BACK OFFICE</a></li>
                </ul>
            </div>
            @endif
            <!-- Mes informations -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Mes informations
                </div>
                <ul class="sidebar-menu">
                    <li><a href="{{ route('profile.show') }}" class="active">Mon compte</a></li>
                    <li><a href="{{ route('profile.show') }}">Mon adresse e-mail</a></li>
                    <li><a href="{{ route('profile.show') }}">Mon mot de passe</a></li>
                    <li><a href="#">Mes préférences acheteur</a></li>
                    <li><a href="#">Mes préférences vendeur</a></li>
                    <li><a href="{{ route('abonnements.index') }}">Mes abonnements</a></li>
                </ul>
            </div>

            <!-- Mes achats -->
            <div class="sidebar-section">
                <div class="sidebar-title">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Mes achats
                </div>
                <ul class="sidebar-menu">
                    <li><a href="#">Tous mes achats</a></li>
                    <li><a href="#">Mes favoris</a></li>
                    <li><a href="#">Mon suivi de commande</a></li>
                </ul>
            </div>

            <div style="text-align: center; margin-top: 1rem;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #666; font-size: 0.9rem; cursor: pointer; text-decoration: underline;">
                        Se déconnecter
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h1>Mon profil personnel</h1>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label class="label">Prénom</label>
                        <input type="text" name="prenom" class="input-field" value="{{ old('prenom', $user->prenom) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="label">Nom</label>
                        <input type="text" name="nom" class="input-field" value="{{ old('nom', $user->nom) }}">
                    </div>

                    <div class="form-group">
                        <label class="label">Adresse e-mail</label>
                        <input type="email" name="email" class="input-field" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label class="label">Téléphone</label>
                        <input type="tel" name="telephone" class="input-field" value="{{ old('telephone', $user->telephone) }}" placeholder="Ex: +236 ...">
                    </div>

                    <div class="form-group">
                        <label class="label">Nationalité</label>
                        <input type="text" name="nationalite" class="input-field" value="{{ old('nationalite', $user->nationalite) }}" placeholder="Ex: Centrafricaine">
                    </div>

                    <div class="form-group">
                        <label class="label">Date de naissance</label>
                        <input type="date" name="date_de_naissance" class="input-field" value="{{ old('date_de_naissance', $user->date_de_naissance ? $user->date_de_naissance->format('Y-m-d') : '') }}">
                    </div>

                    <div class="form-group full-width">
                        <label class="label">Adresse complète</label>
                        <textarea name="adresse" class="input-field" rows="3" placeholder="Votre adresse physique...">{{ old('adresse', $user->adresse) }}</textarea>
                    </div>
                </div>

                <div style="margin-top: 2rem; border-top: 1px solid #f0f0f0; padding-top: 2rem; text-align: right;">
                    <button type="submit" class="btn-save">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>

            <div style="margin-top: 4rem; border-top: 2px solid #f0f0f0; padding-top: 2rem;">
                <h2 style="font-size: 1.25rem; margin-bottom: 1.5rem;">Sécurité - Modifier le mot de passe</h2>
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="label">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="input-field" required>
                        </div>
                        <div class="form-group"></div> <!-- Spacer -->

                        <div class="form-group">
                            <label class="label">Nouveau mot de passe</label>
                            <input type="password" name="password" class="input-field" required>
                        </div>

                        <div class="form-group">
                            <label class="label">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" class="input-field" required>
                        </div>
                    </div>

                    <div style="text-align: right; margin-top: 1rem;">
                        <button type="submit" class="btn-save" style="background: #333;">
                            Mettre à jour le mot de passe
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Scripts éventuels pour l'interactivité
    </script>
</body>
</html>
