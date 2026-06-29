@extends('layouts.admin')

@section('title', 'Détail du pays · ' . $country->name)

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            font-size: 0.82rem;
            outline: none;
            background: #fff;
            color: #475569;
            transition: all 0.2s;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #ff9900 !important;
        }

        .amazon-card {
            background: #fff;
            border: 1px solid #eff3f6;
            border-radius: 8px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f1f5f9;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .field-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            color: #94a3b8;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .btn-amazon-primary {
            background: linear-gradient(180deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            color: #fff !important;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            cursor: pointer;
            width: 100%;
        }

        .btn-amazon-primary:hover {
            background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .btn-amazon-secondary {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569 !important;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.78rem;
            font-weight: 500;
            letter-spacing: 0.03em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
            cursor: pointer;
            width: 100%;
        }

        .btn-amazon-secondary:hover {
            background: #f8fafc;
            border-color: #dee2e6;
            color: #1e293b !important;
        }

        .inline-add { display: flex; gap: 8px; margin-bottom: 16px; }
        .inline-add input { flex: 1; }
        .inline-add button { width: auto; white-space: nowrap; }

        .flash { padding: 12px 16px; border-radius: 6px; font-size: 0.82rem; margin-bottom: 16px; }
        .flash-success { background: #f7fff0; color: #3d6b00; border: 1px solid #cdeaa8; }
        .flash-error { background: #fff5f5; color: #c40000; border: 1px solid #f5c2c2; }

        .badge-amazon { font-size: 0.75rem; font-weight: 600; padding: 2px 8px; border-radius: 12px; }
        .badge-amazon-success { color: #569b00; background: #f7fff0; }
        .badge-amazon-danger { color: #c40000; background: #fff5f5; }
    </style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
<div style="max-width: 1200px; margin: 0 auto; width: 100%;">

    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="font-size: 1.6rem; line-height: 1;">{{ $country->flag ?? '🏳️' }}</div>
                <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                    <span>Détail du pays · {{ $country->name }}</span>
                </div>
            </div>

            <div style="display: flex; gap: 8px;">
                <a href="{{ route('admin.countries.edit', $country) }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                    <i class="fas fa-edit" style="color: #ff9900;"></i> Modifier
                </a>
                <a href="{{ route('admin.countries.index') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                    <i class="fas fa-globe-africa" style="color: #ff9900;"></i> Retour à la liste
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="flash flash-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash flash-error">{{ session('error') }}</div>
        @endif

        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">

            <!-- Colonne gauche -->
            <div style="display: flex; flex-direction: column; gap: 20px;">

                <div class="amazon-card" style="margin: 0;">
                    <h3 class="section-title">Régions ({{ $regionsCount }})</h3>

                    <form action="{{ route('admin.countries.import-geography', $country) }}" method="POST" style="margin-bottom: 16px;"
                          onsubmit="this.querySelector('button').disabled = true; this.querySelector('button').innerHTML = '<i class=\'fas fa-spinner fa-spin\'></i> Import en cours…';">
                        @csrf
                        <button type="submit" class="btn-amazon-primary">
                            <i class="fas fa-cloud-download-alt"></i> Importer les régions (OpenStreetMap)
                        </button>
                    </form>

                    <form action="{{ route('admin.countries.regions.store', $country) }}" method="POST" class="inline-add">
                        @csrf
                        <input type="text" name="name" placeholder="Ajouter une région…" required>
                        <button type="submit" class="btn-amazon-secondary"><i class="fas fa-plus"></i> Ajouter</button>
                    </form>

                    <table style="width: 100%; border-collapse: collapse; border: 1px solid #eff3f6;">
                        <thead>
                            <tr style="background: #f6f6f6; border-bottom: 1px solid #eff3f6;">
                                <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #eff3f6;">Région</th>
                                <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($country->regions as $region)
                                <tr style="border-bottom: 1px solid #eff3f6; transition: background 0.1s;"
                                    onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                                    <td style="padding: 12px 15px; font-size: 0.82rem; color: #111; font-weight: 600; border-right: 1px solid #eff3f6;">
                                        <i class="fas fa-map-marker-alt" style="color: #ff9900;"></i> &nbsp;{{ $region->name }}
                                    </td>
                                    <td style="padding: 12px 15px; text-align: right;">
                                        <form action="{{ route('admin.countries.regions.destroy', $region) }}" method="POST"
                                              onsubmit="return confirm('Supprimer la région « {{ $region->name }} » ?')" style="display: inline;">
                                            @csrf @method('DELETE')
                                            <button type="submit"
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
                                    <td colspan="2" style="padding: 2rem; text-align: center; color: #999; font-size: 0.82rem;">
                                        Aucune région. Importez-les depuis OpenStreetMap ou ajoutez-les manuellement.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Colonne droite -->
            <div style="display: flex; flex-direction: column; gap: 20px;">

                <div class="amazon-card" style="margin: 0;">
                    <h3 class="section-title">Résumé</h3>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                        <span class="field-label" style="margin: 0;">Statut</span>
                        <span class="badge-amazon {{ $country->is_active ? 'badge-amazon-success' : 'badge-amazon-danger' }}">
                            {{ $country->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="field-label" style="margin: 0;">Régions enregistrées</span>
                        <span style="font-weight: 800; color: #111; font-size: 1.1rem;">{{ $regionsCount }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
