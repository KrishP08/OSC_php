<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: ../public/login.php");
    exit();
}

// Fetch all courses
$sql_courses = "SELECT id, title, description FROM courses";
$stmt = $conn->prepare($sql_courses);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch quizzes for enrolled courses
$sql_quizzes = "SELECT quizzes.id, quizzes.title, courses.title AS course_name,
        (SELECT COUNT(*) FROM quiz_results WHERE quiz_results.quiz_id = quizzes.id AND quiz_results.student_id = ?) AS attempted
        FROM quizzes
        JOIN courses ON quizzes.course_id = courses.id
        JOIN enrollments ON courses.id = enrollments.course_id
        WHERE enrollments.student_id = ?";

$stmt = $conn->prepare($sql_quizzes);
$stmt->execute([$_SESSION['user_id'], $_SESSION['user_id']]);
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: "Lexend", sans-serif;
        background-color: #fff;
      }

      /* Header Styles */
      .header {
        display: flex;
        padding: 12px 40px;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e5e8eb;
      }

      .brand {
        display: flex;
        align-items: center;
        gap: 16px;
      }

      .brand-name {
        color: #0d171c;
        font-size: 18px;
        font-weight: 700;
        line-height: 23px;
      }

      .header-right {
        display: flex;
        align-items: center;
        gap: 32px;
      }

      .nav-menu {
        display: flex;
        align-items: center;
        gap: 36px;
      }

      .nav-item {
        color: #0d171c;
        font-size: 14px;
        font-weight: 500;
        line-height: 21px;
        text-decoration: none;
      }

      .search-container {
        display: flex;
        height: 40px;
        padding: 0 10px;
        justify-content: center;
        align-items: center;
        border-radius: 12px;
        background-color: #e8edf2;
      }

      .profile-img {
        width: 40px;
        height: 40px;
        border-radius: 20px;
      }

      /* Main Content Styles */
      .main-content {
        display: flex;
        padding: 20px 160px;
        justify-content: center;
      }

      .content-container {
        max-width: 960px;
        width: 100%;
      }

      .welcome-heading {
        color: #0d171c;
        font-size: 24px;
        font-weight: 700;
        line-height: 30px;
        padding: 20px 16px 8px 16px;
      }

      /* Action Card Styles */
      .action-card {
        display: flex;
        padding: 20px;
        justify-content: space-between;
        align-items: center;
        margin: 16px;
        border-radius: 12px;
        border: 1px solid #d1dee5;
        background-color: #f7fafa;
      }

      .card-title {
        color: #0d171c;
        font-size: 16px;
        font-weight: 700;
        line-height: 20px;
        margin-bottom: 4px;
      }

      .card-description {
        color: #4f7a94;
        font-size: 16px;
        font-weight: 400;
        line-height: 24px;
      }

      .action-button {
        height: 32px;
        padding: 0 16px;
        border-radius: 12px;
        color: #f7fafa;
        font-size: 14px;
        font-weight: 500;
        line-height: 21px;
        background-color: #1f94e0;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
      }

      /* Courses Section */
      .courses-header {
        display: flex;
        padding: 16px;
        justify-content: space-between;
        align-items: center;
      }

      .courses-title {
        color: #0d171c;
        font-size: 36px;
        font-weight: 900;
        line-height: 45px;
        letter-spacing: -1px;
      }

      .view-course-btn {
        height: 40px;
        padding: 0 16px;
        border-radius: 12px;
        color: #0d171c;
        font-size: 14px;
        font-weight: 700;
        line-height: 21px;
        background-color: #e8edf2;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
      }

      .courses-table-container {
        margin: 12px 16px;
        border-radius: 12px;
        border: 1px solid #d1dee5;
        background-color: #f7fafa;
      }

      .table-header {
        display: flex;
        background-color: #f7fafa;
      }

      .table-cell {
        padding: 12px 16px;
        color: #0d171c;
        font-size: 14px;
        font-weight: 500;
        line-height: 21px;
        flex: 1;
      }

      .table-row {
        display: flex;
        border-top: 1px solid #e5e8eb;
      }

      .table-data {
        padding: 8px 16px;
        min-height: 72px;
        color: #0d171c;
        font-size: 14px;
        line-height: 21px;
        flex: 1;
        display: flex;
        align-items: center;
      }

      /* Course List */
      .course-list {
        list-style: none;
        padding: 0;
      }

      .course-item {
        display: flex;
        padding: 16px;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e5e8eb;
      }

      .course-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
      }

      .course-title {
        color: #0d171c;
        font-size: 16px;
        font-weight: 700;
        line-height: 20px;
      }

      .course-description {
        color: #4f7a94;
        font-size: 14px;
        line-height: 21px;
      }

      /* Footer Styles */
      .footer {
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 24px;
      }

      .footer-links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 24px;
      }

      .footer-link {
        color: #4f7a94;
        text-align: center;
        font-size: 16px;
        line-height: 24px;
        min-width: 160px;
        text-decoration: none;
      }

      .social-icons {
        display: flex;
        gap: 16px;
      }

      .copyright {
        color: #4f7a94;
        text-align: center;
        font-size: 16px;
        line-height: 24px;
      }

      /* Media Queries */
      @media (max-width: 991px) {
        .main-content {
          padding: 20px;
        }

        .content-container {
          padding: 0;
        }

        .action-card {
          flex-direction: column;
          gap: 16px;
          text-align: center;
        }

        .action-button {
          width: 100%;
        }

        .courses-header {
          flex-direction: column;
          gap: 16px;
          text-align: center;
        }

        .view-course-btn {
          width: 100%;
        }
      }

      @media (max-width: 640px) {
        .header {
          padding: 12px 20px;
        }

        .nav-menu {
          display: none;
        }

        .welcome-heading {
          font-size: 20px;
        }

        .action-card {
          margin: 8px 0;
        }

        .courses-table-container {
          overflow-x: auto;
        }

        .footer-links {
          justify-content: center;
        }
      }
    </style>
