const CACHE_NAME = 'reservas-cancha-v1';
const STATIC_ASSETS = [
    '/manifest.json',
    '/css/styles.css',
    '/pwa/icons/android/launchericon-192x192.png',
    '/pwa/icons/android/launchericon-512x512.png',
    '/pwa/icons/android/launchericon-144x144.png',
    '/pwa/icons/android/launchericon-96x96.png',
    '/pwa/icons/android/launchericon-72x72.png',
    '/pwa/icons/android/launchericon-48x48.png',
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            return cache.addAll(STATIC_ASSETS);
        })
    );
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys => {
            return Promise.all(
                keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
            );
        })
    );
    self.clients.claim();
});

self.addEventListener('fetch', event => {
    if (event.request.method !== 'GET') return;

    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request)
                .then(response => {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request, clone);
                    });
                    return response;
                })
                .catch(() => {
                    return caches.match(event.request).then(cached => {
                        return cached || Response.error();
                    });
                })
        );
        return;
    }

    event.respondWith(
        caches.match(event.request).then(cached => {
            const fetchPromise = fetch(event.request)
                .then(response => {
                    if (response && response.status === 200) {
                        const clone = response.clone();
                        caches.open(CACHE_NAME).then(cache => {
                            cache.put(event.request, clone);
                        });
                    }
                    return response;
                })
                .catch(() => cached);

            return cached || fetchPromise;
        })
    );
});
