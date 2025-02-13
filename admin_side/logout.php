<?php
session_start(); // Start the session if it's not already started

// Unset all session variables
$_SESSION = array();

// Destroy the session properly
if (session_status() == PHP_SESSION_ACTIVE) {
    session_destroy();
}

// Regenerate session ID to prevent session fixation attacks
session_regenerate_id(true);

// Redirect to login page
header("Location: login.php");
exit();
?>
