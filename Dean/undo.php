<?php
require('../database.php'); // Ensure this file correctly initializes $connection

// Get the student_id from the POST request
$student_id = isset($_POST['student_id']) ? intval($_POST['student_id']) : 0;

if ($student_id === 0) {
    die("Invalid student ID.");
}

// Update the status in the database to "pre-enrolled"
$updateQuery = "UPDATE courseenrollment SET status = 'pre-enrolled' WHERE student_id = $student_id";

if (mysqli_query($connection, $updateQuery)) {
    echo "<script>alert('Enrollment undone successfully.'); window.location.href = 'enrolled.php';</script>";
} else {
    die("Failed to update status: " . mysqli_error($connection));
}
?>
