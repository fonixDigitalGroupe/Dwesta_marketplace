@extends('layouts.admin')

@section('title', 'Ajouter une catégorie')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <a href="{{ route('admin.categories.l1') }}">Catalogue</a>
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #bf0000; font-weight: 500;">Ajouter</span>
@endsection

@section('content')
    <div style="max-width: 1000px; margin: 0 auto;">

        <header style="margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">Ajouter une catégorie</h1>
            <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Configurez les paramètres d'un nouvel élément de
                votre catalogue.</p>
        </header>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">

                <!-- Left Colonne -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Section 1: Identité -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2
                            style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: #bf0000;">01.</span> Identité Commerciale
                        </h2>

                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label for="nom"
                                    style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Nom
                                    de la catégorie <span style="color: #bf0000;">*</span></label>
                                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;"
                                    onfocus="this.style.borderColor='#bf0000'" onblur="this.style.borderColor='#e0e0e0'">
                                @error('nom') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}
                                </p> @enderror
                            </div>

                            <div>
                                <label for="description"
                                    style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Description
                                    (SEO & Info)</label>
                                <textarea name="description" id="description" rows="4"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical;"
                                    onfocus="this.style.borderColor='#bf0000'"
                                    onblur="this.style.borderColor='#e0e0e0'">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Structure -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2
                            style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: #bf0000;">02.</span> Architecture
                        </h2>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                            <div>
                                <label for="parent_id"
                                    style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Catégorie
                                    Parente</label>
                                <select name="parent_id" id="parent_id"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff; cursor: pointer;">
                                    <option value="">-- Racine --</option>
                                    @foreach($categoriesTree as $treeItem)
                                        <option value="{{ $treeItem->id }}" {{ old('parent_id') == $treeItem->id ? 'selected' : '' }}>{{ $treeItem->nom }}</option>
                                        @foreach($treeItem->enfants as $child)
                                            <option value="{{ $child->id }}" {{ old('parent_id') == $child->id ? 'selected' : '' }}>
                                                &nbsp;&nbsp;↳ {{ $child->nom }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="ordre"
                                    style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Ordre
                                    d'affichage</label>
                                <input type="number" name="ordre" id="ordre" value="{{ old('ordre', 0) }}"
                                    style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Colonne -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1.25rem;">Configuration
                        </h3>

                        <!-- Famille Selection (Only for Root) -->
                        <div id="famille-group" style="margin-bottom: 1.25rem;">
                            <label for="famille"
                                style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Famille
                                (Catégorie Principale) <span style="color: #bf0000;">*</span></label>
                            <select name="famille" id="famille"
                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; background: #fff; cursor: pointer;">
                                <option value="">-- Sélectionner une famille --</option>
                                @foreach(\App\Models\Category::getFamilles() as $famille)
                                    <option value="{{ $famille }}" {{ old('famille') == $famille ? 'selected' : '' }}>
                                        {{ $famille }}
                                    </option>
                                @endforeach
                            </select>
                            <p style="font-size: 0.75rem; color: #999; margin-top: 4px;">Requis uniquement pour les
                                catégories de premier niveau.</p>
                        </div>
                    </div>

                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h3 style="font-size: 1rem; color: #333; font-weight: 500; margin-bottom: 1.25rem;">Visuel & État
                        </h3>

                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label
                                    style="display: block; font-size: 0.75rem; font-weight: 500; color: #999; text-transform: uppercase; margin-bottom: 12px; letter-spacing: 0.05em;">Icône
                                    de catégorie</label>

                                <input type="hidden" name="icone" id="icone_input" value="{{ old('icone', '📦') }}">

                                <div id="icon-grid"
                                    style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; margin-bottom: 8px;">
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

                                        const grid = document.getElementById('icon-grid');
                                        icons.forEach(svg => {
                                            const btn = document.createElement('button');
                                            btn.type = 'button';
                                            btn.className = 'icon-option';
                                            btn.innerHTML = svg;
                                            btn.style.cssText = 'padding: 8px; border: 1px solid #e0e0e0; border-radius: 6px; background: #fff; cursor: pointer; color: #999; transition: all 0.2s; display: flex; align-items: center; justify-content: center;';

                                            btn.onclick = function () {
                                                document.querySelectorAll('.icon-option').forEach(b => {
                                                    b.style.borderColor = '#e0e0e0';
                                                    b.style.color = '#999';
                                                    b.style.background = '#fff';
                                                });
                                                this.style.borderColor = '#bf0000';
                                                this.style.color = '#bf0000';
                                                this.style.background = '#fdf2f2';
                                                document.getElementById('icone_input').value = svg;
                                            };
                                            grid.appendChild(btn);
                                        });
                                    </script>
                                </div>

                                <div style="padding-top: 1rem; border-top: 1px solid #f0f0f0; margin-top: 1rem;">
                                    <label for="actif"
                                        style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                                        <input type="checkbox" name="actif" id="actif" value="1" {{ (old('_token') ? old('actif') : true) ? 'checked' : '' }}
                                            style="width: 16px; height: 16px; accent-color: #bf0000; cursor: pointer;">
                                        <span style="font-size: 0.9rem; font-weight: 500; color: #333;">Catégorie
                                            Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit"
                            style="background-color: #000; color: #fff; border: none; padding: 0.75rem; border-radius: 4px; font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-size: 0.95rem;">
                            Créer
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                        <a href="{{ route('admin.categories.l1') }}"
                            style="display: flex; justify-content: center; padding: 0.75rem; background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; color: #666; text-decoration: none; font-weight: 500; font-size: 0.9rem; transition: all 0.2s;"
                            onmouseover="this.style.background='#f9f9f9'; this.style.color='#333'"
                            onmouseout="this.style.background='#fff'; this.style.color='#666'">
                            Annuler
                        </a>
                    </div>

                </div>

            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const parentSelect = document.getElementById('parent_id');
            const familleGroup = document.getElementById('famille-group');
            const familleSelect = document.getElementById('famille');

            function toggleFamille() {
                if (parentSelect.value === "") {
                    // C'est une racine
                    familleGroup.style.display = 'block';
                    familleSelect.setAttribute('required', 'required');
                } else {
                    // C'est une sous-catégorie
                    familleGroup.style.display = 'none';
                    familleSelect.removeAttribute('required');
                    familleSelect.value = ""; // Reset value
                }
            }

            parentSelect.addEventListener('change', toggleFamille);
            toggleFamille(); // Run on load
        });
    </script>
@endsection