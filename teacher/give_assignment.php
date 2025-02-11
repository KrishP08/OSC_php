<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];

    // ✅ Fixed SQL for PDO
    $sql = "INSERT INTO assignments (course_id, teacher_id, title, description, due_date) 
            VALUES (:course_id, :teacher_id, :title, :description, :due_date)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
    $stmt->bindParam(":teacher_id", $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt->bindParam(":description", $description, PDO::PARAM_STR);
    $stmt->bindParam(":due_date", $due_date, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "<p>Assignment created successfully!</p>";
    } else {
        echo "<p>Error creating assignment.</p>";
    }
}

// ✅ Fixed course retrieval query for PDO
$sql = "SELECT * FROM courses WHERE teacher_id = :teacher_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":teacher_id", $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Give Assignment</title>
    <link rel="stylesheet" href="../assets/css/give_assignment.css">
</head>
<body>
    <h2>Give Assignment</h2>
    <form method="POST">
        <label>Select Course:</label>
        <select name="course_id" required>
            <?php foreach ($courses as $row): ?>
                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                    <?php echo htmlspecialchars($row['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label>Title:</label>
        <input type="text" name="title" required>
        <label>Description:</label>
        <textarea name="description" required></textarea>
        <label>Due Date:</label>
        <input type="date" name="due_date" required>
        <button type="submit">Create Assignment</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
