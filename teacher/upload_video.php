<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit();
}

$message = ""; // To store messages for debugging

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["video"])) {
    $course_id = $_POST['course_id'];
    $video_title = $_POST['video_title'];
    $video_name = basename($_FILES["video"]["name"]);
    $video_tmp = $_FILES["video"]["tmp_name"];
    $upload_dir = "../uploads/videos/";

    // Ensure upload directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Set file path
    $video_path = $upload_dir . $video_name;
    $allowed_formats = ["mp4", "webm", "avi"];
    $file_extension = strtolower(pathinfo($video_path, PATHINFO_EXTENSION));

    if (!in_array($file_extension, $allowed_formats)) {
        $message = "<p style='color:red;'>Invalid file format. Only MP4, WebM, or AVI allowed.</p>";
    } elseif (move_uploaded_file($video_tmp, $video_path)) {
        // Store only the relative path (not full server path)
        $relative_path = "uploads/videos/" . $video_name;

        // Insert video details into course_videos table
        $sql = "INSERT INTO course_videos (course_id, title, video_path) VALUES (:course_id, :title, :video_path)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
        $stmt->bindParam(":title", $video_title, PDO::PARAM_STR);
        $stmt->bindParam(":video_path", $relative_path, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $message = "<p style='color:green;'>Video uploaded successfully!</p>";
        } else {
            $message = "<p style='color:red;'>Database insertion failed.</p>";
        }
    } else {
        $message = "<p style='color:red;'>Failed to upload video.</p>";
    }
}

// Fetch courses taught by the teacher
$sql = "SELECT * FROM courses WHERE teacher_id = :teacher_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":teacher_id", $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Course Videos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Upload Course Video</h2>
    <?php echo $message; ?> <!-- Show success or error message -->
    <form method="POST" enctype="multipart/form-data">
        <label>Select Course:</label>
        <select name="course_id" required>
            <?php foreach ($courses as $row): ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>Video Title:</label>
        <input type="text" name="video_title" required>
        <label>Select Video:</label>
        <input type="file" name="video" accept=".mp4, .webm, .avi" required>
        <button type="submit">Upload</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
