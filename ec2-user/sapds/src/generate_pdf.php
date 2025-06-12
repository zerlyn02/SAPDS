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

$startDate = new DateTime($start);
$endDate = new DateTime($end);

// Get all classes
$classes = $pdo->query("SELECT DISTINCT class FROM children")->fetchAll(PDO::FETCH_COLUMN);

// Create PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SAPDS');
$pdf->SetTitle('Attendance Report');
$pdf->SetHeaderData('', 0, 'Attendance Report', '');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->SetFont('dejavusans', '', 10);

// Loop through each date
for ($date = clone $startDate; $date <= $endDate; $date->modify('+1 day')) {
    $dateStr = $date->format('Y-m-d');

    foreach ($classes as $class) {
        // Fetch all students in class (sorted by name ASC)
        $studentsStmt = $pdo->prepare("SELECT id, name FROM children WHERE class = ? ORDER BY name ASC");
        $studentsStmt->execute([$class]);
        $students = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Skip if no students
        if (empty($students)) continue;

        // Fetch attendance records for the class on this date
        $attendedStmt = $pdo->prepare("
            SELECT id, MIN(time) as first_time 
            FROM attendance 
            WHERE class = ? AND date = ? 
            GROUP BY id
        ");
        $attendedStmt->execute([$class, $dateStr]);
        $attendanceRecords = $attendedStmt->fetchAll(PDO::FETCH_KEY_PAIR); // id => time

        // Build HTML content
        $html = '<h3>Class: ' . htmlspecialchars($class) . '</h3>';
        $html .= '<strong>Date:</strong> ' . htmlspecialchars($dateStr);
        $html .= '<br><br>';
        $html .= '<table border="1" cellpadding="5">
                    <tr>
                        <th>Name</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>';

        foreach ($students as $student) {
            $id = $student['id'];
            $name = htmlspecialchars($student['name']);

            if (isset($attendanceRecords[$id])) {
                $time = $attendanceRecords[$id];
                $status = (strtotime($time) > strtotime('08:30:00')) ? 'Present (Late)' : 'Present';
                $timeDisplay = htmlspecialchars($time);
                $statusStyle = (strpos($status, 'Late') !== false) ? 'style="color:red;"' : '';
            } else {
                $timeDisplay = '-';
                $status = 'Absent';
                $statusStyle = 'style="color:gray;"';
            }

            $html .= '<tr>
                        <td>' . $name . '</td>
                        <td>' . $timeDisplay . '</td>
                        <td ' . $statusStyle . '>' . $status . '</td>
                    </tr>';
        }

        $html .= '</table>';

        // Add new page and write HTML
        $pdf->AddPage();
        $pdf->writeHTML($html, true, false, true, false, '');
    }
}

$pdf->Output('attendance_summary.pdf', 'I');
ob_end_flush();
