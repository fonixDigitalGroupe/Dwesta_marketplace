@extends('layouts.admin')

@section('title', 'Modifier le critère de filtrage')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        
        /* Input Amazon Style */
        input[type="text"]:focus, 
        select:focus {
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

        .remove-option-btn {
            background: #fff;
            border: 1px solid #adb1b8;
            color: #c40000;
            padding: 0 12px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .remove-option-btn:hover {
            background: #f7f8fa;
            border-color: #c40000;
        }
    </style>
@endpush

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">Modifier le critère : {{ $filter->nom }}</h1>
        <a href="{{ route('admin.filters.index') }}" class="btn-amazon-secondary" style="gap: 8px;">
            <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i> Retour à la liste
        </a>
    </div>

    <form action="{{ route('admin.filters.update', $filter->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr 400px; gap: 20px; align-items: stretch;">
            
            <!-- Left Column: Identité -->
            <div class="amazon-card">
                <h3 class="section-title">Identité du Critère</h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    <div>
                        <label for="l1_category_id" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Niveau 1 <small style="color: red;">*</small></label>
                        <select id="l1_category_id" 
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc; cursor: pointer;">
                            <option value="">-- Choisir --</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" {{ $l1Id == $parent->id ? 'selected' : '' }}>{{ $parent->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="l2_category_id" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Niveau 2 <small style="color: red;">*</small></label>
                        <select id="l2_category_id" {{ !$l2Id ? 'disabled' : '' }}
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: {{ $l2Id ? '#fcfcfc' : '#f7f8fa' }}; cursor: {{ $l2Id ? 'pointer' : 'not-allowed' }};">
                            <option value="">-- Choisir --</option>
                            @if($l2Id)
                                <option value="{{ $l2Id }}" selected>{{ $filter->category->parent->nom ?? ($l3Id ? $filter->category->parent->nom : $filter->category->nom) }}</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                    <div>
                        <label for="category_id" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Niveau 3 <small style="color: red;">*</small></label>
                        <select name="category_id" id="category_id" required {{ !$l3Id ? 'disabled' : '' }}
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: {{ $l3Id ? '#fcfcfc' : '#f7f8fa' }}; cursor: {{ $l3Id ? 'pointer' : 'not-allowed' }};">
                            <option value="">-- Choisir --</option>
                            @if($l3Id)
                                <option value="{{ $l3Id }}" selected>{{ $filter->category->nom }}</option>
                            @endif
                        </select>
                        <div id="loader" style="display: none; font-size: 0.75rem; color: #0066c0; margin-top: 6px; align-items: center; gap: 5px;">
                            <i class="fas fa-spinner fa-spin"></i> Chargement des catégories...
                        </div>
                    </div>

                    <div>
                        <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Nom du Critère <small style="color: red;">*</small></label>
                        <input type="text" name="nom" id="nom" value="{{ old('nom', $filter->nom) }}" required 
                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc; text-transform: capitalize;">
                    </div>
                </div>

                <input type="hidden" name="type" value="select">
            </div>

            <!-- Right Column: Options -->
            <div class="amazon-card" style="display: flex; flex-direction: column;">
                <h3 class="section-title">Options de filtrage</h3>

                <div style="flex: 1;">
                    <p style="font-size: 0.8rem; color: #555; margin-bottom: 15px;">Valeurs existantes et nouvelles options.</p>
                    
                    <div id="options-container" style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                        @if($filter->options)
                            @foreach($filter->options as $option)
                                <div style="display: flex; gap: 0;">
                                    <input type="text" name="options[]" value="{{ $option }}" required
                                        style="flex: 1; padding: 8px 12px; border: 1px solid #adb1b8; border-right: none; border-radius: 0; font-size: 0.85rem; outline: none; background: #fff; text-transform: capitalize;">
                                    <button type="button" class="remove-option-btn" style="border-radius: 0;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div style="display: flex; gap: 0; align-items: stretch;">
                        <input type="text" id="new-option-input" placeholder="Ajouter une option..."
                            style="flex: 1; padding: 8px 12px; border: 1px solid #adb1b8; border-right: none; border-radius: 0; font-size: 0.85rem; outline: none; background: #fff;">
                        <button type="button" id="add-option-btn-v2" class="btn-amazon-secondary" style="padding: 0 15px; border-left: none;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                    <button type="submit" class="btn-amazon-primary" style="padding: 12px;">
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('admin.filters.index') }}" class="btn-amazon-secondary" style="padding: 12px;">
                        Annuler
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const l1Select = document.getElementById('l1_category_id');
        const l2Select = document.getElementById('l2_category_id');
        const l3Select = document.getElementById('category_id');
        const loader = document.getElementById('loader');

        const initialL2Id = "{{ $l2Id }}";
        const initialL3Id = "{{ $l3Id }}";

        function resetSelect(select) {
            select.innerHTML = `<option value="">-- Choisir --</option>`;
            select.disabled = true;
            select.style.background = '#f7f8fa';
            select.style.cursor = 'not-allowed';
        }

        function enableSelect(select) {
            select.disabled = false;
            select.style.background = '#fcfcfc';
            select.style.cursor = 'pointer';
        }

        function fetchChildren(parentId, targetSelect, placeholder, selectedId = null) {
            if (!parentId) return Promise.resolve();
            loader.style.display = 'flex';
            return fetch(`/admin/filters/categories/${parentId}/children`)
                .then(response => response.json())
                .then(data => {
                    targetSelect.innerHTML = `<option value="">-- ${placeholder} --</option>`;
                    data.forEach(child => {
                        const option = document.createElement('option');
                        option.value = child.id;
                        option.textContent = child.nom;
                        if (selectedId && child.id == selectedId) option.selected = true;
                        targetSelect.appendChild(option);
                    });
                    enableSelect(targetSelect);
                    loader.style.display = 'none';
                });
        }

        l1Select.addEventListener('change', function() {
            resetSelect(l2Select);
            resetSelect(l3Select);
            if (this.value) fetchChildren(this.value, l2Select, 'Choisir');
        });

        l2Select.addEventListener('change', function() {
            resetSelect(l3Select);
            if (this.value) fetchChildren(this.value, l3Select, 'Choisir');
        });

        if (l1Select.value) {
            fetchChildren(l1Select.value, l2Select, 'Choisir', initialL2Id)
                .then(() => {
                    if (l2Select.value) {
                        fetchChildren(l2Select.value, l3Select, 'Choisir', initialL3Id);
                    }
                });
        }

        const container = document.getElementById('options-container');
        const input = document.getElementById('new-option-input');
        const btn = document.getElementById('add-option-btn-v2');

        function setupOption(div) {
            div.querySelector('.remove-option-btn').onclick = () => div.remove();
            div.querySelector('input').onfocus = function() {
                this.style.borderColor = '#e77600';
                this.style.boxShadow = '0 0 3px 2px rgba(228,121,17,0.5)';
            };
            div.querySelector('input').onblur = function() {
                this.style.borderColor = '#adb1b8';
                this.style.boxShadow = 'none';
            };
        }

        function addOption(val = '') {
            if (!val) return;
            const div = document.createElement('div');
            div.style.display = 'flex';
            div.style.gap = '0';
            div.innerHTML = `
                <input type="text" name="options[]" value="${val}" required
                    style="flex: 1; padding: 8px 12px; border: 1px solid #adb1b8; border-right: none; border-radius: 0; font-size: 0.85rem; outline: none; background: #fff; text-transform: capitalize;">
                <button type="button" class="remove-option-btn" style="border-radius: 0;">
                    <i class="fas fa-times"></i>
                </button>
            `;
            setupOption(div);
            container.appendChild(div);
        }

        document.querySelectorAll('#options-container > div').forEach(setupOption);

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
@endsection
