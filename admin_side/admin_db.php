<?php
// This file used to create admin users with password_hash that will increase the security agains password hijacking.
// Database connection
$servername = "localhost";
$username = "root";
$password = "root@123";
$dbname = "register";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Hash the password using PHP
$hashed_password = password_hash('admin@123', PASSWORD_DEFAULT);

// Prepare the SQL query
$stmt = $conn->prepare("INSERT INTO admin_users (username, email, password) VALUES (?, ?, ?)");
$username = "admin";
$email = "admin@gmail.com";

$stmt->bind_param("sss", $username, $email, $hashed_password);

// Execute the query
if ($stmt->execute()) {
    echo "Admin user inserted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connection
$stmt->close();
$conn->close();
?>