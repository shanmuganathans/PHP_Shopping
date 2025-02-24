<?php
include 'db.php';

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fetch categories and items
$query = "SELECT category, name, image, price FROM items ORDER BY category";
$result = $conn->query($query);

// Organize items by category
$menu = [];

while ($row = $result->fetch_assoc()) {
    $category = $row['category'];
    if (!isset($menu[$category])) {
        $menu[$category] = [];
    }
    $menu[$category][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="menu.css">
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <a href="home.php">Home</a>
    <a href="menu.php">Menu</a>
    <a href="shop.php">Shop</a>
    <a href="my_orders.php">My Orders</a>
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact Us</a>
    <a href="logout.php">Logout</a>
</div>

<!-- Header -->
<header>
    <h1>Our Bakery Menu</h1>
</header>

<!-- Search Bar -->
<div class="search-container">
    <input type="text" id="search" placeholder="Search items..." onkeyup="filterMenu()">
    <button id="searchBtn">Search</button>
</div>

<!-- Menu Items -->
<div class="menu-container">
    <?php
    if (!empty($menu)) {
        foreach ($menu as $category => $items) {
            echo '<div class="menu-category">';
            echo '<h2>' . htmlspecialchars($category) . '</h2>';
            foreach ($items as $item) {
                echo '<div class="menu-item" data-name="' . htmlspecialchars($item['name']) . '">
                        <img src="../uploads/' . htmlspecialchars($item['image']) . '" alt="' . htmlspecialchars($item['name']) . '">
                        <h3>' . htmlspecialchars($item['name']) . ' - ₹' . htmlspecialchars($item['price']) . '</h3>
                      </div>';
            }
            echo '</div>';
        }
    } else {
        echo "<p>No menu items available.</p>";
    }
    ?>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2025 Our Bakery. All Rights Reserved.</p>
</footer>

<!-- JavaScript -->
<script>
    function filterMenu() {
        let input = document.getElementById("search").value.toLowerCase().trim();
        let menuItems = document.querySelectorAll(".menu-item");

        menuItems.forEach(item => {
            let itemName = item.getAttribute("data-name").toLowerCase();
            item.style.display = itemName.includes(input) ? "block" : "none";
        });
    }
</script>

</body>
</html>

<?php $conn->close(); ?>
