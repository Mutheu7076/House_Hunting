<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['email'])) {
  header("Location: login.html");
  exit();
}

// Fetch all messages from database
$sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Messages</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h2>Contact Messages</h2> 
  <a href="dashboard.php">← Back to Dashboard</a><br><br>

  <?php if ($result && $result->num_rows > 0): ?>
    <table border="1" cellpadding="10">
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Reply</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo htmlspecialchars($row['email']); ?></td>
          <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
          <td>
            <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>?subject=Reply to your message&body=Hi <?php echo urlencode($row['name']); ?>,%0D%0A%0D%0AYour message: <?php echo urlencode($row['message']); ?>%0D%0A%0D%0AReply here...">
              Reply
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p>No messages found.</p>
  <?php endif; ?>
</body>
</html>
