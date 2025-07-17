<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
  header("Location: login.html");
  exit();   
}

$email = $_SESSION['email'];

// Get user's ID
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
if (!$stmt) {
  die("User query failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$userId = $user['id'] ?? 0;
$stmt->close();

// Get properties by user
$query = $conn->prepare("SELECT * FROM properties WHERE user_id = ?");
if (!$query) {
  die("Property query failed: " . $conn->error);
}
$query->bind_param("i", $userId);
$query->execute();
$properties = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Properties</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h2>My Property Listings</h2>
    <nav>
      <a href="dashboard.php">← Back to Dashboard</a> |
      <a href="add-property.html">+ Add New Property</a>
    </nav>
    <hr>
  </header>

  <section>
    <?php if ($properties->num_rows > 0): ?>
      <table border="1" cellpadding="10" cellspacing="0">
        <thead>
          <tr>
            <th>Title</th>
            <th>Location</th>
            <th>Price</th>
            <th>Description</th>
            <th>Image</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $properties->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['title']) ?></td>
              <td><?= htmlspecialchars($row['location']) ?></td>
              <td>KES <?= number_format($row['price']) ?></td>
              <td><?= htmlspecialchars($row['description']) ?></td>
              <td>
                <?php if (!empty($row['image'])): ?>
                  <img src="uploads/<?= htmlspecialchars($row['image']) ?>" width="100">
                <?php else: ?>
                  No image
                <?php endif; ?>
              </td>
              <td>
                <a href="edit-property.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete-property.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this property?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>You have not posted any properties yet.</p>
    <?php endif; ?>
  </section>

  <footer>
    <hr>
    <p>&copy; 2025 HomeFinder. All rights reserved.</p>
  </footer>
</body>
</html>
