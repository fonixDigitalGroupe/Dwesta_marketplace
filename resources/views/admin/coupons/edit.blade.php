@extends('layouts.admin')

@section('title', 'Modifier le Code Promo : ' . $coupon->code)

@push('styles')
    <style>
        input[type="text"],
        input[type="number"],
        input[type="date"],
        input[type="datetime-local"],
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

        .dropzone-amazon {
            border: 1px dashed #dee2e6;
            border-radius: 6px;
            padding: 30px 20px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropzone-amazon:hover {
            border-color: #ff9900;
            background: #fff;
        }

        .dropzone-amazon img {
            max-width: 100%;
            max-height: 120px;
            object-fit: contain;
            border-radius: 4px;
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
            flex-shrink: 0;
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

@section('content')
<div style="max-width: 1200px; margin: -30px auto 0;">
    <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">

        {{-- Card Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                <i class="fas fa-edit" style="font-size: 0.8rem;"></i>
                <span>Modifier le Code : <span style="color: #ff9900;">{{ $coupon->code }}</span></span>
            </div>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.promotions.index') }}" class="btn-amazon-secondary" style="width: auto !important; height: 32px !important; padding: 0 16px !important; font-size: 0.8rem;">
                    <i class="fas fa-list" style="color: #ff9900;"></i> Promotions
                </a>
            </div>
        </div>

        <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">

                {{-- Left Column --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">

                    {{-- Informations générales --}}
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Général</h3>

                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <div>
                                <label for="code" class="field-label">Code promotionnel <span style="color: red;">*</span></label>
                                <input type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}" style="text-transform: uppercase;" required>
                                @error('code') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                                <div>
                                    <label for="category_id_n1" class="field-label">Niveau 1</label>
                                    <select name="category_id_n1" id="category_id_n1" onchange="filterN2Categories()">
                                        <option value="">-- Choisir N1 --</option>
                                        @foreach($n1Categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('category_id_n1', $coupon->category_id_n1) == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="category_id_n2" class="field-label">Niveau 2</label>
                                    <select name="category_id_n2" id="category_id_n2" onchange="filterN3Categories()">
                                        <option value="">-- Choisir N2 --</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="category_id" class="field-label">Cible (N3)</label>
                                    <select name="category_id" id="category_id">
                                        <option value="">-- Choisir N3 --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>



                    {{-- Visuels --}}
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="amazon-card" style="margin: 0;">
                            <h3 class="section-title">Image Bannière (Home)</h3>
                            <div class="dropzone-amazon" onclick="document.getElementById('banner-image-input').click()">
                                <div id="dropzone-banner-content" style="{{ $coupon->banner_image ? 'display: none;' : '' }}">
                                    <i class="fas fa-image" style="font-size: 24px; color: #cbd5e1; margin-bottom: 10px;"></i>
                                    <p style="font-size: 0.75rem; color: #64748b; font-weight: 600;">Slider Principal</p>
                                </div>
                                @if($coupon->banner_image)
                                    <img id="preview-banner-img" src="{{ Storage::url($coupon->banner_image) }}">
                                @else
                                    <img id="preview-banner-img" style="display: none;">
                                @endif
                            </div>
                            <input type="file" id="banner-image-input" name="banner_image" accept="image/*" style="display: none;" onchange="previewImage(this, 'preview-banner-img', 'dropzone-banner-content')">
                            @error('banner_image') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>

                        <div class="amazon-card" style="margin: 0;">
                            <h3 class="section-title">Image Page</h3>
                            <div class="dropzone-amazon" onclick="document.getElementById('landing-image-input').click()">
                                <div id="dropzone-landing-content" style="{{ $coupon->landing_page_image ? 'display: none;' : '' }}">
                                    <i class="fas fa-desktop" style="font-size: 24px; color: #cbd5e1; margin-bottom: 10px;"></i>
                                    <p style="font-size: 0.75rem; color: #64748b; font-weight: 600;">En-tête de page</p>
                                </div>
                                @if($coupon->landing_page_image)
                                    <img id="preview-landing-img" src="{{ Storage::url($coupon->landing_page_image) }}">
                                @else
                                    <img id="preview-landing-img" style="display: none;">
                                @endif
                            </div>
                            <input type="file" id="landing-image-input" name="landing_page_image" accept="image/*" style="display: none;" onchange="previewImage(this, 'preview-landing-img', 'dropzone-landing-content')">
                            @error('landing_page_image') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                        </div>
                    </div>

                </div>

                {{-- Right Column --}}
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    {{-- Règles de réduction --}}
                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Règles de Réduction</h3>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div>
                                <label for="type" class="field-label">Type <span style="color: red;">*</span></label>
                                <select name="type" id="type" required>
                                    <option value="percent" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>Pourcentage (%)</option>
                                    <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Montant Fixe (FCFA)</option>
                                </select>
                            </div>
                            <div>
                                <label for="value" class="field-label">Valeur <span style="color: red;">*</span></label>
                                <input type="number" step="0.01" min="0" name="value" id="value" value="{{ old('value', $coupon->value) }}" placeholder="Ex: 10 ou 5000" required>
                                @error('value') <p style="color: #bf0000; font-size: 0.75rem; margin-top: 6px;">{{ $message }}</p> @enderror
                            </div>
                        </div>


                    </div>

                    <div class="amazon-card" style="margin: 0;">
                        <h3 class="section-title">Utilisation</h3>

                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <div style="border-top: 1px solid #f1f5f9; padding-top: 0;">
                                <label class="checkbox-container">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                                    <span class="checkmark"></span>
                                    <span style="font-size: 0.75rem; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.05em;">Code actif</span>
                                </label>
                            </div>
                        </div>

                        <div style="margin-top: 25px; display: grid; grid-template-columns: 1fr; gap: 10px;">
                            <button type="submit" class="btn-amazon-primary">
                                METTRE À JOUR
                            </button>
                            <a href="{{ route('admin.promotions.index') }}" class="btn-amazon-secondary">
                                ANNULER
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
function previewImage(input, previewId, dropzoneId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            const dropzone = document.getElementById(dropzoneId);
            preview.src = e.target.result;
            preview.style.display = 'inline-block';
            if (dropzone) dropzone.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

const allCategories = @json($allCategories);

function filterN2Categories(selectedN2 = null) {
    const n1Id = document.getElementById('category_id_n1').value;
    const n2Select = document.getElementById('category_id_n2');
    const n3Select = document.getElementById('category_id');
    
    n2Select.innerHTML = '<option value="">-- Choisir N2 --</option>';
    n3Select.innerHTML = '<option value="">-- Choisir N3 --</option>';
    
    if (n1Id) {
        const filtered = allCategories.filter(c => c.parent_id == n1Id);
        filtered.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.nom;
            if (selectedN2 && c.id == selectedN2) opt.selected = true;
            n2Select.appendChild(opt);
        });
    }
}

function filterN3Categories(selectedN3 = null) {
    const n2Id = document.getElementById('category_id_n2').value;
    const n3Select = document.getElementById('category_id');
    
    n3Select.innerHTML = '<option value="">-- Choisir N3 --</option>';
    
    if (n2Id) {
        const filtered = allCategories.filter(c => c.parent_id == n2Id);
        filtered.forEach(c => {
            const opt = document.createElement('option');
            opt.value = c.id;
            opt.textContent = c.nom;
            if (selectedN3 && c.id == selectedN3) opt.selected = true;
            n3Select.appendChild(opt);
        });
    }
}

// Initial state for Edit
document.addEventListener('DOMContentLoaded', function() {
    const initialN2 = @json(old('category_id_n2', $coupon->category_id_n2));
    const initialN3 = @json(old('category_id', $coupon->category_id));
    
    if (document.getElementById('category_id_n1').value) {
        filterN2Categories(initialN2);
        if (initialN2) {
            filterN3Categories(initialN3);
        }
    }
});
</script>
@endsection
