<?php
header("Access-Control-Allow-Origin: *"); // Replace * with specific domain if needed (e.g., "https://example.com")
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

include "conn.php";

// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Debugging: Initial script start
// echo "<h3>Script Debugging Output</h3>";
// echo "Script Start<br>";

$response = [];

if (isset($_SERVER['REQUEST_METHOD'])) {
    // echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "<br>";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // echo "POST Request Detected<br>";

        // Debugging: Check if POST data is received
        // if (!empty($_POST)) {
        //     echo "POST Data Received:<br>";
        //     print_r($_POST);
        // } else {
        //     echo "No POST Data Received<br>";
        // }

        // Debugging: Check before data sanitization
        // echo "<br>Before Sanitization:<br>";
        // echo "Raw Data: ";
        // print_r($_POST);

       // Debugging: Check if POST variables are set and sanitize them
        $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
        // if (empty($name)) echo "Debug: 'name' is empty or not provided.<br>";
        
        $gender = isset($_POST['gender']) ? $conn->real_escape_string($_POST['gender']) : '';
        // if (empty($gender)) echo "Debug: 'gender' is empty or not provided.<br>";
        
        $mobile = isset($_POST['mobile']) ? $conn->real_escape_string($_POST['mobile']) : '';
        // if (empty($mobile)) echo "Debug: 'mobile' is empty or not provided.<br>";
        
        $state = isset($_POST['state']) ? $conn->real_escape_string($_POST['state']) : '';
        // if (empty($state)) echo "Debug: 'state' is empty or not provided.<br>";
        
        $country = isset($_POST['country']) ? $conn->real_escape_string($_POST['country']) : '';
        // if (empty($country)) echo "Debug: 'country' is empty or not provided.<br>";
        
        $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
        // if (empty($email)) echo "Debug: 'email' is empty or not provided.<br>";
        
        $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : '';
        // if (empty($password)) echo "Debug: 'password' is empty or not provided.<br>";
        
        // Debugging: Check sanitized variables
        // echo "Sanitized Data:<br>";
        // echo "Name: $name, Gender: $gender, Mobile: $mobile, State: $state, Country: $country, Email: $email<br>";


        // Debugging: After sanitization
        // echo "<br>Sanitized Data:<br>";
        // var_dump($name, $gender, $mobile, $state, $country, $email);

        // Check if email already exists
        // echo "<br>Checking Email Existence...<br>";
        $emailCheckQuery = $conn->prepare("SELECT 1 FROM user_data WHERE email = ?");
        $emailCheckQuery->bind_param("s", $email);
        $emailCheckQuery->execute();
        $emailCheckQuery->store_result();

        // Debugging: Email validation result
        // echo "Email Query Result (Rows Found): " . $emailCheckQuery->num_rows . "<br>";
        if ($emailCheckQuery->num_rows > 0) {
            $response[] = "The email address $email is already registered.";
        }
        $emailCheckQuery->close();

        // Check if mobile already exists
        // echo "<br>Checking Mobile Existence...<br>";
        $mobileCheckQuery = $conn->prepare("SELECT 1 FROM user_data WHERE mobile = ?");
        $mobileCheckQuery->bind_param("s", $mobile);
        $mobileCheckQuery->execute();
        $mobileCheckQuery->store_result();

        // Debugging: Mobile validation result
        // echo "Mobile Query Result (Rows Found): " . $mobileCheckQuery->num_rows . "<br>";
        if ($mobileCheckQuery->num_rows > 0) {
            $response[] = "The mobile number $mobile is already registered.";
        }
        $mobileCheckQuery->close();

        // Debugging: Check validation errors
        // echo "<br>Validation Errors:<br>";
        if (!empty($response)) {
            echo implode(" ", $response) . "<br>";
        } else {
            echo "No Validation Errors. Proceeding with Registration.<br>";
        }

        // Insert user data if no validation errors
        if (empty($response)) {
            // echo "<br>Preparing for Insertion...<br>";
            $current_time = date('Y-m-d H:i:s');

            $insertQuery = $conn->prepare("INSERT INTO user_data (name, gender, mobile, state, country, email, password, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $insertQuery->bind_param("ssssssss", $name, $gender, $mobile, $state, $country, $email, $password, $current_time);

            if ($insertQuery->execute()) {
                echo "Registration successful.<br>";
            } else {
                echo "Insertion Error: " . $insertQuery->error . "<br>";
            }
            $insertQuery->close();
        } else {
            // echo "<br>Validation Errors Encountered. Registration Aborted.<br>";
        }
    } else {
        echo "Request Method is not POST.<br>";
    }
} else {
    echo "Request Method Not Detected.<br>";
}

// Debugging: Script end
// echo "<br>Script End<br>";

// Close the connection
$conn->close();
?>
