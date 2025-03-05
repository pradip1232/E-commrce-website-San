<?php
session_start(); // Start the session if not already started

// Clear all session variables
$_SESSION = [];

// Destroy the session
session_unset();
session_destroy();

// Send a 200 response for successful logout
http_response_code(200);
exit;
