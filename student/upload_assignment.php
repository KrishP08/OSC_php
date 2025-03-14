<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

$message = ""; // Store success or error messages

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $assignment_id = $_POST['assignment_id'];
    $student_id = $_SESSION['user_id'];
    $file_name = basename($_FILES["file"]["name"]);
    $file_tmp = $_FILES["file"]["tmp_name"];
    $upload_dir = "../uploads/";

    // Ensure the upload directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Save only the relative file path
    $relative_path = "uploads/" . $file_name;
    $file_path = $upload_dir . $file_name;

    if (move_uploaded_file($file_tmp, $file_path)) {
        // Insert into the database using PDO
        $sql = "INSERT INTO submissions (assignment_id, student_id, file_name, file_path)
                VALUES (:assignment_id, :student_id, :file_name, :file_path)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'assignment_id' => $assignment_id,
            'student_id' => $student_id,
            'file_name' => $file_name,
            'file_path' => $relative_path
        ]);

        if ($stmt) {
            $message = "<div class='success-message'>Assignment submitted successfully!</div>";
        } else {
            $message = "<div class='error-message'>Error submitting assignment.</div>";
        }
    } else {
        $message = "<div class='error-message'>Failed to upload file.</div>";
    }
}

// Fetch assignments using PDO
$sql = "SELECT assignments.id, assignments.title, courses.title AS course_title
        FROM assignments
        JOIN courses ON assignments.course_id = courses.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Assignment</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;700&display=swap" rel="stylesheet" />
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

        .app-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Sidebar styles */
        .sidebar {
            width: 190px;
            padding: 12px 0;
            border-right: 1px solid #e5e8eb;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-spacer {
            padding: 0 40px;
            margin-bottom: 8px;
        }

        .sidebar-title {
            color: #121417;
            font-size: 18px;
            font-weight: 700;
            margin-top: 20px;
            padding: 0 12px;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 36px;
            list-style: none;
            margin-top: 8px;
        }

        .nav-item {
            display: flex;
            padding: 8px 12px;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            width: 100%;
        }

        .nav-item.active {
            background-color: #f0f2f5;
            border-left: 3px solid #0d7df2;
        }

        .nav-icon-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .nav-label {
            font-size: 14px;
            color: #121417;
        }

        /* Main content styles */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Header styles */
        .main-header {
            display: flex;
            padding: 12px 40px;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e8eb;
        }

        .header-title {
            font-size: 18px;
            font-weight: 700;
            color: #121417;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .header-nav-list {
            display: flex;
            gap: 36px;
            list-style: none;
        }

        .header-nav-item {
            font-size: 14px;
            color: #121417;
            cursor: pointer;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .upgrade-button {
            padding: 0 16px;
            height: 40px;
            border-radius: 12px;
            color: #fff;
            font-family: "Lexend", sans-serif;
            font-size: 14px;
            font-weight: 700;
            background-color: #0d7df2;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 20px;
            object-fit: cover;
        }

        /* Upload container styles */
        .upload-container {
            padding: 16px;
            flex: 1;
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: #121417;
            margin-bottom: 24px;
        }

        .upload-form {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 24px;
            max-width: 600px;
            margin-bottom: 24px;
            border: 1px solid #e5e8eb;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #121417;
            margin-bottom: 8px;
        }

        .form-select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #dbe0e5;
            font-family: "Lexend", sans-serif;
            font-size: 14px;
            background-color: #fff;
            margin-bottom: 16px;
        }

        .file-upload-container {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background-color: #e6f0fd;
            border-radius: 8px;
            cursor: pointer;
            width: fit-content;
        }

        .file-upload-input {
            display: none;
        }

        .file-name-display {
            font-size: 14px;
            color: #61758a;
            margin-top: 8px;
            padding-left: 8px;
        }

        .submit-button {
            padding: 0 16px;
            height: 40px;
            border-radius: 12px;
            color: #fff;
            font-family: "Lexend", sans-serif;
            font-size: 14px;
            font-weight: 700;
            background-color: #0d7df2;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .back-button {
            padding: 0 16px;
            height: 40px;
            border-radius: 12px;
            color: #fff;
            font-family: "Lexend", sans-serif;
            font-size: 14px;
            font-weight: 700;
            background-color: #0d7df2;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            width: fit-content;
        }

        .success-message {
            background-color: #e6f7e6;
            color: #2e7d32;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .error-message {
            background-color: #fdecea;
            color: #d32f2f;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        /* Responsive styles */
        @media (max-width: 991px) {
            .sidebar {
                width: 64px;
            }

            .sidebar-spacer {
                display: none;
            }

            .sidebar-title {
                display: none;
            }

            .nav-label {
                display: none;
            }

            .main-content {
                width: calc(100% - 64px);
            }

            .header-nav {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .main-header {
                padding: 12px 16px;
            }

            .header-title {
                font-size: 16px;
            }

            .profile-img {
                width: 32px;
                height: 32px;
            }

            .upload-container {
                padding: 12px;
            }

            .page-title {
                font-size: 24px;
            }

            .upload-form {
                padding: 16px;
            }

            .back-button {
                width: 100%;
            }

            .submit-button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <nav class="sidebar">
            <div class="sidebar-spacer"></div>
            <h1 class="sidebar-title">Online Smart Class</h1>
            <ul class="nav-menu">
                <li class="nav-item">
                    <div class="nav-icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="nav-icon">
                            <g clip-path="url(#clip0_home)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5153 9.72844L13.0153 2.65219C13.0116 2.64899 13.0082 2.64554 13.005 2.64188C12.4328 2.1215 11.5588 2.1215 10.9866 2.64188L10.9762 2.65219L3.48469 9.72844C3.17573 10.0125 2.99994 10.4131 3 10.8328V19.5C3 20.3284 3.67157 21 4.5 21H9C9.82843 21 10.5 20.3284 10.5 19.5V15H13.5V19.5C13.5 20.3284 14.1716 21 15 21H19.5C20.3284 21 21 20.3284 21 19.5V10.8328C21.0001 10.4131 20.8243 10.0125 20.5153 9.72844ZM19.5 19.5H15V15C15 14.1716 14.3284 13.5 13.5 13.5H10.5C9.67157 13.5 9 14.1716 9 15V19.5H4.5V10.8328L4.51031 10.8234L12 3.75L19.4906 10.8216L19.5009 10.8309L19.5 19.5Z" fill="#121417"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_home">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <span class="nav-label">Home</span>
                </li>
                <li class="nav-item">
                    <div class="nav-icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="nav-icon">
                            <g clip-path="url(#clip0_courses)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 2.25H6.75C5.09315 2.25 3.75 3.59315 3.75 5.25V21C3.75 21.4142 4.08579 21.75 4.5 21.75H18C18.4142 21.75 18.75 21.4142 18.75 21C18.75 20.5858 18.4142 20.25 18 20.25H5.25C5.25 19.4216 5.92157 18.75 6.75 18.75H19.5C19.9142 18.75 20.25 18.4142 20.25 18V3C20.25 2.58579 19.9142 2.25 19.5 2.25ZM18.75 17.25H6.75C6.22326 17.2493 5.70572 17.388 5.25 17.6522V5.25C5.25 4.42157 5.92157 3.75 6.75 3.75H18.75V17.25Z" fill="#121417"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_courses">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <span class="nav-label">Courses</span>
                </li>
                <li class="nav-item">
                    <div class="nav-icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="nav-icon">
                            <g clip-path="url(#clip0_live)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25ZM12 14.25C10.7574 14.25 9.75 13.2426 9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25ZM18.9103 14.9194C18.5881 15.6812 18.1421 16.3844 17.5903 17.0006C17.3123 17.3014 16.8445 17.3236 16.5393 17.0504C16.2341 16.7772 16.2045 16.3098 16.4728 16.0003C18.5119 13.7236 18.5119 10.2774 16.4728 8.00062C16.289 7.80176 16.2267 7.51926 16.3098 7.26152C16.3928 7.00379 16.6084 6.81084 16.8737 6.75672C17.139 6.7026 17.4129 6.7957 17.5903 7.00031C19.5233 9.1633 20.0372 12.2464 18.9103 14.9194ZM6.46875 9.66469C5.56546 11.803 5.97658 14.2704 7.52437 16.0003C7.79265 16.3098 7.76306 16.7772 7.45789 17.0504C7.15273 17.3236 6.68485 17.3014 6.40688 17.0006C3.85725 14.1547 3.85725 9.84622 6.40688 7.00031C6.6831 6.69095 7.15782 6.66408 7.46719 6.94031C7.77655 7.21654 7.80342 7.69126 7.52719 8.00062C7.08469 8.49289 6.72701 9.05523 6.46875 9.66469ZM23.25 12C23.2545 14.9454 22.0998 17.7742 20.0353 19.875C19.8494 20.0738 19.5704 20.1562 19.3062 20.0904C19.0421 20.0246 18.8344 19.8209 18.7635 19.5581C18.6925 19.2953 18.7696 19.0148 18.9647 18.825C22.6834 15.0363 22.6834 8.96747 18.9647 5.17875C18.6737 4.88311 18.6775 4.40755 18.9731 4.11656C19.2688 3.82558 19.7443 3.82936 20.0353 4.125C22.0998 6.22578 23.2545 9.05462 23.25 12ZM5.03531 18.8231C5.22321 19.0144 5.29481 19.2913 5.22313 19.5497C5.15145 19.808 4.94739 20.0085 4.68782 20.0756C4.42824 20.1427 4.15259 20.0662 3.96469 19.875C-0.329686 15.5032 -0.329686 8.49683 3.96469 4.125C4.15061 3.92621 4.42965 3.84376 4.69376 3.90957C4.95787 3.97537 5.1656 4.1791 5.23653 4.44188C5.30745 4.70466 5.23044 4.98524 5.03531 5.175C1.31661 8.96372 1.31661 15.0325 5.03531 18.8213V18.8231Z" fill="#121417"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_live">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <span class="nav-label">Live</span>
                </li>
                <li class="nav-item active">
                    <div class="nav-icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="nav-icon">
                            <g clip-path="url(#clip0_library)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.25 6.75H12.3103L9.75 4.18969C9.46966 3.90711 9.08773 3.74873 8.68969 3.75H3.75C2.92157 3.75 2.25 4.42157 2.25 5.25V18.8081C2.25103 19.604 2.89598 20.249 3.69187 20.25H20.3334C21.1154 20.249 21.749 19.6154 21.75 18.8334V8.25C21.75 7.42157 21.0784 6.75 20.25 6.75ZM3.75 5.25H8.68969L10.1897 6.75H3.75V5.25ZM20.25 18.75H3.75V8.25H20.25V18.75Z" fill="#121417"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_library">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <span class="nav-label">Library</span>
                </li>
                <li class="nav-item">
                    <div class="nav-icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="nav-icon">
                            <g clip-path="url(#clip0_calendar)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 3H17.25V2.25C17.25 1.83579 16.9142 1.5 16.5 1.5C16.0858 1.5 15.75 1.83579 15.75 2.25V3H8.25V2.25C8.25 1.83579 7.91421 1.5 7.5 1.5C7.08579 1.5 6.75 1.83579 6.75 2.25V3H4.5C3.67157 3 3 3.67157 3 4.5V19.5C3 20.3284 3.67157 21 4.5 21H19.5C20.3284 21 21 20.3284 21 19.5V4.5C21 3.67157 20.3284 3 19.5 3ZM6.75 4.5V5.25C6.75 5.66421 7.08579 6 7.5 6C7.91421 6 8.25 5.66421 8.25 5.25V4.5H15.75V5.25C15.75 5.66421 16.0858 6 16.5 6C16.9142 6 17.25 5.66421 17.25 5.25V4.5H19.5V7.5H4.5V4.5H6.75ZM19.5 19.5H4.5V9H19.5V19.5Z" fill="#121417"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_calendar">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <span class="nav-label">Calendar</span>
                </li>
                <li class="nav-item">
                    <div class="nav-icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="nav-icon">
                            <g clip-path="url(#clip0_grades)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1853 11.6962C23.1525 11.6222 22.3584 9.86062 20.5931 8.09531C18.2409 5.74312 15.27 4.5 12 4.5C8.73 4.5 5.75906 5.74312 3.40687 8.09531C1.64156 9.86062 0.84375 11.625 0.814687 11.6962C0.728449 11.8902 0.728449 12.1117 0.814687 12.3056C0.8475 12.3797 1.64156 14.1403 3.40687 15.9056C5.75906 18.2569 8.73 19.5 12 19.5C15.27 19.5 18.2409 18.2569 20.5931 15.9056C22.3584 14.1403 23.1525 12.3797 23.1853 12.3056C23.2716 12.1117 23.2716 11.8902 23.1853 11.6962ZM12 18C9.11438 18 6.59344 16.9509 4.50656 14.8828C3.65029 14.0313 2.9218 13.0603 2.34375 12C2.92165 10.9396 3.65015 9.9686 4.50656 9.11719C6.59344 7.04906 9.11438 6 12 6C14.8856 6 17.4066 7.04906 19.4934 9.11719C20.3514 9.9684 21.0815 10.9394 21.6609 12C20.985 13.2619 18.0403 18 12 18ZM12 7.5C9.51472 7.5 7.5 9.51472 7.5 12C7.5 14.4853 9.51472 16.5 12 16.5C14.4853 16.5 16.5 14.4853 16.5 12C16.4974 9.51579 14.4842 7.50258 12 7.5ZM12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12C15 13.6569 13.6569 15 12 15Z" fill="#121417"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_grades">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <span class="nav-label">View Grades</span>
                </li>
                <li class="nav-item">
                    <div class="nav-icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="nav-icon">
                            <g clip-path="url(#clip0_logout)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5 18H21.75V5.25C21.75 4.42157 21.0784 3.75 20.25 3.75H3.75C2.92157 3.75 2.25 4.42157 2.25 5.25V18H1.5C1.08579 18 0.75 18.3358 0.75 18.75C0.75 19.1642 1.08579 19.5 1.5 19.5H22.5C22.9142 19.5 23.25 19.1642 23.25 18.75C23.25 18.3358 22.9142 18 22.5 18ZM20.25 18H13.5V16.5C13.5 16.0858 13.8358 15.75 14.25 15.75H19.5C19.9142 15.75 20.25 16.0858 20.25 16.5V18ZM20.25 13.5C20.25 13.9142 19.9142 14.25 19.5 14.25C19.0858 14.25 18.75 13.9142 18.75 13.5V6.75H5.25V17.25C5.25 17.6642 4.91421 18 4.5 18C4.08579 18 3.75 17.6642 3.75 17.25V6C3.75 5.58579 4.08579 5.25 4.5 5.25H19.5C19.9142 5.25 20.25 5.58579 20.25 6V13.5Z" fill="#121417"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_logout">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <span class="nav-label">Logout</span>
                </li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="main-header">
                <h1 class="header-title">Online Smart Class</h1>
                <div class="header-content">
                    <nav class="header-nav">
                        <ul class="header-nav-list">
                            <li class="header-nav-item">Home</li>
                            <li class="header-nav-item">Courses</li>
                            <li class="header-nav-item">Quizzes</li>
                            <li class="header-nav-item">Projects</li>
                        </ul>
                    </nav>
                    <div class="header-actions">
                        <button class="upgrade-button">Upgrade</button>
                        <img src="../assets/images/profile.jpg" alt="Profile" class="profile-img" onerror="this.src='../assets/images/default-profile.jpg'">
                    </div>
                </div>
            </header>

            <section class="upload-container">
                <h2 class="page-title">Upload Assignment</h2>

                <?php echo $message; ?>

                <form class="upload-form" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="form-label">Select Assignment:</label>
                        <select class="form-select" name="assignment_id" required>
                            <?php foreach ($assignments as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <?php echo htmlspecialchars($row['course_title']); ?> - <?php echo htmlspecialchars($row['title']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Select File:</label>
                        <div class="file-upload-container">
                            <label class="file-upload-label">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 16.5V6.5M12 6.5L8 10.5M12 6.5L16 10.5" stroke="#0d7df2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3 19.5H21" stroke="#0d7df2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Choose File
                                <input type="file" name="file" class="file-upload-input" id="file-upload" required>
                            </label>
                            <div class="file-name-display" id="file-name">No file chosen</div>
                        </div>
                    </div>

                    <button type="submit" class="submit-button">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 4.5V16.5M12 16.5L7 11.5M12 16.5L17 11.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3 19.5H21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Upload Assignment
                    </button>
                </form>

                <a href="dashboard.php" class="back-button">Back to Dashboard</a>
            </section>
        </main>
    </div>

    <script>
        // Display file name when selected
        document.getElementById('file-upload').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'No file chosen';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</body>
</html>