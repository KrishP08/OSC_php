<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'quiz_only') {
    header("Location: ../public/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Quiz Dashboard</title>
    <link rel="stylesheet" href="css/quiz_dashboard.css"> <!-- Optional CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            text-align: center;
            padding: 40px;
        }

        .dashboard {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h1 {
            margin-bottom: 30px;
            color: #333;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 16px;
        }

        .btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<div class="dashboard">
<?php if (isset($_SESSION['user_name'])): ?>
    <p>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</p>
<?php else: ?>
    <p>Welcome, Guest!</p>
<?php endif; ?>

    <a href="attempt_quiz.php" class="btn">Attempt Quiz</a>
    <a href="view_attempted_quiz.php" class="btn">View Attempted Quizzes</a>
    <a href="../public/logout.php" class="btn" style="background-color: #dc3545;">Logout</a>
</div>

</body>
</html>
