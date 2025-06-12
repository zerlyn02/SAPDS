<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'database.php';

// Function to send notifications
function notify($status, $location, $name) {
    require_once 'send_fcm.php';
    
    if ($status === "IN") {
        sendNotification("SAPDS- Student Entered", "$name has entered the $location.", $name);
    } elseif ($location !== "Main Gate" && $status === "OUT") {
        sendNotification("SAPDS- Student Left", "$name has left via the $location.", $name);
    } elseif ($location === "Main Gate" && $status === "OUT") {
        sendNotification("It's After School!", "$name is at the main gate waiting for your pick up!", $name);
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $location = $_POST['location'] ?? '';

    if (empty($id) || empty($location)) {
        echo "Missing UID or location";
        exit;
    }

    $pdo = Database::connect();

    // Fetch child information
    $stmt = $pdo->prepare("SELECT name, class FROM children WHERE id = ?");
    $stmt->execute([$id]);
    $child = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($child) {
        $name = $child['name'];
        $class = $child['class'];

        date_default_timezone_set('Asia/Kuala_Lumpur');
        $date = date("Y-m-d");
        $time = date("H:i:s");

        // Check if this child has entered or left today
        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM attendance WHERE id = ? AND location = ? AND date = ?");
        $countStmt->execute([$id, $location, $date]);
        $entryCount = $countStmt->fetchColumn();

        // Determine status based on entry count
        $status = ($entryCount % 2 == 0) ? 'IN' : 'OUT';

        // Insert attendance record
        $insert = $pdo->prepare("INSERT INTO attendance (id, name, class, date, time, location, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->execute([$id, $name, $class, $date, $time, $location, $status]);

        // Output status for debugging
        echo "Attendance logged as $status";
        echo " Location: $location, Status: $status";

        notify($status, $location, $name);
        // Check session and role
        /*if (isset($_SESSION['role'])) {
            $role = $_SESSION['role'];

            $shouldNotify = false;

            if ($role === "guardian" && isset($_SESSION['child_name'])) {
                $child_name = $_SESSION['child_name'];
                $shouldNotify = ($name === $child_name);
            } elseif ($role === "school-administrator") {
                $shouldNotify = true;
            }

            // Notify based on role
            if ($shouldNotify) {
                notify($status, $location, $name);
            }
        }*/
    } else {
        echo "UID not found in children table";
    }

    Database::disconnect();
} else {
    echo "Invalid request method";
}
?>
