importScripts('https://www.gstatic.com/firebasejs/7.2.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.2.1/firebase-messaging.js');
// For an optimal experience using Cloud Messaging, also add the Firebase SDK for Analytics.
importScripts('https://www.gstatic.com/firebasejs/7.2.1/firebase-analytics.js');

// Initialize the Firebase app in the service worker by passing in the
// messagingSenderId.
firebase.initializeApp({
  'messagingSenderId': '75902901199'
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
    const notification = JSON.parse(payload.data.notification);
  // Customize notification here
  const notificationTitle = notification.title;
  const notificationOptions = {
        body: notification.body,
        icon: notification.icon,
          data: {
              click_action: notification.click_action
        }
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);

});

self.addEventListener('notificationclick', event => {
    event.waitUntil(async function() {
        const allClients = await clients.matchAll({
            includeUncontrolled: true
        });
        for (const client of allClients) {
            const url = new URL(client.url);
            console.log(url);
            console.log(event.notification.data.click_action);
            if (url.origin == event.notification.data.click_action) {
                // Excellent, let's use it!
                return client.focus();
            }
        }
        if (clients.openWindow) {

            return clients.openWindow(event.notification.data.click_action);
        }
    }());
});
