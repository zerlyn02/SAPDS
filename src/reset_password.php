<?php
require 'database.php';
$message = '';
$token = $_GET['token'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("SELECT id FROM users WHERE reset_token=? AND token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id);
        $stmt->fetch();

        $update = $conn->prepare("UPDATE users SET password=?, reset_token=NULL, token_expiry=NULL WHERE id=?");
        $update->bind_param("si", $new_password, $user_id);
        $update->execute();

        $message = "✅ Your password has been reset successfully.";
    } else {
        $message = "❌ Invalid or expired token.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
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
