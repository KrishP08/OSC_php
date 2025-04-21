<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <style>
    .teaching-dashboard {
      background-color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }
  
    .main-container {
      display: flex;
      width: 100%;
      flex-direction: column;
      justify-content: flex-start;
    }
  
    @media (max-width: 991px) {
      .main-container {
        max-width: 100%;
      }
    }
  
    .content-wrapper {
      display: flex;
      width: 100%;
      align-items: flex-start;
      gap: 4px;
      justify-content: center;
      flex: 1;
      flex-wrap: wrap;
      height: 100%;
      padding: 20px 24px;
    }
  
    @media (max-width: 991px) {
      .content-wrapper {
        max-width: 100%;
        padding: 0 20px;
      }
    }
  
    .sidebar {
      display: flex;
      min-width: 240px;
      flex-direction: column;
      overflow: hidden;
      justify-content: flex-start;
      width: 320px;
    }
  
    .sidebar-content {
      background-color: #fff;
      display: flex;
      min-height: 700px;
      width: 100%;
      flex-direction: column;
      justify-content: space-between;
      flex: 1;
      padding: 16px;
    }
  
    .nav-menu {
      display: flex;
      width: 100%;
      flex-direction: column;
      justify-content: flex-start;
    }
  
    .nav-item {
      display: flex;
      width: 100%;
      align-items: center;
      gap: 12px;
      justify-content: flex-start;
      padding: 8px 12px;
    }
  
    .nav-icon {
      align-self: stretch;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      width: 24px;
      margin: auto 0;
    }
  
    .nav-icon-img {
      aspect-ratio: 1;
      object-fit: contain;
      object-position: center;
      width: 24px;
      flex: 1;
    }
  
    .nav-text {
      align-self: stretch;
      color: #000;
      white-space: nowrap;
      margin: auto 0;
      font: 500 14px Lexend, sans-serif;
    }
  
    @media (max-width: 991px) {
      .nav-text {
        white-space: initial;
      }
    }
  
    .nav-item-active {
      border-radius: 12px;
      background-color: #f0f2f5;
    }
  
    .sidebar-footer {
      display: flex;
      margin-top: 731px;
      width: 100%;
      flex-direction: column;
      justify-content: flex-start;
    }
  
    @media (max-width: 991px) {
      .sidebar-footer {
        margin-top: 40px;
      }
    }
  
    .footer-item {
      display: flex;
      width: 100%;
      align-items: center;
      gap: 12px;
      justify-content: flex-start;
      padding: 8px 12px;
    }
  
    .footer-icon {
      align-self: stretch;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      width: 24px;
      margin: auto 0;
    }
  
    .footer-text {
      align-self: stretch;
      color: #000;
      margin: auto 0;
      font: 500 14px Lexend, sans-serif;
    }
  
    .main-content {
      display: flex;
      min-width: 240px;
      flex-direction: column;
      overflow: hidden;
      justify-content: flex-start;
      flex: 1;
      flex-basis: 0%;
      max-width: 960px;
    }
  
    @media (max-width: 991px) {
      .main-content {
        max-width: 100%;
      }
    }
  
    .header {
      display: flex;
      width: 100%;
      align-items: flex-start;
      gap: 12px 0;
      color: #000;
      white-space: nowrap;
      justify-content: space-between;
      flex-wrap: wrap;
      padding: 16px;
      font: 700 32px/1 Lexend, sans-serif;
    }
  
    @media (max-width: 991px) {
      .header {
        max-width: 100%;
        white-space: initial;
      }
    }
  
    .header-title {
      min-width: 288px;
      width: 288px;
    }
  
    @media (max-width: 991px) {
      .header-title {
        white-space: initial;
      }
    }
  
    .tab-container {
      display: flex;
      width: 100%;
      padding-bottom: 12px;
      flex-direction: column;
      justify-content: flex-start;
      font: 700 14px Lexend, sans-serif;
    }
  
    @media (max-width: 991px) {
      .tab-container {
        max-width: 100%;
      }
    }
  
    .tab-list {
      border-color: #dbe0e5;
      border-bottom-width: 1px;
      display: flex;
      width: 100%;
      align-items: flex-start;
      gap: 32px;
      justify-content: flex-start;
      flex-wrap: wrap;
      padding: 0 16px;
    }
  
    @media (max-width: 991px) {
      .tab-list {
        max-width: 100%;
      }
    }
  
    .tab-item {
      border-color: #e5e8eb;
      border-bottom-width: 3px;
      display: flex;
      flex-direction: column;
      align-items: center;
      color: #000;
      white-space: nowrap;
      justify-content: center;
      width: 79px;
      padding: 16px 0 13px;
    }
  
    @media (max-width: 991px) {
      .tab-item {
        white-space: initial;
      }
    }
  
    .tab-text {
      width: 79px;
    }
  
    @media (max-width: 991px) {
      .tab-text {
        white-space: initial;
      }
    }
  
    .stats-container {
      display: flex;
      width: 100%;
      align-items: flex-start;
      gap: 16px;
      font-family: Lexend, sans-serif;
      color: #000;
      justify-content: flex-start;
      flex-wrap: wrap;
      padding: 16px;
    }
  
    @media (max-width: 991px) {
      .stats-container {
        max-width: 100%;
      }
    }
  
    .stat-item {
      border-radius: 12px;
      display: flex;
      min-width: 158px;
      flex-direction: column;
      justify-content: flex-start;
      flex: 1;
      flex-basis: 0%;
      padding: 24px;
      border: 1px solid #dbe0e5;
    }
  
    @media (max-width: 991px) {
      .stat-item {
        padding: 0 20px;
      }
    }
  
    .stat-label {
      width: 100%;
      font-size: 16px;
      font-weight: 500;
    }
  
    .stat-value {
      margin-top: 8px;
      width: 100%;
      font-size: 24px;
      font-weight: 700;
      white-space: nowrap;
      line-height: 1;
    }
  
    @media (max-width: 991px) {
      .stat-value {
        white-space: initial;
      }
    }
  
    .quick-actions-title {
      min-height: 47px;
      width: 100%;
      color: #000;
      padding: 16px 16px 8px;
      font: 700 18px/1 Lexend, sans-serif;
    }
  
    @media (max-width: 991px) {
      .quick-actions-title {
        max-width: 100%;
      }
    }
  
    .quick-action-item {
      display: flex;
      width: 100%;
      flex-direction: column;
      justify-content: center;
      padding: 16px;
      font: 14px Lexend, sans-serif;
    }
  
    @media (max-width: 991px) {
      .quick-action-item {
        max-width: 100%;
      }
    }
  
    .quick-action-content {
      border-radius: 12px;
      display: flex;
      width: 100%;
      align-items: flex-start;
      justify-content: space-between;
      flex-wrap: wrap;
    }
  
    @media (max-width: 991px) {
      .quick-action-content {
        max-width: 100%;
      }
    }
  
    .quick-action-text {
      display: flex;
      min-width: 240px;
      min-height: 161px;
      flex-direction: column;
      justify-content: flex-start;
      width: 573px;
    }
  
    @media (max-width: 991px) {
      .quick-action-text {
        max-width: 100%;
      }
    }
  
    .quick-action-details {
      display: flex;
      width: 100%;
      flex-direction: column;
      color: #000001;
      font-weight: 400;
      justify-content: flex-start;
    }
  
    @media (max-width: 991px) {
      .quick-action-details {
        max-width: 100%;
      }
    }
  
    .quick-action-label {
      width: 100%;
      white-space: nowrap;
    }
  
    @media (max-width: 991px) {
      .quick-action-label {
        max-width: 100%;
        white-space: initial;
      }
    }
  
    .quick-action-title {
      margin-top: 4px;
      width: 100%;
      font-size: 16px;
      color: #000;
      font-weight: 700;
      white-space: nowrap;
      line-height: 1;
    }
  
    @media (max-width: 991px) {
      .quick-action-title {
        max-width: 100%;
        white-space: initial;
      }
    }
  
    .quick-action-description {
      margin-top: 4px;
      width: 100%;
    }
  
    @media (max-width: 991px) {
      .quick-action-description {
        max-width: 100%;
      }
    }
  
    .quick-action-button {
      border-radius: 12px;
      background-color: #f0f2f5;
      display: flex;
      min-width: 84px;
      margin-top: 16px;
      min-height: 32px;
      width: 84px;
      align-items: center;
      overflow: hidden;
      color: #000;
      font-weight: 500;
      white-space: nowrap;
      text-align: center;
      justify-content: center;
      padding: 0 16px;
    }
  
    @media (max-width: 991px) {
      .quick-action-button {
        white-space: initial;
      }
    }
  
    .quick-action-button-text {
      align-self: stretch;
      overflow: hidden;
      margin: auto 0;
    }
  
    @media (max-width: 991px) {
      .quick-action-button-text {
        white-space: initial;
      }
    }
  
    .quick-action-image {
      aspect-ratio: 1.88;
      object-fit: contain;
      object-position: center;
      width: 100%;
      border-radius: 12px;
      min-width: 240px;
      flex: 1;
      flex-basis: 0%;
    }
  
    .courses-title {
      min-height: 47px;
      width: 100%;
      color: #000;
      padding: 16px 16px 8px;
      font: 700 18px/1 Lexend, sans-serif;
    }
  
    @media (max-width: 991px) {
      .courses-title {
        max-width: 100%;
      }
    }
  
    .course-item {
      background-color: #fff;
      display: flex;
      min-height: 72px;
      width: 100%;
      align-items: center;
      gap: 40px 100px;
      justify-content: space-between;
      flex-wrap: wrap;
      padding: 8px 16px;
    }
  
    @media (max-width: 991px) {
      .course-item {
        max-width: 100%;
      }
    }
  
    .course-info {
      align-self: stretch;
      display: flex;
      align-items: center;
      gap: 16px;
      font-family: Lexend, sans-serif;
      justify-content: flex-start;
      margin: auto 0;
    }
  
    .course-image {
      aspect-ratio: 1;
      object-fit: contain;
      object-position: center;
      width: 56px;
      border-radius: 8px;
      align-self: stretch;
      margin: auto 0;
    }
  
    .course-details {
      align-self: stretch;
      display: flex;
      flex-direction: column;
      justify-content: center;
      margin: auto 0;
    }
  
    .course-title {
      max-width: 100%;
      overflow: hidden;
      font-size: 16px;
      color: #000;
      font-weight: 500;
    }
  
    .course-progress {
      max-width: 100%;
      overflow: hidden;
      font-size: 14px;
      color: #000001;
      font-weight: 400;
    }
  
    .course-action {
      align-self: stretch;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      width: 28px;
      margin: auto 0;
    }
  
    .course-action-button {
      display: flex;
      width: 28px;
      align-items: center;
      justify-content: center;
      flex: 1;
      height: 100%;
    }
  
    .course-action-icon {
      aspect-ratio: 1;
      object-fit: contain;
      object-position: center;
      width: 24px;
      align-self: stretch;
      margin: auto 0;
    }
    a{color: black;
        text-decoration: none;}
  </style>
  
