<?php
require_once 'database.php';

header('Content-Type: application/json');

$pdo = Database::connect();

$childName = isset($_GET['child_name']) ? $_GET['child_name'] : null;

if ($childName) {
    // Join users and attendance based on matching names
    $sql = "SELECT a.name, a.location, a.date, a.time, a.status
            FROM attendance a
            INNER JOIN users u ON a.name = u.child_name
            WHERE u.child_name = :child_name
            ORDER BY a.date DESC, a.time DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':child_name' => $childName]);

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'data' => $rows]);
} else {
    echo json_encode(['success' => false, 'message' => 'Child name not provided']);
}

Database::disconnect();
?>
