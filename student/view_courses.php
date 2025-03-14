<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

// Fetch courses the student is enrolled in
$sql = "SELECT c.id, c.title FROM courses c
        JOIN enrollments e ON c.id = e.course_id
        WHERE e.student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if a course is selected
$course_id = isset($_GET['course_id']) ? $_GET['course_id'] : null;
$videos = [];

// Check if search term is provided
$search_term = isset($_GET['search']) ? $_GET['search'] : '';

if ($course_id) {
    // Fetch course videos for the selected course with optional search
    if (!empty($search_term)) {
        $sql = "SELECT * FROM course_videos WHERE course_id = ? AND (title LIKE ? OR description LIKE ?)";
        $search_param = "%$search_term%";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$course_id, $search_param, $search_param]);
    } else {
        $sql = "SELECT * FROM course_videos WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$course_id]);
    }
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get user profile info
$user_name = "";
$sql = "SELECT name FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user_data) {
    $user_name = $user_data['name'];
}

// Get course title if course is selected
$course_title = "";
if ($course_id && !empty($courses)) {
    foreach ($courses as $course) {
        if ($course['id'] == $course_id) {
            $course_title = $course['title'];
            break;
        }
    }
}

// Handle video progress tracking via AJAX
if (isset($_POST['save_progress']) && isset($_POST['video_id']) && isset($_POST['current_time'])) {
    $video_id = $_POST['video_id'];
    $current_time = $_POST['current_time'];
    $student_id = $_SESSION['user_id'];

    // Check if progress record exists
    $sql = "SELECT * FROM video_progress WHERE student_id = ? AND video_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$student_id, $video_id]);
    $progress = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($progress) {
        // Update existing record
        $sql = "UPDATE video_progress SET current_time = ?, updated_at = NOW() WHERE student_id = ? AND video_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$current_time, $student_id, $video_id]);
    } else {
        // Create new record
        $sql = "INSERT INTO video_progress (student_id, video_id, current_time, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$student_id, $video_id, $current_time]);
    }

    // Return success response
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit;
}

