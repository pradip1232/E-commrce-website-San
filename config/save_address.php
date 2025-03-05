<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Include database connection
include "conn.php";

// Enable error reporting for debugging (you can disable it later)
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$data = json_decode(file_get_contents('php://input'), true);


// print_r($data);

// // Check if the user is logged in
if (isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];

    // Prepare address data
    $addressData = [
        'line1' => $data['addressLine1'],
        'line2' => $data['addressLine2'],
        'landmark' => $data['landmark'],
        'city' => $data['city'],
        'state' => $data['state'],
        'pinCode' => $data['pinCode'],
        'country' => $data['country']
    ];
    

    $sql = "SELECT full_add FROM user_data WHERE email = '$user_email'"; 

    $result = $conn->query($sql);

    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $existingAddresses = json_decode($row['full_add'], true);
    
        $addressKey = 'address' . (count($existingAddresses) + 1);
        $existingAddresses[$addressKey] = $addressData;
    
        $updatedAddresses = json_encode($existingAddresses);
        $updateSql = "UPDATE user_data SET full_add = '$updatedAddresses' WHERE email = '$user_email'";
        
        $updateStmt = $conn->query($updateSql);
        
        if ($updateStmt) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update address.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
}
?>