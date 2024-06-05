<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "main_db";

// Establishing a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user's most recent assessment results from the database
$email = $_SESSION['email'];
$sql = "SELECT realistic, investigative, artistic, social, enterprising, conventional, date 
        FROM assessment_responses 
        WHERE email='$email' 
        ORDER BY date DESC 
        LIMIT 1";
$result = $conn->query($sql);

$categories = [];
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $categories = [
        'Realistic' => $row['realistic'],
        'Investigative' => $row['investigative'],
        'Artistic' => $row['artistic'],
        'Social' => $row['social'],
        'Enterprising' => $row['enterprising'],
        'Conventional' => $row['conventional']
    ];
    $assessment_date = $row['date'];  // Store the assessment date
} else {
    echo "No results found.";
    exit;
}

$conn->close();

// Determine the highest category
$max_score = max($categories);
$dominant_category = array_keys($categories, $max_score)[0];  // Get only the first dominant category

// Course recommendations for each category
$course_recommendations = [
    'Realistic' => [
        'description' => 'Your result indicates that you are a realistic person...',
        'result' => 'Realistic',
        'course' => 'Individuals with a Realistic personality type prefer hands-on, physical activities that involve working with objects, tools, machines, or animals. They enjoy tasks that require physical coordination, strength, and practical problem-solving.',
        'details' => 'Recommended: Agriculture, Health Assistant, Computers, Engineering'
    ],
    'Investigative' => [
        'description' => 'Your result indicates that you are an investigative person...',
        'result' => 'Investigative',
        'course' => 'People with an Investigative personality type enjoy activities that involve thinking, researching, and experimenting. They are drawn to tasks that require critical thinking, intellectual curiosity, and solving complex problems through analysis and exploration.',
        'details' => 'Recommended: Marine Biology, Chemistry, Engineering'
    ],
    'Artistic' => [
        'description' => 'Your result indicates that you are an artistic person...',
        'result' => 'Artistic',
        'course' => 'Artistic individuals thrive in environments that allow for creativity, self-expression, and innovation. They are attracted to activities involving art, music, writing, and performance, where they can use their imagination and originality.',
        'details' => 'Recommended: Communications, Photography, Architecture'
    ],
    'Social' => [
        'description' => 'Your result indicates that you are a social person...',
        'result' => 'Social',
        'course' => 'Those with a Social personality type excel in environments that involve helping, teaching, and caring for others. They enjoy interacting with people, fostering relationships, and making a positive impact on individuals and communities.',
        'details' => 'Recommended: Counseling, Nursing, Public Relations'
    ],
    'Enterprising' => [
        'description' => 'Your result indicates that you are an enterprising person...',
        'result' => 'Enterprising',
        'course' => 'Enterprising individuals are drawn to roles that involve leading, persuading, and managing others to achieve goals. They enjoy activities that require initiative, decision-making, and taking risks to drive success and influence outcomes.',
        'details' => 'Recommended: Fashion Merchandising, Marketing/Sales, Banking/Finance'
    ],
    'Conventional' => [
        'description' => 'Your result indicates that you are a conventional person...',
        'result' => 'Conventional',
        'course' => 'People with a Conventional personality type prefer structured, orderly environments with clear guidelines and routines. They are skilled at organizing, managing details, and performing tasks that require precision, accuracy, and adherence to established procedures.',
        'details' => 'Recommended: Accounting, Administration, Medical Records'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Assessment Result</title>
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
    <div class="container">
        <div class="second">
            <div class="first">
                <h1>Your Dominant Personality Type Is:</h1>
                <h1><?php echo $dominant_category; ?></h1>
                <h2 class="course"><?php echo $course_recommendations[$dominant_category]['result']; ?></h2>
                <h1><?php echo $course_recommendations[$dominant_category]['description']; ?></h1>
                <p style="margin-top: 1rem;">Taken at: <?php echo $assessment_date; ?></p> <!-- Display the assessment date -->
            </div>
            <div class="description">
                <p style="margin-bottom: 0.5rem;"><?php echo $course_recommendations[$dominant_category]['course']; ?></p>
                <p style="text-decoration: underline;"><?php echo $course_recommendations[$dominant_category]['details']; ?></p>
            </div>
            <button class="button" style="vertical-align:middle" type="button" onclick="result()"><span>Go Back</span></button>
        </div>
    </div>
</body>
</html>
