// lib/echo.js
import Echo from "laravel-echo";
import Pusher from "pusher-js";

// Singleton instance
let echoInstance = null;

export function getEcho() {
  if (typeof window === "undefined") {
    // Return null or a mock object during SSR
    return null;
  }

  if (!echoInstance) {
    // Assign Pusher to window and initialize Echo
    window.Pusher = Pusher;

    echoInstance = new Echo({
      broadcaster: "reverb",
      key: process.env.NEXT_PUBLIC_REVERB_APP_KEY,
      wsHost: 'localhost',
      wsPort: process.env.NEXT_PUBLIC_REVERB_PORT || 8081,
      wssPort: process.env.NEXT_PUBLIC_REVERB_PORT || 8081,
      forceTLS: process.env.NEXT_PUBLIC_REVERB_SCHEME === "https",
      enabledTransports: ["ws"],
      disableStats: true,
    });
  }

  return echoInstance;
}