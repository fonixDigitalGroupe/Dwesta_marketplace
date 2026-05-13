@extends('layouts.admin')

@section('title', 'Modifier le critère : ' . $filter->nom)

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        /* Input Amazon Style */
        input[type="text"]:focus,
        select:focus {
            border-color: #e77600 !important;

            outline: none;
        }

        .amazon-card {
            background: #fff;
            border: 1px solid #e7e7e7;
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
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
            background: linear-gradient(180deg, #007bff 0%, #0056b3 100%);
            border: 1px solid #004aad;
            color: #fff;
            padding: 8px 24px;
            border-radius: 0;
            font-size: 0.85rem;
            font-weight: 400;
            text-decoration: none;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .4) inset;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-amazon-primary:hover {
            background: linear-gradient(180deg, #0069d9 0%, #004494 100%);
            border-color: #003d82;
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
            box-shadow: 0 1px 0 rgba(255, 255, 255, .6) inset;
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
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) inset;
        }

        .checkbox-container:hover input~.checkmark {
            border-color: #e77600;

        }

        .checkbox-container input:checked~.checkmark {
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

        .checkbox-container input:checked~.checkmark:after {
            display: block;
        }
    </style>
@endpush

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
    <div style="max-width: 100%;">

        <div style="background: #fff; border: 1px solid #e7e7e7; border-top: none; padding: 25px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">Modifier le critère :
                    {{ $filter->nom }}
                </h1>
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
                                <label for="l1_category_id"
                                    style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Niveau
                                    1 <small style="color: red;">*</small></label>
                                <select id="l1_category_id"
                                    style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc; cursor: pointer;">
                                    <option value="">-- Choisir --</option>
                                    @foreach($parents as $parent)
                                        <option value="{{ $parent->id }}" {{ $l1Id == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="l2_category_id"
                                    style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Niveau
                                    2 <small style="color: red;">*</small></label>
                                <select id="l2_category_id" {{ $l2Id ? '' : 'disabled' }}
                                    style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: {{ $l2Id ? '#fcfcfc' : '#f7f8fa' }}; cursor: {{ $l2Id ? 'pointer' : 'not-allowed' }};">
                                    <option value="">-- Choisir --</option>
                                </select>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                            <div>
                                <label for="category_id"
                                    style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Niveau
                                    3 <small style="color: red;">*</small></label>
                                <select name="category_id" id="category_id" required {{ $l3Id ? '' : 'disabled' }}
                                    style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: {{ $l3Id ? '#fcfcfc' : '#f7f8fa' }}; cursor: {{ $l3Id ? 'pointer' : 'not-allowed' }};">
                                    <option value="">-- Choisir --</option>
                                </select>
                                <div id="loader"
                                    style="display: none; font-size: 0.75rem; color: #0066c0; margin-top: 6px; align-items: center; gap: 5px;">
                                    <i class="fas fa-spinner fa-spin"></i> Chargement des catégories...
                                </div>
                            </div>

                            <div>
                                <label for="nom"
                                    style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Nom
                                    du Critère <small style="color: red;">*</small></label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom', $filter->nom) }}" required
                                    placeholder="Couleur"
                                    style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc; text-transform: capitalize;">
                                @error('nom')
                                    <p style="color: #c40000; font-size: 0.75rem; margin-top: 5px;">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" name="type" value="select">
                    </div>

                    <!-- Right Column: Options -->
                    <div class="amazon-card" style="display: flex; flex-direction: column;">
                        <h3 class="section-title">Options de filtrage</h3>

                        <div style="flex: 1;">

                            <div id="options-container"
                                style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
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
                                    oninput="this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)"
                                    style="flex: 1; padding: 8px 12px; border: 1px solid #adb1b8; border-right: none; border-radius: 0; font-size: 0.85rem; outline: none; background: #fff;">
                                <button type="button" id="add-option-btn-v2" class="btn-amazon-secondary"
                                    style="padding: 0 15px; border-left: none;">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div
                            style="display: flex; flex-direction: column; gap: 10px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                            <!-- Status Section -->
                            <div style="margin-bottom: 20px;">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="is_filterable" value="1" {{ $filter->is_filterable ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    <span style="font-weight: 700;">Activer ce critère</span>
                                </label>
                                <p style="font-size: 0.75rem; color: #555; margin-left: 24px; margin-top: 4px;">
                                    Si décoché, ce critère ne sera pas visible comme option de filtrage sur le site.
                                </p>
                            </div>

                            <button type="submit" class="btn-amazon-primary" style="padding: 12px; font-weight: 700;">
                                ENREGISTRER
                            </button>
                            <a href="{{ route('admin.filters.index') }}" class="btn-amazon-secondary"
                                style="padding: 12px;">
                                ANNULER
                            </a>
                        </div>
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

            const initialL1Id = "{{ $l1Id }}";
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

            async function loadCategories(parentId, targetSelect, selectedId = null) {
                if (!parentId) return;
                loader.style.display = 'flex';
                try {
                    const response = await fetch(`/admin/filters/categories/${parentId}/children`);
                    const data = await response.json();
                    targetSelect.innerHTML = '<option value="">-- Choisir --</option>';
                    data.forEach(child => {
                        const option = document.createElement('option');
                        option.value = child.id;
                        option.textContent = child.nom;
                        if (selectedId && child.id == selectedId) option.selected = true;
                        targetSelect.appendChild(option);
                    });
                    enableSelect(targetSelect);
                } catch (error) {
                    console.error("Erreur chargement catégories:", error);
                } finally {
                    loader.style.display = 'none';
                }
            }

            // Initialization
            if (initialL1Id) {
                loadCategories(initialL1Id, l2Select, initialL2Id).then(() => {
                    if (initialL2Id) {
                        loadCategories(initialL2Id, l3Select, initialL3Id);
                    }
                });
            }

            l1Select.addEventListener('change', function () {
                const parentId = this.value;
                resetSelect(l2Select);
                resetSelect(l3Select);
                if (parentId) loadCategories(parentId, l2Select);
            });

            l2Select.addEventListener('change', function () {
                const parentId = this.value;
                resetSelect(l3Select);
                if (parentId) loadCategories(parentId, l3Select);
            });

            const container = document.getElementById('options-container');
            const input = document.getElementById('new-option-input');
            const btn = document.getElementById('add-option-btn-v2');

            // Initial setup for existing remove buttons
            document.querySelectorAll('.remove-option-btn').forEach(b => {
                b.onclick = () => b.parentElement.remove();
            });

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
                div.querySelector('.remove-option-btn').onclick = () => div.remove();
                div.querySelector('input').onfocus = function () {
                    this.style.borderColor = '#e77600';
                };
                div.querySelector('input').onblur = function () {
                    this.style.borderColor = '#adb1b8';
                };
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