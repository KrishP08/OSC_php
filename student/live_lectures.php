<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

// Fetch upcoming live lectures using PDO
$sql = "SELECT live_lectures.*, courses.title as course_title 
        FROM live_lectures 
        JOIN courses ON live_lectures.course_id = courses.id 
        WHERE live_lectures.scheduled_at >= NOW() 
        ORDER BY live_lectures.scheduled_at ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$lectures = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Live Lectures</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Upcoming Live Lectures</h2>
    <?php if (count($lectures) > 0): ?>
        <ul>
            <?php foreach ($lectures as $lecture): ?>
                <li>
                    <strong><?php echo htmlspecialchars($lecture['course_title']); ?> - <?php echo htmlspecialchars($lecture['title']); ?></strong>
                    <p>Scheduled At: <?php echo htmlspecialchars($lecture['scheduled_at']); ?></p>
                    <a href="<?php echo htmlspecialchars($lecture['meeting_link']); ?>" target="_blank">Join Lecture</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No upcoming lectures.</p>
    <?php endif; ?>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
