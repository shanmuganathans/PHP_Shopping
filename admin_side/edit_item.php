<?php
session_start();
// Database connection
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}

// Get item details
$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image_name = $item['image'];

    // If new image is uploaded
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "uploads/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    }

    // Update query
    $stmt = $conn->prepare("UPDATE items SET name = ?, price = ?, category = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sdssi", $name, $price, $category, $image_name, $id);
    $stmt->execute();

    header("Location: menu.php");
    exit();
}
// If you need to fetch data, you can do so here
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
    <link rel="stylesheet" href="edit_item.css">
</head>
<body>
    <div class="container">
        <h2>Edit Item</h2>
        <form action="edit_item.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($item['name']) ?>" required>
            
            <label>Price (₹):</label>
            <input type="number" name="price" step="0.01" value="<?= $item['price'] ?>" required>
            
            <label>Category:</label>
            <select name="category" required>
                <option value="Cake" <?= ($item['category'] == "Cake") ? "selected" : "" ?>>Cake</option>
                <option value="Sweets" <?= ($item['category'] == "Sweets") ? "selected" : "" ?>>Sweets</option>
                <option value="Cookies & Biscuits" <?= ($item['category'] == "Cookies & Biscuits") ? "selected" : "" ?>>Cookies & Biscuits</option>
            </select>
            
            <label>Current Image:</label>
            <img src="uploads/<?= $item['image'] ?>" width="100">
            
            <label>Upload New Image (optional):</label>
            <input type="file" name="image" accept="image/*">

            <button type="submit">Update Item</button>
        </form>
        <a href="menu.php" class="back-btn">Back to Menu</a>
    </div>
</body>
</html>
