<?php 
  session_start();

  function pathTo($destination) {
    echo "<script>window.location.href = '/monarch_online_enrollment/$destination.php'</script>";
  }

  if ($_SESSION['status'] == 'invalid' || empty($_SESSION['status'])) {
    /* Set status to invalid */
    $_SESSION['status'] = 'invalid';

    /* Unset user data */
    unset($_SESSION['username']);
    unset($_SESSION['role']);

    /* Redirect to login page */
    pathTo('login');
  } else {
    // Check user role and redirect if accessing session.php directly
    if ($_SESSION['role'] == 'student') {
      pathTo('enrollment_form');
    } elseif ($_SESSION['role'] == 'dean') {
      pathTo('dean');
    } elseif ($_SESSION['role'] == 'admin') {
      pathTo('admin');
    } else {
      echo "Unauthorized access.";
    }
  }
?>
