<?php
require_once 'database.php';

$pdo = Database::connect();

$startDate = $_GET['start_date'] ?? null;
$endDate = $_GET['end_date'] ?? null;
$child_name = $_GET['child_name'] ?? '';

$sql = "
    SELECT a.name, a.class, a.date, a.time
    FROM attendance a
    INNER JOIN users u ON a.name = u.child_name
    INNER JOIN (
        SELECT name, date, MIN(time) as first_time
        FROM attendance
        WHERE name = :child_name
        GROUP BY name, date
    ) first_attendance
    ON a.name = first_attendance.name 
    AND a.date = first_attendance.date 
    AND a.time = first_attendance.first_time
    WHERE a.name = :child_name
";


$params = [':child_name' => $child_name];

if ($startDate) {
    $sql .= " AND a.date >= :start_date";
    $params[':start_date'] = $startDate;
}
if ($endDate) {
    $sql .= " AND a.date <= :end_date";
    $params[':end_date'] = $endDate;
}

$sql .= " ORDER BY a.date DESC, a.time ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo "<table border='1'>";
echo "<tr><th>Name</th><th>Class</th><th>Date</th><th>Time</th></tr>";

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
    echo "<td>" . htmlspecialchars($row['class']) . "</td>";
    echo "<td>" . htmlspecialchars($row['date']) . "</td>";
    echo "<td>" . htmlspecialchars(substr($row['time'], 0, 8)) . "</td>";
    echo "</tr>";
}

echo "</table>";

Database::disconnect();
?>
