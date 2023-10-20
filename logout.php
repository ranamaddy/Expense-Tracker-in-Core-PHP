<?php
// Start session for user management
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header('Location: login.php');
    exit();
}

// Destroy session and logout user
session_destroy();
unset($_SESSION['user_id']);

// Redirect to login page
header('Location: login.php');
exit();
?>
