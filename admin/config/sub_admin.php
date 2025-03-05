<?php

// session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include your database connection
include "conn.php";

header('Content-Type: application/json'); // Set response type as JSON


// Get POST data
$name = $_POST['subAdminName'];
$type = 'Sub Admin';
$userId = $_POST['userId'];
$password = $_POST['password'];
$state = $_POST['state'];
$editAccess = isset($_POST['editAccess']) ? 1 : 0;
$deleteAccess = isset($_POST['deleteAccess']) ? 1 : 0;
$uploadAccess = isset($_POST['uploadAccess']) ? 1 : 0;

// Validate required fields
if (empty($name) || empty($userId) || empty($password) || empty($state)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

// Insert sub-admin into database
$stmt = $conn->prepare("INSERT INTO sub_admins (name, type, user_id, password, state, edit_access, delete_access, upload_access) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die(json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]));
}

// Bind parameters
$stmt->bind_param("sssssiii", $name, $type, $userId, $password, $state, $editAccess, $deleteAccess, $uploadAccess);

// Execute statement
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Sub Admin created successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to create Sub Admin: ' . $stmt->error]);
}

// Close statement and connection
$stmt->close();
$conn->close();
