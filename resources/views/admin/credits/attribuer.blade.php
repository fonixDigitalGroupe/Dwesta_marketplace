@extends('layouts.admin')

@section('title', 'Attribuer des crédits')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
    /* Input Amazon Style */
    input[type="text"]:focus, input[type="number"]:focus, textarea:focus, select:focus {
        border-color: #e77600 !important;
        box-shadow: 0 0 3px 2px rgba(228,121,17,0.5) !important;
        outline: none;
    }

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
    }
    .btn-amazon-primary:hover {
        background: linear-gradient(to bottom, #f5d78e, #eeb933);
        border-color: #9c7e31;
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
    }
    .btn-amazon-secondary:hover {
        background: linear-gradient(to bottom, #e7eaf0, #d8dade);
        border-color: #a2a6ac;
    }
</style>
@endpush

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">Attribuer des crédits</h1>
        <a href="{{ route('admin.credits.dashboard') }}" class="btn-amazon-secondary" style="gap: 8px;">
            <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i> Tableau de bord
        </a>
    </div>

    @if($errors->any())
        <div style="background-color: #fff9f9; border: 1px solid #c40000; color: #c40000; padding: 10px 15px; font-size: 0.85rem; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 1.2rem;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="amazon-card">
        <h3 class="section-title">Informations d'attribution</h3>

        <form method="POST" action="{{ route('admin.credits.attribuer.store') }}">
            @csrf

            <div style="display: grid; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                        Utilisateur bénéficiaire <small style="color: red;">*</small>
                    </label>
                    <select name="user_id" required 
                        style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; color: #111; outline: none; background: #fcfcfc; cursor: pointer;">
                        <option value="">-- Choisir un utilisateur --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->prenom }} {{ $user->nom }} — {{ $user->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                            Nombre de crédits <small style="color: red;">*</small>
                        </label>
                        <input type="number" name="montant" value="{{ old('montant') }}" min="1" required
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; color: #111; outline: none; background: #fcfcfc;">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">
                        Raison / Note (sera visible sur le tableau de bord) <small style="color: red;">*</small>
                    </label>
                    <input type="text" name="raison" value="{{ old('raison') }}" required placeholder="Ex: Compensation pour erreur technique..."
                        style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; color: #111; outline: none; background: #fcfcfc;">
                </div>
            </div>

            <hr style="border: 0; border-top: 1px solid #e7e7e7; margin: 25px 0;">

            <div style="display: flex; gap: 15px; justify-content: flex-end;">
                <a href="{{ route('admin.credits.dashboard') }}" class="btn-amazon-secondary">
                    Annuler
                </a>
                <button type="submit" class="btn-amazon-primary">
                    Attribuer les crédits
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
