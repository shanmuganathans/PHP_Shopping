<?php
session_start();

// Ensure admin is logged in
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "root@123";
$db_name = "register";

$conn = new mysqli($servername, $username, $password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle user deletion securely
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Ensure ID is an integer
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "User deleted successfully!";
    } else {
        $_SESSION['message'] = "Error deleting user.";
    }
    $stmt->close();
    header("Location: manage_users.php");
    exit();
}

// Fetch all users securely
$sql = "SELECT id, username, email FROM users";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="manage_users.css">
    <script>
        function confirmDeletion(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = "manage_users.php?delete_id=" + userId;
            }
        }
    </script>
</head>
<body>
    <div class="dashboard-container">
        <h1>Manage Users</h1>

        <?php if (isset($_SESSION['message'])): ?>
            <p class="success-message"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <button onclick="confirmDeletion(<?php echo $row['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
