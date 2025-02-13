<?php
session_start();

// Initialize the cart session if not already done
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add items to the cart
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $quantity = $_POST['quantity'];

    // Add item to the cart session
    $_SESSION['cart'][] = [
        'name' => $item_name,
        'quantity' => $quantity,
        'price' => $item_price,
    ];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
	$item_name = $conn->real_escape_string($_POST['item']);
    $quantity = $conn->real_escape_string($_POST['quantity']);
    $price = $conn->real_escape_string($_POST['price']);


   $sql = "INSERT INTO cart (name, quantity, price)
            VALUES ('$item_name', '$quantity', '$price')";

    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

    // Redirect to shop page
    header("Location: shop.php");
    exit();
}
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

        <h2>Cakes</h2>
        <table>
            <tr><th>Item</th><th>Price</th><th>Quantity</th>
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
                <td><?= $cake[0] ?></td>
                <td>₹
                <?= $cake[1] ?> per slice</td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="item_name" value="<?= $cake[0] ?>">
                        <input type="hidden" name="item_price" value="<?= $cake[1] ?>">
                        <input type="number" name="quantity" value="1" min="1" required>
                        <button type="submit">Add to Cart</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h2>Sweets & Desserts</h2>
        <table>
            <tr><th>Item</th><th>Price</th><th>Quantity</th>
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
                <td><?= $sweet[0] ?></td>
                <td>₹
                <?= $sweet[1] ?> per piece</td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="item_name" value="<?= $sweet[0] ?>">
                        <input type="hidden" name="item_price" value="<?= $sweet[1] ?>">
                        <input type="number" name="quantity" value="1" min="1" required>
                        <button type="submit">Add to Cart</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h2>Cookies & Biscuits</h2>
        <table>
            <tr><th>Item</th><th>Price</th><th>Quantity</th>
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
                <td><?= $cookie[0] ?></td>
                <td>₹
                <?= $cookie[1] ?> per piece</td>
                <td>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="item_name" value="<?= $cookie[0] ?>">
                        <input type="hidden" name="item_price" value="<?= $cookie[1] ?>">
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
