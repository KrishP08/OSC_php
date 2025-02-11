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
    <title>Teacher Dashboard</title>
    <style>
        a{color: black;
            text-decoration: none;}
        .m{
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 class="m">Welcome, Teacher</h2>
<div style="width: 320px; height: 485px; padding: 16px; background: white; flex-direction: column; justify-content: space-between; align-items: flex-start; display: inline-flex">
    <div style="align-self: stretch; height: 280px; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 16px; display: flex">
        <div style="align-self: stretch; flex: 1 1 0; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 8px; display: flex">
            <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
                <div data-svg-wrapper>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_8_11)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5153 9.72844L13.0153 2.65219C13.0116 2.64899 13.0082 2.64554 13.005 2.64188C12.4328 2.1215 11.5588 2.1215 10.9866 2.64188L10.9762 2.65219L3.48469 9.72844C3.17573 10.0125 2.99994 10.4131 3 10.8328V19.5C3 20.3284 3.67157 21 4.5 21H9C9.82843 21 10.5 20.3284 10.5 19.5V15H13.5V19.5C13.5 20.3284 14.1716 21 15 21H19.5C20.3284 21 21 20.3284 21 19.5V10.8328C21.0001 10.4131 20.8243 10.0125 20.5153 9.72844V9.72844ZM19.5 19.5H15V15C15 14.1716 14.3284 13.5 13.5 13.5H10.5C9.67157 13.5 9 14.1716 9 15V19.5H4.5V10.8328L4.51031 10.8234L12 3.75L19.4906 10.8216L19.5009 10.8309L19.5 19.5Z" fill="#121417"/>
                </g>
                <defs>
                <clipPath id="clip0_8_11">
                <rect width="24" height="24" fill="white"/>
                </clipPath>
                </defs>
                </svg>
                </div>
                <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                    <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word">Home</div>
                </div>
            </div>
            <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
                <div data-svg-wrapper>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_8_18)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 2.25H6.75C5.09315 2.25 3.75 3.59315 3.75 5.25V21C3.75 21.4142 4.08579 21.75 4.5 21.75H18C18.4142 21.75 18.75 21.4142 18.75 21C18.75 20.5858 18.4142 20.25 18 20.25H5.25C5.25 19.4216 5.92157 18.75 6.75 18.75H19.5C19.9142 18.75 20.25 18.4142 20.25 18V3C20.25 2.58579 19.9142 2.25 19.5 2.25V2.25ZM18.75 17.25H6.75C6.22326 17.2493 5.70572 17.388 5.25 17.6522V5.25C5.25 4.42157 5.92157 3.75 6.75 3.75H18.75V17.25Z" fill="#121417"/>
                </g>
                <defs>
                <clipPath id="clip0_8_18">
                <rect width="24" height="24" fill="white"/>
                </clipPath>
                </defs>
                </svg>
                </div>
                <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                    <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word">Courses</div>
                </div>
            </div>
            <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
                <div data-svg-wrapper>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_8_25)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 8.25C9.92893 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92893 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25V8.25ZM12 14.25C10.7574 14.25 9.75 13.2426 9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25V14.25ZM18.9103 14.9194C18.5881 15.6812 18.1421 16.3844 17.5903 17.0006C17.3123 17.3014 16.8445 17.3236 16.5393 17.0504C16.2341 16.7772 16.2045 16.3098 16.4728 16.0003C18.5119 13.7236 18.5119 10.2774 16.4728 8.00062C16.289 7.80176 16.2267 7.51926 16.3098 7.26152C16.3928 7.00379 16.6084 6.81084 16.8737 6.75672C17.139 6.7026 17.4129 6.7957 17.5903 7.00031C19.5233 9.1633 20.0372 12.2464 18.9103 14.9194V14.9194ZM6.46875 9.66469C5.56546 11.803 5.97658 14.2704 7.52437 16.0003C7.79265 16.3098 7.76306 16.7772 7.45789 17.0504C7.15273 17.3236 6.68485 17.3014 6.40688 17.0006C3.85725 14.1547 3.85725 9.84622 6.40688 7.00031C6.6831 6.69095 7.15782 6.66408 7.46719 6.94031C7.77655 7.21654 7.80342 7.69126 7.52719 8.00062C7.08469 8.49289 6.72701 9.05523 6.46875 9.66469V9.66469ZM23.25 12C23.2545 14.9454 22.0998 17.7742 20.0353 19.875C19.8494 20.0738 19.5704 20.1562 19.3062 20.0904C19.0421 20.0246 18.8344 19.8209 18.7635 19.5581C18.6925 19.2953 18.7696 19.0148 18.9647 18.825C22.6834 15.0363 22.6834 8.96747 18.9647 5.17875C18.6737 4.88311 18.6775 4.40755 18.9731 4.11656C19.2688 3.82558 19.7443 3.82936 20.0353 4.125C22.0998 6.22578 23.2545 9.05462 23.25 12V12ZM5.03531 18.8231C5.22321 19.0144 5.29481 19.2913 5.22313 19.5497C5.15146 19.808 4.94739 20.0085 4.68782 20.0756C4.42824 20.1427 4.15259 20.0662 3.96469 19.875C-0.329686 15.5032 -0.329686 8.49683 3.96469 4.125C4.15061 3.92621 4.42965 3.84376 4.69376 3.90957C4.95787 3.97537 5.1656 4.1791 5.23653 4.44188C5.30745 4.70466 5.23044 4.98524 5.03531 5.175C1.31661 8.96372 1.31661 15.0325 5.03531 18.8213V18.8231Z" fill="#121417"/>
                </g>
                <defs>
                <clipPath id="clip0_8_25">
                <rect width="24" height="24" fill="white"/>
                </clipPath>
                </defs>
                </svg>
                </div>
                <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                    <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word">Live</div>
                </div>
            </div>
            <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
                <div data-svg-wrapper>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_8_32)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.25 6.75H12.3103L9.75 4.18969C9.46966 3.90711 9.08773 3.74873 8.68969 3.75H3.75C2.92157 3.75 2.25 4.42157 2.25 5.25V18.8081C2.25103 19.604 2.89598 20.249 3.69187 20.25H20.3334C21.1154 20.249 21.749 19.6154 21.75 18.8334V8.25C21.75 7.42157 21.0784 6.75 20.25 6.75V6.75ZM3.75 5.25H8.68969L10.1897 6.75H3.75V5.25ZM20.25 18.75H3.75V8.25H20.25V18.75Z" fill="#121417"/>
                </g>
                <defs>
                <clipPath id="clip0_8_32">
                <rect width="24" height="24" fill="white"/>
                </clipPath>
                </defs>
                </svg>
                </div>
                <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                    <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word"><a href="upload_material.php">Upload Material</a></div>
                </div>
            </div>
            <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
                <div data-svg-wrapper>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_8_32)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.25 6.75H12.3103L9.75 4.18969C9.46966 3.90711 9.08773 3.74873 8.68969 3.75H3.75C2.92157 3.75 2.25 4.42157 2.25 5.25V18.8081C2.25103 19.604 2.89598 20.249 3.69187 20.25H20.3334C21.1154 20.249 21.749 19.6154 21.75 18.8334V8.25C21.75 7.42157 21.0784 6.75 20.25 6.75V6.75ZM3.75 5.25H8.68969L10.1897 6.75H3.75V5.25ZM20.25 18.75H3.75V8.25H20.25V18.75Z" fill="#121417"/>
                </g>
                <defs>
                <clipPath id="clip0_8_32">
                <rect width="24" height="24" fill="white"/>
                </clipPath>
                </defs>
                </svg>
                </div>
                <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                    <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word"><a href="upload_video.php">Upload video</a></div>
                </div>
            </div>
            <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
                <div data-svg-wrapper>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_8_32)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M20.25 6.75H12.3103L9.75 4.18969C9.46966 3.90711 9.08773 3.74873 8.68969 3.75H3.75C2.92157 3.75 2.25 4.42157 2.25 5.25V18.8081C2.25103 19.604 2.89598 20.249 3.69187 20.25H20.3334C21.1154 20.249 21.749 19.6154 21.75 18.8334V8.25C21.75 7.42157 21.0784 6.75 20.25 6.75V6.75ZM3.75 5.25H8.68969L10.1897 6.75H3.75V5.25ZM20.25 18.75H3.75V8.25H20.25V18.75Z" fill="#121417"/>
                </g>
                <defs>
                <clipPath id="clip0_8_32">
                <rect width="24" height="24" fill="white"/>
                </clipPath>
                </defs>
                </svg>
                </div>
                <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                    <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word"><a href="give_assignment.php">Give Assignment</a></div>
                </div>
            </div>
            <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
                <div data-svg-wrapper>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_8_39)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 3H17.25V2.25C17.25 1.83579 16.9142 1.5 16.5 1.5C16.0858 1.5 15.75 1.83579 15.75 2.25V3H8.25V2.25C8.25 1.83579 7.91421 1.5 7.5 1.5C7.08579 1.5 6.75 1.83579 6.75 2.25V3H4.5C3.67157 3 3 3.67157 3 4.5V19.5C3 20.3284 3.67157 21 4.5 21H19.5C20.3284 21 21 20.3284 21 19.5V4.5C21 3.67157 20.3284 3 19.5 3V3ZM6.75 4.5V5.25C6.75 5.66421 7.08579 6 7.5 6C7.91421 6 8.25 5.66421 8.25 5.25V4.5H15.75V5.25C15.75 5.66421 16.0858 6 16.5 6C16.9142 6 17.25 5.66421 17.25 5.25V4.5H19.5V7.5H4.5V4.5H6.75ZM19.5 19.5H4.5V9H19.5V19.5V19.5ZM10.5 11.25V17.25C10.5 17.6642 10.1642 18 9.75 18C9.33579 18 9 17.6642 9 17.25V12.4631L8.58562 12.6713C8.2149 12.8566 7.76411 12.7063 7.57875 12.3356C7.39339 11.9649 7.54365 11.5141 7.91437 11.3287L9.41438 10.5787C9.64695 10.4624 9.92322 10.4748 10.1444 10.6116C10.3656 10.7483 10.5002 10.9899 10.5 11.25V11.25ZM16.0462 14.1047L14.25 16.5H15.75C16.1642 16.5 16.5 16.8358 16.5 17.25C16.5 17.6642 16.1642 18 15.75 18H12.75C12.4659 18 12.2062 17.8395 12.0792 17.5854C11.9521 17.3313 11.9796 17.0273 12.15 16.8L14.8481 13.2028C15.0153 12.9802 15.0455 12.6833 14.9264 12.4316C14.8073 12.1799 14.5586 12.0149 14.2804 12.003C14.0023 11.9912 13.7404 12.1344 13.6003 12.375C13.4702 12.6146 13.2203 12.7647 12.9476 12.7671C12.675 12.7694 12.4226 12.6236 12.2884 12.3863C12.1542 12.1489 12.1593 11.8574 12.3019 11.625C12.8112 10.7435 13.849 10.3139 14.8324 10.5774C15.8158 10.8409 16.4997 11.7319 16.5 12.75C16.5016 13.2391 16.3421 13.7152 16.0462 14.1047V14.1047Z" fill="#121417"/>
                </g>
                <defs>
                <clipPath id="clip0_8_39">
                <rect width="24" height="24" fill="white"/>
                </clipPath>
                </defs>
                </svg>
                </div>
                <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                    <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word"><a href="schedule_lecture.php">Schedule Lecture</a></div>
                </div>
            </div>
        </div>
    </div>
    <div style="align-self: stretch; height: 128px; flex-direction: column; justify-content: flex-start; align-items: flex-start; gap: 4px; display: flex">
        <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
            <div data-svg-wrapper>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_8_54)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M21 12C21 12.4142 20.6642 12.75 20.25 12.75H12.75V20.25C12.75 20.6642 12.4142 21 12 21C11.5858 21 11.25 20.6642 11.25 20.25V12.75H3.75C3.33579 12.75 3 12.4142 3 12C3 11.5858 3.33579 11.25 3.75 11.25H11.25V3.75C11.25 3.33579 11.5858 3 12 3C12.4142 3 12.75 3.33579 12.75 3.75V11.25H20.25C20.6642 11.25 21 11.5858 21 12V12Z" fill="#121417"/>
            </g>
            <defs>
            <clipPath id="clip0_8_54">
            <rect width="24" height="24" fill="white"/>
            </clipPath>
            </defs>
            </svg>
            </div>
            <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word"><a href="create_course.php">Create a Course</a></div>
            </div>
        </div>
        <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
            <div data-svg-wrapper>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_8_54)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M21 12C21 12.4142 20.6642 12.75 20.25 12.75H12.75V20.25C12.75 20.6642 12.4142 21 12 21C11.5858 21 11.25 20.6642 11.25 20.25V12.75H3.75C3.33579 12.75 3 12.4142 3 12C3 11.5858 3.33579 11.25 3.75 11.25H11.25V3.75C11.25 3.33579 11.5858 3 12 3C12.4142 3 12.75 3.33579 12.75 3.75V11.25H20.25C20.6642 11.25 21 11.5858 21 12V12Z" fill="#121417"/>
            </g>
            <defs>
            <clipPath id="clip0_8_54">
            <rect width="24" height="24" fill="white"/>
            </clipPath>
            </defs>
            </svg>
            </div>
            <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word"><a href="create_quiz.php">Create Test</a></div>
            </div>
        </div>
        <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
            <div data-svg-wrapper>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_8_61)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M22.95 14.1C22.6186 14.3485 22.1485 14.2814 21.9 13.95C20.9833 12.7178 19.5358 11.994 18 12C17.6985 12 17.4263 11.8194 17.3091 11.5416C17.2304 11.3551 17.2304 11.1449 17.3091 10.9584C17.4263 10.6806 17.6985 10.5 18 10.5C19.1692 10.4999 20.1435 9.60425 20.2418 8.43916C20.3401 7.27406 19.5297 6.22784 18.377 6.03184C17.2243 5.83584 16.1136 6.55539 15.8212 7.6875C15.7177 8.08877 15.3085 8.33012 14.9072 8.22656C14.5059 8.12301 14.2646 7.71377 14.3681 7.3125C14.7687 5.76266 16.1088 4.63794 17.7047 4.51237C19.3005 4.38679 20.8001 5.28805 21.4381 6.75618C22.0761 8.2243 21.7119 9.93555 20.5312 11.0166C21.5511 11.4581 22.4376 12.1588 23.1028 13.0491C23.2222 13.2086 23.2731 13.4091 23.2444 13.6062C23.2158 13.8034 23.1098 13.9811 22.95 14.1V14.1ZM17.8988 19.875C18.0465 20.1075 18.055 20.4023 17.9207 20.6429C17.7865 20.8834 17.5311 21.031 17.2557 21.0273C16.9802 21.0236 16.7289 20.8691 16.6012 20.625C15.64 18.9973 13.8903 17.9986 12 17.9986C10.1097 17.9986 8.36001 18.9973 7.39875 20.625C7.27105 20.8691 7.0198 21.0236 6.74434 21.0273C6.46887 21.031 6.21353 20.8834 6.07928 20.6429C5.94502 20.4023 5.95346 20.1075 6.10125 19.875C6.82837 18.6257 7.93706 17.6425 9.26437 17.07C7.73297 15.8975 7.11905 13.8795 7.73805 12.0528C8.35704 10.2261 10.0713 8.997 12 8.997C13.9287 8.997 15.643 10.2261 16.262 12.0528C16.8809 13.8795 16.267 15.8975 14.7356 17.07C16.0629 17.6425 17.1716 18.6257 17.8988 19.875V19.875ZM12 16.5C13.6569 16.5 15 15.1569 15 13.5C15 11.8431 13.6569 10.5 12 10.5C10.3431 10.5 9 11.8431 9 13.5C9 15.1569 10.3431 16.5 12 16.5V16.5ZM6.75 11.25C6.75 10.8358 6.41421 10.5 6 10.5C4.83076 10.4999 3.85646 9.60425 3.75816 8.43916C3.65987 7.27406 4.47034 6.22784 5.62303 6.03184C6.77572 5.83584 7.88644 6.55539 8.17875 7.6875C8.2823 8.08877 8.69154 8.33012 9.09281 8.22656C9.49408 8.12301 9.73543 7.71377 9.63188 7.3125C9.23134 5.76266 7.89116 4.63794 6.29533 4.51237C4.6995 4.38679 3.19991 5.28805 2.56189 6.75618C1.92388 8.2243 2.28813 9.93555 3.46875 11.0166C2.44995 11.4585 1.56442 12.1592 0.9 13.0491C0.651213 13.3804 0.71816 13.8507 1.04953 14.0995C1.3809 14.3483 1.85121 14.2814 2.1 13.95C3.01674 12.7178 4.46416 11.994 6 12C6.41421 12 6.75 11.6642 6.75 11.25V11.25Z" fill="#121417"/>
            </g>
            <defs>
            <clipPath id="clip0_8_61">
            <rect width="24" height="24" fill="white"/>
            </clipPath>
            </defs>
            </svg>
            </div>
            <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word"><a href="view_results.php">View Results</a></div>
            </div>
        </div>
        <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
            <div data-svg-wrapper>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_8_68)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1853 11.6962C23.1525 11.6222 22.3584 9.86062 20.5931 8.09531C18.2409 5.74312 15.27 4.5 12 4.5C8.73 4.5 5.75906 5.74312 3.40687 8.09531C1.64156 9.86062 0.84375 11.625 0.814687 11.6962C0.728449 11.8902 0.728449 12.1117 0.814687 12.3056C0.8475 12.3797 1.64156 14.1403 3.40687 15.9056C5.75906 18.2569 8.73 19.5 12 19.5C15.27 19.5 18.2409 18.2569 20.5931 15.9056C22.3584 14.1403 23.1525 12.3797 23.1853 12.3056C23.2716 12.1117 23.2716 11.8902 23.1853 11.6962V11.6962ZM12 18C9.11438 18 6.59344 16.9509 4.50656 14.8828C3.65029 14.0313 2.9218 13.0603 2.34375 12C2.92165 10.9396 3.65015 9.9686 4.50656 9.11719C6.59344 7.04906 9.11438 6 12 6C14.8856 6 17.4066 7.04906 19.4934 9.11719C20.3514 9.9684 21.0815 10.9394 21.6609 12C20.985 13.2619 18.0403 18 12 18V18ZM12 7.5C9.51472 7.5 7.5 9.51472 7.5 12C7.5 14.4853 9.51472 16.5 12 16.5C14.4853 16.5 16.5 14.4853 16.5 12C16.4974 9.51579 14.4842 7.50258 12 7.5V7.5ZM12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12C15 13.6569 13.6569 15 12 15V15Z" fill="#121417"/>
            </g>
            <defs>
            <clipPath id="clip0_8_68">
            <rect width="24" height="24" fill="white"/>
            </clipPath>
            </defs>
            </svg>
            </div>
            <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word"><a href="view_subissions.php">View Submissions</a></div>
            </div>
        </div>
                <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
            <div data-svg-wrapper>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_8_68)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M23.1853 11.6962C23.1525 11.6222 22.3584 9.86062 20.5931 8.09531C18.2409 5.74312 15.27 4.5 12 4.5C8.73 4.5 5.75906 5.74312 3.40687 8.09531C1.64156 9.86062 0.84375 11.625 0.814687 11.6962C0.728449 11.8902 0.728449 12.1117 0.814687 12.3056C0.8475 12.3797 1.64156 14.1403 3.40687 15.9056C5.75906 18.2569 8.73 19.5 12 19.5C15.27 19.5 18.2409 18.2569 20.5931 15.9056C22.3584 14.1403 23.1525 12.3797 23.1853 12.3056C23.2716 12.1117 23.2716 11.8902 23.1853 11.6962V11.6962ZM12 18C9.11438 18 6.59344 16.9509 4.50656 14.8828C3.65029 14.0313 2.9218 13.0603 2.34375 12C2.92165 10.9396 3.65015 9.9686 4.50656 9.11719C6.59344 7.04906 9.11438 6 12 6C14.8856 6 17.4066 7.04906 19.4934 9.11719C20.3514 9.9684 21.0815 10.9394 21.6609 12C20.985 13.2619 18.0403 18 12 18V18ZM12 7.5C9.51472 7.5 7.5 9.51472 7.5 12C7.5 14.4853 9.51472 16.5 12 16.5C14.4853 16.5 16.5 14.4853 16.5 12C16.4974 9.51579 14.4842 7.50258 12 7.5V7.5ZM12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12C15 13.6569 13.6569 15 12 15V15Z" fill="#121417"/>
            </g>
            <defs>
            <clipPath id="clip0_8_68">
            <rect width="24" height="24" fill="white"/>
            </clipPath>
            </defs>
            </svg>
            </div>
            <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word"><a href="view_subissions.php">View Submissions</a></div>
            </div>
        </div>
        <div style="align-self: stretch; padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; background: #F0F2F5; border-radius: 12px; justify-content: flex-start; align-items: center; gap: 12px; display: inline-flex">
                <div data-svg-wrapper>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_8_46)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5 18H21.75V5.25C21.75 4.42157 21.0784 3.75 20.25 3.75H3.75C2.92157 3.75 2.25 4.42157 2.25 5.25V18H1.5C1.08579 18 0.75 18.3358 0.75 18.75C0.75 19.1642 1.08579 19.5 1.5 19.5H22.5C22.9142 19.5 23.25 19.1642 23.25 18.75C23.25 18.3358 22.9142 18 22.5 18V18ZM20.25 18H13.5V16.5C13.5 16.0858 13.8358 15.75 14.25 15.75H19.5C19.9142 15.75 20.25 16.0858 20.25 16.5V18ZM20.25 13.5C20.25 13.9142 19.9142 14.25 19.5 14.25C19.0858 14.25 18.75 13.9142 18.75 13.5V6.75H5.25V17.25C5.25 17.6642 4.91421 18 4.5 18C4.08579 18 3.75 17.6642 3.75 17.25V6C3.75 5.58579 4.08579 5.25 4.5 5.25H19.5C19.9142 5.25 20.25 5.58579 20.25 6V13.5Z" fill="#121417"/>
                </g>
                <defs>
                <clipPath id="clip0_8_46">
                <rect width="24" height="24" fill="white"/>
                </clipPath>
                </defs>
                </svg>
                </div>
                <div style="flex-direction: column; justify-content: flex-start; align-items: flex-start; display: inline-flex">
                    <div style="color: #121417; font-size: 14px; font-family: Lexend; font-weight: 500; line-height: 21px; word-wrap: break-word"><a href="../public/logout.php">Logout</a></div>
                </div>
            </div>
    </div>

</div>

</body>
</html>