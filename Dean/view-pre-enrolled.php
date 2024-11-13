<?php 
// Require database connection
require('../database.php');

// Get the student_id from the URL
$student_id = isset($_GET['student_id']) ? intval($_GET['student_id']) : 0;

if ($student_id === 0) {
    die("Invalid student ID.");
}

// Handle accept/reject actions
if (isset($_POST['action'])) {
    $status = $_POST['action'] === 'accept' ? 'enrolled' : 'rejected';

    // Update the status in the database
    $updateQuery = "UPDATE courseenrollment SET status = '$status' WHERE student_id = $student_id";
    if (mysqli_query($connection, $updateQuery)) {
        echo "<script>alert('Status updated to " . htmlspecialchars($status) . ".'); window.location.href = 'pre-enrolled.php';</script>";
        exit;
    } else {
        die("Failed to update status: " . mysqli_error($connection));
    }
}

// Initialize student information array
$studentInformation = [];

// Query to get student information for the specific student
$queryStudentInformation = "
SELECT 
    s.student_id,
    s.first_name,
    s.last_name,
    s.middle_name,
    s.birthdate,
    s.gender,
    s.religion,
    s.civil_status,
    ci.email,
    ci.phone_no,
    a.barangay,
    a.municipal,
    a.province,
    a.country,
    p.father_last_name,
    p.father_first_name,
    p.father_middle_name,
    p.father_occupation,
    p.father_phone_no,
    p.mother_last_name,
    p.mother_first_name,
    p.mother_middle_name,
    p.mother_occupation,
    p.mother_phone_no,
    e.senior_high_school,
    e.strand,
    e.year_graduated,
    e.general_average,
    e.transfer_last_school,
    e.transfer_last_year,
    e.transfer_course,
    ce.year_level,
    ce.semester,
    ce.course_name,
    r.file,
    r.file_name
FROM 
    students s
INNER JOIN 
    contactinfo ci ON s.student_id = ci.student_id
INNER JOIN 
    address a ON s.student_id = a.student_id
INNER JOIN 
    parents p ON s.student_id = p.student_id
LEFT JOIN 
    education e ON s.student_id = e.student_id  -- Use LEFT JOIN here for optional data
INNER JOIN 
    courseenrollment ce ON s.student_id = ce.student_id
LEFT JOIN 
    requirements r ON s.student_id = r.student_id  -- Use LEFT JOIN here for optional data
WHERE 
    s.student_id = $student_id;";


$result = mysqli_query($connection, $queryStudentInformation);
if (!$result) {
    die("Database query failed: " . mysqli_error($connection));
}

