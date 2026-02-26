@extends('layouts.admin')

@section('title', 'Configuration Générale')

@section('breadcrumbs')
    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="opacity: 0.4;">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
    </svg>
    <span style="color: #333; font-weight: 500;">Configuration Générale</span>
@endsection

@section('content')
    <div x-data="{ 
        emails: {{ isset($settings['contact_emails']) ? json_encode($settings['contact_emails']) : json_encode(['']) }},
        phones: {{ isset($settings['contact_phones']) ? json_encode($settings['contact_phones']) : json_encode(['']) }},
        logoPreview: '{{ isset($settings['logo']) ? asset('storage/' . $settings['logo']) : '' }}',
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
            }
        },
        clearLogo() {
            this.logoPreview = '';
            this.removeLogoFlag = true;
            this.$refs.logoInput.value = '';
        }
    }" style="max-width: 1000px; margin: 0 auto;">

        <header style="margin-bottom: 1.5rem;">
            <h1 style="font-size: 1.5rem; color: #333; font-weight: 500; margin-bottom: 0.25rem;">Configuration Générale</h1>
            <p style="font-size: 0.95rem; color: #666; font-weight: 400;">Gérez les paramètres globaux de votre marketplace de manière professionnelle.</p>
        </header>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settings-form">
            @csrf
            
            <input type="hidden" name="remove_logo" :value="removeLogoFlag ? '1' : '0'">

            <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">

                <!-- Main Column (Left) -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <!-- Section 1: Identité du Projet -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Section 1: Identité du Projet
                        </h2>
                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Nom du Site</label>
                                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Dwesta' }}" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Description</label>
                                <textarea name="site_description" rows="4" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s; resize: vertical;" onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">{{ $settings['site_description'] ?? '' }}</textarea>
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
                                <input type="text" name="legal_rc" value="{{ $settings['legal_rc'] ?? '' }}" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">NINEA</label>
                                <input type="text" name="legal_ninea" value="{{ $settings['legal_ninea'] ?? '' }}" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">
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
                                        <img :src="logoPreview" alt="Logo" style="max-width: 90%; max-height: 90%; object-fit: contain; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
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
                                    <p style="font-size: 0.85rem; color: #777; margin-bottom: 1.25rem; line-height: 1.5;">Format carré ou horizontal recommandé (PNG, SVG, JPG). Taille max : 2Mo.</p>
                                    
                                    <div style="display: flex; gap: 0.75rem;">
                                        <button type="button" @click="$refs.logoInput.click()" style="padding: 10px 18px; background: #000; color: #fff; border: none; border-radius: 6px; font-size: 0.85rem; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            Choisir un fichier
                                        </button>
                                        
                                        <button type="button" @click="clearLogo" x-show="logoPreview" style="padding: 10px 18px; background: #fff; color: #ef4444; border: 1px solid #fee2e2; border-radius: 6px; font-size: 0.85rem; font-weight: 500; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#fff'">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Supprimer
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
                            Section 2: Contact & Coordonnées
                        </h2>
                        <div style="display: grid; gap: 1.5rem;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Emails de contact</label>
                                <template x-for="(email, index) in emails" :key="index">
                                    <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                                        <input type="email" name="contact_emails[]" x-model="emails[index]" style="flex: 1; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;" onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">
                                        <button type="button" @click="removeEmail(index)" x-show="emails.length > 1" style="background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; padding: 0.5rem; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="addEmail" style="margin-top: 0.5rem; background: #fff; border: 1px dashed #e0e0e0; color: #666; padding: 8px 14px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.borderColor='#666'; this.style.color='#333'" onmouseout="this.style.borderColor='#e0e0e0'; this.style.color='#666'">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Ajouter un email
                                </button>
                            </div>
                            <div id="phone-inputs-container">
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Numéros de téléphone</label>
                                <template x-for="(phone, index) in phones" :key="index">
                                    <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem; align-items: center;">
                                        <div style="flex: 1;">
                                            <input type="tel" :id="'phone-' + index" name="contact_phones[]" x-model="phones[index]" class="phone-input" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none;">
                                        </div>
                                        <button type="button" @click="removePhone(index)" x-show="phones.length > 1" style="background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; padding: 0.5rem; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </template>
                                <button type="button" @click="addPhone" style="margin-top: 0.5rem; background: #fff; border: 1px dashed #e0e0e0; color: #666; padding: 8px 14px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: 500; display: flex; align-items: center; gap: 8px; transition: all 0.2s;" onmouseover="this.style.borderColor='#666'; this.style.color='#333'" onmouseout="this.style.borderColor='#e0e0e0'; this.style.color='#666'">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Ajouter un téléphone
                                </button>
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 8px;">Adresse Physique</label>
                                <textarea name="contact_address" rows="2" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.95rem; color: #333; outline: none; transition: all 0.2s;" onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">{{ $settings['contact_address'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Réseaux Sociaux -->
                    <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.5rem;">
                        <h2 style="font-size: 1.1rem; color: #333; font-weight: 500; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 10px;">
                            Section 3: Réseaux Sociaux
                        </h2>
                        <div style="display: grid; gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 6px;">Facebook</label>
                                <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="URL" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;" onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 6px;">Instagram</label>
                                <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="URL" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;" onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 6px;">Twitter / X</label>
                                <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}" placeholder="URL" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;" onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 500; color: #666; margin-bottom: 6px;">LinkedIn</label>
                                <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}" placeholder="URL" style="width: 100%; padding: 10px 14px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 0.9rem; color: #333; outline: none;" onfocus="this.style.borderColor='#000'" onblur="this.style.borderColor='#e0e0e0'">
                            </div>
                        </div>
                    </div>


                    <!-- Actions -->
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit" style="background-color: #000; color: #fff; border: none; padding: 0.75rem; border-radius: 4px; font-weight: bold; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-size: 0.95rem; transition: opacity 0.2s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                            Enregistrer les paramètres
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                        <a href="{{ route('admin.dashboard') }}" style="display: flex; justify-content: center; padding: 0.75rem; background: #fff; border: 1px solid #e0e0e0; border-radius: 4px; color: #666; text-decoration: none; font-weight: 500; font-size: 0.9rem; transition: all 0.2s;" onmouseover="this.style.background='#f9f9f9'; this.style.color='#333'" onmouseout="this.style.background='#fff'; this.style.color='#666'">
                            Annuler
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.3/build/css/intlTelInput.css">
<style>
    .iti { width: 100%; }
    .iti__flag-container { z-index: 10; }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.3/build/js/intlTelInput.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const initPhones = () => {
            setTimeout(() => {
                const inputs = document.querySelectorAll(".phone-input");
                inputs.forEach(input => {
                    if (!input.dataset.iti) {
                        window.intlTelInput(input, {
                            initialCountry: "fr",
                            separateDialCode: true,
                            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.3/build/js/utils.js",
                        });
                        input.dataset.iti = "true";
                    }
                });
            }, 100);
        };

        initPhones();

        // Observe for added phone inputs (since Alpine might add them)
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.addedNodes.length) {
                    initPhones();
                }
            });
        });

        const container = document.getElementById('phone-inputs-container');
        if (container) {
            observer.observe(container, { childList: true, subtree: true });
        }
    });
</script>
@endpush
