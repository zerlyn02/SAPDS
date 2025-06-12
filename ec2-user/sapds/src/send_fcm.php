<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once 'database.php'; // Make sure this path is correct

use Google\Auth\OAuth2;
use GuzzleHttp\Client;

function sendNotification($title, $body, $childName) {
    $conn = Database::connect();

    // Get tokens for both specific child AND all users with child_name IS NULL (i.e., teachers)
    $stmt = $conn->prepare("SELECT noti_token FROM users WHERE child_name = :childName OR child_name IS NULL");
    $stmt->execute(['childName' => $childName]);
    $tokens = $stmt->fetchAll(PDO::FETCH_COLUMN); // Get just the noti_token values as array

    if (empty($tokens)) {
        return; // No tokens found
    }

    $serviceAccountFile = 'firebase.json'; // Ensure this path is correct
    $creds = json_decode(file_get_contents($serviceAccountFile));

    $oauth = new OAuth2([
        'audience' => 'https://oauth2.googleapis.com/token',
        'issuer' => $creds->client_email,
        'signingAlgorithm' => 'RS256',
        'signingKey' => $creds->private_key,
        'tokenCredentialUri' => 'https://oauth2.googleapis.com/token',
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
    ]);

    $token = $oauth->fetchAuthToken();
    $accessToken = $token['access_token'];
    $projectId = $creds->project_id;

    $client = new Client();

    // Send notification to each token (student + all teachers)
    foreach ($tokens as $deviceToken) {
        if (empty($deviceToken)) {
            continue; // Skip empty/null tokens
        }
        $response = $client->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'message' => [
                    'token' => $deviceToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                    'android' => [
                        'priority' => 'high',
                    ],
                ],
            ],
        ]);

        echo $response->getBody(); // Optional: remove this if sending to many tokens
    }
}

