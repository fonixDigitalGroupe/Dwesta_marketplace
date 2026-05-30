@extends('layouts.admin')

@section('title', 'Modifier l\'Option : ' . $service->nom)

@push('styles')
    <style>
        /* Input Amazon Style Modernisé */
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
            box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15);
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
            color: #fff;
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
        }

        .btn-amazon-primary:hover {
            background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            color: #fff;
        }

        .btn-amazon-secondary {
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
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
        }

        .btn-amazon-secondary:hover {
            background: #f8fafc;
            border-color: #dee2e6;
            color: #1e293b;
        }

        /* Custom Checkbox */
        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            font-size: 0.85rem;
            color: #1e293b;
        }

        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        
        .checkmark {
            height: 18px;
            width: 18px;
            background-color: #fff;
            border: 2px solid #dee2e6;
            border-radius: 4px;
            position: relative;
            transition: all 0.2s;
        }
        
        .checkbox-container input:checked ~ .checkmark {
            background-color: #ff9900;
            border-color: #ff9900;
        }
        
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            left: 5px;
            top: 2px;
            width: 4px;
            height: 8px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        .checkbox-container input:checked ~ .checkmark:after {
            display: block;
        }
    </style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
<div style="max-width: 1000px; margin: 0 auto;">
    
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                    <i class="fas fa-edit" style="font-size: 0.8rem;"></i>
                    <span>Modifier l'Option : {{ $service->nom }}</span>
                </div>
            </div>
            
            <a href="{{ route('admin.settings.visibility') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                <i class="fas fa-list" style="color: #ff9900;"></i> Voir les options
            </a>
        </div>

        <form action="{{ route('admin.settings.visibility.update', $service) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 20px; align-items: start;">
                
                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Configuration du Service</h3>
                        
                        <div style="margin-bottom: 20px;">
                            <label class="field-label">Type de service <small style="color: red;">*</small></label>
                            <select name="service_type" required>
                                <option value="mise_en_avant" {{ old('service_type', $service->cle) == 'mise_en_avant' ? 'selected' : '' }}>Mise en avant</option>
                                <option value="boost" {{ old('service_type', $service->cle) == 'boost' ? 'selected' : '' }}>Boost visibilité</option>
                                <option value="video" {{ old('service_type', $service->cle) == 'video' ? 'selected' : '' }}>Ajout Vidéo</option>
                            </select>
                        </div>

                        <div style="margin-bottom: 0;">
                            <label class="field-label">Description <small style="color: red;">*</small></label>
                            <textarea name="description" rows="5" required placeholder="Décrivez les avantages de ce service...">{{ old('description', $service->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Paramètres & Tarif</h3>

                        <div style="margin-bottom: 15px;">
                            <label class="field-label">Crédit <small style="color: red;">*</small></label>
                            <input type="number" name="credits_requis" value="{{ old('credits_requis', $service->credits_requis) }}" min="0" required>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label class="field-label">Durée (Jours)</label>
                            <input type="number" name="duree_jours" value="{{ old('duree_jours', $service->duree_jours) }}" min="1" placeholder="Permanent">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label class="field-label">Ordre d'affichage</label>
                            <input type="number" name="ordre" value="{{ old('ordre', $service->ordre) }}">
                        </div>

                        <!-- Status Checkbox -->
                        <div style="border-top: 1px solid #f1f5f9; padding-top: 20px;">
                            <label class="checkbox-container">
                                <input type="checkbox" name="actif" value="1" {{ $service->actif ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                <span style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase;">Activer ce service</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Actions Row -->
                <div style="grid-column: 1 / -1; display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid #eff3f6; padding-top: 20px; margin-top: 10px;">
                    <a href="{{ route('admin.settings.visibility') }}" class="btn-amazon-secondary" style="width: auto; padding: 10px 24px;">
                        ANNULER
                    </a>
                    <button type="submit" class="btn-amazon-primary" style="width: auto; padding: 10px 32px;">
                        METTRE À JOUR
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
