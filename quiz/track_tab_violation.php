<?php
require_once "../config/db.php";
session_start();

if (!isset($_POST['student_id']) || !isset($_POST['quiz_id'])) {
    die("Invalid request.");
}

$student_id = $_POST['student_id'];
$quiz_id = $_POST['quiz_id'];

// Check if the student already has a violation record
$sql = "SELECT warnings FROM violations WHERE student_id = ? AND quiz_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$student_id, $quiz_id]);
$violation = $stmt->fetch(PDO::FETCH_ASSOC);

if ($violation) {
    $warnings = $violation['warnings'] + 1;

    // If warnings reach 3, disqualify the student
    if ($warnings >= 3) {
        $sql = "UPDATE violations SET warnings = ?, disqualified = 1 WHERE student_id = ? AND quiz_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$warnings, $student_id, $quiz_id]);
    } else {
        $sql = "UPDATE violations SET warnings = ? WHERE student_id = ? AND quiz_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$warnings, $student_id, $quiz_id]);
    }
} else {
    // Insert a new record if no previous violation exists
    $sql = "INSERT INTO violations (student_id, quiz_id, warnings, disqualified) VALUES (?, ?, 1, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$student_id, $quiz_id]);
}
?>
