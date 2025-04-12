<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    $location = $_POST['location'] ?? '';

    if (empty($id) || empty($location)) {
        echo "Missing UID or location";
        exit;
    }

    $pdo = Database::connect();

    // Check if UID exists in children table
    $stmt = $pdo->prepare("SELECT name, class FROM children WHERE id = ?");
    $stmt->execute([$id]);
    $child = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($child) {
        $name = $child['name'];
        $class = $child['class'];

        // Prepare attendance data
        $date = date("Y-m-d");
        $time = date("H:i:s");

        // Insert attendance
        $insert = $pdo->prepare("INSERT INTO attendance (id, name, class, date, time, location) VALUES (?, ?, ?, ?, ?, ?)");
        $insert->execute([$id, $name, $class, $date, $time, $location]);

        echo "Attendance logged";
    } else {
        echo "UID not found in children table";
    }

    Database::disconnect();
} else {
    echo "Invalid request method";
}
?>
