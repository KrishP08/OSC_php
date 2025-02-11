<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

// Fetch courses that the student is NOT enrolled in
$sql = "SELECT id, title, description 
        FROM courses 
        WHERE id NOT IN (SELECT course_id FROM enrollments WHERE student_id = ?)";
$stmt = $conn->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle enrollment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    $enroll_sql = "INSERT INTO enrollments (student_id, course_id) VALUES (?, ?)";
    $stmt = $conn->prepare($enroll_sql);
    if ($stmt->execute([$_SESSION['user_id'], $course_id])) {
        echo "<p>Successfully enrolled in the course! <a href='dashboard.php'>Go to Dashboard</a></p>";
    } else {
        echo "<p>Error enrolling in the course.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Enroll in Courses</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Available Courses</h2>
    <ul>
        <?php foreach ($courses as $course): ?>
            <li>
                <strong><?php echo htmlspecialchars($course['title']); ?></strong> - 
                <?php echo htmlspecialchars($course['description']); ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                    <button type="submit">Enroll</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
