<?php
include 'conn.php'; // Include the database connection file

// Check if the request is a POST and contains the expected parameters
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the user ID from the incoming request (JSON payload)
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $data['user_id']; // The user ID passed for deletion

    // Validate the user ID
    if (empty($userId)) {
        echo json_encode(["status" => "error", "message" => "User ID is required"]);
        exit;
    }

    // Construct the SQL query to delete the sub-admin
    $sql = "DELETE FROM `sub_admins` WHERE `user_id` = '" . $conn->real_escape_string($userId) . "'";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Sub-Admin deleted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error deleting sub-admin: " . $conn->error]);
    }

    // Close the connection
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
