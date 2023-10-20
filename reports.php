<?php

include('auth.php');
include('config.php');

// Set default filter values
$filter_category = '';
$filter_date_from = '';
$filter_date_to = '';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker - Reports</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        body {
            padding: 10px;
        }

        .expenses-table {
            width: 100%;
        }

        .expenses-table th,
        .expenses-table td {
            padding: 10px;
            text-align: center;
        }

        .filter-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<?php
include('menu.php');

?>
<div class="container">
    <h1>Expense Tracker - Reports</h1>
   
    <form class="filter-form" method="post">
        <h2>Filter Expenses</h2>
      
        <div class="mb-3">
            <label for="filter_category" class="form-label">Category</label>
            <select class="form-select" id="filter_category" name="filter_category">

                <option value="">All Categories</option>
                <?php
                $categories_sql = "SELECT * FROM categories";
                $categories_result = mysqli_query($db, $categories_sql);
                
                while ($category = mysqli_fetch_assoc($categories_result)) {
                ?>
                    <option value="<?php echo $category['id']; ?>">
                        <?php echo $category['name']; ?>
                        
                        
                    </option>
                <?php } ?>
            </select>

        </div>
        <div class="mb-3">
            <label for="filter_date_from" class="form-label">Date From</label>
            <input type="date" class="form-control" id="filter_date_from" name="filter_date_from" value="<?php echo $filter_date_from; ?>">
        </div>
        <div class="mb-3">
            <label for="filter_date_to" class="form-label">Date To</label>
            <input type="date" class="form-control" id="filter_date_to" name="filter_date_to" value="<?php echo $filter_date_to; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="filter">Filter Expenses</button>
    </form>

    <table class="expenses-table">
        <thead>
            <tr>
                <th>Amount</th>
                <th>Description</th>
                <th>Category</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            // Check if filter form is submitted
if (isset($_POST['filter'])) {
    $filter_category = $_POST['filter_category'];
    $filter_date_from = $_POST['filter_date_from'];
    $filter_date_to = $_POST['filter_date_to'];
}

// Build SQL query based on filter options
$sql = "SELECT expenses.id, expenses.amount, expenses.description, expenses.date, categories.name AS category_name
        FROM expenses
        LEFT JOIN categories ON expenses.category_id = categories.id
        WHERE expenses.user_id = '" . $_SESSION['user_id'] . "'";

if ($filter_category != '') {
    $sql .= " AND categories.name = '$filter_category'";
}

if ($filter_date_from != '') {
    $sql .= " AND expenses.date >= '$filter_date_from'";
}

if ($filter_date_to != '') {
    $sql .= " AND expenses.date <= '$filter_date_to'";
}

$sql .= " ORDER BY expenses.date DESC";

$result = mysqli_query($db, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $expenses[] = $row;
}


            
            
            if (count($expenses) > 0) { ?>
                <?php foreach ($expenses as $expense) { ?>
                    <tr>
                        <td>$<?php echo $expense['amount']; ?></td>
                        <td><?php echo $expense['description']; ?></td>
                        <td><?php echo $expense['category_name']; ?></td>
                        <td><?php echo $expense['date']; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4">No expenses found.</td>
                </tr>
            <?php } 
            mysqli_close($db);
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

