<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Assessment</title>
    <link rel="stylesheet" href="css/overall.css">
    <link rel="stylesheet" href="css/styles2.css">
    <link rel="icon" href="img/favicon.jpg">
    <script src="js/script2.js"></script>
</head>
<body class="signup_class">

<?php
$conn = mysqli_connect("localhost", "root", "", "main_db");
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

$error_message = "";
$signed_up = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['signup_fname'];
    $lname = $_POST['signup_lname'];
    $email = $_POST['signup_email'];
    $password = $_POST['signup_password'];
    $confirm_password = $_POST['signup_confirmpassword'];

    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($confirm_password)) {
        $error_message = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        $check_email_query = "SELECT * FROM myLogin WHERE email=?";
        $stmt = $conn->prepare($check_email_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error_message = "Email already exists.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO myLogin (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("ssss", $fname, $lname, $email, $hashed_password);
            if ($stmt->execute()) {
                $signed_up = true;
                header("Refresh: 2; URL=career_login.php");
                $success_message = "Registration successful! Redirecting to login page...";
                
            } else {
                $error_message = "Error: " . $stmt->error;
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>

<div class="signup_container">
    <div class="signup_logo">
        <img src="img/logo.png">
    </div>
    <br>
    <hr>
    <h1> Registration Form</h1>
    <p> Please fill in this form to register an account.</p>
    <br>
    <hr>
    <br>

    <form id="signup_form" action="" method="post" autocomplete="off" onsubmit="return validateForm()">
        <label for="signup_fname">First Name</label>
        <div>
            <input class="input_box" type="text" id="signup_fname" for="signup_fname" name="signup_fname">
        </div>

        <label for="signup_lname">Last Name</label>
        <div>
            <input class="input_box" type="text" id="signup_lname" for="signup_lname" name="signup_lname">
        </div>

        <label for="signup_email">Email</label>
        <div>
            <input class="input_box" type="email" id="signup_email" for="signup_email" name="signup_email">
        </div>

        <label for="signup_password">Password</label>
<div class="sign_password_design">
    <input class="input_box" type="password" id="signup_password" name="signup_password">
    <button type="button" class="hide_unhide_password_button" onclick="myHideUnhideFunction('signup_password', 'hide_unhide_password_button')">
        <img id="hide_unhide_password_button" src="img/hide.png">
    </button>
</div>

<label for="signup_confirmpassword">Confirm Password</label>
<div class="sign_password_design">
    <input class="input_box" type="password" id="signup_confirmpassword" name="signup_confirmpassword">
    <button type="button" class="hide_unhide_password_button" onclick="myHideUnhideFunction('signup_confirmpassword', 'hide_unhide_confirmpassword_button')">
        <img id="hide_unhide_confirmpassword_button" src="img/hide.png">
    </button>
</div>



        <div id="error_message" style="display:none;">
        <p style='color:red; margin-bottom: -1rem;'>All fields are required.</p>
    </div>
    <?php
    if (!empty($error_message)) {
        echo "<div id='server_error_message' style='color:red; margin-bottom: -1rem; '>$error_message</div>";
    }
    ?>

    <?php
    if (!empty($success_message)) {
        echo "<div id='success_message' style='color:green; text-align: center;'>$success_message</div>";
        echo "<script>alert('Successfully Registered!');</script>";
    }
    ?>
        <input class="signup_button" type="submit" value="Register">
    </form>

    <div class="signup_login">
        <p>Already have an account? <a href="career_login.php">Log In</a></p>
    </div>
</div>

</body>
</html>
