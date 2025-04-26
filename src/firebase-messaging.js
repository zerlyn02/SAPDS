import { initializeApp } from "firebase/app";
import { getMessaging, getToken, onMessage } from "firebase/messaging";

// Your Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyDFRWNQCDmNxtKohMebv-QFE402KYVSt7A",
  authDomain: "sapds-b3da3.firebaseapp.com",
  projectId: "sapds-b3da3",
  storageBucket: "sapds-b3da3.firebasestorage.app",
  messagingSenderId: "60404615160",
  appId: "1:60404615160:web:a42ef3ff2696c5fa64b80d",
  measurementId: "G-M22GVXKKVD"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// Request Permission for Notifications
async function requestPermission() {
  try {
    await Notification.requestPermission();
    if (Notification.permission === "granted") {
      console.log("Notification permission granted.");
      const token = await getToken(messaging, { vapidKey: "YOUR_VAPID_KEY" });
      console.log("FCM Token:", token);  // Send this token to your server to store
    } else {
      console.log("Notification permission denied.");
    }
  } catch (error) {
    console.error("Error getting permission:", error);
  }
}

// Listen for incoming messages while the app is in the foreground
onMessage(messaging, (payload) => {
  console.log("Message received: ", payload);
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: payload.notification.icon,
  };
  new Notification(notificationTitle, notificationOptions);
});

// Call the requestPermission function to prompt for notifications
requestPermission();
