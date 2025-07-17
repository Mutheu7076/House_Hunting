<?php
include 'db.php';

if (!isset($_GET['id'])) {
    echo "Property ID not provided.";
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
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($property['title']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2><?php echo htmlspecialchars($property['title']); ?></h2>
    <p><strong>Location:</strong> <?php echo htmlspecialchars($property['location']); ?></p>
    <p><strong>Price:</strong> KES <?php echo number_format($property['price']); ?></p>
    <p><strong>Description:</strong><br><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>

    <br><a href="listings.php">← Back to Listings</a>
</body>
</html>
