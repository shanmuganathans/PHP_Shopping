<?php
session_start();

if (!isset($_SESSION["loggedInUser"])) {
    header("Location: login.php");
    exit();
}

$admin_username = htmlspecialchars($_SESSION["loggedInUser"], ENT_QUOTES, 'UTF-8'); // Prevents XSS attacks

// Database connection
$host = 'localhost';
$username = 'root';
$password = 'root@123';
$database = 'register';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// If you need to fetch data, you can do so here

$conn->close();
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
        <p>You are logged in as: <strong><?php echo $admin_username; ?></strong></p>

        <!-- Navigation links -->
        <nav class="admin-nav">
            <a href="view_orders.php">View Orders</a>
            <a href="profit.php">Profit Report</a>
            <a href="manage_users.php">Manage Users</a>
            <a href="view_messages.php">View Messages</a>
            <a href="view_feedbacks.php">View Feedbacks</a>
            <a href="menu.php">View Menus</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </nav>
    </div>
</body>
</html>
