<?php
session_start();

// DB connection
$host = "localhost";
$db = "ecommerce_db";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get inputs
$username = $_POST['user_name'];
$password = $_POST['user_pass'];

// Fetch user by username
$sql = "SELECT * FROM user_account WHERE user_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Plain password check (since DB doesn't store hashed passwords)
    if ($password === $user['user_pass']) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_role'] = $user['user_role'];

        // Role-based redirect (case insensitive)
        $role = strtolower($user['user_role']);
        if ($role === 'buyer') {
            header("Location: products.html");
        } elseif ($role === 'seller') {
            header("Location: add_product.html");
        } else {
            echo "Unknown role.";
        }
    } else {
        echo "Invalid username or password.";
    }
} else {
    echo "Invalid username or password.";
}

$conn->close();
?>
