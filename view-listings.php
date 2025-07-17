<?php
include 'db.php';

$sql = "SELECT * FROM properties ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Listings</title>
    <style>
        .property {
            border: 1px solid #ccc;
            padding: 16px;
            margin-bottom: 20px;
            width: 90%;
            max-width: 600px;
        }
        .property img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Available Properties</h2>
    <p><a href="login.html">Property Owner? Login here</a></p>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="property">';
            if (!empty($row['image'])) {
                echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" alt="Property Image">';
            }
            echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
            echo '<p><strong>Location:</strong> ' . htmlspecialchars($row['location']) . '</p>';
            echo '<p><strong>Price:</strong> KES ' . number_format($row['price']) . '</p>';
            echo '<p><strong>Description:</strong> ' . nl2br(htmlspecialchars($row['description'])) . '</p>';
            echo '<p><strong>Contact:</strong> ' . htmlspecialchars($row['contact_info']) . '</p>';
            echo '</div>';
        }
    } else {
        echo "<p>No properties found.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
