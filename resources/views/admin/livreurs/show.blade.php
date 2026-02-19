@extends('layouts.admin')

@section('title', 'Détails du Livreur')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.livreurs.index') }}" style="color: #666; text-decoration: none;">Livreurs</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Dossier Livreur</span>
@endsection

@section('content')
<div style="max-width: 1100px;">

    <!-- Header & Actions Rapides -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div style="width: 70px; height: 70px; background: #fff7ed; border-radius: 16px; display: flex; align-items: center; justify-content: center; color: #ff750f; border: 1px solid #ffedd5;">
                <svg width="35" height="35" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
            <div>
                <h1 style="font-size: 1.5rem; color: #333; font-weight: 600; margin-bottom: 4px;">
                    {{ $livreur->user->prenom }} {{ $livreur->user->nom }}
                </h1>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 0.85rem; color: #666;">Membre depuis {{ $livreur->created_at->format('d/m/Y') }}</span>
                    @if($livreur->statut_verification === 'verifie')
                        <span style="background: #f0fdf4; color: #16a34a; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; border: 1px solid #bbf7d0;">Dossier Approuvé</span>
                    @elseif($livreur->statut_verification === 'rejete')
                        <span style="background: #fef2f2; color: #dc2626; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; border: 1px solid #fecaca;">Dossier Rejeté</span>
                    @else
                        <span style="background: #fffbeb; color: #ea580c; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; border: 1px solid #fef3c7;">En attente de vérification</span>
                    @endif
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 10px;">
            @if($livreur->statut_verification !== 'verifie')
                <form action="{{ route('admin.livreurs.approve', $livreur) }}" method="POST">
                    @csrf
                    <button type="submit" style="background: #16a34a; color: #fff; border: none; padding: 0.6rem 1.2rem; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Approuver le dossier
                    </button>
                </form>
            @endif

            @if($livreur->statut_verification !== 'rejete')
                <button onclick="document.getElementById('reject-modal').style.display='flex'" style="background: #fff; color: #dc2626; border: 1px solid #fecaca; padding: 0.6rem 1.2rem; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 0.85rem; display: flex; align-items: center; gap: 8px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Rejeter
                </button>
            @endif
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 2rem;">
        
        <!-- Colonne Principale -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- Informations Personnelles -->
            <div style="background: #fff; border: 1px solid #e5e5e5; border-radius: 12px; padding: 1.5rem;">
                <h2 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 10px;">
                    <span style="width: 4px; height: 16px; background: #ff750f; border-radius: 2px;"></span>
                    Informations de Contact
                </h2>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.75rem; color: #999; margin-bottom: 4px;">Email</label>
                        <div style="font-size: 0.95rem; color: #333; font-weight: 500;">{{ $livreur->user->email }}</div>
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.75rem; color: #999; margin-bottom: 4px;">Téléphone</label>
                        <div style="font-size: 0.95rem; color: #333; font-weight: 500;">{{ $livreur->user->telephone ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Documents KYC -->
            <div style="background: #fff; border: 1px solid #e5e5e5; border-radius: 12px; padding: 1.5rem;">
                <h2 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 10px;">
                    <span style="width: 4px; height: 16px; background: #ff750f; border-radius: 2px;"></span>
                    Documents d'Identité ({{ $livreur->type_document }})
                </h2>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <label style="display: block; font-size: 0.75rem; color: #999; margin-bottom: 8px;">Recto</label>
                        @if($livreur->document_recto)
                            <a href="{{ $documents['document_recto'] }}" target="_blank" style="display: block; border-radius: 8px; overflow: hidden; border: 1px solid #eee;">
                                @if(Str::endsWith($livreur->document_recto, '.pdf'))
                                    <div style="padding: 20px; text-align: center; background: #f8fafc;">
                                        <svg width="40" height="40" fill="none" stroke="#ef4444" viewBox="0 0 24 24" style="margin-bottom: 10px;">
                                            <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        <div style="font-size: 0.8rem; color: #475569;">Voir le PDF</div>
                                    </div>
                                @else
                                    <img src="{{ $documents['document_recto'] }}" style="width: 100%; height: 200px; object-fit: cover;">
                                @endif
                            </a>
                        @else
                            <div style="height: 150px; background: #f9fafb; border: 1px dashed #ddd; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999; font-size: 0.85rem;">
                                Document non fourni
                            </div>
                        @endif
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.75rem; color: #999; margin-bottom: 8px;">Verso</label>
                        @if($livreur->document_verso)
                            <a href="{{ $documents['document_verso'] }}" target="_blank" style="display: block; border-radius: 8px; overflow: hidden; border: 1px solid #eee;">
                                @if(Str::endsWith($livreur->document_verso, '.pdf'))
                                    <div style="padding: 20px; text-align: center; background: #f8fafc;">
                                        <svg width="40" height="40" fill="none" stroke="#ef4444" viewBox="0 0 24 24" style="margin-bottom: 10px;">
                                            <path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        <div style="font-size: 0.8rem; color: #475569;">Voir le PDF</div>
                                    </div>
                                @else
                                    <img src="{{ $documents['document_verso'] }}" style="width: 100%; height: 200px; object-fit: cover;">
                                @endif
                            </a>
                        @else
                            <div style="height: 150px; background: #f9fafb; border: 1px dashed #ddd; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999; font-size: 0.85rem;">
                                Document non fourni
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne Latérale -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Infos Véhicule -->
            <div style="background: #fff; border: 1px solid #e5e5e5; border-radius: 12px; padding: 1.5rem;">
                <h2 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.25rem;">Véhicule</h2>
                
                <div style="display: flex; flex-direction: column; gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 0.75rem; color: #999; margin-bottom: 4px;">Type d'engin</label>
                        <div style="font-size: 0.95rem; color: #333; font-weight: 500;">{{ $livreur->type_vehicule }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Rejet -->
<div id="reject-modal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #fff; width: 100%; max-width: 500px; border-radius: 12px; padding: 2rem;">
        <h3 style="font-size: 1.25rem; color: #333; font-weight: 600; margin-bottom: 1rem;">Motif du rejet</h3>
        <form action="{{ route('admin.livreurs.reject', $livreur) }}" method="POST">
            @csrf
            <textarea name="raison_rejet" required placeholder="Expliquez pourquoi le dossier est rejeté..." 
                      style="width: 100%; height: 120px; padding: 1rem; border: 1px solid #e0e0e0; border-radius: 8px; margin-bottom: 1.5rem; outline: none; focus: border-color: #ff750f"></textarea>
            <div style="display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="document.getElementById('reject-modal').style.display='none'" style="background: #f3f4f6; color: #666; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; font-weight: 600; cursor: pointer;">Annuler</button>
                <button type="submit" style="background: #dc2626; color: #fff; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; font-weight: 600; cursor: pointer;">Confirmer le rejet</button>
            </div>
        </form>
    </div>
</div>
@endsection
