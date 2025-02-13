<?php
include 'db.php';
session_start(); // Start the session

// Redirect if already logged in
if (isset($_SESSION['username'])) {
    header("Location: home.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "root@123";
$dbname = "register";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error message
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input to prevent XSS
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Use prepared statements to prevent SQL Injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verify user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
                
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id']; // Store user ID for better tracking
                header("Location: home.php");
                exit();
            } else {
                $error = "Invalid credentials. Please try again.";
            }
        } else {
            $error = "No user found with this username.";
        }
        $stmt->close();
    } else {
        $error = "Both fields are required.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
