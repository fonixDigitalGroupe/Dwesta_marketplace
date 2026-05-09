@extends('layouts.admin')

@section('title', 'Configuration Générale')

@push('styles')
<style>
    .main-content { background-color: #f8f9fa !important; }
    
    /* Input Amazon Style */
    input[type="text"]:focus, 
    input[type="email"]:focus, 
    input[type="tel"]:focus, 
    input[type="url"]:focus, 
    textarea:focus {
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
        gap: 8px;
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
        gap: 8px;
    }
    .btn-amazon-secondary:hover {
        background: linear-gradient(to bottom, #e7eaf0, #d8dade);
        border-color: #a2a6ac;
    }

    /* intl-tel-input integration */
    .iti { width: 100% !important; }
    .iti__flag-container { z-index: 1000 !important; }
    .iti--separate-dial-code .iti__selected-flag {
        border-right: 1px solid #adb1b8 !important;
        padding-right: 10px !important;
        margin-right: 5px !important;
        background: #fcfcfc !important;
        border-radius: 0 !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/css/intlTelInput.css">
@endpush

@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/js/intlTelInput.min.js"></script>
    <script>
        window.initPhoneField = function(el) {
            if (!el || el.dataset.itiInit) return;
            const tryInit = () => {
                if (window.intlTelInput) {
                    window.intlTelInput(el, {
                        initialCountry: 'sn',
                        separateDialCode: true,
                        dropdownContainer: document.body,
                        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/js/utils.js"
                    });
                    el.dataset.itiInit = 'true';
                } else {
                    setTimeout(tryInit, 100);
                }
            };
            tryInit();
        }
    </script>

    <div x-data="{ 
        emails: {{ isset($settings['contact_emails']) ? json_encode($settings['contact_emails']) : json_encode(['']) }},
        phones: {{ isset($settings['contact_phones']) ? json_encode($settings['contact_phones']) : json_encode(['']) }},
        logoPreview: '{{ isset($settings['logo']) ? asset('storage/' . $settings['logo']) : '' }}',
        defaultLogo: '{{ asset('images/logo.png') }}',
        isCustomLogo: {{ (isset($settings['logo']) && !empty($settings['logo'])) ? 'true' : 'false' }},
        removeLogoFlag: false,
        addEmail() { this.emails.push('') },
        removeEmail(index) { this.emails.splice(index, 1) },
        addPhone() { this.phones.push('') },
        removePhone(index) { this.phones.splice(index, 1) },
        handleLogoChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.logoPreview = URL.createObjectURL(file);
                this.removeLogoFlag = false;
                this.isCustomLogo = true;
            }
        },
        clearLogo() {
            this.logoPreview = '';
            this.removeLogoFlag = true;
            this.isCustomLogo = false;
            this.$refs.logoInput.value = '';
    }" style="max-width: 1200px; margin: 0 auto;">

    @include('admin.partials.settings-tabs')

    <div style="background: #fff; border: 1px solid #e7e7e7; border-top: none; padding: 25px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="font-size: 1.25rem; font-weight: 500; color: #111; margin: 0;">Configuration Générale</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn-amazon-secondary">
            <i class="fas fa-reply" style="font-size: 0.8rem; opacity: 0.7;"></i> Retour au tableau de bord
        </a>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settings-form">
        @csrf
        <input type="hidden" name="remove_logo" :value="removeLogoFlag ? '1' : '0'">

        <div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">
            
            <!-- Left Column -->
            <div style="display: flex; flex-direction: column;">
                
                <!-- Logo Card -->
                <div class="amazon-card">
                    <h3 class="section-title">Visuel du Projet</h3>
                    <p style="font-size: 0.85rem; color: #555; margin-bottom: 20px;">Personnalisez l'apparence de votre plateforme en ajoutant le logo officiel.</p>
                    
                    <div style="background: #fcfcfc; border: 1px solid #e7e7e7; padding: 20px; display: flex; align-items: flex-start; gap: 25px;">
                        <!-- Preview Box -->
                        <div style="flex-shrink: 0; width: 140px; height: 140px; background: #fff; border: 1px solid #adb1b8; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                            <template x-if="logoPreview">
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                    <img :src="logoPreview" alt="Logo" style="max-width: 90%; max-height: 90%; object-fit: contain;">
                                    <button type="button" @click="clearLogo" x-show="logoPreview && !removeLogoFlag" 
                                        style="position: absolute; top: 5px; right: 5px; width: 24px; height: 24px; background: #fff; border: 1px solid #adb1b8; color: #c40000; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                        title="Supprimer">
                                        <i class="fas fa-times" style="font-size: 0.75rem;"></i>
                                    </button>
                                </div>
                            </template>
                            <template x-if="!logoPreview">
                                <div style="text-align: center; color: #999;">
                                    <i class="far fa-image" style="font-size: 2rem; margin-bottom: 5px; display: block;"></i>
                                    <span style="font-size: 0.7rem;">AUCUN VISUEL</span>
                                </div>
                            </template>
                        </div>

                        <!-- Actions -->
                        <div style="flex-grow: 1;">
                            <h4 style="font-size: 0.9rem; font-weight: 700; color: #111; margin: 0 0 5px 0;">Logo de marque</h4>
                            <p style="font-size: 0.8rem; color: #555; margin-bottom: 15px;">Format PNG ou SVG recommandé pour une meilleure transparence.</p>
                            
                            <button type="button" @click="$refs.logoInput.click()" class="btn-amazon-primary" style="width: auto; padding: 6px 15px;">
                                <i class="fas fa-upload" style="font-size: 0.8rem;"></i> Choisir un fichier
                            </button>
                            <input type="file" x-ref="logoInput" name="logo" accept="image/*" style="display: none;" @change="handleLogoChange">
                        </div>
                    </div>
                </div>

                <!-- Identity Card -->
                <div class="amazon-card">
                    <h3 class="section-title">Identité du Projet</h3>
                    <div style="display: grid; gap: 20px;">
                        <div>
                            <label for="site_name" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Nom du Site</label>
                            <input type="text" name="site_name" id="site_name" value="{{ $settings['site_name'] ?? 'Dwesta' }}" 
                                style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                        </div>
                        <div>
                            <label for="site_description" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Description (Meta-data)</label>
                            <textarea name="site_description" id="site_description" rows="4" 
                                style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc; resize: vertical; font-family: inherit;">{{ $settings['site_description'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Legal Card -->
                <div class="amazon-card">
                    <h3 class="section-title">Informations Légales</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label for="legal_rc" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Registre de Commerce (RC)</label>
                            <input type="text" name="legal_rc" id="legal_rc" value="{{ $settings['legal_rc'] ?? '' }}" 
                                style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                        </div>
                        <div>
                            <label for="legal_ninea" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">NINEA</label>
                            <input type="text" name="legal_ninea" id="legal_ninea" value="{{ $settings['legal_ninea'] ?? '' }}" 
                                style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div style="display: flex; flex-direction: column;">
                
                <!-- Contact Card -->
                <div class="amazon-card">
                    <h3 class="section-title">Contact & Coordonnées</h3>
                    <div style="display: grid; gap: 20px;">
                        <div>
                            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Emails de contact</label>
                            <template x-for="(email, index) in emails" :key="index">
                                <div style="display: flex; gap: 5px; margin-bottom: 8px; align-items: center;">
                                    <input type="email" name="contact_emails[]" x-model="emails[index]" 
                                        style="flex: 1; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                                    
                                    <button type="button" @click="removeEmail(index)" x-show="emails.length > 1" 
                                        style="width: 32px; height: 32px; background: #fff; border: 1px solid #adb1b8; color: #c40000; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-trash-alt" style="font-size: 0.8rem;"></i>
                                    </button>
                                    
                                    <button type="button" @click="addEmail" x-show="index === emails.length - 1" 
                                        style="width: 32px; height: 32px; background: #f0f2f2; border: 1px solid #adb1b8; color: #111; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-plus" style="font-size: 0.8rem;"></i>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div>
                            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Téléphones</label>
                            <template x-for="(phone, index) in phones" :key="index">
                                <div style="display: flex; gap: 5px; margin-bottom: 8px; align-items: center;">
                                    <div style="flex: 1;">
                                        <input type="tel" name="contact_phones[]" x-model="phones[index]" 
                                            x-init="window.initPhoneField($el)"
                                            style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc;">
                                    </div>
                                    <button type="button" @click="removePhone(index)" x-show="phones.length > 1" 
                                        style="width: 32px; height: 32px; background: #fff; border: 1px solid #adb1b8; color: #c40000; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-trash-alt" style="font-size: 0.8rem;"></i>
                                    </button>
                                    <button type="button" @click="addPhone" x-show="index === phones.length - 1" 
                                        style="width: 32px; height: 32px; background: #f0f2f2; border: 1px solid #adb1b8; color: #111; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-plus" style="font-size: 0.8rem;"></i>
                                    </button>
                                </div>
                            </template>
                        </div>

                        <div>
                            <label for="contact_address" style="display: block; font-size: 0.85rem; font-weight: 700; color: #111; margin-bottom: 8px;">Adresse Physique</label>
                            <textarea name="contact_address" id="contact_address" rows="2" 
                                style="width: 100%; padding: 8px 12px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.85rem; outline: none; background: #fcfcfc; font-family: inherit;">{{ $settings['contact_address'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Social Card -->
                <div class="amazon-card">
                    <h3 class="section-title">Réseaux Sociaux</h3>
                    <div style="display: grid; gap: 12px;">
                        <div>
                            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #555; margin-bottom: 4px;">Facebook</label>
                            <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" 
                                style="width: 100%; padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.8rem; outline: none; background: #fcfcfc;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #555; margin-bottom: 4px;">Instagram</label>
                            <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" 
                                style="width: 100%; padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.8rem; outline: none; background: #fcfcfc;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #555; margin-bottom: 4px;">Twitter / X</label>
                            <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" 
                                style="width: 100%; padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.8rem; outline: none; background: #fcfcfc;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.8rem; font-weight: 500; color: #555; margin-bottom: 4px;">LinkedIn</label>
                            <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}" 
                                style="width: 100%; padding: 6px 10px; border: 1px solid #adb1b8; border-radius: 0; font-size: 0.8rem; outline: none; background: #fcfcfc;">
                        </div>
                    </div>
                </div>

                <!-- Footer Actions sticky or at bottom -->
                <div style="display: flex; gap: 10px; padding-top: 10px;">
                    <button type="submit" class="btn-amazon-primary" style="flex: 1; padding: 12px;">
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn-amazon-secondary" style="flex: 1; padding: 12px;">
                        Annuler
                    </a>
                </div>
            </div>

        </div>
    </form>
    </div>
</div>
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/js/intlTelInput.min.js" defer></script>
<script>
    window.initPhoneField = function(el) {
        if (!el || el.dataset.itiInit) return;
        
        const doInit = () => {
            if (window.intlTelInput) {
                window.intlTelInput(el, {
                    initialCountry: 'sn',
                    separateDialCode: true,
                    dropdownContainer: document.body,
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/js/utils.js"
                });
                el.dataset.itiInit = 'true';
            }
        };

        if (window.intlTelInput) {
            doInit();
        } else {
            document.addEventListener('DOMContentLoaded', doInit);
        }
    };
</script>
@endpush
@endsection
