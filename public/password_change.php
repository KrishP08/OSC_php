<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $message = "New password and confirm password do not match.";
    } else {
        // Fetch current password from DB
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $stored_hash = $stmt->fetchColumn();

        if (password_verify($current_password, $stored_hash)) {
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

            // Update password
            $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update->execute([$new_hash, $user_id]);
            $message = "Password changed successfully.";
        } else {
            $message = "Current password is incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
        form { background: #fff; padding: 20px; border-radius: 5px; max-width: 400px; margin: auto; }
        input[type="password"], input[type="submit"] {
            width: 100%; padding: 10px; margin: 8px 0; box-sizing: border-box;
        }
        .message { text-align: center; margin-bottom: 15px; color: red; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Change Password</h2>
        <div class="message"><?= htmlspecialchars($message) ?></div>
        <label>Current Password:</label>
        <input type="password" name="current_password" required>

        <label>New Password:</label>
        <input type="password" name="new_password" required>

        <label>Confirm New Password:</label>
        <input type="password" name="confirm_password" required>

        <input type="submit" value="Change Password">
    </form>
</body>
</html>
