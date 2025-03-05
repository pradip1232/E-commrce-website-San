<?php
include 'conn.php'; // Include the database connection file

// Check if the request is a POST and contains the expected action and parameters
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_sub_admin') {

    // Get the sub-admin details from the form
    $id = $_POST['user_id']; // Ensure 'user_id' is correctly passed from the frontend
    $name = $_POST['name'];
    $state = $_POST['state'];
    $editAccess = isset($_POST['editAccess']) ? 1 : 0;
    $deleteAccess = isset($_POST['deleteAccess']) ? 1 : 0;
    $uploadAccess = isset($_POST['uploadAccess']) ? 1 : 0;

    // Debugging: Echo the received data
    // echo "Received Data: user_id=$id, name=$name, state=$state, editAccess=$editAccess, deleteAccess=$deleteAccess, uploadAccess=$uploadAccess<br>";

    // Construct the SQL query with correct variables
    // Add quotes around $id to treat it as a string in the WHERE clause
    $sql = "UPDATE `sub_admins` SET `name` = '" . $conn->real_escape_string($name) . "', `state` = '" . $conn->real_escape_string($state) . "', edit_access = $editAccess, delete_access = $deleteAccess, upload_access = $uploadAccess WHERE user_id = '" . $conn->real_escape_string($id) . "'";

    // Debugging: Echo the SQL query
    // echo "SQL Query: " . $sql . "<br>";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Record updated successfully"]);
    } else {
        // Echo any errors for debugging
        echo "Error updating record: " . $conn->error . "<br>";
        echo json_encode(["status" => "error", "message" => "Error updating record: " . $conn->error]);
    }

    // Close the connection
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
