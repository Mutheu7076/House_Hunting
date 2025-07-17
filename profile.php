<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT fullname, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>My Profile - HomeFinder</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>My Profile</h1>
    <nav>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="add-property.html">Add Property</a></li>
        <li><a href="listings.php">View Listings</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <section>
    <h2>Welcome, <?= htmlspecialchars($user['fullname']) ?>!</h2>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
  </section>

  <footer>
    <p>&copy; 2025 HomeFinder. All rights reserved.</p>
  </footer>
</body>
</html>
