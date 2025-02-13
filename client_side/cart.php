<?php
session_start();

// Check if the cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='shop.php'>Return to shop</a></p>";
    exit;
}

// Handle item removal
if (isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    $remove_quantity = $_POST['remove_quantity'];

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            if ($item['quantity'] <= $remove_quantity) {
                unset($_SESSION['cart'][$key]);
            } else {
                $_SESSION['cart'][$key]['quantity'] -= $remove_quantity;
            }
            break;
        }
    }
    header("Location: cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Bakery</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="shop.php">Shop</a>
        <a href="aboutus.php">About Us</a>
        <a href="contactus.php">Contact Us</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="cart-container">
        <h2>Your Cart</h2>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $total_price = 0; ?>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>₹                          <?= htmlspecialchars($item['price']) ?></td>
                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                        <td>₹                          <?= $item['price'] * $item['quantity'] ?></td>
                        <td>
                            <form action="cart.php" method="POST">
                                <select name="remove_quantity" required>
                                    <?php for ($i = 1; $i <= $item['quantity']; $i++): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                     <a href="remove_item.php" class="btn checkout-btn"> remove</a>
                            </form>
                        </td>
                    </tr>
                    <?php $total_price += $item['price'] * $item['quantity']; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p class="total">Grand Total: ₹
        <?= $total_price ?></p>

        <div class="actions">
            <a href="shop.php" class="btn">Return to Shop</a>
            <a href="checkout.php" class="btn checkout-btn">Proceed to Checkout</a>
        </div>
    </div>
</body>
</html>
