<?php
require "db.php";

// All students for the dropdown
$students = $conn->query("SELECT student_id, name FROM student ORDER BY name");

// Selected student from the URL (?student_id=...)
$selected = trim($_GET["student_id"] ?? "");
$rows  = [];
$total = 0;

if ($selected !== "") {
    // JOIN enrollment + student + course for the chosen student (prepared statement)
    $stmt = $conn->prepare(
        "SELECT s.name, c.course_title, c.credits, e.semester,
                DATE_FORMAT(e.enroll_date, '%d-%m-%Y') AS enroll_date
         FROM enrollment e
         JOIN student s ON e.student_id = s.student_id
         JOIN course  c ON e.course_code = c.course_code
         WHERE e.student_id = ?
         ORDER BY e.enroll_date DESC");
    $stmt->bind_param("s", $selected);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($r = $result->fetch_assoc()) {
        $rows[] = $r;
        $total += (int)$r["credits"];   // running total of credits
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Report</title>
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
    <h2>Student Report</h2>

    <!-- Selecting a student submits the form automatically -->
    <form method="GET" action="report.php">
        <label>Select Student</label>
        <select name="student_id" onchange="this.form.submit()">
            <option value="">-- Select Student --</option>
            <?php while ($s = $students->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($s['student_id']) ?>"
                    <?= $s['student_id'] === $selected ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['student_id'] . " - " . $s['name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php if ($selected !== ""): ?>
    <div class="table-wrap">
    <table>
        <tr>
            <th>Student Name</th>
            <th>Course Title</th>
            <th>Credits</th>
            <th>Semester</th>
            <th>Enrollment Date</th>
        </tr>
        <?php if (count($rows) === 0): ?>
            <tr><td colspan="5" class="center">No enrollments for this student</td></tr>
        <?php else: ?>
            <?php foreach ($rows as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['name']) ?></td>
                <td><?= htmlspecialchars($r['course_title']) ?></td>
                <td><?= htmlspecialchars($r['credits'] ?? '') ?></td>
                <td><?= htmlspecialchars($r['semester'] ?? '') ?></td>
                <td><?= htmlspecialchars($r['enroll_date'] ?? '') ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <th colspan="2">Total Credits</th>
                <th colspan="3"><?= htmlspecialchars($total) ?></th>
            </tr>
        <?php endif; ?>
    </table>
    </div>
    <?php endif; ?>
</div>
<?php include "footer.php"; ?>
</body>
</html>
<?php $conn->close(); ?>
