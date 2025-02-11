<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

$message = ""; // Store success or error messages

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $assignment_id = $_POST['assignment_id'];
    $student_id = $_SESSION['user_id'];
    $file_name = basename($_FILES["file"]["name"]);
    $file_tmp = $_FILES["file"]["tmp_name"];
    $upload_dir = "../uploads/";

    // Ensure the upload directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Save only the relative file path
    $relative_path = "uploads/" . $file_name;
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($file_tmp, $file_path)) {
        // Insert into the database using PDO
        $sql = "INSERT INTO submissions (assignment_id, student_id, file_name, file_path) 
                VALUES (:assignment_id, :student_id, :file_name, :file_path)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'assignment_id' => $assignment_id,
            'student_id' => $student_id,
            'file_name' => $file_name,
            'file_path' => $relative_path
        ]);

        if ($stmt) {
            $message = "<p style='color:green;'>Assignment submitted successfully!</p>";
        } else {
            $message = "<p style='color:red;'>Error submitting assignment.</p>";
        }
    } else {
        $message = "<p style='color:red;'>Failed to upload file.</p>";
    }
}

// Fetch assignments using PDO
$sql = "SELECT assignments.id, assignments.title, courses.title AS course_title 
        FROM assignments 
        JOIN courses ON assignments.course_id = courses.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Assignment</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Upload Assignment</h2>
    <?php echo $message; ?>
    <form method="POST" enctype="multipart/form-data">
        <label>Select Assignment:</label>
        <select name="assignment_id" required>
            <?php foreach ($assignments as $row): ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['course_title']); ?> - <?php echo htmlspecialchars($row['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>Select File:</label>
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
