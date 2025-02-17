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
$sql = "SELECT id, customer_name, email, phone, address, total_amount, order_date FROM orders ORDER BY order_date DESC";
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
    <link rel="stylesheet" href="view_orders.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>All Orders</h1>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Total Amount</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['phone']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td>₹<?php echo number_format($row['total_amount'], 2); ?></td>
                            <td><?php echo date("Y-m-d H:i:s", strtotime($row['order_date'])); ?></td>
                            <td>
                                <a href="view_order_details.php?order_id=<?php echo $row['id']; ?>" class="details-btn">View Details</a>
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
    ?>
</body>
</html>
