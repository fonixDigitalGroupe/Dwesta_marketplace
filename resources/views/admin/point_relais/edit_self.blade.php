@extends('layouts.admin')

@section('title', 'Modifier mon Point Relais')

@section('breadcrumbs')
    > <span>Point Relais</span> > <span>Modifier</span>
@endsection

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 2rem 0;">
    <div class="card-pro">
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #1e293b; margin-bottom: 2rem;">Modifier les informations du Point Relais</h2>
        
        <form action="{{ route('admin.prive.point-relais.update', $point_relais) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nom (Disabled) -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Nom du Point Relais</label>
                <input type="text" value="{{ $point_relais->nom }}" disabled 
                    style="width: 100%; padding: 0.75rem; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; color: #64748b;">
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">Le nom ne peut être modifié que par un administrateur.</p>
            </div>

            <!-- Adresse (Disabled) -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Adresse</label>
                <textarea disabled style="width: 100%; padding: 0.75rem; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 8px; color: #64748b;">{{ $point_relais->adresse }}</textarea>
                <p style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">L'adresse ne peut être modifiée que par un administrateur.</p>
            </div>

            <!-- Téléphone -->
            <div style="margin-bottom: 1.5rem;">
                <label for="telephone" style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Téléphone de contact</label>
                <input type="tel" name="full_telephone" id="telephone" value="{{ old('telephone', $point_relais->telephone) }}" 
                    class="form-input" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;">
            </div>

            <!-- Google Maps URL -->
            <div style="margin-bottom: 1.5rem;">
                <label for="google_maps_url" style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Lien Google Maps</label>
                <input type="url" name="google_maps_url" id="google_maps_url" value="{{ old('google_maps_url', $point_relais->google_maps_url) }}" 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;" placeholder="https://maps.google.com/...">
            </div>

            <!-- Horaires -->
            <div style="margin-bottom: 2rem;">
                <label for="horaires" style="display: block; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Horaires d'ouverture</label>
                <textarea name="horaires" id="horaires" rows="4" 
                    style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;" placeholder="Lundi - Vendredi : 09h - 18h...">{{ old('horaires', $point_relais->horaires) }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ route('admin.prive.point-relais.dashboard') }}" 
                    style="padding: 0.75rem 1.5rem; color: #64748b; font-weight: 600; text-decoration: none; border: 1px solid #cbd5e1; border-radius: 8px;">
                    Annuler
                </a>
                <button type="submit" 
                    style="padding: 0.75rem 1.5rem; background: #6b21a8; color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer;">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
<style>
    .iti { width: 100%; }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script>
    const input = document.querySelector("#telephone");
    if (input) {
        window.intlTelInput(input, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            initialCountry: "auto",
            geoIpLookup: function(callback) {
                fetch('https://ipinfo.io/json?token=YOUR_TOKEN', { headers: { 'Accept': 'application/json' }})
                  .then((resp) => resp.json())
                  .then((resp) => { callback(resp.country); })
                  .catch(() => { callback('sn'); });
            },
            preferredCountries: ['sn', 'ci', 'ml', 'gn', 'bf']
        });
    }
</script>
@endpush
@endsection
