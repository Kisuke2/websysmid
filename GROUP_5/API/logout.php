<?php
// Logout API - Destroys session and logs out user
header('Content-Type: application/json');

session_start();

// Destroy all session variables
$_SESSION = array();

// Destroy the session
if (session_destroy()) {
    echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error logging out']);
}
?>

