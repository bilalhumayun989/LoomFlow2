const CACHE_NAME = 'loomflow-pwa-v1';
const OFFLINE_URL = '/offline.html';
const APP_ICON_URLS = [
    '/icons/loomflow.svg',
    '/icons/loomflow-192.png',
    '/icons/loomflow-512.png',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll([OFFLINE_URL, ...APP_ICON_URLS]))
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => Promise.all(
            cacheNames
                .filter((cacheName) => cacheName.startsWith('loomflow-pwa-') && cacheName !== CACHE_NAME)
                .map((cacheName) => caches.delete(cacheName))
        ))
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    const request = event.request;
    const requestUrl = new URL(request.url);

    if (request.method !== 'GET' || requestUrl.origin !== self.location.origin) {
        return;
    }

    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(async () => (await caches.match(OFFLINE_URL)) || Response.error())
        );
        return;
    }

    const isStaticAsset = ['style', 'script', 'image', 'font'].includes(request.destination)
        || requestUrl.pathname.startsWith('/build/');

    if (!isStaticAsset) {
        return;
    }

    event.respondWith((async () => {
        const cachedResponse = await caches.match(request);

        try {
            const networkResponse = await fetch(request);
            if (networkResponse.ok && networkResponse.type === 'basic') {
                const cache = await caches.open(CACHE_NAME);
                cache.put(request, networkResponse.clone());
            }

            return networkResponse;
        } catch {
            return cachedResponse || Response.error();
        }
    })());
});
