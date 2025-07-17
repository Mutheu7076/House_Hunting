<?php
include 'db.php';
session_start();

if (!isset($_SESSION['reset_email'])) {
    echo "Invalid session.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $email = $_SESSION['reset_email'];

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_password, $email);
    if ($stmt->execute()) {
        unset($_SESSION['reset_email']);
        echo "Password reset successful. <a href='login.html'>Login</a>";
        exit();
    } else {
        $error = "Failed to reset password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Set New Password</title></head>
<body>
    <h2>Enter New Password</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <input type="password" name="new_password" required placeholder="New Password"><br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>
