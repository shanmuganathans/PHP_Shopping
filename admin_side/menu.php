<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include 'db.php';

// Handle Item Deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: menu.php");
    exit();
}

// Fetch Menu Items
$category_filter = isset($_GET['category']) ? $_GET['category'] : "";
$query = "SELECT * FROM items";
if ($category_filter) {
    $query .= " WHERE category = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $category_filter);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($query);
}

// If you need to fetch data, you can do so here

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Management</title>
    <link rel="stylesheet" href="menu.css">
</head>
<body>

    <div class="container">
        <h2>Manage Menu Items</h2>

        <!-- Add New Item Button -->
        <a href="add_item.php" class="add-btn">Add New Item</a>

        <!-- Category Filter -->
        <form method="GET" class="category-filter">
            <label for="category">Filter by Category:</label>
            <select name="category" id="category">
                <option value="">All</option>
                <option value="Cake" <?= ($category_filter == "Cake") ? "selected" : "" ?>>Cake</option>
                <option value="Sweets" <?= ($category_filter == "Sweets") ? "selected" : "" ?>>Sweets</option>
                <option value="Cookies & Biscuits" <?= ($category_filter == "Cookies & Biscuits") ? "selected" : "" ?>>Cookies & Biscuits</option>
            </select>
            <button type="submit">Filter</button>
        </form>

        <!-- Display Items Table -->
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price (₹)</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Item Image"></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td>₹<?= htmlspecialchars($row['price']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td>
                            <a href="edit_item.php?id=<?= $row['id'] ?>" class="edit-btn">Edit</a>
                            <a href="menu.php?delete=<?= $row['id'] ?>" class="delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
