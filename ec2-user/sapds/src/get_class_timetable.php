<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/database.php';

header('Content-Type: application/json');

if (!isset($_GET['class'])) {
    echo json_encode(['error' => 'Class not specified']);
    exit;
}

$class = $_GET['class'];

try {
    $pdo = Database::connect();
    $stmt = $pdo->prepare("SELECT class, day, timeslot, subject FROM timetable WHERE class = ?");
    $stmt->execute([$class]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($rows) > 0) {
        echo json_encode($rows);
    } else {
        echo json_encode(['error' => 'No timetable found for the selected class']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
