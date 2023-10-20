<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker - Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        body {
            padding: 20px;
        }

        .register-form {
            width: 400px;
            margin: 0 auto;
        }

        .error-message {
            color: red;
        }
    </style>
</head>
<body>

<?php
// Start session for user management
session_start();

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    // User is already logged in, redirect to home page
    header('Location: index.php');
    exit();
}

include('config.php');

// Check if registration form is submitted
if (isset($_POST['register'])) {
    // Validate user input
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo '<p class="error-message">Please fill in all fields.</p>';
    } else if ($password != $confirm_password) {
        echo '<p class="error-message">Passwords do not match.</p>';
    } else {
        // Sanitize user input
        $username = mysqli_real_escape_string($db, $username);
        $email = mysqli_real_escape_string($db, $email);
        $password = mysqli_real_escape_string($db, $password);

        // Check if username or email already exists
        $sql = "SELECT id FROM user WHERE username = '$username' OR email = '$email'";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<p class="error-message">Username or email already exists.</p>';
        } else {
            // Hash password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into database
            $sql = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
            $result = mysqli_query($db, $sql);

            if ($result) {
                echo '<p class="success-message">Registration successful. Please login.</p>';
            } else {
                echo '<p class="error-message">Registration failed.</p>';
            }
        }
    }
}

mysqli_close($db);
?>

<div class="container">
    <h1>Expense Tracker - Register</h1>

    <form class="register-form" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
        </div>
        <button type="submit" class="btn btn-primary" name="register">Register</button>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </form>
</div>

</body>
</html>

