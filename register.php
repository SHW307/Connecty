<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "connectyfy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah email atau username sudah terdaftar
    $emailCheckQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($emailCheckQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultEmail = $stmt->get_result();

    $usernameCheckQuery = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($usernameCheckQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $resultUsername = $stmt->get_result();

    if ($resultEmail->num_rows > 0) {
        $error = "Email sudah terdaftar.";
    } elseif ($resultUsername->num_rows > 0) {
        $error = "Username sudah terdaftar.";
    } else {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO users (firstname, lastname, email, username, password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssss", $firstname, $lastname, $email, $username, $passwordHash);
        $stmt->execute();

        echo "<script>
            alert('Registrasi berhasil! Anda akan diarahkan ke halaman login.');
            window.location.href = 'login.php';
        </script>";
        exit();
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Connecty</title>
    <link rel="stylesheet" href="css/logres.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="register-wrapper">
        <div class="register-container">
            <h2>Create Your Account</h2>
            <form method="POST">
                <div class="input-group">
                    <input type="text" name="firstname" placeholder="Firstname" required>
                </div>
                <div class="input-group">
                    <input type="text" name="lastname" placeholder="Lastname" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="input-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" name="register">Sign Up</button>
            </form>
            <div class="error-message"><?php if (isset($error)) echo $error; ?></div>
            <div class="login-link">
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>

</html>