<?php
session_start();
include '../config/db.php'; // Include the database connection file

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $teacher_id = $_SESSION['user_id'];

    try {
        $stmt = $conn->prepare("INSERT INTO courses (title, description, teacher_id) VALUES (:title, :description, :teacher_id)");
        $stmt->bindParam(":title", $title, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);
        $stmt->bindParam(":teacher_id", $teacher_id, PDO::PARAM_INT);
        $stmt->execute();} catch (PDOException $e) {


    if ($stmt->execute()) {
        echo "<p>Course created successfully!</p>";
    } else {
        echo "<p>Error creating course.</p>";
    }
}}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Course</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h2>Create a New Course</h2>
    <form method="POST">
        <label>Title:</label>
        <input type="text" name="title" required>
        <label>Description:</label>
        <textarea name="description" required></textarea>
        <button type="submit">Create Course</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>