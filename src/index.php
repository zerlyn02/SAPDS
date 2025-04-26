<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Database configuration
$host = 'localhost';
$dbName = 'sapds'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
// $port = '3306';


// Connect to the database
$conn = new mysqli($host, $username, $password, $dbName);

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
                    header("refresh:2;url=clerk/clerk_main.html"); // Redirect to clerk dashboard
                } else {
                    echo "Login successful. Redirecting to school administrator dashboard...";
                    header("refresh:2;url=SA_main.html"); // Redirect to school administrator dashboard
                }
            } elseif ($row['role'] == 'guardian') {
                echo "Login successful. Redirecting to guardian dashboard...";
                header("refresh:2;url=G_main.html"); // Redirect to guardian dashboard
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
