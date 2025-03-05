<?php
// header("Content-Type: application/json");
// require_once("conn.php");


// SQL query to fetch all data from the table
$sql = "SELECT * FROM user_purchases";  
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    // echo json_encode(["status" => "success", "data" => $data]);
} else {
    echo json_encode(["status" => "error", "message" => "No records found"]);
}

// Close the database connection
$conn->close();
