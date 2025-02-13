<?php
session_start();

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p style='text-align:center; font-size:18px; margin-top:50px;'>
            Your cart is empty. <a href='shop.php'>Return to shop</a>
          </p>";
    exit;
}

// Handle item quantity reduction
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'], $_POST['product_id'], $_POST['remove_quantity'])) {
    $product_id = htmlspecialchars($_POST['product_id']);
    $remove_quantity = (int)$_POST['remove_quantity'];

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            if ($item['quantity'] <= $remove_quantity) {
                unset($_SESSION['cart'][$key]); // Remove the entire item if quantity is 0
            } else {
                $_SESSION['cart'][$key]['quantity'] -= $remove_quantity;
            }
            break;
        }
    }

    // If cart is empty after removal, destroy session cart
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
    }

    header("Location: cart.php");
    exit;
}

// Handle full item removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'], $_POST['product_id'])) {
    $product_id = htmlspecialchars($_POST['product_id']);

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $product_id) {
            unset($_SESSION['cart'][$key]); // Completely remove item from cart
            break;
        }
    }

    // If cart is empty after removal, destroy session cart
    if (empty($_SESSION['cart'])) {
        unset($_SESSION['cart']);
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
    <title>Your Cart - Bakery</title>
    <link rel="stylesheet" href="cart.css">
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="shop.php">Shop</a>
        <a href="aboutus.php">About Us</a>
        <a href="contactus.php">Contact Us</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Cart Container -->
    <div class="cart-container">
        <h2>Your Cart</h2>
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $total_price = 0; ?>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>₹<?= number_format($item['price'], 2) ?></td>
                        <td><?= (int) $item['quantity'] ?></td>
                        <td>₹<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        <td>
                            <!-- Remove Quantity Form -->
                            <form action="cart.php" method="POST" style="display:inline;" onsubmit="return confirm('Reduce quantity?');">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['id']) ?>">
                                <select name="remove_quantity" required>
                                    <?php for ($i = 1; $i <= $item['quantity']; $i++): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                                <button type="submit" name="remove" class="btn remove-btn">Reduce</button>
                            </form>

                            <!-- Full Remove Form -->
                            <form action="cart.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to remove this item completely?');">
                                <input type="hidden" name="product_id" value="<?= htmlspecialchars($item['id']) ?>">
                                <button type="submit" name="remove_item" class="btn delete-btn">Remove Item</button>
                            </form>
                        </td>
                    </tr>
                    <?php $total_price += $item['price'] * $item['quantity']; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Grand Total -->
        <p class="total">Grand Total: <strong>₹<?= number_format($total_price, 2) ?></strong></p>

        <!-- Actions -->
        <div class="actions">
            <a href="shop.php" class="btn">Return to Shop</a>
            <a href="checkout.php" class="btn checkout-btn">Proceed to Checkout</a>
        </div>
    </div>
</body>
</html>
