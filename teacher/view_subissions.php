<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit();
}

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // ✅ Validate submission_id
        if (!isset($_POST['submission_id']) || !is_numeric($_POST['submission_id'])) {
            die("Invalid submission ID.");
        }
        $submission_id = (int)$_POST['submission_id'];
        $grade = trim($_POST['grade']);
        $feedback = trim($_POST['feedback']);

        // ✅ Update submission grade and feedback
        $sql = "UPDATE submissions SET grade = :grade, feedback = :feedback WHERE id = :submission_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":grade", $grade, PDO::PARAM_STR);
        $stmt->bindParam(":feedback", $feedback, PDO::PARAM_STR);
        $stmt->bindParam(":submission_id", $submission_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<p>Assignment graded successfully!</p>";
        } else {
            echo "<p>Error grading assignment.</p>";
        }
    }

    // ✅ Fetch submissions using PDO
    $sql = "SELECT submissions.*, users.name, assignments.title 
            FROM submissions 
            JOIN users ON submissions.student_id = users.id 
            JOIN assignments ON submissions.assignment_id = assignments.id";
    $stmt = $conn->query($sql);
    $submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Submissions</title>
    <link rel="stylesheet" href="../assets/css/submissions.css">
</head>
<body>
    <h2>View Submissions</h2>
    <?php if (count($submissions) > 0): ?>
        <ul>
            <?php foreach ($submissions as $row): ?>
                <li>
                    <strong><?php echo htmlspecialchars($row['name']); ?></strong> 
                    submitted <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                    
                    <!-- ✅ Validate and provide download link -->
                    <?php if (!empty($row['file_path']) && file_exists("../uploads/" . $row['file_path'])): ?>
                        <a href="../uploads/<?php echo htmlspecialchars($row['file_path']); ?>" download>Download</a>
                    <?php else: ?>
                        <span style="color: red;">File not available</span>
                    <?php endif; ?>

                    <form method="POST">
                        <input type="hidden" name="submission_id" value="<?php echo (int)$row['id']; ?>">
                        <label>Grade:</label>
                        <input type="text" name="grade" required>
                        <label>Feedback:</label>
                        <textarea name="feedback"></textarea>
                        <button type="submit">Submit Grade</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No submissions available.</p>
    <?php endif; ?>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
