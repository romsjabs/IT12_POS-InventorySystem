function updateDateTime() {
    const now = new Date();

    const day = now.toLocaleDateString('en-US', { weekday: 'short' }); // "Wed"
    const date = now.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }); // "April 9, 2025"
    const time = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true }); // "12:00 PM"

    document.getElementById("current-date").textContent = `${date} (${day})`;
    document.getElementById("current-time").textContent = time;
  }

  setInterval(updateDateTime, 1000);
  updateDateTime();