<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name     = trim($_POST['name']);
  $email    = trim($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role     = $_POST['role'];

  // Check for empty fields
  if (empty($name) || empty($email) || empty($_POST['password']) || empty($role)) {
    die("All fields are required.");
  }

  // Check if email already exists
  $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
  $check->bind_param("s", $email);
  $check->execute();
  $check->store_result();

  if ($check->num_rows > 0) {
    die("This email is already registered.");
  }

  // Insert user
  $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
  if (!$stmt) {
    die("Prepare failed: " . $conn->error);
  }

  $stmt->bind_param("ssss", $name, $email, $password, $role);

  if ($stmt->execute()) {
    echo "Registration successful. <a href='login.html'>Login here</a>.";
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
} else {
  header("Location: register.html");
  exit();
}
?>
