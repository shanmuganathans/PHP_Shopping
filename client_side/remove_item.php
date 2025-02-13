<?php
// Database configuration
$servername = "localhost"; // Change if your database server is different
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "register"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the remove request is made
if (isset($_POST['remove'])) {
    $itemId = intval($_POST['item_id']); // Get the item ID from POST data

    // Prepare and execute a query to get current quantity
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE id = ?");
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentQuantity = intval($row['quantity']);

        if ($currentQuantity > 1) {
            // Decrease quantity by 1
            $newQuantity = $currentQuantity - 1;
            $updateStmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
            $updateStmt->bind_param("ii", $newQuantity, $itemId);
            if ($updateStmt->execute()) {
                header("Location: cart.php?message=Item quantity decreased.");
                exit; // Ensure no further code is executed after redirection
            } else {
                echo "Error updating quantity: " . $updateStmt->error;
            }
            $updateStmt->close();
        } else {
            // Remove item from cart if quantity is 1
            $deleteStmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
            $deleteStmt->bind_param("i", $itemId);
            if ($deleteStmt->execute()) {
                header("Location: remove_success.php?message=Item removed from cart.");
                exit; // Ensure no further code is executed after redirection
            } else {
                echo "Error removing item: " . $deleteStmt->error;
            }
            $deleteStmt->close();
        }
    } else {
        echo "Item not found.";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Removed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #45a049; /* Darker green */
        }
    </style>
</head>
<body>

<h1>Item Removed Successfully!</h1>
<p>Your item has been removed from the cart.</p>

<a href="cart.php" class="button">Return to Cart</a>

</body>
</html>
