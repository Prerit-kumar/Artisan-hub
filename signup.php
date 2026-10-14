<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "ecommerce_db";

// Connect to DB
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get values from form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_name = $_POST['user_name'] ?? '';
  $user_pass = $_POST['user_pass'] ?? '';
  $user_role = $_POST['user_role'] ?? '';
}

// Insert into DB
$sql = "INSERT INTO user_account (user_name, user_pass, user_role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $user_name, $user_pass, $user_role);

if ($stmt->execute()) {
  echo "Signup successful! <a href='login.html'>Login Now</a>";
} else {
  echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
