<?php
// Connect to the database
$db = mysqli_connect('localhost', 'root', '', 'expense_tracker');

// Check connection
if (!$db) {
    die('Connection failed: ' . mysqli_connect_error());
}
?>