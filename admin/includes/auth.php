<?php
// Start the session
session_start();

// echo "<pre>";
// print_r($_SESSION);
// var_dump($_SESSION['sub_admin_logged_in']);
// echo "</pre>";

if (!isset($_SESSION['sub_admin_logged_in']) || $_SESSION['sub_admin_logged_in'] !== true) {
    // echo "Redirecting to login page...";
    header("Location: login");

    exit;
}


// Optionally, check for specific access permissions
// Uncomment if required for additional validation
// if (!isset($_SESSION['edit_access']) || $_SESSION['edit_access'] !== 1) {
//     echo "You do not have edit access.";
//     exit;
// }
