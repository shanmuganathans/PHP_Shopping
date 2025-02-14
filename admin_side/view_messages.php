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

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle message deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Ensure it's an integer
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
    header("Location: view_messages.php");
    exit();
}

// Fetch all messages securely
$sql = "SELECT id, name, email, subject, message, submitted_at FROM contact_messages ORDER BY submitted_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Contact Messages</h1>
        
        <!-- Table for displaying messages -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['subject']); ?></td>
                            <td>
                                <?php 
                                    $message = htmlspecialchars($row['message']);
                                    echo (strlen($message) > 50) ? substr($message, 0, 50) . '...' : $message;
                                ?>
                                <a href="view_full_message.php?id=<?php echo $row['id']; ?>">View Full</a>
                            </td>
                            <td><?php echo date("Y-m-d", strtotime($row['created_at'])); ?></td>
                            <td>
                                <a href="view_messages.php?delete_id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        
        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
    
    <?php 
    // Close database connection
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
