<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}
$student_id = $_SESSION['user_id'];

// Fetch courses
$courses = $conn->query("SELECT id, title FROM courses")->fetchAll(PDO::FETCH_ASSOC);

// Course and quiz selection
$selected_course = $_GET['course'] ?? '';
$selected_quiz = $_GET['quiz'] ?? '';
$quizzes = [];

if ($selected_course) {
    $stmt = $conn->prepare("SELECT id, title FROM quizzes WHERE course_id = ?");
    $stmt->execute([$selected_course]);
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Attempted Quiz</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lexend', sans-serif;
            background-color: #f0f2f5;
            color: #121417;
            line-height: 1.5;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            gap: 16px;
        }

        .dashboard-button {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background-color: #f0f2f5;
            border-radius: 8px;
            color: #121417;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .dashboard-button:hover {
            background-color: #e5e8eb;
        }

        .dashboard-button svg {
            width: 20px;
            height: 20px;
        }

        h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 24px;
            color: #121417;
        }

        .form-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #121417;
        }

        select {
            width: 100%;
            height: 40px;
            padding: 8px 12px;
            border: 1px solid #e5e8eb;
            border-radius: 8px;
            font-family: 'Lexend', sans-serif;
            font-size: 14px;
            color: #121417;
            background-color: #fff;
            margin-bottom: 16px;
            cursor: pointer;
        }

        select:focus {
            outline: none;
            border-color: #0d7df2;
            box-shadow: 0 0 0 2px rgba(13, 125, 242, 0.1);
        }

        .question-container {
            background-color: #fff;
            border: 1px solid #e5e8eb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .question-text {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #121417;
        }

        .option-box {
            padding: 12px 16px;
            margin: 8px 0;
            border-radius: 8px;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .bg-success {
            background-color: #ecfdf3;
            color: #027a48;
            border: 1px solid #6ce9a6;
        }

        .bg-danger {
            background-color: #fef3f2;
            color: #b42318;
            border: 1px solid #fecdca;
        }

        .bg-light {
            background-color: #f9fafb;
            border: 1px solid #e5e8eb;
            color: #121417;
        }

        .answer-badge {
            font-size: 12px;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
            background-color: rgba(255, 255, 255, 0.2);
        }

        hr {
            border: none;
            border-top: 1px solid #e5e8eb;
            margin: 24px 0;
        }

        .no-quiz-selected {
            text-align: center;
            padding: 40px;
            color: #61758a;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 16px;
            }

            h2 {
                font-size: 24px;
            }

            .form-container {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-container">
            <a href="dashboard.php" class="dashboard-button">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z" fill="currentColor"/>
                </svg>
                Back to Dashboard
            </a>
            <h2>View Attempted Quiz</h2>
        </div>

        <div class="form-container">
            <form method="get">
                <div class="form-group">
                    <label for="course">Course:</label>
                    <select id="course" name="course" required onchange="this.form.submit()">
                        <option value="">-- Select Course --</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= $course['id'] ?>" <?= ($selected_course == $course['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($course['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if (!empty($quizzes)): ?>
                    <div class="form-group">
                        <label for="quiz">Quiz:</label>
                        <select id="quiz" name="quiz" required onchange="this.form.submit()">
                            <option value="">-- Select Quiz --</option>
                            <?php foreach ($quizzes as $quiz): ?>
                                <option value="<?= $quiz['id'] ?>" <?= ($selected_quiz == $quiz['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($quiz['title']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <?php
        if ($selected_quiz) {
            $checkQuiz = $conn->prepare("SELECT allow_review FROM quizzes WHERE id = ?");
            $checkQuiz->execute([$selected_quiz]);
            $quizSettings = $checkQuiz->fetch(PDO::FETCH_ASSOC);
        
            if (!$quizSettings || $quizSettings['allow_review'] == 0) {
                echo "<div class='no-quiz-selected'>The teacher has not allowed viewing answers for this quiz at this time.</div>";
            } else {
            $stmt = $conn->prepare("
                SELECT q.id AS question_id, q.question_text, q.correct_option, sa.selected_option
                FROM questions q
                JOIN student_answers sa ON q.id = sa.question_id
                WHERE sa.student_id = ? AND sa.quiz_id = ?
            ");
            $stmt->execute([$student_id, $selected_quiz]);
            $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($questions as $question):
                $qid = $question['question_id'];
                echo "<div class='question-container'>";
                echo "<div class='question-text'>Q: " . htmlspecialchars($question['question_text']) . "</div>";

                $optStmt = $conn->prepare("SELECT option_text, option_number FROM options WHERE question_id = ?");
                $optStmt->execute([$qid]);
                $options = $optStmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($options as $option):
                    $class = "option-box";

                    if ($option['option_number'] == $question['selected_option']) {
                        if ($option['option_number'] == $question['correct_option']) {
                            $class .= " bg-success";
                        } else {
                            $class .= " bg-danger";
                        }
                    } elseif ($option['option_number'] == $question['correct_option']) {
                        $class .= " bg-success";
                    } else {
                        $class .= " bg-light";
                    }

                    echo "<div class='$class'>";
                    echo "<span>" . htmlspecialchars($option['option_text']) . "</span>";
                    if ($option['option_number'] == $question['selected_option']) {
                        echo "<span class='answer-badge'>Your Answer</span>";
                    }
                    echo "</div>";
                endforeach;
                echo "</div>";
            endforeach;
        }
        } else {
            echo "<div class='no-quiz-selected'>Please select a course and quiz to view your attempts.</div>";
        }
        ?>
    </div>
</body>
</html>