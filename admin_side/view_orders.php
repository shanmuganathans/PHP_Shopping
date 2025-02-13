<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}

// Database Connection
$servername = "localhost";
$username = "root";
$password = "root@123";
$db_name = "register";

$conn = new mysqli($servername, $username, $password, $db_name);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all orders (Sorted by latest first)
$sql = "SELECT order_id, user_id, product_name, quantity, total_price, order_date, status FROM orders ORDER BY order_date DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>All Orders</h1>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Order Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td>$<?php echo number_format($row['total_price'], 2); ?></td>
                            <td><?php echo date("Y-m-d", strtotime($row['order_date'])); ?></td>
                            <td>
                                <?php echo htmlspecialchars(ucfirst($row['status'])); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>

    <?php 
    // Close database connection
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
