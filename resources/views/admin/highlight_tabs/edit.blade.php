@extends('layouts.admin')

@section('title', 'Modifier l\'Onglet')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }

    input[type="text"]:focus, input[type="number"]:focus,
    textarea:focus, select:focus {
        border-color: #e77600 !important;
        outline: none;
    }

    .checkbox-container {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        padding: 4px 0;
        user-select: none;
        font-size: 0.85rem;
        color: #111;
    }
    .checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
    .checkmark {
        height: 16px;
        width: 16px;
        background-color: #fff;
        border: 1px solid #adb1b8;
        border-radius: 0;
        position: relative;
        transition: all 0.1s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) inset;
        flex-shrink: 0;
    }
    .checkbox-container:hover input ~ .checkmark { border-color: #e77600; }
    .checkbox-container input:checked ~ .checkmark { background-color: #fff; border-color: #e77600; }
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        left: 5px;
        top: 1px;
        width: 4px;
        height: 8px;
        border: solid #e77600;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }
    .checkbox-container input:checked ~ .checkmark:after { display: block; }

    .amazon-card {
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        padding: 25px;
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #111;
        margin-bottom: 8px;
    }

    .form-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #adb1b8;
        border-radius: 0;
        font-size: 0.85rem;
        outline: none;
        background: #fcfcfc;
        box-sizing: border-box;
    }

    .form-group { margin-bottom: 20px; }
    .form-group:last-child { margin-bottom: 0; }

    .form-error {
        color: #bf0000;
        font-size: 0.75rem;
        margin-top: 6px;
    }

    .btn-amazon-primary {
        background: linear-gradient(180deg, #007bff 0%, #0056b3 100%);
        border: 1px solid #004aad;
        color: #fff;
        padding: 8px 24px;
        border-radius: 0;
        font-size: 0.85rem;
        font-weight: 400;
        text-decoration: none;
        box-shadow: 0 1px 0 rgba(255,255,255,.4) inset;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .btn-amazon-primary:hover {
        background: linear-gradient(180deg, #0069d9 0%, #004494 100%);
        border-color: #003d82;
        color: #111;
        text-decoration: none;
    }

    .btn-amazon-secondary {
        background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
        border: 1px solid #adb1b8;
        color: #111;
        padding: 8px 24px;
        border-radius: 0;
        font-size: 0.85rem;
        font-weight: 400;
        text-decoration: none;
        box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .btn-amazon-secondary:hover {
        background: linear-gradient(to bottom, #e7eaf0, #d8dade);
        border-color: #a2a6ac;
        color: #111;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div style="max-width: 100%; margin-top: -50px;">

    <div style="background: #fff; border: 1px solid #e7e7e7; border-top: none; padding: 25px;">
        {{-- Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">Modifier l'Onglet</h1>
            <a href="{{ route('admin.highlight-tabs.index') }}" class="btn-amazon-secondary" style="gap: 8px;">
                <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i> Retour à la liste
            </a>
        </div>

        <form action="{{ route('admin.highlight-tabs.update', $highlightTab) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 25px; align-items: start;">

            {{-- Colonne gauche : Identité --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                <div class="amazon-card">
                    <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #111; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                        Informations de l'Onglet
                    </h2>

                    <div class="form-group">
                        <label for="name" class="form-label">
                            Nom de l'onglet <span style="color: #c40000;">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $highlightTab->name) }}" required
                            class="form-input"
                            placeholder="Ex: Mode, High-Tech, Immobilier...">
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Colonne droite : Configuration --}}
            <div style="display: flex; flex-direction: column; gap: 25px;">
                <div class="amazon-card">
                    <h2 style="font-size: 1rem; font-weight: 700; margin-bottom: 15px; color: #111;">Configuration</h2>

                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div class="form-group">
                            <label for="position" class="form-label">
                                Ordre d'affichage <span style="color: #c40000;">*</span>
                            </label>
                            <input type="number" name="position" id="position"
                                value="{{ old('position', $highlightTab->position) }}" min="0" required
                                class="form-input" style="background: #fff; height: 40px;">
                            <p style="color: #777; font-size: 0.75rem; margin-top: 6px;">
                                Plus la valeur est basse, plus l'onglet apparaît en premier.
                            </p>
                            @error('position')
                                <p class="form-error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group" style="padding-top: 5px;">
                            <label class="checkbox-container" style="margin: 0; padding: 0;">
                                <input type="checkbox" name="active" value="1"
                                       {{ old('active', $highlightTab->active) ? 'checked' : '' }}
                                       style="width: 18px; height: 18px; cursor: pointer; accent-color: #e47911;">
                                <span class="checkmark"></span>
                                <div style="margin-left: 5px;">
                                    <div style="font-size: 0.85rem; font-weight: 700; color: #111;">Onglet actif</div>
                                    <div style="font-size: 0.75rem; color: #555;">Désactivez pour masquer tout le groupe d'actualités.</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div style="margin-top: 30px; display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit" class="btn-amazon-primary" style="width: 100%; height: 40px; font-weight: 700;">
                            Mettre à jour l'onglet
                        </button>
                        <a href="{{ route('admin.highlight-tabs.index') }}" class="btn-amazon-secondary" style="width: 100%; height: 40px;">
                            Annuler
                        </a>
                    </div>
                </div>
            </div>

        </div>

        </form>
    </div>
</div>
@endsection
