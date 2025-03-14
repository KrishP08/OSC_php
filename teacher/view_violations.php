<?php
require_once "../config/db.php";

// Handle Unlock Request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["unlock_student"])) {
    $student_id = $_POST["student_id"] ?? null;
    $quiz_id = $_POST["quiz_id"] ?? null;

    if ($student_id && $quiz_id) {
        $sql = "DELETE FROM violations WHERE student_id = ? AND quiz_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$student_id, $quiz_id]);

        echo "<script>alert('student unlocked successfully!');</script>";
    } else {
        echo "<script>alert('Invalid request!');</script>";
    }
}

// Fetch Disqualified students
$sql = "SELECT s.id, s.name, v.quiz_id
        FROM users s
        JOIN violations v ON s.id = v.student_id
        WHERE s.role = 'student' AND v.disqualified = 1";

$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unlock Disqualified students</title>
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

        /* Table container styles */
        .table-container {
            padding: 16px;
            flex: 1;
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: #121417;
            margin-bottom: 24px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .data-table thead {
            background-color: #f0f2f5;
        }

        .data-table th {
            padding: 12px 16px;
            text-align: left;
            font-weight: 700;
            font-size: 14px;
            color: #121417;
            border-bottom: 1px solid #e5e8eb;
        }

        .data-table td {
            padding: 12px 16px;
            font-size: 14px;
            color: #121417;
            border-bottom: 1px solid #e5e8eb;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .empty-message {
            text-align: center;
            padding: 16px;
            color: #61758a;
            font-size: 14px;
        }

        .unlock-button {
            padding: 8px 16px;
            border-radius: 8px;
            background-color: #0d7df2;
            color: #fff;
            font-family: "Lexend", sans-serif;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .unlock-button:hover {
            background-color: #0a6ad0;
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

            .table-container {
                padding: 12px;
            }

            .page-title {
                font-size: 24px;
            }

            .data-table {
                display: block;
                overflow-x: auto;
            }

            .back-button {
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
                <li class="nav-item">
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
                <li class="nav-item active">
                    <div class="nav-icon-container">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="nav-icon">
                            <g clip-path="url(#clip0_admin)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 4C10.9 4 10 4.9 10 6C10 7.1 10.9 8 12 8C13.1 8 14 7.1 14 6C14 4.9 13.1 4 12 4ZM12 18C10.9 18 10 18.9 10 20C10 21.1 10.9 22 12 22C13.1 22 14 21.1 14 20C14 18.9 13.1 18 12 18ZM10 12C10 10.9 10.9 10 12 10C13.1 10 14 10.9 14 12C14 13.1 13.1 14 12 14C10.9 14 10 13.1 10 12Z" fill="#121417"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_admin">
                                    <rect width="24" height="24" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <span class="nav-label">Admin</span>
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
                            <li class="header-nav-item">Admin</li>
                        </ul>
                    </nav>
                    <div class="header-actions">
                        <button class="upgrade-button">Upgrade</button>
                        <img src="../assets/images/profile.jpg" alt="Profile" class="profile-img" onerror="this.src='../assets/images/default-profile.jpg'">
                    </div>
                </div>
            </header>

            <section class="table-container">
                <h2 class="page-title">Unlock Disqualified students</h2>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>student Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($students)): ?>
                            <tr>
                                <td colspan="2" class="empty-message">No disqualified students</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= htmlspecialchars($student["name"]) ?></td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="student_id" value="<?= $student["id"] ?>">
                                            <input type="hidden" name="quiz_id" value="<?= $student["quiz_id"] ?>">
                                            <button type="submit" name="unlock_student" class="unlock-button">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M15 7.5V7C15 4.79086 13.2091 3 11 3C8.79086 3 7 4.79086 7 7V7.5M8 11.5V14.5M14 11.5V14.5M19.2 9.5H2.8C2.35817 9.5 2 9.85817 2 10.3V19.7C2 20.1418 2.35817 20.5 2.8 20.5H19.2C19.6418 20.5 20 20.1418 20 19.7V10.3C20 9.85817 19.6418 9.5 19.2 9.5Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                Unlock
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>

                <a href="dashboard.php" class="back-button">Back to Dashboard</a>
            </section>
        </main>
    </div>
</body>
</html>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unlock Disqualified Students</title>
    <link rel="stylesheet" href="styles.css"> <!-- Optional CSS -->
</head>
<body>

    <h2>Unlock Disqualified Students</h2>

    <table border="1">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($students)): ?>
                <tr><td colspan="2">No disqualified students</td></tr>
            <?php else: ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student["name"]) ?></td>
                        <td>
                            <form method="POST">
                               
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
