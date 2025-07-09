<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if (isset($_POST['import'])) {
    $filename = $_FILES["file"]["tmp_name"];

    if ($_FILES["file"]["size"] > 0) {
        $file = fopen($filename, "r");

        // Skip the first row (header)
        fgetcsv($file);

        while (($data = fgetcsv($file, 10000, ",")) !== FALSE) {
            // Skip empty or incomplete rows
            if (count($data) < 4 || !is_numeric($data[2]) || !is_numeric($data[3])) {
                continue;
            }
        
            // Safe to extract data
            $name = mysqli_real_escape_string($conn, $data[0]);
            $category = mysqli_real_escape_string($conn, $data[1]);
            $quantity = (int)$data[2];
            $price = (float)$data[3];
        
            // Insert into database
            $sql = "INSERT INTO products (name, category, quantity, price, date_added)
                    VALUES ('$name', '$category', $quantity, $price, NOW())";
            mysqli_query($conn, $sql);
        
        

            $sql = "INSERT INTO products (name, category, quantity, price, date_added) 
                    VALUES ('$name', '$category', $quantity, $price, NOW())";
            mysqli_query($conn, $sql);
        }

        fclose($file);
        $message = "Products imported successfully!";
    } else {
        $message = "Please upload a valid file.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Import Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Sri Jeyam Textiles - Inventory</span>
        <div class="d-flex">
            <a href="dashboard.php" class="btn btn-outline-light btn-sm">← Dashboard</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h3 class="mb-4">📥 Import Products (CSV)</h3>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Choose CSV File</label>
            <input type="file" name="file" accept=".csv" class="form-control" required>
            <div class="form-text">CSV Format: Name, Category, Quantity, Price</div>
        </div>
        <button type="submit" name="import" class="btn btn-primary">Import Now</button>
    </form>
</div>
</body>
</html>
