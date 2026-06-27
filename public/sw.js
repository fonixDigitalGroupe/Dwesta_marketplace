/* Karnou Partenaire — Service Worker (servi depuis la racine, scope: /partenaire) */
const VERSION = 'karnou-partenaire-v1';
const STATIC_CACHE = `${VERSION}-static`;
const OFFLINE_URL = '/pwa/offline.html';

// Ressources de coquille (app shell) précachées à l'installation.
const PRECACHE_URLS = [
    OFFLINE_URL,
    '/pwa/icons/icon-192.png',
    '/pwa/icons/icon-512.png',
    '/pwa/manifest.webmanifest',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE).then((cache) => cache.addAll(PRECACHE_URLS)).then(() => self.skipWaiting())
    );
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(keys.filter((k) => !k.startsWith(VERSION)).map((k) => caches.delete(k)))
        ).then(() => self.clients.claim())
    );
});

self.addEventListener('fetch', (event) => {
    const { request } = event;

    // On ne gère que le GET de même origine ; le reste passe directement au réseau.
    if (request.method !== 'GET' || new URL(request.url).origin !== self.location.origin) {
        return;
    }

    // Navigations (pages HTML) : réseau d'abord, repli sur la page hors-ligne.
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(() => caches.match(OFFLINE_URL))
        );
        return;
    }

    // Assets statiques (icônes, build Vite) : cache d'abord, puis réseau + mise en cache.
    const url = new URL(request.url);
    const isAsset = url.pathname.startsWith('/pwa/icons/') || url.pathname.startsWith('/build/');
    if (isAsset) {
        event.respondWith(
            caches.match(request).then((cached) =>
                cached ||
                fetch(request).then((response) => {
                    const copy = response.clone();
                    caches.open(STATIC_CACHE).then((cache) => cache.put(request, copy));
                    return response;
                }).catch(() => cached)
            )
        );
    }
});
