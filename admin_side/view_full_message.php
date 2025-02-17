<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}

// Database Connection
$servername = "localhost";
$username = "root";
$password = "root@123";
$db_name = "register";

$conn = new mysqli($servername, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and fetch the message
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid message ID.");
}

$message_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT id, name, email, subject, message, submitted_at FROM contact_messages WHERE id = ?");
$stmt->bind_param("i", $message_id);
$stmt->execute();
$result = $stmt->get_result();
$message = $result->fetch_assoc();

// Check if message exists
if (!$message) {
    die("Message not found.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Message</title>
    <link rel="stylesheet" href="view_full_message.css">
</head>
<body>
    <div class="message-container">
        <h1>Full Message</h1>
        <table class="message-table">
            <tr>
                <th>ID:</th>
                <td><?php echo htmlspecialchars($message['id']); ?></td>
            </tr>
            <tr>
                <th>Name:</th>
                <td><?php echo htmlspecialchars($message['name']); ?></td>
            </tr>
            <tr>
                <th>Email:</th>
                <td><?php echo htmlspecialchars($message['email']); ?></td>
            </tr>
            <tr>
                <th>Subject:</th>
                <td><?php echo htmlspecialchars($message['subject']); ?></td>
            </tr>
            <tr>
                <th>Message:</th>
                <td><?php echo nl2br(htmlspecialchars($message['message'])); ?></td>
            </tr>
            <tr>
                <th>Date Submitted:</th>
                <td><?php echo date("Y-m-d H:i:s", strtotime($message['submitted_at'])); ?></td>
            </tr>
        </table>

        <a href="view_messages.php" class="back-btn">Back to Messages</a>
    </div>
</body>
</html>
