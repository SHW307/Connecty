let micOn = false;
let cameraOn = false;
let screenSharing = false;
let mediaStream;
let screenStream;
let mediaRecorder;

const videoElement = document.getElementById("videoElement");

async function toggleMicrophone() {
  if (micOn) {
    // Matikan mikrofon
    const tracks = mediaStream.getTracks();
    tracks.forEach((track) => {
      if (track.kind === "audio") {
        track.enabled = false;
      }
    });
    document.getElementById("micButton").textContent = "🔇 Mikrofon";
  } else {
    // Aktifkan mikrofon
    try {
      mediaStream = await navigator.mediaDevices.getUserMedia({
        video: false,
        audio: true,
      });
      videoElement.srcObject = mediaStream;
      document.getElementById("micButton").textContent = "🔊 Mikrofon Aktif";
    } catch (err) {
      alert("Tidak dapat mengakses mikrofon: " + err);
    }
  }
  micOn = !micOn;
}

async function toggleCamera() {
  if (cameraOn) {
    // Matikan kamera
    const tracks = mediaStream.getTracks();
    tracks.forEach((track) => {
      if (track.kind === "video") {
        track.stop();
      }
    });
    document.getElementById("cameraButton").textContent = "📷 Kamera";
  } else {
    // Aktifkan kamera
    try {
      mediaStream = await navigator.mediaDevices.getUserMedia({
        video: true,
        audio: true,
      });
      videoElement.srcObject = mediaStream;
      document.getElementById("cameraButton").textContent = "🎥 Kamera Aktif";
    } catch (err) {
      alert("Tidak dapat mengakses kamera: " + err);
    }
  }
  cameraOn = !cameraOn;
}

async function toggleScreenShare() {
  if (screenSharing) {
    // Berhenti share screen
    if (screenStream) {
      const tracks = screenStream.getTracks();
      tracks.forEach((track) => track.stop());
      document.getElementById("screenShareButton").textContent =
        "📺 Share Screen";
    }
  } else {
    // Mulai share screen
    try {
      screenStream = await navigator.mediaDevices.getDisplayMedia({
        video: true,
      });
      videoElement.srcObject = screenStream;
      document.getElementById("screenShareButton").textContent =
        "🔴 Berhenti Share Screen";
    } catch (err) {
      alert("Tidak dapat mengakses layar: " + err);
    }
  }
  screenSharing = !screenSharing;
}

function showParticipants() {
  alert("Fitur Partisipan akan muncul di sini.");
}

function toggleChat() {
  const chatArea = document.getElementById("chatArea");
  chatArea.style.display = chatArea.style.display === "none" ? "block" : "none";
}

function sendMessage(event) {
  if (event.key === "Enter") {
    const chatInput = document.getElementById("chatInput");
    const message = chatInput.value;
    if (message) {
      const chatMessages = document.getElementById("chatMessages");
      const messageElement = document.createElement("div");
      messageElement.classList.add("message");
      messageElement.textContent = message;
      chatMessages.appendChild(messageElement);
      chatInput.value = "";
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }
  }
}
