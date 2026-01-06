/**
 * Afrisol Service Worker
 * Enables PWA functionality with offline support
 */

const CACHE_NAME = 'afrisol-v1';
const OFFLINE_URL = '/offline.html';

const urlsToCache = [
    '/',
    '/products',
    '/services',
    '/contact',
    '/offline.html'
];

// Install event - cache essential resources
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                return cache.addAll(urlsToCache);
            })
            .catch(() => {
                // Silently handle cache failures
            })
    );
    self.skipWaiting();
});

// Activate event - clean up old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cacheName) => {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    self.clients.claim();
});

// Fetch event - serve from cache, fallback to network
self.addEventListener('fetch', (event) => {
    // Skip cross-origin requests
    if (!event.request.url.startsWith(self.location.origin)) {
        return;
    }

    // Skip POST requests
    if (event.request.method !== 'GET') {
        return;
    }

    event.respondWith(
        caches.match(event.request)
            .then((response) => {
                if (response) {
                    return response;
                }

                return fetch(event.request)
                    .then((response) => {
                        // Don't cache non-successful responses
                        if (!response || response.status !== 200 || response.type !== 'basic') {
                            return response;
                        }

                        // Clone the response
                        const responseToCache = response.clone();

                        // Cache static assets
                        if (
                            event.request.url.includes('/assets/') ||
                            event.request.url.includes('.css') ||
                            event.request.url.includes('.js') ||
                            event.request.url.includes('.png') ||
                            event.request.url.includes('.jpg') ||
                            event.request.url.includes('.webp')
                        ) {
                            caches.open(CACHE_NAME)
                                .then((cache) => {
                                    cache.put(event.request, responseToCache);
                                });
                        }

                        return response;
                    })
                    .catch(() => {
                        // Return offline page for navigation requests
                        if (event.request.mode === 'navigate') {
                            return caches.match(OFFLINE_URL);
                        }
                    });
            })
    );
});

// Background sync for cart operations
self.addEventListener('sync', (event) => {
    if (event.tag === 'sync-cart') {
        event.waitUntil(syncCart());
    }
});

async function syncCart() {
    // Sync cart data when back online
    const pendingOperations = await getIndexedDBData('pending-operations');
    
    for (const operation of pendingOperations) {
        try {
            await fetch(operation.url, {
                method: operation.method,
                body: JSON.stringify(operation.data),
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            await removeIndexedDBData('pending-operations', operation.id);
        } catch (error) {
            // Silently handle sync failures
        }
    }
}

// Push notifications
self.addEventListener('push', (event) => {
    const options = {
        body: event.data ? event.data.text() : 'New notification from Afrisol',
        icon: '/wp-content/plugins/afrisol-plugin/assets/images/logo-192.png',
        badge: '/wp-content/plugins/afrisol-plugin/assets/images/logo-72.png',
        vibrate: [100, 50, 100],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1
        },
        actions: [
            {
                action: 'view',
                title: 'View',
                icon: '/wp-content/plugins/afrisol-plugin/assets/images/icon-view.png'
            },
            {
                action: 'close',
                title: 'Close',
                icon: '/wp-content/plugins/afrisol-plugin/assets/images/icon-close.png'
            }
        ]
    };

    event.waitUntil(
        self.registration.showNotification('Afrisol', options)
    );
});

// Handle notification click
self.addEventListener('notificationclick', (event) => {
    event.notification.close();

    if (event.action === 'view') {
        event.waitUntil(
            clients.openWindow('/')
        );
    }
});

// Helper functions for IndexedDB
function getIndexedDBData(storeName) {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open('afrisol-db', 1);
        
        request.onsuccess = () => {
            const db = request.result;
            const transaction = db.transaction(storeName, 'readonly');
            const store = transaction.objectStore(storeName);
            const getAllRequest = store.getAll();
            
            getAllRequest.onsuccess = () => resolve(getAllRequest.result || []);
            getAllRequest.onerror = () => reject(getAllRequest.error);
        };
        
        request.onerror = () => reject(request.error);
    });
}

function removeIndexedDBData(storeName, key) {
    return new Promise((resolve, reject) => {
        const request = indexedDB.open('afrisol-db', 1);
        
        request.onsuccess = () => {
            const db = request.result;
            const transaction = db.transaction(storeName, 'readwrite');
            const store = transaction.objectStore(storeName);
            const deleteRequest = store.delete(key);
            
            deleteRequest.onsuccess = () => resolve();
            deleteRequest.onerror = () => reject(deleteRequest.error);
        };
        
        request.onerror = () => reject(request.error);
    });
}
