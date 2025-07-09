<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
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
        Welcome, <?php echo $_SESSION['username']; ?>
      </span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<!-- Content -->
<div class="container mt-5">
    <h2 class="mb-4">Dashboard</h2>
    <div class="row g-3">
        <div class="col-md-6">
            <a href="add_product.php" class="btn btn-primary w-100 p-3">+ Add Product</a>
        </div>
        <div class="col-md-6">
            <a href="view_products.php" class="btn btn-success w-100 p-3">📦 View Products</a>
        </div>
    </div>
</div>

</body>
</html>
