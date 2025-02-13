<?php
session_start();

if (!isset($_SESSION["loggedInUser"])) {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'register';

$conn = mysqli_connect('localhost', 'root', '', 'register');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome, Admin!</h1>
        <p>You are logged in as: <strong><?php echo htmlspecialchars($admin_username); ?></strong></p>

        <!-- Navigation links -->
        <nav class="admin-nav">
            <a href="view_orders.php">View Orders</a>
            <a href="manage_users.php">Manage Users</a>
            <a href="view_messages.php">View Messages</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </nav>
    </div>
</body>
</html>
