<?php
session_start();
require_once "../config/db.php";

// Ensure the user is logged in as a student
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

$student_id = $_SESSION['user_id']; // Get student ID

// Ensure `course_id` is set
if (!isset($_GET['id'])) {
    die("Course not found.");
}

$course_id = intval($_GET['id']); // Convert to integer for security

// Fetch course details from the `courses` table
$sql = "SELECT 
            c.*, 
            u.name AS instructor_name, 
            u.email AS instructor_email,
            (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) AS enrolled_students,
            (SELECT COUNT(*) FROM course_videos WHERE course_id = c.id) AS video_count,
            (SELECT COUNT(*) FROM quizzes WHERE course_id = c.id) AS quiz_count
        FROM courses c
        LEFT JOIN users u ON c.teacher_id = u.id
        WHERE c.id = :course_id"; 

$stmt = $conn->prepare($sql);
$stmt->bindValue(":course_id", $course_id, PDO::PARAM_INT);
$stmt->execute();
$course = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$course) {
    die("Course not found.");
}

// Course Topics (if needed)
$topics = [
    [
        'title' => $course['title'],
        'description' => $course['description']
    ]
];

// Handle Enrollment Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    $course_id = intval($_POST['course_id']);

    // Check if the student is already enrolled
    $check_sql = "SELECT * FROM enrollments WHERE student_id = :student_id AND course_id = :course_id";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bindValue(":student_id", $student_id, PDO::PARAM_INT);
    $check_stmt->bindValue(":course_id", $course_id, PDO::PARAM_INT);
    $check_stmt->execute();

    if ($check_stmt->rowCount() == 0) {
        // Enroll the student
        $enroll_sql = "INSERT INTO enrollments (student_id, course_id) VALUES (:student_id, :course_id)";
        $enroll_stmt = $conn->prepare($enroll_sql);
        $enroll_stmt->bindValue(":student_id", $student_id, PDO::PARAM_INT);
        $enroll_stmt->bindValue(":course_id", $course_id, PDO::PARAM_INT);
        $enroll_stmt->execute();
    }

    // Redirect to course details
    header("Location: course_details.php?id=" . $course_id);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['title']); ?> - Course Preview</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Lexend", sans-serif;
            color: #121417;
            background-color: #f8f9fa;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .course-header {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .course-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 16px;
            color: #121417;
        }

        .course-description {
            font-size: 16px;
            line-height: 1.6;
            color: #61758a;
            margin-bottom: 24px;
        }

        .course-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #121417;
            margin-bottom: 8px;
        }

        .stat-label {
            color: #61758a;
            font-size: 14px;
        }

        .instructor-section {
            display: flex;
            align-items: center;
            gap: 24px;
            padding: 24px;
            background: #f8f9fa;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .instructor-image {
            width: 80px;
            height: 80px;
            border-radius: 40px;
            object-fit: cover;
        }

        .instructor-info h3 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .instructor-info p {
            color: #61758a;
            font-size: 14px;
        }

        .course-content {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 24px;
            color: #121417;
        }

        .topics-list {
            list-style: none;
        }

        .topic-item {
            padding: 16px;
            border-bottom: 1px solid #e5e8eb;
        }

        .topic-item:last-child {
            border-bottom: none;
        }

        .topic-title {
            font-weight: 500;
            margin-bottom: 8px;
        }

        .topic-description {
            color: #61758a;
            font-size: 14px;
        }

        .enrollment-section {
            background: #fff;
            border-radius: 16px;
            padding: 32px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .price {
            font-size: 36px;
            font-weight: 700;
            color: #121417;
            margin-bottom: 16px;
        }

        .enroll-button {
            background: #0d7df2;
            color: #fff;
            border: none;
            padding: 16px 48px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .enroll-button:hover {
            background: #0b6ad3;
        }

        .features-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 16px;
            margin-top: 24px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .feature-icon {
            width: 24px;
            height: 24px;
            color: #0d7df2;
        }

        .back-link {
            display: inline-block;
            color: #0d7df2;
            text-decoration: none;
            margin-top: 24px;
        }

        @media (max-width: 768px) {
            .main-content {
                padding: 20px;
            }

            .course-stats {
                grid-template-columns: 1fr;
            }

            .instructor-section {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <main class="main-content">
            <div class="course-header">
                <h1 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h1>
                <p class="course-description"><?php echo htmlspecialchars($course['description']); ?></p>

                <div class="course-stats">
                    <div class="stat-card">
                        <div class="stat-value"><?php echo $course['enrolled_students']?? 0; ?></div>
                        <div class="stat-label">Enrolled Students</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value"><?php echo $course['video_count']?? 0; ?></div>
                        <div class="stat-label">Video Lectures</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value"><?php echo $course['duration']?? 0; ?> weeks</div>
                        <div class="stat-label">Course Duration</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value"><?php echo $course['quiz_count']?? 0; ?></div>
                        <div class="stat-label">Practice Quizzes</div>
                    </div>
                </div>

                <div class="instructor-section">
                    <img
                        src="<?php echo htmlspecialchars($course['instructor_image'] ?? 0); ?>"
                        alt="Instructor"
                        class="instructor-image"
                    >
                    <div class="instructor-info">
                        <h3>Your Instructor</h3>
                        <p><?php echo htmlspecialchars($course['instructor_name']?? 0); ?></p>
                        <p><?php echo htmlspecialchars($course['instructor_email']?? 0); ?></p>
                    </div>
                </div>
            </div>

            <div class="course-content">
                <h2 class="section-title">What You'll Learn</h2>
                <ul class="topics-list">
                    <?php foreach ($topics as $topic): ?>
                        <li class="topic-item">
                            <div class="topic-title"><?php echo htmlspecialchars($topic['title']?? 0); ?></div>
                            <div class="topic-description"><?php echo htmlspecialchars($topic['description']?? 0); ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="enrollment-section">
                <div class="price">$<?php echo number_format($course['price']?? 0, 2); ?></div>
                <form method="POST">
                    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                    <button type="submit" class="enroll-button">Enroll Now</button>
                </form>

                <div class="features-list">
                    <div class="feature-item">
                        <svg class="feature-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
                        </svg>
                        <span>Lifetime Access</span>
                    </div>
                    <div class="feature-item">
                        <svg class="feature-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>24/7 Support</span>
                    </div>
                    <div class="feature-item">
                        <svg class="feature-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        </svg>
                        <span>Certificate of Completion</span>
                    </div>
                    <div class="feature-item">
                        <svg class="feature-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M13 2.05v3.03c3.39.49 6 3.39 6 6.92 0 .9-.18 1.75-.5 2.54l2.6 1.53c.56-1.24.9-2.62.9-4.07 0-5.18-3.95-9.45-9-9.95zM12 19c-3.87 0-7-3.13-7-7 0-3.53 2.61-6.43 6-6.92V2.05c-5.06.5-9 4.76-9 9.95 0 5.52 4.47 10 9.99 10 3.31 0 6.24-1.61 8.06-4.09l-2.6-1.53C16.17 17.75 14.21 19 12 19z"></path>
                        </svg>
                        <span>Money Back Guarantee</span>
                    </div>
                </div>
            </div>

            <a href="dashboard.php" class="back-link">← Back to Dashboard</a>
        </main>
    </div>
</body>
</html>