<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
  header("Location: login.html");
  exit();
}

$currentEmail = $_SESSION['email'];
$message = "";

// Fetch current user data
$stmt = $conn->prepare("SELECT fullname, email FROM users WHERE email = ?");
$stmt->bind_param("s", $currentEmail);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $newName = $_POST['fullname'];
  $newEmail = $_POST['email'];

  // Update user data
  $update = $conn->prepare("UPDATE users SET fullname = ?, email = ? WHERE email = ?");
  $update->bind_param("sss", $newName, $newEmail, $currentEmail);

  if ($update->execute()) {
    $_SESSION['email'] = $newEmail;
    $message = "Profile updated successfully!";
    // Refresh current values
    $user['fullname'] = $newName;
    $user['email'] = $newEmail;
  } else {
    $message = "Failed to update profile.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Edit Your Profile</h2>
  <p style="color: green;"><?php echo $message; ?></p>

<form action="edit-property.php?id=<?php echo $property['id']; ?>" method="POST" enctype="multipart/form-data" style="max-width: 600px; margin: auto; background-color: #f9f9f9; padding: 20px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">

  <label for="title">Property Title:</label>
  <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($property['title']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

  <label for="location">Location:</label>
  <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($property['location']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

  <label for="price">Price (Ksh):</label>
  <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($property['price']); ?>" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;">

  <label for="description">Description:</label>
  <textarea id="description" name="description" rows="4" required style="width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;"><?php echo htmlspecialchars($property['description']); ?></textarea>

  <label for="image">Current Image:</label><br>
  <?php if (!empty($property['image'])): ?>
    <img src="uploads/<?php echo htmlspecialchars($property['image']); ?>" width="150" style="margin-bottom: 15px;"><br>
  <?php else: ?>
    <p style="color: #999;">No image uploaded.</p>
  <?php endif; ?>

  <label for="image">Change Image:</label>
  <input type="file" id="image" name="image" accept="image/*" style="margin-bottom: 15px;"><br><br>

  <button type="submit" style="width: 100%; background-color: #003366; color: white; padding: 10px; border: none; border-radius: 5px; font-weight: bold;">Update Property</button>
</form>


  <p><a href="dashboard.php">← Back to Dashboard</a></p>
</body>
</html>
