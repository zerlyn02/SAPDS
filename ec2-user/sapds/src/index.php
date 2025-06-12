<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "Login.php reached<br>";
print_r($_POST);


session_start();

// Database configuration
$host = 'sapds.c7y6kwyygqfb.ap-southeast-1.rds.amazonaws.com';
$dbName = 'sapds'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = 'zerlynfyp'; // Replace with your database password
$port = '3306';


// Connect to the database
$conn = new mysqli($host, $username, $password, $dbName, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Check for empty fields
    if (empty($user) || empty($pass)) {
        echo "Please fill in all fields.";
        exit;
    }

    // Query to check user credentials
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($pass, $row['password'])) {
            // Successful login
            $_SESSION['username'] = $user; // Store username in session
            if ($row['role'] == 'school-administrator') {
                if ($row['admin_role'] == 'clerk') {
                    echo "Login successful. Redirecting to clerk dashboard...";
                    $noti_token = 'd4w5nkaNQ3a3HBBNcHd11q:APA91bGxhVYxfQ0uFXvqhf355-NFiYa-nBkaTniaDj7ZbKxEm6uCct6fnPC0JqX8T9hI7-6R-RZ17uSTUs1wvsfMT85XwuoC89yGOzjVpC4VerDLvUlVc4w';

                    // Update the user's noti_token in the database
                    $update_sql = "UPDATE users SET noti_token = ? WHERE username = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    if ($update_stmt) {
                        $update_stmt->bind_param("ss", $noti_token, $user);
                        $update_stmt->execute();
                        $update_stmt->close();
                    } else {
                        echo "Failed to prepare update statement: " . $conn->error;
                    }
                    header("Location: clerk/clerk_main.html"); // Redirect to clerk dashboard
                    exit;
                } else {
                    echo "Login successful. Redirecting to school administrator dashboard...";
                    $noti_token = 'd4w5nkaNQ3a3HBBNcHd11q:APA91bGxhVYxfQ0uFXvqhf355-NFiYa-nBkaTniaDj7ZbKxEm6uCct6fnPC0JqX8T9hI7-6R-RZ17uSTUs1wvsfMT85XwuoC89yGOzjVpC4VerDLvUlVc4w';

                    // Update the user's noti_token in the database
                    $update_sql = "UPDATE users SET noti_token = ? WHERE username = ?";
                    $update_stmt = $conn->prepare($update_sql);
                    if ($update_stmt) {
                        $update_stmt->bind_param("ss", $noti_token, $user);
                        $update_stmt->execute();
                        $update_stmt->close();
                    } else {
                        echo "Failed to prepare update statement: " . $conn->error;
                    }
                    header("Location: SA_main.html");
                    exit;
                }
            } elseif ($row['role'] == 'guardian') {
                echo "Login successful. Redirecting to guardian dashboard...";
                $noti_token = 'd4w5nkaNQ3a3HBBNcHd11q:APA91bGxhVYxfQ0uFXvqhf355-NFiYa-nBkaTniaDj7ZbKxEm6uCct6fnPC0JqX8T9hI7-6R-RZ17uSTUs1wvsfMT85XwuoC89yGOzjVpC4VerDLvUlVc4w';

                // Update the user's noti_token in the database
                $update_sql = "UPDATE users SET noti_token = ? WHERE username = ?";
                $update_stmt = $conn->prepare($update_sql);
                if ($update_stmt) {
                    $update_stmt->bind_param("ss", $noti_token, $user);
                    $update_stmt->execute();
                    $update_stmt->close();
                } else {
                    echo "Failed to prepare update statement: " . $conn->error;
                }
                header("Location: G_main.html"); // Redirect to guardian dashboard
                exit;
            } else {
                echo "Invalid role.";
            }
        } else {
            // Invalid credentials
            echo "Invalid username or password.";
        }
    } else {
        // Invalid credentials
        echo "Invalid username or password.";
    }

    $stmt->close();
}

$conn->close();
?>
