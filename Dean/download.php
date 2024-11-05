<?php
require('../database.php'); // Ensure you have the correct path to your database connection

// Get the student_id from the URL
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;

if ($student_id === 0) {
    die("Invalid student ID.");
}

// Prepare the SQL query to retrieve the file from the database
$query = "SELECT file, file_name FROM requirements WHERE student_id = $student_id"; // Adjust the table and column names as needed
$result = mysqli_query($connection, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}

if (mysqli_num_rows($result) > 0) {
    $fileData = mysqli_fetch_assoc($result);
    $file = $fileData['file'];
    $fileName = $fileData['file_name']; // Ensure you have a column for the file name

    // Set the headers to initiate the download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($file));
    
    // Output the file content
    echo $file;
    exit;
} else {
    echo "No file found.";
}
?>
