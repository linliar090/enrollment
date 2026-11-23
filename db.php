<?php
// Database connection (shared by all pages)

// Make mysqli throw exceptions on errors
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$user = "root";
$pass = "";              // WAMP default: empty password
$db   = "enrollment_db";

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    die("Database connection failed: " . htmlspecialchars($e->getMessage()));
}
?>
