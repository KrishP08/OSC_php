<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

if (!isset($_GET['quiz_id'])) {
    header("Location: dashboard.php");
    exit();
}

$quiz_id = $_GET['quiz_id'];
$student_id = $_SESSION['user_id'];

$sql = "SELECT score, total_questions, percentage FROM quiz_results WHERE student_id = :student_id AND quiz_id = :quiz_id";
$stmt = $conn->prepare($sql);
$stmt->execute(['student_id' => $student_id, 'quiz_id' => $quiz_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    $message = "<p style='color:red;'>No results found for this quiz.</p>";
} else {
    $message = "
        <p>Score: {$result['score']} / {$result['total_questions']}</p>
        <p>Percentage: {$result['percentage']}%</p>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quiz Result</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Quiz Result</h2>
    <?php echo $message; ?>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
