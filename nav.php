<?php
// Top navigation bar - included on every page
$current = basename($_SERVER["PHP_SELF"]);   // current file name, e.g. "enroll.php"

// Link list: file => label
$links = [
    "index.php"     => "Home",
    "enroll.php"    => "Enroll Student",
    "dashboard.php" => "Dashboard",
    "report.php"    => "Student Report",
];

// save_enroll.php belongs to the Enroll Student section
if ($current === "save_enroll.php") {
    $current = "enroll.php";
}
?>
<nav class="navbar">
    <div class="brand">Course Enrollment System</div>
    <div class="links">
        <?php foreach ($links as $file => $label): ?>
            <a href="<?= htmlspecialchars($file) ?>"
               class="<?= $file === $current ? 'active' : '' ?>">
                <?= htmlspecialchars($label) ?>
            </a>
        <?php endforeach; ?>
    </div>
</nav>
