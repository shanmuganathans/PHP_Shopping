<?php
include 'db.php';
session_start();

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

// Ensure the cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='shop.php'>Return to shop</a></p>";
    exit;
}

$order_placed = false;
$error_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['customer_name']) && !empty($_POST['email']) && !empty($_POST['address']) && !empty($_POST['phone'])) {
        
        // Sanitize user input
        $customer_name = trim($_POST['customer_name']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ? $_POST['email'] : "";
        $phone = trim($_POST['phone']);
        $address = trim($_POST['address']);

        if (empty($email)) {
            $error_message = "Invalid email address.";
        } else {
            // Calculate total price
            $total_price = 0;
            foreach ($_SESSION['cart'] as $item) {
                $total_price += $item['price'] * $item['quantity'];
            }

            // Insert order using prepared statement
            $stmt = $conn->prepare("INSERT INTO orders (customer_name, email, phone, address, total_amount, order_date) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssssd", $customer_name, $email, $phone, $address, $total_price);

            if ($stmt->execute()) {
                $order_placed = true;
                $_SESSION['cart'] = []; // Clear cart after successful order
            } else {
                $error_message = "Error placing order: " . $stmt->error;
            }

            $stmt->close();
        }
    } else {
        $error_message = "Please fill in all required fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Bakery</title>
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="shop.php">Shop</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact Us</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="checkout-container">
        <h2>Checkout</h2>

        <?php if ($order_placed): ?>
            <p class="success">Order placed successfully! 🎉</p>
            <a href="shop.php" class="btn">Continue Shopping</a>
        <?php else: ?>
            <?php if (!empty($error_message)): ?>
                <p class="error"><?= htmlspecialchars($error_message) ?></p>
            <?php endif; ?>

            <h3>Your Order</h3>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total_price = 0; ?>
                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>₹ <?= number_format($item['price'], 2) ?></td>
                            <td><?= htmlspecialchars($item['quantity']) ?></td>
                            <td>₹ <?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                        <?php $total_price += $item['price'] * $item['quantity']; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="total">Grand Total: ₹ <?= number_format($total_price, 2) ?></p>

            <h3>Shipping Information</h3>
            <form action="checkout.php" method="POST">
                <label for="customer_name">Name:</label>
                <input type="text" id="customer_name" name="customer_name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required>

                <label for="address">Address:</label>
                <textarea id="address" name="address" required></textarea>

                <div class="form-actions">
                    <a href="cart.php" class="btn">Return to Cart</a>
                    <button type="submit" class="btn checkout-btn">Place Order</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
