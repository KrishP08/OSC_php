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

    //  Fixed SQL for PDO
    $sql = "INSERT INTO assignments (course_id, teacher_id, title, description, due_date)
            VALUES (:course_id, :teacher_id, :title, :description, :due_date)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":course_id", $course_id, PDO::PARAM_INT);
    $stmt->bindParam(":teacher_id", $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(":title", $title, PDO::PARAM_STR);
    $stmt->bindParam(":description", $description, PDO::PARAM_STR);
    $stmt->bindParam(":due_date", $due_date, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $success_message = "Assignment created successfully!";
    } else {
        $error_message = "Error creating assignment.";
    }
}

//  Fixed course retrieval query for PDO
$sql = "SELECT * FROM courses WHERE teacher_id = :teacher_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":teacher_id", $_SESSION['user_id'], PDO::PARAM_INT);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give Assignment - Online Smart Class</title>
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

        .app-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #fff;
        }

        /* Header styles */
        .main-header {
            display: flex;
            padding: 12px 40px;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e8eb;
        }

        .brand-name {
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

        .nav-links {
            display: flex;
            align-items: center;
            gap: 36px;
        }

        .nav-item {
            color: #121417;
            font-size: 14px;
            font-weight: 400;
            line-height: 21px;
            text-decoration: none;
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

        /* Main content styles */
        .main-content {
            display: flex;
            flex: 1;
        }

        /* Sidebar styles */
        .sidebar {
            display: flex;
            width: 190px;
            flex-direction: column;
            gap: 8px;
            padding: 20px 0;
        }

        .sidebar-item {
            display: flex;
            padding: 8px 12px;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            text-decoration: none;
        }

        .sidebar-item.active {
            background-color: rgba(13, 125, 242, 0.1);
            border-radius: 8px;
        }

        .icon-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-icon {
            width: 24px;
            height: 24px;
        }

        .sidebar-text {
            color: #121417;
            font-size: 14px;
            font-weight: 400;
            line-height: 21px;
        }

        /* Content styles */
        .content {
            flex: 1;
            padding: 20px 160px 20px 20px;
        }

        .page-header {
            color: #121417;
            font-size: 32px;
            font-weight: 700;
            line-height: 40px;
            padding: 16px;
            margin-bottom: 20px;
        }

        /* Form styles */
        .form-container {
            background-color: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #121417;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-select, .form-input, .form-textarea, .form-date {
            width: 100%;
            padding: 12px;
            border: 1px solid #dbe0e5;
            border-radius: 8px;
            font-family: "Lexend", sans-serif;
            font-size: 14px;
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-button {
            background-color: #0d7df2;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-family: "Lexend", sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 8px;
        }

        .form-button:hover {
            background-color: #0a6ad0;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #0d7df2;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .message {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .success-message {
            background-color: #e6f7e6;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .error-message {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        /* Responsive styles */
        @media (max-width: 991px) {
            .main-header {
                padding: 12px 20px;
            }

            .nav-links {
                display: none;
            }

            .content {
                padding: 20px;
            }
        }

        @media (max-width: 640px) {
            .main-header {
                padding: 12px 16px;
            }

            .main-content {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                padding: 10px;
            }

            .content {
                padding: 10px;
            }

            .page-header {
                font-size: 24px;
                line-height: 32px;
            }
        }
    </style>
</head>
<body>
    <div class="app-container">
        <header class="main-header">
            <div class="brand-name">Online Smart Class</div>
            <div class="header-right">
                <nav class="nav-links">
                    <a href="#" class="nav-item">Home</a>
                    <a href="#" class="nav-item">Courses</a>
                    <a href="#" class="nav-item">Quizzes</a>
                    <a href="#" class="nav-item">Projects</a>
                </nav>
                <button class="upgrade-button">Upgrade</button>
                <img src="https://via.placeholder.com/40" alt="Profile" class="profile-image">
            </div>
        </header>
        <main class="main-content">
            <aside class="sidebar">
                <a href="dashboard.php" class="sidebar-item">
                    <div class="icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="sidebar-icon">
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
                    <span class="sidebar-text">Dashboard</span>
                </a>
                <a href="#" class="sidebar-item">
                    <div class="icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="sidebar-icon">
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
                    <span class="sidebar-text">Courses</span>
                </a>
                <a href="#" class="sidebar-item">
                    <div class="icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="sidebar-icon">
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
                    <span class="sidebar-text">Quizzes</span>
                </a>
                <a href="#" class="sidebar-item active">
                    <div class="icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="sidebar-icon">
                            <g clip-path="url(#clip0_2_33)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 3H17.25V2.25C17.25 1.83579 16.9142 1.5 16.5 1.5C16.0858 1.5 15.75 1.83579 15.75 2.25V3H8.25V2.25C8.25 1.83579 7.91421 1.5 7.5 1.5C7.08579 1.5 6.75 1.83579 6.75 2.25V3H4.5C3.67157 3 3 3.67157 3 4.5V19.5C3 20.3284 3.67157 21 4.5 21H19.5C20.3284 21 21 20.3284 21 19.5V4.5C21 3.67157 20.3284 3 19.5 3ZM6.75 4.5V5.25C6.75 5.66421 7.08579 6 7.5 6C7.91421 6 8.25 5.66421 8.25 5.25V4.5H15.75V5.25C15.75 5.66421 16.0858 6 16.5 6C16.9142 6 17.25 5.66421 17.25 5.25V4.5H19.5V7.5H4.5V4.5H6.75ZM19.5 19.5H4.5V9H19.5V19.5Z" fill="#121417"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_2_33">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <span class="sidebar-text">Assignments</span>
                </a>
                <a href="#" class="sidebar-item">
                    <div class="icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="sidebar-icon">
                            <g clip-path="url(#clip0_2_47)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M22.95 14.1C22.6186 14.3485 22.1485 14.2814 21.9 13.95C20.9833 12.7178 19.5358 11.994 18 12C17.6985 12 17.4263 11.8194 17.3091 11.5416C17.2304 11.3551 17.2304 11.1449 17.3091 10.9584C17.4263 10.6806 17.6985 10.5 18 10.5C19.1692 10.4999 20.1435 9.60425 20.2418 8.43916C20.3401 7.27406 19.5297 6.22784 18.377 6.03184C17.2243 5.83584 16.1136 6.55539 15.8212 7.6875C15.7177 8.08877 15.3085 8.33012 14.9072 8.22656C14.5059 8.12301 14.2646 7.71377 14.3681 7.3125C14.7687 5.76266 16.1088 4.63794 17.7047 4.51237C19.3005 4.38679 20.8001 5.28805 21.4381 6.75618C22.0761 8.2243 21.7119 9.93555 20.5312 11.0166C21.5511 11.4581 22.4376 12.1588 23.1028 13.0491C23.2222 13.2086 23.2731 13.4091 23.2444 13.6062C23.2158 13.8034 23.1098 13.9811 22.95 14.1ZM17.8988 19.875C18.0465 20.1075 18.055 20.4023 17.9207 20.6429C17.7865 20.8834 17.5311 21.031 17.2557 21.0273C16.9802 21.0236 16.7289 20.8691 16.6012 20.625C15.64 18.9973 13.8903 17.9986 12 17.9986C10.1097 17.9986 8.36001 18.9973 7.39875 20.625C7.27105 20.8691 7.0198 21.0236 6.74434 21.0273C6.46887 21.031 6.21353 20.8834 6.07928 20.6429C5.94502 20.4023 5.95346 20.1075 6.10125 19.875C6.82837 18.6257 7.93706 17.6425 9.26437 17.07C7.73297 15.8975 7.11905 13.8795 7.73805 12.0528C8.35704 10.2261 10.0713 8.997 12 8.997C13.9287 8.997 15.643 10.2261 16.262 12.0528C16.8809 13.8795 16.267 15.8975 14.7356 17.07C16.0629 17.6425 17.1716 18.6257 17.8988 19.875ZM12 16.5C13.6569 16.5 15 15.1569 15 13.5C15 11.8431 13.6569 10.5 12 10.5C10.3431 10.5 9 11.8431 9 13.5C9 15.1569 10.3431 16.5 12 16.5ZM6.75 11.25C6.75 10.8358 6.41421 10.5 6 10.5C4.83076 10.4999 3.85646 9.60425 3.75816 8.43916C3.65987 7.27406 4.47034 6.22784 5.62303 6.03184C6.77572 5.83584 7.88644 6.55539 8.17875 7.6875C8.2823 8.08877 8.69154 8.33012 9.09281 8.22656C9.49408 8.12301 9.73543 7.71377 9.63188 7.3125C9.23134 5.76266 7.89116 4.63794 6.29533 4.51237C4.6995 4.38679 3.19991 5.28805 2.56189 6.75618C1.92388 8.2243 2.28813 9.93555 3.46875 11.0166C2.44995 11.4585 1.56442 12.1592 0.9 13.0491C0.651213 13.3804 0.71816 13.8507 1.04953 14.0995C1.3809 14.3483 1.85121 14.2814 2.1 13.95C3.01674 12.7178 4.46416 11.994 6 12C6.41421 12 6.75 11.6642 6.75 11.25Z" fill="#121417"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_2_47">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <span class="sidebar-text">Students</span>
                </a>
                <a href="create_course.php" class="sidebar-item">
                    <div class="icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="sidebar-icon">
                            <g clip-path="url(#clip0_2_54)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M21 12C21 12.4142 20.6642 12.75 20.25 12.75H12.75V20.25C12.75 20.6642 12.4142 21 12 21C11.5858 21 11.25 20.6642 11.25 20.25V12.75H3.75C3.33579 12.75 3 12.4142 3 12C3 11.5858 3.33579 11.25 3.75 11.25H11.25V3.75C11.25 3.33579 11.5858 3 12 3C12.4142 3 12.75 3.33579 12.75 3.75V11.25H20.25C20.6642 11.25 21 11.5858 21 12Z" fill="#121417"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_2_54">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <span class="sidebar-text">Create Course</span>
                </a>
            </aside>
            <section class="content">
                <h1 class="page-header">Give Assignment</h1>

                <?php if(isset($success_message)): ?>
                    <div class="message success-message"><?php echo $success_message; ?></div>
                <?php endif; ?>

                <?php if(isset($error_message)): ?>
                    <div class="message error-message"><?php echo $error_message; ?></div>
                <?php endif; ?>

                <div class="form-container">
                    <form method="POST">
                        <div class="form-group">
                            <label class="form-label">Select Course:</label>
                            <select name="course_id" class="form-select" required>
                                <?php foreach ($courses as $row): ?>
                                    <option value="<?php echo htmlspecialchars($row['id']); ?>">
                                        <?php echo htmlspecialchars($row['title']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Title:</label>
                            <input type="text" name="title" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Description:</label>
                            <textarea name="description" class="form-textarea" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Due Date:</label>
                            <input type="date" name="due_date" class="form-date" required>
                        </div>

                        <button type="submit" class="form-button">Create Assignment</button>
                    </form>

                    <a href="dashboard.php" class="back-link">Back to Dashboard</a>
                </div>
            </section>
        </main>
    </div>
</body>
</html>