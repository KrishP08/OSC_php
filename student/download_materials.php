<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

// Fetch only course materials for enrolled courses
$sql = "SELECT course_materials.*, courses.title AS course_title 
        FROM course_materials
        JOIN courses ON course_materials.course_id = courses.id
        JOIN enrollments ON courses.id = enrollments.course_id
        WHERE enrollments.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$materials = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Download Course Materials</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Download Course Materials</h2>

    <?php if (count($materials) > 0): ?>
        <ul>
            <?php foreach ($materials as $row): ?>
                <li>
                    <strong><?php echo htmlspecialchars($row['course_title']); ?>:</strong>
                    <a href="<?php echo htmlspecialchars($row['file_path']); ?>" download>
                        <?php echo htmlspecialchars($row['file_name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No course materials available.</p>
    <?php endif; ?>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
