<?php
require 'database.php';
$message = '';
$token = $_GET['token'] ?? '';

$conn = Database::connect();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token = ? AND token_expiry > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $update = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE id = ?");
        $update->execute([$new_password, $user['id']]);

        $message = "✅ Your password has been reset successfully.";
    } else {
        $message = "❌ Invalid or expired token.";
    }

    Database::disconnect(); // optional
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/attendance.css">
</head>
<body>
    <div class="container">
        <h3>Reset Password</h3>
        <form method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="password" name="password" required placeholder="Enter new password">
            <button type="submit">Reset Password</button>
        </form>
        <?php if (!empty($message)) echo "<div class='message'>$message</div>"; ?>
    </div>
</body>
</html>
