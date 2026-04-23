@extends('layouts.admin')

@section('title', 'Modifier le critère')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        .checkbox-container {
            display: flex;
            align-items: center;
            position: relative;
            padding-left: 35px;
            margin-bottom: 0;
            cursor: pointer;
            font-size: 14px;
            user-select: none;
        }
        .checkbox-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 22px;
            width: 22px;
            background-color: #eee;
            border-radius: 6px;
            transition: all 0.2s;
        }
        .checkbox-container:hover input ~ .checkmark {
            background-color: #ccc;
        }
        .checkbox-container input:checked ~ .checkmark {
            background-color: #e67e00;
        }
        .checkmark:after {
            content: "\f00c";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            display: none;
            color: white;
            font-size: 12px;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .checkbox-container input:checked ~ .checkmark:after {
            display: block;
        }
    </style>
@endpush

@section('content')
    <div style="max-width: 100%;">
        <!-- Main Conteneur -->
        <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1.5rem;">
            
            <div style="margin-bottom: 0.5rem;">
                <h1 style="font-size: 1.25rem; font-weight: 700; color: #333; margin: 0;">Modifier le Critère : {{ $filter->nom }}</h1>
            </div>
            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1rem;"></div>

            <div style="display: flex; justify-content: flex-end; align-items: center; margin-bottom: 1rem;">
                <a href="{{ route('admin.filters.index') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.borderColor='#e67e00'" onmouseout="this.style.borderColor='#ddd'">
                    Retour à la liste <i class="fas fa-undo" style="font-size: 0.75rem; opacity: 0.6;"></i>
                </a>
            </div>

            <div style="border-bottom: 1px solid #f3f3f3; margin-bottom: 1.5rem;"></div>

            <form action="{{ route('admin.filters.update', $filter->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Grid Layout Side-by-Side -->
                <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 2rem; align-items: stretch;">
                    
                    <!-- Left Column: Identité -->
                    <div style="background: #fdfdfd; border: 1px solid #f3f3f3; border-radius: 4px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            Identité du Critère
                        </h3>
                        
                        <div style="display: grid; gap: 1.5rem;">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                <!-- Sélection Niveau 1 -->
                                <div>
                                    <label for="l1_category_id" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Niveau 1 <small style="color: red;">*</small></label>
                                    <select id="l1_category_id" 
                                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; outline: none; background: #fff; cursor: pointer; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                                        <option value="">-- Choisir --</option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}" {{ $l1Id == $parent->id ? 'selected' : '' }}>{{ $parent->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Sélection Niveau 2 -->
                                <div>
                                    <label for="l2_category_id" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Niveau 2 <small style="color: red;">*</small></label>
                                    <select id="l2_category_id" {{ !$l2Id ? 'disabled' : '' }}
                                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; outline: none; background: {{ $l2Id ? '#fff' : '#fdfdfd' }}; cursor: {{ $l2Id ? 'pointer' : 'not-allowed' }}; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                                        <option value="">-- Choisir --</option>
                                        @if($l2Id)
                                            <option value="{{ $l2Id }}" selected>{{ $filter->category->parent->nom ?? ($l3Id ? $filter->category->parent->nom : $filter->category->nom) }}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                <!-- Sélection Niveau 3 -->
                                <div>
                                    <label for="category_id" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Niveau 3 <small style="color: red;">*</small></label>
                                    <select name="category_id" id="category_id" required {{ !$l3Id ? 'disabled' : '' }}
                                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; outline: none; background: {{ $l3Id ? '#fff' : '#fdfdfd' }}; cursor: {{ $l3Id ? 'pointer' : 'not-allowed' }}; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                                        <option value="">-- Choisir --</option>
                                        @if($l3Id)
                                            <option value="{{ $l3Id }}" selected>{{ $filter->category->nom }}</option>
                                        @endif
                                    </select>
                                    <div id="loader" style="display: none; font-size: 0.75rem; color: #666; margin-top: 4px; align-items: center; gap: 5px;">
                                        <i class="fas fa-spinner fa-spin"></i> Chargement...
                                    </div>
                                </div>

                                <div>
                                    <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Nom du Critère <small style="color: red;">*</small></label>
                                    <input type="text" name="nom" id="nom" value="{{ old('nom', $filter->nom) }}" required
                                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; outline: none; transition: all 0.2s; text-transform: capitalize;"
                                        onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                                </div>
                            </div>

                            <input type="hidden" name="type" value="select">
                        </div>
                    </div>

                    <!-- Right Column: Options & Paramètres -->
                    <div style="background: #fdfdfd; border: 1px solid #f3f3f3; border-radius: 4px; padding: 1.5rem; display: flex; flex-direction: column;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            Options & Paramètres
                        </h3>

                        <div style="flex: 1;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 12px;">Options de filtrage</label>
                            
                            <div id="options-group">
                                <div id="options-container" style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 15px;">
                                    @if($filter->options)
                                        @foreach($filter->options as $option)
                                            <div style="display: flex; gap: 10px;">
                                                <input type="text" name="options[]" value="{{ $option }}" placeholder="Nom de l'option"
                                                    style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; outline: none; transition: all 0.2s; text-transform: capitalize;"
                                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                                                <button type="button" class="existing-remove-btn" 
                                                    style="width: 40px; height: 40px; background: #fff1f2; color: #e74c3c; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;"
                                                    onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fff1f2'">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div style="display: flex; gap: 10px; align-items: center;">
                                    <input type="text" id="new-option-input" placeholder="Ajouter une option..."
                                        style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 0.9rem; outline: none; transition: all 0.2s;"
                                        onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                                    <button type="button" id="add-option-btn-v2" 
                                        style="width: 40px; height: 40px; background: #e67e00; color: #fff; border: none; border-radius: 8px; font-size: 1.1rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
                                        onmouseover="this.style.background='#cf7100'" onmouseout="this.style.background='#e67e00'">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Actions Footer -->
                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #eee; display: flex; justify-content: flex-end; gap: 12px;">
                    <a href="{{ route('admin.filters.index') }}" 
                        style="background: #fff; border: 1px solid #ddd; color: #333; padding: 10px 24px; border-radius: 6px; font-size: 0.9rem; font-weight: 600; text-decoration: none; transition: all 0.2s;"
                        onmouseover="this.style.background='#f9f9f9'; this.style.borderColor='#ccc'" 
                        onmouseout="this.style.background='#fff'; this.style.borderColor='#ddd'">
                        Annuler
                    </a>
                    <button type="submit" 
                        style="background: #e67e00; color: #fff; border: none; padding: 10px 30px; border-radius: 6px; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.background='#cf7100'" 
                        onmouseout="this.style.background='#e67e00'">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
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
                select.style.background = '#fdfdfd';
                select.style.cursor = 'not-allowed';
            }

            function enableSelect(select) {
                select.disabled = false;
                select.style.background = '#fff';
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
                            if (selectedId && child.id == selectedId) {
                                option.selected = true;
                            }
                            targetSelect.appendChild(option);
                        });
                        enableSelect(targetSelect);
                        loader.style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        loader.style.display = 'none';
                    });
            }

            l1Select.addEventListener('change', function() {
                const parentId = this.value;
                resetSelect(l2Select);
                resetSelect(l3Select);
                if (parentId) {
                    fetchChildren(parentId, l2Select, 'Choisir');
                }
            });

            l2Select.addEventListener('change', function() {
                const parentId = this.value;
                resetSelect(l3Select);
                if (parentId) {
                    fetchChildren(parentId, l3Select, 'Choisir');
                }
            });

            // Initial Load for Edit Mode
            if (l1Select.value) {
                fetchChildren(l1Select.value, l2Select, 'Choisir', initialL2Id)
                    .then(() => {
                        if (l2Select.value) {
                            fetchChildren(l2Select.value, l3Select, 'Choisir', initialL3Id);
                        }
                    });
            }

            const optionsContainer = document.getElementById('options-container');
            const newOptionInput = document.getElementById('new-option-input');
            const addOptionBtn = document.getElementById('add-option-btn-v2');
            
            function addOption(value = '') {
                if (!value) return;

                const div = document.createElement('div');
                div.style.display = 'flex';
                div.style.gap = '8px';
                div.innerHTML = `
                    <input type="text" name="options[]" value="${value}" placeholder="Nom de l'option"
                        style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; outline: none; transition: border-color 0.2s; text-transform: capitalize;">
                    <button type="button" class="remove-option-btn" 
                        style="padding: 10px 14px; background: #fff1f2; color: #e74c3c; border: none; border-radius: 4px; cursor: pointer; transition: opacity 0.2s;"
                        onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                
                div.querySelector('.remove-option-btn').onclick = function() {
                    div.remove();
                };
                
                div.querySelector('input').onfocus = function() { this.style.borderColor = '#e67e00'; };
                div.querySelector('input').onblur = function() { this.style.borderColor = '#ddd'; };
                
                optionsContainer.appendChild(div);
            }

            // Setup existing remove buttons
            document.querySelectorAll('.existing-remove-btn').forEach(btn => {
                btn.onclick = function() {
                    btn.parentElement.remove();
                };
            });

            addOptionBtn.addEventListener('click', function() {
                const val = newOptionInput.value.trim();
                if (val) {
                    addOption(val);
                    newOptionInput.value = '';
                    newOptionInput.focus();
                }
            });

            newOptionInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    addOptionBtn.click();
                }
            });
        });
    </script>
    @endpush
@endsection
