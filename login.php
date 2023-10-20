<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker - Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        body {
            padding: 20px;
        }

        .login-form {
            width: 300px;
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
    // User is already logged in, redirect to dashboard
    header('Location: index.php');
    exit();
}

// Check if login form is submitted
if (isset($_POST['login'])) {
    // Validate user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo '<p class="error-message">Please enter both username and password.</p>';
    } else {
        // Connect to the database
        $db = mysqli_connect('localhost', 'root', '', 'expense_tracker');

        // Check connection
        if (!$db) {
            die('Connection failed: ' . mysqli_connect_error());
        }

        // Verify user credentials
        $sql = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($db, $sql);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user['id'];
                header('Location: index.php');
                exit();
           
        } else {
            echo '<p class="error-message">Invalid username or password.</p>';
        }

        mysqli_close($db);
    }
}
?>

<div class="container">
    <h1>Expense Tracker - Login</h1>

    <form class="login-form" method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary" name="login">Login</button>
    </form>
    <a href="user_register.php"> Create Account</a>
</div>

</body>
</html>