</head>
<body>

  <div class="teaching-dashboard">
    <div class="main-container">
      <div class="content-wrapper">
        <nav class="sidebar" aria-label="Main Navigation">
          <div class="sidebar-content">
            <ul class="nav-menu">
              <li class="nav-item">
                <div class="nav-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/ab3212d700556f4846583fcc8379170bf2e01a13e0bc8d9e4ae426f9e97fdcb0?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="nav-text">Home</span>
              </li>
              <li class="nav-item"></li>
              <li class="nav-item">
                <div class="nav-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/4e97e827b2a1692ab3e40d0728284a83eb5ea0541ec7eabbc87487d290504241?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="nav-text">Courses</span>
              </li>
              <li class="nav-item">
                <div class="nav-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/94df25a4f166a64408a0883ac84de6a2980c250104450627583600be934c0d63?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="nav-text"><a href="schedule_lecture.php">Live</a></span>
              </li>
              <li class="nav-item">
                <div class="nav-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/9896726ce5350d386467817f157acb633ad906e781e20b7e30d7b25417c99fb0?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="nav-text"><a href="upload_material.php">Upload Material</a></span>
              </li>
              <li class="nav-item">
                <div class="nav-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/9896726ce5350d386467817f157acb633ad906e781e20b7e30d7b25417c99fb0?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="nav-text"><a href="upload_video.php">Upload video</a></span>
              </li>
              <li class="nav-item">
                <div class="nav-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/9896726ce5350d386467817f157acb633ad906e781e20b7e30d7b25417c99fb0?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="nav-text"><a href="give_assignment.php">Give Assignment</a></span>
              </li>
              <li class="nav-item">
                <div class="nav-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/d9729bab8d6d5f18cf984806640ef62a08e90edaa00914107dd17914a42d4bcd?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="nav-text"><a href="schedule_lecture.php">Schedule Lecture</a></span>
              </li>
              <li class="nav-item nav-item-active">
                <div class="nav-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/a4886430002835c6ff7b1594b958954ea65ae1ed360ebacaf76204c66d522d26?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="nav-text">Teaching</span>
              </li>
            </ul>
            <div class="sidebar-footer">
             
              <div class="sidebar-footer">
              <div class="footer-item">
                <div class="footer-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/4510c340a7d0c7b7e147d8e37a4033e2b7d96b9d83a923086aba4d671fd1e5a8?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="footer-text"><a href="create_quiz.php">Create Test</a></span>
              </div>
              <div class="footer-item">
                <div class="footer-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/4510c340a7d0c7b7e147d8e37a4033e2b7d96b9d83a923086aba4d671fd1e5a8?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="footer-text"><a href="edit_quiz&edit_questions.php">Edit Quiz and Questions</a></span>
              </div>
              <div class="footer-item">
                <div class="footer-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/135b0a051827b3f9bcc90bbc1f4ab1b608bc4aecb0d4e46f3aad275fad02b53b?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="footer-text"><a href="view_results.php">View Results</a></span>
              </div>
              <div class="footer-item">
                <div class="footer-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/135b0a051827b3f9bcc90bbc1f4ab1b608bc4aecb0d4e46f3aad275fad02b53b?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="footer-text"><a href="view_subissions.php">View Submissions</a></span>
              </div>
              <div class="footer-item">
                <div class="footer-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/135b0a051827b3f9bcc90bbc1f4ab1b608bc4aecb0d4e46f3aad275fad02b53b?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="footer-text"><a href="view_violations.php">View Disqualified Students</a>
                </span>
              </div>
              <div class="footer-item">
                <div class="footer-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/135b0a051827b3f9bcc90bbc1f4ab1b608bc4aecb0d4e46f3aad275fad02b53b?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="footer-text"><a href="../public/password_change.php">Change Password</a>
                </span>
              </div>
                <li class="nav-item">
                <div class="nav-icon">
                  <img
                    loading="lazy"
                    src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/a4886430002835c6ff7b1594b958954ea65ae1ed360ebacaf76204c66d522d26?apiKey=47dff2ad50354820a55155efd8d95052&"
                    class="nav-icon-img"
                    alt=""
                  />
                </div>
                <span class="nav-text"><a href="../public/logout.php">Logout</a></span>
              </li>
              </div>
          </div>
        </nav>
        <main class="main-content">
          <header class="header">
            <h1 class="header-title">Teaching</h1>
          </header>
          <div class="tab-container">
            <ul class="tab-list" role="tablist">
              <li class="tab-item" role="tab" aria-selected="true" tabindex="0">
                <span class="tab-text">Dashboard</span>
              </li>
              <li class="tab-item" role="tab" aria-selected="false" tabindex="0">
                <span class="tab-text">My Courses</span>
              </li>
            </ul>
          </div>
          <div class="stats-container">
            <div class="stat-item">
              <span class="stat-label">Course in progress</span>
              <span class="stat-value">5</span>
            </div>
            <div class="stat-item">
              <span class="stat-label">Students</span>
              <span class="stat-value">20</span>
            </div>
            <div class="stat-item">
              <span class="stat-label">Lectures</span>
              <span class="stat-value">4</span>
            </div>
          </div>
          <h2 class="quick-actions-title">Quick Actions</h2>
          <div class="quick-action-item">
            <div class="quick-action-content">
              <div class="quick-action-text">
                <div class="quick-action-details">
                  <span class="quick-action-label">Create</span>
                  <h3 class="quick-action-title">Course</h3>
                  <p class="quick-action-description">Start teaching</p>
                </div>
                <button class="quick-action-button">
                  <span class="quick-action-button-text"><a href="create_course.php">Create</a></span>
                </button>
              </div>
              <img
                loading="lazy"
                src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/b011101fd7767123928b7f8c4d9e5a5d2653bad15ae4038a7b64c02087def6b6?apiKey=47dff2ad50354820a55155efd8d95052&"
                class="quick-action-image"
                alt="Create a new course"
              />
            </div>
          </div>
          <div class="quick-action-item">
            <div class="quick-action-content">
              <div class="quick-action-text">
                <div class="quick-action-details">
                  <span class="quick-action-label">Upload</span>
                  <h3 class="quick-action-title">Materials</h3>
                  <p class="quick-action-description">Create a new lecture</p>
                </div>
                <button class="quick-action-button">
                  <span class="quick-action-button-text"><a href="upload_material">Upload</a></span>
                </button>
              </div>
              <img
                loading="lazy"
                src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/68c197aee876694154051e4fa07bb64f700215e199e0239b899a3d41b30a6c44?apiKey=47dff2ad50354820a55155efd8d95052&"
                class="quick-action-image"
                alt="Upload course materials"
              />
            </div>
          </div>
          <div class="quick-action-item">
            <div class="quick-action-content">
              <div class="quick-action-text">
                <div class="quick-action-details">
                  <span class="quick-action-label">Schedule</span>
                  <h3 class="quick-action-title">Live Class</h3>
                  <p class="quick-action-description">
                    Plan your next live class
                  </p>
                </div>
                <button class="quick-action-button">
                  <span class="quick-action-button-text"><a href="schedule_lecture.php">Schedule</a></span>
                </button>
              </div>
              <img
                loading="lazy"
                src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/920bd2416b809eae4097be3177467fed8113974b9efdb36ba1740f43a630f030?apiKey=47dff2ad50354820a55155efd8d95052&"
                class="quick-action-image"
                alt="Schedule a live class"
              />
            </div>
          </div>
          <h2 class="courses-title">Your courses</h2>
          <div class="course-item">
            <div class="course-info">
              <img
                loading="lazy"
                src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/c13bcf6f4fd13247178a79b036a353960970032a703cf82ec741def2434ce8e7?apiKey=47dff2ad50354820a55155efd8d95052&"
                class="course-image"
                alt="Intro to Economics course thumbnail"
              />
              <div class="course-details">
                <h3 class="course-title">Intro to Economics</h3>
                <span class="course-progress">3/4 lectures</span>
              </div>
            </div>
            <div class="course-action">
              <button class="course-action-button">
                <img
                  loading="lazy"
                  src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/f7d6e60b8f007cc97ff4a8bfef5e382e32760e226318581f2b8c75c3981905f7?apiKey=47dff2ad50354820a55155efd8d95052&"
                  class="course-action-icon"
                  alt="More options"
                />
              </button>
            </div>
          </div>
          <div class="course-item">
            <div class="course-info">
              <img
                loading="lazy"
                src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/ffae328654e1effa9f0c998caec7e8a057344688d6f4ca5cceca0b1fb6063f4b?apiKey=47dff2ad50354820a55155efd8d95052&"
                class="course-image"
                alt="Intro to Psychology course thumbnail"
              />
              <div class="course-details">
                <h3 class="course-title">Intro to Psychology</h3>
                <span class="course-progress">2/4 lectures</span>
              </div>
            </div>
            <div class="course-action">
              <button class="course-action-button">
                <img
                  loading="lazy"
                  src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/ee909af4a64078ef05003330582f905706e8dd49987b6bbb76530a46b32524a9?apiKey=47dff2ad50354820a55155efd8d95052&"
                  class="course-action-icon"
                  alt="More options"
                />
              </button>
            </div>
          </div>
          <div class="course-item">
            <div class="course-info">
              <img
                loading="lazy"
                src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/f2d9d9133680d07967a59f29cceec7a7b3e677acbe9b2bcf9787a1069870a4fb?apiKey=47dff2ad50354820a55155efd8d95052&"
                class="course-image"
                alt="Intro to Philosophy course thumbnail"
              />
              <div class="course-details">
                <h3 class="course-title">Intro to Philosophy</h3>
                <span class="course-progress">1/4 lectures</span>
              </div>
            </div>
            <div class="course-action">
              <button class="course-action-button">
                <img
                  loading="lazy"
                  src="https://cdn.builder.io/api/v1/image/assets/47dff2ad50354820a55155efd8d95052/bc527e89bcfc609cb2ae9a0c71439ed1b6db34ab746c636796e956660f431cdd?apiKey=47dff2ad50354820a55155efd8d95052&"
                  class="course-action-icon"
                  alt="More options"
                />
              </button>
            </div>
          </div>
        </main>
      </div>
    </div>
  </div>

</body>
</html>