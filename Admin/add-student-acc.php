<?php 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST["fullname"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $to = "obillojericho.14@gmail.com";
    $headers = "From: $email";

    if(mail($to, $subject, $message, $headers )){
        echo "Email Sent";
    } else {
        echo "Email sending failed";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <form action="add-student-acc.php" method="POST">
            <input type="text" class="form-control mt-4" name="fullname" id="" placeholder="Full Name:">
            <input type="email" class="form-control mt-4" name="email" id="" placeholder="Enter Email:">
            <input type="text" class="form-control mt-4" name="subject" id="" placeholder="Enter Subject:">
            <textarea class="form-control mt-4" name="message" id="" cols="30" rows="10" placeholder="Enter Message"></textarea>
                
            <input type="submit" class="btn btn-primary mt-4" value="Send" name="submit">
        </form>
    </div>
</body>
</html>