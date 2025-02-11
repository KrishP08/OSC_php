<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

// Fetch all courses
$sql_courses = "SELECT id, title, description FROM courses";
$stmt = $conn->prepare($sql_courses);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch quizzes for enrolled courses
$sql_quizzes = "SELECT quizzes.id, quizzes.title, courses.title AS course_name,
        (SELECT COUNT(*) FROM quiz_results WHERE quiz_results.quiz_id = quizzes.id AND quiz_results.student_id = ?) AS attempted
        FROM quizzes
        JOIN courses ON quizzes.course_id = courses.id
        JOIN enrollments ON courses.id = enrollments.course_id
        WHERE enrollments.student_id = ?";

$stmt = $conn->prepare($sql_quizzes);
$stmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../assets/css/sdashboard.css">
</head>
<body>
    <h2>Welcome, Student</h2>
    <ul>
        <li><a href="view_courses.php">View & Enroll in Courses</a></li>
        <li><a href="download_materials.php">Download Materials</a></li>
        <li><a href="course_videos.php">View Video</a></li>
        <li><a href="attempt_quiz.php">Attempt Quiz</a></li>
        <li><a href="upload_assignment.php">Upload Assignment</a></li>
        <li><a href="live_lectures.php">Live Lectures</a></li>
        <li><a href="view_grades.php">View Grades</a></li>
        <li><a href="../public/logout.php">Logout</a></li>
    </ul>

    <h2>Your Courses</h2>
    <ul>
        <?php foreach ($courses as $course): ?>
            <li>
                <strong><?php echo htmlspecialchars($course['title']); ?></strong> - 
                <?php echo htmlspecialchars($course['description']); ?>
                <a href="course_details.php?course_id=<?php echo $course['id']; ?>">View Course</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Available Quizzes</h2>
    <table border="1">
        <tr>
            <th>Quiz Title</th>
            <th>Course</th>
            <th>Action</th>
        </tr>
        <?php foreach ($quizzes as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                <td>
                    <?php if ($row['attempted'] > 0): ?>
                        <button disabled>Attempted</button>
                    <?php else: ?>
                        <a href="attempt_quiz.php?quiz_id=<?php echo $row['id']; ?>">Take Quiz</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
