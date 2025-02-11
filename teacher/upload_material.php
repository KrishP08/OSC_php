<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $course_id = $_POST['course_id'];
    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES["file"]["tmp_name"];
    $upload_dir = "../uploads/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_path = $upload_dir . basename($file_name);

    if (move_uploaded_file($file_tmp, $file_path)) {
        // ✅ Corrected query for uploading materials
        $sql = "INSERT INTO course_materials (course_id, file_name, file_path) VALUES (:course_id, :file_name, :file_path)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
        $stmt->bindParam(":file_name", $file_name, PDO::PARAM_STR);
        $stmt->bindParam(":file_path", $file_path, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<p>File uploaded successfully!</p>";
        } else {
            echo "<p>Error uploading file.</p>";
        }
    } else {
        echo "<p>Failed to upload file.</p>";
    }
}

// ✅ Fixed course retrieval query
$sql = "SELECT * FROM courses WHERE teacher_id = :teacher_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":teacher_id", $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Course Materials</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Upload Course Material</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Select Course:</label>
        <select name="course_id" required>
            <?php foreach ($courses as $row): ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['title']); ?>
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
