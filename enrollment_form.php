<?php 
require('database.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    //echo "Form submitted <br>"; // Debugging: check if form was submitted

    // Collecting form data
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $religion = $_POST['religion'];
    $civil_status = $_POST['civil_status'];
    $email = $_POST['email'];
    $phone_no= $_POST['student_phoneNo'];
    $barangay = $_POST['barangay'];
    $municipal = $_POST['municipal'];
    $province = $_POST['province'];
    $country = $_POST['country'];
    $father_last_name = $_POST['father_last_name'];
    $father_first_name = $_POST['father_first_name'];
    $father_middle_name = $_POST['father_middle_name'];
    $father_occupation = $_POST['father_occupation'];
    $father_phone_no = $_POST['father_phone_no'];
    $mother_last_name = $_POST['mother_last_name'];
    $mother_first_name = $_POST['mother_first_name'];
    $mother_middle_name = $_POST['mother_middle_name'];
    $mother_occupation = $_POST['mother_occupation'];
    $mother_phone_no = $_POST['mother_phone_no'];
    $last_school_attended = $_POST['last_school_attended'];
    $strand = $_POST['strand'];
    $year_graduated = $_POST['year_graduated'];
    $general_average = $_POST['general_average'];
    $transfer_last_school = $_POST['transfer_last_school'];
    $transfer_last_year = $_POST['transfer_last_year'];
    $transfer_course = $_POST['transfer_course'];
    $year_level = $_POST['year_level'];
    $semester = $_POST['semester'];
    $course_name = $_POST['course_name'];

    // Begin transaction
    mysqli_begin_transaction($connection);

    try {
        // Insert data into students table
        $queryStudents = "INSERT INTO students (last_name, first_name, middle_name, birthdate, gender, religion, civil_status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtStudents = mysqli_prepare($connection, $queryStudents);
        mysqli_stmt_bind_param($stmtStudents, "sssssss", $last_name, $first_name, $middle_name, $birthdate, $gender, $religion, $civil_status);
        mysqli_stmt_execute($stmtStudents);
        $student_id = mysqli_insert_id($connection);

        // Insert data into contactinfo table
        $queryContactinfo = "INSERT INTO contactinfo (student_id, email, phone_no) VALUES (?, ?, ?)";
        $stmtContactinfo = mysqli_prepare($connection, $queryContactinfo);
        mysqli_stmt_bind_param($stmtContactinfo, "iss", $student_id, $email, $phone_no);
        mysqli_stmt_execute($stmtContactinfo);

        // Insert data into address table
        $queryAddress = "INSERT INTO address (student_id, barangay, municipal, province, country) VALUES (?, ?, ?, ?, ?)";
        $stmtAddress = mysqli_prepare($connection, $queryAddress);
        mysqli_stmt_bind_param($stmtAddress, "issss", $student_id, $barangay, $municipal, $province, $country);
        mysqli_stmt_execute($stmtAddress);

        // Insert data into parents table
        $queryParents = "INSERT INTO parents (student_id, father_last_name, father_first_name, father_middle_name, father_occupation, father_phone_no, mother_last_name, mother_first_name, mother_middle_name, mother_occupation, mother_phone_no) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtParents = mysqli_prepare($connection, $queryParents);
        mysqli_stmt_bind_param($stmtParents, "issssssssss", $student_id, $father_last_name, $father_first_name, $father_middle_name, $father_occupation, $father_phone_no, $mother_last_name, $mother_first_name, $mother_middle_name, $mother_occupation, $mother_phone_no);
        mysqli_stmt_execute($stmtParents);

        // Insert data into education table (Adjust column names as needed)
        $queryEducation = "INSERT INTO education (student_id, senior_high_school, strand, year_graduated, general_average, transfer_last_school, transfer_last_year, transfer_course) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtEducation = mysqli_prepare($connection, $queryEducation);
        mysqli_stmt_bind_param($stmtEducation, "isssssss", $student_id, $last_school_attended, $strand, $year_graduated, $general_average, $transfer_last_school, $transfer_last_year, $transfer_course);
        mysqli_stmt_execute($stmtEducation);

        // Insert data into courseenrollment table
        $queryCourseEnrollment = "INSERT INTO courseenrollment (student_id, year_level, semester, course_name) VALUES (?, ?, ?, ?)";
        $stmtCourseEnrollment = mysqli_prepare($connection, $queryCourseEnrollment);
        mysqli_stmt_bind_param($stmtCourseEnrollment, "isss", $student_id, $year_level, $semester, $course_name);
        mysqli_stmt_execute($stmtCourseEnrollment);

        // Handle file upload for requirements
        if (isset($_FILES['requirement_file']) && $_FILES['requirement_file']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['requirement_file']['tmp_name'];
            $fileName = $_FILES['requirement_file']['name'];
            $fileContent = file_get_contents($fileTmpPath);
            
            // Insert the image into the requirements table
            $queryRequirements = "INSERT INTO requirements (student_id, type, file, file_name) VALUES (?, ?, ?, ?)";
            $stmtRequirements = mysqli_prepare($connection, $queryRequirements);
            $requirement_type = 'Image'; // Set the requirement type as needed
            mysqli_stmt_bind_param($stmtRequirements, "isss", $student_id, $requirement_type, $fileContent, $fileName);
            mysqli_stmt_execute($stmtRequirements);
        } else {
            echo "No file uploaded or there was an upload error.";
        }

        mysqli_commit($connection);
        //echo "Data inserted successfully";
        echo '<script> alert("Data Inserted Successfully") </script>';
        echo '<script> window.location.href = "/monarch_online_enrollment/student_account.php" </script>';

    } catch (Exception $e) {
        mysqli_rollback($connection);
        echo "Failed to insert data: " . $e->getMessage();
    }

    // Close all statements if defined
    if (isset($stmtStudents)) mysqli_stmt_close($stmtStudents);
    if (isset($stmtContactinfo)) mysqli_stmt_close($stmtContactinfo);
    if (isset($stmtAddress)) mysqli_stmt_close($stmtAddress);
    if (isset($stmtParents)) mysqli_stmt_close($stmtParents);
    if (isset($stmtEducation)) mysqli_stmt_close($stmtEducation);
    if (isset($stmtCourseEnrollment)) mysqli_stmt_close($stmtCourseEnrollment);
    if (isset($stmtRequirements)) mysqli_stmt_close($stmtRequirements);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monarch Online Enrollment</title>
    <link rel="stylesheet" href="">
</head>
<body>    
    <header class="header">
        <h1>Monarch Online Enrollment</h1> <br>
    </header>

    <div class="form-body">
        <!-- <form action="database.php" method="post" enctype="multipart/form-data"> -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <h3 class="box1">Basic Information</h3>
            <label for="last_name">Last name</label>
            <input type="text" id="last_name" name="last_name" required>
            
            <label for="first_name">First name</label>
            <input type="text" id="first_name" name="first_name" required>
            
            <label for="middle_name">Middle name</label>
            <input type="text" id="middle_name" name="middle_name"> <br> <br>

            <label for="birthdate">Birthdate</label>
            <input type="date" id="birthdate" name="birthdate" required> 

            <label for="gender">Gender</label>
            <input type="radio" id="male" name="gender" value="male" required>
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label> <br> <br>

            <label for="religion">Religion</label>
            <select id="religion" name="religion" required>
                <option value="catholic">Catholic</option>
                <option value="inc">INC</option>
                <option value="jw">JW</option>
                <option value="other">Other</option>
            </select>

            <label for="civil_status">Civil Status</label>
            <input type="radio" id="single" name="civil_status" value="single" required>
            <label for="single">Single</label>
            <input type="radio" id="married" name="civil_status" value="married">
            <label for="married">Married</label>
            <input type="radio" id="other" name="civil_status" value="other">
            <label for="other">Other</label>
            <br> <br>

            <h3>Contact Information</h3>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="student_phoneNo">Phone No</label>
            <input type="tel" id="student_phoneNo" name="student_phoneNo" required>
            <br> <br>

            <h3>Address</h3>
            <label for="barangay">Barangay</label>
            <input type="text" id="barangay" name="barangay" required>
        
            <label for="municipal">Municipal</label>
            <input type="text" id="municipal" name="municipal" required> <br> <br>
            
            <label for="province">Province</label>
            <input type="text" id="province" name="province" required>
            
            <label for="country">Country</label>
            <input type="text" id="country" name="country" required>

            <h3>Parents</h3>
            <label for="father_last_name">Father Last Name</label>
            <input type="text" id="father_last_name" name="father_last_name" placeholder="Lastname" required>
            
            <label for="father_first_name">Father First Name</label>
            <input type="text" id="father_first_name" name="father_first_name" placeholder="Firstname" required>
            
            <label for="father_middle_name">Father Middle Name</label>
            <input type="text" id="father_middle_name" name="father_middle_name" placeholder="Middlename"> <br> <br>

            <label for="father_occupation">Father Occupation</label>
            <input type="text" id="father_occupation" name="father_occupation" required> 
            
            <label for="father_phone_no">Father Phone No</label>
            <input type="tel" id="father_phone_no" name="father_phone_no" required>
            <br> <br>

            <label for="mother_last_name">Mother Last Name</label>
            <input type="text" id="mother_last_name" name="mother_last_name" placeholder="Lastname" required>
            
            <label for="mother_first_name">Mother First Name</label>
            <input type="text" id="mother_first_name" name="mother_first_name" placeholder="Firstname" required>
            
            <label for="mother_middle_name">Mother Middle Name</label>
            <input type="text" id="mother_middle_name" name="mother_middle_name" placeholder="Middlename"> <br> <br>

            <label for="mother_occupation">Mother Occupation</label>
            <input type="text" id="mother_occupation" name="mother_occupation" required> 
            
            <label for="mother_phone_no">Mother Phone No</label>
            <input type="tel" id="mother_phone_no" name="mother_phone_no" required>
            <br> <br>

            <h3>Education</h3>
            <h4>Senior Highschool</h4>
            <label for="last_school_attended"></label>
            <input type="text" id="last_school_attended" name="last_school_attended" placeholder="Last School Attended" >

            <label for="strand"></label>
            <input type="text" id="strand" name="strand" placeholder="SHS Strand" required> <br> <br>
            
            <label for="year_graduated"></label>
            <input type="text" id="year_graduated" name="year_graduated" placeholder="Year Graduated" required>
            
            <label for="general_average"></label>
            <input type="text" id="general_average" name="general_average" placeholder="General Average" required>
             <br>
             
             <h4>Transferee</h4>
             <label for="transfer_last_school"></label>
             <input type="text" id="transfer_last_school" name="transfer_last_school" placeholder="Last School Attended">

             <label for="transfer_last_year"></label>
             <input type="text" id="transfer_last_year" name="transfer_last_year" placeholder="Last School Year">
            <br> <br>
             <label for="transfer_course"></label>
             <input type="text" id="transfer_course" name="transfer_course" placeholder="Course">
             
             <h3>Choose Course</h3>
            <label for="year_level">Year Level</label>
            <select id="year_level" name="year_level" required>
                <option value="1st Year">1st Year</option>
                <option value="2nd Year">2nd Year</option>
                <option value="3rd Year">3rd Year</option>
                <option value="4th Year">4th Year</option>
            </select> <br> <br>

            <label for="semester">Semester:</label>
            <input type="hidden" id="semester" name="semester" value="First Semester">
            <span>First Semester</span> <br> <br>


            <label for="course_name">Courses</label>
            <select id="course_name" name="course_name" required>
                <option value="it">Information Technology</option>
                <option value="cs">Computer Science</option>
            </select> <br> <br>

            <h3 class="box7">Requirements</h3>
            <label for="requirement_file">Upload Requirement (Image)</label>
            <input type="file" id="requirement_file" name="requirement_file" accept="image/*" required> <br> <br> <br>

            <input type="submit" name="submit" value="Enroll">
        </form>
    </div>
</body>
</html>