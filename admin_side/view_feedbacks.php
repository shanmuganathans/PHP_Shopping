<?php
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit();
}
// Database connection
include 'db.php';

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
