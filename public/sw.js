self.addEventListener('install', (event) => {
    event.waitUntil(caches.open('gk-floor-v1').then((cache) => cache.addAll(['/floor'])));
});

self.addEventListener('fetch', (event) => {
    event.respondWith(caches.match(event.request).then((cached) => cached || fetch(event.request)));
});
