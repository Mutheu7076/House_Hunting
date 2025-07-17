<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Check if the property belongs to the logged-in user
$sql = "SELECT * FROM properties WHERE id = $id AND user_id = $user_id";
$result = mysqli_query($conn, $sql);
$property = mysqli_fetch_assoc($result);

if (!$property) {
    echo "Property not found or permission denied.";
    exit();
}

// Delete the property
$delete = "DELETE FROM properties WHERE id = $id AND user_id = $user_id";
if (mysqli_query($conn, $delete)) {
    header("Location: listings.php");
    exit();
} else {
    echo "Failed to delete: " . mysqli_error($conn);
}
?>
