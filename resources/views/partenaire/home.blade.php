@extends('layouts.partenaire')

@section('title', 'Karnou Partenaire')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .home { position: absolute; inset: 0; background: #212121; overflow: hidden; }
    .home-map { position: absolute; inset: 0; z-index: 0; }
    .leaflet-tile-pane { filter: brightness(0.6) invert(1) contrast(3) hue-rotate(200deg) brightness(0.3) saturate(0.3); }
    .home-map .leaflet-control-attribution { display: none; }
    .user-marker { background: #004aad; border: 3px solid #fff; border-radius: 50%; width: 20px !important; height: 20px !important; box-shadow: 0 0 12px rgba(0,0,0,.6); }
    .home-dim { position: absolute; inset: 0; background: rgba(0,0,0,.12); z-index: 1; pointer-events: none; }

    .home-header { position: absolute; top: calc(14px + var(--sat)); left: 0; right: 0; z-index: 10; display: flex; align-items: center; justify-content: space-between; padding: 0 20px; }
    .home-circle { width: 48px; height: 48px; border-radius: 50%; background: rgba(0,0,0,.82); border: 1px solid #1e1e1e; display: flex; align-items: center; justify-content: center; color: #fff; cursor: pointer; text-decoration: none; }
    .home-pill { display: flex; align-items: center; gap: 4px; background: #000; border: 1px solid #1e1e1e; height: 48px; padding: 0 22px; border-radius: 30px; color: #fff; text-decoration: none; }
    .home-pill b { font-size: 18px; font-weight: 900; }

    .home-banner { position: absolute; top: calc(74px + var(--sat)); left: 16px; right: 16px; z-index: 9; background: rgba(255,107,0,.16); border: 1px solid rgba(255,107,0,.4); color: #ffd9bd; padding: 10px 14px; border-radius: 14px; font-size: 13px; text-align: center; }

    .home-bottom { position: absolute; bottom: calc(34px + var(--sab)); left: 0; right: 0; z-index: 20; padding: 0 20px; text-align: center; }
    .go-btn { width: 100%; height: 80px; border: 0; border-radius: 24px; font-size: 24px; font-weight: 900; letter-spacing: 1px; cursor: pointer; box-shadow: 0 12px 30px rgba(0,0,0,.4); font-family: inherit; }
    .go-btn--off { background: var(--karnou-orange); color: #000; }
    .go-btn--on { background: #FF3B30; color: #fff; }
    .home-status { margin-top: 14px; color: #cbd5e1; font-size: 13px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .home-status .pulse { width: 9px; height: 9px; border-radius: 50%; background: #10B981; animation: pulse 1.4s infinite; }
    @keyframes pulse { 0%,100% { opacity: 1 } 50% { opacity: .25 } }

    /* Overlay mission (équivalent RequestOverlay) */
    .mission { position: absolute; inset: 0; z-index: 100; background: var(--karnou-blue); padding: calc(50px + var(--sat)) 24px calc(34px + var(--sab)); display: flex; flex-direction: column; animation: missionUp .35s cubic-bezier(.2,.8,.2,1); }
    @keyframes missionUp { from { transform: translateY(100%) } to { transform: translateY(0) } }
    .mission-close { width: 46px; height: 46px; border: 0; border-radius: 50%; background: rgba(0,0,0,.12); color: rgba(255,255,255,.7); font-size: 22px; cursor: pointer; }
    .mission-title { text-align: center; color: #fff; font-size: 28px; font-weight: 900; letter-spacing: -1px; margin-top: 14px; }
    .mission-badge { display: block; width: max-content; margin: 8px auto 0; background: rgba(0,0,0,.12); color: #fff; font-size: 10px; font-weight: 900; letter-spacing: 1px; padding: 4px 12px; border-radius: 8px; }
    .mission-fare { text-align: center; color: #fff; font-size: 60px; font-weight: 900; margin: 32px 0; }
    .mission-fare span { font-size: 22px; opacity: .6; }
    .mission-route { padding-left: 40px; position: relative; }
    .mission-route .line { position: absolute; left: 11px; top: 12px; bottom: 12px; width: 2px; background: rgba(255,255,255,.18); }
    .mission-stop { position: relative; margin-bottom: 26px; }
    .mission-stop .dot { position: absolute; left: -38px; top: 2px; width: 18px; height: 18px; border-radius: 4px; border: 3px solid var(--karnou-blue); }
    .mission-stop .lbl { color: rgba(255,255,255,.45); font-size: 10px; font-weight: 900; letter-spacing: 1px; }
    .mission-stop .addr { color: #fff; font-size: 19px; font-weight: 800; }
    .mission-accept { margin-top: auto; width: 100%; height: 88px; background: #fff; border: 0; border-radius: 26px; display: flex; align-items: center; justify-content: center; gap: 18px; cursor: pointer; font-family: inherit; }
    .mission-timer { width: 50px; height: 50px; border-radius: 50%; border: 4px solid #eee; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900; color: #111; }
    .mission-accept b { font-size: 23px; font-weight: 900; letter-spacing: 1px; color: #111; }
</style>
@endpush

@section('content')
<div class="home" x-data="driverHome({
        enLigne: {{ $enLigne ? 'true' : 'false' }},
        verifie: {{ $verifie ? 'true' : 'false' }},
        gains: {{ $gainsJour }},
        lat: {{ $position['lat'] ?? 'null' }},
        lng: {{ $position['lng'] ?? 'null' }},
        urls: {
            toggle: '{{ route('partenaire.toggle-online') }}',
            position: '{{ route('partenaire.position') }}',
            missions: '{{ route('partenaire.missions') }}'
        }
    })" x-init="init()">

    <div id="map" class="home-map"></div>
    <div class="home-dim"></div>

    {{-- Header flottant --}}
    <div class="home-header" x-show="!mission" x-cloak>
        <a href="{{ Route::has('partenaire.profil') ? route('partenaire.profil') : '#' }}" class="home-circle" title="Profil">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>
        </a>
        <a href="{{ Route::has('partenaire.gains') ? route('partenaire.gains') : '#' }}" class="home-pill">
            <b><span x-text="gains.toLocaleString('fr-FR')"></span> FCFA</b>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.4)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </a>
        <button class="home-circle" @click="recenter()" title="Recentrer">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/></svg>
        </button>
    </div>

    <div class="home-banner" x-show="!verifie && !mission" x-cloak>
        ⏳ Votre profil est en cours de vérification. Vous pourrez recevoir des courses une fois validé.
    </div>

    {{-- Zone basse : bouton EN LIGNE / HORS LIGNE --}}
    <div class="home-bottom" x-show="!mission" x-cloak>
        <button class="go-btn" :class="enLigne ? 'go-btn--on' : 'go-btn--off'" @click="toggle()" x-text="enLigne ? 'HORS LIGNE' : 'EN LIGNE'"></button>
        <div class="home-status" x-show="enLigne">
            <span class="pulse"></span>
            <span>Recherche de courses à proximité…</span>
        </div>
    </div>

    {{-- Overlay mission entrante --}}
    <template x-if="mission">
        <div class="mission">
            <button class="mission-close" @click="decline()">✕</button>
            <div class="mission-title">Nouvelle commande</div>
            <span class="mission-badge">+2 POINTS D'ACTIVITÉ</span>

            <div class="mission-fare"><span x-text="mission.montant.toLocaleString('fr-FR')"></span> <span>CFA</span></div>

            <div class="mission-route">
                <div class="line"></div>
                <div class="mission-stop">
                    <span class="dot" style="background:#000"></span>
                    <div class="lbl">RAMASSAGE</div>
                    <div class="addr" x-text="mission.ramassage"></div>
                </div>
                <div class="mission-stop">
                    <span class="dot" style="background:#fff"></span>
                    <div class="lbl">DESTINATION</div>
                    <div class="addr" x-text="mission.destination"></div>
                </div>
            </div>

            <button class="mission-accept" @click="accept()">
                <span class="mission-timer" x-text="countdown"></span>
                <b>ACCEPTER</b>
            </button>
        </div>
    </template>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    function driverHome(cfg) {
        return {
            enLigne: cfg.enLigne,
            verifie: cfg.verifie,
            gains: cfg.gains,
            urls: cfg.urls,
            map: null,
            marker: null,
            lastPush: 0,
            pollTimer: null,
            mission: null,
            declined: new Set(),
            countdown: 15,
            countdownTimer: null,

            init() {
                const start = (cfg.lat && cfg.lng) ? [cfg.lat, cfg.lng] : [5.3484, -4.0305];
                this.map = L.map('map', { zoomControl: false, attributionControl: false }).setView(start, 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(this.map);
                if (cfg.lat && cfg.lng) this.setMarker(cfg.lat, cfg.lng);

                this.watchGps();
                if (this.enLigne) this.startPolling();
            },

            csrf() { return document.querySelector('meta[name=csrf-token]').content; },

            setMarker(lat, lng) {
                if (!this.marker) {
                    this.marker = L.marker([lat, lng], { icon: L.divIcon({ className: 'user-marker' }) }).addTo(this.map);
                } else {
                    this.marker.setLatLng([lat, lng]);
                }
            },

            watchGps() {
                if (!('geolocation' in navigator)) return;
                navigator.geolocation.watchPosition(
                    (pos) => {
                        const { latitude: lat, longitude: lng } = pos.coords;
                        this.setMarker(lat, lng);
                        this.pushPosition(lat, lng);
                    },
                    () => {},
                    { enableHighAccuracy: true, maximumAge: 5000, timeout: 15000 }
                );
            },

            pushPosition(lat, lng) {
                const now = Date.now();
                if (now - this.lastPush < 8000) return; // throttle 8s
                this.lastPush = now;
                fetch(this.urls.position, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': this.csrf() },
                    body: JSON.stringify({ lat, lng })
                }).catch(() => {});
            },

            recenter() {
                if (this.marker) this.map.panTo(this.marker.getLatLng());
            },

            toggle() {
                fetch(this.urls.toggle, { method: 'POST', headers: { 'X-CSRF-TOKEN': this.csrf() } })
                    .then(r => r.json())
                    .then(d => {
                        this.enLigne = d.en_ligne;
                        if (this.enLigne) { this.startPolling(); }
                        else { this.stopPolling(); this.mission = null; }
                    })
                    .catch(() => alert('Connexion impossible. Réessayez.'));
            },

            startPolling() {
                this.poll();
                this.pollTimer = setInterval(() => this.poll(), 10000);
            },
            stopPolling() {
                if (this.pollTimer) clearInterval(this.pollTimer);
                this.pollTimer = null;
            },

            poll() {
                if (this.mission) return; // déjà une mission affichée
                fetch(this.urls.missions, { headers: { 'Accept': 'application/json' } })
                    .then(r => r.json())
                    .then(d => {
                        if (!d.en_ligne) return;
                        const next = (d.missions || []).find(m => !this.declined.has(m.id));
                        if (next) this.showMission(next);
                    })
                    .catch(() => {});
            },

            showMission(m) {
                this.mission = m;
                this.countdown = 15;
                this.countdownTimer = setInterval(() => {
                    this.countdown--;
                    if (this.countdown <= 0) this.decline();
                }, 1000);
            },

            decline() {
                if (this.mission) this.declined.add(this.mission.id);
                this.clearMission();
            },

            clearMission() {
                if (this.countdownTimer) clearInterval(this.countdownTimer);
                this.countdownTimer = null;
                this.mission = null;
            },

            accept() {
                // La prise en charge réelle + cycle de vie de la course arrivent en Phase 4.
                alert('Mission #' + this.mission.reference + ' — la prise en charge sera disponible en Phase 4.');
                this.clearMission();
            },
        };
    }
</script>
@endpush
