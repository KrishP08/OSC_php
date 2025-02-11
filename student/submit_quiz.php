<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quiz_id = $_POST['quiz_id'];
    $student_id = $_SESSION['user_id'];
    $answers = $_POST['answers'];

    $score = 0;
    $total_questions = count($answers);

    foreach ($answers as $question_id => $selected_option) {
        // Get correct answer
        $sql = "SELECT correct_option FROM questions WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$question_id]);
        $correct_option = $stmt->fetchColumn();

        // Check if the answer is correct
        $is_correct = ($selected_option == $correct_option) ? 1 : 0;
        if ($is_correct) {
            $score++;
        }
        
        // Store student answer
        $sql = "INSERT INTO student_answers (student_id, quiz_id, question_id, selected_option, is_correct) 
                VALUES (:student_id, :quiz_id, :question_id, :selected_option, :is_correct)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":student_id", $student_id, PDO::PARAM_INT);
        $stmt->bindValue(":quiz_id", $quiz_id, PDO::PARAM_INT);
        $stmt->bindValue(":question_id", $question_id, PDO::PARAM_INT);
        $stmt->bindValue(":selected_option", $selected_option, PDO::PARAM_INT);
        $stmt->bindValue(":is_correct", $is_correct, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Store quiz result
    $percentage = ($score / $total_questions) * 100;
    $sql = "INSERT INTO quiz_results (student_id, quiz_id, score, total_questions, percentage) 
            VALUES (:student_id, :quiz_id, :score, :total_questions, :percentage)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":student_id", $student_id, PDO::PARAM_INT);
    $stmt->bindValue(":quiz_id", $quiz_id, PDO::PARAM_INT);
    $stmt->bindValue(":score", $score, PDO::PARAM_INT);
    $stmt->bindValue(":total_questions", $total_questions, PDO::PARAM_INT);
    $stmt->bindValue(":percentage", $percentage, PDO::PARAM_STR); // Float value
    $stmt->execute();

    header("Location: view_result.php?quiz_id=$quiz_id");
    exit();
}
?>
