
<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include "conn.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$data = json_decode(file_get_contents('php://input'), true);

if (isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];

    // Prepare address data
    $addressData = [
        'line1' => $data['addressLine1'] ?? '',
        'line2' => $data['addressLine2'] ?? '',
        'landmark' => $data['landmark'] ?? '',
        'city' => $data['city'] ?? '',
        'state' => $data['state'] ?? '',
        'pinCode' => $data['pinCode'] ?? '',
        'country' => $data['country'] ?? ''
    ];

    $sql = "SELECT full_add FROM user_data WHERE email = '$user_email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if full_add is empty or invalid
        $existingAddresses = (!empty($row['full_add']) && is_string($row['full_add']))
            ? json_decode($row['full_add'], true)
            : [];

        // Ensure $existingAddresses is an array
        if (!is_array($existingAddresses)) {
            $existingAddresses = [];
        }

        // Generate new address key
        $addressKey = 'address' . (count($existingAddresses) + 1);
        $existingAddresses[$addressKey] = $addressData;

        $updatedAddresses = json_encode($existingAddresses, JSON_UNESCAPED_UNICODE);
        $updateSql = "UPDATE user_data SET full_add = ? WHERE email = ?";

        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ss", $updatedAddresses, $user_email);
        $success = $stmt->execute();
        $stmt->close();

        if ($success) {
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