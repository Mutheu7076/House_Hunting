<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Fetch existing image
    $stmt = $conn->prepare("SELECT image FROM properties WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $property = $result->fetch_assoc();
    $oldImage = $property['image'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetPath = "uploads/" . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            // Delete old image
            if (!empty($oldImage) && file_exists("uploads/" . $oldImage)) {
                unlink("uploads/" . $oldImage);
            }
        } else {
            die("Failed to upload new image.");
        }
    } else {
        $imageName = $oldImage; // Keep old image
    }

    // Update property
    $stmt = $conn->prepare("UPDATE properties SET title = ?, location = ?, price = ?, description = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssissi", $title, $location, $price, $description, $imageName, $id);

    if ($stmt->execute()) {
        header("Location: listings.php?message=Property updated successfully");
        exit();
    } else {
        echo "Failed to update property.";
    }

} else {
    echo "Invalid request.";
}
?>

