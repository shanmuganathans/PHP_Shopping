<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Ensure the session cookie is also removed
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Close session write to prevent unexpected behavior
session_write_close();

// Redirect to login page
header("Location: login.php");
exit();
?>
