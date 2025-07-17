<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
  header("Location: login.html");
  exit();
}

$email = $_SESSION['email'];
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $currentPassword = $_POST['current_password'];
  $newPassword = $_POST['new_password'];
  $confirmPassword = $_POST['confirm_password'];

  if ($newPassword !== $confirmPassword) {
    $message = "New passwords do not match.";
  } else {
    // Get user's current hashed password
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($currentPassword, $user['password'])) {
      // Hash new password
      $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

      // Update password
      $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
      $update->bind_param("ss", $hashedPassword, $email);

      if ($update->execute()) {
        $message = "Password changed successfully!";
      } else {
        $message = "Failed to change password.";
      }
    } else {
      $message = "Current password is incorrect.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Change Your Password</h2>
  <p style="color: green;"><?php echo $message; ?></p>

  <form method="POST" action="">
    <label for="current_password">Current Password:</label><br>
    <input type="password" name="current_password" required><br><br>

    <label for="new_password">New Password:</label><br>
    <input type="password" name="new_password" required><br><br>

    <label for="confirm_password">Confirm New Password:</label><br>
    <input type="password" name="confirm_password" required><br><br>

    <button type="submit">Change Password</button>
  </form>

  <p><a href="login.html">← Back to Dashboard</a></p>
</body>
</html>
