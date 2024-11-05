<?php 
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "online_enrollment";

    $connection = mysqli_connect($host, $username, $password, $database);

    //$connection = mysqli_connect("host", "user", "password", "database");
    
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

?>