<?php
// Mulai sesi
session_start();

// Hapus semua sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Arahkan ke halaman index.php setelah logout
header("Location: index.php");
exit();
