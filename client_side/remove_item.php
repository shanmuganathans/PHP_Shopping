<?php
include 'db.php';
// Database configuration
$servername = "localhost";
$username = "root";
$password = "root@123";
$dbname = "register";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the remove request is made via POST method
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['remove'])) {
    $itemId = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);

    if ($itemId === false || $itemId === null) {
        die("Invalid item ID.");
    }

    // Prepare statement to get current quantity
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE id = ?");
    $stmt->bind_param("i", $itemId);
    $stmt->execute();
    $stmt->store_result();

    // Check if item exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($currentQuantity);
        $stmt->fetch();
        $stmt->close();

        if ($currentQuantity > 1) {
            // Decrease quantity by 1
            $updateStmt = $conn->prepare("UPDATE cart SET quantity = quantity - 1 WHERE id = ?");
            $updateStmt->bind_param("i", $itemId);
            $success = $updateStmt->execute();
            $updateStmt->close();
        } else {
            // Remove item from cart if quantity is 1
            $deleteStmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
            $deleteStmt->bind_param("i", $itemId);
            $success = $deleteStmt->execute();
            $deleteStmt->close();
        }

        if ($success) {
            header("Location: cart.php?message=Item updated successfully.");
            exit();
        } else {
            die("Error updating item.");
        }
    } else {
        die("Item not found.");
    }
}

// Close the database connection
$conn->close();

// Redirect if accessed directly without POST request
header("Location: cart.php");
exit();
?>
