@extends('layouts.admin')

@section('title', 'Configuration Générale')

@push('styles')
    <style>
        .main-content {
            background-color: #f8f9fa !important;
        }

        /* Input Amazon Style Modernisé */
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="url"],
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

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #ff9900 !important;
            box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15);
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
        }

        .btn-amazon-secondary:hover {
            background: #f8fafc;
            border-color: #dee2e6;
            color: #1e293b;
        }

        .action-button {
            width: 32px; 
            height: 32px; 
            border-radius: 4px;
            display: flex; 
            align-items: center; 
            justify-content: center;
            transition: all 0.1s;
            cursor: pointer;
            border: 1px solid #dee2e6;
        }
        
        .action-button.danger {
            background: #fff;
            color: #c40000;
        }
        
        .action-button.danger:hover {
            background: #fff5f5;
            border-color: #ffcccc;
        }

        .action-button.normal {
            background: #f8fafc;
            color: #1e293b;
        }

        .action-button.normal:hover {
            background: #e2e8f0;
        }

        /* intl-tel-input integration */
        .iti {
            width: 100% !important;
        }

        .iti__flag-container {
            z-index: 1000 !important;
        }

        .iti--separate-dial-code .iti__selected-flag {
            border-right: 1px solid #dee2e6 !important;
            padding-right: 10px !important;
            margin-right: -1px !important;
            background: transparent !important;
            border-radius: 4px 0 0 4px !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/css/intlTelInput.css">
@endpush

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/js/intlTelInput.min.js"></script>
<script>
    window.initPhoneField = function (el) {
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

@section('sub_header')
    @include('admin.partials.settings-tabs')
@endsection

@section('content')
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
        }" style="max-width: 1200px; margin: 0 auto;">

        <div style="background: #fff; border: 1px solid #eff3f6; border-top: none; border-radius: 0 0 8px 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.02); padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eff3f6; padding-bottom: 15px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="display: flex; align-items: center; gap: 8px; color: #475569; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; height: 28px;">
                        <i class="fas fa-cogs" style="font-size: 0.8rem;"></i>
                        <span>Configuration Générale</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settings-form">
                @csrf
                <input type="hidden" name="remove_logo" :value="removeLogoFlag ? '1' : '0'">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: stretch;">

                    <!-- Left Column: Visuel -->
                    <div class="amazon-card" style="margin: 0; display: flex; flex-direction: column;">
                        <h3 class="section-title">Visuel du Projet</h3>
                        <p style="font-size: 0.82rem; color: #64748b; margin-bottom: 20px;">Personnalisez l'apparence de
                            votre plateforme en ajoutant le logo officiel.</p>

                        <div
                            style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 4px; padding: 20px; display: flex; align-items: flex-start; gap: 25px; flex-grow: 1;">
                            <!-- Preview Box -->
                            <div
                                style="flex-shrink: 0; width: 140px; height: 140px; background: #fff; border: 1px solid #cbd5e1; border-radius: 4px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                                <template x-if="logoPreview">
                                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                                        <img :src="logoPreview" alt="Logo"
                                            style="max-width: 90%; max-height: 90%; object-fit: contain;">
                                        <button type="button" @click="clearLogo" x-show="logoPreview && !removeLogoFlag"
                                            style="position: absolute; top: 5px; right: 5px; width: 24px; height: 24px; background: #fff; border: 1px solid #cbd5e1; color: #c40000; border-radius: 4px; cursor: pointer; display: flex; align-items: center; justify-content: center;"
                                            title="Supprimer">
                                            <i class="fas fa-times" style="font-size: 0.75rem;"></i>
                                        </button>
                                    </div>
                                </template>
                                <template x-if="!logoPreview">
                                    <div style="text-align: center; color: #94a3b8;">
                                        <i class="far fa-image"
                                            style="font-size: 2rem; margin-bottom: 5px; display: block;"></i>
                                        <span style="font-size: 0.7rem; font-weight: 600;">AUCUN VISUEL</span>
                                    </div>
                                </template>
                            </div>

                            <!-- Actions -->
                            <div style="flex-grow: 1;">
                                <h4 style="font-size: 0.9rem; font-weight: 700; color: #1e293b; margin: 0 0 5px 0;">Logo de marque</h4>
                                <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 15px;">Format PNG ou SVG
                                    recommandé pour une meilleure transparence.</p>

                                <button type="button" @click="$refs.logoInput.click()" class="btn-amazon-primary"
                                    style="width: auto; padding: 6px 15px;">
                                    <i class="fas fa-upload" style="font-size: 0.8rem;"></i> Choisir un fichier
                                </button>
                                <input type="file" x-ref="logoInput" name="logo" accept="image/*" style="display: none;"
                                    @change="handleLogoChange">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Contact -->
                    <div class="amazon-card" style="margin: 0; display: flex; flex-direction: column;">
                        <h3 class="section-title">Contact & Coordonnées</h3>
                        <div style="display: grid; gap: 20px; flex-grow: 1; align-content: start;">
                            <div>
                                <label class="field-label" style="margin-bottom: 8px;">Emails de contact</label>
                                <template x-for="(email, index) in emails" :key="index">
                                    <div style="display: flex; gap: 8px; margin-bottom: 10px; align-items: center;">
                                        <input type="email" name="contact_emails[]" x-model="emails[index]" style="flex: 1;">

                                        <button type="button" @click="removeEmail(index)" x-show="emails.length > 1" class="action-button danger">
                                            <i class="fas fa-trash-alt" style="font-size: 0.8rem;"></i>
                                        </button>

                                        <button type="button" @click="addEmail" x-show="index === emails.length - 1" class="action-button normal">
                                            <i class="fas fa-plus" style="font-size: 0.8rem;"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <div>
                                <label class="field-label" style="margin-bottom: 8px;">Téléphones</label>
                                <template x-for="(phone, index) in phones" :key="index">
                                    <div style="display: flex; gap: 8px; margin-bottom: 10px; align-items: center;">
                                        <div style="flex: 1;">
                                            <input type="tel" name="contact_phones[]" x-model="phones[index]"
                                                x-init="window.initPhoneField($el)" style="width: 100%;">
                                        </div>
                                        <button type="button" @click="removePhone(index)" x-show="phones.length > 1" class="action-button danger">
                                            <i class="fas fa-trash-alt" style="font-size: 0.8rem;"></i>
                                        </button>
                                        <button type="button" @click="addPhone" x-show="index === phones.length - 1" class="action-button normal">
                                            <i class="fas fa-plus" style="font-size: 0.8rem;"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>

                            <div>
                                <label for="contact_address" class="field-label" style="margin-bottom: 8px;">Adresse Physique</label>
                                <textarea name="contact_address" id="contact_address" rows="2"
                                    style="resize: vertical; font-family: inherit;">{{ $settings['contact_address'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Left Column Remaining -->
                    <div style="display: flex; flex-direction: column;">
                        <!-- Identity Card -->
                        <div class="amazon-card">
                            <h3 class="section-title">Identité du Projet</h3>
                            <div style="display: grid; gap: 20px;">
                                <div>
                                    <label for="site_name" class="field-label" style="margin-bottom: 8px;">Nom du Site</label>
                                    <input type="text" name="site_name" id="site_name" value="{{ $settings['site_name'] ?? 'Dwesta' }}">
                                </div>
                                <div>
                                    <label for="site_description" class="field-label" style="margin-bottom: 8px;">Description (Meta-data)</label>
                                    <textarea name="site_description" id="site_description" rows="4"
                                        style="resize: vertical; font-family: inherit;">{{ $settings['site_description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Legal Card -->
                        <div class="amazon-card" style="margin-bottom: 0;">
                            <h3 class="section-title">Informations Légales</h3>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div>
                                    <label for="legal_rc" class="field-label" style="margin-bottom: 8px;">Registre de Commerce (RC)</label>
                                    <input type="text" name="legal_rc" id="legal_rc" value="{{ $settings['legal_rc'] ?? '' }}">
                                </div>
                                <div>
                                    <label for="legal_ninea" class="field-label" style="margin-bottom: 8px;">NINEA</label>
                                    <input type="text" name="legal_ninea" id="legal_ninea" value="{{ $settings['legal_ninea'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Row 2: Right Column Remaining -->
                    <div style="display: flex; flex-direction: column;">
                        <!-- Social Card -->
                        <div class="amazon-card" style="flex-grow: 1;">
                            <h3 class="section-title">Réseaux Sociaux</h3>
                            <div style="display: grid; gap: 12px;">
                                <div>
                                    <label class="field-label" style="margin-bottom: 4px;">Facebook</label>
                                    <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}">
                                </div>
                                <div>
                                    <label class="field-label" style="margin-bottom: 4px;">Instagram</label>
                                    <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}">
                                </div>
                                <div>
                                    <label class="field-label" style="margin-bottom: 4px;">Twitter / X</label>
                                    <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}">
                                </div>
                                <div>
                                    <label class="field-label" style="margin-bottom: 4px;">LinkedIn</label>
                                    <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? '' }}">
                                </div>
                                <div>
                                    <label class="field-label" style="margin-bottom: 4px;">YouTube</label>
                                    <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}">
                                </div>
                                <div>
                                    <label class="field-label" style="margin-bottom: 4px;">TikTok</label>
                                    <input type="url" name="social_tiktok" value="{{ $settings['social_tiktok'] ?? '' }}">
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions sticky or at bottom -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; border-top: 1px solid #eff3f6; padding-top: 20px; margin-top: 20px;">
                            <a href="{{ route('admin.dashboard') }}" class="btn-amazon-secondary" style="width: 100%;">
                                ANNULER
                            </a>
                            <button type="submit" class="btn-amazon-primary" style="width: 100%;">
                                ENREGISTRER
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/js/intlTelInput.min.js" defer></script>
        <script>
            window.initPhoneField = function (el) {
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