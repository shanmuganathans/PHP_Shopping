<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root@123";
$db_name = "register";

$conn = new mysqli($servername, $username, $password, $db_name);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if order_id is passed
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    echo "<p>Invalid order.</p>";
    exit();
}

$order_id = intval($_GET['order_id']);

// Fetch order details
$order_stmt = $conn->prepare("SELECT customer_name, email, phone, address, total_amount, order_date FROM orders WHERE id = ?");
$order_stmt->bind_param("i", $order_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
$order = $order_result->fetch_assoc();

if (!$order) {
    echo "<p>Order not found.</p>";
    exit();
}

// Fetch order items
$item_stmt = $conn->prepare("SELECT item_name, quantity, item_price, total_price FROM order_items WHERE order_id = ?");
$item_stmt->bind_param("i", $order_id);
$item_stmt->execute();
$item_result = $item_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link rel="stylesheet" href="view_order_details.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Order Details</h1>

        <h3>Order Information</h3>
        <table class="order-info">
            <tr>
                <th>Name:</th>
                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?php echo htmlspecialchars($order['email']); ?></td>
            </tr>
            <tr>
                <th>Phone:</th>
                <td><?php echo htmlspecialchars($order['phone']); ?></td>
            </tr>
            <tr>
                <th>Address:</th>
                <td><?php echo htmlspecialchars($order['address']); ?></td>
            </tr>
            <tr>
                <th>Total Amount:</th>
                <td>₹ <?php echo number_format($order['total_amount'], 2); ?></td>
            </tr>
            <tr>
                <th>Order Date:</th>
                <td><?php echo date("Y-m-d H:i:s", strtotime($order['order_date'])); ?></td>
            </tr>
        </table>

        <h3>Ordered Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Item Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $item_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['item_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td>₹ <?php echo number_format($item['item_price'], 2); ?></td>
                        <td>₹ <?php echo number_format($item['total_price'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="view_orders.php" class="back-btn">Back to Orders</a>
    </div>

    <?php
    // Close database connection
    $order_stmt->close();
    $item_stmt->close();
    $conn->close();
    ?>
</body>
</html>
