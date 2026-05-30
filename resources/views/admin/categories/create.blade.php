@extends('layouts.admin')

@section('title', 'Ajouter une catégorie')

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

        .icon-btn {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1px solid #eff3f6;
            border-radius: 4px;
            cursor: pointer;
            color: #64748b;
            transition: all 0.2s;
        }
        .icon-btn:hover {
            border-color: #ff9900;
            background: rgba(255,153,0,0.02);
        }
        .icon-btn.active {
            border-color: #ff9900;
            background: rgba(255, 153, 0, 0.08);
            color: #ff9900;
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
                    <span>Nouvelle catégorie</span>
                </div>
            </div>
            
            <a href="{{ route('admin.categories.l1') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                <i class="fas fa-list" style="color: #ff9900;"></i> Voir le catalogue
            </a>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">
                
                <!-- Left Column -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Identité Commerciale</h3>
                        <div style="margin-bottom: 15px;">
                            <label for="nom" class="field-label">Nom de la catégorie <small style="color: red;">*</small></label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required 
                                   placeholder="Ex: Électronique, Vêtements Homme..."
                                   oninput="if(this.value) this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">
                            @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                        <div style="margin-bottom: 0;">
                            <label for="description" class="field-label">Description (SEO & Info)</label>
                            <textarea name="description" id="description" rows="4" placeholder="Brève description pour le SEO et les clients..."
                                      oninput="if(this.value) this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1)">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="amazon-card" style="margin: 0; min-height: 260px;">
                        <h3 class="section-title">Architecture</h3>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                            <div>
                                <label for="parent_id" class="field-label">Catégorie Parente</label>
                                <select name="parent_id" id="parent_id">
                                    <option value="">-- Racine (Niveau 1) --</option>
                                    @foreach($categoriesTree as $treeItem)
                                        <option value="{{ $treeItem->id }}" {{ old('parent_id') == $treeItem->id ? 'selected' : '' }}>{{ $treeItem->nom }}</option>
                                        @foreach($treeItem->enfants as $child)
                                            <option value="{{ $child->id }}" {{ old('parent_id') == $child->id ? 'selected' : '' }}>
                                                &nbsp;&nbsp;↳ {{ $child->nom }} (L2)</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="ordre" class="field-label">Ordre d'affichage</label>
                                <input type="number" name="ordre" id="ordre" value="{{ old('ordre', $nextOrders['root'] ?? 1) }}" min="1">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div class="amazon-card" style="margin: 0; display: flex; flex-direction: column;">
                    
                    <!-- Visual Section -->
                    <h3 class="section-title" style="margin-bottom: 15px;">Visuel & État</h3>
                    
                    <div style="margin-bottom: 15px;">
                        <label class="field-label">Icône de catégorie</label>
                        <input type="hidden" name="icone" id="icone_input" value="{{ old('icone', '📦') }}">
                        <div id="icon-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 6px;">
                            <!-- Icons dynamic logic here -->
                        </div>
                    </div>
                    <div id="category-image-group" style="display: none; margin-bottom: 15px;">
                        <label class="field-label">Image de couverture</label>
                        <div style="border: 1px solid #dee2e6; border-radius: 4px; padding: 40px 20px; text-align: center; background: #fff; cursor: pointer; position: relative;" 
                             id="dropzone-container">
                            <div id="dropzone-content" onclick="document.getElementById('image-input').click()">
                                <i class="fas fa-camera" style="font-size: 2rem; color: #999; margin-bottom: 10px;"></i>
                                <p style="font-size: 0.8rem; color: #555; margin: 0; font-weight: 600;">CHANGER L'IMAGE DE COUVERTURE</p>
                            </div>
                            <div id="preview-container" style="display: none; position: relative;">
                                <img id="preview-img" style="max-width: 100%; max-height: 180px; object-fit: contain; margin-top: 5px;">
                                <button type="button" onclick="removeImage()" 
                                        style="position: absolute; top: -10px; right: -10px; background: #bf0000; color: #fff; border: none; width: 24px; height: 24px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 10;">
                                    <i class="fas fa-times" style="font-size: 0.8rem;"></i>
                                </button>
                            </div>
                        </div>
                        <input type="file" id="image-input" name="image" accept="image/*" style="display: none;" onchange="previewImage(this)">
                    </div>

                    <!-- Configuration Section (Conditional visibility via JS) -->
                    <div id="config-section" style="display: none; border-top: 1px solid #e7e7e7; padding-top: 15px; margin-top: 5px;">
                        <h3 class="section-title" style="margin-bottom: 15px;">Configuration</h3>
                        <div style="margin-bottom: 0;">
                            <label for="famille" class="field-label">Famille <small style="color: red;">*</small></label>
                            <select name="famille" id="famille">
                                <option value="">-- Sélectionner une famille --</option>
                                @foreach(\App\Models\Category::getFamilles() as $famille)
                                    <option value="{{ $famille }}" {{ old('famille') == $famille ? 'selected' : '' }}>
                                        {{ $famille }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Status & Actions -->
                    <div style="border-top: 1px solid #f1f5f9; padding-top: 24px; margin-top: auto;">
                        <div style="margin-bottom: 0;">
                            <label class="checkbox-container">
                                <input type="checkbox" name="actif" value="1" checked>
                                <span class="checkmark"></span>
                                <span style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Activer cette catégorie</span>
                            </label>
                            <p style="font-size: 0.75rem; color: #64748b; margin-left: 28px; margin-top: 6px;">
                                Si décoché, cette catégorie et ses sous-catégories ne seront plus visibles sur le site.
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Actions Row (Outside Card) -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <button type="submit" class="btn-amazon-primary">
                        ENREGISTRER
                    </button>
                    <a href="{{ route('admin.categories.l1') }}" class="btn-amazon-secondary">
                        ANNULER
                    </a>
                </div>

            </div>


        </form>
    </div>
</div>

@push('scripts')
<script>
    const icons = [
        '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.4 2.9A3.7 3.7 0 0 0 2 12v4c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>',
        '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>',
        '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
        '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
        '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>',
        '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
        '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12v10H4V12M2 7h20v5H2z"></path></svg>',
        '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83m13.79-4l-5.74 9.94"/></svg>',
        '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>',
        '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10a5 5 0 0 1 5 5v2a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5v-2a5 5 0 0 1 5-5z"></path></svg>',
        '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>',
        '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>'
    ];

    document.addEventListener('DOMContentLoaded', function () {
        const grid = document.getElementById('icon-grid');
        const iconeInput = document.getElementById('icone_input');

        icons.forEach(svg => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'icon-btn';
            btn.innerHTML = svg;
            if (iconeInput.value === svg) btn.classList.add('active');

            btn.onclick = function () {
                document.querySelectorAll('.icon-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                iconeInput.value = svg;
            };
            grid.appendChild(btn);
        });

        const parentSelect = document.getElementById('parent_id');
        const orderInput = document.getElementById('ordre');
        const configSection = document.getElementById('config-section');
        const imageGroup = document.getElementById('category-image-group');
        const familleSelect = document.getElementById('famille');

        // Prochains ordres par parent (injecté depuis PHP)
        const nextOrders = @json($nextOrders);

        function toggleFamille() {
            const val = parentSelect.value;
            const key = val === "" ? 'root' : val;
            
            // Mise à jour automatique de l'ordre
            if (nextOrders[key]) {
                orderInput.value = nextOrders[key];
            } else {
                orderInput.value = 1; // Par défaut si aucun enfant
            }

            if (val === "") {
                configSection.style.display = 'block';
                imageGroup.style.display = 'block';
                familleSelect.setAttribute('required', 'required');
            } else {
                configSection.style.display = 'none';
                imageGroup.style.display = 'none';
                familleSelect.removeAttribute('required');
                familleSelect.value = "";
            }
        }

        parentSelect.addEventListener('change', toggleFamille);
        toggleFamille();
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('preview-img');
                const previewContainer = document.getElementById('preview-container');
                const dropzone = document.getElementById('dropzone-content');
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
                if (dropzone) dropzone.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        const input = document.getElementById('image-input');
        const previewContainer = document.getElementById('preview-container');
        const dropzone = document.getElementById('dropzone-content');
        const previewImg = document.getElementById('preview-img');

        input.value = ""; // Clear file input
        previewImg.src = "";
        previewContainer.style.display = 'none';
        if (dropzone) dropzone.style.display = 'block';
    }
</script>
@endpush
@endsection