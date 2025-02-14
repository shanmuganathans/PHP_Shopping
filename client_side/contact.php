<?php
include 'db.php';
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(strip_tags(trim($_POST['subject'])));
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message, submitted_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $success_message = "Message sent successfully!";
        } else {
            $error_message = "Error submitting your message. Please try again.";
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Get in touch with Our Bakery for inquiries, orders, or feedback.">
    <title>Contact Us - Our Bakery</title>
    <link rel="stylesheet" href="contact.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="shop.php">Shop</a>
        <a href="my_orders.php">My Orders</a>
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
        <h2>We'd Love to Hear from You!</h2>
        
        <?php if (isset($success_message)): ?>
            <p class="success"><?= htmlspecialchars($success_message) ?></p>
        <?php elseif (isset($error_message)): ?>
            <p class="error"><?= htmlspecialchars($error_message) ?></p>
        <?php endif; ?>

        <form class="contact-form" action="contact.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <input type="text" name="subject" placeholder="Subject" required>
            <textarea name="message" placeholder="Your Message" required></textarea>
            <button type="submit">Send Message</button>
        </form>
    </div>

    <!-- Contact Information -->
    <div class="contact-info">
        <p class="address"><strong>Address:</strong> 123 Bakery Lane, Sweet Town, ABC</p>
        <p class="phone"><strong>Phone:</strong> +123 456 7890</p>
        <p><strong>Email:</strong> contact@ourbakery.com</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; 2025 Our Bakery. All rights reserved.
    </div>
</body>
</html>
