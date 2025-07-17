<?php
session_start();
require 'config.php';

// Restrict access to logged-in owners
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    echo "Access denied.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch properties for this owner
$stmt = $conn->prepare("SELECT * FROM properties WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Properties</title>
    <style>
        .property {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 15px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .property img {
            width: 200px;
            height: auto;
            margin-bottom: 10px;
        }
        .actions {
            margin-top: 10px;
        }
        .actions a {
            margin-right: 10px;
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .actions a.delete {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <h2>My Property Listings</h2>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="property">
            <img src="<?= htmlspecialchars($row['image']) ?>" alt="Property Image"><br>
            <strong><?= htmlspecialchars($row['title']) ?></strong><br>
            <b>Location:</b> <?= htmlspecialchars($row['location']) ?><br>
            <b>Price:</b> KES <?= number_format($row['price']) ?><br>
            <b>Description:</b> <?= htmlspecialchars($row['description']) ?><br>
            <div class="actions">
                <a href="edit-property.php?id=<?= $row['id'] ?>">Edit</a>
                <a href="delete-property.php?id=<?= $row['id'] ?>" class="delete" onclick="return confirm('Are you sure you want to delete this property?');">Delete</a>
            </div>
        </div>
    <?php endwhile; ?>
</body>
</html>
