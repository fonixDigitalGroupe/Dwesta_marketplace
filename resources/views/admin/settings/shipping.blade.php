@extends('layouts.admin')

@section('title', 'Gestion des Frais de Livraison')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        .ship-section { background: transparent; border: none; padding: 0; }
        .section-title { font-size: 0.75rem; font-weight: 700; color: #475569; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9; text-transform: uppercase; letter-spacing: 0.06em; }
        .field-label { display: block; font-size: 0.72rem; font-weight: 600; color: #94a3b8; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.06em; }
        
        .btn-amazon-primary { background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%); border: none; color: #fff; padding: 8px 16px; border-radius: 4px; font-size: 0.78rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
        .btn-amazon-danger { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; padding: 6px 12px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; cursor: pointer; }
        
        .shipping-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .shipping-table th { text-align: left; font-size: 0.7rem; color: #94a3b8; text-transform: uppercase; padding: 12px; border-bottom: 2px solid #f1f5f9; }
        .shipping-table td { padding: 12px; border-bottom: 1px solid #f1f5f9; font-size: 0.85rem; color: #475569; }
        
        .badge { padding: 4px 8px; border-radius: 99px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .badge-domicile { background: #eff6ff; color: #1e40af; }
        .badge-relais { background: #fef2f2; color: #991b1b; }
        
        input, select { width: 100%; padding: 8px 12px; border: 1px solid #dee2e6; border-radius: 4px; font-size: 0.85rem; outline: none; transition: all 0.2s; }
        input:focus, select:focus { border-color: #ff9900 !important; box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15); }
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

        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 24px; align-items: start;">

        <!-- Liste des Règles -->
        <div class="ship-section">
            <h3 class="section-title">Tarifs Actuels (Marketplace Standard)</h3>
            <table class="shipping-table">
                <thead>
                    <tr>
                        <th>Source</th>
                        <th>Destination</th>
                        <th>Type</th>
                        <th>Délai</th>
                        <th>Prix</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rules as $rule)
                        <tr>
                            <td style="font-weight: 700;">
                                {{ $rule->sourceCountry->flag ?? '🌍' }} {{ $rule->sourceCountry->name ?? 'Tous' }}
                            </td>
                            <td style="font-weight: 700;">
                                {{ $rule->destinationCountry->flag ?? '🌍' }} {{ $rule->destinationCountry->name ?? 'Tous' }}
                                @if($rule->zone_name)
                                    <br><small style="color: #64748b; font-weight: normal;">Zone: {{ $rule->zone_name }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $rule->delivery_type == 'livraison_domicile' ? 'badge-domicile' : 'badge-relais' }}">
                                    {{ $rule->delivery_type == 'livraison_domicile' ? 'À Domicile' : 'Point Relais' }}
                                </span>
                            </td>
                            <td><small style="color: #64748b;">{{ $rule->delivery_delay ?? '-' }}</small></td>
                            <td style="font-weight: 700; color: #1e293b;">{{ number_format($rule->price, 0, ',', ' ') }} F</td>
                            <td>
                                <form action="{{ route('admin.shipping.toggle', $rule->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                                        @if($rule->is_active)
                                            <span style="color: #10b981;"><i class="fas fa-toggle-on fa-lg"></i></span>
                                        @else
                                            <span style="color: #94a3b8;"><i class="fas fa-toggle-off fa-lg"></i></span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.shipping.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Supprimer cette règle ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-amazon-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">
                                Aucune règle de livraison configurée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Formulaire d'ajout -->
        <div class="ship-section">
            <h3 class="section-title">Nouvelle Règle</h3>
            <form action="{{ route('admin.shipping.store') }}" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label class="field-label">Pays Source (Vendeur)</label>
                    <select name="source_country_id" required>
                        <option value="">Sélectionner un pays</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->flag }} {{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="field-label">Pays Destination (Acheteur)</label>
                    <select name="destination_country_id" required>
                        <option value="">Sélectionner un pays</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->flag }} {{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="field-label">Zone / Région de destination (Optionnel)</label>
                    <input type="text" name="zone_name" placeholder="ex: Dakar, National...">
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="field-label">Mode de Livraison</label>
                    <select name="delivery_type" required>
                        <option value="livraison_domicile">Livraison à domicile</option>
                        <option value="retrait_point_relais">Point Relais</option>
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="field-label">Frais (FCFA)</label>
                    <input type="number" name="price" value="0" min="0" required>
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="field-label">Délai de livraison (ex: 2-3 jours)</label>
                    <input type="text" name="delivery_delay" placeholder="ex: 24h, 3-5 jours...">
                </div>

                <button type="submit" class="btn-amazon-primary" style="width: 100%; justify-content: center; background: #ff9900;">
                    AJOUTER LA RÈGLE
                </button>
            </form>

            <div style="margin-top: 30px; padding: 15px; background: #fffbe6; border: 1px solid #ffe58f; border-radius: 4px; font-size: 0.8rem; color: #856404;">
                <i class="fas fa-info-circle"></i> <strong>Note :</strong><br>
                Le système cherchera une règle correspondant à la région du Point Relais ou de l'utilisateur. Si aucune règle n'est trouvée, un tarif par défaut de 0 F sera appliqué.
            </div>
        </div>

        </div>
    </div>
</div>
@endsection
