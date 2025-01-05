<?php
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

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SAPDS";

// Create connection
// $conn = mysqli_connect($servername, $username, $password, $dbname);
// // Check connection
// if (!$conn) {
//   die("Connection failed: " . mysqli_connect_error());
// }

try {
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $stmt = $pdo->prepare("INSERT INTO Users 
        (name, email, username, password, phone, address, role, admin_role, child_name, relationship, car_plate) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$name, $email, $username, $password, $phone, $address, $role, $adminRole, $childName, $relationship, $carPlate]);

    echo json_encode(["message" => "Registration successful"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["message" => "Database error: " . $e->getMessage()]);
}
?>