</head>
<body>
    <header class="header">
      <div class="brand">
        <div>
          <svg
            width="16"
            height="16"
            viewBox="0 0 16 16"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="logo"
          >
            <g clip-path="url(#clip0_1_8)">
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M4.6087 10.1912C5.57343 9.96087 6.74147 9.8261 8 9.8261C9.25853 9.8261 10.4266 9.96087 11.3913 10.1912C12.3048 10.4093 13.3322 10.9223 13.7854 11.2784L8.28287 2.45363C8.15237 2.24434 7.84763 2.24434 7.71713 2.45363L2.21458 11.2784C2.66777 10.9223 3.6952 10.4093 4.6087 10.1912Z"
                fill="#0D171C"
              ></path>
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M13.3327 11.9213C13.3315 11.9154 13.3292 11.9052 13.3249 11.8902C13.3145 11.8534 13.2983 11.8086 13.2782 11.7608C13.2723 11.7468 13.2663 11.7331 13.2604 11.7201C12.8368 11.4296 11.9929 11.0202 11.2365 10.8396C10.3292 10.623 9.21377 10.4928 8 10.4928C6.78623 10.4928 5.67083 10.623 4.7635 10.8396C4.0004 11.0218 3.14835 11.4368 2.72846 11.7277C2.72461 11.7358 2.72072 11.7443 2.71684 11.7531C2.69973 11.7917 2.68574 11.8295 2.67659 11.863C2.66785 11.8949 2.6668 11.9111 2.66668 11.9129C2.66667 11.9131 2.66668 11.913 2.66668 11.9129C2.66668 11.9214 2.67013 12.0256 2.89495 12.2105C3.11515 12.3915 3.47407 12.5844 3.97637 12.7591C4.97473 13.1063 6.3973 13.3333 8 13.3333C9.6027 13.3333 11.0253 13.1063 12.0236 12.7591C12.5259 12.5844 12.8848 12.3915 13.105 12.2105C13.3002 12.05 13.3286 11.9504 13.3327 11.9213ZM1.65059 10.9229L7.15143 2.10089C7.54293 1.47303 8.45707 1.47303 8.84857 2.10089L14.3511 10.9257C14.357 10.9351 14.3626 10.9446 14.368 10.9543L13.7854 11.2784C14.368 10.9543 14.3679 10.9542 14.368 10.9543L14.3684 10.955L14.3688 10.9558L14.37 10.958L14.3733 10.9639C14.3759 10.9687 14.3792 10.9749 14.3832 10.9824C14.3913 10.9975 14.4021 11.0182 14.4147 11.0433C14.4397 11.0931 14.4732 11.163 14.5072 11.2439C14.5634 11.3774 14.6667 11.6437 14.6667 11.913C14.6667 12.4809 14.3343 12.9258 13.9519 13.2403C13.5649 13.5586 13.0451 13.8155 12.4617 14.0184C11.2885 14.4265 9.711 14.6667 8 14.6667C6.289 14.6667 4.71153 14.4265 3.53833 14.0184C2.95488 13.8155 2.4351 13.5586 2.04806 13.2403C1.66565 12.9258 1.33333 12.4809 1.33333 11.913C1.33333 11.6242 1.43088 11.3641 1.49774 11.2131C1.53458 11.1299 1.57116 11.0601 1.59896 11.0104C1.61299 10.9852 1.62516 10.9645 1.6345 10.949C1.63918 10.9413 1.64318 10.9348 1.64639 10.9296L1.64887 10.9257L1.65059 10.9229ZM11.9956 9.668L8 3.25999L4.00437 9.668C4.15537 9.6203 4.30597 9.57807 4.4539 9.54273C5.47603 9.2987 6.6967 9.15943 8 9.15943C9.3033 9.15943 10.524 9.2987 11.5461 9.54273C11.694 9.57807 11.8446 9.6203 11.9956 9.668Z"
                fill="#0D171C"
              ></path>
            </g>
            <defs>
              <clipPath id="clip0_1_8">
                <rect width="16" height="16" fill="white"></rect>
              </clipPath>
            </defs>
          </svg>
        </div>
        <h1 class="brand-name">Online Smart Class</h1>
      </div>
      <div class="header-right">
        <nav class="nav-menu">
          <a href="#" class="nav-item">Dashboard</a>
          <a href="view_courses.php" class="nav-item">Courses</a>
          <a href="#" class="nav-item">Resources</a>
          <a href="#" class="nav-item">Community</a>
        </nav>
        <div class="search-container">
          <svg
            width="20"
            height="20"
            viewBox="0 0 20 20"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="search-icon"
          >
            <g clip-path="url(#clip0_1_31)">
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M17.9422 17.0578L14.0305 13.1469C16.3858 10.3192 16.1004 6.13911 13.3826 3.65779C10.6649 1.17647 6.47612 1.27167 3.87389 3.87389C1.27167 6.47612 1.17647 10.6649 3.65779 13.3826C6.13911 16.1004 10.3192 16.3858 13.1469 14.0305L17.0578 17.9422C17.302 18.1864 17.698 18.1864 17.9422 17.9422C18.1864 17.698 18.1864 17.302 17.9422 17.0578ZM3.125 8.75C3.125 5.6434 5.6434 3.125 8.75 3.125C11.8566 3.125 14.375 5.6434 14.375 8.75C14.375 11.8566 11.8566 14.375 8.75 14.375C5.64483 14.3716 3.12844 11.8552 3.125 8.75Z"
                fill="#0D171C"
              ></path>
            </g>
            <defs>
              <clipPath id="clip0_1_31">
                <rect width="20" height="20" fill="white"></rect>
              </clipPath>
            </defs>
          </svg>
        </div>
        <img
          src="../assets/images/profile.jpg"
          alt="Profile"
          class="profile-img"
        />
      </div>
    </header>

    <main class="main-content">
      <div class="content-container">
        <h2 class="welcome-heading">Welcome, Student</h2>

        <section class="action-card">
          <div>
            <h3 class="card-title">View &amp; Enroll in Courses</h3>
            <p class="card-description">
              Explore our catalog of courses and paths
            </p>
          </div>
          <a href="view_courses.php" class="action-button">View All</a>
        </section>

        <section class="action-card">
          <div>
            <h3 class="card-title">Download Materials</h3>
            <p class="card-description">
              Download the course materials to use offline
            </p>
          </div>
          <a href="download_materials.php" class="action-button">Download</a>
        </section>

        <section class="action-card">
          <div>
            <h3 class="card-title">View Video</h3>
            <p class="card-description">
              Watch the full video for this lecture
            </p>
          </div>
          <a href="course_videos.php" class="action-button">View Video</a>
        </section>

        <section class="action-card">
          <div>
            <h3 class="card-title">Attempt Quiz</h3>
            <p class="card-description">
              Test your understanding of the lecture with a quiz
            </p>
          </div>
          <a href="attempt_quiz.php" class="action-button">Attempt Quiz</a>
        </section>

        <section class="action-card">
          <div>
            <h3 class="card-title">Upload Assignment</h3>
            <p class="card-description">
              Submit your completed assignment for review
            </p>
          </div>
          <a href="upload_assignment.php" class="action-button">Upload</a>
        </section>

        <section class="action-card">
          <div>
            <h3 class="card-title">Participate in Live Lectures</h3>
            <p class="card-description">
              Join live lectures for real-time discussions and Q&amp;A
            </p>
          </div>
          <a href="live_lectures.php" class="action-button">Join Now</a>
        </section>

        <section class="action-card">
          <div>
            <h3 class="card-title">View Grades</h3>
            <p class="card-description">
              See your grades on assignments and quizzes
            </p>
          </div>
          <a href="view_grades.php" class="action-button">View</a>
        </section>
        <section class="action-card">
          <div>
            <h3 class="card-title">View Quiz Result</h3>
            <p class="card-description">
              See your grades on assignments and quizzes
            </p>
          </div>
          <a href="view_attempted_quiz.php" class="action-button">View</a>
        </section>

        <section class="action-card">
          <div>
            <h3 class="card-title">Logout</h3>
            <p class="card-description">
              Sign out from your account
            </p>
          </div>
          <a href="../public/logout.php" class="action-button">Logout</a>
        </section>

        <section class="courses-header">
          <h2 class="courses-title">Your Courses</h2>
          <?php if (!empty($courses)): ?>
          <a href="course_details.php" class="view-course-btn">View All Courses</a>
          <?php endif; ?>
        </section>

        <?php if (empty($courses)): ?>
          <section class="action-card">
            <div>
              <h3 class="card-title">No Courses Found</h3>
              <p class="card-description">You are not enrolled in any courses yet.</p>
            </div>
            <a href="view_courses.php" class="action-button">Enroll Now</a>
          </section>
        <?php else: ?>
          <ul class="course-list">
            <?php foreach ($courses as $course): ?>
              <li class="course-item">
                <div class="course-info">
                  <h3 class="course-title"><?php echo htmlspecialchars($course['title']); ?></h3>
                  <p class="course-description"><?php echo htmlspecialchars($course['description']); ?></p>
                </div>
                <a href="course_details.php?course_id=<?php echo $course['id']; ?>" class="view-course-btn">View Course</a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>

        <section class="courses-header">
          <h2 class="courses-title">Available Quizzes</h2>
        </section>

        <?php if (empty($quizzes)): ?>
          <section class="action-card">
            <div>
              <h3 class="card-title">No Quizzes Available</h3>
              <p class="card-description">There are no quizzes available for your enrolled courses.</p>
            </div>
          </section>
        <?php else: ?>
          <section class="courses-table-container">
            <div class="table-header">
              <div class="table-cell">Quiz Title</div>
              <div class="table-cell">Course</div>
              <div class="table-cell">Action</div>
            </div>
            <?php foreach ($quizzes as $row): ?>
              <div class="table-row">
                <div class="table-data"><?php echo htmlspecialchars($row['title']); ?></div>
                <div class="table-data"><?php echo htmlspecialchars($row['course_name']); ?></div>
                <div class="table-data">
                  <?php if ($row['attempted'] > 0): ?>
                    <button class="action-button" disabled style="background-color: #ccc;">Attempted</button>
                  <?php else: ?>
                    <a href="attempt_quiz.php?quiz_id=<?php echo $row['id']; ?>" class="action-button">Take Quiz</a>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </section>
        <?php endif; ?>
      </div>
    </main>

    <footer class="footer">
      <div class="footer-links">
        <a href="#" class="footer-link">Help Center</a>
        <a href="#" class="footer-link">Suggest Features</a>
        <a href="#" class="footer-link">Report a Bug</a>
        <a href="#" class="footer-link">Terms of Service</a>
        <a href="#" class="footer-link">Privacy Policy</a>
      </div>
      <div class="social-icons">
        <a href="#" aria-label="Twitter">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="social-icon"
          >
            <g clip-path="url(#clip0_1_160)">
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M23.1928 6.46313C23.0768 6.18285 22.8033 6.00006 22.5 6H19.6472C18.8359 4.61972 17.3604 3.76579 15.7594 3.75C14.5747 3.73446 13.4339 4.19754 12.5953 5.03438C11.7322 5.88138 11.2472 7.04071 11.25 8.25V8.82094C7.47563 7.82531 4.38844 4.755 4.35563 4.72219C4.15019 4.51493 3.84318 4.44566 3.56865 4.54461C3.29411 4.64356 3.1019 4.89277 3.07594 5.18344C2.67188 9.66375 3.97312 12.6619 5.13844 14.3878C5.70664 15.241 6.39786 16.0055 7.18969 16.6566C5.76188 18.3 3.51375 19.1634 3.48938 19.1728C3.27498 19.2531 3.109 19.4269 3.03868 19.6448C2.96837 19.8627 3.00142 20.1008 3.12844 20.2913C3.19875 20.3962 3.48 20.7647 4.16719 21.1087C5.01656 21.5344 6.13875 21.75 7.5 21.75C14.1253 21.75 19.6612 16.6481 20.2266 10.0837L23.0306 7.28062C23.2451 7.06601 23.3091 6.74335 23.1928 6.46313ZM18.9741 9.22031C18.8455 9.34921 18.7682 9.52049 18.7566 9.70219C18.375 15.6169 13.4325 20.25 7.5 20.25C6.51 20.25 5.8125 20.1187 5.32312 19.9613C6.40219 19.3753 7.90688 18.3675 8.87438 16.9163C8.98915 16.7438 9.02746 16.5315 8.98023 16.3298C8.93299 16.128 8.80442 15.9548 8.625 15.8512C8.58094 15.8259 4.50844 13.3819 4.5 6.85125C6 8.07 8.74219 9.96094 11.8753 10.4878C12.0927 10.5245 12.3151 10.4636 12.4836 10.3215C12.6521 10.1794 12.7495 9.9704 12.75 9.75V8.25C12.7483 7.44176 13.0728 6.66702 13.65 6.10125C14.2034 5.54686 14.9574 5.23983 15.7406 5.25C16.9275 5.265 18.0366 5.98875 18.5006 7.05094C18.6202 7.32382 18.8899 7.50008 19.1878 7.5H20.6878L18.9741 9.22031Z"
                fill="#4F7A94"
              ></path>
            </g>
            <defs>
              <clipPath id="clip0_1_160">
                <rect width="24" height="24" fill="white"></rect>
              </clipPath>
            </defs>
          </svg>
        </a>
        <a href="#" aria-label="Facebook">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="social-icon"
          >
            <g clip-path="url(#clip0_1_165)">
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M12 2.25C6.61522 2.25 2.25 6.61522 2.25 12C2.25 17.3848 6.61522 21.75 12 21.75C17.3848 21.75 21.75 17.3848 21.75 12C21.7443 6.61758 17.3824 2.25568 12 2.25ZM12.75 20.2153V14.25H15C15.4142 14.25 15.75 13.9142 15.75 13.5C15.75 13.0858 15.4142 12.75 15 12.75H12.75V10.5C12.75 9.67157 13.4216 9 14.25 9H15.75C16.1642 9 16.5 8.66421 16.5 8.25C16.5 7.83579 16.1642 7.5 15.75 7.5H14.25C12.5931 7.5 11.25 8.84315 11.25 10.5V12.75H9C8.58579 12.75 8.25 13.0858 8.25 13.5C8.25 13.9142 8.58579 14.25 9 14.25H11.25V20.2153C6.85788 19.8144 3.55787 16.0299 3.75854 11.6241C3.95922 7.21827 7.58962 3.74947 12 3.74947C16.4104 3.74947 20.0408 7.21827 20.2415 11.6241C20.4421 16.0299 17.1421 19.8144 12.75 20.2153Z"
                fill="#4F7A94"
              ></path>
            </g>
            <defs>
              <clipPath id="clip0_1_165">
                <rect width="24" height="24" fill="white"></rect>
              </clipPath>
            </defs>
          </svg>
        </a>
        <a href="#" aria-label="Instagram">
          <svg
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="social-icon"
          >
            <g clip-path="url(#clip0_1_170)">
              <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M12 7.5C9.51472 7.5 7.5 9.51472 7.5 12C7.5 14.4853 9.51472 16.5 12 16.5C14.4853 16.5 16.5 14.4853 16.5 12C16.4974 9.51579 14.4842 7.50258 12 7.5ZM12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12C15 13.6569 13.6569 15 12 15ZM16.5 2.25H7.5C4.60179 2.2531 2.2531 4.60179 2.25 7.5V16.5C2.2531 19.3982 4.60179 21.7469 7.5 21.75H16.5C19.3982 21.7469 21.7469 19.3982 21.75 16.5V7.5C21.7469 4.60179 19.3982 2.2531 16.5 2.25ZM20.25 16.5C20.25 18.5711 18.5711 20.25 16.5 20.25H7.5C5.42893 20.25 3.75 18.5711 3.75 16.5V7.5C3.75 5.42893 5.42893 3.75 7.5 3.75H16.5C18.5711 3.75 20.25 5.42893 20.25 7.5V16.5ZM18 7.125C18 7.74632 17.4963 8.25 16.875 8.25C16.2537 8.25 15.75 7.74632 15.75 7.125C15.75 6.50368 16.2537 6 16.875 6C17.4963 6 18 6.50368 18 7.125Z"
                fill="#4F7A94"
              ></path>
            </g>
            <defs>
              <clipPath id="clip0_1_170">
                <rect width="24" height="24" fill="white"></rect>
              </clipPath>
            </defs>
          </svg>
        </a>
      </div>
      <p class="copyright">@<?php echo date('Y'); ?> Online Smart Class</p>
    </footer>
</body>
</html>