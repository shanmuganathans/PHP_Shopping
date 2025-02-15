<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$feedback_id = $_POST['feedback_id'];
$username = $_SESSION['username'];

$stmt = $conn->prepare("DELETE FROM feedbacks WHERE id = ? AND username = ?");
$stmt->bind_param("is", $feedback_id, $username);

if ($stmt->execute()) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error"]);
}

$stmt->close();
$conn->close();
?>
