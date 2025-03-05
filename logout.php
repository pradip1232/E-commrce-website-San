<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Optionally, clear cookies associated with the session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, 
              $params["path"], $params["domain"], 
              $params["secure"], $params["httponly"]);
}

// Redirect to the login page or home page
header("Location: login"); // Change this to your desired redirect page
exit();
?>
