@extends('layouts.admin')

@section('title', 'Nouveau Rôles')

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

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

        /* Buttons Alignés avec Index */
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
<div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                    <i class="fas fa-plus" style="font-size: 0.8rem;"></i>
                    <span>Nouveau rôle</span>
                </div>
            </div>
            
            <a href="{{ route('admin.roles.index') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                <i class="fas fa-list" style="color: #ff9900;"></i> Voir la liste
            </a>
        </div>

        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; align-items: start;">
                
                <!-- Left Column: Role Identity -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Identité du rôle</h3>
                        
                        <div style="margin-bottom: 20px;">
                            <label for="name" class="field-label">Nom du rôle <small style="color: red;">*</small></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                                   placeholder="Ex: Responsable Logistique"
                                   oninput="if(this.value) this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                            @error('name') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>

                        <div style="border-top: 1px solid #f1f5f9; padding-top: 20px; margin-top: 20px;">
                            <label class="checkbox-container">
                                <input type="checkbox" name="is_active" value="1" checked>
                                <span class="checkmark"></span>
                                <span style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Activer ce rôle</span>
                            </label>
                            <p style="font-size: 0.75rem; color: #64748b; margin-left: 28px; margin-top: 6px;">
                                Si décoché, les utilisateurs associés ne pourront plus utiliser les fonctionnalités liées à ce rôle.
                            </p>
                        </div>
                    </div>

                    <!-- Actions Column -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                        <button type="submit" class="btn-amazon-primary">
                            ENREGISTRER
                        </button>
                        <a href="{{ route('admin.roles.index') }}" class="btn-amazon-secondary">
                            ANNULER
                        </a>
                    </div>
                </div>

                <!-- Right Column: Permissions -->
                <div class="amazon-card" style="margin: 0;">
                    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 10px; margin-bottom: 20px;">
                        <h3 style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.06em; margin: 0;">Permissions accordées</h3>
                        <div style="display: flex; gap: 15px;">
                            <button type="button" onclick="document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = true)"
                                    style="background: none; border: none; color: #0066c0; font-size: 0.75rem; cursor: pointer; padding: 0; font-weight: 600;"
                                    onmouseover="this.style.textDecoration='underline'"
                                    onmouseout="this.style.textDecoration='none'">
                                TOUT SÉLECTIONNER
                            </button>
                            <span style="color: #cbd5e1;">|</span>
                            <button type="button" onclick="document.querySelectorAll('.perm-checkbox').forEach(cb => cb.checked = false)"
                                    style="background: none; border: none; color: #0066c0; font-size: 0.75rem; cursor: pointer; padding: 0; font-weight: 600;"
                                    onmouseover="this.style.textDecoration='underline'"
                                    onmouseout="this.style.textDecoration='none'">
                                TOUT DÉCOCHER
                            </button>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 12px;">
                        @foreach($permissions as $permission)
                            <label class="checkbox-container">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="perm-checkbox">
                                <span class="checkmark"></span>
                                <span style="font-size: 0.8rem; color: #475569;">{{ $labels[$permission->name] ?? $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>

        </form>
    </div>
</div>
@endsection