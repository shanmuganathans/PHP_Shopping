<?php
session_start();
// Database connection
$host = 'localhost';
$username = 'root';
$password = 'root@123';
$database = 'register';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// If you need to fetch data, you can do so here


// Redirect if not logged in
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    
    // Image Upload
    $target_dir = "uploads/";
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Insert data
    $stmt = $conn->prepare("INSERT INTO items (name, price, category, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $category, $image_name);
    $stmt->execute();
    
    header("Location: menu.php");
    exit();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link rel="stylesheet" href="add_item.css">
</head>
<body>
    <div class="container">
        <h2>Add New Item</h2>
        <form action="add_item.php" method="POST" enctype="multipart/form-data">
            <label>Name:</label>
            <input type="text" name="name" required>
            
            <label>Price (₹):</label>
            <input type="number" name="price" step="0.01" required>
            
            <label>Category:</label>
            <select name="category" required>
                <option value="Cake">Cake</option>
                <option value="Sweets">Sweets</option>
                <option value="Cookies & Biscuits">Cookies & Biscuits</option>
            </select>
            
            <label>Upload Image:</label>
            <input type="file" name="image" accept="image/*" required>

            <button type="submit">Add Item</button>
        </form>
        <a href="menu.php" class="back-btn">Back to Menu</a>
    </div>
</body>
</html>
