@extends('layouts.admin')

@section('title', 'Configuration Générale')


@section('content')
    <!-- intl-tel-input -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/css/intlTelInput.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/js/intlTelInput.min.js"></script>
    <style>
        .iti { width: 100% !important; }
        .iti__flag-container { z-index: 1000 !important; }
        .iti--separate-dial-code .iti__selected-flag {
            border-right: 1px solid #e0e0e0 !important;
            padding-right: 10px !important;
            margin-right: 5px !important;
            background: transparent !important;
        }
    </style>
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
        }
    }" style="max-width: 1000px; margin: 0 auto;">

        <!-- Titre en majuscules -->
        <h2 style="font-size: 0.85rem; color: #555; font-weight: 700; text-transform: uppercase; margin-bottom: 1.5rem; letter-spacing: 0.05em;">
            Configuration Générale
        </h2>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settings-form">
            @csrf
            
            <input type="hidden" name="remove_logo" :value="removeLogoFlag ? '1' : '0'">

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">

                <!-- Main Column (Left) -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- Section 1: Identité du Projet -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Identité du Projet
                        </h2>
                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Nom du Site</label>
                                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Dwesta' }}" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Description</label>
                                <textarea name="site_description" rows="4" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical; font-family: inherit;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">{{ $settings['site_description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Informations Légales -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Informations Légales
                        </h2>
                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Registre de Commerce (RC)</label>
                                <input type="text" name="legal_rc" value="{{ $settings['legal_rc'] ?? '' }}" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">NINEA</label>
                                <input type="text" name="legal_ninea" value="{{ $settings['legal_ninea'] ?? '' }}" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                        </div>
                    </div>

                    <!-- Visuel du Projet -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h3 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 0.5rem;">Visuel du Projet</h3>
                        <p style="font-size: 0.9rem; color: #666; margin-bottom: 1.5rem;">Personnalisez l'apparence de votre plateforme en ajoutant le logo officiel de votre structure.</p>
                        
                        <div style="background: #fcfcfc; border: 1px solid #f0f0f0; border-radius: 12px; padding: 1.5rem;">
                            <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #888; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em;">Logo de la structure</label>
                            
                            <div style="display: flex; align-items: center; gap: 2rem;">
                                <!-- Preview Area -->
                                <div style="flex-shrink: 0; width: 140px; height: 140px; background: #fff; border: 1px solid #e8e8e8; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                                    <template x-if="logoPreview">
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; position: relative;">
                                            <img :src="logoPreview" alt="Logo" style="max-width: 90%; max-height: 90%; object-fit: contain; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                            
                                            <!-- Bouton Supprimer flottant -->
                                            <button type="button" @click="clearLogo" x-show="logoPreview && !removeLogoFlag" 
                                                style="position: absolute; top: 8px; right: 8px; width: 28px; height: 28px; background: rgba(255, 255, 255, 0.9); border: 1px solid #fee2e2; border-radius: 50%; color: #ef4444; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.1); z-index: 10;"
                                                onmouseover="this.style.background='#ef4444'; this.style.color='#fff'; this.style.borderColor='#ef4444'" 
                                                onmouseout="this.style.background='rgba(255, 255, 255, 0.9)'; this.style.color='#ef4444'; this.style.borderColor='#fee2e2'"
                                                title="Supprimer le logo">
                                                <i class="fas fa-times" style="font-size: 0.85rem;"></i>
                                            </button>
                                        </div>
                                    </template>
                                    <template x-if="!logoPreview">
                                        <div style="text-align: center; color: #ccc;">
                                            <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-bottom: 8px; opacity: 0.5;">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p style="font-size: 0.7rem; font-weight: 500;">Aucun visuel</p>
                                        </div>
                                    </template>
                                </div>
                                
                                <!-- Info & Actions -->
                                <div style="flex-grow: 1;">
                                    <h4 style="font-size: 0.95rem; color: #333; font-weight: 600; margin-bottom: 0.5rem;">Image de marque</h4>
                                    <p style="font-size: 0.85rem; color: #777; margin-bottom: 1.25rem; line-height: 1.5;">Format recommandé (PNG, SVG, JPG).</p>
                                    
                                    <div style="display: flex; gap: 0.75rem;">
                                        <button type="button" @click="$refs.logoInput.click()" style="padding: 10px 18px; background: #2563eb; color: #fff; border: none; border-radius: 6px; font-size: 0.85rem; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.background='#1e40af'" onmouseout="this.style.background='#2563eb'">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            Choisir un fichier
                                        </button>
                                    </div>
                                    <input type="file" x-ref="logoInput" name="logo" accept="image/*" style="display: none;" @change="handleLogoChange">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (Sidebar) -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">

                    <!-- Section 2: Contact & Coordonnées -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Contact & Coordonnées
                        </h2>
                        <div style="display: grid; gap: 1.5rem;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Emails de contact</label>
                                <template x-for="(email, index) in emails" :key="index">
                                    <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem; align-items: center;">
                                        <input type="email" name="contact_emails[]" x-model="emails[index]" style="flex: 1; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                        <button type="button" @click="removeEmail(index)" x-show="emails.length > 1" style="background: #fff; color: #ef4444; border: 1px solid #fee2e2; padding: 0.5rem; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#fff'">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        <!-- Bouton Ajouter à droite (uniquement sur le dernier) -->
                                        <button type="button" @click="addEmail" x-show="index === emails.length - 1" style="width: 28px; height: 28px; background: #2563eb; color: #fff; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0;" onmouseover="this.style.background='#1e40af'" onmouseout="this.style.background='#2563eb'" title="Ajouter un email">
                                            <i class="fas fa-plus" style="font-size: 0.8rem;"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <div id="phone-inputs-container">
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Numéros de téléphone</label>
                                <template x-for="(phone, index) in phones" :key="index">
                                    <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem; align-items: center;">
                                        <div style="flex: 1;">
                                            <input type="tel" :id="'phone-' + index" name="contact_phones[]" x-model="phones[index]" class="phone-input" 
                                                x-init="window.initPhoneField($el)"
                                                style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;" 
                                                onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                                        </div>
                                        <button type="button" @click="removePhone(index)" x-show="phones.length > 1" style="background: #fff; color: #ef4444; border: 1px solid #fee2e2; padding: 0.5rem; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#fff'">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        <!-- Bouton Ajouter à droite (uniquement sur le dernier) -->
                                        <button type="button" @click="addPhone" x-show="index === phones.length - 1" style="width: 28px; height: 28px; background: #2563eb; color: #fff; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s; flex-shrink: 0;" onmouseover="this.style.background='#1e40af'" onmouseout="this.style.background='#2563eb'" title="Ajouter un téléphone">
                                            <i class="fas fa-plus" style="font-size: 0.8rem;"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Adresse Physique</label>
                                <textarea name="contact_address" rows="2" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; font-family: inherit;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">{{ $settings['contact_address'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Réseaux Sociaux -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Réseaux Sociaux
                        </h2>
                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 6px;">Facebook</label>
                                <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="URL" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 6px;">Instagram</label>
                                <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="URL" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 6px;">Twitter / X</label>
                                <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" placeholder="URL" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 6px;">LinkedIn</label>
                                <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}" placeholder="URL" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;" onfocus="this.style.borderColor='#e67e00'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                        </div>
                    </div>


                    <!-- Actions -->
                    <div style="display: flex; gap: 10px; margin-top: 0.5rem;">
                        <a href="{{ route('admin.dashboard') }}" style="flex: 1; display: flex; justify-content: center; padding: 10px; background: #dc2626; border: none; border-radius: 6px; color: #fff; text-decoration: none; font-weight: 500; font-size: 0.95rem; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            Annuler
                        </a>
                        <button type="submit" style="flex: 1; background-color: #e67e00; color: #fff; border: none; padding: 10px; border-radius: 6px; font-weight: 500; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            Enregistrer
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection

@push('scripts')
@endpush
