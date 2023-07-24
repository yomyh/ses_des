<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to login page
    header("Location: login.php");
    exit;
}

// Get logged in username from session
$username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, <?php echo $username; ?>!</h2>
    <p>This is the welcome page.</p>
</body>
</html>