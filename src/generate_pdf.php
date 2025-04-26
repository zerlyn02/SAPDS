<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'database.php';
require_once($_SERVER['DOCUMENT_ROOT'] . '/sapds/src/lib/tcpdf/tcpdf.php');

$pdo = Database::connect();
date_default_timezone_set('Asia/Kuala_Lumpur');

$start = $_GET['startDate'] ?? '';
$end = $_GET['endDate'] ?? '';

if (!$start || !$end) {
    die("Start and End dates are required.");
}

// Get all classes
$classes = $pdo->query("SELECT DISTINCT class FROM children")->fetchAll(PDO::FETCH_COLUMN);

// Create PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SAPDS');
$pdf->SetTitle('Attendance Summary');
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

foreach ($classes as $index => $class) {   // ✨ notice $index added here
    // Get students in class
    $studentsStmt = $pdo->prepare("SELECT id, name FROM children WHERE class = ?");
    $studentsStmt->execute([$class]);
    $students = $studentsStmt->fetchAll(PDO::FETCH_KEY_PAIR); // id => name

    // Get attended students in class
    $attendedStmt = $pdo->prepare("SELECT DISTINCT id FROM attendance WHERE class = ? AND date BETWEEN ? AND ?");
    $attendedStmt->execute([$class, $start, $end]);
    $attendedIds = $attendedStmt->fetchAll(PDO::FETCH_COLUMN);

    $presentList = [];
    $absentList = [];

    foreach ($students as $id => $name) {
        if (in_array($id, $attendedIds)) {
            $presentList[] = $name;
        } else {
            $absentList[] = $name;
        }
    }

    // Build the HTML
    $html = "<h3>Class: " . htmlspecialchars($class) . "</h3>";
    $html .= "<strong>Date Range:</strong> " . htmlspecialchars($start) . " to " . htmlspecialchars($end);
    $html .= "<h4>Present:</h4><ul>";

    foreach ($presentList as $student) {
        $html .= "<li>" . htmlspecialchars($student) . "</li>";
    }
    $html .= "</ul>";

    $html .= "<h4>Absent:</h4><ul>";
    foreach ($absentList as $student) {
        $html .= "<li>" . htmlspecialchars($student) . "</li>";
    }
    $html .= "</ul><hr>";

    // Correct method
    $pdf->writeHTML($html, true, false, true, false, '');

    // 🌟 Add page break if it's not the last class
    if ($index !== array_key_last($classes)) {
        $pdf->AddPage();
    }
}

$pdf->Output('attendance_summary.pdf', 'I');
ob_end_flush();
?>
