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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email']; // Get email from session

    // Initialize variables to store counts for each category
    $realistic = 0;
    $investigative = 0;
    $artistic = 0;
    $social = 0;
    $enterprising = 0;
    $conventional = 0;

    // Iterate through each question and update the respective count
    for ($i = 1; $i <= 8; $i++) {
        // Get the answer for each question
        $answer = isset($_POST["q$i"]) ? intval($_POST["q$i"]) : 0;
        
        // Update the respective count based on the category of the question
        for ($i = 1; $i <= 60; $i++) {
            // Get the answer for each question
            $answer = isset($_POST["q$i"]) ? intval($_POST["q$i"]) : 0;

            // Update the respective count based on the category of the question
            if ($i >= 1 && $i <= 10) {
                $realistic += $answer;
            } elseif ($i >= 11 && $i <= 20) {
                $investigative += $answer;
            } elseif ($i >= 21 && $i <= 30) {
                $artistic += $answer;
            } elseif ($i >= 31 && $i <= 40) {
                $social += $answer;
            } elseif ($i >= 41 && $i <= 50) {
                $enterprising += $answer;
            } elseif ($i >= 51 && $i <= 60) {
                $conventional += $answer;
            }
        }

    }

    // Insert data into the database
    $sql = "INSERT INTO assessment_responses (email, realistic, investigative, artistic, social, enterprising, conventional)
            VALUES ('$email', '$realistic', '$investigative', '$artistic', '$social', '$enterprising', '$conventional')";

    if ($conn->query($sql) === TRUE) {
        $message = "Your response have been saved!";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
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
    
    <div class="assessment_container">
        <div class="questionholder">
            <?php if (isset($message)): ?>
                <p><?php echo $message; ?></p>
                <?php echo "<script>alert('Done!');</script>"; ?>
                <?php header("Refresh: 3; url=career_result.php"); ?>
            <?php else: ?>
                <form id="assessmentForm" method="POST" action="">
    <!-- Realistic -->
<div class="question active" id="question1">
    <label>Do you enjoy working with your hands, like building or repairing things?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q1" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q1" value="0">No</label>
    </div>
</div>

<div class="question" id="question2">
    <label>Do you prefer spending time outdoors, such as gardening or hiking?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q2" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q2" value="0">No</label>
    </div>
</div>

<div class="question" id="question3">
    <label>Do you like operating machinery or equipment?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q3" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q3" value="0">No</label>
    </div>
</div>

<div class="question" id="question4">
    <label>Are you interested in jobs that involve being outside, like farming or landscaping?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q4" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q4" value="0">No</label>
    </div>
</div>

<div class="question" id="question5">
    <label>Do you often use tools like saws, hammers, or drills for projects?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q5" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q5" value="0">No</label>
    </div>
</div>

<div class="question" id="question6">
    <label>Do you prefer physically active jobs over desk jobs?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q6" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q6" value="0">No</label>
    </div>
</div>

<div class="question" id="question7">
    <label>Are you fascinated by how machines work and enjoy fixing them?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q7" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q7" value="0">No</label>
    </div>
</div>

<div class="question" id="question8">
    <label>Do you have hobbies that involve working with engines, electronics, or other mechanical systems?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q8" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q8" value="0">No</label>
    </div>
</div>

<div class="question" id="question9">
    <label>Do you enjoy solving practical problems, like fixing a broken appliance or assembling furniture?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q9" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q9" value="0">No</label>
    </div>
</div>

<div class="question" id="question10">
    <label>Do you like working with animals, such as in a veterinary setting or on a farm?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q10" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q10" value="0">No</label>
    </div>
</div>


    <!-- Investigative -->
<div class="question" id="question11">
    <label>Do you enjoy solving complex problems and puzzles?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q11" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q11" value="0">No</label>
    </div>
</div>

<div class="question" id="question12">
    <label>Are you interested in conducting research or experiments?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q12" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q12" value="0">No</label>
    </div>
</div>

<div class="question" id="question13">
    <label>Do you like reading scientific books or articles?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q13" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q13" value="0">No</label>
    </div>
</div>

<div class="question" id="question14">
    <label>Do you enjoy activities that involve analysis and critical thinking?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q14" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q14" value="0">No</label>
    </div>
</div>

<div class="question" id="question15">
    <label>Are you fascinated by subjects like biology, chemistry, or physics?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q15" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q15" value="0">No</label>
    </div>
</div>

<div class="question" id="question16">
    <label>Do you prefer tasks that require deep concentration and focus?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q16" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q16" value="0">No</label>
    </div>
</div>

<div class="question" id="question17">
    <label>Do you enjoy working with data, graphs, and statistics?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q17" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q17" value="0">No</label>
    </div>
</div>

<div class="question" id="question18">
    <label>Are you interested in understanding how things work and why they happen?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q18" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q18" value="0">No</label>
    </div>
</div>

<div class="question" id="question19">
    <label>Do you like exploring new ideas and theories?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q19" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q19" value="0">No</label>
    </div>
</div>

<div class="question" id="question20">
    <label>Do you enjoy learning about new scientific discoveries and technologies?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q20" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q20" value="0">No</label>
    </div>
</div>


    <!-- Artistic -->

<div class="question" id="question21">
    <label>Do you enjoy creating art, such as drawing, painting, or sculpting?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q21" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q21" value="0">No</label>
    </div>
</div>

<div class="question" id="question22">
    <label>Do you like expressing yourself through writing, like stories or poems?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q22" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q22" value="0">No</label>
    </div>
</div>

<div class="question" id="question23">
    <label>Are you interested in music, whether playing an instrument, singing, or composing?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q23" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q23" value="0">No</label>
    </div>
</div>

<div class="question" id="question24">
    <label>Do you enjoy activities that involve acting, dancing, or performing?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q24" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q24" value="0">No</label>
    </div>
</div>

<div class="question" id="question25">
    <label>Do you prefer unstructured tasks that allow for creativity and imagination?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q25" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q25" value="0">No</label>
    </div>
</div>

<div class="question" id="question26">
    <label>Do you enjoy visiting museums, art galleries, or theaters?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q26" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q26" value="0">No</label>
    </div>
</div>

<div class="question" id="question27">
    <label>Are you drawn to designing things, like fashion, interiors, or graphics?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q27" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q27" value="0">No</label>
    </div>
</div>

<div class="question" id="question28">
    <label>Do you find satisfaction in crafting or DIY projects?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q28" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q28" value="0">No</label>
    </div>
</div>

<div class="question" id="question29">
    <label>Do you like exploring different forms of media, such as photography or filmmaking?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q29" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q29" value="0">No</label>
    </div>
</div>

<div class="question" id="question30">
    <label>Do you often think of innovative ideas or unique ways to solve problems?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q30" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q30" value="0">No</label>
    </div>
</div>

    <!-- Social -->

<div class="question" id="question31">
    <label>Do you enjoy helping others solve their problems or challenges?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q31" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q31" value="0">No</label>
    </div>
</div>

<div class="question" id="question32">
    <label>Are you interested in teaching or instructing others?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q32" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q32" value="0">No</label>
    </div>
</div>

<div class="question" id="question33">
    <label>Do you like volunteering or participating in community service activities?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q33" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q33" value="0">No</label>
    </div>
</div>

<div class="question" id="question34">
    <label>Do you find satisfaction in providing care or support to others?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q34" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q34" value="0">No</label>
    </div>
</div>

<div class="question" id="question35">
    <label>Do you enjoy working in teams or group settings?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q35" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q35" value="0">No</label>
    </div>
</div>

<div class="question" id="question36">
    <label>Are you drawn to activities that involve counseling or advising people?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q36" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q36" value="0">No</label>
    </div>
</div>

<div class="question" id="question37">
    <label>Do you like organizing and leading group activities or events?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q37" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q37" value="0">No</label>
    </div>
</div>

<div class="question" id="question38">
    <label>Do you feel fulfilled when you make a positive impact on someone's life?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q38" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q38" value="0">No</label>
    </div>
</div>

<div class="question" id="question39">
    <label>Do you enjoy meeting new people and building relationships?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q39" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q39" value="0">No</label>
    </div>
</div>

<div class="question" id="question40">
    <label>Are you interested in understanding and addressing social issues?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q40" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q40" value="0">No</label>
    </div>
</div>


    <!-- Enterprising -->

<div class="question" id="question41">
    <label>Do you enjoy leading and motivating others to achieve goals?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q41" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q41" value="0">No</label>
    </div>
</div>

<div class="question" id="question42">
    <label>Are you interested in starting and running your own business?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q42" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q42" value="0">No</label>
    </div>
</div>

<div class="question" id="question43">
    <label>Do you like persuading others to see your point of view?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q43" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q43" value="0">No</label>
    </div>
</div>

<div class="question" id="question44">
    <label>Do you enjoy taking on leadership roles in projects or activities?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q44" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q44" value="0">No</label>
    </div>
</div>

<div class="question" id="question45">
    <label>Are you drawn to activities that involve selling products or services?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q45" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q45" value="0">No</label>
    </div>
</div>

<div class="question" id="question46">
    <label>Do you feel confident making decisions and taking risks?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q46" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q46" value="0">No</label>
    </div>
</div>

<div class="question" id="question47">
    <label>Do you enjoy organizing and managing events or operations?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q47" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q47" value="0">No</label>
    </div>
</div>

<div class="question" id="question48">
    <label>Are you interested in public speaking or presenting ideas to groups?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q48" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q48" value="0">No</label>
    </div>
</div>

<div class="question" id="question49">
    <label>Do you like negotiating and finding solutions to conflicts?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q49" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q49" value="0">No</label>
    </div>
</div>

<div class="question" id="question50">
    <label>Do you thrive in competitive environments and aim to achieve high levels of success?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q50" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q50" value="0">No</label>
    </div>
</div>


    <!-- Conventional -->

<div class="question" id="question51">
    <label>Do you enjoy organizing and maintaining detailed records or files?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q51" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q51" value="0">No</label>
    </div>
</div>

<div class="question" id="question52">
    <label>Are you interested in working with numbers and performing calculations?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q52" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q52" value="0">No</label>
    </div>
</div>

<div class="question" id="question53">
    <label>Do you like following set procedures and guidelines to complete tasks?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q53" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q53" value="0">No</label>
    </div>
</div>

<div class="question" id="question54">
    <label>Do you enjoy tasks that require accuracy and attention to detail?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q54" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q54" value="0">No</label>
    </div>
</div>

<div class="question" id="question55">
    <label>Are you drawn to organizing data in spreadsheets or databases?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q55" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q55" value="0">No</label>
    </div>
</div>

<div class="question" id="question56">
    <label>Do you feel comfortable working with established systems and routines?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q56" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q56" value="0">No</label>
    </div>
</div>

<div class="question" id="question57">
    <label>Do you like tasks that involve managing schedules and planning?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q57" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q57" value="0">No</label>
    </div>
</div>

<div class="question" id="question58">
    <label>Are you interested in keeping track of financial information, such as budgeting or bookkeeping?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q58" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q58" value="0">No</label>
    </div>
</div>

<div class="question" id="question59">
    <label>Do you enjoy categorizing and systematically arranging items or information?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q59" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q59" value="0">No</label>
    </div>
</div>

<div class="question" id="question60">
    <label>Do you prefer working in a structured environment with clear expectations?</label>
    <div class="checkbox_choices">
        <label><input class="checkbox_edit" type="radio" name="q60" value="1">Yes</label>
        <label><input class="checkbox_edit" type="radio" name="q60" value="0">No</label>
    </div>
</div>

    
    <button class="next_button" type="button" onclick="nextQuestion()">Next Question</button>
    <button class="back_button" id="goBackButton" type="button" onclick="prevQuestion()">Go Back</button>
    <button class="last_button" type="submit">Submit</button>
</form>

            <?php endif; ?>
        </div>
    </div>
</body>
</html>
