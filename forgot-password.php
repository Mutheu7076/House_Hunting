<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - HomeFinder</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body.light-mode {
      background: url('background.jpg') no-repeat center center fixed;
      background-size: cover;
      color: #000;
      font-family: Arial, sans-serif;
    }
    body.dark-mode {
      background-color: #121212;
      color: #e0e0e0;
      font-family: Arial, sans-serif;
    }
    .login-box {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      padding: 30px;
      max-width: 400px;
      margin: 100px auto;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
    .login-box.dark-mode {
      background-color: rgba(30, 30, 30, 0.9);
    }
    input[type=email], input[type=password], button {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      background-color: #0d6efd;
      color: white;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background-color: #0b5ed7;
    }
    .toggle-mode {
      position: absolute;
      top: 15px;
      right: 15px;
      padding: 5px 10px;
      cursor: pointer;
      border-radius: 5px;
      background-color: #eee;
    }
    body.dark-mode .toggle-mode {
      background-color: #333;
      color: white;
      border: 1px solid #666;
    }
  </style>
  <script>
    function toggleMode() {
      const body = document.body;
      const isDark = body.classList.toggle('dark-mode');
      body.classList.toggle('light-mode', !isDark);
      localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }

    window.onload = () => {
      const saved = localStorage.getItem('theme') || 'light';
      document.body.classList.add(saved + '-mode');
    };
  </script>
</head>
<body>
  <div class="toggle-mode" onclick="toggleMode()">🌓 Toggle Mode</div>

  <div class="login-box">
    <h2>Login to Your Account</h2>
    <form action="login.php" method="POST">
      <label for="email">Email:</label><br>
      <input type="email" id="email" name="email" required><br>

      <label for="password">Password:</label><br>
      <input type="password" id="password" name="password" required><br>

      <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.html">Register here</a></p>
    <p>Or <a href="listings.php">View Listings without logging in</a></p>
  </div>

  <footer style="text-align: center; margin-top: 40px; color: inherit">
    <p>&copy; 2025 HomeFinder. All rights reserved.</p>
  </footer>
</body>
</html>
