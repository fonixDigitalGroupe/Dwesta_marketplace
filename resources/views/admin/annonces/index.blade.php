@extends('layouts.admin')

@section('title', 'Gestion des Articles')

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        select:focus,
        input:focus {
            border-color: #adb1b8 !important;
            outline: none;
        }
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <!-- Main Conteneur style Amazon Card -->
    <div style="background: #fff; border: 1px solid #eff3f6; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px; margin-top: -50px;">

        <!-- Top Action Bar -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eff3f6;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-clipboard-list" style="font-size: 0.8rem;"></i>
                <span style="line-height: 1;">Articles</span>
            </div>

            <div style="display: flex; gap: 8px;">
                <button disabled
                    style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px; opacity: 0.5; cursor: not-allowed;">
                    <i class="fas fa-print"></i> Imprimer
                </button>
                <button disabled
                    style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px; opacity: 0.5; cursor: not-allowed;">
                    <i class="fas fa-sms"></i> SMS
                </button>
                <button disabled
                    style="background: linear-gradient(to bottom, #f7f8fa, #e7e9ec); border: 1px solid #adb1b8; color: #111; padding: 6px 14px; border-radius: 0; font-size: 0.8rem; font-weight: 400; text-decoration: none; box-shadow: 0 1px 0 rgba(255,255,255,.6) inset; display: flex; align-items: center; gap: 6px; opacity: 0.5; cursor: not-allowed;">
                    <i class="fas fa-envelope"></i> Email
                </button>
            </div>
        </div>

        @php
            $totalAnnonces = \App\Models\Annonce::count();
            $enAttenteAnnonces = \App\Models\Annonce::where('statut', 'en_attente')->count();
            $publieesAnnonces = \App\Models\Annonce::where('statut', 'publiee')->count();
            $rejeteesAnnonces = \App\Models\Annonce::where('statut', 'rejetee')->count();
        @endphp
        <!-- Statistiques annonces -->
        <div style="display: flex; gap: 14px; margin-bottom: 20px; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 160px; display: flex; align-items: center; gap: 12px; background: #f8fafc; border: 1px solid #eff3f6; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #eef4ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $totalAnnonces }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Total des annonces</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 160px; display: flex; align-items: center; gap: 12px; background: #f8fafc; border: 1px solid #eff3f6; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff8f3; color: #f68b1e; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $enAttenteAnnonces }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">En attente</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 160px; display: flex; align-items: center; gap: 12px; background: #f8fafc; border: 1px solid #eff3f6; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #f7fff0; color: #569b00; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $publieesAnnonces }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Publiées</div>
                </div>
            </div>
            <div style="flex: 1; min-width: 160px; display: flex; align-items: center; gap: 12px; background: #f8fafc; border: 1px solid #eff3f6; border-radius: 8px; padding: 14px 18px;">
                <div style="width: 40px; height: 40px; border-radius: 8px; background: #fff5f5; color: #c40000; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <div style="font-size: 1.4rem; font-weight: 800; color: #111; line-height: 1;">{{ $rejeteesAnnonces }}</div>
                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.03em; margin-top: 4px;">Rejetées</div>
                </div>
            </div>
        </div>

        <!-- Status Filter Tabs (Amazon Style) -->
        <div style="display: flex; gap: 20px; border-bottom: 1px solid #f0f0f0; margin-bottom: 20px; padding-bottom: 0;">
            <a href="{{ route('admin.annonces.index') }}" 
               style="padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: {{ !$status ? '#c45500' : '#555' }}; font-weight: {{ !$status ? '700' : '400' }}; border-bottom: 2px solid {{ !$status ? '#c45500' : 'transparent' }};">
                Tous
            </a>
            <a href="{{ route('admin.annonces.index', ['status' => 'en_attente']) }}" 
               style="padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: {{ $status === 'en_attente' ? '#c45500' : '#555' }}; font-weight: {{ $status === 'en_attente' ? '700' : '400' }}; border-bottom: 2px solid {{ $status === 'en_attente' ? '#c45500' : 'transparent' }};">
                En attente <span style="background: #fff8f3; border: 1px solid #fbd8b4; color: #c45500; padding: 0px 6px; border-radius: 10px; font-size: 0.75rem;">{{ \App\Models\Annonce::where('statut', 'en_attente')->count() }}</span>
            </a>
            <a href="{{ route('admin.annonces.index', ['status' => 'publiee']) }}" 
               style="padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: {{ $status === 'publiee' ? '#c45500' : '#555' }}; font-weight: {{ $status === 'publiee' ? '700' : '400' }}; border-bottom: 2px solid {{ $status === 'publiee' ? '#c45500' : 'transparent' }};">
                Publiées
            </a>
            <a href="{{ route('admin.annonces.index', ['status' => 'rejetee']) }}" 
               style="padding: 10px 5px; text-decoration: none; font-size: 0.85rem; color: {{ $status === 'rejetee' ? '#c45500' : '#555' }}; font-weight: {{ $status === 'rejetee' ? '700' : '400' }}; border-bottom: 2px solid {{ $status === 'rejetee' ? '#c45500' : 'transparent' }};">
                Rejetées
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="filters-bar" style="background: #f8fafc; border: 1px solid #eff3f6; padding: 10px 16px; border-radius: 0; margin-bottom: 20px;">
            <form action="{{ route('admin.annonces.index') }}" method="GET" style="display: flex; align-items: center; width: 100%; gap: 12px;">
                <input type="hidden" name="status" value="{{ $status }}">
                <div style="display: flex; flex: 1; border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden; background: #fff; transition: all 0.2s;" id="search-container">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Rechercher un article, un vendeur..."
                        style="padding: 10px 16px; border: none; outline: none; flex: 1; font-size: 0.9rem; background: transparent;"
                        onfocus="document.getElementById('search-container').style.borderColor='#ff9900'; document.getElementById('search-container').style.boxShadow='0 0 0 3px rgba(255, 153, 0, 0.15)'"
                        onblur="document.getElementById('search-container').style.borderColor='#dee2e6'; document.getElementById('search-container').style.boxShadow='none'">
                    <button type="submit"
                        style="background: linear-gradient(180deg, #ff9900 0%, #e77600 100%); border: none; color: #fff; padding: 0 22px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;"
                        onmouseover="this.style.background='linear-gradient(180deg, #f08804 0%, #d87300 100%)'"
                        onmouseout="this.style.background='linear-gradient(180deg, #ff9900 0%, #e77600 100%)'">
                        <i class="fas fa-search" style="font-size: 1.1rem; text-shadow: 0 1px 1px rgba(0,0,0,0.1);"></i>
                    </button>
                </div>
                @if($search || $status)
                    <a href="{{ route('admin.annonces.index') }}"
                       style="color: #0066c0; font-size: 0.85rem; text-decoration: none; white-space: nowrap;"
                       onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Effacer</a>
                @endif
            </form>
        </div>

        <!-- Articles Table -->
        <div style="border: 1px solid #e7e7e7; border-radius: 0; overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #d1d5db; border-bottom: 1px solid #cbd0d6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Article</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 200px;">Vendeur</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 150px;">Prix</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7; width: 120px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($annonces as $annonce)
                    <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                            <div style="display: flex; gap: 12px; align-items: center;">
                                <div style="width: 40px; height: 40px; background: #f0f0f0; border: 1px solid #eee; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 2px; flex-shrink: 0;">
                                    @if($annonce->photoPrincipale())
                                        <img src="{{ $annonce->photoPrincipale()->url }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <i class="fas fa-image" style="color: #ccc; font-size: 1.2rem;"></i>
                                    @endif
                                </div>
                                <div>
                                    <div style="font-weight: 700; font-size: 0.85rem; color: #111; margin-bottom: 2px;">{{ $annonce->titre }}</div>
                                    <div style="font-size: 0.75rem; color: #111;">Réf: #{{ $annonce->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                            <div style="font-weight: 700; font-size: 0.85rem; color: #111;">{{ $annonce->vendeur->user->prenom }} {{ $annonce->vendeur->user->nom }}</div>
                            <div style="font-size: 0.75rem; color: #111; margin-top: 2px;">{{ ucfirst($annonce->vendeur->type) }}</div>
                        </td>
                        <td style="padding: 12px 15px; border-right: 1px solid #e7e7e7;">
                            <div style="font-weight: 700; color: #111; font-size: 0.9rem;">{{ number_format($annonce->prix, 0, ',', ' ') }} <small style="font-size: 0.7rem; font-weight: 400;">FCFA</small></div>
                        </td>
                        <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #e7e7e7;">
                            @php
                                $statusLabel = 'Inconnu';
                                $statusColor = '#555';
                                $statusBg = 'transparent';
                                
                                switch($annonce->statut) {
                                    case 'publiee':
                                        $statusLabel = 'Publiée';
                                        $statusColor = '#569b00';
                                        $statusBg = '#f7fff0';
                                        break;
                                    case 'en_attente':
                                        $statusLabel = 'En attente';
                                        $statusColor = '#f68b1e';
                                        $statusBg = '#fff8f3';
                                        break;
                                    case 'rejetee':
                                        $statusLabel = 'Rejetée';
                                        $statusColor = '#c40000';
                                        $statusBg = '#fff5f5';
                                        break;
                                    default:
                                        $statusLabel = ucfirst($annonce->statut);
                                        $statusBg = '#f6f6f6';
                                }
                            @endphp
                            <span style="font-size: 0.75rem; color: {{ $statusColor }}; background: {{ $statusBg }}; padding: 3px 8px; border-radius: 12px; font-weight: 700; text-transform: uppercase; display: inline-block;">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td style="padding: 12px 15px; text-align: right;">
                            <div style="display: flex; gap: 10px; justify-content: flex-end; align-items: center;">
                                @if($annonce->statut === 'en_attente')
                                    <form action="{{ route('admin.annonces.moderation.approve', $annonce) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="color: #569b00; font-size: 0.8rem; text-decoration: none; font-weight: 600; background: #f7fff0; border: none; padding: 2px 8px; border-radius: 2px; cursor: pointer;">
                                            Approuver
                                        </button>
                                    </form>
                                    <span style="color: #ddd;">|</span>
                                @elseif($annonce->statut === 'publiee')
                                    <a href="{{ route('annonces.show', $annonce) }}" target="_blank" style="color: #0066c0; font-size: 0.8rem; text-decoration: none;">Voir</a>
                                    <span style="color: #ddd;">|</span>
                                @endif

                                @if($annonce->statut !== 'rejetee')
                                    <form action="{{ route('admin.annonces.moderation.reject', $annonce) }}" method="POST" style="display: inline;" class="rejection-form">
                                        @csrf
                                        <input type="hidden" name="raison_rejet" class="rejection-reason-input">
                                        <button type="button" 
                                            onclick="confirmRejection(this, '{{ addslashes($annonce->titre) }}', '{{ $annonce->photoPrincipale() ? $annonce->photoPrincipale()->url : '' }}', '{{ addslashes($annonce->vendeur->user->prenom . ' ' . $annonce->vendeur->user->nom) }}', '{{ ucfirst($annonce->vendeur->type) }}')"
                                            style="color: #c40000; font-size: 0.8rem; text-decoration: none; font-weight: 600; background: #fff5f5; border: none; padding: 2px 8px; border-radius: 2px; cursor: pointer;">
                                            Rejeter
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 60px; text-align: center; color: #888;">
                            <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.2;"></i>
                            <p>Aucun article trouvé pour les critères sélectionnés.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination info & links harmonisée -->
        @if($annonces->total() > 0)
        <div style="margin-top: 15px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                    Affichage de {{ $annonces->firstItem() ?? 0 }} à {{ $annonces->lastItem() ?? 0 }} sur {{ $annonces->total() }} résultats
                </div>
                
                <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                    @if ($annonces->onFirstPage())
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;">Précédent</span>
                    @else
                        <a href="{{ $annonces->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                    @endif

                    @php
                        $startPage = max(1, $annonces->currentPage() - 2);
                        $endPage = min($annonces->lastPage(), $startPage + 4);
                    @endphp

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        @if ($i == $annonces->currentPage())
                            <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #004aad;">{{ $i }}</span>
                        @else
                            <a href="{{ $annonces->url($i) }}" style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                        @endif
                    @endfor

                    @if ($annonces->hasMorePages())
                        <a href="{{ $annonces->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;">Suivant</a>
                    @else
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;">Suivant</span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        function confirmRejection(btn, title, imageUrl, sellerName, sellerType) {
            const form = btn.closest('form');
            const placeholderImg = `<div style="width: 60px; height: 60px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 4px; border: 1px solid #eee;"><i class="fas fa-image" style="color: #ccc; font-size: 1.5rem;"></i></div>`;
            const articleImg = imageUrl ? `<img src="${imageUrl}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">` : placeholderImg;

            Swal.fire({
                title: 'Confirmer le rejet',
                html: `
                    <div style="text-align: left; background: #f9f9f9; padding: 15px; border-radius: 8px; border: 1px solid #eee; margin-bottom: 20px;">
                        <div style="display: flex; gap: 15px; margin-bottom: 15px; align-items: center;">
                            ${articleImg}
                            <div style="flex: 1;">
                                <div style="font-weight: 700; color: #111; font-size: 1rem; margin-bottom: 2px;">${title}</div>
                                <div style="font-size: 0.8rem; color: #666;">Vendeur: <span style="font-weight: 600; color: #333;">${sellerName}</span> (${sellerType})</div>
                            </div>
                        </div>
                        <div style="height: 1px; background: #eee; margin: 10px 0;"></div>
                        <div style="margin-top: 15px;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #333; margin-bottom: 8px;">Motif du rejet (obligatoire) :</label>
                            <textarea id="rejection-reason-textarea" 
                                placeholder="Indiquez au vendeur pourquoi son article est refusé..."
                                style="width: 100%; height: 100px; padding: 10px; border: 1px solid #adb1b8; border-radius: 4px; font-size: 0.85rem; outline: none;"></textarea>
                        </div>
                    </div>
                    <div style="font-size: 0.8rem; color: #d00; font-weight: 500;">
                        <i class="fas fa-info-circle"></i> Le vendeur recevra un email avec ce motif.
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Rejeter l\'annonce',
                cancelButtonText: 'Annuler',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'amazon-swal-popup',
                    confirmButton: 'amazon-swal-confirm',
                    cancelButton: 'amazon-swal-cancel',
                    title: 'amazon-swal-title',
                    actions: 'amazon-swal-actions'
                },
                didOpen: () => {
                    const textarea = document.getElementById('rejection-reason-textarea');
                    textarea.focus();
                },
                preConfirm: () => {
                    const reason = document.getElementById('rejection-reason-textarea').value;
                    if (!reason || reason.trim() === "") {
                        Swal.showValidationMessage('Veuillez indiquer un motif de rejet.');
                        return false;
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.querySelector('.rejection-reason-input').value = result.value;
                    form.submit();
                }
            });
        }
    </script>
@endpush
@endsection
