<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include the database connection class
require_once 'database.php'; 

// Get the PDO connection
$conn = Database::connect();

$data = json_decode(file_get_contents("php://input"));
$name = $data->name ?? '';

if (!$name) {
    // Return an error message in JSON format
    echo json_encode(['message' => 'Invalid name.']);
    exit;
}

// Use prepared statement to prevent SQL injection
$sql = "UPDATE users SET noti_token = NULL WHERE name = :name";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':name', $name, PDO::PARAM_STR);

$response = [];

try {
    if ($stmt->execute()) {
        // Success response
        $response = ['message' => 'Logout successful. Token cleared.'];
    } else {
        // Error response
        $response = ['message' => 'Error updating record.'];
    }
} catch (PDOException $e) {
    // Handle the exception
    $response = ['message' => 'Error: ' . $e->getMessage()];
}

// Return the response as JSON
echo json_encode($response);

// Disconnect the database
Database::disconnect();
?>
