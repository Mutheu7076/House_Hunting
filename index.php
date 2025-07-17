<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to House Hunter</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #003366, #005580);
      color: white;
      text-align: center;
      margin: 0;
      padding: 0;
    }
    .container {
      padding: 60px 20px;
      max-width: 600px;
      margin: auto;
    }
    h1 {
      font-size: 2.5rem;
      margin-bottom: 10px;
    }
    p {
      font-size: 1.2rem;
      margin-bottom: 40px;
    }
    .buttons {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    .buttons a {
      background: white;
      color: #003366;
      text-decoration: none;
      padding: 15px;
      border-radius: 8px;
      font-weight: bold;
      transition: background 0.3s;
    }
    .buttons a:hover {
      background: #f1f1f1;
    }
    footer {
      margin-top: 60px;
      font-size: 0.9rem;
      color: #ccc;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome to House Hunter</h1>
    <p>Find your dream house or manage your property listings easily.</p>
    <div class="buttons">
      <a href="login.html">I'm a Property Owner – Log In</a>
      <a href="home-viewer.php">I'm Looking for a House – Browse Listings</a>
    </div>
    <footer>
      &copy; <?= date("Y") ?> House Hunter. All rights reserved.
    </footer>
  </div>
</body>
</html>
