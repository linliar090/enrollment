<?php
require "db.php";

// Load students and courses for the dropdowns (no user input, so plain query is safe)
$students = $conn->query(
    "SELECT student_id, name, programme, email FROM student ORDER BY name");
$courses = $conn->query(
    "SELECT course_code, course_title, credits, faculty_name FROM course ORDER BY course_title");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Enroll Student</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Fonts + Tabler Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@400;500;600&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include "nav.php"; ?>

<div class="box">
    <h2>Enroll Student</h2>

    <form method="POST" action="save_enroll.php">
        <!-- Section 1: Student details -->
        <h3>Student Details</h3>
        <label>Student <span class="req">*</span></label>
        <select name="student_id" id="student" onchange="fillStudent()" required>
            <option value="">-- Select Student --</option>
            <?php while ($s = $students->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($s['student_id']) ?>"
                        data-name="<?= htmlspecialchars($s['name']) ?>"
                        data-programme="<?= htmlspecialchars($s['programme'] ?? '') ?>"
                        data-email="<?= htmlspecialchars($s['email'] ?? '') ?>">
                    <?= htmlspecialchars($s['student_id'] . " - " . $s['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <label>Name</label>
        <input type="text" id="name" readonly>
        <label>Programme</label>
        <input type="text" id="programme" readonly>
        <label>Email</label>
        <input type="text" id="email" readonly>

        <!-- Section 2: Course details (only the title is shown) -->
        <h3>Course Details</h3>
        <label>Course <span class="req">*</span></label>
        <select name="course_code" id="course" onchange="fillCourse()" required>
            <option value="">-- Select Course --</option>
            <?php while ($c = $courses->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($c['course_code']) ?>"
                        data-credits="<?= htmlspecialchars($c['credits'] ?? '') ?>"
                        data-faculty="<?= htmlspecialchars($c['faculty_name'] ?? '') ?>">
                    <?= htmlspecialchars($c['course_title']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <label>Credits</label>
        <input type="text" id="credits" readonly>
        <label>Faculty Name</label>
        <input type="text" id="faculty" readonly>

        <!-- Section 3: Enrollment details -->
        <h3>Enrollment Details</h3>
        <label>Semester <span class="req">*</span></label>
        <input type="text" name="semester" maxlength="10" placeholder="e.g. S1" required>
        <label>Enrollment Date <span class="req">*</span></label>
        <input type="date" name="enroll_date" required>

        <button type="submit"><i class="ti ti-circle-plus"></i> Enroll</button>
    </form>
</div>

<script>
// Copy the selected student's data-* values into the read-only boxes
function fillStudent() {
    const opt = document.getElementById("student").selectedOptions[0];
    document.getElementById("name").value      = opt.dataset.name || "";
    document.getElementById("programme").value = opt.dataset.programme || "";
    document.getElementById("email").value     = opt.dataset.email || "";
}

// Copy the selected course's data-* values into the read-only boxes
function fillCourse() {
    const opt = document.getElementById("course").selectedOptions[0];
    document.getElementById("credits").value = opt.dataset.credits || "";
    document.getElementById("faculty").value = opt.dataset.faculty || "";
}
</script>
<?php include "footer.php"; ?>
</body>
</html>
<?php $conn->close(); ?>
