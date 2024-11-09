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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $usernameOrEmail = $_POST['username_or_email'];
    $password = $_POST['password'];

    $loginQuery = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($loginQuery);
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            echo "<script>
                window.location.href = 'index.php';
            </script>";
            exit();
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username atau Email tidak ditemukan.";
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
    <title>Login | Connecty</title>
    <link rel="stylesheet" href="css/logres.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-wrapper">
        <div class="login-container">
            <h2>Login to Connecty</h2>
            <form method="POST">
                <div class="input-group">
                    <input type="text" name="username_or_email" placeholder="Username or Email" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" name="login">Login</button>
            </form>
            <div class="error-message"><?php if (isset($error)) echo $error; ?></div>
            <div class="register-link">
                <p>Don't have an account? <a href="register.php">Sign Up</a></p>
            </div>
        </div>
    </div>
</body>

</html>