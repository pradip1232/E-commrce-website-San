<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";
// $servername = "localhost";
// $username = "djfounda_sanjiveeka_data";
// $password = "sanjiveeka_data@123";  
// $dbname = "djfounda_sanjiveeka_Newdata";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection and handle errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

    // echo "Connected successfully";
}
