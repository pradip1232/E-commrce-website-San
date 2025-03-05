<?php
session_start();

// Check if the 'auth' session variable is not set
if (!isset($_SESSION['auth'])) {
    $_SESSION["Status"] = "Please login to access the dashboard";
    header('Location: ../login');
    exit();
}
    