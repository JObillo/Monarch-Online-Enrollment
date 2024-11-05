<?php 
    require('../database.php');

    // Query to join students and courseenrollment
    $queryStudents = "
        SELECT 
            students.student_id,
            students.last_name,
            students.first_name,
            students.middle_name,
            courseenrollment.course_name,
            courseenrollment.year_level
        FROM students
        JOIN courseenrollment ON students.student_id = courseenrollment.student_id";

    $sqlStudents = mysqli_query($connection, $queryStudents);

    if (!$sqlStudents) {
        die("Database query failed: " . mysqli_error($connection));
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="main">
        <h1>Student List</h1>
        <table class="read-main">
            <tr>
                <th>Student ID</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Status</th>
            </tr>
            <?php while($results = mysqli_fetch_array($sqlStudents)) { ?>
            <tr>
                <td><?php echo $results['student_id']; ?></td>
                <td><?php echo $results['last_name']; ?></td>
                <td><?php echo $results['first_name']; ?></td>
                <td><?php echo $results['middle_name']; ?></td>
                <td><?php echo $results['course_name']; ?></td>
                <td><?php echo $results['year_level']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
