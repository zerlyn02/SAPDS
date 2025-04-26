<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = 'localhost';
$dbName = 'sapds';
$username = 'root';
$password = '';

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the username is stored in the session after login
if (!isset($_SESSION['username'])) {
    die("Username not set in session.");
}

$user = $_SESSION['username'];

$sql = "
    SELECT u.name AS guardian_name, u.child_name, c.class 
    FROM users u
    LEFT JOIN children c ON u.child_name = c.name
    WHERE u.username = ?
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare statement failed: " . $conn->error);
}
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_assoc();

// If no data is found, set default values for child
if (!$data || !$data['child_name']) {
    $data = [
        'guardian_name' => 'Guardian Name Not Found',
        'child_name' => 'Child is not registered!',
        'class' => 'N/A',
    ];
}

$stmt->close();
$conn->close();

// Return data as JSON
echo json_encode($data);

?>
