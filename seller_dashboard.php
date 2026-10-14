<?php
session_start();

// Restrict access to sellers only
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'seller') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "ecommerce_db");

// Handle product upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $product_price = $_POST['product_price'];
    $user_id = $_SESSION['user_id'];
    
    // File handling
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $upload_path = "uploads/" . basename($image);

    if (move_uploaded_file($tmp_name, $upload_path)) {
        $stmt = $conn->prepare("INSERT INTO products (name, image, price, user_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssdi", $user_name, $image, $product_price, $user_id);
        
        if ($stmt->execute()) {
            echo "<p style='color:green;'>Product uploaded successfully!</p>";
        } else {
            echo "<p style='color:red;'>Error uploading product: " . $stmt->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Failed to upload image.</p>";
    }
}
?>

<h2>Welcome, <?php echo $_SESSION['username']; ?> (Seller)</h2>
<a href="logout.php">Logout</a>

<h3>Upload a Product</h3>
<form method="POST" enctype="multipart/form-data">
    Product Name: <input type="text" name="name" required><br><br>
    Price (₹): <input type="number" name="price" step="0.01" required><br><br>
    Image: <input type="file" name="image" accept="image/*" required><br><br>
    <input type="submit" value="Upload Product">
</form>
