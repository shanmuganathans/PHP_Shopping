<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
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

    <!-- Cakes Section -->
    <div class="menu-category" id="cakes">
        <h2>Cakes</h2>
        <?php
        $cakes = [
            ["Gulab Jamun Cake", "gulab juman cake.jpg", "₹120 per slice"],
            ["Rava Kesari Cake", "rava kesari cake.jpg", "₹100 per slice"],
            ["Milk Cake", "milk cake.jpg", "₹150 per slice"],
            ["Mango Cake", "mango cake.jpg", "₹130 per slice"],
            ["Chocolate Cake", "chocolate cake.jpg", "₹110 per slice"]
        ];
        foreach ($cakes as $cake) {
            echo '<div class="menu-item" data-name="'.htmlspecialchars($cake[0]).'">
                    <img src="../images/'.htmlspecialchars($cake[1]).'" alt="'.htmlspecialchars($cake[0]).'">
                    <h3>'.htmlspecialchars($cake[0]).' - '.htmlspecialchars($cake[2]).'</h3>
                  </div>';
        }
        ?>
    </div>

    <!-- Sweets Section -->
    <div class="menu-category" id="sweets">
        <h2>Sweets & Desserts</h2>
        <?php
        $sweets = [
            ["Gulab Jamun", "gulab jamun.jpg", "₹40 per piece"],
            ["Jalebi", "jalebi.jpg", "₹50 per serving"],
            ["Barfi", "barfi.jpg", "₹60 per piece"],
            ["Rasgulla", "rasgulla.jpg", "₹30 per piece"],
            ["Kaju Katli", "kaju katli.jpg", "₹80 per piece"]
        ];
        foreach ($sweets as $sweet) {
            echo '<div class="menu-item" data-name="'.htmlspecialchars($sweet[0]).'">
                    <img src="../images/'.htmlspecialchars($sweet[1]).'" alt="'.htmlspecialchars($sweet[0]).'">
                    <h3>'.htmlspecialchars($sweet[0]).' - '.htmlspecialchars($sweet[2]).'</h3>
                  </div>';
        }
        ?>
    </div>

    <!-- Cookies Section -->
    <div class="menu-category" id="cookies">
        <h2>Cookies & Biscuits</h2>
        <?php
        $cookies = [
            ["Chocolate Chip Cookies", "chocolate chip cookies.jpeg", "₹25 per piece"],
            ["Coconut Cookies", "coconut cookies.jpg", "₹20 per piece"],
            ["Butter Biscuits", "butter biscuits.jpg", "₹20 per piece"],
            ["Peanut Butter Cookies", "peanut butter cookies.jpg", "₹30 per piece"],
            ["Oatmeal Raisin Cookies", "oatmeal raisin cookie.jpg", "₹20 per piece"]
        ];
        foreach ($cookies as $cookie) {
            echo '<div class="menu-item" data-name="'.htmlspecialchars($cookie[0]).'">
                    <img src="../images/'.htmlspecialchars($cookie[1]).'" alt="'.htmlspecialchars($cookie[0]).'">
                    <h3>'.htmlspecialchars($cookie[0]).' - '.htmlspecialchars($cookie[2]).'</h3>
                  </div>';
        }
        ?>
    </div>

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
