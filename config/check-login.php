<?php
session_start();

// Response array
$response = array('loggedIn' => false);

// Check if the user is logged in by checking session variable
if (isset($_SESSION['user_id'])) {
    $response['loggedIn'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
