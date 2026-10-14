<?php
session_start();

// Restrict access to buyers only
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'buyer') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'ecommerce_db');

// Fetch all products
$result = $conn->query("SELECT * FROM products");
?>

<h2>Welcome, <?php echo $_SESSION['username']; ?> (Buyer)</h2>
<a href="logout.php">Logout</a>
<h3>Available Products</h3>

<?php
while ($row = $result->fetch_assoc()) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin-bottom:10px;'>";
    echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' width='150'><br>";
    echo "<strong>" . htmlspecialchars($row['user_name']) . "</strong><br>";
    echo "Price: ₹" . htmlspecialchars($row['product_price']) . "<br>";
    echo "</div>";
}
?>

