<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="student.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>

<body class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar bg-dark text-white flex-shrink-0 d-flex flex-column align-items-center py-4">
        <h3 class="text-warning">Monarch</h3>
        <ul class="list-unstyled w-100 text-center">
            <li><a href="#" class="d-block py-2 text-decoration-none text-white active" id="profile-link"><span class="las la-user"></span> Profile</a></li>
            <li><a href="#" class="d-block py-2 text-decoration-none text-white" id="subjects-link"><span class="las la-book"></span> Subjects</a></li>
            <li><a href="#" class="d-block py-2 text-decoration-none text-white" id="schedule-link"><span class="las la-calendar"></span> Schedule</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-grow-1 px-4">
        <!-- Profile Section -->
        <div id="profile-section">
            <header class="d-flex justify-content-between align-items-center mb-4">
                <h2>Student Profile</h2>
                <div class="logout text-danger d-flex align-items-center">
                    <span class="las la-power-off"></span> Logout
                </div>
            </header>

            <div class="row">
                <!-- Profile Info -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="profile-info bg-white p-4 text-center shadow-sm rounded">
                        <div class="profile-picture mx-auto bg-secondary rounded-circle mb-3" style="width: 120px; height: 120px;"></div>
                        <h3>Student Name</h3>
                        <p>Student@gmail.com</p>
                        <p><strong>Course:</strong></p>
                        <p><strong>Section:</strong></p>
                        <p><strong>Semester:</strong></p>
                    </div>
                </div>

                <!-- Personal Details Form -->
                <div class="col-lg-8 col-md-6">
                    <div class="details-form bg-white p-4 shadow-sm rounded">
                        <h2 class="text-center mb-4">Personal Details</h2>
                        <div class="info-line mb-3 d-flex align-items-center">
                            <label class="font-weight-bold mr-3">Last Name:</label>
                            <span class="line flex-grow-1 border-bottom"></span>
                        </div>
                        <div class="info-line mb-3 d-flex align-items-center">
                            <label class="font-weight-bold mr-3">First Name:</label>
                            <span class="line flex-grow-1 border-bottom"></span>
                        </div>
                        <div class="info-line mb-3 d-flex align-items-center">
                            <label class="font-weight-bold mr-3">Middle Name:</label>
                            <span class="line flex-grow-1 border-bottom"></span>
                        </div>
                        <h2 class="text-center mt-4 mb-4">Other Information</h2>
                        <div class="info-line mb-3 d-flex align-items-center">
                            <label class="font-weight-bold mr-3">Gender:</label>
                            <span class="line flex-grow-1 border-bottom"></span>
                        </div>
                        <div class="info-line mb-3 d-flex align-items-center">
                            <label class="font-weight-bold mr-3">Birth Date:</label>
                            <span class="line flex-grow-1 border-bottom"></span>
                        </div>
                        <div class="info-line mb-3 d-flex align-items-center">
                            <label class="font-weight-bold mr-3">Religion:</label>
                            <span class="line flex-grow-1 border-bottom"></span>
                        </div>
                        <div class="info-line mb-3 d-flex align-items-center">
                            <label class="font-weight-bold mr-3">Civil Status:</label>
                            <span class="line flex-grow-1 border-bottom"></span>
                        </div>
                        <div class="info-line mb-3 d-flex align-items-center">
                            <label class="font-weight-bold mr-3">Nationality:</label>
                            <span class="line flex-grow-1 border-bottom"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other Sections -->
        <div id="subjects-section" class="d-none"></div>
        <div id="schedule-section" class="d-none"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="student.js"></script>
</body>

</html>
stackpath.bootstrapcdn.com