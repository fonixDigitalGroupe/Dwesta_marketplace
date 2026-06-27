@extends('partenaire::layouts.partenaire')

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

    /* Carte de course active */
    .trip { background: #0F0F0F; border: 1px solid #1e1e1e; border-radius: 28px; padding: 22px; box-shadow: 0 12px 30px rgba(0,0,0,.45); text-align: left; }
    .trip-head { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; }
    .trip-ind { width: 10px; height: 10px; border-radius: 50%; background: var(--karnou-orange); }
    .trip-status { color: var(--karnou-orange); font-size: 12px; font-weight: 900; letter-spacing: 1px; }
    .trip-addr { color: #fff; font-size: 23px; font-weight: 900; line-height: 1.15; }
    .trip-client { color: #94A3B8; font-size: 13px; margin-top: 4px; }
    .trip-code { margin-top: 16px; }
    .trip-code label { display: block; color: #94A3B8; font-size: 12px; font-weight: 700; margin-bottom: 6px; }
    .trip-code input { width: 100%; background: #1a1a1a; border: 1.5px solid #2a2a2a; border-radius: 14px; color: #fff; font-size: 22px; font-weight: 800; letter-spacing: 8px; text-align: center; padding: 12px; outline: none; font-family: inherit; }
    .trip-code small { display: block; color: #64748B; font-size: 12px; margin-top: 6px; }
    .trip-code small b { color: #10B981; letter-spacing: 2px; }
    .trip-btn { margin-top: 18px; width: 100%; height: 62px; background: var(--karnou-orange); color: #fff; border: 0; border-radius: 18px; font-size: 17px; font-weight: 900; letter-spacing: .5px; cursor: pointer; font-family: inherit; }
</style>
@endpush

@section('content')
<div class="home" x-data="driverHome({
        enLigne: {{ $enLigne ? 'true' : 'false' }},
        verifie: {{ $verifie ? 'true' : 'false' }},
        gains: {{ $gainsJour }},
        lat: {{ $position['lat'] ?? 'null' }},
        lng: {{ $position['lng'] ?? 'null' }},
        type: '{{ $type }}',
        urls: {
            toggle: '{{ route('partenaire.toggle-online') }}',
            position: '{{ route('partenaire.position') }}',
            missions: '{{ route('partenaire.missions') }}',
            courseActive: '{{ route('partenaire.course.active') }}',
            courseBase: '{{ url('partenaire/course') }}'
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

    {{-- Zone basse : course active OU bouton EN LIGNE / HORS LIGNE --}}
    <div class="home-bottom" x-show="!mission" x-cloak>
        {{-- Carte de course active --}}
        <template x-if="course">
            <div class="trip">
                <div class="trip-head">
                    <span class="trip-ind"></span>
                    <span class="trip-status" x-text="tripStatus()"></span>
                </div>
                <div class="trip-addr" x-text="tripAddr()"></div>
                <div class="trip-client">Course <span x-text="course.reference"></span> · <span x-text="course.montant.toLocaleString('fr-FR')"></span> FCFA</div>

                {{-- Saisie du code de livraison (livreur, étape finale) --}}
                <template x-if="step === 'destination' && course.type === 'livreur'">
                    <div class="trip-code">
                        <label>Code de livraison du client</label>
                        <input type="tel" inputmode="numeric" maxlength="4" x-model="codeInput" placeholder="0000">
                        <small x-show="course.code_livraison">Démo — code client : <b x-text="course.code_livraison"></b></small>
                    </div>
                </template>

                <button class="trip-btn" @click="advance()" x-text="tripAction()"></button>
            </div>
        </template>

        {{-- Bouton En ligne / Hors ligne --}}
        <template x-if="!course">
            <div>
                <button class="go-btn" :class="enLigne ? 'go-btn--on' : 'go-btn--off'" @click="toggle()" x-text="enLigne ? 'HORS LIGNE' : 'EN LIGNE'"></button>
                <div class="home-status" x-show="enLigne">
                    <span class="pulse"></span>
                    <span>Recherche de courses à proximité…</span>
                </div>
            </div>
        </template>
    </div>

    {{-- Overlay mission entrante --}}
    <template x-if="mission && !course">
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
            type: cfg.type,
            course: null,
            step: 'pickup',
            codeInput: '',

            init() {
                const start = (cfg.lat && cfg.lng) ? [cfg.lat, cfg.lng] : [5.3484, -4.0305];
                this.map = L.map('map', { zoomControl: false, attributionControl: false }).setView(start, 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(this.map);
                if (cfg.lat && cfg.lng) this.setMarker(cfg.lat, cfg.lng);

                this.watchGps();
                this.loadActive();
                if (this.enLigne) this.startPolling();
            },

            /* ----- Course active : reprise après rechargement ----- */
            loadActive() {
                fetch(this.urls.courseActive, { headers: { 'Accept': 'application/json' } })
                    .then(r => r.json())
                    .then(d => {
                        if (d.course) {
                            this.course = d.course;
                            this.step = localStorage.getItem('karnou_step_' + d.course.id) || 'pickup';
                            this.stopPolling();
                        }
                    })
                    .catch(() => {});
            },

            tripStatus() {
                return {
                    pickup: 'ALLER AU POINT DE COLLECTE',
                    on_site: 'COLIS RÉCUPÉRÉ',
                    destination: 'LIVRAISON EN COURS',
                }[this.step];
            },
            tripAddr() {
                return this.step === 'pickup' ? this.course.ramassage : this.course.destination;
            },
            tripAction() {
                return {
                    pickup: 'ARRIVÉ AU POINT',
                    on_site: 'DÉMARRER LA COURSE',
                    destination: this.type === 'livreur' ? 'TERMINER LA MISSION' : 'DÉPOSER AU RELAIS',
                }[this.step];
            },
            advance() {
                if (this.step === 'pickup') { this.setStep('on_site'); }
                else if (this.step === 'on_site') { this.setStep('destination'); }
                else if (this.step === 'destination') { this.complete(); }
            },
            setStep(s) {
                this.step = s;
                if (this.course) localStorage.setItem('karnou_step_' + this.course.id, s);
            },

            complete() {
                const body = {};
                if (this.type === 'livreur') {
                    if (!/^\d{4}$/.test(this.codeInput)) { alert('Saisissez le code à 4 chiffres du client.'); return; }
                    body.code = this.codeInput;
                }
                fetch(this.urls.courseBase + '/' + this.course.id + '/terminer', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': this.csrf() },
                    body: JSON.stringify(body)
                })
                .then(async r => ({ ok: r.ok, data: await r.json() }))
                .then(({ ok, data }) => {
                    if (!ok) { alert(data.message || 'Erreur.'); return; }
                    localStorage.removeItem('karnou_step_' + this.course.id);
                    alert(data.message || 'Course terminée !');
                    this.course = null; this.step = 'pickup'; this.codeInput = '';
                    if (this.enLigne) this.startPolling();
                })
                .catch(() => alert('Connexion impossible.'));
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
                const id = this.mission.id;
                fetch(this.urls.courseBase + '/' + id + '/accepter', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': this.csrf() }
                })
                .then(async r => ({ ok: r.ok, data: await r.json() }))
                .then(({ ok, data }) => {
                    if (!ok) {
                        alert(data.message || 'Course indisponible.');
                        this.decline();
                        return;
                    }
                    if (this.countdownTimer) clearInterval(this.countdownTimer);
                    this.countdownTimer = null;
                    this.mission = null;
                    this.stopPolling();
                    this.course = data.course;
                    this.setStep('pickup');
                })
                .catch(() => alert('Connexion impossible.'));
            },
        };
    }
</script>
@endpush
