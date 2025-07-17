<?php
include 'db.php'; // Ensure this file connects to your DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $message = trim($_POST['message']);

  if (!empty($name) && !empty($email) && !empty($message)) {
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
      echo "Thank you! Your message has been sent.";
    } else {
      echo "Something went wrong. Please try again later.";
    }

    $stmt->close();
  } else {
    echo "All fields are required.";
  }
}
?>
