<?php
session_start();
require_once "../config/db.php";

if ($_SESSION['role'] !== 'admin') {
    die("Access denied.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['id'];
    $new_password = $_POST['new_password'];

    if (!empty($user_id) && !empty($new_password)) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed, $user_id]);
        $message = "Password has been reset.";
    } else {
        $message = "All fields are required.";
    }
}

// Fetch users for dropdown
$users = $conn->query("SELECT id,name FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset User Password</title>
</head>
<body>
    <h2>Reset User Password</h2>
    <p style="color:red;"><?= $message ?></p>
    <form method="POST">
        <label>Select User:</label>
        <select name="user_id" required>
            <option value="">-- Choose --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>New Password:</label>
        <input type="text" name="new_password" required><br><br>

        <input type="submit" value="Reset Password">
    </form>
</body>
</html>