<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker - Manage Categories</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        body {
            padding: 10px;
        }

        .categories-list {
            margin-bottom: 20px;
        }

        .add-category-form {
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
if (isset($_POST['add_category'])) {
    // Validate user input
    $category_name = $_POST['category_name'];

    if (empty($category_name)) {
        echo '<p class="error-message">Please enter a category name.</p>';
    } else {
        // Sanitize user input
        $category_name = mysqli_real_escape_string($db, $category_name);

        // Check if category already exists
        $sql = "SELECT id FROM categories WHERE name = '$category_name'";
        $result = mysqli_query($db, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<p class="error-message">Category already exists.</p>';
        } else {
            // Insert category into database
            $sql = "INSERT INTO categories (name) VALUES ('$category_name')";
            $result = mysqli_query($db, $sql);

            if ($result) {
                echo '<p class="success-message">Category added successfully.</p>';
            } else {
                echo '<p class="error-message">Failed to add category.</p>';
            }
        }
    }
}

// Fetch categories for display
$sql = "SELECT id, name FROM categories";
$result = mysqli_query($db, $sql);
$categories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $categories[] = $row;
}

mysqli_close($db);
?>

<div class="container">
    <h1>Expense Tracker - Manage Categories</h1>

    <div class="categories-list">
        <h2>Existing Categories</h2>
        <ul>
            <?php if (count($categories) > 0) { ?>
                <?php foreach ($categories as $category) { ?>
                    <li><?php echo $category['name']; ?></li>
                <?php } ?>
            <?php } else { ?>
                <li>No categories added yet.</li>
            <?php } ?>
        </ul>
    </div>

    <form class="add-category-form" method="post">
        <h2>Add New Category</h2>
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name">
            </div>
        <button type="submit" class="btn btn-primary" name="add_category">Add Category</button>
    </form>
</div>

</body>
</html>
