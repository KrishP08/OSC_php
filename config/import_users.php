<?php
session_start();
require_once "../config/db.php";
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Access control (optional)
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES['excel_file'])) {
    $file = $_FILES['excel_file']['tmp_name'];

    try {
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $imported = 0;
        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // skip header row

            [$name, $email, $password, $role] = $row;

            // Basic validation
            if (!$name || !$email || !$password || !$role) continue;

            // Hash the password (recommended)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $email, $hashedPassword, $role]);

            $imported++;
        }

        $success_message = "$imported users imported successfully.";
    } catch (Exception $e) {
        $error_message = "Error reading the file: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Import Users</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2rem; }
        .message { margin: 1rem 0; padding: 10px; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<h2>Import Users from Excel</h2>

<?php if ($success_message): ?>
    <div class="message success"><?php echo htmlspecialchars($success_message); ?></div>
<?php endif; ?>
<?php if ($error_message): ?>
    <div class="message error"><?php echo htmlspecialchars($error_message); ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <label>Select Excel File (.xlsx):</label><br>
    <input type="file" name="excel_file" accept=".xlsx" required><br><br>
    <button type="submit">Import Users</button>
</form>

<p><a href="template_users.xlsx" download>Download Excel Template</a></p>

</body>
</html>