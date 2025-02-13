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
        // Add item to the session cart
        $_SESSION['cart'][] = [
            'name' => $item_name,
            'quantity' => $quantity,
            'price' => $item_price,
        ];

        // Store item in the database
        $stmt = $conn->prepare("INSERT INTO cart (name, quantity, price) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $item_name, $quantity, $item_price);

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

// Close connection
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
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact Us</a>
    <a href="logout.php">Logout</a>
</div>

<div class="shop-container">
    <h1>Welcome to Our Bakery Shop!</h1>
    <p>Select your favorite items and add them to your cart.</p>

    <!-- Cakes Section -->
    <h2>Cakes</h2>
    <table>
        <tr><th>Item</th><th>Price</th><th>Quantity</th></tr>
        <?php
        $cakes = [
            ["Gulab Jamun Cake", 120],
            ["Rava Kesari Cake", 100],
            ["Milk Cake", 150],
            ["Mango Cake", 130],
            ["Chocolate Cake", 110]
        ];
        foreach ($cakes as $cake): ?>
        <tr>
            <td><?= htmlspecialchars($cake[0]) ?></td>
            <td>₹ <?= htmlspecialchars($cake[1]) ?> per slice</td>
            <td>
                <form method="POST">
                    <input type="hidden" name="item_name" value="<?= htmlspecialchars($cake[0]) ?>">
                    <input type="hidden" name="item_price" value="<?= htmlspecialchars($cake[1]) ?>">
                    <input type="number" name="quantity" value="1" min="1" required>
                    <button type="submit">Add to Cart</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Sweets Section -->
    <h2>Sweets & Desserts</h2>
    <table>
        <tr><th>Item</th><th>Price</th><th>Quantity</th></tr>
        <?php
        $sweets = [
            ["Gulab Jamun", 40],
            ["Jalebi", 50],
            ["Barfi (Pistachio, Coconut, Rose)", 60],
            ["Rasgulla", 30],
            ["Kaju Katli", 80]
        ];
        foreach ($sweets as $sweet): ?>
        <tr>
            <td><?= htmlspecialchars($sweet[0]) ?></td>
            <td>₹ <?= htmlspecialchars($sweet[1]) ?> per piece</td>
            <td>
                <form method="POST">
                    <input type="hidden" name="item_name" value="<?= htmlspecialchars($sweet[0]) ?>">
                    <input type="hidden" name="item_price" value="<?= htmlspecialchars($sweet[1]) ?>">
                    <input type="number" name="quantity" value="1" min="1" required>
                    <button type="submit">Add to Cart</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <!-- Cookies Section -->
    <h2>Cookies & Biscuits</h2>
    <table>
        <tr><th>Item</th><th>Price</th><th>Quantity</th></tr>
        <?php
        $cookies = [
            ["Chocolate Chip Cookies", 25],
            ["Coconut Cookies", 20],
            ["Butter Biscuits", 20],
            ["Peanut Butter Cookies", 30],
            ["Oatmeal Raisin Cookies", 20]
        ];
        foreach ($cookies as $cookie): ?>
        <tr>
            <td><?= htmlspecialchars($cookie[0]) ?></td>
            <td>₹ <?= htmlspecialchars($cookie[1]) ?> per piece</td>
            <td>
                <form method="POST">
                    <input type="hidden" name="item_name" value="<?= htmlspecialchars($cookie[0]) ?>">
                    <input type="hidden" name="item_price" value="<?= htmlspecialchars($cookie[1]) ?>">
                    <input type="number" name="quantity" value="1" min="1" required>
                    <button type="submit">Add to Cart</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <a href="cart.php" class="view-cart-btn">View Cart</a>
</div>
</body>
</html>
