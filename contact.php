<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us - HomeFinder</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }

    .navbar-brand {
      font-weight: bold;
      color: #007bff;
    }

    .form-container {
      max-width: 600px;
      margin: 60px auto;
      padding: 30px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    footer {
      margin-top: 100px;
      text-align: center;
      padding: 20px;
      background: #f1f1f1;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="dashboard.php">
        <img src="https://img.icons8.com/color/48/000000/home--v1.png" width="30" /> HomeFinder
      </a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="add-property.php">Add Property</a></li>
          <li class="nav-item"><a class="nav-link" href="listings.php">Listings</a></li>
          <li class="nav-item"><a class="nav-link active" href="contact.php">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Contact Form -->
  <div class="form-container">
    <h3 class="text-center mb-4">Contact Us</h3>
    <form action="contact-handler.php" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Your Name</label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Your Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="message" class="form-label">Your Message</label>
        <textarea name="message" class="form-control" rows="5" required></textarea>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Send Message</button>
      </div>
    </form>
  </div>

  <!-- Footer -->
  <footer>
    <p>&copy; <?php echo date("Y"); ?> HomeFinder. All rights reserved.</p>
  </footer>

</body>
</html>
