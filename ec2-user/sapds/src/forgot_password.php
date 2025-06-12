<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'database.php';
require '../vendor/autoload.php'; // Include PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Connect to the database
    $conn = Database::connect();

    // Generate the token and expiry time
    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", time() + 3600);

    // Prepare the SQL query using PDO
    $query = "UPDATE users SET reset_token = :token, token_expiry = :expiry WHERE email = :email";
    $stmt = $conn->prepare($query);
    
    // Bind the parameters
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':expiry', $expiry);
    $stmt->bindParam(':email', $email);

    // Execute the statement
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->rowCount() > 0) {
        $reset_link = "http://18.141.9.202/sapds/src/reset_password.php?token=$token";
        $subject = "Reset Your Password";
        $message_body = "Click the link below to reset your password:\n\n$reset_link\n\nThis link expires in 1 hour.";

        // Send the email using PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Example SMTP server (Gmail)
            $mail->SMTPAuth = true;
            $mail->Username = 'zerlyn0816@gmail.com'; // Your email
            $mail->Password = 'thge uzlj ngwk exik'; // Your email password or App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; // SMTP port for Gmail

            // Recipients
            $mail->setFrom('zerlyn0816@gmail.com', 'SAPDS');
            $mail->addAddress($email); // Send to the user's email

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = "Click the link below to reset your password:<br><br><a href=\"$reset_link\">$reset_link</a><br><br>This link expires in 1 hour.";

            // Send email
            $mail->send();

            $message = "✅ Password reset link sent to your email.";
        } catch (Exception $e) {
            $message = "❌ Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $message = "❌ Email not found.";
    }

    // Disconnect from the database
    Database::disconnect();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/attendance.css">
    <style>
            .back-button {
            display: block;
            margin-top: 20px;
            text-align: left;
            color: #435c47;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            border: 2px solid #3b4f3e;
            border-radius: 5px;
            padding: 10px 20px;
            width: 60px;
        }

        .back-button:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="info">
    <div class="container">
    <a href="index.html" class="back-button">&larr; Back</a>
        <h3>Forgot Password</h3>
        <form method="POST">
            <input type="email" name="email" required placeholder="Enter your email">
            <button type="submit">Send Reset Link</button>
        </form>
        <?php if (!empty($message)) echo "<div class='message " . (strpos($message, "❌") !== false ? 'error' : 'success') . "'>$message</div>"; ?>
    </div>
    </div>
</body>
</html>
