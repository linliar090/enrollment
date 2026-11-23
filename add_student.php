<?php
require "db.php";

$msg = "";
$type = "";
$student_id = $name = $programme = $email = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_id = trim($_POST["student_id"] ?? "");
    $name       = trim($_POST["name"] ?? "");
    $programme  = trim($_POST["programme"] ?? "");
    $email      = trim($_POST["email"] ?? "");

    if ($student_id === "" || $name === "") {
        $msg = "Student ID and Name are required!";
        $type = "error";
    } elseif ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Please enter a valid email address.";
        $type = "error";
    } else {
        try {
            $stmt = $conn->prepare(
                "INSERT INTO student (student_id, name, programme, email) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $student_id, $name, $programme, $email);
            $stmt->execute();
            $msg = "Student " . $name . " added successfully!";
            $type = "success";
            $student_id = $name = $programme = $email = "";   // clear the form
        } catch (mysqli_sql_exception $e) {
            // 1062 = duplicate primary key
            $msg = ($e->getCode() == 1062)
                 ? "Student ID already exists!"
                 : "Error: " . $e->getMessage();
            $type = "error";
        }
    }
}

// All students for the table below the form
$students = $conn->query("SELECT student_id, name, programme, email FROM student ORDER BY student_id");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Student - Course Enrollment System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include "nav.php"; ?>

<div class="box">
    <h2>Add Student</h2>

    <?php if ($msg !== ""): ?>
        <p class="<?= $type ?>"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="POST" action="add_student.php">
        <h3>Student Details</h3>
        <label>Student ID *</label>
        <input type="text" name="student_id" maxlength="10" value="<?= htmlspecialchars($student_id) ?>" required>
        <label>Name *</label>
        <input type="text" name="name" maxlength="100" value="<?= htmlspecialchars($name) ?>" required>
        <label>Programme</label>
        <input type="text" name="programme" maxlength="50" value="<?= htmlspecialchars($programme) ?>">
        <label>Email</label>
        <input type="email" name="email" maxlength="100" value="<?= htmlspecialchars($email) ?>">

        <button type="submit">Add Student</button>
    </form>

    <?php if ($type === "success"): ?>
        <a href="enroll.php">Enroll a student in a course</a>
    <?php endif; ?>
</div>
</body>
</html>
<?php $conn->close(); ?>