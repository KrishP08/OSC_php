<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

// Fetch courses the student is enrolled in
$sql = "SELECT c.id, c.title FROM courses c
        JOIN enrollments e ON c.id = e.course_id
        WHERE e.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if a course is selected
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
$videos = [];

if ($course_id) {
    // Fetch course videos for the selected course
    $sql = "SELECT * FROM course_videos WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$course_id]);
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Course Videos</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script>
        function selectCourse(courseId) {
            if (courseId) {
                window.location.href = 'course_videos.php?course_id=' + courseId;
            }
        }
    </script>
</head>
<body>
    <h2>Select a Course</h2>

    <label for="courseSelect">Choose a Course:</label>
    <select id="courseSelect" onchange="selectCourse(this.value)">
        <option value="">-- Select Course --</option>
        <?php foreach ($courses as $course): ?>
            <option value="<?php echo htmlspecialchars($course['id']); ?>" 
                <?php echo ($course['id'] == $course_id) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($course['title']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <?php if ($course_id): ?>
        <h2>Videos for "<?php echo htmlspecialchars($courses[array_search($course_id, array_column($courses, 'id'))]['title']); ?>"</h2>

        <?php if (count($videos) > 0): ?>
            <?php foreach ($videos as $video): ?>
                <div>
                    <h3><?php echo htmlspecialchars($video['title']); ?></h3>
                    <video width="640" height="360" controls>
                        <source src="../<?php echo htmlspecialchars($video['video_path']); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No videos available for this course.</p>
        <?php endif; ?>
    <?php endif; ?>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
