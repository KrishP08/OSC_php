<?php
session_start();
require_once "../config/db.php";

// Access control
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

// Count stats
$userCount = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
$quizCount = $conn->query("SELECT COUNT(*) FROM quizzes")->fetchColumn();
$questionCount = $conn->query("SELECT COUNT(*) FROM questions")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Welcome, Admin</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text fs-4"><?= $userCount ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Quizzes</h5>
                    <p class="card-text fs-4"><?= $quizCount ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Questions</h5>
                    <p class="card-text fs-4"><?= $questionCount ?></p>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Management</h4>
    <div class="list-group">
        <a href="manage_users.php" class="list-group-item list-group-item-action">Manage Users</a>
        <a href="import_users.php" class="list-group-item list-group-item-action">Import Users from Excel</a>
        <a href="manage_quizzes.php" class="list-group-item list-group-item-action">Manage Quizzes</a>
        <a href="add_questions.php" class="list-group-item list-group-item-action">Add or Import Questions</a>
        <a href="../logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
    </div>
</div>
</body>
</html>
