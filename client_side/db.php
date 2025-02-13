<?php
$servername = "localhost";
$username = "root";
$password = "root@123";
$dbname = "register";

// Enable persistent connection for performance
$conn = new mysqli("p:$servername", $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Database Connection Error: " . $conn->connect_error); // Log error for debugging
    die("Database connection failed. Please try again later.");
}

// Set UTF-8 encoding for proper character support
$conn->set_charset("utf8mb4");

// Function to safely execute queries
function executeQuery($query, $params = []) {
    global $conn;
    $stmt = $conn->prepare($query);
    
    if ($params) {
        $types = str_repeat('s', count($params)); // Assume all params are strings (modify if needed)
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    return $stmt;
}
?>
