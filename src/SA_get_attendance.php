<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'database.php';
$pdo = Database::connect();
date_default_timezone_set('Asia/Kuala_Lumpur');
$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');

// Handle manual attendance submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if there is any attendance to mark
    if (isset($_POST['mark_attendance'])) {
        foreach ($_POST['mark_attendance'] as $childId) {
            // Check if the child exists in the 'children' table
            $stmt = $pdo->prepare("SELECT name, class FROM children WHERE id = ?");
            $stmt->execute([$childId]);
            $child = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($child) {
                // Insert the attendance record (no need to check if the record exists, since duplicates are allowed now)
                $insert = $pdo->prepare("INSERT INTO attendance (id, name, class, location, date, time) VALUES (?, ?, ?, 'Main Gate', ?, ?)");
                if (!$insert->execute([$childId, $child['name'], $child['class'], $currentDate, $currentTime])) {
                    // If insertion fails, log the error
                    error_log("Failed to insert attendance for child ID: $childId");
                    echo "Error inserting attendance for child ID: $childId";
                    exit;
                }
            } else {
                // If child not found, log it
                error_log("Child with ID $childId not found in database.");
                echo "Child with ID $childId not found.";
                exit;
            }
        }
        // Success message after all attendance is updated
        echo "Manual attendance updated successfully!";
        exit;
    } else {
        echo "No attendance selected.";
        exit;
    }
}

// Fetch attendance: only first record per student per day
$sql = "
    SELECT a.id, a.name, a.class, a.date, a.time
    FROM attendance a
    INNER JOIN (
        SELECT id, date, MIN(time) as first_time
        FROM attendance
        GROUP BY id, date
    ) fa ON a.id = fa.id AND a.date = fa.date AND a.time = fa.first_time
    WHERE a.date = ?
    ORDER BY a.time ASC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$currentDate]);
$present = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get IDs of children already attended
$attendedIds = array_map('trim', array_column($present, 'id'));

$absentQuery = "SELECT id, name, class FROM children";
if (!empty($attendedIds)) {
    $placeholders = rtrim(str_repeat('?,', count($attendedIds)), ','); // Create "?,?,?" dynamically
    $absentQuery .= " WHERE id NOT IN ($placeholders)";
    $absentStmt = $pdo->prepare($absentQuery);
    $absentStmt->execute(array_values($attendedIds)); // Make sure it's indexed array
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
