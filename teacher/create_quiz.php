<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];

    // ✅ Fixed SQL for PDO
    $sql = "INSERT INTO quizzes (course_id, teacher_id, title) VALUES (:course_id, :teacher_id, :title)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
    $stmt->bindParam(":teacher_id", $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    
    if ($stmt->execute()) {
        echo "<p>Quiz created successfully!</p>";
    } else {
        echo "<p>Error creating quiz.</p>";
    }
}

// ✅ Fixed course retrieval query for PDO
$sql = "SELECT * FROM courses WHERE teacher_id = :teacher_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":teacher_id", $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Quiz</title>
    <link rel="stylesheet" href="../assets/css/create_quiz.css">
</head>
<body>
    <h2>Create a New Quiz</h2>
    <form method="POST">
        <label>Select Course:</label>
        <select name="course_id" required>
            <?php foreach ($courses as $row): ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>Quiz Title:</label>
        <input type="text" name="title" required>
        <button type="submit">Create Quiz</button>
    </form>
    <a href="add_questions.php">add_questions</a>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
