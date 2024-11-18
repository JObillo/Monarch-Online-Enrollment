// Toggle between sections and set active link styling
function setActiveLink(link) {
    document.querySelectorAll('.sidebar ul li a').forEach((sidebarLink) => {
        sidebarLink.classList.remove('active');
    });
    link.classList.add('active');
}

// Function to display subjects in a table
function loadSubjects() {
    const subjectsList = document.querySelector('#subjects-list tbody');
    subjectsList.innerHTML = ''; // Clear any existing content

    subjects.forEach(subject => {
        const subjectRow = document.createElement('tr');
        a
        subjectRow.innerHTML = `
            <td>${subject.code}</td>
            <td>${subject.name}</td>
            <td>${subject.professor}</td>
        `;

        subjectsList.appendChild(subjectRow);
    });
}

// Show Subjects Section
document.getElementById('subjects-link').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('subjects-section').style.display = 'block';
    document.getElementById('profile-section').style.display = 'none';
    document.getElementById('schedule-section').style.display = 'none';
    setActiveLink(this);

    // Load the subjects dynamically when the Subjects section is displayed
    loadSubjects();
});

// Show Subjects Section
document.getElementById('subjects-link').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('subjects-section').style.display = 'block';
    document.getElementById('profile-section').style.display = 'none';
    document.getElementById('schedule-section').style.display = 'none';
    setActiveLink(this);

    // Load the subjects dynamically when the Subjects section is displayed
    loadSubjects();
});


// Show Profile Section
document.getElementById('profile-link').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('profile-section').style.display = 'block';
    document.getElementById('subjects-section').style.display = 'none';
    document.getElementById('schedule-section').style.display = 'none';
    setActiveLink(this);
});

// Show Schedule Section
document.getElementById('schedule-link').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('schedule-section').style.display = 'block';
    document.getElementById('profile-section').style.display = 'none';
    document.getElementById('subjects-section').style.display = 'none';
    setActiveLink(this);
});

// Download Schedule as PDF
function downloadPDF() {
    const jsPDF = window.jspdf.jsPDF;
    const doc = new jsPDF();

    // Setting up the document title and header
    doc.setFontSize(16);
    doc.text("Student Schedule", 10, 10);

    // Capturing the student details from the schedule section
    const studentDetails = document.querySelector(".schedule-info");
    const scheduleTable = document.querySelector(".schedule-table");

    // Get the student information for the PDF
    const studentInfo = [
        "Student No.: " + document.querySelector(".schedule-info p:nth-child(1)").textContent,
        "Student Name: " + document.querySelector(".schedule-info p:nth-child(2)").textContent,
        "Program/Year: " + document.querySelector(".schedule-info p:nth-child(3)").textContent,
        "Date Enrolled: " + document.querySelector(".schedule-info p:nth-child(4)").textContent,
        "Semester: " + document.querySelector(".schedule-info p:nth-child(5)").textContent,
        "Year: " + document.querySelector(".schedule-info p:nth-child(6)").textContent,
    ];

    let yPosition = 20;
    // Add student details to PDF
    studentInfo.forEach(info => {
        doc.text(info, 10, yPosition);
        yPosition += 10; // Move down to next line
    });

    // Add table headers
    yPosition += 10;
    const tableHeaders = ["Course Code", "Description", "Units", "Time", "Days", "Room"];
    const tableWidth = [30, 50, 20, 30, 20, 30]; // Example column widths

    // Table Header
    doc.setFontSize(12);
    tableHeaders.forEach((header, index) => {
        doc.text(header, 10 + (tableWidth.slice(0, index).reduce((a, b) => a + b, 0)), yPosition);
    });

    // Get the schedule table rows
    const rows = scheduleTable.querySelectorAll("tbody tr");

    yPosition += 10; // Adjust y-position for table rows
    rows.forEach(row => {
        const columns = row.querySelectorAll("td");
        columns.forEach((column, index) => {
            doc.text(column.textContent, 10 + (tableWidth.slice(0, index).reduce((a, b) => a + b, 0)), yPosition);
        });
        yPosition += 10; // Move down for the next row
    });

    // Save the PDF
    doc.save("Student_Schedule.pdf");
}