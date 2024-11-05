<!-- <?php
require('../database.php'); // Make sure this path is correct

if (isset($_POST['student_id']) && isset($_POST['action'])) {
    $student_id = $_POST['student_id'];
    $action = $_POST['action'];

    // Determine the status based on the action
    $status = ($action === 'accept') ? 'accepted' : 'rejected';

    // Prepare the SQL statement
    $query = "UPDATE students SET enrollment_status = ? WHERE student_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    
    if ($stmt) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "si", $status, $student_id);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Enrollment status updated to $status.";
            echo '<script> window.location.href = "pre-enrolled.php"; </script>'; // Adjust path if needed
        } else {
            echo "Failed to update enrollment status: " . mysqli_error($connection); // Provide error feedback
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare the SQL statement: " . mysqli_error($connection); // Error for statement preparation
    }
} else {
    echo "No student ID or action provided.";
}

// Close the database connection
mysqli_close($connection);
?> -->
