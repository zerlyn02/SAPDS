<?php
require_once 'database.php'; // Include the database class

// Firebase Server Key (from Firebase > Project Settings > Cloud Messaging)
$serverKey = 'YOUR_SERVER_KEY';

// Get the parent’s username (e.g., from a location update or another logic)
$username = 'username'; // Replace with logic to fetch dynamically based on child location update

try {
    // Connect to the database
    $pdo = Database::connect();

    // Fetch the FCM token for the parent
    $sql = "SELECT fcm_token FROM users WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the parent has an FCM token
    if ($row) {
        $fcmToken = $row['fcm_token'];

        // Notification content
        $notification = [
            'title' => 'Location Update',
            'body' => 'Your child\'s location has just been updated.',
            'icon' => 'img/logo.png'  // optional
        ];

        // Payload
        $data = [
            'to' => $fcmToken,
            'notification' => $notification
        ];

        // Send notification via curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        curl_close($ch);

        // Return response
        echo $response;
    } else {
        echo json_encode(["status" => "error", "message" => "No FCM token found for this parent."]);
    }

    // Disconnect from the database
    Database::disconnect();

} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
