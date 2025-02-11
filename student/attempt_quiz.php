<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

// Fetch courses the student is enrolled in
$sql = "SELECT c.id, c.title FROM courses c
        JOIN enrollments e ON c.id = e.course_id
        WHERE e.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get selected course & quiz
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
$quiz_id = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;
$quizzes = [];
$questions = [];

// Fetch quizzes for the selected course
if ($course_id) {
    $sql = "SELECT * FROM quizzes WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$course_id]);
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch questions for the selected quiz
if ($quiz_id) {
    $sql = "SELECT * FROM questions WHERE quiz_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$quiz_id]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Attempt Quiz</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script>
        function selectCourse(courseId) {
            if (courseId) {
                window.location.href = 'attempt_quiz.php?course_id=' + courseId;
            }
        }
        
        function selectQuiz(quizId) {
            if (quizId) {
                window.location.href = 'attempt_quiz.php?course_id=' + <?php echo json_encode($course_id); ?> + '&quiz_id=' + quizId;
            }
        }
    </script>
</head>
<body>
    <h2>Attempt Quiz</h2>

    <!-- Course Selection -->
    <label for="courseSelect">Choose a Course:</label>
    <select id="courseSelect" onchange="selectCourse(this.value)">
        <option value="">-- Select Course --</option>
        <?php foreach ($courses as $course): ?>
            <option value="<?php echo htmlspecialchars($course['id']); ?>" 
                <?php echo ($course['id'] == $course_id) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($course['title']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Quiz Selection (if course is selected) -->
    <?php if ($course_id): ?>
        <label for="quizSelect">Choose a Quiz:</label>
        <select id="quizSelect" onchange="selectQuiz(this.value)">
            <option value="">-- Select Quiz --</option>
            <?php foreach ($quizzes as $quiz): ?>
                <option value="<?php echo htmlspecialchars($quiz['id']); ?>" 
                    <?php echo ($quiz['id'] == $quiz_id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($quiz['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>

    <!-- Quiz Form (if a quiz is selected) -->
    <?php if ($quiz_id): ?>
        <form method="POST" action="submit_quiz.php">
            <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
            <?php foreach ($questions as $question): ?>
                <p><?php echo htmlspecialchars($question['question_text']); ?></p>
                
                <?php
                $sql = "SELECT * FROM options WHERE question_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$question['id']]);
                $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <?php foreach ($options as $option): ?>
                    <input type="radio" name="answers[<?php echo $question['id']; ?>]" value="<?php echo $option['option_number']; ?>" required> 
                    <?php echo htmlspecialchars($option['option_text']); ?><br>
                <?php endforeach; ?>
            <?php endforeach; ?>

            <button type="submit">Submit Quiz</button>
        </form>
    <?php endif; ?>

    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
