@extends('layouts.admin')

@section('title', 'Ajouter un critère')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.filters.index') }}">Critères</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Ajouter</span>
@endsection

@section('content')
    <div style="max-width: 1000px; margin: 0 auto;">

        <header style="margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">Ajouter un critère</h1>
            <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Paramétrez un nouvel attribut dynamique pour vos catégories.</p>
        </header>

        <form action="{{ route('admin.filters.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">

                <!-- Left Colonne -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Section 1: Identité -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Identité du Critère
                        </h2>

                        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; align-items: start;">
                            <!-- Sélection Niveau 1 -->
                            <div>
                                <label for="l1_category_id" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Catégorie <span style="color: red;">*</span></label>
                                <select id="l1_category_id" 
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff; cursor: pointer;">
                                    <option value="">-- Choisir --</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}">{{ $parent->nom }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sélection Niveau 2 -->
                            <div>
                                <label for="l2_category_id" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Sous-catégorie <span style="color: red;">*</span></label>
                                <select id="l2_category_id" disabled
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fdfdfd; cursor: not-allowed;">
                                    <option value="">-- Choisir --</option>
                                </select>
                            </div>

                            <!-- Sélection Niveau 3 -->
                            <div>
                                <label for="category_id" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Précision / Détail <span style="color: red;">*</span></label>
                                <select name="category_id" id="category_id" required disabled
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fdfdfd; cursor: not-allowed;">
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

                        <div style="margin-top: 1.25rem;">
                            <label for="nom" style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Nom du Critère <span style="color: red;">*</span></label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required placeholder="ex: Couleur, Pointure, Marque..."
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">
                        </div>

                        <input type="hidden" name="type" value="select">
                    </div>

                    <!-- Section 2: Configuration des Options -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Options de filtrage
                        </h2>

                        <div id="options-group">
                            <div id="options-container" style="display: flex; flex-direction: column; gap: 8px;">
                                <!-- Dynamic options will be added here -->
                            </div>

                            <button type="button" id="add-option-btn" 
                                style="margin-top: 16px; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; padding: 12px; background: #fff; border: 2px dashed #e2e8f0; border-radius: 8px; font-size: 0.9rem; font-weight: 600; color: #64748b; cursor: pointer; transition: all 0.2s;"
                                onmouseover="this.style.borderColor='#cbd5e1'; this.style.background='#f8fafc'; this.style.color='#475569'" 
                                onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='#fff'; this.style.color='#64748b'">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                Ajouter une option
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Right Colonne -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem;">Paramètres</h3>

                        <div style="display: grid; gap: 1rem;">
                            <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                <input type="checkbox" name="is_filterable" value="1" checked
                                    style="width: 18px; height: 18px; accent-color: #000; cursor: pointer;">
                                <span style="font-size: 0.95rem; font-weight: 500; color: #333;">Activer le filtre</span>
                            </label>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit"
                            style="background-color: #000; color: #fff; border: none; padding: 12px; border-radius: 6px; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px; font-size: 0.95rem; transition: all 0.2s;"
                            onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">
                            Enregistrer
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                        <a href="{{ route('admin.filters.index') }}"
                            style="display: flex; justify-content: center; padding: 12px; background: #fff; border: 1px solid #e0e0e0; border-radius: 6px; color: #666; text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: all 0.2s;"
                            onmouseover="this.style.background='#f9f9f9'; this.style.color='#333'"
                            onmouseout="this.style.background='#fff'; this.style.color='#666'">
                            Annuler
                        </a>
                    </div>

                </div>

            </div>
        </form>
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
            const addOptionBtn = document.getElementById('add-option-btn');
            
            function toggleOptions() {
                if (optionsContainer.children.length === 0) {
                    addOption();
                }
            }

            function addOption(value = '') {
                const div = document.createElement('div');
                div.style.display = 'flex';
                div.style.gap = '8px';
                div.innerHTML = `
                    <input type="text" name="options[]" value="${value}" placeholder="Nom de l'option"
                        style="flex: 1; padding: 8px 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; outline: none; transition: border 0.2s;">
                    <button type="button" class="remove-option-btn" 
                        style="padding: 8px; background: #fff1f2; color: #ef4444; border: none; border-radius: 6px; cursor: pointer; transition: all 0.2s;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                `;
                
                div.querySelector('.remove-option-btn').onclick = function() {
                    if (optionsContainer.children.length > 1) {
                        div.remove();
                    } else {
                        div.querySelector('input').value = '';
                    }
                };
                
                div.querySelector('input').onfocus = function() { this.style.borderColor = '#000'; };
                div.querySelector('input').onblur = function() { this.style.borderColor = '#e0e0e0'; };
                
                optionsContainer.appendChild(div);
                div.querySelector('input').focus();
            }

            addOptionBtn.addEventListener('click', () => addOption());
            
            toggleOptions(); // Run on load
        });
    </script>
    @endpush
@endsection
