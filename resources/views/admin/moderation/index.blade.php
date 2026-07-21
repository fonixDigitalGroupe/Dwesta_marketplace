@extends('layouts.admin')

@section('title', 'Modération')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }

        select:focus, input:focus, textarea:focus { border-color: #adb1b8 !important; outline: none; }

        .mod-tab {
            padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: #555;
            font-weight: 400; border-bottom: 2px solid transparent; background: none;
            border-top: none; border-left: none; border-right: none; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
        }
        .mod-tab.active { color: #c45500; font-weight: 700; border-bottom-color: #c45500; }
        .mod-tab .mod-pill {
            background: #fff8f3; border: 1px solid #fbd8b4; color: #c45500;
            padding: 0 6px; border-radius: 10px; font-size: 0.75rem;
        }

        .mod-action-btn {
            font-size: 0.8rem; text-decoration: none; font-weight: 600; border: none;
            padding: 2px 8px; border-radius: 2px; cursor: pointer;
        }
        .mod-icon-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 34px; height: 34px; border-radius: 6px; color: #111;
            text-decoration: none; transition: background 0.2s;
        }
        .mod-icon-btn:hover { background: #f3f4f6; }
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;"
     x-data="{ tab: '{{ $avisEnAttente->count() || !$signalements->count() ? 'avis' : 'signalements' }}', detailOpen: false, detail: {} }">

    <!-- Main Conteneur style Amazon Card -->
    <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px; margin-top: -50px;">

        <!-- Top Action Bar -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eff3f6;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-shield-alt" style="font-size: 0.8rem;"></i>
                <span style="line-height: 1;">Modération</span>
            </div>
        </div>

        @if(session('success'))
            <div style="background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 0.85rem;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 0.85rem;">
                {{ session('error') }}
            </div>
        @endif

        <!-- Statistiques -->
        <div style="display: flex; gap: 14px; margin-bottom: 20px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #f59e0b; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-star"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $avisEnAttenteCount }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Avis en attente</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #fff1f2; border: 1px solid #ffe4e6; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #f43f5e; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-flag"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $signalementsNouveauCount }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Annonces signalées</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 180px; display: flex; align-items: center; gap: 12px; background: #ecfdf5; border: 1px solid #d1fae5; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff; color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $signalementsTraiteCount }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Signalements traités</div>
                </div>
            </div>
        </div>

        <!-- Tabs (Amazon Style) -->
        <div style="display: flex; gap: 20px; border-bottom: 1px solid #f0f0f0; margin-bottom: 20px;">
            <button class="mod-tab" :class="{ 'active': tab === 'avis' }" @click="tab = 'avis'">
                Avis en attente
                @if($avisEnAttenteCount > 0)<span class="mod-pill">{{ $avisEnAttenteCount }}</span>@endif
            </button>
            <button class="mod-tab" :class="{ 'active': tab === 'signalements' }" @click="tab = 'signalements'">
                Annonces signalées
                @if($signalementsNouveauCount > 0)<span class="mod-pill">{{ $signalementsNouveauCount }}</span>@endif
            </button>
        </div>

        {{-- ===================== AVIS ===================== --}}
        <div x-show="tab === 'avis'" x-cloak>
            <div style="border: 1px solid #e7e7e7; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                            <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Client / Avis</th>
                            <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 220px;">Annonce</th>
                            <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 110px;">Note</th>
                            <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 130px;">Date</th>
                            <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($avisEnAttente as $avis)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                                <div style="font-weight: 700; font-size: 0.85rem; color: #111; margin-bottom: 2px;">{{ $avis->user->prenom }} {{ $avis->user->nom ?? '' }}</div>
                                <div style="font-size: 0.8rem; color: #555; line-height: 1.4;">{{ \Illuminate\Support\Str::limit($avis->commentaire, 120) }}</div>
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                                <a href="{{ route('annonces.show', $avis->annonce) }}" target="_blank" style="color: #0066c0; text-decoration: none; font-size: 0.85rem;">{{ $avis->annonce->titre }}</a>
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7; white-space: nowrap;">
                                <span style="color: #f59e0b; font-size: 0.9rem;">
                                    @for($i = 1; $i <= 5; $i++){{ $i <= $avis->note ? '★' : '☆' }}@endfor
                                </span>
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7; font-size: 0.8rem; color: #555;">
                                {{ $avis->created_at->format('d/m/Y') }}
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                    <form action="{{ route('admin.avis.approve', $avis) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="mod-action-btn" style="color: #569b00; background: #f7fff0;">Approuver</button>
                                    </form>
                                    <span style="color: #ddd;">|</span>
                                    <form action="{{ route('admin.avis.reject', $avis) }}" method="POST" style="display: inline;" class="avis-reject-form">
                                        @csrf
                                        <input type="hidden" name="raison_rejet" class="avis-reject-reason">
                                        <button type="button" class="mod-action-btn" style="color: #c40000; background: #fff5f5;"
                                            onclick="confirmAvisRejection(this)">Rejeter</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding: 60px; text-align: center; color: #888;">
                                <i class="fas fa-star" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.2;"></i>
                                <p>Aucun avis en attente de modération.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($avisEnAttente->total() > 0)
            <div style="margin-top: 15px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        Affichage de {{ $avisEnAttente->firstItem() ?? 0 }} à {{ $avisEnAttente->lastItem() ?? 0 }} sur {{ $avisEnAttente->total() }} résultats
                    </div>
                    <div style="display: flex; border: 1px solid #adb1b8; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                        @if ($avisEnAttente->onFirstPage())
                            <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                        @else
                            <a href="{{ $avisEnAttente->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                        @endif
                        @if ($avisEnAttente->hasMorePages())
                            <a href="{{ $avisEnAttente->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- ================= SIGNALEMENTS ================= --}}
        <div x-show="tab === 'signalements'" x-cloak>
            @if(!($signalementsTablePresente ?? true))
                <div style="background: #fffbeb; color: #92400e; border: 1px solid #fde68a; padding: 12px 16px; border-radius: 6px; margin-bottom: 16px; font-size: 0.85rem;">
                    <i class="fas fa-exclamation-triangle"></i>
                    La table des signalements n'est pas encore créée en base. Lancez la migration
                    (<code>php artisan migrate --force</code>) sur le serveur pour activer cette section.
                </div>
            @endif

            <div style="border: 1px solid #e7e7e7; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                            <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Annonce / Motif</th>
                            <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 180px;">Vendeur</th>
                            <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 210px;">Signalé par</th>
                            <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 110px;">Date</th>
                            <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($signalements as $signalement)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                                <div style="margin-bottom: 4px;">
                                    <span style="font-size: 0.72rem; color: #b91c1c; background: #fee2e2; padding: 2px 8px; border-radius: 12px; font-weight: 700;">{{ $signalement->motif_libelle }}</span>
                                </div>
                                @if($signalement->annonce)
                                    <a href="{{ route('annonces.show', $signalement->annonce) }}" target="_blank" style="color: #0066c0; text-decoration: none; font-size: 0.85rem; font-weight: 700;">{{ $signalement->annonce->titre }}</a>
                                @else
                                    <span style="color: #94a3b8; font-size: 0.85rem;">(annonce supprimée)</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7; font-size: 0.82rem; color: #333;">
                                @php $vendeurUser = $signalement->annonce?->vendeur?->user; @endphp
                                @if($vendeurUser)
                                    <div style="font-weight: 700; color: #111;">{{ $vendeurUser->prenom }} {{ $vendeurUser->nom ?? '' }}</div>
                                    <div style="color: #555;">{{ ucfirst($signalement->annonce->vendeur->type ?? '') }}</div>
                                @else
                                    <span style="color: #94a3b8;">—</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7; font-size: 0.82rem; color: #333;">
                                @if($signalement->reporter)
                                    <div style="font-weight: 700; color: #111;">{{ $signalement->reporter->prenom }} {{ $signalement->reporter->nom ?? '' }}</div>
                                    <div style="color: #555;">{{ $signalement->reporter->email }}</div>
                                @elseif($signalement->email)
                                    <div>{{ $signalement->email }}</div>
                                    <div style="color: #94a3b8;">Visiteur</div>
                                @else
                                    <span style="color: #94a3b8;">Visiteur anonyme</span>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7; font-size: 0.8rem; color: #555;">
                                {{ $signalement->created_at->format('d/m/Y') }}
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                @php
                                    $repLabel = $signalement->reporter
                                        ? trim($signalement->reporter->prenom . ' ' . ($signalement->reporter->nom ?? '')) . ' (' . $signalement->reporter->email . ')'
                                        : ($signalement->email ? $signalement->email . ' (visiteur)' : 'Visiteur anonyme');
                                    $detailData = [
                                        'titre'   => $signalement->annonce->titre ?? '(annonce supprimée)',
                                        'url'     => $signalement->annonce ? route('annonces.show', $signalement->annonce) : '',
                                        'motif'   => $signalement->motif_libelle,
                                        'message' => $signalement->description ?: '(aucun message fourni)',
                                        'reporter'=> $repLabel,
                                        'date'    => $signalement->created_at->format('d/m/Y à H:i'),
                                    ];
                                @endphp
                                <div style="display: flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                    <button type="button" title="Détail" class="mod-icon-btn"
                                        @click="detail = @js($detailData); detailOpen = true"><i class="fas fa-eye" style="font-size: 0.95rem;"></i></button>
                                    @if($vendeurUser)
                                        <a href="{{ route('admin.messagerie.index', ['compose' => 1, 'to' => $vendeurUser->id, 'article' => $signalement->annonce->id]) }}" title="Envoyer un message au vendeur" class="mod-icon-btn"><i class="fas fa-paper-plane" style="font-size: 0.9rem;"></i></a>
                                    @endif
                                    <span style="color: #ddd;">|</span>
                                    <form action="{{ route('admin.moderation.signalements.traiter', $signalement) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="mod-action-btn" style="color: #569b00; background: #f7fff0;">Traité</button>
                                    </form>
                                    <span style="color: #ddd;">|</span>
                                    <form action="{{ route('admin.moderation.signalements.rejeter', $signalement) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="mod-action-btn" style="color: #555; background: #f1f5f9;">Ignorer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="padding: 60px; text-align: center; color: #888;">
                                <i class="fas fa-flag" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.2;"></i>
                                <p>Aucune annonce signalée.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($signalements->total() > 0)
            <div style="margin-top: 15px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0;">
                    <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                        Affichage de {{ $signalements->firstItem() ?? 0 }} à {{ $signalements->lastItem() ?? 0 }} sur {{ $signalements->total() }} résultats
                    </div>
                    <div style="display: flex; border: 1px solid #adb1b8; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                        @if ($signalements->onFirstPage())
                            <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                        @else
                            <a href="{{ $signalements->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                        @endif
                        @if ($signalements->hasMorePages())
                            <a href="{{ $signalements->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                        @else
                            <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

    </div>

    {{-- Modal Détail signalement --}}
    <template x-teleport="body">
        <div x-show="detailOpen" x-cloak x-transition.opacity @keydown.escape.window="detailOpen = false"
            style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 3000; display: flex; align-items: center; justify-content: center; padding: 1rem;">
            <div @click.outside="detailOpen = false"
                style="background:#fff; border-radius:12px; width:100%; max-width:520px; box-shadow:0 20px 50px rgba(0,0,0,0.25); overflow:hidden;">
                <div style="display:flex; align-items:center; justify-content:space-between; padding:1.1rem 1.5rem; border-bottom:1px solid #f0f0f0;">
                    <h3 style="margin:0; font-size:1.05rem; font-weight:700; color:#111; display:flex; align-items:center; gap:0.5rem;">
                        <i class="fas fa-flag" style="color:#dc2626;"></i> Détail du signalement
                    </h3>
                    <button type="button" @click="detailOpen=false" style="background:none;border:none;cursor:pointer;color:#9ca3af;font-size:1.1rem;"><i class="fas fa-times"></i></button>
                </div>
                <div style="padding:1.25rem 1.5rem;">
                    <div style="margin-bottom:14px;">
                        <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.03em; color:#94a3b8; font-weight:700; margin-bottom:3px;">Produit signalé</div>
                        <a x-show="detail.url" :href="detail.url" target="_blank" x-text="detail.titre" style="color:#0066c0; text-decoration:none; font-weight:700; font-size:0.95rem;"></a>
                        <span x-show="!detail.url" x-text="detail.titre" style="color:#94a3b8; font-weight:700;"></span>
                    </div>
                    <div style="margin-bottom:14px;">
                        <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.03em; color:#94a3b8; font-weight:700; margin-bottom:3px;">Motif</div>
                        <span x-text="detail.motif" style="font-size:0.72rem; color:#b91c1c; background:#fee2e2; padding:2px 8px; border-radius:12px; font-weight:700;"></span>
                    </div>
                    <div style="margin-bottom:14px;">
                        <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.03em; color:#94a3b8; font-weight:700; margin-bottom:3px;">Message</div>
                        <p x-text="detail.message" style="margin:0; background:#f8fafc; border:1px solid #eef2f6; border-radius:8px; padding:10px 12px; color:#374151; font-size:0.88rem; line-height:1.6; white-space:pre-wrap;"></p>
                    </div>
                    <div style="display:flex; gap:24px;">
                        <div>
                            <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.03em; color:#94a3b8; font-weight:700; margin-bottom:3px;">Signalé par</div>
                            <div x-text="detail.reporter" style="font-size:0.85rem; color:#374151;"></div>
                        </div>
                        <div>
                            <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.03em; color:#94a3b8; font-weight:700; margin-bottom:3px;">Date</div>
                            <div x-text="detail.date" style="font-size:0.85rem; color:#374151;"></div>
                        </div>
                    </div>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:0.6rem; padding:1rem 1.5rem; border-top:1px solid #f0f0f0; background:#fafafa;">
                    <a x-show="detail.url" :href="detail.url" target="_blank" style="color:#fff; background:#111; padding:8px 14px; border-radius:6px; font-size:0.85rem; font-weight:600; text-decoration:none;"><i class="fas fa-eye"></i> Voir le produit</a>
                    <button type="button" @click="detailOpen=false" style="padding:8px 14px; border:1px solid #d1d5db; background:#fff; color:#374151; border-radius:6px; font-size:0.85rem; font-weight:600; cursor:pointer;">Fermer</button>
                </div>
            </div>
        </div>
    </template>
</div>

@push('scripts')
<script>
    function confirmAvisRejection(btn) {
        const form = btn.closest('form');
        Swal.fire({
            title: 'Rejeter cet avis',
            input: 'textarea',
            inputPlaceholder: 'Motif du rejet (obligatoire)...',
            inputAttributes: { style: 'height: 100px;' },
            showCancelButton: true,
            confirmButtonText: 'Confirmer le rejet',
            cancelButtonText: 'Annuler',
            reverseButtons: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6c757d',
            preConfirm: (value) => {
                if (!value || value.trim() === '') {
                    Swal.showValidationMessage('Veuillez indiquer un motif de rejet.');
                    return false;
                }
                return value;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.querySelector('.avis-reject-reason').value = result.value;
                form.submit();
            }
        });
    }
</script>
@endpush
@endsection
