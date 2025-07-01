self.addEventListener('push', event => {
    const data = event.data.json();

    const audio = new Audio('/sons/notification.mp3');
    audio.play(); // ne fonctionnera que si le navigateur autorise le son

    const options = {
        body: data.body,
        icon: data.icon,
        badge: data.badge,
        data: { url: data.url }
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();
    event.waitUntil(clients.openWindow(event.notification.data.url));
});
