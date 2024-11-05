<?php
require('../database.php'); // Ensure this file correctly initializes $connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch rejected students
$query = "SELECT se.student_id, se.first_name, se.last_name, ce.year_level, ce.semester, ce.course_name, ce.status 
          FROM students se
          JOIN courseenrollment ce ON se.student_id = ce.student_id 
          WHERE ce.status = 'rejected'";

$result = mysqli_query($connection, $query);

// Check for errors in the query execution
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Display rejected students
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Rejected Students</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <h3>M<span>onarch</span></h3>
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
                       <a href="dean-dashboard.php" class="">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                       <a href="pre-enrolled.php" class="">
                            <span class="las la-user-alt"></span>
                            <small>Pre-enrolled</small>
                        </a>
                    </li>
                    <li>
                       <a href="enrolled.php" class="">
                            <span class="las la-user-alt"></span>
                            <small>Enrolled</small>
                        </a>
                    </li>
                    <li>
                       <a href="rejected.php" class="active">
                            <span class="las la-user-alt"></span>
                            <small>Rejected Student</small>
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
                            <span class="las la-tasks"></span>
                            <small>Tasks</small>
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
                        
                        <span class="las la-power-off"></span>
                        <span>Logout</span>
                    </div>
                </div>
            </div>
        </header>
        
        <main>
            <div class="page-header">
                <h1>Rejected Students</h1>
                <div class="records table-responsive">
                    <div class="record-header">
                        <div class="add">
                            <span>Student List</span>
                        </div>
                        <div class="browse">
                           <input type="search" placeholder="Search" class="record-search">
                            <select name="" id="">
                                <option value="">Status</option>
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
                                    <th><span class="las la-sort"></span> Year Level</th>
                                    <th><span class="las la-sort"></span> Semester</th>
                                    <th><span class="las la-sort"></span> Course</th>
                                    <th><span class="las la-sort"></span> Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['last_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['year_level']); ?></td>
                                    <td><?php echo htmlspecialchars($row['semester']); ?></td>
                                    <td><?php echo htmlspecialchars($row['course_name']); ?></td>
                                    <td>
                                        <span class="status enrolled"><?php echo htmlspecialchars($row['status']); ?></span>
                                    </td>
                                    <td>
                                        <a href="download.php?id=<?php echo htmlspecialchars($row['student_id']); ?>" title="Download"><span class="las la-download"></span></a>
                                        <a href="view-enrolled.php?student_id=<?php echo htmlspecialchars($row['student_id']); ?>" title="View"><span class="las la-eye"></span></a>
                                        <form method="post" action="undo.php" style="display:inline;">
                                            <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($row['student_id']); ?>">
                                            <button type="submit" name="action" value="undo" onclick="return confirm('Are you sure you want to undo this enrollment?');">Undo</button>
                                        </form>
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
