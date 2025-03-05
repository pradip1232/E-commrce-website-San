<?php
// Start the session at the very beginning
session_start();

include('includes/header.php');
include('includes/sidebar.php');
include('includes/topbar.php');
include('config/con.php');
// include('includes/auth.php');







?>











<?php
// Check if the user is logged in
if (isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];

    // Fetch user details from the database
    $sql = "SELECT `name`, `gender`, `mobile`, `state`, `country`, `email`, `password`, `reg_date` FROM `users_data` WHERE `email` = '$user_email'";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // $stmt->bind_param("s", $user_email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            echo "<h2>No user found with the email: " . htmlspecialchars($user_email) . "</h2>";
            exit();
        }
    } else {
        echo "<h2>Database error: " . htmlspecialchars($conn->error) . "</h2>";
        exit();
    }
} else {
    echo "<h2>You are not logged in.</h2>";
    exit();
}
?>
<h1>hellooo</h1>







<?php
include('includes/footer.php');
?>