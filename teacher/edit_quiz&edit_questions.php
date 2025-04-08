<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit();
}

$selected_course = $_POST['course'] ?? '';
$selected_quiz = $_POST['quiz'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quiz & Questions - Online Smart Class</title>
    <link rel="icon" type="image/x-icon" href="../assets/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Lexend', -apple-system, Roboto, Helvetica, sans-serif;
        }

        .dashboard-button {
            background-color: #0D7DF2;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        .dashboard-button:hover {
            background-color: #0A6AD3;
        }

        body {
            background-color: #ffffff;
            color: #121417;
            padding: 40px;
            line-height: 1.5;
        }

        h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 24px;
            color: #121417;
        }

        h3 {
            font-size: 24px;
            font-weight: 700;
            margin: 20px 0;
            color: #121417;
        }

        form {
            margin-bottom: 24px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #121417;
        }

        select, input[type="text"], input[type="number"], textarea {
            width: 100%;
            max-width: 400px;
            padding: 8px 12px;
            border: 1px solid #E5E8EB;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
        }

        textarea {
            max-width: 100%;
            min-height: 80px;
        }

        input[type="submit"], button {
            background-color: #0D7DF2;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            margin-right: 8px;
        }

        button[name="delete_question"] {
            background-color: #F0F2F5;
            color: #121417;
        }

        hr {
            border: none;
            border-top: 1px solid #E5E8EB;
            margin: 24px 0;
        }

        .question-form {
            background-color: #ffffff;
            border: 1px solid #E5E8EB;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 16px;
        }

        .options-group {
            margin: 16px 0;
        }

        .option-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .option-row input[type="radio"] {
            margin-right: 8px;
        }

        .option-row input[type="text"] {
            margin-bottom: 0;
        }

        .success-message {
            color: #0D7DF2;
            background-color: #F0F2F5;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .error-message {
            color: #FF4D4F;
            background-color: #FFF1F0;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        @media (max-width: 991px) {
            body {
                padding: 20px;
            }

            select, input[type="text"], input[type="number"], textarea {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <a href="dashboard.php" class="dashboard-button">← Back to Dashboard</a>
    <h2>Edit Quiz & Questions</h2>

    <!-- Course Selection -->
    <form method="POST">
        <label>Select Course:</label>
        <select name="course" onchange="this.form.submit()">
            <option value="">-- Select Course --</option>
            <?php
            $stmt = $conn->query("SELECT * FROM courses");
            $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($courses as $c) {
                $selected = ($selected_course == $c['id']) ? 'selected' : '';
                echo "<option value='{$c['id']}' $selected>{$c['title']}</option>";
            }
            ?>
        </select>
    </form>

    <?php if ($selected_course): ?>
        <!-- Quiz Selection -->
        <form method="POST">
            <input type="hidden" name="course" value="<?= $selected_course ?>">
            <label>Select Quiz:</label>
            <select name="quiz" onchange="this.form.submit()">
                <option value="">-- Select Quiz --</option>
                <?php
                $stmt = $conn->prepare("SELECT * FROM quizzes WHERE course_id = ?");
                $stmt->execute([$selected_course]);
                $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($quizzes as $q) {
                    $selected = ($selected_quiz == $q['id']) ? 'selected' : '';
                    echo "<option value='{$q['id']}' $selected>{$q['title']}</option>";
                }
                ?>
            </select>
        </form>
    <?php endif; ?>

    <?php
    if ($selected_quiz) {
        // Fetch quiz data
        $stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
        $stmt->execute([$selected_quiz]);
        $quiz_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Update quiz
        if (isset($_POST['update_quiz'])) {
            $title = $_POST['title'];
            $time_limit = $_POST['time_limit'];
            $allow_review = $_POST['allow_review'];
            $stmt = $conn->prepare("UPDATE quizzes SET title=?, time_limit=?, allow_review=? WHERE id = ?");
            $updated = $stmt->execute([$title, $time_limit, $allow_review, $selected_quiz]);
            echo $updated ? "<div class='success-message'>Quiz updated!</div>" : "<div class='error-message'>Update failed</div>";

            // Refresh quiz data
            $stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
            $stmt->execute([$selected_quiz]);
            $quiz_data = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Update question
        if (isset($_POST['update_question'])) {
            $q_id = $_POST['question_id'];
            $q_text = $_POST['question_text'];
            $correct_option = $_POST['correct_option'];
            $stmt = $conn->prepare("UPDATE questions SET question_text=?, correct_option=? WHERE id=?");
            $stmt->execute([$q_text, $correct_option, $q_id]);

            foreach ($_POST['option_text'] as $opt_id => $opt_text) {
                $stmt = $conn->prepare("UPDATE options SET option_text=? WHERE id=?");
                $stmt->execute([$opt_text, $opt_id]);
            }

            echo "<div class='success-message'>Question updated!</div>";
        }

        // Delete question
        if (isset($_POST['delete_question'])) {
            $q_id = $_POST['question_id'];
            $conn->prepare("DELETE FROM student_answers WHERE question_id=?")->execute([$q_id]);
            $conn->prepare("DELETE FROM options WHERE question_id=?")->execute([$q_id]);
            $conn->prepare("DELETE FROM questions WHERE id=?")->execute([$q_id]);
            echo "<div class='error-message'>Question deleted!</div>";
        }
    ?>

    <!-- Edit Quiz Form -->
    <hr>
    <h3>Edit Quiz</h3>
    <form method="POST" class="question-form">
        <input type="hidden" name="course" value="<?= $selected_course ?>">
        <input type="hidden" name="quiz" value="<?= $selected_quiz ?>">

        <label>Quiz Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($quiz_data['title']) ?>" required>

        <label>Time Limit (minutes):</label>
        <input type="number" name="time_limit" value="<?= $quiz_data['time_limit'] ?>" required>

        <label>Allow Review:</label>
        <select name="allow_review">
            <option value="1" <?= $quiz_data['allow_review'] == 1 ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= $quiz_data['allow_review'] == 0 ? 'selected' : '' ?>>No</option>
        </select>

        <input type="submit" name="update_quiz" value="Update Quiz">
    </form>

    <!-- Edit Questions -->
    <hr>
    <h3>Edit Questions</h3>
    <?php
    $stmt = $conn->prepare("SELECT * FROM questions WHERE quiz_id = ?");
    $stmt->execute([$selected_quiz]);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($questions as $q):
        $q_id = $q['id'];
        $stmt = $conn->prepare("SELECT * FROM options WHERE question_id = ?");
        $stmt->execute([$q_id]);
        $options = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <form method="POST" class="question-form">
        <input type="hidden" name="course" value="<?= $selected_course ?>">
        <input type="hidden" name="quiz" value="<?= $selected_quiz ?>">
        <input type="hidden" name="question_id" value="<?= $q_id ?>">

        <label>Question:</label>
        <textarea name="question_text" rows="2"><?= htmlspecialchars($q['question_text']) ?></textarea>

        <div class="options-group">
            <label>Options:</label>
            <?php
            foreach ($options as $index => $option) {
                $temp_number = $index + 1;
                $checked = ($temp_number == $q['correct_option']) ? 'checked' : '';
            ?>
            <div class="option-row">
                <input type="radio" name="correct_option" value="<?= $temp_number ?>" <?= $checked ?>>
                <label>Option <?= $temp_number ?>:</label>
                <input type="text" name="option_text[<?= $option['id'] ?>]" value="<?= htmlspecialchars($option['option_text']) ?>">
            </div>
            <?php } ?>
        </div>

        <button type="submit" name="update_question">Update Question</button>
        <button type="submit" name="delete_question" onclick="return confirm('Delete this question?')">Delete Question</button>
    </form>
    <?php endforeach; ?>

    <?php } ?>
</body>
</html>