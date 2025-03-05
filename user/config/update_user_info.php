<?php
session_start();
include 'conn.php'; // Make sure to include your database connection file

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['user_email']; // Get the logged-in user's email
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];
    $state = $_POST['state'];
    $country = $_POST['country'];

    // Validate input
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Invalid email format';
        exit();
    }

    // Update SQL query
    $sql = "UPDATE `users_data` SET 
            `name` = '$name', 
            `gender` = '$gender', 
            `mobile` = '$mobile', 
            `state` = '$state', 
            `country` = '$country'
            WHERE `email` = '$email'";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        // $stmt->bind_param('ssssss', $name, $gender, $mobile, $state, $country, $email);

        // Execute the query
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }

        // Close statement
        $stmt->close();
    } else {
        echo 'error';
    }

    // Close connection
    $conn->close();
} else {
    echo 'Invalid request method';
}
?>
