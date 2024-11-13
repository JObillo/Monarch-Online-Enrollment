<?php 
require('../database.php');

// Query to count total pre-enrolled students
$queryPreEnrolledCount = "
    SELECT COUNT(*) AS total_pre_enrolled
    FROM courseenrollment
    WHERE status = 'pre-enrolled'";

$resultPreEnrolledCount = mysqli_query($connection, $queryPreEnrolledCount);
$totalPreEnrolled = 0; // Default value

if ($resultPreEnrolledCount) {
    $rowCount = mysqli_fetch_assoc($resultPreEnrolledCount);
    $totalPreEnrolled = $rowCount['total_pre_enrolled'];
} else {
    die("Query failed: " . mysqli_error($connection));
}

// Query to count total enrolled students
$queryEnrolledCount = "
    SELECT COUNT(*) AS total_enrolled
    FROM courseenrollment
    WHERE status = 'enrolled'";

$resultEnrolledCount = mysqli_query($connection, $queryEnrolledCount);
$totalEnrolled = 0; // Default value

if ($resultEnrolledCount) {
    $rowCount = mysqli_fetch_assoc($resultEnrolledCount);
    $totalEnrolled = $rowCount['total_enrolled'];
} else {
    die("Query failed: " . mysqli_error($connection));
}

// Query to count total rejected students
$queryRejectedCount = "
    SELECT COUNT(*) AS total_rejected
    FROM courseenrollment
    WHERE status = 'rejected'";

$resultRejectedCount = mysqli_query($connection, $queryRejectedCount);
$totalRejected = 0; // Default value

if ($resultRejectedCount) {
    $rowCount = mysqli_fetch_assoc($resultRejectedCount);
    $totalRejected = $rowCount['total_rejected'];
} else {
    die("Query failed: " . mysqli_error($connection));
}

// Query to join students and courseenrollment, including status
$queryStudents = "
    SELECT 
        students.student_id,
        students.last_name,
        students.first_name,
        students.middle_name,
        courseenrollment.course_name,
        courseenrollment.year_level,
        courseenrollment.status  -- Include the status here
    FROM students
    JOIN courseenrollment ON students.student_id = courseenrollment.student_id
    LIMIT 20";

$sqlStudents = mysqli_query($connection, $queryStudents);

// Check for errors in the query execution
if (!$sqlStudents) {
    die("Database query failed: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Dean Dashboard</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
   <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3><span>Monarch</span></h3>
        </div>
        
        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(img/3.jpeg)"></div>
                <h4>Dean Nathaniel</h4>
                <small>Dean</small>
            </div>

            <div class="side-menu">
                <ul>
                    <li>
                       <a href="" class="active">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                       <a href="pre-enrolled.php">
                            <span class="las la-user-alt"></span>
                            <small>Pre-enrolled</small>
                        </a>
                    </li>
                    <li>
                       <a href="enrolled.php">
                            <span class="las la-user-alt"></span>
                            <small>Enrolled</small>
                        </a>
                    </li>
                    <li>
                       <a href="rejected.php">
                            <span class="las la-user-alt"></span>
                            <small>Rejected Students</small>
                        </a>
                    </li>
                    <li>
                       <a href="teacher.php">
                            <span class="las la-user-alt"></span>
                            <small>Teacher</small>
                        </a>
                    </li>
                    <li>
                       <a href="">
                            <span class="las la-book-reader"></span>
                            <small>Subject</small>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">
                    <div class="user">
                        <div class="bg-img" style="background-image: url(img/1.jpeg)"></div>
                        
                         <!-- Logout button -->
                        <form action="dean-logout.php" method="post">
                            <button type="submit" name="logout" class="logout-btn">
                                <span class="las la-power-off"></span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>
        
        <main>
            <div class="page-header">
                <h1>Dashboard</h1>
                <small>Home / Dashboard</small>
            </div>
            
            <div class="page-content">
                <div class="analytics">
                    <div class="card">
                        <div class="card-head">
                            <h2><?php echo $totalPreEnrolled; ?></h2> <!-- Display dynamic pre-enrolled count -->
                            <span class="las la-user-friends"></span>
                        </div>
                        <div class="card-progress">
                            <small>Total Pre-Enrolled</small>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2><?php echo $totalEnrolled; ?></h2> <!-- Display dynamic enrolled count -->
                            <span class="las la-user-friends"></span>
                        </div>
                        <div class="card-progress">
                            <small>Total Enrolled</small>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2><?php echo $totalRejected; ?></h2>
                            <span class="las la-user-friends"></span>
                        </div>
                        <div class="card-progress">
                            <small>Total Rejected</small>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2>0</h2>
                            <span class="las la-book-reader"></span>
                        </div>
                        <div class="card-progress">
                            <small>Total Subject</small>
                        </div>
                    </div>
                </div>

                <div class="records table-responsive">
                    <div class="record-header">
                        <div class="add">
                            <span>Student List</span>
                        </div>

                        <div class="browse">
                           <input type="search" placeholder="Search" class="record-search">
                            <select name="" id="">
                                <option value="">All Course</option>
                                <option value="">Information Technology</option>
                                <option value="">Computer Science</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th><span class="las la-sort"></span> Last Name</th>
                                    <th><span class="las la-sort"></span> First Name</th>
                                    <th><span class="las la-sort"></span> Middle Name</th>
                                    <th><span class="las la-sort"></span> Course</th>
                                    <th><span class="las la-sort"></span> Year Level</th>
                                    <th><span class="las la-sort"></span> Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($results = mysqli_fetch_array($sqlStudents)) { ?>
                                <tr>
                                    <td><?php echo $results['student_id']; ?></td>
                                    <td><?php echo $results['last_name']; ?></td>
                                    <td><?php echo $results['first_name']; ?></td>
                                    <td><?php echo $results['middle_name']; ?></td>
                                    <td><?php echo $results['course_name']; ?></td>
                                    <td><?php echo $results['year_level']; ?></td>
                                    <td>
                                    <span class="status <?php echo htmlspecialchars($results['status']); ?>">
                                        <?php echo ($results['status'] === 'pre-enrolled') ? 'pending' : htmlspecialchars($results['status']); ?>
                                    </span>
                                    </td>
                                </tr>
                            <?php } ?>  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body> 
</html>
