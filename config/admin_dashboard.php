<?php
session_start();
require_once "../config/db.php";

// Access control
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit();
}

// Count stats
// Exclude admin from total user count
$userCount = $conn->query("SELECT COUNT(*) FROM users WHERE role != 'admin'")->fetchColumn();
$quizCount = $conn->query("SELECT COUNT(*) FROM quizzes")->fetchColumn();
$coursesCount = $conn->query("SELECT COUNT(*) FROM courses")->fetchColumn();
// Count user roles
$studentCount = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'student'")->fetchColumn();
$teacherCount = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'teacher'")->fetchColumn();
$quizOnlyCount = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'quiz_only'")->fetchColumn();


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

                <div class="row text-white mt-3">
                    <div class="col-4 border-end">
                        <div class="text-center">
                            <small>👨‍🏫</small><br>
                            <strong><?= $teacherCount ?></strong><br>
                            <small>Teachers</small>
                        </div>
                    </div>
                    <div class="col-4 border-end">
                        <div class="text-center">
                            <small>🎓</small><br>
                            <strong><?= $studentCount ?></strong><br>
                            <small>Students</small>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="text-center">
                            <small>📝</small><br>
                            <strong><?= $quizOnlyCount ?></strong><br>
                            <small>Quiz Only</small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Cousers</h5>
                    <p class="card-text fs-4"><?= $coursesCount ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Quizzes</h5>
                    <p class="card-text fs-4"><?= $quizCount ?></p>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Management</h4>
    <div class="list-group">
        <a href="manage_users.php" class="list-group-item list-group-item-action">Manage Users</a>
        <a href="import_users.php" class="list-group-item list-group-item-action">Import Users from Excel</a>
        <a href="manage_cousers.php" class="list-group-item list-group-item-action">Manage Cousers</a>
        <a href="manage_quizzes.php" class="list-group-item list-group-item-action">Manage Quizzes</a>
        <a href="../logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
    </div>
</div>
</body>
</html>
