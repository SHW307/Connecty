function login() {
  // Cek status login di localStorage
  if (localStorage.getItem("loginStatus") === "success") {
    // Redirect ke halaman index.html
    window.location.href = "index.html";
  } else {
    // Jika tidak login, tampilkan pesan error atau lakukan proses login lainnya
    alert("Login failed or not successful!");
  }
}
