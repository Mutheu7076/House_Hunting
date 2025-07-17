<?php
include 'db.php';

if (!isset($_GET['id'])) {
    echo "No property selected.";
    exit();
}

$property_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
$stmt->bind_param("i", $property_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $property = $result->fetch_assoc();
} else {
    echo "Property not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($property['title']); ?> - Property Details</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2><?php echo htmlspecialchars($property['title']); ?></h2>
  <p><strong>Location:</strong> <?php echo htmlspecialchars($property['location']); ?></p>
  <p><strong>Price:</strong> KSh <?php echo htmlspecialchars($property['price']); ?></p>
  <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
  <?php if ($property['image']): ?>
    <img src="<?php echo htmlspecialchars($property['image']); ?>" alt="Property Image" style="max-width: 400px;">
  <?php endif; ?>

  <p><a href="listings.php">← Back to Listings</a></p>
</body>
</html>
