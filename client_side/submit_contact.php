<?php
include 'db.php';
// Database configuration
$servername = "localhost"; // Change if your database server is different
$username = "root"; // Your database username
$password = "root@123"; // Your database password
$dbname = "register"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize response variables
$success_message = "";
$error_message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['subject']) || empty($_POST['message'])) {
        $error_message = "All fields are required!";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format!";
    } else {
        // Sanitize and assign variables
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $subject = trim($_POST['subject']);
        $message = trim($_POST['message']);

        // Prepare SQL query using prepared statements
        $stmt = $conn->prepare("INSERT INTO messages (name, email, subject, message, submitted_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $success_message = "Your message has been sent successfully!";
        } else {
            $error_message = "Error submitting message. Please try again.";
        }

        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Bakery</title>
    <link rel="stylesheet" href="cart.css">
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

    <div class="container">
        <h1>Contact Form Submission</h1>

        <?php if ($success_message): ?>
            <div class="success-message"><?= htmlspecialchars($success_message) ?></div>
        <?php elseif ($error_message): ?>
            <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <div class="actions">
            <a href="contact.php" class="btn">Go Back</a>
        </div>
    </div>

    <style>
        .container {
            text-align: center;
            margin-top: 50px;
        }
        .success-message {
            color: #28a745;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .error-message {
            color: #dc3545;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .actions {
            margin-top: 20px;
        }
        .btn {
            background-color: #b34d3a;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #d46958;
        }
    </style>

</body>
</html>
