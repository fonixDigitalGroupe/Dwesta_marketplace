@extends('layouts.admin')

@section('title', 'Détail du pays · ' . $country->name)

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }

        .btn-amazon-primary {
            background: linear-gradient(180deg, #ff9900 0%, #e77600 100%);
            border: 1px solid #c05d00;
            color: #fff !important;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-amazon-primary:hover { background: linear-gradient(180deg, #e77600 0%, #c05d00 100%); color: #fff !important; }

        .btn-amazon-secondary {
            background: #fff;
            border: 1px solid #e2e8f0;
            color: #475569 !important;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }
        .btn-amazon-secondary:hover { background: #f8fafc; border-color: #cbd5e1; }

        .stat-card {
            background: #fff; border: 1px solid #eff3f6; border-radius: 8px;
            padding: 16px 20px; flex: 1; min-width: 140px;
        }
        .stat-card .num { font-size: 1.6rem; font-weight: 800; color: #111; line-height: 1; }
        .stat-card .lbl { font-size: 0.7rem; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 6px; }

        .region-card {
            border: 1px solid #eff3f6; border-radius: 8px; margin-bottom: 14px; overflow: hidden;
        }
        .region-head {
            background: #f6f6f6; padding: 12px 16px; display: flex; justify-content: space-between;
            align-items: center; border-bottom: 1px solid #eff3f6;
        }
        .inline-add { display: inline-flex; gap: 6px; margin-top: 8px; }
        .inline-add input {
            border: 1px solid #cbd5e1; border-radius: 4px; padding: 4px 8px; font-size: 0.78rem; min-width: 160px;
        }
        .inline-add button {
            background: #fff; border: 1px solid #cbd5e1; border-radius: 4px; padding: 4px 10px;
            font-size: 0.78rem; cursor: pointer; color: #0066c0; font-weight: 600;
        }
        .flash { padding: 12px 16px; border-radius: 6px; font-size: 0.85rem; margin-bottom: 16px; }
        .flash-success { background: #f7fff0; color: #3d6b00; border: 1px solid #cdeaa8; }
        .flash-error { background: #fff5f5; color: #c40000; border: 1px solid #f5c2c2; }
    </style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
    <div style="max-width: 1600px; margin: 0 auto; width: 100%;">
        <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

            @if(session('success'))
                <div class="flash flash-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="flash flash-error">{{ session('error') }}</div>
            @endif

            <!-- En-tête pays -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 1px solid #eff3f6; padding-bottom: 18px; margin-bottom: 20px; gap: 20px; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="font-size: 3rem; line-height: 1;">{{ $country->flag ?? '🏳️' }}</div>
                    <div>
                        <div style="font-size: 1.3rem; font-weight: 800; color: #111;">{{ $country->name }}</div>
                        <div style="font-size: 0.8rem; color: #64748b; margin-top: 4px;">
                            <code style="background: #f8fafc; padding: 2px 6px; border-radius: 3px;">{{ $country->code }}</code>
                            &nbsp;·&nbsp; {{ $country->phone_code ?? '—' }}
                            &nbsp;·&nbsp; {{ $country->currency ?? 'FCFA' }}
                            &nbsp;·&nbsp;
                            <span class="badge-amazon {{ $country->is_active ? 'badge-amazon-success' : 'badge-amazon-danger' }}">
                                {{ $country->is_active ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('admin.countries.index') }}" class="btn-amazon-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <a href="{{ route('admin.countries.edit', $country) }}" class="btn-amazon-secondary">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                </div>
            </div>

            <!-- Stats + carte -->
            <div style="display: flex; gap: 16px; flex-wrap: wrap; margin-bottom: 24px;">
                <div class="stat-card">
                    <div class="num">{{ $regionsCount }}</div>
                    <div class="lbl">Régions</div>
                </div>
                @if($country->map)
                    <div style="flex: 2; min-width: 220px; border: 1px solid #eff3f6; border-radius: 8px; overflow: hidden;">
                        <img src="{{ asset('storage/' . $country->map) }}" alt="Carte {{ $country->name }}"
                             style="width: 100%; height: 140px; object-fit: cover; display: block;">
                    </div>
                @endif
            </div>

            <!-- Barre d'import -->
            <div style="display: flex; justify-content: space-between; align-items: center; background: #fffaf3; border: 1px solid #ffe2c2; border-radius: 8px; padding: 16px; margin-bottom: 24px; gap: 16px; flex-wrap: wrap;">
                <div style="font-size: 0.85rem; color: #7c4a00;">
                    <strong>Import automatique</strong> — récupère les régions de {{ $country->name }} depuis OpenStreetMap.
                    <div style="font-size: 0.75rem; color: #a16207; margin-top: 4px;">L'opération peut prendre quelques secondes. Réexécutable sans créer de doublons.</div>
                </div>
                <form action="{{ route('admin.countries.import-geography', $country) }}" method="POST"
                      onsubmit="this.querySelector('button').disabled = true; this.querySelector('button').innerHTML = '<i class=\'fas fa-spinner fa-spin\'></i> Import en cours…';">
                    @csrf
                    <button type="submit" class="btn-amazon-primary">
                        <i class="fas fa-cloud-download-alt"></i> Importer les régions
                    </button>
                </form>
            </div>

            <!-- Ajout manuel d'une région -->
            <form action="{{ route('admin.countries.regions.store', $country) }}" method="POST" class="inline-add" style="margin-bottom: 20px;">
                @csrf
                <input type="text" name="name" placeholder="Ajouter une région…" required>
                <button type="submit"><i class="fas fa-plus"></i> Ajouter la région</button>
            </form>

            <!-- Liste des régions -->
            @forelse($country->regions as $region)
                <div class="region-card">
                    <div class="region-head">
                        <div style="font-weight: 700; color: #111; font-size: 0.9rem;">
                            <i class="fas fa-map-marker-alt" style="color: #e77600;"></i>
                            {{ $region->name }}
                        </div>
                        <form action="{{ route('admin.countries.regions.destroy', $region) }}" method="POST"
                              onsubmit="return confirm('Supprimer la région « {{ $region->name }} » ?')">
                            @csrf @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: #c40000; cursor: pointer; font-size: 0.78rem;">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="padding: 3rem; text-align: center; color: #999; font-size: 0.9rem; border: 1px dashed #e2e8f0; border-radius: 8px;">
                    Aucune région enregistrée pour ce pays.<br>
                    Cliquez sur <strong>« Importer les régions »</strong> pour les récupérer automatiquement, ou ajoutez-les manuellement.
                </div>
            @endforelse

        </div>
    </div>
@endsection
