<?php
session_start();
require 'conn.php';

$data = json_decode(file_get_contents('php://input'), true);
print_r($data);
$key = $data['key'];
$updatedAddress = json_encode(array_slice($data, 1));

if (isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];

    $sql = "SELECT full_add FROM users_data WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $addresses = json_decode($result->fetch_assoc()['full_add'], true);
        $addresses[$key] = json_decode($updatedAddress, true);

        $updateSql = "UPDATE users_data SET full_add = ? WHERE email = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ss", json_encode($addresses), $user_email);

        if ($updateStmt->execute()) {
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
