@extends('layouts.admin')

@section('title', 'Gestion des Frais de Livraison')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        .ship-section { background: transparent; border: none; padding: 0; }
        /* Panneau formulaire en carte */
        .ship-aside { background: #f9fafb; border: 1px solid #eef2f6; border-radius: 8px; padding: 18px; }
        .form-row { margin-bottom: 14px; }
        /* Bloc englobant chaque grande section */
        .ship-block { border: 1px solid #eff3f6; border-radius: 8px; padding: 20px; margin-bottom: 20px; }
        .ship-block-title { display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 18px; }
        .section-title { font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 14px; padding-bottom: 8px; border-bottom: 1px solid #f1f5f9; text-transform: uppercase; letter-spacing: 0.06em; }
        .field-label { display: block; font-size: 0.72rem; font-weight: 600; color: #94a3b8; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.06em; }

        .btn-amazon-primary { background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%); border: none; color: #fff; padding: 8px 16px; border-radius: 4px; font-size: 0.78rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-amazon-danger { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 6px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; cursor: pointer; }

        .badge { padding: 4px 8px; border-radius: 99px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .badge-domicile { background: #eff6ff; color: #1e40af; }
        .badge-relais { background: #fef2f2; color: #991b1b; }

        .badge-amazon { font-size: 0.75rem; font-weight: 600; padding: 2px 8px; border-radius: 12px; }
        .badge-amazon-success { color: #569b00; background: #f7fff0; }
        .badge-amazon-danger { color: #c40000; background: #fff5f5; }

        input, select { width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 0.85rem; outline: none; transition: all 0.2s; }
        input:focus, select:focus { border-color: #ff9900 !important; box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15); }

        /* align-items: stretch => les deux cartes prennent la hauteur de la plus grande */
        .forms-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: stretch; }
        .forms-grid .ship-aside { display: flex; flex-direction: column; }
        .forms-grid .ship-aside form { display: flex; flex-direction: column; flex: 1; }
        /* pousse le bouton (et la note) vers le bas pour aligner les deux formulaires */
        .forms-grid .ship-aside form button[type="submit"] { margin-top: auto; }
        @media (max-width: 900px) { .forms-grid { grid-template-columns: 1fr; } }
    </style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

        {{-- Card Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-truck" style="font-size: 0.8rem;"></i>
                <span>Gestion des Frais de Livraison</span>
            </div>
        </div>

        {{-- ===================== FORMULAIRES (côte à côte) ===================== --}}
        <div class="ship-block">
            <div class="ship-block-title">
                <i class="fas fa-plus"></i>
                <span>Ajouter / définir un tarif</span>
            </div>

            <div class="forms-grid">

                <!-- Formulaire règle Marketplace -->
                <div class="ship-aside">
                    <h3 class="section-title">Nouvelle règle (pays → pays)</h3>
                    <form action="{{ route('admin.shipping.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <label class="field-label">Pays Source (Vendeur)</label>
                            <select name="source_country_id" required>
                                <option value="">Sélectionner un pays</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->flag }} {{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
                            <label class="field-label">Pays Destination (Acheteur)</label>
                            <select name="destination_country_id" required>
                                <option value="">Sélectionner un pays</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->flag }} {{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
                            <label class="field-label">Mode de Livraison</label>
                            <select name="delivery_type" required>
                                <option value="livraison_domicile">Livraison à domicile</option>
                                <option value="retrait_point_relais">Point Relais</option>
                            </select>
                        </div>

                        <div class="form-row">
                            <label class="field-label">Frais (FCFA)</label>
                            <input type="number" name="price" value="0" min="0" required>
                        </div>

                        <div class="form-row">
                            <label class="field-label">Délai de livraison</label>
                            <input type="text" name="delivery_delay">
                        </div>

                        <button type="submit" class="btn-amazon-primary" style="width: 100%; justify-content: center; background: #ff9900;">
                            AJOUTER LA RÈGLE
                        </button>
                    </form>
                </div>

                <!-- Formulaire tarif inter-régions -->
                <div class="ship-aside">
                    <h3 class="section-title">Tarif inter-régions (national)</h3>
                    <form action="{{ route('admin.shipping.inter-region.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <label class="field-label">Pays</label>
                            <select name="country_id" required>
                                <option value="">Sélectionner un pays</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->flag }} {{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
                            <label class="field-label">Prix même région (FCFA)</label>
                            <input type="number" name="same_region_price" value="0" min="0" required>
                        </div>

                        <div class="form-row">
                            <label class="field-label">Prix régions différentes (FCFA)</label>
                            <input type="number" name="inter_region_price" value="0" min="0" required>
                        </div>

                        <div class="form-row">
                            <label class="field-label">Délai de livraison</label>
                            <input type="text" name="delivery_delay" placeholder="Ex: 2-3 jours">
                        </div>

                        <button type="submit" class="btn-amazon-primary" style="width: 100%; justify-content: center; background: #ff9900;">
                            ENREGISTRER LE TARIF
                        </button>
                        <p style="font-size: 0.72rem; color: #94a3b8; margin-top: 10px;">Un seul tarif par pays. Ré-enregistrer un pays met à jour son tarif.</p>
                    </form>
                </div>

            </div>
        </div>

        {{-- ===================== TABLEAU MARKETPLACE ===================== --}}
        <div class="ship-block">
            <div class="ship-block-title">
                <i class="fas fa-globe-africa"></i>
                <span>Tarifs Marketplace (pays → pays)</span>
            </div>
            <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #eff3f6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Source</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Destination</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 120px;">Type</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 110px;">Délai</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 110px;">Prix</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 90px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 110px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rules as $rule)
                        <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.8rem; font-weight: 700; color: #111; border-right: 1px solid #eff3f6;">
                                {{ $rule->sourceCountry->flag ?? '🌍' }} {{ $rule->sourceCountry->name ?? 'Tous' }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; font-weight: 700; color: #111; border-right: 1px solid #eff3f6;">
                                {{ $rule->destinationCountry->flag ?? '🌍' }} {{ $rule->destinationCountry->name ?? 'Tous' }}
                                @if($rule->zone_name)
                                    <br><small style="color: #64748b; font-weight: normal;">Zone: {{ $rule->zone_name }}</small>
                                @endif
                            </td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                <span class="badge {{ $rule->delivery_type == 'livraison_domicile' ? 'badge-domicile' : 'badge-relais' }}">
                                    {{ $rule->delivery_type == 'livraison_domicile' ? 'À Domicile' : 'Point Relais' }}
                                </span>
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; color: #64748b; text-align: center; border-right: 1px solid #eff3f6;">{{ $rule->delivery_delay ?? '-' }}</td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; font-weight: 700; color: #1e293b; text-align: center; border-right: 1px solid #eff3f6;">{{ number_format($rule->price, 0, ',', ' ') }} F</td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                <form action="{{ route('admin.shipping.toggle', $rule->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;" title="{{ $rule->is_active ? 'Désactiver' : 'Activer' }}">
                                        @if($rule->is_active)
                                            <span class="badge-amazon badge-amazon-success">Active</span>
                                        @else
                                            <span class="badge-amazon badge-amazon-danger">Inactive</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <form id="delete-rule-{{ $rule->id }}" action="{{ route('admin.shipping.destroy', $rule->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDeleteRule({{ $rule->id }})"
                                            style="background: none; border: none; color: #c40000; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                            onmouseover="this.style.textDecoration='underline'"
                                            onmouseout="this.style.textDecoration='none'">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                                Aucune règle de livraison configurée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        {{-- ===================== TABLEAU INTER-RÉGIONS ===================== --}}
        <div class="ship-block">
            <div class="ship-block-title">
                <i class="fas fa-map-signs"></i>
                <span>Tarifs Inter-régions (livraison nationale par pays)</span>
            </div>
            <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #eff3f6;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #eff3f6;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Pays</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 130px;">Même région</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 130px;">Régions différentes</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 100px;">Délai</th>
                        <th style="padding: 10px 15px; text-align: center; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6; width: 90px;">Statut</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 90px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($interRegionTariffs as $tarif)
                        <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                            onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.8rem; font-weight: 700; color: #111; border-right: 1px solid #eff3f6;">
                                {{ $tarif->country->flag ?? '🌍' }} {{ $tarif->country->name ?? '—' }}
                            </td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; font-weight: 700; color: #1e293b; text-align: center; border-right: 1px solid #eff3f6;">{{ number_format($tarif->same_region_price, 0, ',', ' ') }} F</td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; font-weight: 700; color: #1e293b; text-align: center; border-right: 1px solid #eff3f6;">{{ number_format($tarif->inter_region_price, 0, ',', ' ') }} F</td>
                            <td style="padding: 12px 15px; font-size: 0.8rem; color: #64748b; text-align: center; border-right: 1px solid #eff3f6;">{{ $tarif->delivery_delay ?? '-' }}</td>
                            <td style="padding: 12px 15px; text-align: center; border-right: 1px solid #eff3f6;">
                                <form action="{{ route('admin.shipping.inter-region.toggle', $tarif->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;" title="{{ $tarif->is_active ? 'Désactiver' : 'Activer' }}">
                                        @if($tarif->is_active)
                                            <span class="badge-amazon badge-amazon-success">Active</span>
                                        @else
                                            <span class="badge-amazon badge-amazon-danger">Inactive</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <form id="delete-inter-{{ $tarif->id }}" action="{{ route('admin.shipping.inter-region.destroy', $tarif->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDeleteInterRegion({{ $tarif->id }})"
                                            style="background: none; border: none; color: #c40000; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                            onmouseover="this.style.textDecoration='underline'"
                                            onmouseout="this.style.textDecoration='none'">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 2rem; text-align: center; color: #999; font-size: 0.85rem; border: 1px solid #eee;">
                                Aucun tarif inter-régions configuré.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function confirmDeleteInterRegion(id) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e67e00',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-inter-' + id).submit();
            }
        });
    }

    function confirmDeleteRule(id) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Cette action est irréversible !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e67e00',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-rule-' + id).submit();
            }
        });
    }
</script>
@endpush
@endsection
