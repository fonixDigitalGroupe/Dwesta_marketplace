@extends('layouts.admin')

@section('title', 'Détails du Litige #' . $litige->id)

@push('styles')
<style>.main-content { background-color: #f8f9fa !important; }</style>
@endpush

@section('content')
<div style="max-width: 1500px; margin: -50px auto 0;">
  <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

    <!-- Header -->
    <div style="margin-bottom: 1.5rem; border-bottom: 1px solid #eff3f6; padding-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-gavel" style="color: #475569;"></i>
            <div>
                <h1 style="font-size: 1.2rem; color: #111; font-weight: 700; margin: 0;">Litige #{{ $litige->id }}</h1>
                <p style="font-size: 0.82rem; color: #666; margin: 2px 0 0;">Signalé le {{ $litige->created_at->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
        <a href="{{ route('admin.litiges.index') }}"
           style="font-size: 0.82rem; color: #004aad; text-decoration: none; font-weight: 600;">
            &larr; Retour à la liste
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 24px; align-items: start;">
        
        <!-- Left Column: Details & Resolution -->
        <div style="display: flex; flex-direction: column; gap: 25px;">

            @php
                $rid = $litige->reporter->id ?? null;
                if ($litige->order && $litige->order->seller && $litige->order->seller->user_id === $rid) {
                    $roleSignaleur = 'Vendeur';
                } elseif ($litige->order && $litige->order->user_id === $rid) {
                    $roleSignaleur = 'Client';
                } else {
                    $roleSignaleur = 'Agence';
                }
            @endphp

            <!-- Signalé par (Demandeur) -->
            <div style="background: #fff; border: 1px solid #e7e7e7; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h3 style="font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid #f1f1f1; padding-bottom: 10px;">Signalé par ({{ $roleSignaleur }})</h3>
                <div style="display: flex; align-items: center; gap: 15px;">
                    @php
                        $roleIcon = match($roleSignaleur) {
                            'Vendeur' => 'fa-shopping-cart',
                            'Client'  => 'fa-user',
                            'Agence'  => 'fa-building',
                            default   => 'fa-user',
                        };
                    @endphp
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #004aad; border: 1px solid #e7e7e7;">
                        <i class="fas {{ $roleIcon }}"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: #111; font-size: 0.95rem;">{{ $litige->reporter->prenom }} {{ $litige->reporter->nom }}</div>
                        <div style="font-size: 0.8rem; color: #666;">{{ $litige->reporter->email }}</div>
                    </div>
                </div>

                @if(in_array($roleSignaleur, ['Vendeur', 'Client']))
                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #f1f1f1; display: grid; grid-template-columns: 1fr 1fr; gap: 10px 20px;">
                        <div>
                            <div style="font-size: 0.68rem; font-weight: 700; color: #888; text-transform: uppercase;">Téléphone</div>
                            <div style="font-size: 0.85rem; color: #111;">{{ $litige->reporter->telephone ?? '—' }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.68rem; font-weight: 700; color: #888; text-transform: uppercase;">Pays</div>
                            <div style="font-size: 0.85rem; color: #111;">{{ $litige->reporter->nationalite ?? $litige->reporter->pays ?? '—' }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.68rem; font-weight: 700; color: #888; text-transform: uppercase;">Région</div>
                            <div style="font-size: 0.85rem; color: #111;">{{ $litige->reporter->region ?? '—' }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.68rem; font-weight: 700; color: #888; text-transform: uppercase;">Ville</div>
                            <div style="font-size: 0.85rem; color: #111;">{{ $litige->reporter->ville ?? '—' }}</div>
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <div style="font-size: 0.68rem; font-weight: 700; color: #888; text-transform: uppercase;">Adresse</div>
                            <div style="font-size: 0.85rem; color: #111;">{{ $litige->reporter->adresse ?? '—' }}</div>
                        </div>
                    </div>
                @endif
            </div>

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
                    <div style="margin-top: 10px; padding: 20px; background: #fff; border: 1px solid #e7e7e7; border-radius: 4px; font-size: 0.95rem; color: #333; line-height: 1.6;">
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
                
                @php
                    $o = $litige->order;
                    $estCod = in_array($o->gestion_paiement, ['livraison_buyer', 'livraison_receiver']) || $o->moyen_paiement === 'cod';
                    $paiementLabel = $estCod ? 'Paiement à la livraison'
                        : match($o->moyen_paiement) {
                            'cb' => 'Carte Bancaire', 'om' => 'Orange Money', 'wave' => 'Wave',
                            'gift_card' => 'Carte Cadeau', 'wallet' => 'Portefeuille',
                            default => ucfirst(str_replace('_', ' ', $o->moyen_paiement ?? 'Non renseigné')),
                        };
                @endphp
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 20px;">
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 5px;">Référence</div>
                        <div style="font-weight: 700; color: #004aad; font-size: 1rem;">#{{ $o->reference }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 5px;">Montant Total</div>
                        <div style="font-weight: 700; color: #111; font-size: 1rem;">{{ number_format($o->total_final, 0, ',', ' ') }} FCFA</div>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 5px;">Statut</div>
                        <div>
                            <span style="font-size: 0.7rem; color: #004aad; background: #f0f7ff; padding: 2px 8px; border-radius: 4px; font-weight: 700; text-transform: uppercase; border: 1px solid #cce3ff;">
                                {{ $o->statut_label ?? $o->statut }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 5px;">Mode de paiement</div>
                        <div style="font-weight: 600; color: #111; font-size: 0.9rem;">{{ $paiementLabel }} @if($paidOnline)<span style="color:#16a34a; font-size:0.72rem;">(payé en ligne)</span>@endif</div>
                        @if(!empty($cardInfo) && $cardInfo['last4'])
                            <div style="margin-top: 6px; display: inline-flex; align-items: center; gap: 6px; background: #f8fafc; border: 1px solid #e5e7eb; border-radius: 6px; padding: 4px 10px; font-size: 0.8rem; color: #111;">
                                <i class="fas fa-credit-card" style="color: #64748b;"></i>
                                {{ ucfirst($cardInfo['brand'] ?? 'Carte') }} •••• {{ $cardInfo['last4'] }}
                                @if($cardInfo['refunded'])
                                    <span style="color:#16a34a; font-weight:700; font-size:0.72rem;">· Remboursé</span>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 5px;">Mode de livraison</div>
                        <div style="font-weight: 600; color: #111; font-size: 0.9rem;">{{ ucfirst(str_replace('_', ' ', $o->mode_livraison ?? '-')) }}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 5px;">Commission plateforme</div>
                        <div style="font-weight: 600; color: #c40000; font-size: 0.9rem;">{{ number_format($o->commission_plateforme ?? 0, 0, ',', ' ') }} FCFA</div>
                    </div>
                </div>

                <div style="overflow-x: auto; border: 1px solid #e7e7e7; border-radius: 4px;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.85rem;">
                        <thead>
                            <tr style="background: #f0f2f2;">
                                <th style="padding: 9px 12px; text-align: left; font-size: 0.7rem; text-transform: uppercase; color: #555; border-bottom: 1px solid #e0e0e0; width: 60px;">Image</th>
                                <th style="padding: 9px 12px; text-align: left; font-size: 0.7rem; text-transform: uppercase; color: #555; border-bottom: 1px solid #e0e0e0;">Nom</th>
                                <th style="padding: 9px 12px; text-align: center; font-size: 0.7rem; text-transform: uppercase; color: #555; border-bottom: 1px solid #e0e0e0;">Qté</th>
                                <th style="padding: 9px 12px; text-align: right; font-size: 0.7rem; text-transform: uppercase; color: #555; border-bottom: 1px solid #e0e0e0;">Prix unitaire</th>
                                <th style="padding: 9px 12px; text-align: right; font-size: 0.7rem; text-transform: uppercase; color: #555; border-bottom: 1px solid #e0e0e0;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($litige->order->items as $item)
                                @php $photo = $item->annonce?->photoPrincipale(); @endphp
                                <tr style="border-bottom: 1px solid #f0f0f0;">
                                    <td style="padding: 10px 12px;">
                                        <div style="width: 44px; height: 44px; border: 1px solid #eee; border-radius: 6px; background: #fafafa; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                            @if($photo)
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($photo->chemin) }}" alt="" style="width: 100%; height: 100%; object-fit: contain;">
                                            @else
                                                <i class="fa-regular fa-image" style="color: #ccc;"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="padding: 10px 12px; color: #111;">
                                        <div style="font-weight: 500;">{{ $item->annonce->titre ?? 'Article' }}</div>
                                        @if($item->annonce)
                                            <a href="{{ route('annonces.show', $item->annonce->slug) }}" target="_blank" style="font-size: 0.75rem; color: #004aad; text-decoration: none; font-weight: 600;">Voir le détail <i class="fas fa-external-link-alt" style="font-size: 0.65rem;"></i></a>
                                        @endif
                                    </td>
                                    <td style="padding: 10px 12px; text-align: center; font-weight: 600;">{{ $item->quantite }}</td>
                                    <td style="padding: 10px 12px; text-align: right;">{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                    <td style="padding: 10px 12px; text-align: right; font-weight: 700;">{{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Historique / suivi de la commande --}}
                @php
                    $estCodH = in_array($o->gestion_paiement, ['livraison_buyer', 'livraison_receiver']) || $o->moyen_paiement === 'cod';
                    if ($estCodH) {
                        $steps = [
                            'en_attente' => 'Commande confirmée',
                            'pret_expedition' => 'Prêt pour expédition',
                            'en_route' => 'En cours de livraison',
                            'disponible' => 'Disponible au point relais',
                            'livre' => 'Livré',
                        ];
                    } else {
                        $steps = [
                            'en_attente' => 'En attente de paiement',
                            'paye' => 'Payé — À préparer',
                            'pret_expedition' => 'Prêt pour expédition',
                            'en_route' => 'En cours de livraison',
                            'disponible' => 'Disponible au point relais',
                            'livre' => 'Livré',
                        ];
                    }
                    $stKeys = array_keys($steps);
                    $curIdx = array_search($o->statut, $stKeys);
                @endphp
                <div style="margin-top: 20px; padding-top: 18px; border-top: 1px solid #f1f1f1;">
                    <div style="font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 14px;">Historique de la commande</div>
                    <div style="display: flex; flex-direction: column; gap: 0;">
                        @foreach($steps as $key => $label)
                            @php
                                $done = $curIdx !== false && array_search($key, $stKeys) < $curIdx;
                                $current = $o->statut === $key;
                            @endphp
                            <div style="display: flex; align-items: center; gap: 12px; padding: 6px 0;">
                                <span style="width: 14px; height: 14px; border-radius: 50%; flex-shrink: 0; background: {{ $done ? '#16a34a' : ($current ? '#f68b1e' : '#fff') }}; border: 2px solid {{ $done ? '#16a34a' : ($current ? '#f68b1e' : '#d1d5db') }};"></span>
                                <span style="font-size: 0.88rem; color: {{ $done || $current ? '#111' : '#9ca3af' }}; font-weight: {{ $current ? '700' : '500' }};">{{ $label }}</span>
                            </div>
                        @endforeach
                        @if(in_array($o->statut, ['annule', 'litige']))
                            <div style="display: flex; align-items: center; gap: 12px; padding: 6px 0;">
                                <span style="width: 14px; height: 14px; border-radius: 50%; flex-shrink: 0; background: #dc2626; border: 2px solid #dc2626;"></span>
                                <span style="font-size: 0.88rem; color: #991b1b; font-weight: 700;">{{ $o->statut === 'litige' ? 'Litige en cours' : 'Annulée' }}</span>
                            </div>
                        @endif
                    </div>
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

                        <div style="margin-bottom: 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #444; margin-bottom: 8px;">Mise à jour du Statut</label>
                                <select name="statut" style="width: 100%; padding: 10px; border: 1px solid #adb1b8; border-radius: 3px; background: #fff; outline: none; cursor: pointer;">
                                    <option value="resolu">Résolu - Favorable au Signalant</option>
                                    <option value="ferme">Fermé - Rejeté / Sans suite</option>
                                </select>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #444; margin-bottom: 8px;">Action financière</label>
                                <select name="action_financiere" style="width: 100%; padding: 10px; border: 1px solid #adb1b8; border-radius: 3px; background: #fff; outline: none; cursor: pointer;">
                                    <option value="aucune">Aucune</option>
                                    <option value="retour_vendeur">Retour au vendeur (rembourser le client si payé en ligne)</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-bottom: 25px; font-size: 0.8rem; color: #666; background: #f9fafb; border: 1px solid #eee; border-radius: 4px; padding: 10px 14px; line-height: 1.5;">
                            <strong>Retour au vendeur :</strong>
                            @if($paidOnline)
                                le client a payé en ligne → il sera <strong>remboursé</strong> et le montant sera <strong>déduit du vendeur</strong>. La commande passera en « annulée ».
                            @else
                                le client n'a <strong>pas encore payé</strong> (paiement à la livraison) → <strong>aucun remboursement</strong>, la commande sera simplement annulée.
                            @endif
                        </div>

                        <button type="submit"
                            style="width: 100%; background: #004aad; border: none; border-radius: 6px; padding: 12px; font-weight: 700; color: #fff; cursor: pointer; transition: background 0.2s;"
                            onmouseover="this.style.background='#003a8a'"
                            onmouseout="this.style.background='#004aad'">
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

            <!-- Reported -->
            @php
                $rdid = $litige->reported->id ?? null;
                if ($litige->order && $litige->order->seller && $litige->order->seller->user_id === $rdid) {
                    $roleDefendeur = 'Vendeur';
                } elseif ($litige->order && $litige->order->user_id === $rdid) {
                    $roleDefendeur = 'Client';
                } else {
                    $roleDefendeur = 'Agence';
                }
                $roleIconD = match($roleDefendeur) {
                    'Vendeur' => 'fa-shopping-cart',
                    'Client'  => 'fa-user',
                    'Agence'  => 'fa-building',
                    default   => 'fa-user',
                };
            @endphp
            <div style="background: #fff; border: 1px solid #e7e7e7; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <h3 style="font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid #f1f1f1; padding-bottom: 10px;">Contre ({{ $roleDefendeur }})</h3>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="width: 50px; height: 50px; border-radius: 50%; background: #fdeeee; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: #dc2626; border: 1px solid #f7d5d5;">
                        <i class="fas {{ $roleIconD }}"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; color: #111; font-size: 0.95rem;">{{ $litige->reported->prenom }} {{ $litige->reported->nom }}</div>
                        <div style="font-size: 0.8rem; color: #666;">{{ $litige->reported->email }}</div>
                    </div>
                </div>

                @if(in_array($roleDefendeur, ['Vendeur', 'Client']))
                    <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #f1f1f1; display: grid; grid-template-columns: 1fr 1fr; gap: 10px 20px;">
                        <div>
                            <div style="font-size: 0.68rem; font-weight: 700; color: #888; text-transform: uppercase;">Téléphone</div>
                            <div style="font-size: 0.85rem; color: #111;">{{ $litige->reported->telephone ?? '—' }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.68rem; font-weight: 700; color: #888; text-transform: uppercase;">Pays</div>
                            <div style="font-size: 0.85rem; color: #111;">{{ $litige->reported->nationalite ?? $litige->reported->pays ?? '—' }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.68rem; font-weight: 700; color: #888; text-transform: uppercase;">Région</div>
                            <div style="font-size: 0.85rem; color: #111;">{{ $litige->reported->region ?? '—' }}</div>
                        </div>
                        <div>
                            <div style="font-size: 0.68rem; font-weight: 700; color: #888; text-transform: uppercase;">Ville</div>
                            <div style="font-size: 0.85rem; color: #111;">{{ $litige->reported->ville ?? '—' }}</div>
                        </div>
                        <div style="grid-column: 1 / -1;">
                            <div style="font-size: 0.68rem; font-weight: 700; color: #888; text-transform: uppercase;">Adresse</div>
                            <div style="font-size: 0.85rem; color: #111;">{{ $litige->reported->adresse ?? '—' }}</div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Parties de la commande : toujours Client puis Vendeur (même si répétition) --}}
            @if($litige->order)
                @php $ven = $litige->order->seller?->user; @endphp
                @if($ven)
                    <div style="background: #fff; border: 1px solid #e7e7e7; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <h3 style="font-size: 0.75rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 15px; border-bottom: 1px solid #f1f1f1; padding-bottom: 10px;">Vendeur</h3>
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="width: 46px; height: 46px; border-radius: 50%; background: #fff8f0; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: #f68b1e; border: 1px solid #fde3c4;"><i class="fas fa-shopping-cart"></i></div>
                            <div>
                                <div style="font-weight: 700; color: #111; font-size: 0.95rem;">{{ $ven->prenom }} {{ $ven->nom }}</div>
                                <div style="font-size: 0.8rem; color: #666;">{{ $ven->email }}</div>
                            </div>
                        </div>
                        <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #f1f1f1; font-size: 0.82rem; color: #333; line-height: 1.7;">
                            <div><span style="color:#888;">Tél :</span> {{ $ven->telephone ?? '—' }}</div>
                            <div><span style="color:#888;">Pays :</span> {{ $ven->nationalite ?? $ven->pays ?? '—' }} · <span style="color:#888;">Région :</span> {{ $ven->region ?? '—' }}</div>
                            <div><span style="color:#888;">Adresse :</span> {{ $ven->adresse ?? '—' }}</div>
                        </div>
                    </div>
                @endif
            @endif

        </div>

    </div>

  </div>
</div>
@endsection
