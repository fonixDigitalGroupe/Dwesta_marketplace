<x-app-layout>
    <x-slot name="header_tabs">
        <div style="background: #fff; padding: 0 25px; border-bottom: 1px solid #e7e7e7; display: flex; gap: 20px;">
            <a href="?tab=incoming" style="text-decoration: none; padding: 15px 0; color: {{ $activeTab == 'incoming' ? '#0066c0' : '#555' }}; font-weight: {{ $activeTab == 'incoming' ? '700' : '500' }}; border-bottom: 3px solid {{ $activeTab == 'incoming' ? '#0066c0' : 'transparent' }};">
                En approche 
                @if($counts['incoming'] > 0)
                    <span style="background: #bf0000; color: #fff; padding: 2px 6px; border-radius: 10px; font-size: 0.7rem;">{{ $counts['incoming'] }}</span>
                @endif
            </a>
            <a href="?tab=stock" style="text-decoration: none; padding: 15px 0; color: {{ $activeTab == 'stock' ? '#0066c0' : '#555' }}; font-weight: {{ $activeTab == 'stock' ? '700' : '500' }}; border-bottom: 3px solid {{ $activeTab == 'stock' ? '#0066c0' : 'transparent' }};">
                En stock
                <span class="badge" style="background: #eee; color: #333; padding: 2px 6px; border-radius: 10px; font-size: 0.7rem;">{{ $counts['stock'] }}</span>
            </a>
            <a href="?tab=history" style="text-decoration: none; padding: 15px 0; color: {{ $activeTab == 'history' ? '#0066c0' : '#555' }}; font-weight: {{ $activeTab == 'history' ? '700' : '500' }}; border-bottom: 3px solid {{ $activeTab == 'history' ? '#0066c0' : 'transparent' }};">
                Historique (Livrés)
                <span style="color: #999; font-size: 0.7rem; margin-left: 5px;">{{ $counts['history'] }}</span>
            </a>
        </div>
    </x-slot>


    @push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        
        /* High-Precision Amazon/Karnou Buttons */
        .sync-btn-blue {
            background: linear-gradient(180deg, #007bff 0%, #0056b3 100%);
            border: 1px solid #004aad;
            color: #fff !important;
            padding: 6px 14px;
            border-radius: 0;
            font-size: 0.8rem;
            font-weight: 400;
            text-decoration: none;
            box-shadow: 0 1px 0 rgba(255,255,255,.4) inset;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .sync-btn-blue:hover { background: linear-gradient(180deg, #0069d9 0%, #004085 100%); }

        .sync-btn-gray {
            background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
            border: 1px solid #adb1b8;
            color: #111 !important;
            padding: 6px 14px;
            border-radius: 0;
            font-size: 0.8rem;
            font-weight: 400;
            text-decoration: none;
            box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .sync-btn-gray:hover { background: #f0f2f5; }

        /* Table Mirroring (Grid + Header Background) */
        .table-mirror {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-bottom: 20px !important;
            border: 1px solid #e7e7e7 !important;
            background: #fff;
        }

        .table-mirror th {
            padding: 10px 15px !important;
            text-align: left !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            color: #111 !important;
            text-transform: uppercase !important;
            border-right: 1px solid #e7e7e7 !important;
            border-bottom: 1px solid #e7e7e7 !important;
            background: #f6f6f6 !important;
        }

        .table-mirror td {
            padding: 12px 15px !important;
            font-size: 0.85rem !important;
            color: #111 !important;
            border-right: 1px solid #e7e7e7 !important;
            border-bottom: 1px solid #e7e7e7 !important;
            vertical-align: middle !important;
        }

        .table-mirror tr:hover { background: #f9f9f9; }

        /* Typography Sync */
        .mirror-title {
            font-size: 1.1rem;
            font-weight: 500;
            color: #111;
            margin: 0;
        }
        .item-main {
            font-weight: 600;
            color: #0066c0;
            font-size: 0.9rem;
            text-decoration: none;
            display: block;
            margin-bottom: 2px;
        }
        .item-sub {
            font-size: 0.8rem;
            color: #777;
        }

        /* Action Links */
        .mirror-link { color: #0066c0; font-size: 0.84rem; text-decoration: none; cursor: pointer; }
        .mirror-link:hover { text-decoration: underline; }
        .mirror-link-red { color: #c40000; font-size: 0.84rem; text-decoration: none; cursor: pointer; }
        .mirror-link-red:hover { text-decoration: underline; }
        .mirror-sep { color: #ddd; margin: 0 8px; }

        /* Filter Standard Styling from Categories */
        .filter-container {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px 20px;
            border-radius: 0;
            margin-bottom: 20px;
        }
        .filter-input {
            padding: 6px 12px;
            border: 1px solid #adb1b8;
            border-radius: 0;
            outline: none;
            font-size: 0.85rem;
            width: 250px;
            background: #fff;
        }
        .filter-select {
            padding: 3px 6px;
            border: 1px solid #adb1b8;
            border-radius: 0;
            background: #fcfcfc;
            font-size: 0.8rem;
            color: #111;
            cursor: pointer;
            outline: none;
        }
    </style>
    @endpush

    <div style="max-width: 100%;">
        {{-- Main Dashboard Card --}}
        <div style="background: #fff; border: 1px solid #e7e7e7; border-top: none; padding: 25px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h1 class="mirror-title">Gestion du Stock & Colis</h1>

                <div style="display: flex; gap: 8px;">
                    <button type="button" onclick="openScanModal()" class="sync-btn-blue">
                        <i class="fas fa-barcode"></i> Scanner un colis
                    </button>
                    <a href="javascript:window.print()" class="sync-btn-gray">
                        <i class="fas fa-print"></i> Imprimer
                    </a>
                </div>
            </div>

            <!-- Barre de filtres (1:1 with Categories) -->
            <div class="filter-container">
                <form action="{{ route('operations.stock') }}" method="GET" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                    <input type="hidden" name="tab" value="{{ $activeTab }}">
                    
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555;">
                        <span>Afficher</span>
                        <select onchange="window.location.href = '{{ request()->fullUrlWithQuery(['per_page' => '']) }}'.replace('per_page=', 'per_page=' + this.value)"
                                class="filter-select">
                            <option value="8" {{ $perPage == 8 ? 'selected' : '' }}>8</option>
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        <span>résultats</span>
                    </div>

                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span style="font-size: 0.8rem; color: #555; font-weight: 500;">Rechercher :</span>
                        <input type="text" name="search" value="{{ $search }}"
                               placeholder="Réf, Nom client..."
                               class="filter-input">
                    </div>
                </form>
            </div>

            <!-- Table Pixel-Perfect -->
            <table class="table-mirror">
                <thead>
                    <tr>
                        <th style="width: 150px;">référence</th>
                        <th>client</th>
                        <th>vendeur</th>
                        <th style="width: 120px; text-align: center;">statut</th>
                        <th style="width: 180px;">mis à jour</th>
                        <th style="width: 100px; text-align: right;">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td style="font-weight: 400; font-size: 0.65rem; color: #555;">{{ $order->reference }}</td>
                            <td>
                                <a href="#" class="item-main">
                                    {{ $order->buyer->prenom ?? '' }} {{ $order->buyer->nom ?? $order->buyer->name ?? 'Inconnu' }}
                                </a>
                                <div class="item-sub">{{ $order->buyer->email ?? '' }}</div>
                            </td>
                            <td>
                                @php
                                    $sellerName = 'Vendeur Inconnu';
                                    if ($order->seller) {
                                        $sellerName = $order->seller->identite ?? ($order->seller->user ? $order->seller->user->prenom . ' ' . $order->seller->user->nom : 'Inconnu');
                                    }
                                @endphp
                                <span class="item-main" style="color: #333; font-weight: 500;">{{ $sellerName }}</span>
                                @if($order->seller && $order->seller->type === 'professionnel')
                                    <span style="font-size: 0.65rem; background: #eee; padding: 1px 4px; border-radius: 3px; font-weight: bold; color: #666;">PRO</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @php
                                    $pillColor = match($order->statut) {
                                        'en_route' => '#0066c0',
                                        'disponible' => '#569b00',
                                        'livre' => '#c45500',
                                        default => '#555'
                                    };
                                    $label = match($order->statut) {
                                        'en_route' => 'En Route',
                                        'disponible' => 'Active',
                                        'livre' => 'Livré',
                                        default => $order->statut_label
                                    };
                                @endphp
                                <span style="font-size: 0.75rem; font-weight: 600; color: {{ $pillColor }};">{{ $label }}</span>
                            </td>
                            <td style="color: #666;">
                                <div style="font-weight: 500;">{{ $order->updated_at->format('d/m/Y') }}</div>
                                <div style="font-size: 0.72rem; color: #999; margin-top: 2px;">à {{ $order->updated_at->format('H:i') }}</div>
                            </td>
                            <td style="text-align: right; display: flex; align-items: center; justify-content: flex-end; gap: 8px;">
                                <a href="#" onclick="alert('Fonctionnalité Détails en cours de développement.'); return false;" class="mirror-link" style="color: #666;">Détails</a>

                                @if($activeTab == 'incoming')
                                    <span class="mirror-sep">|</span>
                                    <button type="button" onclick="confirmReceive('{{ $order->id }}', '{{ $order->reference }}')" class="mirror-link" style="background: none; border: none; font-weight: bold; color: #0066c0;">Réceptionner</button>
                                    <form id="receive-form-{{ $order->id }}" action="{{ route('colis.receive', $order->id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @elseif($activeTab == 'stock')
                                    <span class="mirror-sep">|</span>
                                    <button type="button" onclick="confirmDeliver('{{ $order->id }}', '{{ $order->reference }}')" class="mirror-link" style="background: none; border: none; font-weight: bold; color: #569b00;">Remettre au client</button>
                                    <form id="deliver-form-{{ $order->id }}" action="{{ route('colis.deliver', $order->id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 50px; text-align: center; color: #999;">Aucun résultat trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($orders->total() > 0)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: #ffffff; border: 1px solid #e7e7e7; border-top: none; margin-top: -20px;">
                    <div style="font-size: 0.85rem; color: #555; font-weight: 500;">
                        Affichage de {{ $orders->firstItem() }} à {{ $orders->lastItem() }} sur {{ $orders->total() }} résultats
                    </div>
                    <div style="display: flex; border: 1px solid #adb1b8; border-radius: 4px; overflow: hidden;">
                        @if($orders->onFirstPage())
                            <span style="padding: 7px 14px; background: #fdfdfd; color: #aaa; font-size: 0.85rem; border-right: 1px solid #adb1b8;">Précédent</span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" style="padding: 7px 14px; background: #fff; color: #111; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                        @endif

                        @for($i = max(1, $orders->currentPage() - 2); $i <= min($orders->lastPage(), max(1, $orders->currentPage() - 2) + 4); $i++)
                            @php $isActive = $i == $orders->currentPage(); @endphp
                            <a href="{{ $isActive ? '#' : $orders->url($i) }}" 
                               style="padding: 7px 14px; background: {{ $isActive ? '#007bff' : '#fff' }}; color: {{ $isActive ? '#fff' : '#555' }}; font-weight: {{ $isActive ? '700' : '400' }}; font-size: 0.85rem; text-decoration: none; border-right: 1px solid {{ $isActive ? '#004aad' : '#adb1b8' }};">
                               {{ $i }}
                            </a>
                        @endfor

                        @if($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" style="padding: 7px 14px; background: #fff; color: #111; font-size: 0.85rem; text-decoration: none;">Suivant</a>
                        @else
                            <span style="padding: 7px 14px; background: #fdfdfd; color: #aaa; font-size: 0.85rem;">Suivant</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de Scan -->
    <div id="scanModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 2000; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: #fff; width: 100%; max-width: 450px; border-radius: 8px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); overflow: hidden;">
            <div style="padding: 20px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600; color: #111;">Scanner un code-barres</h3>
                <button onclick="closeScanModal()" style="background: none; border: none; font-size: 1.5rem; color: #9ca3af; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <div style="padding: 24px;">
                <p style="font-size: 0.875rem; color: #4b5563; margin-bottom: 20px;">Utilisez votre lecteur de code-barres ou saisissez manuellement la référence du colis.</p>
                
                <div style="position: relative;">
                    <input type="text" id="barcodeInput" 
                           placeholder="Attente du scan..." 
                           style="width: 100%; padding: 12px 16px; border: 2px solid #0066c0; border-radius: 6px; font-size: 1rem; outline: none; background: #f0f7ff;"
                           autocomplete="off">
                    <div id="scanStatus" style="margin-top: 10px; font-size: 0.8rem; display: none;"></div>
                </div>
            </div>
            <div style="padding: 16px 24px; background: #f9fafb; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 12px;">
                <button onclick="closeScanModal()" style="padding: 8px 16px; background: #fff; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem; color: #374151; cursor: pointer;">Fermer</button>
                <button onclick="processScan()" style="padding: 8px 20px; background: #0066c0; border: none; border-radius: 6px; font-size: 0.875rem; color: #fff; font-weight: 600; cursor: pointer;">Valider</button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmReceive(id, ref) {
            Swal.fire({
                title: 'Réceptionner ?',
                text: "Confirmer l'arrivée du colis " + ref,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0066c1',
                confirmButtonText: 'Confirmer',
                cancelButtonText: 'Annuler'
            }).then((result) => { if (result.isConfirmed) document.getElementById('receive-form-' + id).submit(); });
        }
        function confirmDeliver(id, ref) {
            Swal.fire({
                title: 'Remettre au client ?',
                text: "Confirmer la remise du colis " + ref,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#569b00',
                confirmButtonText: 'Confirmer',
                cancelButtonText: 'Annuler'
            }).then((result) => { if (result.isConfirmed) document.getElementById('deliver-form-' + id).submit(); });
        }

        // Scan Logic
        const scanModal = document.getElementById('scanModal');
        const barcodeInput = document.getElementById('barcodeInput');
        const scanStatus = document.getElementById('scanStatus');
        let isProcessing = false;

        function openScanModal() {
            scanModal.style.display = 'flex';
            barcodeInput.focus();
            scanStatus.style.display = 'none';
            barcodeInput.value = '';
        }

        function closeScanModal() {
            scanModal.style.display = 'none';
        }

        barcodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                processScan();
            }
        });

        function processScan() {
            const code = barcodeInput.value.trim();
            if (!code || isProcessing) return;

            isProcessing = true;
            scanStatus.style.display = 'block';
            scanStatus.style.color = '#0066c0';
            scanStatus.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Recherche du colis...';
            barcodeInput.disabled = true;

            fetch('{{ route("colis.scan") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ code: code })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Succès !',
                        text: data.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    scanStatus.style.color = '#c40000';
                    scanStatus.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + data.message;
                    barcodeInput.disabled = false;
                    barcodeInput.value = '';
                    barcodeInput.focus();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                scanStatus.style.color = '#c40000';
                scanStatus.innerHTML = '<i class="fas fa-exclamation-circle"></i> Une erreur est survenue.';
                barcodeInput.disabled = false;
            })
            .finally(() => {
                isProcessing = false;
            });
        }
    </script>
    @endpush
</x-app-layout>
