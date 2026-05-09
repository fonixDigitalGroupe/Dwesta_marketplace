@extends('layouts.admin')

@section('title', 'Nouvel Onglet Actualités')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }

    /* Input Amazon Style */
    input[type="text"]:focus, input[type="number"]:focus,
    textarea:focus, select:focus {
        border-color: #e77600 !important;
        box-shadow: 0 0 3px 2px rgba(228,121,17,0.5) !important;
        outline: none;
    }

    /* Custom Checkbox Amazon Style */
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
    .checkbox-container:hover input ~ .checkmark {
        border-color: #e77600;
        box-shadow: 0 0 3px rgba(228,121,17,0.5);
    }
    .checkbox-container input:checked ~ .checkmark {
        background-color: #fff;
        border-color: #e77600;
    }
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

    .section-title {
        font-size: 1.1rem;
        font-weight: 500;
        color: #111;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e7e7e7;
    }

    .btn-amazon-primary {
        background: linear-gradient(to bottom, #f7dfa5, #f0c14b);
        border: 1px solid #a88734;
        color: #111;
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
        background: linear-gradient(to bottom, #f5d78e, #eeb933);
        border-color: #9c7e31;
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
<div style="max-width: 1200px; margin: 0 auto;">

    {{-- En-tête de page --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">
            Nouvel Onglet "Bento Grid"
        </h1>
        <a href="{{ route('admin.highlight-tabs.index') }}" class="btn-amazon-secondary">
            <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i>
            Retour à la liste
        </a>
    </div>

    <form method="POST" action="{{ route('admin.highlight-tabs.store') }}">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: stretch;">

            {{-- Section 1 : Identité --}}
            <div class="amazon-card">
                <h3 class="section-title">Identité de l'Onglet</h3>

                <div style="margin-bottom: 20px;">
                    <label for="name" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                        Nom de l'onglet <small style="color: red;">*</small>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0;
                               font-size: 0.85rem; outline: none; background: #fcfcfc;"
                        placeholder="Ex: Mode, High-Tech, Immobilier...">
                    @error('name')
                        <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 0;">
                    <label for="slug" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                        Slug (identifiant URL)
                        <span style="font-weight: 400; color: #777; font-size: 0.78rem;">&nbsp;— généré automatiquement si vide</span>
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                        style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0;
                               font-size: 0.85rem; outline: none; background: #fcfcfc;"
                        placeholder="ex: mode-homme">
                    @error('slug')
                        <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Section 2 : Configuration --}}
            <div class="amazon-card">
                <h3 class="section-title">Configuration</h3>

                <div style="margin-bottom: 20px;">
                    <label for="position" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                        Ordre d'affichage <small style="color: red;">*</small>
                    </label>
                    <input type="number" name="position" id="position" value="{{ old('position', 0) }}" min="0" required
                        style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0;
                               font-size: 0.85rem; outline: none; background: #fcfcfc;">
                    <p style="color: #777; font-size: 0.75rem; margin-top: 6px;">
                        Plus la valeur est basse, plus l'onglet apparaît en premier.
                    </p>
                    @error('position')
                        <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
                    <label class="checkbox-container">
                        <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <span style="font-weight: 500;">Activer cet onglet (visible sur le site)</span>
                    </label>
                </div>
            </div>

        </div>

        {{-- Footer Actions --}}
        <div style="display: flex; justify-content: flex-end; gap: 15px; padding-top: 20px;">
            <a href="{{ route('admin.highlight-tabs.index') }}" class="btn-amazon-secondary">
                Annuler
            </a>
            <button type="submit" class="btn-amazon-primary">
                Enregistrer l'onglet
            </button>
        </div>

    </form>
</div>
@endsection
