<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "main_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['forgot_email'])) {
        $forgot_email = $conn->real_escape_string($_POST['forgot_email']);
        $sql = "SELECT id FROM myLogin WHERE email='$forgot_email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Email exists
            $email_valid = true;
        } else {
            // Email does not exist
            $email_error = "Email not found";
        }
    } elseif (isset($_POST['email']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $new_password = $conn->real_escape_string($_POST['new_password']);
        $confirm_password = $conn->real_escape_string($_POST['confirm_password']);

        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            
            // Update password in the database
            $sql = "UPDATE myLogin SET password='$hashed_password' WHERE email='$email'";

            if ($conn->query($sql) === TRUE) {
                $reset_success = "Password reset successfully.";
                // Optionally redirect to login page
                header("Location: career_login.php");
                exit();
            } else {
                $reset_error = "Error updating password: " . $conn->error;
            }
        } else {
            $reset_error = "Passwords do not match.";
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Assessment - Forgot Password</title>
    <link rel="stylesheet" href="css/overall.css">
    <link rel="stylesheet" href="css/styles3.css">
    <link rel="icon" href="img/favicon.jpg">
    <script src="js/script3.js"></script>
</head>
<body class="forgot_class">
    <div class="forgot_container">
        <div class="forgot_logo">
            <img src="img/logo.png" alt="Logo">
        </div>

        <?php if (isset($email_valid) && $email_valid): ?>
            <!-- Reset Password Form -->
            <h1 class="forgot_password_h1">- - - Reset Password - - -</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
                <input type="hidden" name="email" value="<?php echo htmlspecialchars($forgot_email); ?>">
                <label for="new_password">New Password</label>
                <div class="sign_password_design">
                    <input class="forgot_input" type="password" id="new_password" name="new_password" required>
                    <button type="button" class="hide_unhide_password_button" onclick="myHideUnhideFunction('new_password', 'hide_unhide_password_button')">
                        <img id="hide_unhide_password_button" src="img/hide.png">
                        </button>
                </div>
                <label for="confirm_password">Confirm Password</label>
                <div class="sign_password_design">
                    <input class="forgot_input" type="password" id="confirm_password" name="confirm_password" required>
                    <button type="button" class="hide_unhide_password_button" onclick="myHideUnhideFunction('confirm_password', 'hide_unhide_confirmpassword_button')">
                    <img id="hide_unhide_confirmpassword_button" src="img/hide.png">
                    </button>

                </div>
                <input class="forgot_button" type="submit" value="Reset Password">
            </form>
        <?php else: ?>
            <!-- Email Form -->
            <h1 class="forgot_password_h1">- - -Forgot Password- - -</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" autocomplete="off">
                <label for="forgot_email">Email</label>
                <div>
                    <input class="forgot_input" type="email" id="forgot_email" name="forgot_email" required>
                </div>
                <?php if (isset($email_error)): ?>
                    <p style="color: red;"><?php echo $email_error; ?></p>
                <?php endif; ?>
                <input class="forgot_button" type="submit" value="Forgot Password">
            </form>
        <?php endif; ?>

        <?php if (isset($reset_error)): ?>
            <?php echo "<p style='color: red;'>$reset_error</p>"; ?>
        <?php endif; ?>

        <?php if (isset($reset_success)): ?>
            <?php echo "<p style='color: green;'>$reset_success; </p>";?>
        <?php endif; ?>

        <div class="login_signup">
            <p>Already know your account? <a href="career_login.php">Go Back</a></p>
        </div>
    </div>
</body>
</html>
