<?php
// Database configuration
$host = 'localhost'; // Replace with your database host
$dbName = 'sapds'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

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
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Successful login
        echo "Login successful. Redirecting...";
        header("refresh:2;url=dashboard.html"); // Replace with your dashboard URL
    } else {
        // Invalid credentials
        echo "Invalid username or password.";
    }

    $stmt->close();
}

$conn->close();
?>
