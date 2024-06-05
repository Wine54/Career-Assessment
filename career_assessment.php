<?php
session_start(); // Start the session

if (!isset($_SESSION['email'])) {
    // Redirect to login page if not logged in
    header("Location: career_login.php");
    exit();
}

$email = $_SESSION['email'];

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "main_db";

// Establishing a connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Retrieve the user's first name from the database
$query = "SELECT first_name FROM myLogin WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($first_name);
$stmt->fetch();
$stmt->close();
$conn->close();

// If the first name is not found, set a default value
if (empty($first_name)) {
    $first_name = "User";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Assessment</title>
    <link rel="stylesheet" href="css/overall.css">
    <link rel="stylesheet" href="css/styles4.css">
    <link rel="icon" href="img/favicon.jpg">
    <script src="js/script4.js"></script>
</head>
<body class="dashboard_class">
    <header class="header_container">
        <div class="header_logo">
            <img src="img/logo_header.png" alt="Logo">
        </div>
        <nav class="navigation_bar">
            <a href="career_dashboard.php">Home</a>
            <a href="career_dashbord_contact.php">Contact Us</a>
            <a href="career_dashbord_about.php">About Us</a>
        </nav>
        <a href="career_dashboard_profile.php" class="profile_button"><img src="img/user_profile.jpg" alt="User Profile"></a>
    </header>
    
    <div class="main_section">
        <h1>Welcome to the Career Assessment</h1>
        <p>Discover your ideal career path based on your interests and preferences. This assessment will guide you through a series of questions to help identify your strengths and areas of interest. Let's get started and explore the best career options for you!</p>
        <button class="assessment_button" type="button" onclick="startAssessmentTest()">Start Assessment</button>
    </div>

    <div class="additional_content_container">
        <div class="additional_content">
            <h2>Instructions for Taking the Assessment</h2>
            <p>
                Learn how to proceed with the assessment. Find out how many questions there are, how to answer them, and what to expect after completing the assessment.
            </p>
            <ol>
                <li>Start the assessment by clicking on the "Get Started" button.</li>
                <li>Read each question carefully and select the answer that best represents your preferences or abilities.</li>
                <li>Answer all questions honestly and to the best of your ability.</li>
                <li>Once you have completed all questions, click on the submit button to receive your assessment results.</li>
                <li>Review your results carefully and consider the recommendations provided.</li>
                <li>Use the insights gained from the assessment to explore potential career paths and make informed decisions about your future.</li>
            </ol>
        </div>
    </div>

</body>
</html>
