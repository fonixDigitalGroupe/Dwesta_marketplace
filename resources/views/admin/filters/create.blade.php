@extends('layouts.admin')

@section('title', 'Créer un critère de filtrage')

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

        .remove-option-btn {
            background: #fff;
            border: 1px solid #dee2e6;
            color: #c40000;
            padding: 0 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .remove-option-btn:hover {
            background: #f1f5f9;
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
                    <span>Nouveau critère de filtrage</span>
                </div>
            </div>
            
            <a href="{{ route('admin.filters.index') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                <i class="fas fa-list" style="color: #ff9900;"></i> Voir les critères
            </a>
        </div>

        <form action="{{ route('admin.filters.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">
                
                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Identité du Critère</h3>
                        
                        <div style="margin-bottom: 15px;">
                            <label for="nom" class="field-label">Nom du Critère <small style="color: red;">*</small></label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required 
                                   placeholder="Couleur"
                                   oninput="if(this.value) this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                            @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <label for="l1_category_id" class="field-label">Niveau 1 <small style="color: red;">*</small></label>
                                <select id="l1_category_id">
                                    <option value="">-- Choisir --</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="l2_category_id" class="field-label">Niveau 2 <small style="color: red;">*</small></label>
                                <select id="l2_category_id" disabled style="background: #f8fafc; cursor: not-allowed;">
                                    <option value="">-- Choisir --</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-top: 20px;">
                            <label for="category_id" class="field-label">Niveau 3 <small style="color: red;">*</small></label>
                            <select name="category_id" id="category_id" required disabled style="background: #f8fafc; cursor: not-allowed;">
                                <option value="">-- Choisir --</option>
                            </select>
                            <div id="loader" style="display: none; font-size: 0.75rem; color: #3b82f6; margin-top: 6px; align-items: center; gap: 5px;">
                                <i class="fas fa-spinner fa-spin"></i> Chargement des catégories...
                            </div>
                        </div>
                        
                        <input type="hidden" name="type" value="select">
                    </div>

                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div class="amazon-card" style="margin: 0; display: flex; flex-direction: column; flex: 1;">
                        <h3 class="section-title">Options de filtrage</h3>

                        <div style="flex: 1;">
                            <div id="options-container" style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                                <!-- Options insérées dynamiquement -->
                            </div>

                            <div style="display: flex; gap: 0; align-items: stretch; margin-bottom: 20px;">
                                <input type="text" id="new-option-input" placeholder="Saisir une option..."
                                    oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"
                                    style="border-right: none; border-radius: 4px 0 0 4px;">
                                <button type="button" id="add-option-btn-v2" class="btn-amazon-secondary"
                                    style="width: 44px !important; border-radius: 0 4px 4px 0; border: 1px solid #dee2e6; border-left: none;">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Status Checkbox -->
                        <div style="border-top: 1px solid #f1f5f9; padding-top: 20px;">
                            <label class="checkbox-container">
                                <input type="checkbox" name="is_filterable" value="1" checked>
                                <span class="checkmark"></span>
                                <span style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Activer ce critère</span>
                            </label>
                            <p style="font-size: 0.75rem; color: #64748b; margin-left: 28px; margin-top: 6px;">
                                Si décoché, ce critère ne sera pas visible comme option de filtrage sur le site.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions Row -->
                <div style="grid-column: 1 / -1; display: grid; grid-template-columns: 140px 140px; gap: 12px; justify-content: end; border-top: 1px solid #eff3f6; padding-top: 20px;">
                    <button type="submit" class="btn-amazon-primary">
                        ENREGISTRER
                    </button>
                    <a href="{{ route('admin.filters.index') }}" class="btn-amazon-secondary">
                        ANNULER
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const l1Select = document.getElementById('l1_category_id');
        const l2Select = document.getElementById('l2_category_id');
        const l3Select = document.getElementById('category_id');
        const loader = document.getElementById('loader');

        function resetSelect(select) {
            select.innerHTML = `<option value="">-- Choisir --</option>`;
            select.disabled = true;
            select.style.background = '#f8fafc';
            select.style.cursor = 'not-allowed';
        }

        function enableSelect(select) {
            select.disabled = false;
            select.style.background = '#fff';
            select.style.cursor = 'auto'; // Reverts to the css default
        }

        l1Select.addEventListener('change', function () {
            const parentId = this.value;
            resetSelect(l2Select);
            resetSelect(l3Select);
            if (!parentId) return;

            loader.style.display = 'flex';
            fetch(`/admin/filters/categories/${parentId}/children`)
                .then(response => response.json())
                .then(data => {
                    l2Select.innerHTML = '<option value="">-- Choisir --</option>';
                    data.forEach(child => {
                        const option = document.createElement('option');
                        option.value = child.id;
                        option.textContent = child.nom;
                        l2Select.appendChild(option);
                    });
                    enableSelect(l2Select);
                    loader.style.display = 'none';
                });
        });

        l2Select.addEventListener('change', function () {
            const parentId = this.value;
            resetSelect(l3Select);
            if (!parentId) return;

            loader.style.display = 'flex';
            fetch(`/admin/filters/categories/${parentId}/children`)
                .then(response => response.json())
                .then(data => {
                    l3Select.innerHTML = '<option value="">-- Choisir --</option>';
                    data.forEach(child => {
                        const option = document.createElement('option');
                        option.value = child.id;
                        option.textContent = child.nom;
                        l3Select.appendChild(option);
                    });
                    enableSelect(l3Select);
                    loader.style.display = 'none';
                });
        });

        const container = document.getElementById('options-container');
        const input = document.getElementById('new-option-input');
        const btn = document.getElementById('add-option-btn-v2');

        function addOption(val = '') {
            if (!val) return;
            const div = document.createElement('div');
            div.style.display = 'flex';
            div.style.gap = '0';
            div.innerHTML = `
                <input type="text" name="options[]" value="${val}" required
                    style="border-right: none; border-radius: 4px 0 0 4px; text-transform: capitalize;">
                <button type="button" class="remove-option-btn" style="width: 44px; border-radius: 0 4px 4px 0; border-left: none;">
                    <i class="fas fa-times"></i>
                </button>
            `;
            div.querySelector('.remove-option-btn').onclick = () => div.remove();
            container.appendChild(div);
        }

        btn.onclick = () => {
            addOption(input.value.trim());
            input.value = '';
            input.focus();
        };

        input.onkeypress = (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                btn.click();
            }
        };
    });
</script>
@endpush