@extends('partenaire::layouts.partenaire')

@section('title', 'Autorisations — Karnou Partenaire')

@section('content')
<div class="pt-screen" x-data="permissions()">
    <div class="pt-header">
        <div style="width:44px"></div>
        <div class="pt-progress"><i style="width:65%"></i></div>
    </div>

    <div class="pt-body">
        <h1 class="pt-title">Quelques autorisations</h1>
        <p class="pt-subtitle">Karnou en a besoin pour vous attribuer des courses proches de vous et vous prévenir en temps réel.</p>

        <div class="pt-section">
            <button type="button" class="pt-option" :class="{ 'is-active': geo === 'granted' }" @click="askGeo()">
                <span class="ic-box">📍</span>
                <span style="flex:1">
                    <h3>Localisation</h3>
                    <p x-text="geoLabel()"></p>
                </span>
                <span x-show="geo === 'granted'" style="color:var(--karnou-orange);font-weight:700">✓</span>
            </button>

            <button type="button" class="pt-option" :class="{ 'is-active': notif === 'granted' }" @click="askNotif()">
                <span class="ic-box">🔔</span>
                <span style="flex:1">
                    <h3>Notifications</h3>
                    <p x-text="notifLabel()"></p>
                </span>
                <span x-show="notif === 'granted'" style="color:var(--karnou-orange);font-weight:700">✓</span>
            </button>
        </div>

        <p class="pt-muted" style="margin-top:20px;">Vous pourrez modifier ces autorisations à tout moment dans les réglages de votre téléphone.</p>
    </div>

    <div class="pt-footer">
        <a href="{{ route('partenaire.metier') }}" class="pt-btn">Continuer</a>
    </div>
</div>

@push('scripts')
<script>
    function permissions() {
        return {
            geo: 'prompt',
            notif: '{{ 'default' }}',
            init() {
                if ('Notification' in window) this.notif = Notification.permission;
                if (navigator.permissions) {
                    navigator.permissions.query({ name: 'geolocation' })
                        .then(s => { this.geo = s.state; s.onchange = () => this.geo = s.state; })
                        .catch(() => {});
                }
            },
            askGeo() {
                if (!('geolocation' in navigator)) { alert('Géolocalisation non supportée.'); return; }
                navigator.geolocation.getCurrentPosition(
                    () => this.geo = 'granted',
                    () => this.geo = 'denied',
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            },
            askNotif() {
                if (!('Notification' in window)) { alert('Notifications non supportées.'); return; }
                Notification.requestPermission().then(p => this.notif = p);
            },
            geoLabel() {
                return { granted: 'Activée', denied: 'Refusée — appuyez pour réessayer', prompt: 'Appuyez pour autoriser' }[this.geo] || 'Appuyez pour autoriser';
            },
            notifLabel() {
                return { granted: 'Activées', denied: 'Refusées — appuyez pour réessayer', default: 'Appuyez pour autoriser' }[this.notif] || 'Appuyez pour autoriser';
            },
        };
    }
</script>
@endpush
@endsection
