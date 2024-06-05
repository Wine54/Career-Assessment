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
            <img src="img/logo_header.png">
        </div>
        <nav class="navigation_bar">
            <a href="career_dashboard.php">Home</a>
            <a href="career_dashbord_contact.php">Contact Us</a>
            <a href="career_dashbord_about.php">About Us</a>
        </nav>
        <a href="career_dashboard_profile.php" class="profile_button"><img src="img/user_profile.jpg"></a>
    </header>

    <div class="main_section">
        <h1>Welcome, <?php echo htmlspecialchars($first_name); ?></h1>
        <h2>About</h2>
        <p>Welcome to this online college course assessment! The purpose of this assessment is to give you recommendations on what college course you should take by calculating each of your answers through processes found in other online assessment.</p>
        <button class="assessment_button" type="button" onclick="startAssessment()">Get Started!</button>
    </div>

    <div class="additional_content_container">
        <div class="additional_content">
            <h2>About Us</h2>
            <p>We are a group of Information and Communications Technology-Programming students from the Philippines who have many peers we know who are still indecisive about what courses they will take after senior high. We have found this incredibly concerning and thus we have created this online career assessment quiz to help future students decide their desired course.</p>
        </div>
    </div>
</body>
</html>
