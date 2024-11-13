<?php 
require('database.php');
session_start();

/* Functions */
function pathTo($destination) {
    echo "<script>window.location.href = '/monarch_online_enrollment/$destination.php'</script>";
}

// Check if the user is already logged in
if (isset($_SESSION['status']) && $_SESSION['status'] == 'valid') {
    pathTo('login');
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connection, trim($_POST['username']));
    $password = mysqli_real_escape_string($connection, trim($_POST['password']));

    if (empty($username) || empty($password)) {
        echo "Please fill up all fields";
    } else {
        // Generate the MD5 hash for the password
        $login_hashed_password = md5($password);

        // Query to validate username and password with MD5 hash
        $queryValidate = "SELECT * FROM accounts WHERE username = '$username' AND password = '$login_hashed_password'";
        $sqlValidate = mysqli_query($connection, $queryValidate);

        if ($sqlValidate && mysqli_num_rows($sqlValidate) > 0) {
            $rowValidate = mysqli_fetch_array($sqlValidate);

            // Store session information
            $_SESSION['status'] = 'valid';
            $_SESSION['username'] = $rowValidate['username'];
            $_SESSION['role'] = $rowValidate['role'];

            // Redirect based on user role
            if ($_SESSION['role'] == 'student') {
                pathTo('enrollment_form');
            } elseif ($_SESSION['role'] == 'dean') {
                pathTo('Dean/dean-dashboard');
            } elseif ($_SESSION['role'] == 'admin') {
                pathTo('Admin/admin');
            } else {
                echo "Error: User role not recognized.";
            }
        } else {
            // Invalid credentials
            $_SESSION['status'] = 'invalid';
            echo 'Invalid Credential';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
</head>
<body>
  <h2>Log in</h2>
  <form action="/monarch_online_enrollment/login.php" method="post">
    <input type="text" name="username" placeholder="Enter your username"/> <br> <br>
    <input type="password" name="password" placeholder="Enter your password"/> <br> <br>
    <input type="submit" name="login" value="LOGIN"/>
  </form>

  <p>Don't have an account? <a href="/monarch_online_enrollment/register.php">Register here</a>.</p>

</body>
</html>