// Fetch student data
if (mysqli_num_rows($result) > 0) {
    $studentInformation = mysqli_fetch_assoc($result);
} else {
    echo "No student information found.";
    exit; // Stop further processing if no data is found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 800px; margin: auto; padding: 20px; }
        h2 { color: #333; }
        .info-section { margin-bottom: 20px; }
        .info-section h3 { margin-top: 0; }
        .info-item { margin: 5px 0; }
        .action-buttons { margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Student Information</h1>

        <div class="info-section">
            <h2>Basic Information</h2>
            <div class="info-item">Last Name: <?= htmlspecialchars($studentInformation['last_name']) ?></div>
            <div class="info-item">First Name: <?= htmlspecialchars($studentInformation['first_name']) ?></div>
            <div class="info-item">Middle Name: <?= htmlspecialchars($studentInformation['middle_name'] ?? 'N/A') ?></div>
            <div class="info-item">Birthdate: <?= htmlspecialchars($studentInformation['birthdate'] ?? 'N/A') ?></div>
            <div class="info-item">Gender: <?= htmlspecialchars($studentInformation['gender'] ?? 'N/A') ?></div>
            <div class="info-item">Religion: <?= htmlspecialchars($studentInformation['religion'] ?? 'N/A') ?></div>
            <div class="info-item">Civil Status: <?= htmlspecialchars($studentInformation['civil_status'] ?? 'N/A') ?></div>
        </div>

        <div class="info-section">
            <h2>Contact Information</h2>
            <div class="info-item">Email: <?= htmlspecialchars($studentInformation['email']) ?></div>
            <div class="info-item">Phone No: <?= htmlspecialchars($studentInformation['phone_no']) ?></div>
        </div>

        <div class="info-section">
            <h2>Address</h2>
            <div class="info-item">Address: <?= htmlspecialchars($studentInformation['barangay']) ?>, <?= htmlspecialchars($studentInformation['municipal']) ?>, <?= htmlspecialchars($studentInformation['province']) ?>, <?= htmlspecialchars($studentInformation['country']) ?></div>
        </div>

        <div class="info-section">
            <h2>Parent Information</h2>
            <h3>Father's Details</h3>
            <div class="info-item">Last Name: <?= htmlspecialchars($studentInformation['father_last_name'] ?? 'N/A') ?></div>
            <div class="info-item">First Name: <?= htmlspecialchars($studentInformation['father_first_name'] ?? 'N/A') ?></div>
            <div class="info-item">Middle Name: <?= htmlspecialchars($studentInformation['father_middle_name'] ?? 'N/A') ?></div>
            <div class="info-item">Occupation: <?= htmlspecialchars($studentInformation['father_occupation'] ?? 'N/A') ?></div>
            <div class="info-item">Phone No: <?= htmlspecialchars($studentInformation['father_phone_no'] ?? 'N/A') ?></div>

            <h3>Mother's Details</h3>
            <div class="info-item">Last Name: <?= htmlspecialchars($studentInformation['mother_last_name'] ?? 'N/A') ?></div>
            <div class="info-item">First Name: <?= htmlspecialchars($studentInformation['mother_first_name'] ?? 'N/A') ?></div>
            <div class="info-item">Middle Name: <?= htmlspecialchars($studentInformation['mother_middle_name'] ?? 'N/A') ?></div>
            <div class="info-item">Occupation: <?= htmlspecialchars($studentInformation['mother_occupation'] ?? 'N/A') ?></div>
            <div class="info-item">Phone No: <?= htmlspecialchars($studentInformation['mother_phone_no'] ?? 'N/A') ?></div>
        </div>

        <div class="info-section">
            <h2>Education</h2>
            <div class="info-item">Last School Attended: <?= htmlspecialchars($studentInformation['senior_high_school']) ?></div>
            <div class="info-item">Strand: <?= htmlspecialchars($studentInformation['strand']) ?></div>
            <div class="info-item">Year Graduated: <?= htmlspecialchars($studentInformation['year_graduated']) ?></div>
            <div class="info-item">General Average: <?= htmlspecialchars($studentInformation['general_average']) ?></div>
        </div>

        <div class="info-section">
            <h2>Transfer Information</h2>
            <div class="info-item">Last School Transferred From: <?= htmlspecialchars($studentInformation['transfer_last_school'] ?? 'N/A') ?></div>
            <div class="info-item">Last Year Attended: <?= htmlspecialchars($studentInformation['transfer_last_year'] ?? 'N/A') ?></div>
            <div class="info-item">Transfer Course: <?= htmlspecialchars($studentInformation['transfer_course'] ?? 'N/A') ?></div>
        </div>

        <div class="info-section">
            <h2>Course Information</h2>
            <div class="info-item">Year Level: <?= htmlspecialchars($studentInformation['year_level']) ?></div>
            <div class="info-item">Semester: <?= htmlspecialchars($studentInformation['semester']) ?></div>
            <div class="info-item">Course: <?= htmlspecialchars($studentInformation['course_name']) ?></div>
        </div>

        <div class="info-section">
            <h2>Requirements</h2>
            <div class="info-item">Requirement File: 
                <?php if (!empty($studentInformation['file'])): ?>
                    <a href="download.php?student_id=<?= htmlspecialchars($studentInformation['student_id']) ?>" target="_blank"><?= htmlspecialchars($studentInformation['file_name']) ?></a>
                <?php else: ?>
                    No requirement file submitted.
                <?php endif; ?>
            </div>
        </div>

        <div class="action-buttons">
            <form method="post">
                <button type="submit" name="action" value="accept">Accept</button>
                <button type="submit" name="action" value="reject">Reject</button>
            </form>
        </div>
    </div>
</body>
</html>
