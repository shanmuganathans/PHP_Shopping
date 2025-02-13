<?php
session_start();

if (isset($_SESSION["loggedInUser"])) {
    header("Location: dashboard.php"); 
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "root@123";
$db_name = "register";

$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Initialize error message variable
$error_message = "";

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = trim($_POST['username']);
    $admin_password = trim($_POST['password']);

    if (!empty($admin_username) && !empty($admin_password)) {
        // Secure Query with Prepared Statement
        $stmt = $conn->prepare("SELECT password FROM admin_users WHERE username = ?");
        $stmt->bind_param("s", $admin_username);
        $stmt->execute();
        $stmt->store_result();
        
        // Verify if the user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();

            // Verify hashed password
            if (password_verify($admin_password, $hashed_password)) {
                $_SESSION['loggedInUser'] = $admin_username;
                $_SESSION['show_message'] = 'Logged In Successfully';
                header('Location: dashboard.php');
                exit();
            } else {
                $error_message = "Invalid username or password.";
            }
        } else {
            $error_message = "Invalid username or password.";
        }
        $stmt->close();
    } else {
        $error_message = "All fields are required.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login-container">
        <h1>Admin Login</h1>

        <!-- Display error message -->
        <?php if (!empty($error_message)) : ?>
            <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <!-- Admin Login Form -->
        <form action="login.php" method="POST" class="login-form">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
