<?php
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['user_email'];
    $key = $_POST['key'];
    $updatedAddress = $_POST['address'];

    $sql = "SELECT `full_add` FROM `users_data` WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $addresses = json_decode($row['full_add'], true) ?? [];
        $addresses[$key] = $updatedAddress;

        $updatedJson = json_encode($addresses);
        $updateSql = "UPDATE `users_data` SET `full_add` = '$updatedJson' WHERE email = '$email'";
        if ($conn->query($updateSql)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update address.']);
        }
    }
}
?>
