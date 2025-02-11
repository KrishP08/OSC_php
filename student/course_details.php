<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

if (!isset($_GET['course_id'])) {
    die("Course not found.");
}

$course_id = $_GET['course_id'];

// Check if student is enrolled in this course
$sql_check = "SELECT COUNT(*) FROM enrollments WHERE student_id = ? AND course_id = ?";
$stmt = $conn->prepare($sql_check);
$stmt->execute([$_SESSION['user_id'], $course_id]);
$is_enrolled = $stmt->fetchColumn();

if (!$is_enrolled) {
    die("You are not enrolled in this course.");
}

// Fetch course details
$sql = "SELECT title, description FROM courses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$course_id]);
$course = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch live lectures
$sql_lectures = "SELECT title, meeting_link, scheduled_at FROM live_lectures WHERE course_id = ?";
$stmt = $conn->prepare($sql_lectures);
$stmt->execute([$course_id]);
$lectures = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch course materials
$sql_materials = "SELECT file_name, file_path FROM course_materials WHERE course_id = ?";
$stmt = $conn->prepare($sql_materials);
$stmt->execute([$course_id]);
$materials = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch quizzes
$sql_quizzes = "SELECT id, title FROM quizzes WHERE course_id = ?";
$stmt = $conn->prepare($sql_quizzes);
$stmt->execute([$course_id]);
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch course videos
$sql_videos = "SELECT title, video_path FROM course_videos WHERE course_id = ?";
$stmt = $conn->prepare($sql_videos);
$stmt->execute([$course_id]);
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch assignments
$sql_assignments = "SELECT id, title, due_date FROM assignments WHERE course_id = ?";
$stmt = $conn->prepare($sql_assignments);
$stmt->execute([$course_id]);
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($course['title']); ?> - Course Details</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2><?php echo htmlspecialchars($course['title']); ?></h2>
    <p><?php echo htmlspecialchars($course['description']); ?></p>

    <h3>Live Lectures</h3>
    <?php if (!empty($lectures)): ?>
        <ul>
            <?php foreach ($lectures as $lecture): ?>
                <li>
                    <strong><?php echo htmlspecialchars($lecture['title']); ?></strong> - 
                    <a href="<?php echo $lecture['meeting_link']; ?>" target="_blank">Join Lecture</a> at 
                    <?php echo $lecture['scheduled_at']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No live lectures scheduled.</p>
    <?php endif; ?>

    <h3>Course Materials</h3>
    <?php if (!empty($materials)): ?>
        <ul>
            <?php foreach ($materials as $material): ?>
                <li>
                    <a href="<?php echo $material['file_path']; ?>" download>
                        <?php echo htmlspecialchars($material['file_name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No course materials available.</p>
    <?php endif; ?>

    <h3>Quizzes</h3>
    <?php if (!empty($quizzes)): ?>
        <ul>
            <?php foreach ($quizzes as $quiz): ?>
                <li>
                    <a href="attempt_quiz.php?quiz_id=<?php echo $quiz['id']; ?>">
                        <?php echo htmlspecialchars($quiz['title']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No quizzes available.</p>
    <?php endif; ?>

    <h3>Course Videos</h3>
    <?php if (!empty($videos)): ?>
        <ul>
            <?php foreach ($videos as $video): ?>
                <li>
                    <h4><?php echo htmlspecialchars($video['title']); ?></h4>
                    <video width="640" height="360" controls>
                        <source src="<?php echo htmlspecialchars($video['video_path']); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No videos available.</p>
    <?php endif; ?>

    <h3>Assignments</h3>
    <?php if (!empty($assignments)): ?>
        <ul>
            <?php foreach ($assignments as $assignment): ?>
                <li>
                    <a href="submit_assignment.php?assignment_id=<?php echo $assignment['id']; ?>">
                        <?php echo htmlspecialchars($assignment['title']); ?>
                    </a> - Due: <?php echo $assignment['due_date']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No assignments available.</p>
    <?php endif; ?>

    <h3>Discussion Forum</h3>
    <p><a href="discussion_forum.php?course_id=<?php echo $course_id; ?>">Join the Discussion</a></p>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
