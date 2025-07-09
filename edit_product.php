<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id=$id"));

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "UPDATE products SET name='$name', category='$category', quantity='$quantity', price='$price' WHERE id=$id";
    mysqli_query($conn, $sql);

    header("Location: view_products.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form method="post">
        Name: <input type="text" name="name" value="<?= $product['name']; ?>" required><br><br>
        Category: <input type="text" name="category" value="<?= $product['category']; ?>" required><br><br>
        Quantity: <input type="number" name="quantity" value="<?= $product['quantity']; ?>" required><br><br>
        Price: <input type="number" name="price" step="0.01" value="<?= $product['price']; ?>" required><br><br>
        <input type="submit" name="update" value="Update Product">
    </form>
    <br>
    <a href="view_products.php">Back to Product List</a>
</body>
</html>
