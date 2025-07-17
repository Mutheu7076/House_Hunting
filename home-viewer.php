<?php
include 'db.php';

$search = $_GET['search'] ?? '';
$filter = $_GET['location'] ?? '';

$sql = "SELECT properties.*, users.fullname, users.email AS owner_email 
        FROM properties 
        JOIN users ON properties.user_id = users.id 
        WHERE 1";


if (!empty($search)) $sql .= " AND properties.title LIKE '%$search%'";
if (!empty($filter)) $sql .= " AND properties.location = '$filter'";

$result = $conn->query($sql);
if (!$result) {
    die("Main query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Browse Properties</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: Arial, sans-serif; background: #f9f9f9; margin: 0; }
    header { background: #003366; color: white; padding: 20px; }
    .container { padding: 20px; }
    .property-card {
      background: white;
      margin-bottom: 20px;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      display: flex;
      gap: 15px;
    }
    .property-card img {
      width: 200px;
      height: 140px;
      object-fit: cover;
      border-radius: 5px;
    }
    .property-info { flex-grow: 1; }
    .search-bar {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }
    .search-bar input, .search-bar select {
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    .search-bar button {
      background: #003366;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 8px 12px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <header>
    <h1>Available Properties</h1>
  </header>

  <div class="container">
    <form class="search-bar" method="GET">
      <input type="text" name="search" placeholder="Search by title..." value="<?= htmlspecialchars($search) ?>">
      <select name="location">
        <option value="">All Locations</option>
        <option value="Nairobi" <?= $filter === 'Nairobi' ? 'selected' : '' ?>>Nairobi</option>
        <option value="Kiambu" <?= $filter === 'Kiambu' ? 'selected' : '' ?>>Kiambu</option>
        <option value="Thika" <?= $filter === 'Thika' ? 'selected' : '' ?>>Thika</option>
        <option value="Ruiru" <?= $filter === 'Ruiru' ? 'selected' : '' ?>>Ruiru</option>
      </select>
      <button type="submit">Search</button>
    </form>

    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="property-card">
          <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Property Image">
          <div class="property-info">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
            <p><strong>Price:</strong> KES <?= number_format($row['price']) ?></p>
            <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
            <p><strong>Contact Owner:</strong> <?= htmlspecialchars($row['owner_email']) ?></p>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No properties found.</p>
    <?php endif; ?>
  </div>
</body>
</html>
