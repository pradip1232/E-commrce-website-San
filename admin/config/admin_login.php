<?php
// Start session at the very beginning
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include your database connection
include "conn.php";

header('Content-Type: application/json'); // Set response type as JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and fetch inputs
    $user_id = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // SQL query to check sub-admin credentials
    $sql = "SELECT `id`, `name`,`type`, `user_id`, `password`, `state`, `edit_access`, `delete_access`, `upload_access`, `created_at`
            FROM `sub_admins` 
            WHERE `user_id` = '$user_id' AND `password` = '$password'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user details
        $row = $result->fetch_assoc();

        // Store user details in session
        $_SESSION['sub_admin_logged_in'] = true;
        $_SESSION['sub_admin_id'] = $row['user_id'];
        $_SESSION['sub_admin_name'] = $row['name'];
        $_SESSION['admin_type'] = $row['type'];
        $_SESSION['edit_access'] = $row['edit_access'];
        $_SESSION['delete_access'] = $row['delete_access'];
        $_SESSION['upload_access'] = $row['upload_access'];
        $_SESSION['sub_admin_state'] = $row['state'];
        $_SESSION['created_at'] = $row['created_at'];

        // Send all user details in JSON response
        echo json_encode([
            "status" => "success",
            "message" => "Admin login successful",
            "user_data" => $row // Send all user details
        ]);
    } else {
        // Invalid login response
        echo json_encode([
            "status" => "error",
            "message" => "Invalid User ID or Password"
        ]);
    }
} else {
    // Invalid request method response
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method"
    ]);
}

$conn->close();
