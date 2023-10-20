<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker - Add Expense</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        body {
            padding: 10px;
        }

        .add-expense-form {
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
include('menu.php');
include('auth.php');
include('config.php');

// Check if form is submitted
if (isset($_POST['add_expense'])) {
    // Validate user input
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $category = $_POST['category'];

    if (empty($amount) || empty($description) || empty($date) || empty($category)) {
        echo '<p class="error-message">Please fill in all fields.</p>';
    } else {
        // Sanitize user input
        $amount = mysqli_real_escape_string($db, $amount);
        $description = mysqli_real_escape_string($db, $description);
        $date = mysqli_real_escape_string($db, $date);
        $category = mysqli_real_escape_string($db, $category);

        // Insert expense into database
        $sql = "INSERT INTO expenses (amount, description, date, category_id, user_id) VALUES ('$amount', '$description', '$date', '$category', '" . $_SESSION['user_id'] . "')";
        $result = mysqli_query($db, $sql);

        if ($result) {
            echo '<p class="success-message">Expense added successfully.</p>';
        } else {
            echo '<p class="error-message">Failed to add expense.</p>';
        }
    }
}

// Fetch categories for dropdown
$sql = "SELECT id, name FROM categories";
$result = mysqli_query($db, $sql);
$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[$row['id']] = $row['name'];
}

mysqli_close($db);
?>

<div class="container">
    <h1>Expense Tracker - Add Expense</h1>

    <form class="add-expense-form" method="post">
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" class="form-control" id="description" name="description">
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" id="category" name="category">
                <option value="">Select Category</option>
                <?php foreach ($categories as $category_id => $category_name) { ?>
                    <option value="<?php echo $category_id; ?>"><?php echo $category_name; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="add_expense">Add Expense</button>
    </form>
</div>

</body>
</html>

