<?php
include 'db.php';

$search = $_GET['search'] ?? '';
$filter = $_GET['location'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Count total matching properties
$count_sql = "SELECT COUNT(*) AS total FROM properties WHERE 1";
if (!empty($search)) $count_sql .= " AND title LIKE '%$search%'";
if (!empty($filter)) $count_sql .= " AND location = '$filter'";

$total_result = $conn->query($count_sql);
if (!$total_result) {
    die("Count query failed: " . $conn->error);
}
$total = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

// Get properties with owner info including phone
$sql = "SELECT properties.*, users.fullname, users.email AS owner_email, users.phone 
        FROM properties 
        JOIN users ON properties.user_id = users.id 
        WHERE 1";

if (!empty($search)) $sql .= " AND properties.title LIKE '%$search%'";
if (!empty($filter)) $sql .= " AND location = '$filter'";
$sql .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);
if (!$result) {
    die("Main query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Property Listings</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body { font-family: Arial; background: #f4f4f4; margin: 0; }
    header { background: #003366; color: white; padding: 20px; }
    nav ul { list-style: none; display: flex; gap: 20px; }
    nav ul li a { color: white; text-decoration: none; }
    .container { padding: 20px; }
    .property-card { background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); padding: 15px; margin-bottom: 20px; display: flex; gap: 15px; }
    .property-card img { width: 200px; height: 130px; object-fit: cover; border-radius: 5px; }
    .property-info { flex-grow: 1; }
    .pagination { text-align: center; margin-top: 20px; }
    .pagination a {
      margin: 0 5px;
      text-decoration: none;
      color: #003366;
      padding: 8px 12px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .pagination a.active {
      background: #003366;
      color: white;
    }
  </style>
</head>
<body>
  <header>
    <h1>Available Properties</h1>
    <nav>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.html">Owner Login</a></li>
      </ul>
    </nav>
  </header>

  <div class="container">
    <form method="GET" style="margin-bottom: 20px; display: flex; gap: 15px; align-items: center;">
      <input type="text" name="search" placeholder="Search by title..." value="<?= htmlspecialchars($search) ?>"
        style="padding: 8px; border: 1px solid #ccc; border-radius: 5px; width: 200px;">

      <select name="location" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        <option value="">All Locations</option>
        <option value="Nairobi" <?= $filter === 'Nairobi' ? 'selected' : '' ?>>Nairobi</option>
        <option value="Kiambu" <?= $filter === 'Kiambu' ? 'selected' : '' ?>>Kiambu</option>
        <option value="Thika" <?= $filter === 'Thika' ? 'selected' : '' ?>>Thika</option>
        <option value="Ruiru" <?= $filter === 'Ruiru' ? 'selected' : '' ?>>Ruiru</option>
      </select>

      <button type="submit" style="padding: 8px 15px; background-color: #003366; color: white; border: none; border-radius: 5px; cursor: pointer;">
        Search
      </button>
    </form>

    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="property-card">
          <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Property Image">
          <div class="property-info">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
            <p><strong>Price:</strong> KES <?= number_format($row['price']) ?></p>
            <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
            <p><strong>Contact Owner:</strong> <?= htmlspecialchars($row['fullname']) ?> (<?= htmlspecialchars($row['owner_email']) ?>)</p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></p>
          </div>
        </div>
      <?php endwhile; ?>

      <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <a href="?search=<?= urlencode($search) ?>&location=<?= urlencode($filter) ?>&page=<?= $i ?>" class="<?= ($i === $page) ? 'active' : '' ?>">
            <?= $i ?>
          </a>
        <?php endfor; ?>
      </div>
    <?php else: ?>
      <p>No properties found.</p>
    <?php endif; ?>
  </div>
</body>
</html>
