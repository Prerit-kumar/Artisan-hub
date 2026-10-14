<?php
// DB connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "ecommerce_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$cate_id = $_POST['cate_id'];

// Insert into DB
$sql = "INSERT INTO products (product_id, product_price, product_name, cate_id) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("idsi", $product_id, $product_price, $product_name, $cate_id);

if ($stmt->execute()) {
    echo "✅ Product added successfully! <a href='products.html'>View Products</a>";
} else {
    echo "❌ Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
