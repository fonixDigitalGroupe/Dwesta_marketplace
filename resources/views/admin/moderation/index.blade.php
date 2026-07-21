@extends('layouts.admin')

@section('title', 'Modération')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }

        .mod-tab {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 10px 18px; font-size: 0.85rem; font-weight: 600;
            color: #64748b; background: transparent; border: none; cursor: pointer;
            border-bottom: 2px solid transparent; transition: all 0.2s;
        }
        .mod-tab:hover { color: #1e293b; }
        .mod-tab.active { color: #111; border-bottom-color: #dc2626; }
        .mod-count {
            font-size: 0.7rem; font-weight: 700; padding: 1px 7px; border-radius: 10px;
            background: #fee2e2; color: #b91c1c;
        }
        .mod-badge {
            font-size: 0.72rem; font-weight: 700; padding: 2px 9px; border-radius: 12px;
            display: inline-block;
        }
        .mod-btn {
            border: none; padding: 7px 14px; border-radius: 6px; font-size: 0.8rem;
            font-weight: 600; cursor: pointer; color: #fff; display: inline-flex;
            align-items: center; gap: 6px; text-decoration: none; transition: opacity 0.2s;
        }
        .mod-btn:hover { opacity: 0.9; }
    </style>
@endpush

@section('content')
    <div style="max-width: 1200px; margin: 0 auto; width: 100%;"
         x-data="{ tab: '{{ $avisEnAttente->count() || !$signalements->count() ? 'avis' : 'signalements' }}' }">

        <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                <i class="fas fa-shield-alt" style="color: #dc2626;"></i>
                <h1 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #111;">Modération</h1>
            </div>
            <p style="color: #64748b; font-size: 0.85rem; margin: 0 0 16px;">
                Gérez les avis clients en attente et les annonces signalées par les utilisateurs.
            </p>

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

            <!-- Tabs -->
            <div style="display: flex; gap: 8px; border-bottom: 1px solid #eff3f6; margin-bottom: 20px;">
                <button class="mod-tab" :class="{ 'active': tab === 'avis' }" @click="tab = 'avis'">
                    <i class="fas fa-star"></i> Avis en attente
                    @if($avisEnAttente->total() > 0)<span class="mod-count">{{ $avisEnAttente->total() }}</span>@endif
                </button>
                <button class="mod-tab" :class="{ 'active': tab === 'signalements' }" @click="tab = 'signalements'">
                    <i class="fas fa-flag"></i> Annonces signalées
                    @if($signalements->total() > 0)<span class="mod-count">{{ $signalements->total() }}</span>@endif
                </button>
            </div>

            {{-- ===================== AVIS ===================== --}}
            <div x-show="tab === 'avis'" x-cloak>
                @forelse($avisEnAttente as $avis)
                    <div style="padding: 18px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #f59e0b; margin-bottom: 14px;">
                        <div style="display: grid; grid-template-columns: 1fr auto; gap: 24px; align-items: start;">
                            <div>
                                <div style="font-weight: 700; color: #111; font-size: 0.9rem;">{{ $avis->user->prenom }} {{ $avis->user->nom ?? '' }}</div>
                                <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 8px;">
                                    Avis pour :
                                    <a href="{{ route('annonces.show', $avis->annonce) }}" target="_blank" style="color: #2563eb; text-decoration: none;">{{ $avis->annonce->titre }}</a>
                                </div>
                                <div style="margin-bottom: 8px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span style="color: {{ $i <= $avis->note ? '#f59e0b' : '#d1d5db' }}; font-size: 1.05rem;">★</span>
                                    @endfor
                                    <span style="color: #64748b; font-size: 0.8rem; margin-left: 6px;">{{ $avis->note }}/5</span>
                                </div>
                                <p style="color: #374151; line-height: 1.6; margin: 0 0 8px; background: #fff; padding: 10px 12px; border-radius: 6px; font-size: 0.85rem;">{{ $avis->commentaire }}</p>
                                @if($avis->photos && count($avis->photos) > 0)
                                    <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 8px;">
                                        @foreach($avis->photos as $photoPath)
                                            <img src="{{ asset('storage/' . $photoPath) }}" alt="Photo" style="width: 72px; height: 72px; object-fit: cover; border-radius: 6px;">
                                        @endforeach
                                    </div>
                                @endif
                                <div style="color: #94a3b8; font-size: 0.78rem;">Soumis le {{ $avis->created_at->format('d/m/Y à H:i') }}</div>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 8px; min-width: 160px;">
                                <form method="POST" action="{{ route('admin.avis.approve', $avis) }}">
                                    @csrf
                                    <button type="submit" class="mod-btn" style="background: #16a34a; width: 100%; justify-content: center;">
                                        <i class="fas fa-check"></i> Approuver
                                    </button>
                                </form>
                                <button type="button" class="mod-btn" style="background: #dc2626; width: 100%; justify-content: center;"
                                    onclick="document.getElementById('reject-avis-{{ $avis->id }}').style.display='block'">
                                    <i class="fas fa-times"></i> Rejeter
                                </button>
                                <form id="reject-avis-{{ $avis->id }}" method="POST" action="{{ route('admin.avis.reject', $avis) }}"
                                    style="display: none; margin-top: 6px; padding: 10px; background: #fff; border-radius: 6px; border: 1px solid #e5e7eb;">
                                    @csrf
                                    <label style="display: block; font-size: 0.78rem; font-weight: 600; color: #374151; margin-bottom: 4px;">Raison du rejet *</label>
                                    <textarea name="raison_rejet" required rows="2" placeholder="Expliquez…"
                                        style="width: 100%; padding: 6px 8px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.8rem; resize: vertical;"></textarea>
                                    <button type="submit" class="mod-btn" style="background: #dc2626; margin-top: 6px; width: 100%; justify-content: center;">Confirmer le rejet</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px; color: #94a3b8;">
                        <div style="font-size: 2rem; margin-bottom: 8px;">✅</div>
                        <p style="margin: 0; font-size: 0.9rem;">Aucun avis en attente de modération.</p>
                    </div>
                @endforelse

                @if($avisEnAttente->hasPages())
                    <div style="margin-top: 16px;">{{ $avisEnAttente->links() }}</div>
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
                @forelse($signalements as $signalement)
                    <div style="padding: 18px; background: #f8fafc; border-radius: 8px; border-left: 4px solid #dc2626; margin-bottom: 14px;">
                        <div style="display: grid; grid-template-columns: 1fr auto; gap: 24px; align-items: start;">
                            <div>
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                                    <span class="mod-badge" style="background: #fee2e2; color: #b91c1c;">{{ $signalement->motif_libelle }}</span>
                                    <span style="color: #94a3b8; font-size: 0.78rem;">{{ $signalement->created_at->format('d/m/Y à H:i') }}</span>
                                </div>
                                <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 8px;">
                                    Annonce :
                                    @if($signalement->annonce)
                                        <a href="{{ route('annonces.show', $signalement->annonce) }}" target="_blank" style="color: #2563eb; text-decoration: none;">{{ $signalement->annonce->titre }}</a>
                                    @else
                                        <span style="color: #94a3b8;">(annonce supprimée)</span>
                                    @endif
                                </div>
                                <div style="color: #64748b; font-size: 0.8rem; margin-bottom: 8px;">
                                    Signalé par :
                                    @if($signalement->reporter)
                                        {{ $signalement->reporter->prenom }} {{ $signalement->reporter->nom ?? '' }} ({{ $signalement->reporter->email }})
                                    @elseif($signalement->email)
                                        {{ $signalement->email }} <span style="color: #94a3b8;">(visiteur)</span>
                                    @else
                                        <span style="color: #94a3b8;">Visiteur anonyme</span>
                                    @endif
                                </div>
                                @if($signalement->description)
                                    <p style="color: #374151; line-height: 1.6; margin: 0; background: #fff; padding: 10px 12px; border-radius: 6px; font-size: 0.85rem;">{{ $signalement->description }}</p>
                                @endif
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 8px; min-width: 160px;">
                                @if($signalement->annonce)
                                    <a href="{{ route('annonces.show', $signalement->annonce) }}" target="_blank" class="mod-btn" style="background: #475569; justify-content: center;">
                                        <i class="fas fa-eye"></i> Voir l'annonce
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('admin.moderation.signalements.traiter', $signalement) }}">
                                    @csrf
                                    <button type="submit" class="mod-btn" style="background: #16a34a; width: 100%; justify-content: center;">
                                        <i class="fas fa-check"></i> Marquer traité
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.moderation.signalements.rejeter', $signalement) }}">
                                    @csrf
                                    <button type="submit" class="mod-btn" style="background: #94a3b8; width: 100%; justify-content: center;">
                                        <i class="fas fa-ban"></i> Ignorer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px; color: #94a3b8;">
                        <div style="font-size: 2rem; margin-bottom: 8px;">✅</div>
                        <p style="margin: 0; font-size: 0.9rem;">Aucune annonce signalée.</p>
                    </div>
                @endforelse

                @if($signalements->hasPages())
                    <div style="margin-top: 16px;">{{ $signalements->links() }}</div>
                @endif
            </div>

        </div>
    </div>
@endsection
