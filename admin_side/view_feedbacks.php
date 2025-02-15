<?php
include 'db.php';
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['username'])) {
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

// Fetch all feedbacks
$feedback_query = "SELECT username, feedback, created_at FROM feedbacks ORDER BY created_at DESC";
$feedbacks = $conn->query($feedback_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback - Our Bakery</title>
    <link rel="stylesheet" href="view_feedbacks.css">
</head>
<body>

    <div class="container">
        <h2>User Feedbacks</h2>

        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Feedback</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $feedbacks->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td><?= htmlspecialchars($row['feedback']) ?></td>
                        <td><?= date("d M Y, H:i", strtotime($row['created_at'])) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>

</body>
</html>
