<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - HomeFinder</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body.light-mode {
      background-color: #f8fafc;
      color: #000;
    }
    body.dark-mode {
      background-color: #121212;
      color: #e0e0e0;
    }
    nav {
      background-color: #0d6efd;
      padding: 10px 30px;
    }
    nav.dark-mode {
      background-color: #1e1e2f;
    }
    nav ul {
      list-style: none;
      display: flex;
      justify-content: flex-end;
      margin: 0;
      padding: 0;
    }
    nav ul li {
      margin-left: 20px;
    }
    nav ul li a {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
    }
    .logo {
      color: #0d6efd;
      font-weight: bold;
      font-size: 24px;
      display: inline-block;
      padding: 15px 30px;
    }
    .dashboard {
      text-align: center;
      padding: 60px 20px;
    }
    .dashboard h2 {
      font-size: 32px;
      margin-bottom: 10px;
    }
    .dashboard p {
      font-size: 18px;
      margin-bottom: 30px;
    }
    .dashboard .btn {
      margin: 10px;
      font-size: 16px;
      padding: 10px 20px;
    }
    footer {
      text-align: center;
      padding: 20px 0;
      background-color: #f1f1f1;
      margin-top: 40px;
    }
    footer.dark-mode {
      background-color: #1f1f1f;
      color: #ccc;
    }
    .contact-section {
      background-color: #f0f4f8;
      padding: 30px 20px;
      margin: 40px 15px 0 15px;
      border-radius: 10px;
      text-align: center;
    }
    .contact-section.dark-mode {
      background-color: #1f1f1f;
      color: #ccc;
    }
    .contact-section a {
      color: #0d6efd;
      text-decoration: none;
      font-weight: 500;
    }
    .mode-toggle {
      position: absolute;
      right: 20px;
      top: 15px;
      background: #fff;
      color: #333;
      border: none;
      padding: 6px 12px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 500;
    }
    body.dark-mode .mode-toggle {
      background: #333;
      color: #fff;
      border: 1px solid #666;
    }
  </style>

  <script>
    function toggleMode() {
      const body = document.body;
      const isDark = body.classList.toggle('dark-mode');
      body.classList.toggle('light-mode', !isDark);
      localStorage.setItem('theme', isDark ? 'dark' : 'light');

      document.querySelector('nav')?.classList.toggle('dark-mode', isDark);
      document.querySelector('.contact-section')?.classList.toggle('dark-mode', isDark);
      document.querySelector('footer')?.classList.toggle('dark-mode', isDark);
    }

    window.onload = () => {
      const saved = localStorage.getItem('theme') || 'light';
      document.body.classList.add(saved + '-mode');
      if (saved === 'dark') {
        document.querySelector('nav')?.classList.add('dark-mode');
        document.querySelector('.contact-section')?.classList.add('dark-mode');
        document.querySelector('footer')?.classList.add('dark-mode');
      }
    };
  </script>
</head>
<body>
  <button class="mode-toggle" onclick="toggleMode()">🌓 Toggle Mode</button>

  <header>
    <div class="logo">🏠 HomeFinder</div>
    <nav>
      <ul>
        <li><a href="add-property.html">Add Property</a></li>
        <li><a href="listings.php">View Listings</a></li>
        <li><a href="my-properties.php">My Properties</a></li>
        <li><a href="change-password.php">Change Password</a></li>
        <li><a href="contact.html">Contact Us</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <main class="dashboard">
    <h2>Welcome to HomeFinder Dashboard</h2>
    <p>Hello, <strong><?php echo htmlspecialchars($email); ?></strong>! What would you like to do today?</p>

    <a href="add-property.html" class="btn btn-primary">➕ Add New Property</a>
    <a href="listings.php" class="btn btn-outline-primary">🏠 View Listings</a>
    <a href="my-properties.php" class="btn btn-primary">📁 My Properties</a>
  </main>

  <section class="contact-section">
    <h3>Contact Us</h3>
    <p>If you have questions, feedback, or need help, feel free to reach out:</p>
    <p>Email us at: <a href="mailto:assumptajay@gmail.com">assumptajay@gmail.com</a></p>
  </section>

  <footer>
    © 2025 HomeFinder. All rights reserved.
  </footer>
</body>
</html>
