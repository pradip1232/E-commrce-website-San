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

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Retrieve and sanitize input
    // $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    // $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Please provide both email and password."]);
        exit();
    }

    // Prepare the SQL query to find the user by email
    $stmt = $conn->prepare("SELECT id, password FROM user_data WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        // Bind both id and password
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        // Verify password using password_verify
        if (password_verify($password, $hashed_password)) {
            // Set session variables for authenticated user
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['loggedin'] = true;

            $redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : '/'; // Default page


            echo json_encode([
                "success" => true,
                "message" => "Login successful.",
                "email" => $email,

                "redirect_url" => $redirect_url,
            ]);
            exit();
        } else {
            // Invalid password
            echo json_encode(["success" => false, "message" => "Invalid password."]);
            exit();
        }
    } else {
        // No user found with the email
        echo json_encode(["success" => false, "message" => "No user found with this email."]);
        exit();
    }

    // Close the statement
    $stmt->close();
} else {
    // Invalid request method
    echo json_encode(["success" => false, "message" => "Invalid request method. Please use POST."]);
    exit();
}

// Close the database connection
$conn->close();
