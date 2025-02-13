n<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="about.css">
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

    <div class="about-header">
        <h1>About Us</h1>
    </div>

<div class="container">
        <h2>Welcome to Our Bakery</h2>
        <p>Welcome to our bakery! Our story begins during the challenging times of the COVID-19 pandemic. Amidst uncertainty, I decided to pursue my lifelong passion for baking and cooking. At 34 years old, I realized that life is too short to not do what you truly love, and that's when the idea of opening a bakery became a reality.</p>
        <p>Having always enjoyed experimenting with new flavors and creating delicious treats, I started baking from home, sharing my creations with family and friends. The joy and satisfaction I felt from seeing others enjoy my baked goods was unmatched. What started as a small hobby quickly blossomed into a full-fledged business.</p>
        <p>Our bakery is a reflection of my love for baking — a place where every cake, pastry, and sweet treat is made with care, love, and the finest ingredients. Whether you're here for a simple slice of cake or looking for something special for a celebration, we promise to deliver the freshest and most delicious items that will leave you coming back for more.</p>
        <p>Thank you for being a part of our journey. We’re thrilled to share our passion with you and can’t wait to serve you the most delightful baked goods made with love!</p>
        <img src="../images/our team.jpg" alt="Our Team" width="540" height="360"> <!-- Replace with your team photo -->
    </div>

    <div class="footer">
        &copy; 2025 Our Bakery. All rights reserved.
    </div>
</body>
</html>