// Fetch video progress for the current student
$video_progress = [];
if ($course_id) {
    $sql = "SELECT video_id, current_time FROM video_progress WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_SESSION['user_id']]);
    $progress_results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($progress_results as $progress) {
        $video_progress[$progress['video_id']] = $progress['current_time'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Videos - Online Smart Class</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Lexend", sans-serif;
            background-color: #fff;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .app-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            min-height: 100vh;
            background-color: #fff;
        }

        /* Header styles */
        .top-header {
            display: flex;
            padding: 12px 40px;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e8eb;
        }

        .logo {
            color: #121417;
            font-size: 18px;
            font-weight: 700;
            line-height: 23px;
        }

        .header-right {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 32px;
            flex: 1;
        }

        .top-nav {
            display: flex;
        }

        .nav-list {
            display: flex;
            align-items: center;
            gap: 36px;
            list-style: none;
        }

        .nav-item {
            color: #121417;
            font-size: 14px;
            font-weight: 500;
            line-height: 21px;
            cursor: pointer;
        }

        .upgrade-button {
            height: 40px;
            min-width: 84px;
            max-width: 480px;
            padding: 0 16px;
            border-radius: 12px;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            line-height: 21px;
            background-color: #0d7df2;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 20px;
            object-fit: cover;
        }

        /* Content layout */
        .content-wrapper {
            display: flex;
            flex: 1;
        }

        /* Sidebar styles */
        .sidebar {
            width: 190px;
            padding: 20px 0;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
            list-style: none;
        }

        .menu-item {
            display: flex;
            padding: 8px 12px;
            align-items: center;
            gap: 12px;
            cursor: pointer;
        }

        .menu-item.active {
            background-color: #f0f2f5;
            border-radius: 8px;
        }

        .icon-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .menu-label {
            color: #121417;
            font-size: 14px;
            font-weight: 500;
            line-height: 21px;
        }

        /* Main content styles */
        .main-content {
            flex: 1;
            padding: 20px 40px;
        }

        .page-title {
            color: #121417;
            font-size: 32px;
            font-weight: 700;
            line-height: 40px;
            padding: 16px 0;
        }

        .course-selection {
            margin-bottom: 30px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #121417;
            font-size: 16px;
            font-weight: 500;
        }

        .form-select {
            width: 100%;
            max-width: 400px;
            padding: 12px;
            border: 1px solid #dbe0e5;
            border-radius: 8px;
            font-family: "Lexend", sans-serif;
            font-size: 14px;
            color: #121417;
            background-color: #fff;
        }

        .course-title {
            color: #121417;
            font-size: 24px;
            font-weight: 700;
            line-height: 32px;
            margin: 24px 0 16px;
        }

        /* Search and filter styles */
        .search-container {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            max-width: 600px;
        }

        .search-input {
            flex: 1;
            padding: 12px;
            border: 1px solid #dbe0e5;
            border-radius: 8px;
            font-family: "Lexend", sans-serif;
            font-size: 14px;
        }

        .search-button {
            padding: 0 16px;
            border-radius: 8px;
            background-color: #0d7df2;
            color: white;
            font-weight: 500;
            border: none;
            cursor: pointer;
        }

        .filter-container {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .filter-button {
            padding: 8px 16px;
            border-radius: 20px;
            background-color: #f0f2f5;
            color: #121417;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .filter-button:hover, .filter-button.active {
            background-color: #0d7df2;
            color: white;
        }

        .videos-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            margin-top: 20px;
        }

        .video-card {
            background-color: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .video-player {
            width: 100%;
            border-radius: 12px 12px 0 0;
            overflow: hidden;
            position: relative;
        }

        .video-player video {
            width: 100%;
            height: auto;
            display: block;
        }

        .video-info {
            padding: 16px;
        }

        .video-title {
            color: #121417;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .video-description {
            color: #61758a;
            font-size: 14px;
            line-height: 20px;
            margin-bottom: 12px;
        }

        .video-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #61758a;
        }

        .progress-bar-container {
            height: 4px;
            background-color: #f0f2f5;
            border-radius: 2px;
            overflow: hidden;
            margin-top: 8px;
        }

        .progress-bar {
            height: 100%;
            background-color: #0d7df2;
            width: 0%;
        }

        .progress-indicator {
            font-size: 12px;
            color: #61758a;
            margin-top: 4px;
            text-align: right;
        }

        .resume-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: rgba(13, 125, 242, 0.9);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #61758a;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        .back-link {
            display: inline-block;
            margin-top: 24px;
            color: #0d7df2;
            font-weight: 500;
        }

        /* Video notes styles */
        .notes-container {
            margin-top: 12px;
        }

        .notes-toggle {
            background: none;
            border: none;
            color: #0d7df2;
            font-size: 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .notes-form {
            margin-top: 8px;
            display: none;
        }

        .notes-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #dbe0e5;
            border-radius: 4px;
            font-family: "Lexend", sans-serif;
            font-size: 14px;
            resize: vertical;
            min-height: 60px;
        }

        .notes-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 8px;
        }

        .notes-save {
            padding: 6px 12px;
            background-color: #0d7df2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }

        .notes-cancel {
            padding: 6px 12px;
            background-color: #f0f2f5;
            color: #121417;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }

        /* SVG icon styles */
        .menu-icon {
            width: 24px;
            height: 24px;
        }

        /* Responsive styles */
        @media (max-width: 991px) {
            .header-right {
                gap: 20px;
            }

            .videos-container {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 640px) {
            .top-header {
                padding: 12px 20px;
            }

            .header-right {
                gap: 16px;
            }

            .nav-list {
                display: none;
            }

            .content-wrapper {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 10px;
            }

            .main-content {
                padding: 20px;
            }

            .page-title {
                font-size: 24px;
                line-height: 32px;
            }

            .videos-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <header class="top-header">
            <h1 class="logo">Online Smart Class</h1>
            <div class="header-right">
                <nav class="top-nav">
                    <ul class="nav-list">
                        <li class="nav-item"><a href="dashboard.php">Home</a></li>
                        <li class="nav-item"><a href="courses.php">Courses</a></li>
                        <li class="nav-item"><a href="quizzes.php">Quizzes</a></li>
                        <li class="nav-item"><a href="projects.php">Projects</a></li>
                    </ul>
                </nav>
                <button class="upgrade-button">Upgrade</button>
                <img src="profile-placeholder.jpg" alt="Profile" class="profile-image">
            </div>
        </header>
        <div class="content-wrapper">
            <nav class="sidebar">
                <ul class="sidebar-menu">
                    <li class="menu-item">
                        <div class="icon-container">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="menu-icon">
                                <g clip-path="url(#clip0_2_5)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5153 9.72844L13.0153 2.65219C13.0116 2.64899 13.0082 2.64554 13.005 2.64188C12.4328 2.1215 11.5588 2.1215 10.9866 2.64188L10.9762 2.65219L3.48469 9.72844C3.17573 10.0125 2.99994 10.4131 3 10.8328V19.5C3 20.3284 3.67157 21 4.5 21H9C9.82843 21 10.5 20.3284 10.5 19.5V15H13.5V19.5C13.5 20.3284 14.1716 21 15 21H19.5C20.3284 21 21 20.3284 21 19.5V10.8328C21.0001 10.4131 20.8243 10.0125 20.5153 9.72844ZM19.5 19.5H15V15C15 14.1716 14.3284 13.5 13.5 13.5H10.5C9.67157 13.5 9 14.1716 9 15V19.5H4.5V10.8328L4.51031 10.8234L12 3.75L19.4906 10.8216L19.5009 10.8309L19.5 19.5Z" fill="#121417"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2_5">
                                        <rect width="24" height="24" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <span class="menu-label"><a href="dashboard.php">Home</a></span>
                    </li>
                    <li class="menu-item">
                        <div class="icon-container">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="menu-icon">
                                <g clip-path="url(#clip0_2_12)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 2.25H6.75C5.09315 2.25 3.75 3.59315 3.75 5.25V21C3.75 21.4142 4.08579 21.75 4.5 21.75H18C18.4142 21.75 18.75 21.4142 18.75 21C18.75 20.5858 18.4142 20.25 18 20.25H5.25C5.25 19.4216 5.92157 18.75 6.75 18.75H19.5C19.9142 18.75 20.25 18.4142 20.25 18V3C20.25 2.58579 19.9142 2.25 19.5 2.25ZM18.75 17.25H6.75C6.22326 17.2493 5.70572 17.388 5.25 17.6522V5.25C5.25 4.42157 5.92157 3.75 6.75 3.75H18.75V17.25Z" fill="#121417"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2_12">
                                        <rect width="24" height="24" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <span class="menu-label"><a href="courses.php">Courses</a></span>
                    </li>
                    <li class="menu-item active">
                        <div class="icon-container">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="menu-icon">
                                <g clip-path="url(#clip0_2_19)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25ZM12 14.25C10.7574 14.25 9.75 13.2426 9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25ZM18.9103 14.9194C18.5881 15.6812 18.1421 16.3844 17.5903 17.0006C17.3123 17.3014 16.8445 17.3236 16.5393 17.0504C16.2341 16.7772 16.2045 16.3098 16.4728 16.0003C18.5119 13.7236 18.5119 10.2774 16.4728 8.00062C16.289 7.80176 16.2267 7.51926 16.3098 7.26152C16.3928 7.00379 16.6084 6.81084 16.8737 6.75672C17.139 6.7026 17.4129 6.7957 17.5903 7.00031C19.5233 9.1633 20.0372 12.2464 18.9103 14.9194ZM6.46875 9.66469C5.56546 11.803 5.97658 14.2704 7.52437 16.0003C7.79265 16.3098 7.76306 16.7772 7.45789 17.0504C7.15273 17.3236 6.68485 17.3014 6.40688 17.0006C3.85725 14.1547 3.85725 9.84622 6.40688 7.00031C6.6831 6.69095 7.15782 6.66408 7.46719 6.94031C7.77655 7.21654 7.80342 7.69126 7.52719 8.00062C7.08469 8.49289 6.72701 9.05523 6.46875 9.66469ZM23.25 12C23.2545 14.9454 22.0998 17.7742 20.0353 19.875C19.8494 20.0738 19.5704 20.1562 19.3062 20.0904C19.0421 20.0246 18.8344 19.8209 18.7635 19.5581C18.6925 19.2953 18.7696 19.0148 18.9647 18.825C22.6834 15.0363 22.6834 8.96747 18.9647 5.17875C18.6737 4.88311 18.6775 4.40755 18.9731 4.11656C19.2688 3.82558 19.7443 3.82936 20.0353 4.125C22.0998 6.22578 23.2545 9.05462 23.25 12ZM5.03531 18.8231C5.22321 19.0144 5.29481 19.2913 5.22313 19.5497C5.15145 19.808 4.94739 20.0085 4.68782 20.0756C4.42824 20.1427 4.15259 20.0662 3.96469 19.875C-0.329686 15.5032 -0.329686 8.49683 3.96469 4.125C4.15061 3.92621 4.42965 3.84376 4.69376 3.90957C4.95787 3.97537 5.1656 4.1791 5.23653 4.44188C5.30745 4.70466 5.23044 4.98524 5.03531 5.175C1.31661 8.96372 1.31661 15.0325 5.03531 18.8213V18.8231Z" fill="#121417"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2_19">
                                        <rect width="24" height="24" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <span class="menu-label">