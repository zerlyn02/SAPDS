<?php
require 'database.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $token = bin2hex(random_bytes(32));
    $expiry = date("Y-m-d H:i:s", time() + 3600);

    $stmt = $conn->prepare("UPDATE users SET reset_token=?, token_expiry=? WHERE email=?");
    $stmt->bind_param("sss", $token, $expiry, $email);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $reset_link = "http://18.143.66.54/sapds/src/reset_password.php?token=$token";
        $subject = "Reset Your Password";
        $message_body = "Click the link below to reset your password:\n\n$reset_link\n\nThis link expires in 1 hour.";

        // Update this to use PHPMailer if needed
        mail($email, $subject, $message_body, "From: no-reply@sapds.com");

        $message = "✅ Password reset link sent to your email.";
    } else {
        $message = "❌ Email not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/attendance.css">
</head>
<body>
    <div class="info">
    <div class="container">
        <h3>Forgot Password</h3>
        <form method="POST">
            <input type="email" name="email" required placeholder="Enter your email">
            <button type="submit">Send Reset Link</button>
        </form>
        <?php if (!empty($message)) echo "<div class='message'>$message</div>"; ?>
    </div>
    </div>
    
</body>
</html>
