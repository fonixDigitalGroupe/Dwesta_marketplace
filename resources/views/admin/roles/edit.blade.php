@extends('layouts.admin')

@section('title', 'Modifier le Rôle')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
    /* Input Amazon Style */
    input[type="text"]:focus {
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
        border-radius: 2px;
        position: relative;
        transition: all 0.1s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) inset;
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
    
    .checkbox-container input:checked ~ .checkmark:after {
        display: block;
    }

    .amazon-card {
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 8px;
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
        border-radius: 3px;
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
        border-radius: 3px;
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
<div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">
            Modifier le rôle : <span style="color: #c45500; text-transform: capitalize;">{{ $role->name }}</span>
        </h1>
        <a href="{{ route('admin.roles.index') }}" class="btn-amazon-secondary" style="gap: 8px;">
            <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i> Retour à la liste
        </a>
    </div>

    @if(in_array($role->name, ['admin', 'vendeur', 'client']))
        <div style="background-color: #fffbeb; border: 1px solid #fef3c7; color: #111; padding: 12px 16px; margin-bottom: 20px; border-radius: 4px; font-size: 0.85rem; display: flex; gap: 12px; align-items: center;">
            <i class="fas fa-info-circle" style="color: #e77600; font-size: 1.1rem;"></i>
            <div>
                <strong>Note :</strong> Ce rôle est un rôle système critique. Vous ne pouvez pas modifier son nom ou son statut, uniquement ses permissions.
            </div>
        </div>
    @endif

    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 20px;">
            
            <!-- Information de base -->
            <div class="amazon-card">
                <h3 class="section-title">Identité du rôle</h3>
                
                <div style="margin-bottom: 20px;">
                    <label for="name" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 5px;">
                        Nom du rôle
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" required
                        @if(in_array($role->name, ['admin', 'vendeur', 'client'])) readonly style="width: 100%; padding: 8px 12px; border: 1px solid #e7e7e7; border-radius: 3px; font-size: 0.85rem; background: #f9f9f9; color: #777; cursor: not-allowed; outline: none;" @else 
                        style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 3px; font-size: 0.85rem; outline: none;" @endif>
                    @error('name') <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p> @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label class="checkbox-container" style="@if(in_array($role->name, ['admin', 'vendeur', 'client'])) opacity: 0.6; cursor: not-allowed; @endif">
                        <input type="checkbox" name="is_active" value="1" {{ $role->is_active ? 'checked' : '' }} @if(in_array($role->name, ['admin', 'vendeur', 'client'])) disabled @endif>
                        <span class="checkmark"></span>
                        <span style="font-weight: 500;">Rôle actif</span>
                    </label>
                    @if(in_array($role->name, ['admin', 'vendeur', 'client']))
                        <input type="hidden" name="is_active" value="1">
                    @endif
                </div>
            </div>

            <!-- Permissions -->
            <div class="amazon-card">
                <div style="display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 20px; border-bottom: 1px solid #e7e7e7; padding-bottom: 10px;">
                    <h3 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">Permissions accordées</h3>
                    <div style="display: flex; gap: 15px;">
                        <button type="button" onclick="document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = true)" 
                                style="background: none; border: none; color: #0066c0; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                            Tout cocher
                        </button>
                        <button type="button" onclick="document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false)" 
                                style="background: none; border: none; color: #0066c0; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                            Tout décocher
                        </button>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 12px;">
                    @foreach($permissions as $permission)
                        <label class="checkbox-container">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                   class="perm-checkbox"
                                   {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            <span>{{ $labels[$permission->name] ?? $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div style="display: flex; justify-content: flex-end; gap: 15px; padding-top: 20px;">
            <a href="{{ route('admin.roles.index') }}" class="btn-amazon-secondary">
                Annuler
            </a>
            <button type="submit" class="btn-amazon-primary">
                Mettre à jour le rôle
            </button>
        </div>

    </form>
</div>
@endsection
