<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/database.php';

header('Content-Type: application/json');

if (!isset($_GET['teacher'])) {
    echo json_encode(['error' => 'Teacher not specified']);
    exit;
}

$teacher = $_GET['teacher'];

try {
    $pdo = Database::connect();
    $stmt = $pdo->prepare("SELECT class, day, timeslot, subject FROM timetable WHERE teacher = ?");
    $stmt->execute([$teacher]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
