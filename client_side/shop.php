<?php
include 'db.php';
session_start();

// Initialize the cart session if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "root@123";
$dbname = "register";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Handle adding items to the cart
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $item_name = filter_input(INPUT_POST, 'item_name', FILTER_SANITIZE_STRING);
    $item_price = filter_input(INPUT_POST, 'item_price', FILTER_VALIDATE_FLOAT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);

    if ($item_name && $item_price && $quantity && $quantity > 0) {
        // Check if item already exists in the session cart
        $found = false;
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['name'] === $item_name) {
                $cart_item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = [
                'name' => $item_name,
                'quantity' => $quantity,
                'price' => $item_price,
            ];
        }

        // Store item in the database
        $stmt = $conn->prepare("INSERT INTO cart (name, quantity, price) VALUES (?, ?, ?) 
                                ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
        $stmt->bind_param("sdi", $item_name, $quantity, $item_price);

        if (!$stmt->execute()) {
            die("Error adding item to database: " . $stmt->error);
        }
        $stmt->close();

        // Redirect to avoid form resubmission issues
        header("Location: shop.php");
        exit();
    } else {
        die("Invalid item details.");
    }
}

// Fetch items from the database
$sql = "SELECT name, price, category FROM items";
$result = $conn->query($sql);

$items_by_category = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items_by_category[$row['category']][] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="shop.css">
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

<div class="shop-container">
    <h1>Welcome to Our Bakery Shop!</h1>
    <p>Select your favorite items and add them to your cart.</p>

    <?php foreach ($items_by_category as $category => $items): ?>
        <h2><?= htmlspecialchars($category) ?></h2>
        <table>
            <tr><th>Item</th><th>Price</th><th>Quantity</th></tr>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['name']) ?></td>
                <td>₹ <?= htmlspecialchars($item['price']) ?> per piece</td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="item_name" value="<?= htmlspecialchars($item['name']) ?>">
                        <input type="hidden" name="item_price" value="<?= htmlspecialchars($item['price']) ?>">
                        <input type="number" name="quantity" value="1" min="1" required>
                        <button type="submit">Add to Cart</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endforeach; ?>

    <a href="cart.php" class="view-cart-btn">View Cart</a>
</div>

</body>
</html>
