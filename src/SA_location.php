<?php
require_once 'database.php';
header('Content-Type: application/json');

$pdo = Database::connect();

$childName = isset($_GET['child_name']) ? $_GET['child_name'] : null;

if ($childName) {
    $sql = "SELECT name, class, date, time, location 
            FROM attendance 
            WHERE name = :child_name 
            ORDER BY date DESC, time DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':child_name' => $childName]);
} else {
    $sql = "SELECT name, class, date, time, location 
            FROM attendance 
            ORDER BY date DESC, time DESC";
    $stmt = $pdo->query($sql);
}

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode(['success' => true, 'data' => $rows]);

Database::disconnect();
?>
