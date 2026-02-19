@extends('layouts.admin')

@section('title', 'Dossier Transporteur : ' . $transporteur->user->prenom)

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.transporteurs.index') }}" style="color: #666; text-decoration: none;">Transporteurs</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Dossier KYC</span>
@endsection

@section('content')
<div style="max-width: 1200px;">

    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.375rem; color: #333; font-weight: 600;">
                Dossier : {{ $transporteur->user->prenom }} {{ $transporteur->user->nom }}
            </h1>
            <p style="font-size: 0.85rem; color: #666; margin-top: 4px;">Vérification des documents et conformité du véhicule</p>
        </div>
        
        <div>
            @if($transporteur->statut_verification === 'verifie')
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                    <div style="width: 6px; height: 6px; background: #22c55e; border-radius: 50%;"></div>
                    Vérifié le {{ $transporteur->updated_at->format('d/m/Y') }}
                </div>
            @elseif($transporteur->statut_verification === 'rejete')
                <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                    <div style="width: 6px; height: 6px; background: #ef4444; border-radius: 50%;"></div>
                    Dossier Rejeté
                </div>
            @else
                <div style="background: #fffbeb; border: 1px solid #fef3c7; color: #92400e; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                    <div style="width: 6px; height: 6px; background: #f59e0b; border-radius: 50%;"></div>
                    En attente de vérification
                </div>
            @endif
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 320px; gap: 1.5rem; align-items: start;">
        
        <!-- Colonne Principale -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- Informations de Base -->
            <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                <h2 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                    <svg width="18" height="18" fill="none" stroke="#666" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Détails du Profil
                </h2>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div>
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #999; margin-bottom: 4px;">Nom complet</label>
                                <div style="font-size: 0.95rem; color: #333; font-weight: 500;">{{ $transporteur->user->prenom }} {{ $transporteur->user->nom }}</div>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #999; margin-bottom: 4px;">Téléphone</label>
                                <div style="font-size: 0.95rem; color: #333;">{{ $transporteur->user->telephone ?? '-' }}</div>
                            </div>
                            @if($transporteur->photo_vehicule)
                            <div style="margin-top: 10px;">
                                <label style="display: block; font-size: 0.75rem; color: #999; margin-bottom: 8px;">Photo du véhicule</label>
                                <a href="{{ route('documents.show', ['path' => base64_encode($transporteur->photo_vehicule)]) }}" target="_blank" style="display: block; width: 100%; max-width: 200px; border-radius: 8px; overflow: hidden; border: 1px solid #eee;">
                                    <img src="{{ route('documents.show', ['path' => base64_encode($transporteur->photo_vehicule)]) }}" style="width: 100%; height: auto; object-fit: cover;">
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #999; margin-bottom: 4px;">Type de véhicule</label>
                                <div style="font-size: 0.95rem; color: #333; font-weight: 500;">{{ $transporteur->type_vehicule }}</div>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #999; margin-bottom: 4px;">Marque & Modèle</label>
                                <div style="font-size: 0.95rem; color: #333;">{{ $transporteur->marque_vehicule }} {{ $transporteur->modele_vehicule }}</div>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.75rem; color: #999; margin-bottom: 4px;">Immatriculation</label>
                                <div style="font-size: 0.95rem; color: #333; font-weight: 600; color: #ff750f;">{{ $transporteur->immatriculation ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents -->
            <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                <h2 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem;">Pièces Justificatives</h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1.5rem;">
                    @foreach($documents as $label => $url)
                        <div style="border: 1px solid #f0f0f0; border-radius: 8px; padding: 1rem; background: #fafafa;">
                            <div style="font-size: 0.75rem; font-weight: 600; color: #666; margin-bottom: 1rem; text-transform: uppercase;">
                                {{ str_replace('_', ' ', $label) }}
                            </div>
                            
                            @if($url)
                                @php $ext = pathinfo($url, PATHINFO_EXTENSION); @endphp
                                @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                                    <a href="{{ $url }}" target="_blank" style="display: block; width: 100%; height: 180px; border-radius: 4px; overflow: hidden; position: relative; border: 1px solid #eee;">
                                        <img src="{{ $url }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.2s;" onmouseover="this.style.opacity=1" onmouseout="this.style.opacity=0">
                                            <span style="background: #fff; padding: 6px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; color: #000;">Cliquez pour agrandir</span>
                                        </div>
                                    </a>
                                @else
                                    <a href="{{ $url }}" target="_blank" style="display: flex; align-items: center; gap: 10px; background: #fff; border: 1px solid #e0e0e0; padding: 12px; border-radius: 6px; color: #333; text-decoration: none; font-weight: 500; font-size: 0.85rem;">
                                        <svg width="20" height="20" fill="none" stroke="#ff750f" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        Voir le document (PDF)
                                    </a>
                                @endif
                            @else
                                <div style="height: 180px; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #999; font-size: 0.8rem; background: #fff; border: 1px dashed #ddd; border-radius: 4px;">
                                    Absence de document
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Colonne Latérale: Actions -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem; position: sticky; top: 1.5rem;">
            
            <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.25rem;">
                <h3 style="font-size: 0.9rem; color: #333; font-weight: 600; margin-bottom: 1rem;">Action requise</h3>
                
                @if($transporteur->statut_verification === 'en_attente')
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <form action="{{ route('admin.transporteurs.approve', $transporteur) }}" method="POST">
                            @csrf
                            <button type="submit" style="width: 100%; border: none; background: #000; color: #fff; padding: 12px; border-radius: 4px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; font-size: 0.9rem;">
                                Approuver
                            </button>
                        </form>

                        <div style="border-top: 1px solid #f0f0f0; padding-top: 12px; margin-top: 4px;">
                            <form action="{{ route('admin.transporteurs.reject', $transporteur) }}" method="POST">
                                @csrf
                                <div style="margin-bottom: 12px;">
                                    <textarea name="raison_rejet" rows="3" required 
                                              style="width: 100%; padding: 10px; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 0.85rem; resize: none; outline: none; transition: border 0.2s;" 
                                              onfocus="this.style.borderColor='#ff750f'" onblur="this.style.borderColor='#e0e0e0'"
                                              placeholder="Motif du rejet..."></textarea>
                                </div>
                                <button type="submit" style="width: 100%; border: none; background: #fef2f2; color: #dc2626; padding: 10px; border-radius: 4px; font-weight: 600; cursor: pointer; font-size: 0.85rem; border: 1px solid #fee2e2;">
                                    Rejeter le dossier
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif($transporteur->statut_verification === 'rejete')
                    <div style="background: #fef2f2; border: 1px solid #fee2e2; padding: 12px; border-radius: 4px;">
                        <div style="font-size: 0.75rem; font-weight: 600; color: #dc2626; margin-bottom: 6px; text-transform: uppercase;">Motif du rejet</div>
                        <div style="font-size: 0.85rem; color: #991b1b; line-height: 1.4;">{{ $transporteur->raison_rejet }}</div>
                    </div>
                @else
                    <div style="padding: 1rem; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 4px; text-align: center;">
                        <svg width="32" height="32" fill="none" stroke="#16a34a" viewBox="0 0 24 24" style="margin-bottom: 8px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div style="font-weight: 600; color: #166534; font-size: 0.9rem;">Profil Vérifié</div>
                        <div style="font-size: 0.75rem; color: #166534; margin-top: 2px;">Tout est en ordre.</div>
                    </div>
                @endif
            </div>

            <a href="{{ route('admin.transporteurs.index') }}" 
               style="display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; color: #666; text-decoration: none; font-weight: 600; font-size: 0.85rem; transition: background 0.2s;" 
               onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='#fff'">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour
            </a>
        </div>
    </div>
</div>
@endsection
