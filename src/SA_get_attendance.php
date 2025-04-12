<?php
require_once 'database.php';
$pdo = Database::connect();
date_default_timezone_set('Asia/Kuala_Lumpur');
$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');

// Handle manual attendance submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['mark_attendance'] ?? [] as $childId) {
        $stmt = $pdo->prepare("SELECT name, class FROM children WHERE id = ?");
        $stmt->execute([$childId]);
        $child = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($child) {
            $insert = $pdo->prepare("INSERT INTO attendance (id, name, class, location, date, time) VALUES (?, ?, ?, 'Main Gate', ?, ?)");
            $insert->execute([$childId, $child['name'], $child['class'], $currentDate, $currentTime]);
        }
    }
    exit;
}

// Fetch attendance: only first record per student per day
$sql = "
    SELECT a.name, a.class, a.date, a.time
    FROM attendance a
    INNER JOIN (
        SELECT name, date, MIN(time) as first_time
        FROM attendance
        GROUP BY name, date
    ) fa ON a.name = fa.name AND a.date = fa.date AND a.time = fa.first_time
    WHERE a.date = ?
    ORDER BY a.time ASC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$currentDate]);
$present = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get names of children already attended
$attendedNames = array_column($present, 'name');

// Fetch absent children
$placeholders = implode(',', array_fill(0, count($attendedNames), '?'));
$absentQuery = "SELECT id, name, class FROM children";
if ($attendedNames) {
    $absentQuery .= " WHERE name NOT IN ($placeholders)";
    $absentStmt = $pdo->prepare($absentQuery);
    $absentStmt->execute($attendedNames);
} else {
    $absentStmt = $pdo->query($absentQuery);
}
$absent = $absentStmt->fetchAll(PDO::FETCH_ASSOC);

// Output HTML
?>

<div id="present-table">
    <table border="1">
        <tr><th>Name</th><th>Class</th><th>Date</th><th>Time</th></tr>
        <?php foreach ($present as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['class']) ?></td>
            <td><?= htmlspecialchars($row['date']) ?></td>
            <td><?= htmlspecialchars(substr($row['time'], 0, 8)) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<div id="absent-list">
    <?php if ($absent): ?>
    <p>Select to mark as attended:</p>
    <table border="1">
    <tr><th>Name</th><th>Class</th><th>Attendance</th></tr>
    <?php foreach ($absent as $child): ?>
        <tr>
            <td><?= htmlspecialchars($child['name']) ?></td>
            <td><?= htmlspecialchars($child['class']) ?></td>
            <td><input type="checkbox" name="mark_attendance[]" value="<?= $child['id'] ?>"></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>All children are present today.</p>
    <?php endif; ?>
</div>

<?php Database::disconnect(); ?>
