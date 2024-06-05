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

$login_error = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_email']) && isset($_POST['login_password'])) {
    // Retrieve email and password from the form and sanitize inputs
    $email = mysqli_real_escape_string($conn, $_POST['login_email']);
    $password = mysqli_real_escape_string($conn, $_POST['login_password']);

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password FROM myLogin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if a matching record was found
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Valid credentials, set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;

            // Redirect to the dashboard
            header("Location: career_dashboard.php");
            exit(); // Terminate script execution after redirection
        } else {
            // Invalid credentials
            $login_error = "Invalid credentials!";
        }
    } else {
        // Email not found
        $login_error = "Invalid credentials!";
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Assessment</title>
    <link rel="stylesheet" href="css/styles1.css">
    <link rel="stylesheet" href="css/overall.css">
    <link rel="icon" href="img/favicon.jpg">
    <script src="js/script1.js"></script>
</head>
<body class="login_class">
    <div class="login_container">
        <div class="login_logo">
            <img src="img/logo.png" alt="Logo">
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
            <label for="login_email">Email</label>
            <div>
                <input class="login_input" type="email" id="login_email" name="login_email" required>
            </div>

            <label for="login_password">Password</label>
            <div class="login_password_design">
                <input class="login_input" type="password" id="login_password" name="login_password" required>
                <button type="button" class="hide_unhide_password_button" onclick="myHideUnhideFunction()">
                    <img id="hide_unhide" src="img/hide.png" alt="Toggle visibility">
                </button>
            </div>

            <div class="login_forgot_password">
                <div>
            <?php if (!empty($login_error)): ?>
            <p style="color: red; text-align: left;"><?php echo $login_error; ?></p>
        <?php endif; ?>
            </div>
            <div>
                <a href="career_forgotpassword.php">Forgot Password</a>
            </div>
            </div>
                    
            <input class="login_button" type="submit" value="Login">
        </form>
        <div class="login_signup">
            <p>Don't have an account? <a href="career_signup.php">Register Now!</a></p>
        </div>
    </div>
</body>
</html>
