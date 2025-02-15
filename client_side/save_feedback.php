<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$username = $_SESSION['username'];
$feedback_text = trim($_POST['feedback_text']);
$feedback_id = $_POST['feedback_id'] ?? null;

if ($feedback_id) {
    // Update feedback
    $stmt = $conn->prepare("UPDATE feedbacks SET feedback = ? WHERE id = ? AND username = ?");
    $stmt->bind_param("sis", $feedback_text, $feedback_id, $username);
} else {
    // Insert new feedback
    $stmt = $conn->prepare("INSERT INTO feedbacks (username, feedback) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $feedback_text);
}

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error"]);
}

$stmt->close();
$conn->close();
?>
