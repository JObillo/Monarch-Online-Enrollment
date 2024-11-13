<?php
require('database.php');
session_start();

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $role = 'student';

    if (empty($username) || empty($password) || empty($confirm_password)) {
        echo "Please fill in all fields!";
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match!";
    } else {
        $query = "SELECT * FROM accounts WHERE username = '$username'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "Username already exists!";
        } else {
            // MD5 hashing
            $hashed_password = md5($password);

            $insertQuery = "INSERT INTO accounts (username, password, role) 
                            VALUES ('$username', '$hashed_password', '$role')";
            $insertResult = mysqli_query($connection, $insertQuery);

            if ($insertResult) {
                header('Location: login.php');
                exit();
            } else {
                echo "Error registering user: " . mysqli_error($connection);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Student Registration</h2>
    <form action="register.php" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br><br>

        <input type="submit" name="register" value="Register"> <br>
        <a href="/monarch_online_enrollment/login.php">Back</a>
    </form>
</body>
</html>
