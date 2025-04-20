<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'quiz_only') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quiz_id = $_POST['quiz_id'];
    $student_id = $_SESSION['user_id'];
    $answers = $_POST['answers'];

    // ✅ Step 1: Remove old answers and results
    $sql = "DELETE FROM student_answers WHERE student_id = :student_id AND quiz_id = :quiz_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':student_id' => $student_id,
        ':quiz_id' => $quiz_id
    ]);

    $sql = "DELETE FROM quiz_results WHERE student_id = :student_id AND quiz_id = :quiz_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':student_id' => $student_id,
        ':quiz_id' => $quiz_id
    ]);

    // ✅ Step 2: Recalculate score and insert updated answers
    $score = 0;
    $total_questions = count($answers);

    foreach ($answers as $question_id => $selected_option) {
        // Get correct answer
        $sql = "SELECT correct_option FROM questions WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$question_id]);
        $correct_option = $stmt->fetchColumn();

        $is_correct = ($selected_option == $correct_option) ? 1 : 0;
        if ($is_correct) {
            $score++;
        }

        // Insert student's answer
        $sql = "INSERT INTO student_answers (student_id, quiz_id, question_id, selected_option, is_correct) 
                VALUES (:student_id, :quiz_id, :question_id, :selected_option, :is_correct)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':student_id' => $student_id,
            ':quiz_id' => $quiz_id,
            ':question_id' => $question_id,
            ':selected_option' => $selected_option,
            ':is_correct' => $is_correct
        ]);
    }

    // ✅ Step 3: Save new result
    $percentage = ($score / $total_questions) * 100;
    $sql = "INSERT INTO quiz_results (student_id, quiz_id, score, total_questions, percentage) 
            VALUES (:student_id, :quiz_id, :score, :total_questions, :percentage)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':student_id' => $student_id,
        ':quiz_id' => $quiz_id,
        ':score' => $score,
        ':total_questions' => $total_questions,
        ':percentage' => $percentage
    ]);
    // Get current attempt count for the student on this quiz
    $stmt = $conn->prepare("SELECT MAX(attempt_number) FROM quiz_results WHERE student_id = ? AND quiz_id = ?");
    $stmt->execute([$student_id, $quiz_id]);
    $current_attempt = $stmt->fetchColumn();
    $next_attempt = $current_attempt ? $current_attempt + 1 : 1;

    // Insert into quiz_results with the attempt number
    $stmt = $conn->prepare("INSERT INTO quiz_results (student_id, quiz_id, score, attempt_number) VALUES (?, ?, ?, ?)");
    $stmt->execute([$student_id, $quiz_id, $score, $next_attempt]);


    header("Location: view_result.php?quiz_id=$quiz_id");
    exit();
}
?>
