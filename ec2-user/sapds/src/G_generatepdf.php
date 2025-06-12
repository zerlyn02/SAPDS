<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/sapds/src/lib/tcpdf/tcpdf.php');
require_once 'database.php';

$pdo = Database::connect();

$type = $_GET['type'] ?? '';
$date = $_GET['date'] ?? '';
$childName = $_GET['child_name'] ?? '';

if (empty($type) || empty($date) || empty($childName)) {
    die('Missing required parameters.');
}

// Create new PDF document
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Attendance System');
$pdf->SetTitle('Attendance Report');
$pdf->SetHeaderData('', 0, 'Attendance Report', '');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(15, 27, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();

// Table header
$html = '<h2>Attendance Report for ' . htmlspecialchars($childName) . '</h2>';
$html .= '<table border="1" cellpadding="5">
<tr>
<th>Date</th>
<th>Time</th>
<th>Status</th>
</tr>';

// Prepare SQL
$sql = "
    SELECT a.date, a.time
    FROM attendance a
    INNER JOIN users u ON a.name = u.child_name
    INNER JOIN (
        SELECT name, date, MIN(time) as first_time
        FROM attendance
        GROUP BY name, date
    ) first_attendance
    ON a.name = first_attendance.name 
    AND a.date = first_attendance.date 
    AND a.time = first_attendance.first_time
    WHERE a.name = :child_name
";

// Add filter
if ($type == 'daily') {
    $sql .= " AND a.date = :date";
} elseif ($type == 'monthly') {
    $sql .= " AND DATE_FORMAT(a.date, '%Y-%m') = :month";
} elseif ($type == 'yearly') {
    $sql .= " AND YEAR(a.date) = :year";
}

$sql .= " ORDER BY a.date ASC";

$stmt = $pdo->prepare($sql);

// Bind parameters
if ($type == 'daily') {
    $stmt->execute([':child_name' => $childName, ':date' => $date]);
} elseif ($type == 'monthly') {
    $month = substr($date, 0, 7); // yyyy-mm
    $stmt->execute([':child_name' => $childName, ':month' => $month]);
} elseif ($type == 'yearly') {
    $year = substr($date, 0, 4); // yyyy
    $stmt->execute([':child_name' => $childName, ':year' => $year]);
}

// Build the table
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $checkInTime = $row['time'];
    $status = 'Present';
    $statusColor = ''; // Default color for "Present"

    // Check if the student is late
    if (strtotime($checkInTime) > strtotime('08:30:00')) {
        $status = 'Present (Late)';
        $statusColor = 'style="color: red;"'; // Red color for "Late"
    }

    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($row['date']) . '</td>';
    $html .= '<td>' . htmlspecialchars($checkInTime) . '</td>';
    $html .= '<td ' . $statusColor . '>' . $status . '</td>';
    $html .= '</tr>';
}



// If no record found
if ($stmt->rowCount() == 0) {
    $html .= '<tr><td colspan="3">No attendance record found.</td></tr>';
}

$html .= '</table>';

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF
$pdf->Output('attendance_report.pdf', 'I');

Database::disconnect();
?>
