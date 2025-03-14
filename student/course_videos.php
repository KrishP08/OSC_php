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

if ($course_id) {
    // Fetch course videos for the selected course
    $sql = "SELECT * FROM course_videos WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$course_id]);
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
        }

        .video-player {
            width: 100%;
            border-radius: 12px 12px 0 0;
            overflow: hidden;
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
                        <span class="menu-label"><a href="course_videos.php">Videos</a></span>
                    </li>
                    <li class="menu-item">
                        <div class="icon-container">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="menu-icon">
                                <g clip-path="url(#clip0_2_26)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.25 6.75H12.3103L9.75 4.18969C9.46966 3.90711 9.08773 3.74873 8.68969 3.75H3.75C2.92157 3.75 2.25 4.42157 2.25 5.25V18.8081C2.25103 19.604 2.89598 20.249 3.69187 20.25H20.3334C21.1154 20.249 21.749 19.6154 21.75 18.8334V8.25C21.75 7.42157 21.0784 6.75 20.25 6.75ZM3.75 5.25H8.68969L10.1897 6.75H3.75V5.25ZM20.25 18.75H3.75V8.25H20.25V18.75Z" fill="#121417"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2_26">
                                        <rect width="24" height="24" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <span class="menu-label"><a href="download_materials.php">Library</a></span>
                    </li>
                    <li class="menu-item">
                        <div class="icon-container">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="menu-icon">
                                <g clip-path="url(#clip0_2_33)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 3H17.25V2.25C17.25 1.83579 16.9142 1.5 16.5 1.5C16.0858 1.5 15.75 1.83579 15.75 2.25V3H8.25V2.25C8.25 1.83579 7.91421 1.5 7.5 1.5C7.08579 1.5 6.75 1.83579 6.75 2.25V3H4.5C3.67157 3 3 3.67157 3 4.5V19.5C3 20.3284 3.67157 21 4.5 21H19.5C20.3284 21 21 20.3284 21 19.5V4.5C21 3.67157 20.3284 3 19.5 3ZM6.75 4.5V5.25C6.75 5.66421 7.08579 6 7.5 6C7.91421 6 8.25 5.66421 8.25 5.25V4.5H15.75V5.25C15.75 5.66421 16.0858 6 16.5 6C16.9142 6 17.25 5.66421 17.25 5.25V4.5H19.5V7.5H4.5V4.5H6.75ZM19.5 19.5H4.5V9H19.5V19.5ZM10.5 11.25V17.25C10.5 17.6642 10.1642 18 9.75 18C9.33579 18 9 17.6642 9 17.25V12.4631L8.58562 12.6713C8.2149 12.8566 7.76411 12.7063 7.57875 12.3356C7.39339 11.9649 7.54365 11.5141 7.91437 11.3287L9.41438 10.5787C9.64695 10.4624 9.92322 10.4748 10.1444 10.6116C10.3656 10.7483 10.5002 10.9899 10.5 11.25ZM16.0462 14.1047L14.25 16.5H15.75C16.1642 16.5 16.5 16.8358 16.5 17.25C16.5 17.6642 16.1642 18 15.75 18H12.75C12.4659 18 12.2062 17.8395 12.0792 17.5854C11.9521 17.3313 11.9796 17.0273 12.15 16.8L14.8481 13.2028C15.0153 12.9802 15.0455 12.6833 14.9264 12.4316C14.8073 12.1799 14.5586 12.0149 14.2804 12.003C14.0023 11.9912 13.7404 12.1344 13.6003 12.375C13.4702 12.6146 13.2203 12.7647 12.9476 12.7671C12.675 12.7694 12.4226 12.6236 12.2884 12.3863C12.1542 12.1489 12.1593 11.8574 12.3019 11.625C12.8112 10.7435 13.849 10.3139 14.8324 10.5774C15.8158 10.8409 16.4997 11.7319 16.5 12.75C16.5016 13.2391 16.3421 13.7152 16.0462 14.1047Z" fill="#121417"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2_33">
                                        <rect width="24" height="24" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <span class="menu-label"><a href="calendar.php">Calendar</a></span>
                    </li>
                    <li class="menu-item">
                        <div class="icon-container">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="menu-icon">
                                <g clip-path="url(#clip0_2_40)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5 18H21.75V5.25C21.75 4.42157 21.0784 3.75 20.25 3.75H3.75C2.92157 3.75 2.25 4.42157 2.25 5.25V18H1.5C1.08579 18 0.75 18.3358 0.75 18.75C0.75 19.1642 1.08579 19.5 1.5 19.5H22.5C22.9142 19.5 23.25 19.1642 23.25 18.75C23.25 18.3358 22.9142 18 22.5 18ZM20.25 18H13.5V16.5C13.5 16.0858 13.8358 15.75 14.25 15.75H19.5C19.9142 15.75 20.25 16.0858 20.25 16.5V18ZM20.25 13.5C20.25 13.9142 19.9142 14.25 19.5 14.25C19.0858 14.25 18.75 13.9142 18.75 13.5V6.75H5.25V17.25C5.25 17.6642 4.91421 18 4.5 18C4.08579 18 3.75 17.6642 3.75 17.25V6C3.75 5.58579 4.08579 5.25 4.5 5.25H19.5C19.9142 5.25 20.25 5.58579 20.25 6V13.5Z" fill="#121417"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2_40">
                                        <rect width="24" height="24" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <span class="menu-label"><a href="student_profile.php">Student</a></span>
                    </li>
                    <li class="menu-item">
                        <div class="icon-container">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="menu-icon">
                                <g clip-path="url(#clip0_2_61)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1853 11.6962C23.1525 11.6222 22.3584 9.86062 20.5931 8.09531C18.2409 5.74312 15.27 4.5 12 4.5C8.73 4.5 5.75906 5.74312 3.40687 8.09531C1.64156 9.86062 0.84375 11.625 0.814687 11.6962C0.728449 11.8902 0.728449 12.1117 0.814687 12.3056C0.8475 12.3797 1.64156 14.1403 3.40687 15.9056C5.75906 18.2569 8.73 19.5 12 19.5C15.27 19.5 18.2409 18.2569 20.5931 15.9056C22.3584 14.1403 23.1525 12.3797 23.1853 12.3056C23.2716 12.1117 23.2716 11.8902 23.1853 11.6962ZM12 18C9.11438 18 6.59344 16.9509 4.50656 14.8828C3.65029 14.0313 2.9218 13.0603 2.34375 12C2.92165 10.9396 3.65015 9.9686 4.50656 9.11719C6.59344 7.04906 9.11438 6 12 6C14.8856 6 17.4066 7.04906 19.4934 9.11719C20.3514 9.9684 21.0815 10.9394 21.6609 12C20.985 13.2619 18.0403 18 12 18ZM12 7.5C9.51472 7.5 7.5 9.51472 7.5 12C7.5 14.4853 9.51472 16.5 12 16.5C14.4853 16.5 16.5 14.4853 16.5 12C16.4974 9.51579 14.4842 7.50258 12 7.5ZM12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12C15 13.6569 13.6569 15 12 15Z" fill="#121417"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_2_61">
                                        <rect width="24" height="24" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <span class="menu-label"><a href="grades.php">View Grades</a></span>
                    </li>
                    <li class="menu-item">
                        <div class="icon-container">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="menu-icon">
                                <g clip-path="url(#clip0_9_14)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5 18H21.75V5.25C21.75 4.42157 21.0784 3.75 20.25 3.75H3.75C2.92157 3.75 2.25 4.42157 2.25 5.25V18H1.5C1.08579 18 0.75 18.3358 0.75 18.75C0.75 19.1642 1.08579 19.5 1.5 19.5H22.5C22.9142 19.5 23.25 19.1642 23.25 18.75C23.25 18.3358 22.9142 18 22.5 18V18ZM20.25 18H13.5V16.5C13.5 16.0858 13.8358 15.75 14.25 15.75H19.5C19.9142 15.75 20.25 16.0858 20.25 16.5V18ZM20.25 13.5C20.25 13.9142 19.9142 14.25 19.5 14.25C19.0858 14.25 18.75 13.9142 18.75 13.5V6.75H5.25V17.25C5.25 17.6642 4.91421 18 4.5 18C4.08579 18 3.75 17.6642 3.75 17.25V6C3.75 5.58579 4.08579 5.25 4.5 5.25H19.5C19.9142 5.25 20.25 5.58579 20.25 6V13.5Z" fill="#121417"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_9_14">
                                        <rect width="24" height="24" fill="white"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                        <span class="menu-label"><a href="../public/logout.php">Logout</a></span>
                    </li>
                </ul>
            </nav>
            <main class="main-content">
                <h1 class="page-title">Course Videos</h1>

                <div class="course-selection">
                    <label for="courseSelect" class="form-label">Choose a Course:</label>
                    <select id="courseSelect" class="form-select" onchange="selectCourse(this.value)">
                        <option value="">-- Select Course --</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?php echo htmlspecialchars($course['id']); ?>"
                                <?php echo ($course['id'] == $course_id) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($course['title']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <?php if ($course_id): ?>
                    <h2 class="course-title">Videos for "<?php echo htmlspecialchars($course_title); ?>"</h2>

                    <?php if (count($videos) > 0): ?>
                        <div class="videos-container">
                            <?php foreach ($videos as $video): ?>
                                <div class="video-card">
                                    <div class="video-player">
                                        <video controls>
                                            <source src="../<?php echo htmlspecialchars($video['video_path']); ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                    <div class="video-info">
                                        <h3 class="video-title"><?php echo htmlspecialchars($video['title']); ?></h3>
                                        <?php if (!empty($video['description'])): ?>
                                            <p class="video-description"><?php echo htmlspecialchars($video['description']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <p>No videos available for this course.</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <a href="dashboard.php" class="back-link">Back to Dashboard</a>
            </main>
        </div>
    </div>

    <script>
        function selectCourse(courseId) {
            if (courseId) {
                window.location.href = 'course_videos.php?course_id=' + courseId;
            }
        }
    </script>
</body>
</html>