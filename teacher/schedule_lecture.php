<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $meeting_link = $_POST['meeting_link'];
    $scheduled_at = $_POST['scheduled_at'];

    // ✅ Fixed SQL for PDO
    $sql = "INSERT INTO live_lectures (course_id, teacher_id, title, meeting_link, scheduled_at) 
            VALUES (:course_id, :teacher_id, :title, :meeting_link, :scheduled_at)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
    $stmt->bindParam(":teacher_id", $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt->bindParam(":meeting_link", $meeting_link, PDO::PARAM_STR);
    $stmt->bindParam(":scheduled_at", $scheduled_at, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "<p>Lecture scheduled successfully!</p>";
    } else {
        echo "<p>Error scheduling lecture.</p>";
    }
}

// ✅ Fetching courses using PDO
$sql = "SELECT * FROM courses WHERE teacher_id = :teacher_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":teacher_id", $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Schedule Live Lecture</title>
    <link rel="stylesheet" href="../assets/css/schedule_lecture.css">
</head>
<body>
    <h2>Schedule Live Lecture</h2>
    <form method="POST">
        <label>Select Course:</label>
        <select name="course_id" required>
            <?php foreach ($courses as $row): ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>Lecture Title:</label>
        <input type="text" name="title" required>
        <label>Meeting Link:</label>
        <input type="url" name="meeting_link" required>
        <label>Schedule Date & Time:</label>
        <input type="datetime-local" name="scheduled_at" required>
        <button type="submit">Schedule</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
