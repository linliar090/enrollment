<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - Course Enrollment System</title>
    <!-- Google Fonts + Tabler Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include "nav.php"; ?>

<!-- Hero section -->
<section class="hero">
    <h1>Course Enrollment System</h1>
    <p>Enroll students in courses, track statistics at a glance and generate student-wise reports.</p>
</section>

<!-- Quick-link cards -->
<div class="cards">
    <a class="card" href="add_student.php">
    <span class="icon"><i class="ti ti-id-badge"></i></span>
    <h3>Add Student</h3>
    <p>Register a new student by entering their details.</p>
    </a>
    <a class="card" href="enroll.php">
        <span class="icon"><i class="ti ti-clipboard-check"></i></span>
        <h3>Enroll Student</h3>
        <p>Register a student for a course.</p>
    </a>
    <a class="card" href="dashboard.php">
        <span class="icon"><i class="ti ti-layout-dashboard"></i></span>
        <h3>Dashboard</h3>
        <p>Totals, enrollments per course and recent activity.</p>
    </a>
    <a class="card" href="report.php">
        <span class="icon"><i class="ti ti-file-text"></i></span>
        <h3>Student Report</h3>
        <p>View all courses a student is enrolled in.</p>
    </a>
</div>

<?php include "footer.php"; ?>
</body>
</html>
