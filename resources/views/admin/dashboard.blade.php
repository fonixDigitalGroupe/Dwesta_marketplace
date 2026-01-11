@extends('layouts.admin')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <span style="color: var(--mady-red); font-weight: 700;">Vue d'ensemble</span>
@endsection

@section('content')
<div style="display: flex; flex-direction: column; gap: 2.5rem;">
    
    <!-- Hero Section -->
    <header style="display: flex; align-items: flex-end; justify-content: space-between;">
        <div>
            <h1 style="font-size: 1.875rem; font-weight: 800; color: var(--slate-900); letter-spacing: -0.03em; margin-bottom: 0.5rem;">Bienvenue, {{ auth()->user()->prenom }}</h1>
            <p style="color: var(--slate-500); font-size: 1rem; font-weight: 500;">Voici l'état actuel de la plateforme Mady Market pour aujourd'hui.</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <div style="background: #fff; border: 1px solid var(--slate-200); padding: 8px 16px; border-radius: 12px; font-size: 0.875rem; font-weight: 700; color: var(--slate-700); display: flex; align-items: center; gap: 8px;">
                <div style="width: 8px; height: 8px; background: #10b981; border-radius: 50%;"></div>
                Système en ligne
            </div>
        </div>
    </header>

    <!-- Professional Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
        
        <!-- Total Users -->
        <div class="card-pro" style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="width: 40px; height: 40px; background: var(--slate-50); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--slate-600);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div style="color: var(--slate-500); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Utilisateurs</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--slate-900);">{{ $stats['users_count'] }}</div>
        </div>

        <!-- Total Ads -->
        <div class="card-pro" style="padding: 1.5rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="width: 40px; height: 40px; background: var(--slate-50); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--slate-600);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
            </div>
            <div style="color: var(--slate-500); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Annonces Totales</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: var(--slate-900);">{{ $stats['annonces_count'] }}</div>
        </div>

        <!-- Pending Moderation -->
        <div class="card-pro" style="padding: 1.5rem; border-color: #10b981; background: #f0fdf4;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="width: 40px; height: 40px; background: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: #059669; border: 1px solid #10b981;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
                <a href="{{ route('admin.annonces.moderation.index') }}" style="font-size: 0.75rem; font-weight: 700; color: #059669; text-decoration: none;">Voir →</a>
            </div>
            <div style="color: #059669; font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">À Modérer</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #064e3b;">{{ $stats['annonces_pending'] }}</div>
        </div>

        <!-- Open Disputes -->
        <div class="card-pro" style="padding: 1.5rem; border-color: var(--mady-red); background: var(--mady-light-red);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="width: 40px; height: 40px; background: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--mady-red); border: 1px solid var(--mady-red);">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <a href="{{ route('admin.litiges.index') }}" style="font-size: 0.75rem; font-weight: 700; color: var(--mady-red); text-decoration: none;">Gérer →</a>
            </div>
            <div style="color: var(--mady-red); font-size: 0.8125rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Litiges en cours</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #7f1d1d;">{{ $stats['litiges_open'] }}</div>
        </div>

    </div>

    <!-- Secondary Actions & Content -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        
        <!-- Quick Actions Panel -->
        <div class="card-pro" style="padding: 2.5rem;">
            <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--slate-900); margin-bottom: 2rem; display: flex; align-items: center; gap: 10px;">
                <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Actions Prioritaires
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <a href="{{ route('admin.categories.l1') }}" style="padding: 1.5rem; border: 1px solid var(--slate-200); border-radius: 16px; text-decoration: none; color: inherit; transition: all 0.2s; display: block;" onmouseover="this.style.background='var(--slate-50)'; this.style.borderColor='var(--slate-300)'" onmouseout="this.style.background='transparent'; this.style.borderColor='var(--slate-200)'">
                    <div style="font-weight: 700; color: var(--slate-900); margin-bottom: 0.5rem;">Architecture Catalogue</div>
                    <div style="font-size: 0.8125rem; color: var(--slate-500); line-height: 1.4;">Gérer les catégories racines et la hiérarchie globale du catalogue.</div>
                </a>
                
                <a href="{{ route('admin.vendeurs.verification.index') }}" style="padding: 1.5rem; border: 1px solid var(--slate-200); border-radius: 16px; text-decoration: none; color: inherit; transition: all 0.2s; display: block;" onmouseover="this.style.background='var(--slate-50)'; this.style.borderColor='var(--slate-300)'" onmouseout="this.style.background='transparent'; this.style.borderColor='var(--slate-200)'">
                    <div style="font-weight: 700; color: var(--slate-900); margin-bottom: 0.5rem;">Validation Vendeurs</div>
                    <div style="font-size: 0.8125rem; color: var(--slate-500); line-height: 1.4;">Examiner les dossiers de vérification et les documents légaux des marchands.</div>
                </a>
            </div>
        </div>

        <!-- System Updates / Info -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="background: var(--slate-900); border-radius: 20px; padding: 2rem; color: #fff;">
                <div style="font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--slate-400); margin-bottom: 1rem;">Notes de Version</div>
                <h4 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 0.75rem;">Mady Market Admin v2.1</h4>
                <p style="font-size: 0.875rem; color: var(--slate-300); line-height: 1.6;">L'interface a été optimisée pour une gestion plus rapide. Les modules de modération sont désormais accessibles directement depuis la sidebar globale.</p>
            </div>

            <div style="padding: 1.5rem; border: 1px dashed var(--slate-300); border-radius: 20px; background: #fff;">
                <div style="font-size: 0.8125rem; font-weight: 700; color: var(--slate-900); margin-bottom: 0.5rem;">Support Technique</div>
                <p style="font-size: 0.75rem; color: var(--slate-500); line-height: 1.5;">Pour toute anomalie sur le back-office, merci de contacter l'équipe de développement via le canal dédié.</p>
            </div>
        </div>

    </div>

</div>
@endsection
