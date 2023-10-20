<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker - Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        body {
            padding: 10px;
        }

        .welcome-message {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .expense-summary {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }

        .expense-summary p {
            font-weight: bold;
        }

        .navigation {
            list-style: none;
            padding: 0;
        }

        .navigation li {
            margin-bottom: 10px;
        }

        .navigation a {
            display: block;
            padding: 10px;
            background-color: #eee;
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php
// Include required files
include('menu.php');
include('auth.php');
include('config.php');

// Get logged-in user's information
$user_id = $_SESSION['user_id'];
$sql = "SELECT username FROM user WHERE id = $user_id";
$result = mysqli_query($db, $sql);
$user = mysqli_fetch_assoc($result);
?>

<div class="container">

    <div class="row">
        <div class="col-md-12">
            <h1 class="welcome-message">Welcome, <?php echo $user['username']; ?>!</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="expense-summary">
                <p>Total Expenses: <?php
                    $sql = "SELECT SUM(amount) AS total_expenses FROM expenses WHERE user_id = $user_id";
                    $result = mysqli_query($db, $sql);
                    $expense_summary = mysqli_fetch_assoc($result);
                    echo $expense_summary['total_expenses'];
                ?></p>
            </div>
        </div>

        <div class="col-md-8">
            <ul class="navigation">
                <li><a href="add_expense.php">Add Expense</a></li>
                <li><a href="view_expenses.php">View Expenses</a></li>
                <li><a href="categories.php">Manage Categories</a></li>
                <li><a href="reports.php">Generate Reports</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>

</div>

<?php
// Close database connection
mysqli_close($db);
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="
