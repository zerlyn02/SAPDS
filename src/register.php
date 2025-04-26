<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid input"]);
    exit;
}

$name = $data['name'];
$email = $data['email'];
$username = $data['username'];
$password = password_hash($data['password'], PASSWORD_BCRYPT); // Hash the password
$phone = $data['phone'];
$address = $data['address'];
$role = $data['role'];
$adminRole = $data['adminRole'] ?? null;
$childName = $data['childName'] ?? null;
$relationship = $data['relationship'] ?? null;
$carPlate = $data['carPlate'] ?? null;

// Debugging output
error_log("Data received: " . print_r($data, true));

// Database connection
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "sapds";

// Create connection
$conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbname);
// Check connection
if (!$conn) {
    error_log("Connection failed: " . mysqli_connect_error());
    die("Connection failed: " . mysqli_connect_error());
}

try {
    // Ensure adminRole is null if the role is guardian
    if ($role === 'guardian') {
        $adminRole = null;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (name, email, username, password, phone, address, role, admin_role, child_name, relationship, car_plate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }

    $stmt->bind_param("sssssssssss", $name, $email, $username, $password, $phone, $address, $role, $adminRole, $childName, $relationship, $carPlate);
    if (!$stmt->execute()) {
        throw new Exception("Execute statement failed: " . $stmt->error);
    }

    echo json_encode(["message" => "New record created successfully"]);

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["message" => "Database error: " . $e->getMessage()]);
}
?>
