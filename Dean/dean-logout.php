<?php
  // Start the session
  session_start();

  // Unset all session variables
  session_unset(); // This clears all session data

  // Destroy the session
  session_destroy(); // This ensures the session is fully destroyed

  // Redirect to the login page
  header("Location: /monarch_online_enrollment/login.php"); // Use header for redirection
  exit(); // Make sure the script stops after redirection
?>