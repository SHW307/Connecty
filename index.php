<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connecty</title>
    <link rel="stylesheet" href="css/css.css">
</head>

<body>

    <!-- Navbar -->
    <div class="nav">
        <div class="nav-logo">Connecty</div>
        <div class="date" id="currentDate"></div>

        <?php if (!isset($_SESSION['username'])): ?>
            <!-- Jika belum login -->
            <div class="nav-buttons">
                <a href="login.php" class="nav-btn">Login</a>
                <a href="register.php" class="nav-btn">Register</a>
            </div>
        <?php else: ?>
            <!-- Jika sudah login -->
            <div class="nav-profile">
                <button class="nav-btn dropdown-btn"><?php echo $_SESSION['username']; ?> ▼</button>
                <div class="dropdown-content">
                    <a href="logout.php">Logout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Konten -->
    <div class="content">
        <div class="text">
            <h2>Rapat panggilan video untuk semua orang</h2>
            <h4>Terhubung dengan siapa saja</h4>
        </div>
        <div class="btrapat">
            <button onclick="mulairapat()" class="btnmulai" id="btn-rapat">Mulai Rapat</button>
        </div>
        <div class="btngabung">
            <input type="text" placeholder="Masukkan Kode">
            <button onclick="gabungrapat()" class="btngabung" id="btn-gabung">Gabung</button>
        </div>
    </div>

    <script>
        const dateElement = document.getElementById("currentDate");
        const options = {
            year: "numeric",
            month: "long",
            day: "numeric"
        };
        dateElement.textContent = new Date().toLocaleDateString("id-ID", options);
    </script>

    <script src="js/js.js"></script>
</body>

</html>