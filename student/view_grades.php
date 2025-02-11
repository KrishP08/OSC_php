<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

$student_id = $_SESSION['user_id'];

// Fetch quiz results
$sql = "SELECT quiz_results.*, quizzes.title AS quiz_title, courses.title AS course_title
        FROM quiz_results
        JOIN quizzes ON quiz_results.quiz_id = quizzes.id
        JOIN courses ON quizzes.course_id = courses.id
        WHERE quiz_results.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$student_id]);
$quiz_grades = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch assignment grades
$sql = "SELECT assignments.title AS assignment_title, courses.title AS course_title, 
               submissions.grade, submissions.feedback
        FROM submissions
        JOIN assignments ON submissions.assignment_id = assignments.id
        JOIN courses ON assignments.course_id = courses.id
        WHERE submissions.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$student_id]);
$assignment_grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Grades</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>My Grades</h2>

    <h3>Quiz Results</h3>
    <?php if (count($quiz_grades) > 0): ?>
        <table border="1">
            <tr>
                <th>Course</th>
                <th>Quiz</th>
                <th>Score</th>
                <th>Percentage</th>
            </tr>
            <?php foreach ($quiz_grades as $quiz): ?>
                <tr>
                    <td><?php echo htmlspecialchars($quiz['course_title']); ?></td>
                    <td><?php echo htmlspecialchars($quiz['quiz_title']); ?></td>
                    <td><?php echo $quiz['score'] . " / " . $quiz['total_questions']; ?></td>
                    <td><?php echo $quiz['percentage']; ?>%</td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No quiz grades available.</p>
    <?php endif; ?>

    <h3>Assignment Grades</h3>
    <?php if (count($assignment_grades) > 0): ?>
        <table border="1">
            <tr>
                <th>Course</th>
                <th>Assignment</th>
                <th>Grade</th>
                <th>Feedback</th>
            </tr>
            <?php foreach ($assignment_grades as $assignment): ?>
                <tr>
                    <td><?php echo htmlspecialchars($assignment['course_title']); ?></td>
                    <td><?php echo htmlspecialchars($assignment['assignment_title']); ?></td>
                    <td><?php echo $assignment['grade'] !== null ? $assignment['grade'] : 'Not Graded'; ?></td>
                    <td><?php echo !empty($assignment['feedback']) ? htmlspecialchars($assignment['feedback']) : 'No Feedback'; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No assignment grades available.</p>
    <?php endif; ?>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
