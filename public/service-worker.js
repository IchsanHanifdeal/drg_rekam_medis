self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open('sioner-cache-v1').then((cache) => {
            return cache.addAll([
                '/',
                '/manifest.json',
                '/favicon.ico',
                '/css/app.css',
                '/js/app.js'
            ]);
        })
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        })
    );
});
