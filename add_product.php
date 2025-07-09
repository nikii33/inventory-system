<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products (name, category, quantity, price)
            VALUES ('$name', '$category', '$quantity', '$price')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $msg = "✅ Product added successfully!";
    } else {
        $msg = "❌ Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand">Inventory System</span>
    <div class="d-flex">
      <span class="navbar-text text-white me-3">
        Hello, <?php echo $_SESSION['username']; ?>
      </span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
      

    </div>
  </div>
</nav>

<!-- Content -->
<div class="container mt-5" style="max-width: 600px;">
    <h3 class="mb-4">➕ Add New Product</h3>

    <?php if (isset($msg)) echo "<div class='alert alert-info'>$msg</div>"; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Price (in ₹)</label>
            <input type="number" name="price" step="0.01" class="form-control" required>
        </div>

        <button type="submit" name="add" class="btn btn-success w-100">Add Product</button>
        <a href="import_products.php" class="btn btn-warning mb-3">📥 Bulk Import</a>

    </form>

    <div class="mt-3">
        <a href="dashboard.php" class="btn btn-secondary btn-sm">← Back to Dashboard</a>
    </div>
</div>

</body>
</html>
