<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields
    $username = $_POST["username"];
    $password = $_POST["password"];


    $users = file_get_contents("users.txt");
    $users = explode("\n", $users);

    $validLogin = false;
    foreach ($users as $user) {
        $userData = explode(":", $user);
        if (trim($userData[0]) == $username && trim($userData[1]) == $password) {
            $validLogin = true;
            break;
        }
    }
    if ($validLogin) {
       
        $_SESSION["username"] = $username;

        header("Location: welcome.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>