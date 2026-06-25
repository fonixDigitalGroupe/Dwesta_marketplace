@extends('layouts.admin')

@section('title', 'Modifier l\'Onglet')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }

        /* Input Amazon Style Modernisé */
        input[type="text"],
        input[type="number"],
        input[type="date"],
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

        /* Buttons Alignés */
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
            width: 100%;
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
            width: 100%;
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
            flex-shrink: 0;
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

@section('content')
<div style="max-width: 1200px; margin: -30px auto 0;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

        {{-- Card Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-pen" style="font-size: 0.8rem;"></i>
                <span>Modifier l'Onglet</span>
            </div>

            <a href="{{ route('admin.highlight-tabs.index') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                <i class="fas fa-list" style="color: #ff9900;"></i> Voir les onglets
            </a>
        </div>

        {{-- Erreurs globales --}}
        @if($errors->any())
            <div style="background: #fff5f5; border: 1px solid #fecaca; padding: 15px; margin-bottom: 20px; border-radius: 6px;">
                <div style="color: #c40000; font-weight: 700; margin-bottom: 8px; font-size: 0.85rem;">
                    <i class="fas fa-exclamation-triangle"></i> Des erreurs sont survenues :
                </div>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li style="font-size: 0.8rem; color: #bf0000;">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.highlight-tabs.update', $highlightTab) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">

                {{-- Left Column --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Informations de l'onglet</h3>

                        <div>
                            <label for="name" class="field-label">Nom de l'onglet <small style="color: red;">*</small></label>
                            <input type="text" name="name" id="name" value="{{ old('name', $highlightTab->name) }}" required>
                            @error('name') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Right Column --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Configuration</h3>

                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <div>
                                <label for="position" class="field-label">Ordre d'affichage <small style="color: red;">*</small></label>
                                <input type="number" name="position" id="position" value="{{ old('position', $highlightTab->position) }}" min="0" required>
                                <p style="font-size: 0.7rem; color: #94a3b8; margin-top: 5px;">Plus bas = premier.</p>
                                @error('position') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>

                            <div style="border-top: 1px solid #f1f5f9; padding-top: 15px;">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="active" value="1" {{ old('active', $highlightTab->active) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    <span style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Onglet actif</span>
                                </label>
                            </div>
                        </div>

                        <div style="margin-top: 25px; display: grid; grid-template-columns: 1fr; gap: 10px;">
                            <button type="submit" class="btn-amazon-primary">
                                METTRE À JOUR
                            </button>
                            <a href="{{ route('admin.highlight-tabs.index') }}" class="btn-amazon-secondary">
                                ANNULER
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection
