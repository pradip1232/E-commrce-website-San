<?php
session_start();

// Response array
$response = array('success' => false);

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];
$password = $data['password'];

// Database connection
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "your_database_name";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check user credentials
$sql = "SELECT id FROM users WHERE username = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Login successful
    $response['success'] = true;
    $stmt->bind_result($user_id);
    $stmt->fetch();
    
    // Set session variables
    $_SESSION['user_id'] = $user_id;
} else {
    // Login failed
    $response['success'] = false;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
