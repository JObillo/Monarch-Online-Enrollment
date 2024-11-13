<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="student.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> <!-- Include jsPDF -->
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Monarch</h3>
        <ul>
            <li><a href="#" class="active" id="profile-link"><span class="las la-user"></span> Profile</a></li>
            <li><a href="#"><span class="las la-edit"></span> Registration</a></li>
            <li><a href="#" id="schedule-link"><span class="las la-calendar"></span> Schedule</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="profile-section">
        <!-- Profile Header -->
        <header>
            <div class="header-content">
                <h2>Student Profile</h2>
                <div class="logout">
                    <form action="student-logout.php" method="post">
                        <button type="submit" name="logout" class="logout-btn">
                            <span class="las la-power-off"></span> Logout </span>
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Profile and Form Section -->
        <div class="profile-container">
            <!-- Left Profile Information -->
            <div class="profile-info">
                <div class="profile-picture"></div>
                <h3>Student Name</h3>
                <p>Student@gmail.com</p>
                <p><strong>Course:</p>
                <p><strong>Section:</p>
                <p><strong>Semester:</p>
            </div>

            <!-- Right Personal Details Section (Static Text) -->
            <div class="details-form">
                <h2>Personal Details</h2>
                <label>Last Name:</label>
                <p class="static-info"></p>

                <label>First Name:</label>
                <p class="static-info"></p>

                <label>Middle Name:</label>
                <p class="static-info"></p>

                <h2>Other Information</h2>
                <label>Gender:</label>
                <p class="static-info"></p>

                <label>Birth Date:</label>
                <p class="static-info"></p>

                <label>Religion:</label>
                <p class="static-info"></p>

                <label>Civil Status:</label>
                <p class="static-info"></p>

                <label>Nationality:</label>
                <p class="static-info"></p>
            </div>
        </div>
    </div>

    <!-- Schedule Section -->
    <div id="schedule-section" style="display: none; text-align: center;">
        <header style="position: fixed; top: 0; width: 100%; background-color: #f5f5f5; padding: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);">
            <h2>Schedule</h2>
            <button onclick="downloadPDF()" class="download-btn" style="margin-top: 10px;">
                <span class="las la-download"></span> Download
            </button>
        </header>
        <div style="margin-top: 80px;"> <!-- Push content below header -->
            <div class="schedule-info">
                <p>Student No.:</p>
                <p>Student Name:</p>
                <p>Program/Year:</p>
                <p>Date Enrolled:</p>
                <p>Semester:</p>
                <p>Year:</p>
            </div>
            <table class="schedule-table" style="margin-left: 20px;">
                <thead>
                    <tr>
                        <th>Course Code</th>
                        <th>Description</th>
                        <th>Units</th>
                        <th>Time</th>
                        <th>Days</th>
                        <th>Room</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <!-- Add remaining rows as shown in your image -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Toggle schedule visibility when clicking "Schedule" in the sidebar
        document.getElementById('schedule-link').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('schedule-section').style.display = 'block';
            document.getElementById('profile-section').style.display = 'none';
        });

        // Toggle back to profile visibility when clicking "Profile" in the sidebar
        document.getElementById('profile-link').addEventListener('click', function(event) {
            event.preventDefault();
            document.getElementById('profile-section').style.display = 'block';
            document.getElementById('schedule-section').style.display = 'none';
        });

        // Function to download schedule as a PDF file
      // Function to download schedule as a PDF file
function downloadPDF() {
    // Make sure to access the jsPDF constructor correctly
    const jsPDF = window.jspdf.jsPDF;
    const doc = new jsPDF();

    doc.setFontSize(12);
    doc.text("Student No.:", 10, 10);
    doc.text("Student Name:", 10, 20);
    doc.text("Program/Year:", 10, 30);
    doc.text("Date Enrolled:", 10, 40);
    doc.text("Term:", 10, 50);
    doc.text("Year:", 10, 60);

    // Add table headers
    doc.text("Course Code | Description | Units | Time | Days | Room", 10, 80);

    // Add table data (simplified)
    const scheduleData = [
        [],
        [],
    ];

    let yPos = 90;
    scheduleData.forEach(row => {
        doc.text(row.join(" | "), 10, yPos);
        yPos += 10;
    });

    // Save the PDF with a filename
    doc.save("Student Profile.pdf");
}

        // Sidebar links
const sidebarLinks = document.querySelectorAll('.sidebar ul li a');

function setActiveLink(link) {
    sidebarLinks.forEach((sidebarLink) => {
        sidebarLink.classList.remove('active');
    });
    link.classList.add('active');
}

// Toggle sections and set active link
document.getElementById('schedule-link').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('schedule-section').style.display = 'block';
    document.getElementById('profile-section').style.display = 'none';
    setActiveLink(this);
});

document.getElementById('profile-link').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('profile-section').style.display = 'block';
    document.getElementById('schedule-section').style.display = 'none';
    setActiveLink(this);
});

    </script>
</body>
</html>
