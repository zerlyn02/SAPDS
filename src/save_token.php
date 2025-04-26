<?php
require_once 'database.php'; // Include the database class

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Check if the token and username are provided
if (isset($data['token']) && isset($data['username'])) {
    $fcm_token = $data['token'];
    $username = $data['username'];

    try {
        // Connect to the database
        $pdo = Database::connect();
        
        // Update token in the database
        $sql = "UPDATE users SET fcm_token = :fcm_token WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':fcm_token', $fcm_token, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        echo json_encode(["status" => "success", "message" => "Token saved."]);
        
        // Disconnect from the database
        Database::disconnect();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Token or Username not provided."]);
}
?>
