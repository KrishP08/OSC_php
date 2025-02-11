<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quiz_id = $_POST['quiz_id'];
    $question_text = $_POST['question_text'];
    $correct_option = $_POST['correct_option'];
    $options = $_POST['options'];

    // ✅ Fixed SQL for PDO
    $sql = "INSERT INTO questions (quiz_id, question_text, correct_option) VALUES (:quiz_id, :question_text, :correct_option)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":quiz_id", $quiz_id, PDO::PARAM_INT);
    $stmt->bindParam(":question_text", $question_text, PDO::PARAM_STR);
    $stmt->bindParam(":correct_option", $correct_option, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        $question_id = $conn->lastInsertId(); // ✅ Corrected insert_id for PDO
        
        foreach ($options as $key => $option_text) {
            $sql = "INSERT INTO options (question_id, option_text, option_number) VALUES (:question_id, :option_text, :option_number)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":question_id", $question_id, PDO::PARAM_INT);
            $stmt->bindParam(":option_text", $option_text, PDO::PARAM_STR);
            $stmt->bindParam(":option_number", $option_number, PDO::PARAM_INT);
            $option_number = $key + 1; // Fix option numbering
            $stmt->execute();
        }
        echo "<p>Question added successfully!</p>";
    } else {
        echo "<p>Error adding question.</p>";
    }
}

// ✅ Fixed quiz retrieval query for PDO
$sql = "SELECT * FROM quizzes WHERE teacher_id = :teacher_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":teacher_id", $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Questions</title>
    <link rel="stylesheet" href="../assets/css/add_questions.css">
</head>
<body>
    <h2>Add Questions to Quiz</h2>
    <form method="POST">
        <label>Select Quiz:</label>
        <select name="quiz_id" required>
            <?php foreach ($quizzes as $row): ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>Question:</label>
        <textarea name="question_text" required></textarea>
        <label>Options:</label>
        <input type="text" name="options[]" required placeholder="Option 1">
        <input type="text" name="options[]" required placeholder="Option 2">
        <input type="text" name="options[]" required placeholder="Option 3">
        <input type="text" name="options[]" required placeholder="Option 4">
        <label>Correct Option (1-4):</label>
        <input type="number" name="correct_option" min="1" max="4" required>
        <button type="submit">Add Question</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
