<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    echo "User not logged in.";
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid property ID.";
    exit();
}

$propertyId = (int)$_GET['id'];
$email = $_SESSION['email'];

// Get current user ID
$userStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$userStmt->bind_param("s", $email);
$userStmt->execute();
$userResult = $userStmt->get_result();
$user = $userResult->fetch_assoc();
$userId = $user['id'] ?? 0;
$userStmt->close();

// Fetch property
$stmt = $conn->prepare("SELECT * FROM properties WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $propertyId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Property not found or not authorized.";
    exit();
}

$property = $result->fetch_assoc();
$currentImage = $property['image'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image = $currentImage;

    // Check if new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = $imageName;
            // Optional: Delete old image if different
            if ($currentImage && $currentImage !== $image && file_exists("uploads/" . $currentImage)) {
                unlink("uploads/" . $currentImage);
            }
        } else {
            echo "<p style='color: red;'>Failed to upload image.</p>";
        }
    }

    $updateStmt = $conn->prepare("UPDATE properties SET title = ?, location = ?, price = ?, description = ?, image = ? WHERE id = ? AND user_id = ?");
    $updateStmt->bind_param("ssdssii", $title, $location, $price, $description, $image, $propertyId, $userId);
    
    if ($updateStmt->execute()) {
        echo "<p style='color: green;'>Property updated successfully!</p>";
        header("Refresh:2; url=my-properties.php");
        exit();
    } else {
        echo "<p style='color: red;'>Failed to update property.</p>";
    }
    $updateStmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Property</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        form { background: white; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; }
        input, textarea, select {
            width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px;
        }
        button {
            background: #003366; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;
        }
        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>Edit Property</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Title</label>
        <input type="text" name="title" value="<?= htmlspecialchars($property['title']) ?>" required>

        <label>Location</label>
        <input type="text" name="location" value="<?= htmlspecialchars($property['location']) ?>" required>

        <label>Price (KES)</label>
        <input type="number" name="price" value="<?= htmlspecialchars($property['price']) ?>" required>

        <label>Phone</label>
        <input type="number" name="phone" value="<?= htmlspecialchars($property['0706003049']) ?>" required>

        <label>Description</label>
        <textarea name="description" rows="4" required><?= htmlspecialchars($property['description']) ?></textarea>

        <label>Current Image</label><br>
        <?php if ($currentImage): ?>
            <img src="uploads/<?= htmlspecialchars($currentImage) ?>" alt="Property Image">
        <?php else: ?>
            <p>No image uploaded.</p>
        <?php endif; ?>

        <label>Upload New Image (optional)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">Update Property</button>
    </form>
</body>
</html>
