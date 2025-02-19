<?php
session_start();
require 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch user's feedback
$feedback_query = "SELECT id, feedback FROM feedbacks WHERE username = ?";
$stmt = $conn->prepare($feedback_query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($feedback_id, $user_feedback);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Review</title>
    <link rel="stylesheet" href="review.css">
</head>
<body>

    <div class="review-container">
        <h2><?= ($user_feedback) ? "Edit Your Review" : "Write a Review"; ?></h2>
        <form id="reviewForm">
            <textarea id="feedbackText" required><?= htmlspecialchars($user_feedback) ?></textarea>
            <input type="hidden" id="feedbackId" value="<?= $feedback_id ?>">
            <button type="button" onclick="saveFeedback()" class="save-btn">
                <?= ($user_feedback) ? "Update Review" : "Submit Review"; ?>
            </button>
        </form>

        <?php if ($user_feedback): ?>
            <button onclick="deleteFeedback()" class="delete-btn">Delete Review</button>
        <?php endif; ?>
    </div>

    <script>
        function saveFeedback() {
            let feedbackText = document.getElementById('feedbackText').value;
            let feedbackId = document.getElementById('feedbackId').value;

            fetch('save_feedback.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `feedback_text=${encodeURIComponent(feedbackText)}&feedback_id=${feedbackId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    window.location.href = "home.php";
                } else {
                    alert("Error saving feedback.");
                }
            });
        }

        function deleteFeedback() {
            let feedbackId = document.getElementById('feedbackId').value;

            fetch('delete_feedback.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `feedback_id=${feedbackId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    window.location.href = "home.php";
                } else {
                    alert("Error deleting feedback.");
                }
            });
        }
    </script>

</body>
</html>
