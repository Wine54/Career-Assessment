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

// Retrieve the user's first name, last name, and admin status from the database
$query = "SELECT first_name, last_name, is_admin, is_superadmin FROM myLogin WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $is_admin, $is_superadmin);
$stmt->fetch();
$stmt->close();

// If the first name or last name is not found, set default values
if (empty($first_name)) {
    $first_name = "User";
}
if (empty($last_name)) {
    $last_name = "";
}

// Feedback message initialization
$feedback_message = "";
$email_not_exist = false; // Variable to track if email doesn't exist

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy(); // Destroy the session
    header("Location: career_login.php"); // Redirect to login page
    exit();
}

// Handle admin registration
if ($is_superadmin && isset($_POST['register_admin'])) {
    $admin_email = $_POST['admin_email'];

    $update_query = "UPDATE myLogin SET is_admin = 1 WHERE email = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("s", $admin_email);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $feedback_message = "Admin registered successfully.";
        } else {
            $feedback_message = "Error: Email does not exist.";
            $email_not_exist = true;
        }
    } else {
        $feedback_message = "Error: " . $stmt->error;
    }
    $stmt->close();
    echo "<script>alert('$feedback_message');</script>";
}

// Handle admin removal
if ($is_superadmin && isset($_POST['remove_admin'])) {
    $admin_email = $_POST['admin_email_remove'];

    $update_query = "UPDATE myLogin SET is_admin = 0 WHERE email = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("s", $admin_email);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $feedback_message = "Admin removed successfully.";
        } else {
            $feedback_message = "Error: Email does not exist.";
            $email_not_exist = true;
        }
    } else {
        $feedback_message = "Error: " . $stmt->error;
    }
    $stmt->close();
    echo "<script>alert('$feedback_message');</script>";
}

// Handle user details update
if ($is_admin && isset($_POST['update_user'])) {
    $user_email = $_POST['user_email'];
    $new_first_name = $_POST['new_first_name'];
    $new_last_name = $_POST['new_last_name'];

    // Update query to change user details
    $update_query = "UPDATE myLogin SET first_name = ?, last_name = ? WHERE email = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sss", $new_first_name, $new_last_name, $user_email);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $feedback_message = "User details updated successfully.";
        } else {
            $feedback_message = "Error: Email does not exist.";
            $email_not_exist = true;
        }
    } else {
        $feedback_message = "Error: " . $stmt->error;
    }
    $stmt->close();
    echo "<script>alert('$feedback_message');</script>";
}

// Handle user history search
$user_test_history = [];
if ($is_admin && isset($_POST['search_user_history'])) {
    $search_email = $_POST['search_email'];

    $history_query = "SELECT * FROM assessment_responses WHERE email = ?";
    $stmt = $conn->prepare($history_query);
    $stmt->bind_param("s", $search_email);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $user_test_history[] = $row;
    }

    $stmt->close();
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
    <script>
        function confirmAdminRegistration() {
            return confirm("Are you sure you want to register this email as an admin?");
        }

        function confirmAdminRemoval() {
            return confirm("Are you sure you want to remove admin rights from this email?");
        }

        function confirmUpdate() {
            return confirm("Are you sure you want to update this?");
        }

    </script>
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
        <h1>Profile</h1>
        <p>Full Name: <?php echo htmlspecialchars($first_name . " " . $last_name); ?></p>
        <p>Email: <?php echo htmlspecialchars($email); ?></p>
        <form method="post">
            <button class="assessment_button" type="submit" name="logout">Log Out</button>
        </form>
    </div>

    <?php if ($is_admin): ?>
    <div class="main_sectionadmin">
        <h1>Administrator Settings</h1>
        
        <h2>Change User Details</h2>
        <form method="post" action="" onsubmit="return confirmUpdate();">
            <label for="user_email">User Email:</label>
            <input type="email" id="user_email" name="user_email" autocomplete="off" required>

            <label for="new_first_name">First Name:</label>
            <input type="text" id="new_first_name" name="new_first_name" autocomplete="off" required>

            <label for="new_last_name">Last Name:</label>
            <input type="text" id="new_last_name" name="new_last_name" autocomplete="off" required>

            <!-- Add other fields you want to allow the admin to update -->

            <button type="submit" name="update_user">Update User</button>
        </form>

        <h2>Search User Test History</h2>
        <form method="post" action="">
            <label for="search_email">User Email:</label>
            <input type="email" id="search_email" name="search_email" autocomplete="off" required>
            <button type="submit" name="search_user_history">Search</button>
        </form>
        
        <?php if (!empty($user_test_history)): ?>
        <div class="history_section">
            <h3>Test History for <?php echo htmlspecialchars($search_email); ?>:</h3>
            <div class="history_scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Realistic</th>
                            <th>Investigative</th>
                            <th>Artistic</th>
                            <th>Social</th>
                            <th>Enterprising</th>
                            <th>Conventional</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user_test_history as $history): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($history['date']); ?></td>
                            <td><?php echo htmlspecialchars($history['realistic']); ?></td>
                            <td><?php echo htmlspecialchars($history['investigative']); ?></td>
                            <td><?php echo htmlspecialchars($history['artistic']); ?></td>
                            <td><?php echo htmlspecialchars($history['social']); ?></td>
                            <td><?php echo htmlspecialchars($history['enterprising']); ?></td>
                            <td><?php echo htmlspecialchars($history['conventional']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if ($is_superadmin): ?>
    <div class="main_sectionsuperadmin">
        <h1>Super Administrator Settings</h1>
        <form method="post" action="" onsubmit="return confirmAdminRegistration();">
            <label for="admin_email">Admin Email:</label>
            <input type="email" id="admin_email" name="admin_email" autocomplete="off" required>
            <button type="submit" name="register_admin">Register Admin</button>
        </form>
        <form method="post" action="" onsubmit="return confirmAdminRemoval();">
            <label for="admin_email_remove">Admin Email:</label>
            <input type="email" id="admin_email_remove" name="admin_email_remove" autocomplete="off" required>
            <button type="submit" name="remove_admin">Remove Admin</button>
        </form>
    </div>
    <?php endif; ?>
</body>
</html>
