<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Delete product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id=$id");
    header("Location: view_products.php");
    exit();
}

// Search products
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $query = "SELECT * FROM products WHERE name LIKE '%$search%' OR category LIKE '%$search%'";
} else {
    $query = "SELECT * FROM products";
}

$result = mysqli_query($conn, $query);

// Collect data + calculate totals
$rows = [];
$total_quantity = 0;
$total_value = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
    $total_quantity += $row['quantity'];
    $total_value += ($row['quantity'] * $row['price']);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Sri Jeyam Textiles - Inventory</span>
        <div class="d-flex">
            <span class="navbar-text text-white me-3">
                Welcome, <?= $_SESSION['username']; ?>
            </span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h3 class="mb-4">📦 Product Inventory</h3>

    <!-- Search -->
    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name or category..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="view_products.php" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- Summary -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="alert alert-info">📦 Total Products: <?= count($rows); ?></div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-warning">📊 Total Quantity: <?= $total_quantity; ?></div>
        </div>
        <div class="col-md-4">
            <div class="alert alert-success">💰 Stock Value: ₹<?= number_format($total_value, 2); ?></div>
        </div>
    </div>

    <!-- Add New Button -->
    <a href="add_product.php" class="btn btn-success mb-3">+ Add Product</a>

    <!-- Product Table -->
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Qty</th>
                <th>Price (₹)</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row) { ?>
            <tr class="<?= $row['quantity'] < 10 ? 'table-danger' : '' ?>">
                <td><?= $row['id']; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['category']; ?></td>
                <td><?= $row['quantity']; ?></td>
                <td><?= $row['price']; ?></td>
                <td><?= date("d M Y, h:i A", strtotime($row['date_added'])); ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                    <a href="view_products.php?delete=<?= $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary mt-3">← Back to Dashboard</a>
</div>

</body>
</html>
