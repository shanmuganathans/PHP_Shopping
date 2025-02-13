<?php
session_start();

if (isset($_SESSION["loggedInUser"])) {
    header("Location: dashboard.php"); 
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "register";

$conn = new mysqli($servername, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error message variable
$error_message = "";

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_username = trim($_POST['username']);
    $admin_password = trim($_POST['password']);

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Corrected query string concatenation
        $userCheck = mysqli_query($conn, "SELECT * FROM admin_users WHERE username='$username' AND password='$password'");
        
        if ($userCheck) {
            if (mysqli_num_rows($userCheck) > 0) {
                $_SESSION['loggedInUser'] = true;
                $_SESSION['show_message'] = 'Logged In Successfully';
                header('Location: dashboard.php');  //change 'admin_dashboard.php' to the name of your dashboard page
            } else {
                $_SESSION['show_message'] = 'Invalid Email or Password';
            }
        } else {
            $_SESSION['show_message'] = 'Something Went Wrong in Query';
        }
    } else {
        $_SESSION['show_message'] = 'All fields are required';
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

        <!-- Display error message --><!-- Admin Login Form -->
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
