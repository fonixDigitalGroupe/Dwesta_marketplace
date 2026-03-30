@extends('layouts.admin')

@section('title', 'Créer un critère')

@push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
    </style>
@endpush

@section('content')
    <div style="max-width: 100%;">
        <!-- Titre en majuscules -->
        <h2 style="font-size: 0.85rem; color: #555; font-weight: 700; text-transform: uppercase; margin-bottom: 1.5rem; letter-spacing: 0.05em;">
            Créer un nouveau critère
        </h2>

        <!-- Barre d'outils -->
        <div style="display: flex; gap: 8px; margin-bottom: 1.5rem;">
            <a href="{{ route('admin.filters.index') }}" style="display: flex; align-items: center; gap: 8px; background: #fff; border: 1px solid #ddd; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem; color: #333; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                <i class="fas fa-arrow-left" style="font-size: 0.75rem; opacity: 0.6;"></i> Retour à la liste
            </a>
        </div>

        <form action="{{ route('admin.filters.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            Identité du Critère
                        </h3>
                        
                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 1.5rem;">
                            <!-- Sélection Niveau 1 -->
                            <div>
                                <label for="l1_category_id" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Catégorie <small style="color: red;">*</small></label>
                                <select id="l1_category_id" 
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; outline: none; background: #fff; cursor: pointer;">
                                    <option value="">-- Choisir --</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sélection Niveau 2 -->
                            <div>
                                <label for="l2_category_id" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Sous-catégorie <small style="color: red;">*</small></label>
                                <select id="l2_category_id" disabled
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; outline: none; background: #fdfdfd; cursor: not-allowed;">
                                    <option value="">-- Choisir --</option>
                                </select>
                            </div>

                            <!-- Sélection Niveau 3 -->
                            <div>
                                <label for="category_id" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Précision / Détail <small style="color: red;">*</small></label>
                                <select name="category_id" id="category_id" required disabled
                                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; outline: none; background: #fdfdfd; cursor: not-allowed;">
                                    <option value="">-- Choisir --</option>
                                </select>
                                <div id="loader" style="display: none; font-size: 0.75rem; color: #666; margin-top: 4px; align-items: center; gap: 5px;">
                                    <svg class="animate-spin" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48l2.83-2.83"></path>
                                    </svg>
                                    Chargement...
                                </div>
                            </div>
                        </div>

                         <div>
                            <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 600; color: #555; margin-bottom: 8px;">Nom du Critère <small style="color: red;">*</small></label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required placeholder="Ex: Couleur, Pointure, Marque..."
                                style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; outline: none; transition: border-color 0.2s; text-transform: capitalize;"
                                onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                        </div>

                        <input type="hidden" name="type" value="select">
                    </div>

                    <!-- Options Section -->
                    <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 600; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            Options de filtrage
                        </h3>

                        <div id="options-group">
                            <div id="options-container" style="display: flex; flex-direction: column; gap: 8px;">
                                <!-- Dynamic options will be added here -->
                            </div>

                            <div style="display: flex; gap: 8px; margin-top: 12px; align-items: center;">
                                <input type="text" id="new-option-input" placeholder="Nouvelle option..."
                                    style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.9rem; outline: none; transition: border-color 0.2s; text-transform: capitalize;"
                                    onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#ddd'">
                                <button type="button" id="add-option-btn-v2" 
                                    style="width: 42px; height: 42px; background: #2563eb; color: #fff; border: none; border-radius: 8px; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: background 0.2s;"
                                    onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div style="background: #fff; border: 1px solid #eee; border-radius: 2px; padding: 1.5rem;">
                        <h3 style="font-size: 0.9rem; color: #333; font-weight: 600; margin-bottom: 1.25rem; border-bottom: 1px solid #eee; padding-bottom: 10px;">Paramètres</h3>
                        
                        <div style="display: grid; gap: 1rem;">
                            <label style="display: flex; align-items: center; gap: 12px; cursor: pointer; user-select: none;">
                                <div style="position: relative; width: 20px; height: 20px;">
                                    <input type="checkbox" name="is_filterable" value="1" checked id="checkbox-is-filterable"
                                        style="position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0;">
                                    <div id="custom-checkbox" style="position: absolute; top: 0; left: 0; height: 20px; width: 20px; background-color: #999; border-radius: 4px; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                                        <i class="fas fa-check" style="color: #fff; font-size: 10px; opacity: 1;"></i>
                                    </div>
                                </div>
                                <span style="font-size: 0.85rem; font-weight: 600; color: #555;">Activer le filtre</span>
                            </label>
                        </div>
                        
                        <script>
                            document.getElementById('checkbox-is-filterable').addEventListener('change', function() {
                                const customBox = document.getElementById('custom-checkbox');
                                if (this.checked) {
                                    customBox.style.backgroundColor = '#999';
                                    customBox.querySelector('i').style.opacity = '1';
                                } else {
                                    customBox.style.backgroundColor = '#eee';
                                    customBox.querySelector('i').style.opacity = '0';
                                }
                            });
                        </script>

                        <div style="display: flex; gap: 10px; margin-top: 1.5rem;">
                            <a href="{{ route('admin.filters.index') }}" style="flex: 1; background: #dc2626; color: #fff; text-align: center; text-decoration: none; padding: 12px; border-radius: 4px; font-weight: 600; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                Annuler
                            </a>
                            <button type="submit" style="flex: 1; background: #e67e00; color: #fff; border: none; padding: 12px; border-radius: 4px; font-weight: 600; cursor: pointer; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                Enregistrer
                            </button>
                        </div>
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

            function resetSelect(select, placeholder) {
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

            l1Select.addEventListener('change', function() {
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
                    })
                    .catch(error => {
                        console.error('Error fetching categories:', error);
                        loader.style.display = 'none';
                    });
            });

            l2Select.addEventListener('change', function() {
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
                    })
                    .catch(error => {
                        console.error('Error fetching categories:', error);
                        loader.style.display = 'none';
                    });
            });

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
