<?php
require "db.php";

$msg        = "";
$type       = "error";   // "success" or "error" (used as CSS class)
$student_id = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Read and trim form values
    $student_id  = trim($_POST["student_id"]  ?? "");
    $course_code = trim($_POST["course_code"] ?? "");
    $semester    = trim($_POST["semester"]    ?? "");
    $enroll_date = trim($_POST["enroll_date"] ?? "");

    // Server-side validation of required fields
    if ($student_id === "" || $course_code === "" || $semester === "" || $enroll_date === "") {
        $msg = "Please fill all required fields!";
    } else {
        try {
            // Insert only into the enrollment table (prepared statement)
            $stmt = $conn->prepare(
                "INSERT INTO enrollment (student_id, course_code, semester, enroll_date)
                 VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $student_id, $course_code, $semester, $enroll_date);
            $stmt->execute();

            $msg  = "Enrollment saved successfully! (Enroll ID: " . $stmt->insert_id . ")";
            $type = "success";
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $msg = "Error: " . $e->getMessage();
        }
    }
} else {
    $msg = "Invalid request. Please use the enrollment form.";
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Enrollment Status</title>
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
    <h2>Enrollment Status</h2>
    <!-- Status box: check icon for success, warning icon for error -->
    <div class="msg <?= $type ?>">
        <i class="ti <?= $type === "success" ? "ti-circle-check" : "ti-alert-triangle" ?>"></i>
        <span><?= htmlspecialchars($msg) ?></span>
    </div>

    <div class="links-row">
        <a class="btn btn-outline" href="enroll.php"><i class="ti ti-arrow-back-up"></i> Enroll Another</a>
        <?php if ($type === "success"): ?>
            <a class="btn" href="report.php?student_id=<?= urlencode($student_id) ?>"><i class="ti ti-file-text"></i> View This Student's Report</a>
        <?php endif; ?>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>
