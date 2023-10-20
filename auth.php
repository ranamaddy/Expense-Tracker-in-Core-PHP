<?php
if (!isset($_SESSION)) {
    session_start();
  }
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to login page
    header('Location: login.php');
    exit();
}
?>