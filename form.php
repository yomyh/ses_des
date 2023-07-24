<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields
    $name = $_POST["name"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];
    $email = $_POST["email"];
    $roomNumber = $_POST["roomNumber"];
    
    // Validate email using filter_var
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Validate email using regular expression
    if (!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/", $email)) {
        $errors[] = "Invalid email format";
    }
    
    // Validate room number
    if ($roomNumber == "") {
        $errors[] = "Please select a room number";
    }
    
    // Validate profile picture
    if ($_FILES["profilePicture"]["error"] == 0) {
        $allowedExtensions = ["jpg", "jpeg", "png"];
        $fileExtension = strtolower(pathinfo($_FILES["profilePicture"]["name"], PATHINFO_EXTENSION));
        
        if (!in_array($fileExtension, $allowedExtensions)) {
            $errors[] = "Invalid file format. Only JPG, JPEG, and PNG are allowed";
        }
    }
    
    // If no errors, store user info in a file
    if (empty($errors)) {
        $userData .= "Name: $name\n";
        $userData .= "Email: $email\n";
        $userData .= "Room Number: $roomNumber\n";
        
        file_put_contents("users.txt", $userData, FILE_APPEND);
        
        // Move uploaded profile picture to a directory
        if ($_FILES["profilePicture"]["error"] == 0) {
            $profilePicturePath = "uploads/" . $_FILES["profilePicture"]["name"];
            move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $profilePicturePath);
        }
        
        // Redirect to login page
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
</head>
<body>
    <h2>Registration Form</h2>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method="POST" action="login.php" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>
        
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" name="confirmPassword" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>
        
        <label for="roomNumber">Room Number:</label>
        <select name="roomNumber" required>
            <option value="">Select Room Number</option>
            <option value="Application1">Application1</option>
            <option value="Application2">Application2</option>
            <option value="cloud">Cloud</option>
        </select><br><br>
        
        <label for="profilePicture">Profile Picture:</label>
        <input type="file" name="profilePicture"><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>