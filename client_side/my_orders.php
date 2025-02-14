<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Connect to database
include 'db.php';

// Check if email is set in session
if (!isset($_SESSION['loggedInUserEmail'])) {
    header("Location: login.php");
    exit();
}

// Get logged-in user email
$user_email = $_SESSION['loggedInUserEmail']; // Ensure this is set in login.php

// Fetch user orders in descending order
$stmt = $conn->prepare("SELECT * FROM orders WHERE email = ? ORDER BY order_date DESC");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
// Debugging: Check if orders exist
// if ($result->num_rows == 0) {
//     echo "<p style='color:red;'>No orders found for user: $user_email</p>";
// } else {
//     echo "<p style='color:green;'>Orders found for user: $user_email</p>";
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="my_orders.css">
</head>
<body>
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="shop.php">Shop</a>
        <a href="my_orders.php">My Orders</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact Us</a>
        <a href="logout.php">Logout</a>
    </div>

    <h2>My Orders</h2>
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Order Date</th>
                <th>Details</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td>₹ <?= number_format($row['total_amount'], 2) ?></td>
                    <td><?= htmlspecialchars($row['order_date']) ?></td>
                    <td><a href="view_order_details.php?order_id=<?= $row['id'] ?>">View</a></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>
</body>
</html>
<?php $stmt->close(); $conn->close(); ?>
