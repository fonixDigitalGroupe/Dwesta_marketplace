@extends('layouts.admin')

@section('title', 'Détails du Litige #' . $litige->id)

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <!-- Header -->
    <div style="margin-bottom: 2rem; border-bottom: 1px solid #e7e7e7; padding-bottom: 1rem; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 style="font-size: 1.5rem; color: #111; font-weight: 700; margin-bottom: 0.25rem;">Litige #{{ $litige->id }}</h1>
            <p style="font-size: 0.9rem; color: #555;">Signalé le {{ $litige->created_at->format('d/m/Y à H:i') }}</p>
        </div>
        <a href="{{ route('admin.litiges.index') }}" 
           style="font-size: 0.85rem; color: #004aad; text-decoration: none; font-weight: 600;">
            &larr; Retour à la liste
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px; align-items: start;">
        
        <!-- Left Column: Details & Resolution -->
        <div style="display: flex; flex-direction: column; gap: 25px;">
            
            <!-- Description Card -->
            <div style="background: #fff; border: 1px solid #e7e7e7; padding: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #111; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #f1f1f1; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-info-circle" style="color: #004aad;"></i> Description du Problème
                </h2>
                
                <div style="margin-bottom: 20px;">
                    <span style="font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase;">Motif du Signalement</span>
                    <div style="margin-top: 5px;">
                        <span style="font-size: 0.85rem; color: #c45500; background: #fff8f3; padding: 4px 12px; border-radius: 4px; font-weight: 700; border: 1px solid #fbd8b4;">
                            {{ ucfirst($litige->motif) }}
                        </span>
                    </div>
                </div>

                <div>
                    <span style="font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase;">Détails (Message)</span>
                    <div style="margin-top: 10px; padding: 20px; background: #fafafa; border: 1px solid #e7e7e7; border-radius: 4px; font-size: 0.95rem; color: #333; line-height: 1.6;">
                        {{ $litige->description }}
                    </div>
                </div>
            </div>

            <!-- Order Card -->
            @if($litige->order)
            <div style="background: #fff; border: 1px solid #e7e7e7; padding: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #111; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #f1f1f1; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-shopping-bag" style="color: #f68b1e;"></i> Commande Associée
                </h2>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px;">
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 5px;">Référence</div>
                        <div style="font-weight: 700; color: #004aad; font-size: 1rem;">#{{ $litige->order->reference }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 5px;">Montant Total</div>
                        <div style="font-weight: 700; color: #111; font-size: 1rem;">{{ number_format($litige->order->total_final, 0, ',', ' ') }} FCFA</div>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 5px;">Statut</div>
                        <div>
                            <span style="font-size: 0.7rem; color: #004aad; background: #f0f7ff; padding: 2px 8px; border-radius: 4px; font-weight: 700; text-transform: uppercase; border: 1px solid #cce3ff;">
                                {{ $litige->order->statut_label ?? $litige->order->statut }}
                            </span>
                        </div>
                    </div>
                </div>

                <div style="background: #f9f9f9; border-radius: 4px; overflow: hidden; border: 1px solid #e7e7e7;">
                    @foreach($litige->order->items as $item)
                        <div style="padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <span style="font-weight: 700; color: #555; font-size: 0.85rem; width: 30px;">x{{ $item->quantite }}</span>
                                <span style="font-size: 0.9rem; color: #111; font-weight: 500;">{{ $item->annonce->titre }}</span>
                            </div>
                            <span style="font-weight: 700; color: #111; font-size: 0.9rem;">{{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Resolution Card -->
            <div style="background: #fff; border: 1px solid {{ $litige->statut === 'en_cours' ? '#adb1b8' : '#bbf7d0' }}; padding: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); {{ $litige->statut === 'en_cours' ? 'border-top: 4px solid #004aad;' : 'background: #f0fdf4;' }}">
                @if($litige->statut === 'en_cours')
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: #111; margin-bottom: 20px;">Décision & Résolution Administrative</h2>
                    <form action="{{ route('admin.litiges.resolve', $litige) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #444; margin-bottom: 8px;">Solution Proposée / Verdict</label>
                            <textarea name="resolution" rows="5" 
                                style="width: 100%; padding: 12px; border: 1px solid #adb1b8; border-radius: 3px; font-family: inherit; font-size: 0.9rem; outline: none; transition: border-color 0.2s;"
                                onfocus="this.style.borderColor='#004aad'; this.style.boxShadow='0 0 0 1px #004aad'"
                                onblur="this.style.borderColor='#adb1b8'; this.style.boxShadow='none'"
                                placeholder="Expliquez la décision finale (ex: Remboursement validé, Réclamation rejetée...)" required></textarea>
                        </div>

                        <div style="margin-bottom: 25px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #444; margin-bottom: 8px;">Mise à jour du Statut</label>
                                <select name="statut" style="width: 100%; padding: 10px; border: 1px solid #adb1b8; border-radius: 3px; background: #fff; outline: none; cursor: pointer;">
                                    <option value="resolu">Résolu - Favorable au Signalant</option>
                                    <option value="ferme">Fermé - Rejeté / Sans suite</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" 
                            style="width: 100%; background: linear-gradient(to bottom, #f7dfa5, #f0c14b); border: 1px solid #a88734; border-radius: 3px; padding: 12px; font-weight: 600; color: #111; cursor: pointer; box-shadow: 0 1px 0 rgba(255,255,255,.4) inset;"
                            onmouseover="this.style.background='linear-gradient(to bottom, #f5d78e, #eeb933)'; this.style.borderColor='#846a29'"
                            onmouseout="this.style.background='linear-gradient(to bottom, #f7dfa5, #f0c14b)'; this.style.borderColor='#a88734'">
                            Valider et clôturer le litige
                        </button>
                    </form>
                @else
                    <h2 style="font-size: 1.1rem; font-weight: 700; color: #166534; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-check-circle"></i> Litige Clôturé ({{ ucfirst($litige->statut) }})
                    </h2>
                    <div style="padding: 20px; background: #fff; border: 1px solid #bbf7d0; border-radius: 4px;">
                        <div style="font-size: 0.7rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 10px;">Décision de l'Administrateur</div>
                        <div style="font-size: 0.95rem; color: #333; line-height: 1.6;">
                            {{ $litige->resolution }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Parties Prenantes -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            
            <!-- Reporter -->
            <div style="background: #fff; border: 1px solid #e7e7e7; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h3 style="font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid #f1f1f1; padding-bottom: 10px;">Signalé par (Demandeur)</h3>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; color: #004aad; border: 1px solid #e7e7e7;">
                        {{ substr($litige->reporter->prenom, 0, 1) }}{{ substr($litige->reporter->nom, 0, 1) }}
                    </div>
                    <div>
                        <div style="font-weight: 700; color: #111; font-size: 0.95rem;">{{ $litige->reporter->prenom }} {{ $litige->reporter->nom }}</div>
                        <div style="font-size: 0.8rem; color: #666;">{{ $litige->reporter->email }}</div>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}?search={{ $litige->reporter->email }}" style="display: block; margin-top: 15px; text-align: center; font-size: 0.75rem; color: #004aad; font-weight: 600; text-decoration: none; padding: 8px; border: 1px solid #adb1b8; border-radius: 3px; background: #f7f8fa;">
                    Voir profil utilisateur
                </a>
            </div>

            <!-- Reported -->
            <div style="background: #fff; border: 1px solid #e7e7e7; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h3 style="font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid #f1f1f1; padding-bottom: 10px;">Contre (Défendeur)</h3>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 700; color: #dc2626; border: 1px solid #e7e7e7;">
                        {{ substr($litige->reported->prenom, 0, 1) }}{{ substr($litige->reported->nom, 0, 1) }}
                    </div>
                    <div>
                        <div style="font-weight: 700; color: #111; font-size: 0.95rem;">{{ $litige->reported->prenom }} {{ $litige->reported->nom }}</div>
                        <div style="font-size: 0.8rem; color: #666;">{{ $litige->reported->email }}</div>
                    </div>
                </div>
                <a href="{{ route('admin.users.index') }}?search={{ $litige->reported->email }}" style="display: block; margin-top: 15px; text-align: center; font-size: 0.75rem; color: #004aad; font-weight: 600; text-decoration: none; padding: 8px; border: 1px solid #adb1b8; border-radius: 3px; background: #f7f8fa;">
                    Voir profil utilisateur
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
