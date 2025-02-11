<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit();
}

$teacher_id = $_SESSION['user_id'];

try {
    // ✅ Fetch quizzes created by the teacher
    $sql = "SELECT id, title FROM quizzes WHERE teacher_id = :teacher_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":teacher_id", $teacher_id, PDO::PARAM_INT);
    $stmt->execute();
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // ✅ Get quiz_id if selected
    $quiz_id = isset($_GET['quiz_id']) && is_numeric($_GET['quiz_id']) ? (int)$_GET['quiz_id'] : null;
    
    $results = [];
    if ($quiz_id) {
        //  Fetch quiz results if a quiz is selected
        $sql = "SELECT users.name, quiz_results.score, quiz_results.total_questions, quiz_results.percentage
                FROM quiz_results
                JOIN users ON quiz_results.student_id = users.id
                WHERE quiz_results.quiz_id = :quiz_id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":quiz_id", $quiz_id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quiz Results</title>
    <link rel="stylesheet" href="../assets/css/quiz_results.css">
</head>
<body>
    <h2>Quiz Results</h2>

    <!-- Quiz Selection Form -->
    <form method="GET">
        <label>Select Quiz:</label>
        <select name="quiz_id" onchange="this.form.submit()">
            <option value="">-- Select a Quiz --</option>
            <?php foreach ($quizzes as $quiz): ?>
                <option value="<?php echo $quiz['id']; ?>" <?php echo ($quiz_id == $quiz['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($quiz['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Display results only if a quiz is selected -->
    <?php if ($quiz_id): ?>
        <?php if (count($results) > 0): ?>
            <table border="1">
                <tr>
                    <th>Student Name</th>
                    <th>Score</th>
                    <th>Total Questions</th>
                    <th>Percentage</th>
                </tr>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['score']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_questions']); ?></td>
                        <td><?php echo htmlspecialchars($row['percentage']); ?>%</td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No results available for this quiz.</p>
        <?php endif; ?>
    <?php endif; ?>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
