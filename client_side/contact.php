<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contact.css">
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

    <!-- Contact Header -->
    <div class="contact-header">
        <h1>Contact Us</h1>
    </div>

    <!-- Contact Form -->
    <div class="contact-form-container">
        <h2>Feedback</h2>
        <form class="contact-form" action="submit_contact.php" method="POST">
          <input type="text" name="name" placeholder="Your Name" required>
          <input type="email" name="email" placeholder="Your Email" required>
          <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>

    <!-- Contact Information -->
    <div class="contact-info">
        <p class="address">123 Bakery Lane, Sweet Town, ABC</p>
        <p class="phone">Phone: +123 456 7890</p>
        <p>Email: contact@ourbakery.com</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2025 Our Bakery. All rights reserved.
    </div>
</body>
</html>
