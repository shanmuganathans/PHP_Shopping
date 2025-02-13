<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Change to your database username
$password = "";     // Change to your database password
$dbname = "register";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $customer_name = $conn->real_escape_string($_POST['customer_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $total_amount = $conn->real_escape_string($_POST['total_amount']);

    // SQL query to insert data into the orders table
    $sql = "INSERT INTO orders (customer_name, email, phone, address, total_amount, order_date)
            VALUES ('$customer_name', '$email', '$phone', '$address', '$total_amount', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Order placed successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
        <?php if (isset($order_placed) && $order_placed): ?>
            <p class="success">Order placed successfully!</p>
            <a href="shop.php" class="btn">Continue Shopping</a>
        <?php else: ?>
            <?php if (isset($error_message)): ?>
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
                            <td>₹                              <?= htmlspecialchars($item['price']) ?></td>
                            <td><?= htmlspecialchars($item['quantity']) ?></td>
                            <td>₹                              <?= $item['price'] * $item['quantity'] ?></td>
                        </tr>
                        <?php $total_price += $item['price'] * $item['quantity']; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="total">Grand Total: ₹
            <?= $total_price ?></p>

            <h3>Shipping Information</h3>
            <form action="checkout.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="address">Address:</label>
                <textarea id="address" name="address" required></textarea>
                <div class="form-actions">
                    <a href="cart.php" class="btn">Return to Cart</a>
                    <button type="submit" class="btn">Place Order</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
