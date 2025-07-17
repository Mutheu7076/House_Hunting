<?php
session_start();
include 'db.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = "uploads/";
        $targetFile = $targetDir . $imageName;

        // Optional: Validate file type and size here

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Prepare and execute SQL insert
            $stmt = $conn->prepare("INSERT INTO properties (title, location, price, description, image) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiss", $title, $location, $price, $description, $imageName);

            if ($stmt->execute()) {
                echo "Property added successfully. <a href='listings.php'>View Listings</a>";
            } else {
                echo "Error adding property: " . $stmt->error;
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "No image file selected or upload error occurred.";
    }
} else {
    echo "Invalid request.";
}
?>

