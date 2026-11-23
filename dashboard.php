<?php
require "db.php";

// 1. Totals for the stat cards
$totStudents    = $conn->query("SELECT COUNT(*) AS n FROM student")->fetch_assoc()["n"];
$totCourses     = $conn->query("SELECT COUNT(*) AS n FROM course")->fetch_assoc()["n"];
$totEnrollments = $conn->query("SELECT COUNT(*) AS n FROM enrollment")->fetch_assoc()["n"];

// 2. Enrollments per course (LEFT JOIN keeps courses with 0 enrollments)
$perCourse = $conn->query(
    "SELECT c.course_title, c.faculty_name, c.credits, COUNT(e.enroll_id) AS enrolled
     FROM course c
     LEFT JOIN enrollment e ON e.course_code = c.course_code
     GROUP BY c.course_code, c.course_title, c.faculty_name, c.credits
     ORDER BY c.course_title");

// 3. Latest 5 enrollments
$recent = $conn->query(
    "SELECT s.name, c.course_title, e.semester,
            DATE_FORMAT(e.enroll_date, '%d-%m-%Y') AS enroll_date
     FROM enrollment e
     JOIN student s ON e.student_id = s.student_id
     JOIN course  c ON e.course_code = c.course_code
     ORDER BY e.enroll_id DESC
     LIMIT 5");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Fonts + Tabler Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include "nav.php"; ?>

<div class="box wide">
    <h2>Dashboard</h2>

    <!-- Stat cards -->
    <div class="stats">
        <div class="stat"><i class="ti ti-users"></i>
            <div><div class="num"><?= htmlspecialchars($totStudents) ?></div><div class="label">Students</div></div></div>
        <div class="stat"><i class="ti ti-book"></i>
            <div><div class="num"><?= htmlspecialchars($totCourses) ?></div><div class="label">Courses</div></div></div>
        <div class="stat"><i class="ti ti-clipboard-check"></i>
            <div><div class="num"><?= htmlspecialchars($totEnrollments) ?></div><div class="label">Enrollments</div></div></div>
    </div>

    <!-- Enrollments per course -->
    <h3>Enrollments per Course</h3>
    <div class="table-wrap">
    <table>
        <tr><th>Course Title</th><th>Faculty</th><th>Credits</th><th>Students Enrolled</th></tr>
        <?php while ($r = $perCourse->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($r['course_title']) ?></td>
                <td><?= htmlspecialchars($r['faculty_name'] ?? '') ?></td>
                <td><?= htmlspecialchars($r['credits'] ?? '') ?></td>
                <td><?= htmlspecialchars($r['enrolled']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    </div>

    <!-- Recent enrollments -->
    <h3>Recent Enrollments</h3>
    <div class="table-wrap">
    <table>
        <tr><th>Student Name</th><th>Course Title</th><th>Semester</th><th>Enrollment Date</th></tr>
        <?php if ($recent->num_rows === 0): ?>
            <tr><td colspan="4" class="center">No enrollments yet</td></tr>
        <?php else: ?>
            <?php while ($r = $recent->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td><?= htmlspecialchars($r['course_title']) ?></td>
                    <td><?= htmlspecialchars($r['semester'] ?? '') ?></td>
                    <td><?= htmlspecialchars($r['enroll_date'] ?? '') ?></td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>
<?php $conn->close(); ?>
