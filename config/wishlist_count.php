<?php
session_start();
require 'conn.php'; // Include your database connection

if (isset($_SESSION['user_email'])) {
    $u = $_SESSION['user_email']; // Get user email from session
    
    // Query to get the count of wishlist items for the logged-in user
    $query = "SELECT COUNT(*) as count FROM wishlist WHERE user_email = '$u'";
    $stmt = $conn->prepare($query);
    // $stmt->bind_param('s', $userEmail);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $wishlistCount = $row['count']; // Get the count
    
    echo json_encode(['wishlistCount' => $wishlistCount]);
    
    $stmt->close();
} else {
    echo json_encode(['wishlistCount' => 0]); // No user logged in
}

$conn->close();
?>